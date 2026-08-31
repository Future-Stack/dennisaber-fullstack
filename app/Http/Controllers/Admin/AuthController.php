<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function loginPage()
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.pages.auth.login');
    }

    public function forgetPage()
    {
        return view('admin.pages.auth.forget-password');
    }

    public function loginStore(LoginRequest $request)
    {
        $user = User::where('email', $request->email)
            ->orWhere('username', $request->email)
            ->first();

        // Check if user exists and is admin
        if (! $user || ! $user->isAdmin() || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => __('Ungültige E-Mail-Adresse oder falsches Passwort.'),
            ]);
        }

        // Check account active
        if (! $user->is_active) {
            throw ValidationException::withMessages([
                'email' => __('Dieses Administratorkonto ist derzeit deaktiviert.'),
            ]);
        }

        // Verify Security Code
        if (! $user->security_code_hash || ! Hash::check($request->security_code, $user->security_code_hash)) {
            throw ValidationException::withMessages([
                'security_code' => __('Ungültiger 4-stelliger Sicherheitscode.'),
            ]);
        }

        // Check Security Code Expiry (if set)
        if ($user->security_code_expires_at && now()->greaterThan($user->security_code_expires_at)) {
            throw ValidationException::withMessages([
                'security_code' => __('Der Sicherheitscode ist abgelaufen.'),
            ]);
        }

        /**
         * Dynamic One-Device Binding (temporarily commented out for HTTP testing)
         */
        /*
        $deviceId = $request->device_id;
        $deviceName = $request->device_name ?: 'Webbrowser';

        if (blank($user->device_id)) {
            // First login → dynamically bind device
            $user->update([
                'device_id' => $deviceId,
                'device_name' => $deviceName,
                'device_bound_at' => now(),
                'last_device_activity_at' => now(),
            ]);
        } elseif ($user->device_id !== $deviceId) {
            // Check if device matches
            throw ValidationException::withMessages([
                'email' => __('Dieses Administratorkonto ist bereits an ein anderes registriertes Gerät gebunden. Aus Sicherheitsgründen ist eine Anmeldung von diesem Gerät nicht möglich.'),
            ]);
        } else {
            $user->update([
                'last_device_activity_at' => now(),
                'device_name' => $deviceName,
            ]);

        }
        */

        Auth::login($user, true);
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'))
            ->with('success', 'Erfolgreich als Administrator angemeldet.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'security_code' => ['required', 'digits:4'],
            'new_password' => ['required', 'string', 'min:12', 'confirmed'],
        ], [
            'security_code.digits' => 'Der Sicherheitscode muss genau 4 Ziffern lang sein.',
            'new_password.min' => 'Das neue Passwort muss mindestens 12 Zeichen lang sein.',
            'new_password.confirmed' => 'Die Passwort-Wiederholung stimmt nicht überein.',
        ]);

        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Das bisherige Admin-Passwort ist nicht korrekt.']);
        }

        if (! Hash::check($request->security_code, $user->security_code_hash)) {
            return back()->withErrors(['security_code' => 'Der angegebene Sicherheitscode ist ungültig.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('password_success', 'Das Administrator-Passwort wurde erfolgreich geändert.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'Sie wurden erfolgreich abgemeldet.');
    }
}
