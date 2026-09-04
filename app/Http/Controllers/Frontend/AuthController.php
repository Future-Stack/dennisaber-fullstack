<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AccessRequest;
use App\Models\AuditLog;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function loginPage()
    {
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('member.dashboard');
        }

        return view('frontend.pages.auth.login');
    }

    public function loginStore(Request $request)
    {
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
            'slug' => ['nullable', 'string', 'max:150'],
            // 'device_id' => ['required', 'string', 'max:255'],
            // 'device_name' => ['nullable', 'string', 'max:255'],
        ]);

        $login = $request->login;

        // Lookup by username or email
        $user = User::where(function ($query) use ($login) {
            $query->where('username', $login)
                ->orWhere('email', $login);
        })->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            if ($user) {
                AuditLog::create([
                    'user_id' => $user->id,
                    'event' => 'LOGIN_FAILED_CREDENTIALS',
                    'detail' => "Fehlgeschlagener Anmeldeversuch für Benutzer '{$login}' (falsches Passwort).",
                    'ip' => $request->ip(),
                ]);
            } else {
                AuditLog::create([
                    'user_id' => null,
                    'event' => 'LOGIN_FAILED_UNKNOWN_USER',
                    'detail' => "Anmeldeversuch mit unbekanntem Benutzernamen '{$login}'.",
                    'ip' => $request->ip(),
                ]);
            }

            throw ValidationException::withMessages([
                'login' => __('Ungültiger Benutzername bzw. E-Mail-Adresse oder falsches Passwort.'),
            ]);
        }

        if (! $user->is_active) {
            AuditLog::create([
                'user_id' => $user->id,
                'event' => 'LOGIN_FAILED_INACTIVE',
                'detail' => "Anmeldeversuch auf deaktiviertem oder abgelaufenem Kundenkonto '{$user->username}'.",
                'ip' => $request->ip(),
            ]);

            throw ValidationException::withMessages([
                'login' => __('Dieses Kundenkonto ist derzeit nicht aktiv oder abgelaufen. Bitte wenden Sie sich an den Support.'),
            ]);
        }

        // If staff, check date validity
        if ($user->isStaff()) {
            if ($user->access_from && now()->lt($user->access_from)) {
                throw ValidationException::withMessages([
                    'login' => __('Ihr Mitarbeiterzugang ist erst ab ' . $user->access_from->format('d.m.Y') . ' gültig.'),
                ]);
            }
            if ($user->access_until && now()->gt($user->access_until->endOfDay())) {
                throw ValidationException::withMessages([
                    'login' => __('Ihr Mitarbeiterzugang ist am ' . $user->access_until->format('d.m.Y') . ' abgelaufen.'),
                ]);
            }
        }

        // Dynamic One-Device Binding for Members & Staff
        $deviceId = $request->input('device_id');
        $deviceName = $request->input('device_name') ?: 'Kundenbrowser';

        if (empty($deviceId)) {
            $deviceId = hash('sha256', (string) $request->header('User-Agent') . (string) $request->header('Accept-Language'));
        }

        if (blank($user->device_id)) {
            // First login → dynamically bind device
            $user->update([
                'device_id' => $deviceId,
                'device_name' => $deviceName,
                'device_bound_at' => now(),
                'last_device_activity_at' => now(),
            ]);

            AuditLog::create([
                'user_id' => $user->id,
                'event' => 'DEVICE_BOUND',
                'detail' => "Erstgerät erfolgreich gebunden: {$deviceName} (Hash: " . substr($deviceId, 0, 16) . "...)",
                'ip' => $request->ip(),
            ]);
        } elseif ($user->device_id !== $deviceId) {
            // Device mismatch → Log event and reject
            AuditLog::create([
                'user_id' => $user->id,
                'event' => 'LOGIN_REJECTED_DEVICE_MISMATCH',
                'detail' => "Abgewiesener Anmeldeversuch von Fremdgerät. Gespeichert: " . substr($user->device_id, 0, 16) . "..., Übermittelt: " . substr($deviceId, 0, 16) . "... ({$deviceName})",
                'ip' => $request->ip(),
            ]);

            throw ValidationException::withMessages([
                'login' => __('Dieses Konto ist bereits an ein anderes Gerät gebunden. Aus Sicherheits- und Urheberrechtsgründen kann der Kurs nur auf Ihrem registrierten Erstgerät genutzt werden. Bei einem Gerätewechsel wenden Sie sich bitte an den Support.'),
            ]);
        } else {
            $user->update([
                'last_device_activity_at' => now(),
                'device_name' => $deviceName,
            ]);
        }

        AuditLog::create([
            'user_id' => $user->id,
            'event' => 'LOGIN_SUCCESS',
            'detail' => "Erfolgreiche Anmeldung des Benutzers '{$user->username}'.",
            'ip' => $request->ip(),
        ]);

        Auth::login($user, true);
        $request->session()->regenerate();

        if ($user->isAdmin()) {
            return redirect()->intended(route('admin.dashboard'));
        }

        // Redirect to selected course if requested
        if ($request->filled('slug')) {
            $courseSlug = $request->slug;
            $course = Course::where('slug', $courseSlug)->first();
            if ($course) {
                return redirect()->route('course.show', $courseSlug)
                    ->with('success', 'Willkommen zurück, ' . ($user->first_name ?: $user->name) . '!');
            }
        }

        return redirect()->intended(route('member.dashboard'))
            ->with('success', 'Willkommen zurück, ' . ($user->first_name ?: $user->name) . '!');
    }

    public function registerPage()
    {
        return view('frontend.pages.auth.register');
    }

    public function registerStore(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:100', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'invoice_number' => ['nullable', 'string', 'max:100'],
        ]);

        $user = User::create([
            'name' => $request->first_name,
            'first_name' => $request->first_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'invoice_number' => $request->invoice_number,
            'role' => 'member',
            'is_active' => true,
        ]);

        Auth::login($user);

        return redirect()->route('member.dashboard')
            ->with('success', 'Kundenkonto erfolgreich erstellt. Willkommen!');
    }

    public function forgotPasswordPage()
    {
        return view('frontend.pages.auth.forget-password');
    }

    public function forgotPasswordStore(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:100'],
            'invoice_number' => ['nullable', 'string', 'max:100'],
            'course' => ['nullable', 'string', 'max:150'],
            'email' => ['nullable', 'email', 'max:150'],
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        AccessRequest::create([
            'username' => $request->username,
            'invoice_number' => $request->invoice_number,
            'course_name' => $request->course,
            'email' => $request->email,
            'note' => $request->note ?: 'Passwort-Wiederherstellungsanfrage über Kundenportal.',
            'status' => 'open',
        ]);

        return back()->with('request_submitted', 'Ihre Zugangsanfrage wurde übermittelt. Nach internem Abgleich mit der Buchhaltung erhalten Sie Ihre neuen Zugangsdaten.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Sie haben sich erfolgreich abgemeldet.');
    }
}
