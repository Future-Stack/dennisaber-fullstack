<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccessRequest;
use App\Models\AdminNote;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\User;
use App\Models\VersionNote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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

        // Courses with all their lessons
        $courses = Course::with(['lessons'])->withCount('lessons')->orderBy('order')->get();

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

    public function storeCourse(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255', 'unique:courses,title'],
            'category' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'duration_days' => ['required', 'integer', 'min:1'],
            'total_hours' => ['nullable', 'string', 'max:100'],
            'public_url' => ['nullable', 'url', 'max:500'],
            'thumbnail_file' => ['nullable', 'image', 'max:10240'],
            'order' => ['nullable', 'integer'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $counter = 1;
        while (Course::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail_file')) {
            $thumbnailPath = '/storage/' . $request->file('thumbnail_file')->store('thumbnails', 'public');
        }

        $order = $request->filled('order')
            ? (int) $request->order
            : (Course::count() + 1);

        $course = Course::create([
            'title' => $request->title,
            'slug' => $slug,
            'category' => $request->category ?: 'Akademie',
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'thumbnail' => $thumbnailPath ?: '/frontend/assets/kompakt-thumb.jpg',
            'duration_days' => (int) $request->duration_days,
            'total_hours' => $request->total_hours ?: '30 Unterrichtsstunden',
            'public_url' => $request->public_url,
            'order' => $order,
            'is_published' => $request->boolean('is_published', true),
        ]);

        return redirect()->route('admin.dashboard', ['#medien'])
            ->with('success', "Neuer Kurs '{$course->title}' erfolgreich angelegt.");
    }

    public function updateCourse(Request $request, Course $course)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'duration_days' => ['required', 'integer', 'min:1'],
            'total_hours' => ['nullable', 'string', 'max:100'],
            'public_url' => ['nullable', 'url', 'max:500'],
            'thumbnail_file' => ['nullable', 'image', 'max:10240'],
            'order' => ['nullable', 'integer'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $data = [
            'title' => $request->title,
            'category' => $request->category ?: $course->category,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'duration_days' => (int) $request->duration_days,
            'total_hours' => $request->total_hours ?: $course->total_hours,
            'public_url' => $request->public_url,
            'order' => $request->filled('order') ? (int) $request->order : $course->order,
            'is_published' => $request->boolean('is_published', true),
        ];

        if ($request->hasFile('thumbnail_file')) {
            $data['thumbnail'] = '/storage/' . $request->file('thumbnail_file')->store('thumbnails', 'public');
        }

        $course->update($data);

        return redirect()->route('admin.dashboard', ['#medien'])
            ->with('success', "Kurs '{$course->title}' wurde erfolgreich aktualisiert.");
    }

    public function deleteCourse(Course $course)
    {
        $title = $course->title;

        // Cleanup all attached lesson files
        foreach ($course->lessons as $lesson) {
            if ($lesson->video_path && Storage::disk('public')->exists($lesson->video_path)) {
                Storage::disk('public')->delete($lesson->video_path);
            }
            if ($lesson->audio_path && Storage::disk('public')->exists($lesson->audio_path)) {
                Storage::disk('public')->delete($lesson->audio_path);
            }
            if ($lesson->pdf_attachment_path && Storage::disk('public')->exists($lesson->pdf_attachment_path)) {
                Storage::disk('public')->delete($lesson->pdf_attachment_path);
            }
            $lesson->delete();
        }

        $course->delete();

        return redirect()->route('admin.dashboard', ['#medien'])
            ->with('success', "Kurs '{$title}' und alle zugehörigen Lektionen wurden erfolgreich gelöscht.");
    }

    public function storeLesson(Request $request, Course $course)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'chapter_name' => ['nullable', 'string', 'max:255'],
            'lesson_number' => ['nullable', 'integer'],
            'duration_minutes' => ['nullable', 'integer'],
            'video_file' => ['nullable', 'file', 'mimes:mp4,mov,webm,ogg,mkv', 'max:512000'],
            'video_url' => ['nullable', 'string', 'max:500'],
            'audio_file' => ['nullable', 'file', 'mimes:mp3,wav,m4a,ogg,aac', 'max:102400'],
            'pdf_file' => ['nullable', 'file', 'mimes:pdf', 'max:51200'],
            'pdf_attachment_name' => ['nullable', 'string', 'max:255'],
            'content_html' => ['nullable', 'string'],
            'is_preview' => ['nullable', 'boolean'],
            'order' => ['nullable', 'integer'],
        ]);

        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $counter = 1;
        while ($course->lessons()->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        $lessonNumber = $request->filled('lesson_number')
            ? (int) $request->lesson_number
            : ($course->lessons()->count() + 1);

        $order = $request->filled('order')
            ? (int) $request->order
            : $lessonNumber;

        $videoPath = null;
        if ($request->hasFile('video_file')) {
            $videoPath = $request->file('video_file')->store('videos', 'public');
        }

        $audioPath = null;
        if ($request->hasFile('audio_file')) {
            $audioPath = $request->file('audio_file')->store('audio', 'public');
        }

        $pdfPath = null;
        $pdfName = $request->pdf_attachment_name;
        if ($request->hasFile('pdf_file')) {
            $pdfFile = $request->file('pdf_file');
            $pdfPath = $pdfFile->store('materials', 'public');
            if (blank($pdfName)) {
                $pdfName = $pdfFile->getClientOriginalName();
            }
        }

        $lesson = $course->lessons()->create([
            'chapter_name' => $request->chapter_name ?: 'Hauptmodul',
            'title' => $request->title,
            'slug' => $slug,
            'lesson_number' => $lessonNumber,
            'duration_minutes' => (int) ($request->duration_minutes ?: 15),
            'video_url' => $request->video_url,
            'video_path' => $videoPath,
            'audio_path' => $audioPath,
            'pdf_attachment_path' => $pdfPath,
            'pdf_attachment_name' => $pdfName,
            'content_html' => $request->content_html,
            'is_preview' => $request->boolean('is_preview'),
            'order' => $order,
        ]);

        return redirect()->route('admin.dashboard', ['#medien'])
            ->with('success', "Lektion '{$lesson->title}' erfolgreich für den Kurs '{$course->title}' angelegt.");
    }

    public function updateLesson(Request $request, Lesson $lesson)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'chapter_name' => ['nullable', 'string', 'max:255'],
            'lesson_number' => ['nullable', 'integer'],
            'duration_minutes' => ['nullable', 'integer'],
            'video_file' => ['nullable', 'file', 'mimes:mp4,mov,webm,ogg,mkv', 'max:512000'],
            'video_url' => ['nullable', 'string', 'max:500'],
            'audio_file' => ['nullable', 'file', 'mimes:mp3,wav,m4a,ogg,aac', 'max:102400'],
            'pdf_file' => ['nullable', 'file', 'mimes:pdf', 'max:51200'],
            'pdf_attachment_name' => ['nullable', 'string', 'max:255'],
            'content_html' => ['nullable', 'string'],
            'is_preview' => ['nullable', 'boolean'],
            'order' => ['nullable', 'integer'],
        ]);

        $data = [
            'chapter_name' => $request->chapter_name ?: $lesson->chapter_name,
            'title' => $request->title,
            'lesson_number' => $request->filled('lesson_number') ? (int) $request->lesson_number : $lesson->lesson_number,
            'duration_minutes' => $request->filled('duration_minutes') ? (int) $request->duration_minutes : $lesson->duration_minutes,
            'video_url' => $request->video_url,
            'content_html' => $request->content_html,
            'is_preview' => $request->boolean('is_preview'),
            'order' => $request->filled('order') ? (int) $request->order : $lesson->order,
        ];

        if ($request->hasFile('video_file')) {
            if ($lesson->video_path && Storage::disk('public')->exists($lesson->video_path)) {
                Storage::disk('public')->delete($lesson->video_path);
            }
            $data['video_path'] = $request->file('video_file')->store('videos', 'public');
        }

        if ($request->hasFile('audio_file')) {
            if ($lesson->audio_path && Storage::disk('public')->exists($lesson->audio_path)) {
                Storage::disk('public')->delete($lesson->audio_path);
            }
            $data['audio_path'] = $request->file('audio_file')->store('audio', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            if ($lesson->pdf_attachment_path && Storage::disk('public')->exists($lesson->pdf_attachment_path)) {
                Storage::disk('public')->delete($lesson->pdf_attachment_path);
            }
            $pdfFile = $request->file('pdf_file');
            $data['pdf_attachment_path'] = $pdfFile->store('materials', 'public');
            if (blank($request->pdf_attachment_name)) {
                $data['pdf_attachment_name'] = $pdfFile->getClientOriginalName();
            } else {
                $data['pdf_attachment_name'] = $request->pdf_attachment_name;
            }
        } elseif ($request->filled('pdf_attachment_name')) {
            $data['pdf_attachment_name'] = $request->pdf_attachment_name;
        }

        $lesson->update($data);

        return redirect()->route('admin.dashboard', ['#medien'])
            ->with('success', "Lektion '{$lesson->title}' wurde erfolgreich aktualisiert.");
    }

    public function deleteLesson(Lesson $lesson)
    {
        $title = $lesson->title;

        // Cleanup storage files if present
        if ($lesson->video_path && Storage::disk('public')->exists($lesson->video_path)) {
            Storage::disk('public')->delete($lesson->video_path);
        }
        if ($lesson->audio_path && Storage::disk('public')->exists($lesson->audio_path)) {
            Storage::disk('public')->delete($lesson->audio_path);
        }
        if ($lesson->pdf_attachment_path && Storage::disk('public')->exists($lesson->pdf_attachment_path)) {
            Storage::disk('public')->delete($lesson->pdf_attachment_path);
        }

        $lesson->delete();

        return redirect()->route('admin.dashboard', ['#medien'])
            ->with('success', "Lektion '{$title}' und zugehörige Mediendateien wurden erfolgreich gelöscht.");
    }
}
