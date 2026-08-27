<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccessRequest;
use App\Models\AdminNote;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use App\Models\VersionNote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Customer Query
        $customersQuery = User::where('role', 'member')
            ->with(['enrollments.course']);

        if ($search) {
            $customersQuery->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('invoice_number', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $customers = $customersQuery->latest()->get();

        // Staff Users
        $staffMembers = User::where('role', 'staff')->latest()->get();

        // Admin Personal Notes (only non-expired, up to 5)
        $adminNotes = AdminNote::where(function ($q) {
            $q->whereNull('expires_at')
                ->orWhere('expires_at', '>', now());
        })->latest()->take(5)->get();

        // Version Notes (permanent)
        $versionNotes = VersionNote::latest()->get();

        // Access Requests
        $accessRequests = AccessRequest::where('status', 'open')->latest()->get();

        // Courses
        $courses = Course::withCount('lessons')->orderBy('order')->get();

        return view('admin.pages.dashboard', compact(
            'customers',
            'staffMembers',
            'adminNotes',
            'versionNotes',
            'accessRequests',
            'courses',
            'search'
        ));
    }

    public function storeCustomer(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:100', 'unique:users,username'],
            'invoice_number' => ['required', 'string', 'max:100'],
            'password' => ['nullable', 'string', 'min:8'],
            'course_slug' => ['nullable', 'string', 'exists:courses,slug'],
            'early_start' => ['nullable', 'boolean'],
            'start_date' => ['nullable', 'date'],
        ]);

        $plainPassword = $request->password ?: Str::password(12, true, true, false);

        $customer = User::create([
            'name' => $request->first_name,
            'first_name' => $request->first_name,
            'username' => $request->username,
            'email' => $request->username . '@besseler-kunden.de',
            'invoice_number' => $request->invoice_number,
            'password' => Hash::make($plainPassword),
            'role' => 'member',
            'is_active' => true,
        ]);

        // Course assignment if selected
        if ($request->filled('course_slug')) {
            $course = Course::where('slug', $request->course_slug)->first();
            if ($course) {
                $isEarlyStart = $request->boolean('early_start');
                $startDate = $request->filled('start_date')
                    ? Carbon::parse($request->start_date)
                    : ($isEarlyStart ? now() : now()->addDays(14));

                $expiresDate = $startDate->copy()->addDays($course->duration_days ?: 90);

                Enrollment::create([
                    'user_id' => $customer->id,
                    'course_id' => $course->id,
                    'invoice_number' => $request->invoice_number,
                    'started_at' => $startDate->toDateString(),
                    'expires_at' => $expiresDate->toDateString(),
                    'is_active' => true,
                    'early_start_agreed' => $isEarlyStart,
                ]);
            }
        }

        return redirect()->route('admin.dashboard', ['#kunden'])
            ->with('created_customer', [
                'name' => $customer->first_name,
                'username' => $customer->username,
                'password' => $plainPassword,
                'invoice' => $customer->invoice_number,
            ])
            ->with('success', "Kundenkonto für '{$customer->username}' erfolgreich angelegt.");
    }

    public function toggleCustomerActive(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Administrator-Konto kann nicht gesperrt werden.');
        }

        $user->update([
            'is_active' => ! $user->is_active,
        ]);

        $status = $user->is_active ? 'aktiviert' : 'gesperrt';
        return back()->with('success', "Kundenkonto {$user->username} wurde erfolgreich {$status}.");
    }

    public function resetCustomerDevice(User $user)
    {
        $user->update([
            'device_id' => null,
            'device_name' => null,
            'device_bound_at' => null,
            'last_device_activity_at' => null,
        ]);

        return back()->with('success', "Gerätebindung für '{$user->username}' wurde zurückgesetzt. Der Kunde kann sich nun von einem neuen Gerät anmelden.");
    }

    public function deleteCustomer(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Administrator-Konto kann nicht gelöscht werden.');
        }

        $username = $user->username;
        $user->delete();

        return back()->with('success', "Kundenkonto '{$username}' wurde datensparsam und vollständig gelöscht.");
    }

    public function storeStaff(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'occupation' => ['required', 'string', 'max:150'],
            'username' => ['required', 'string', 'max:100', 'unique:users,username'],
            'password' => ['nullable', 'string', 'min:10'],
            'access_from' => ['required', 'date'],
            'access_until' => ['required', 'date', 'after_or_equal:access_from'],
            'permissions' => ['nullable', 'array'],
        ]);

        $plainPassword = $request->password ?: Str::password(12, true, true, false);

        User::create([
            'name' => $request->name,
            'first_name' => explode(' ', $request->name)[0],
            'occupation' => $request->occupation,
            'username' => $request->username,
            'email' => $request->username . '@besseler-intern.de',
            'password' => Hash::make($plainPassword),
            'role' => 'staff',
            'access_from' => $request->access_from,
            'access_until' => $request->access_until,
            'permissions' => $request->permissions ?: [],
            'is_active' => true,
        ]);

        return back()->with('created_staff', [
            'name' => $request->name,
            'username' => $request->username,
            'password' => $plainPassword,
        ])->with('success', "Mitarbeiterkonto für '{$request->name}' erfolgreich angelegt.");
    }

    public function deleteStaff(User $user)
    {
        if ($user->role !== 'staff') {
            return back()->with('error', 'Nur Mitarbeiterkonten können an dieser Stelle entfernt werden.');
        }

        $user->delete();
        return back()->with('success', 'Mitarbeiterkonto wurde erfolgreich gelöscht.');
    }

    public function storeAdminNote(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'body' => ['required', 'string', 'max:2000'],
        ]);

        AdminNote::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'body' => $request->body,
            'expires_at' => now()->addDays(10),
        ]);

        return back()->with('success', 'Persönliche Admin-Notiz gespeichert (wird nach 10 Tagen automatisch entfernt).');
    }

    public function deleteAdminNote(AdminNote $note)
    {
        $note->delete();
        return back()->with('success', 'Notiz entfernt.');
    }

    public function storeVersionNote(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'body' => ['required', 'string', 'max:3000'],
        ]);

        VersionNote::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return back()->with('success', 'Planungsidee für die nächste Portalversion dauerhaft eingetragen.');
    }

    public function deleteVersionNote(VersionNote $note)
    {
        $note->delete();
        return back()->with('success', 'Planungseintrag gelöscht.');
    }

    public function resolveAccessRequest(AccessRequest $accessRequest)
    {
        $accessRequest->update([
            'status' => 'resolved',
            'resolved_at' => now(),
        ]);

        return back()->with('success', 'Zugangsanfrage als bearbeitet markiert.');
    }

    public function deleteAccessRequest(AccessRequest $accessRequest)
    {
        $accessRequest->delete();
        return back()->with('success', 'Zugangsanfrage gelöscht.');
    }
}
