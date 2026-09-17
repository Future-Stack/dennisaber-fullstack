<?php

namespace Tests\Feature;

use App\Models\AccessRequest;
use App\Models\AdminNote;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\User;
use App\Models\VersionNote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DennisCoursePortalTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Test Public Landing Pages
     */
    public function test_public_landing_pages_are_accessible(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->get('/payment');
        $response->assertStatus(200);

        $response = $this->get('/copy-protection');
        $response->assertStatus(200);

        $response = $this->get('/faster-processing');
        $response->assertStatus(200);

        $response = $this->get('/pages/privacy-policy');
        $response->assertStatus(200);

        $response = $this->get('/pages/imprint');
        $response->assertStatus(200);
    }

    /**
     * Test Admin Login with Email, Password and Security Code
     */
    public function test_admin_login_with_security_code_and_device_binding(): void
    {
        $deviceId = 'admin-device-hash-123';

        // 1. Invalid security code fails
        $response = $this->post(route('admin.loginStore'), [
            'email' => 'dennis@besseler.de',
            'password' => 'TestTestTest00!',
            'security_code' => '9999',
            'device_id' => $deviceId,
            'device_name' => 'Chrome on MacOS',
        ]);
        $response->assertSessionHasErrors('security_code');

        // 2. Correct credentials and security code succeeds
        $response = $this->post(route('admin.loginStore'), [
            'email' => 'dennis@besseler.de',
            'password' => 'TestTestTest00!',
            'security_code' => '1979',
            'device_id' => $deviceId,
            'device_name' => 'Chrome on MacOS',
        ]);
        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();

        // Check device was dynamically bound
        $admin = User::where('email', 'dennis@besseler.de')->first();
        $this->assertEquals($deviceId, $admin->device_id);

        // 3. Login attempt from another device fails
        auth()->logout();
        $response = $this->post(route('admin.loginStore'), [
            'email' => 'dennis@besseler.de',
            'password' => 'TestTestTest00!',
            'security_code' => '1979',
            'device_id' => 'different-device-hash-456',
            'device_name' => 'Safari on iPhone',
        ]);
        $response->assertSessionHasErrors('email');
    }

    /**
     * Test Admin Password Change with Security Code
     */
    public function test_admin_can_change_password_with_security_code(): void
    {
        $admin = User::where('role', 'admin')->first();
        $this->actingAs($admin);

        $response = $this->post(route('admin.change-password'), [
            'current_password' => 'TestTestTest00!',
            'security_code' => '1979',
            'new_password' => 'NeuesPasswort2026!#',
            'new_password_confirmation' => 'NeuesPasswort2026!#',
        ]);

        $response->assertSessionHas('password_success');
        $admin->refresh();
        $this->assertTrue(Hash::check('NeuesPasswort2026!#', $admin->password));
    }

    /**
     * Test Admin Customer CRUD & Enrollment Calculation
     */
    public function test_admin_customer_crud_and_device_reset(): void
    {
        $admin = User::where('role', 'admin')->first();
        $this->actingAs($admin);

        // Create new customer with course assignment
        $response = $this->post(route('admin.customers.store'), [
            'first_name' => 'Erika',
            'username' => 'erika.muster',
            'invoice_number' => 'RE-2026-999',
            'password' => 'ErikaPass123!',
            'course_slug' => 'dnl-kompakt',
            'early_start' => '1',
            'start_date' => now()->toDateString(),
        ]);

        $response->assertSessionHas('created_customer');
        $customer = User::where('username', 'erika.muster')->first();
        $this->assertNotNull($customer);
        $this->assertEquals('RE-2026-999', $customer->invoice_number);

        // Verify enrollment was created
        $enrollment = Enrollment::where('user_id', $customer->id)->first();
        $this->assertNotNull($enrollment);
        $this->assertEquals(120, $enrollment->started_at->diffInDays($enrollment->expires_at));

        // Simulate device binding
        $customer->update(['device_id' => 'erika-phone-123']);
        $this->assertEquals('erika-phone-123', $customer->device_id);

        // Admin resets device binding
        $this->post(route('admin.customers.reset-device', $customer->id));
        $customer->refresh();
        $this->assertNull($customer->device_id);

        // Admin toggles active status
        $this->post(route('admin.customers.toggle', $customer->id));
        $customer->refresh();
        $this->assertFalse($customer->is_active);

        // Admin deletes customer
        $this->delete(route('admin.customers.delete', $customer->id));
        $this->assertNull(User::find($customer->id));
    }

    /**
     * Test Customer Login, Dashboard and Course Progress Tracking
     */
    public function test_customer_login_and_course_player_flow(): void
    {
        $member = User::where('username', 'testkunde')->first();
        $course = Course::where('slug', 'dnl-kompakt')->first();
        $lesson = $course->lessons()->first();

        // 1. Customer logs in
        $response = $this->post(route('login.store'), [
            'login' => 'testkunde',
            'password' => 'KundeTest2026!',
            'device_id' => 'kunde-laptop-xyz',
            'device_name' => 'Firefox Windows',
        ]);
        $response->assertRedirect(route('member.dashboard'));
        $this->assertAuthenticatedAs($member);

        // 2. Member Dashboard renders with progress
        $response = $this->get(route('member.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('5-Tage-Kompaktlehrgang');
        $response->assertSee('Fortschritt');

        // 3. Access Course Lesson Player
        $response = $this->get(route('course.lesson', [
            'courseSlug' => $course->slug,
            'lessonSlug' => $lesson->slug,
        ]));
        $response->assertStatus(200);
        $response->assertSee($lesson->title);

        // 4. Toggle Lesson Completion via AJAX
        $response = $this->postJson(route('course.lesson.toggle', [
            'courseSlug' => $course->slug,
            'lessonSlug' => $lesson->slug,
        ]));
        $response->assertJson([
            'success' => true,
        ]);

        // 5. Access Protected PDF Stream
        $response = $this->get(route('media.stream', [
            'courseSlug' => $course->slug,
            'lessonSlug' => $lesson->slug,
            'type' => 'pdf',
        ]));
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    /**
     * Test Customer Device Binding Strict Mismatch Rejection and Audit Log
     */
    public function test_customer_device_binding_rejection_and_audit_logging(): void
    {
        $member = User::where('username', 'testkunde')->first();
        $initialDeviceId = 'device-hash-primary-001';
        $secondDeviceId = 'device-hash-secondary-002';

        // 1. First login binds primary device
        $response = $this->post(route('login.store'), [
            'login' => 'testkunde',
            'password' => 'KundeTest2026!',
            'device_id' => $initialDeviceId,
            'device_name' => 'Chrome Windows',
        ]);
        $response->assertRedirect(route('member.dashboard'));
        $member->refresh();
        $this->assertEquals($initialDeviceId, $member->device_id);

        auth()->logout();

        // 2. Second login with different device (Incognito/Second PC) is rejected
        $rejectResponse = $this->post(route('login.store'), [
            'login' => 'testkunde',
            'password' => 'KundeTest2026!',
            'device_id' => $secondDeviceId,
            'device_name' => 'Firefox Incognito',
        ]);
        $rejectResponse->assertSessionHasErrors('login');
        $this->assertGuest();

        // Verify Audit Log records LOGIN_REJECTED_DEVICE_MISMATCH
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $member->id,
            'event' => 'LOGIN_REJECTED_DEVICE_MISMATCH',
        ]);

        // 3. Admin resets the device
        $admin = User::where('role', 'admin')->first();
        $this->actingAs($admin)->post(route('admin.customers.reset-device', $member->id));
        $member->refresh();
        $this->assertNull($member->device_id);

        auth()->logout();

        // 4. Now second device can log in and becomes the new primary device
        $rebindResponse = $this->post(route('login.store'), [
            'login' => 'testkunde',
            'password' => 'KundeTest2026!',
            'device_id' => $secondDeviceId,
            'device_name' => 'Firefox Incognito',
        ]);
        $rebindResponse->assertRedirect(route('member.dashboard'));
        $member->refresh();
        $this->assertEquals($secondDeviceId, $member->device_id);
    }

    /**
     * Test Unauthenticated and Unauthorized Protected Media Access
     */
    public function test_unauthenticated_media_access_is_forbidden(): void
    {
        $course = Course::where('slug', 'dnl-kompakt')->first();
        $lesson = $course->lessons()->first();

        auth()->logout();

        // 1. Guest is redirected to login
        $response = $this->get(route('media.stream', [
            'courseSlug' => $course->slug,
            'lessonSlug' => $lesson->slug,
            'type' => 'pdf',
        ]));
        $response->assertRedirect(route('login'));

        // 2. Member without enrollment gets 403 Forbidden
        $otherMember = User::create([
            'name' => 'Fremder User',
            'username' => 'fremd.user',
            'email' => 'fremd@example.com',
            'password' => Hash::make('Secret123!'),
            'role' => 'member',
            'is_active' => true,
        ]);
        $this->actingAs($otherMember);

        $response = $this->get(route('media.stream', [
            'courseSlug' => $course->slug,
            'lessonSlug' => $lesson->slug,
            'type' => 'pdf',
        ]));
        $response->assertStatus(403);
    }

    /**
     * Test Forgot Password Access Request Submission
     */
    public function test_forgot_password_access_request_is_recorded(): void
    {
        $response = $this->post(route('forgot-password.store'), [
            'username' => 'klaus.w',
            'invoice_number' => 'RE-2026-777',
            'email' => 'klaus@example.com',
            'course' => '5-Tage-Kompaktlehrgang',
            'note' => 'Gerät gewechselt, neues Passwort benötigt.',
        ]);

        $response->assertSessionHas('request_submitted');
        $this->assertDatabaseHas('access_requests', [
            'username' => 'klaus.w',
            'invoice_number' => 'RE-2026-777',
            'status' => 'open',
        ]);
    }

    /**
     * Test Mailto Inquiry Generator
     */
    public function test_inquiry_mailto_generator(): void
    {
        $response = $this->postJson(route('inquiry.mailto'), [
            'first_name' => 'Michael',
            'email' => 'michael@example.com',
            'course' => '5-Tage-Kompaktlehrgang',
            'message' => 'Bitte um Kontaktaufnahme.',
        ]);

        $response->assertJsonStructure([
            'success',
            'mailto_link',
            'subject',
            'body',
        ]);
    }

    /**
     * Test Admin Lesson Creation with Media
     */
    public function test_admin_can_create_update_and_delete_lesson(): void
    {
        $admin = User::where('role', 'admin')->first();
        $course = Course::first();

        // 1. Create Lesson
        $response = $this->actingAs($admin)->post(route('admin.lessons.store', $course->id), [
            'chapter_name' => 'Modul 99: Testmodul',
            'title' => 'Testlektion mit Medien',
            'lesson_number' => 99,
            'duration_minutes' => 30,
            'video_url' => 'https://example.com/test-video.mp4',
            'pdf_attachment_name' => 'Test_Material.pdf',
            'content_html' => '<p>Testinhalt der Lektion</p>',
            'is_preview' => true,
            'order' => 99,
        ]);

        $response->assertRedirect(route('admin.dashboard', ['#medien']));
        $this->assertDatabaseHas('lessons', [
            'course_id' => $course->id,
            'title' => 'Testlektion mit Medien',
            'lesson_number' => 99,
        ]);

        $lesson = Lesson::where('title', 'Testlektion mit Medien')->first();

        // 2. Update Lesson
        $response = $this->actingAs($admin)->post(route('admin.lessons.update', $lesson->id), [
            'chapter_name' => 'Modul 99: Aktualisiertes Modul',
            'title' => 'Testlektion Aktualisiert',
            'lesson_number' => 99,
            'duration_minutes' => 45,
            'video_url' => 'https://example.com/updated-video.mp4',
            'content_html' => '<p>Aktualisierter Inhalt</p>',
            'is_preview' => false,
            'order' => 99,
        ]);

        $response->assertRedirect(route('admin.dashboard', ['#medien']));
        $this->assertDatabaseHas('lessons', [
            'id' => $lesson->id,
            'title' => 'Testlektion Aktualisiert',
            'duration_minutes' => 45,
        ]);

        // 3. Delete Lesson
        $response = $this->actingAs($admin)->delete(route('admin.lessons.delete', $lesson->id));
        $response->assertRedirect(route('admin.dashboard', ['#medien']));
        $this->assertDatabaseMissing('lessons', [
            'id' => $lesson->id,
        ]);
    }

    public function test_admin_can_create_update_and_delete_course(): void
    {
        $admin = User::where('role', 'admin')->first();

        // 1. Create Course
        $response = $this->actingAs($admin)->post(route('admin.courses.store'), [
            'title' => 'Neuer Admin Testkurs',
            'category' => 'Akademie / Führung',
            'subtitle' => 'Untertitel für Testkurs',
            'duration_days' => 60,
            'total_hours' => '45 Unterrichtsstunden',
            'description' => 'Ausführliche Beschreibung des Testkurses',
            'public_url' => 'https://example.com/kurs-landingpage',
            'order' => 15,
            'is_published' => true,
        ]);

        $response->assertRedirect(route('admin.dashboard', ['#medien']));
        $this->assertDatabaseHas('courses', [
            'title' => 'Neuer Admin Testkurs',
            'slug' => 'neuer-admin-testkurs',
            'category' => 'Akademie / Führung',
            'duration_days' => 60,
        ]);

        $course = Course::where('slug', 'neuer-admin-testkurs')->first();

        // 2. Update Course
        $response = $this->actingAs($admin)->post(route('admin.courses.update', $course->id), [
            'title' => 'Neuer Admin Testkurs Aktualisiert',
            'category' => 'Business',
            'subtitle' => 'Aktualisierter Untertitel',
            'duration_days' => 90,
            'total_hours' => '50 Unterrichtsstunden',
            'description' => 'Aktualisierte Beschreibung',
            'public_url' => 'https://example.com/kurs-landingpage-neu',
            'order' => 16,
            'is_published' => true,
        ]);

        $response->assertRedirect(route('admin.dashboard', ['#medien']));
        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'title' => 'Neuer Admin Testkurs Aktualisiert',
            'category' => 'Business',
            'duration_days' => 90,
        ]);

        // 3. Delete Course
        $response = $this->actingAs($admin)->delete(route('admin.courses.delete', $course->id));
        $response->assertRedirect(route('admin.dashboard', ['#medien']));
        $this->assertDatabaseMissing('courses', [
            'id' => $course->id,
        ]);
    }

    /**
     * Test Course Player with Compact MP3 Player, Dynamic Watermark, and Abuse Report Modal
     */
    public function test_systematic_content_type_rendering_for_audio_video_pdf_text(): void
    {
        $member = User::where('username', 'testkunde')->first();
        $this->actingAs($member);

        $course = Course::where('slug', 'dnl-kompakt')->first();

        // 1. Audio Lesson with compact MP3 player and diagonal watermark
        $audioLesson = Lesson::where('slug', 'einfuehrung-und-orientierung')->first();
        $response = $this->get(route('course.lesson', [
            'courseSlug' => $course->slug,
            'lessonSlug' => $audioLesson->slug,
        ]));
        $response->assertStatus(200);
        $response->assertSee('Original MP3');
        $response->assertSee('unit-audio-player', false);
        $response->assertDontSee('id="lesson-video"', false);
        $response->assertSee('course-customer-watermark', false);
        $response->assertSee('Missbrauch melden');
        $response->assertSee('id="abuse-modal"', false);

        // 2. Unwanted Companion PDF box is removed to match reference portal
        $response->assertDontSee('id="companion-pdf-wrapper"', false);
        $response->assertDontSee('Begleitendes Arbeitsblatt / PDF');
    }

    /**
     * Test Course Durations and Time Tracking System
     */
    public function test_course_durations_and_time_tracking(): void
    {
        // 1. Regular course duration is 120 days (4 months)
        $regularCourse = Course::where('slug', 'dnl-kompakt')->first();
        $this->assertEquals(120, $regularCourse->duration_days);

        // 2. Rio Negro is 30 days
        $rioNegro = Course::where('slug', 'rio-negro-2002')->first();
        $this->assertEquals(30, $rioNegro->duration_days);

        // 3. Homepage displays 4 months for regular courses
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Vier Monate');
        $response->assertDontSee('Drei Monate');

        // 4. Admin time tracking API
        $admin = User::where('role', 'admin')->first();
        $this->actingAs($admin);

        // Start timer
        $startRes = $this->postJson(route('time-tracking.start'), [
            'activity_description' => 'Test Aufgabe Support',
        ]);
        $startRes->assertStatus(200);
        $startRes->assertJsonPath('success', true);

        // Status check
        $statusRes = $this->getJson(route('time-tracking.status'));
        $statusRes->assertStatus(200);
        $statusRes->assertJsonPath('active_entry.status', 'running');

        // Pause timer
        $pauseRes = $this->postJson(route('time-tracking.pause.active'));
        $pauseRes->assertStatus(200);
        $pauseRes->assertJsonPath('entry.status', 'paused');

        // Resume timer
        $resumeRes = $this->postJson(route('time-tracking.resume.active'));
        $resumeRes->assertStatus(200);
        $resumeRes->assertJsonPath('entry.status', 'running');

        // Stop timer
        $stopRes = $this->postJson(route('time-tracking.stop.active'));
        $stopRes->assertStatus(200);
        $stopRes->assertJsonPath('entry.status', 'stopped');
    }

    public function test_admin_dashboard_with_audit_page_2(): void
    {
        $admin = User::where('role', 'admin')->first();
        $this->actingAs($admin);

        for ($i = 0; $i < 15; $i++) {
            \App\Models\AuditLog::create([
                'user_id' => $admin->id,
                'event' => 'TEST_EVENT_' . $i,
                'detail' => 'Test detail ' . $i,
                'ip' => '127.0.0.1',
            ]);
        }

        $response = $this->get('/admin/dashboard?audit_page=2');
        $response->assertStatus(200);
    }

    public function test_time_tracking_5_fields_rotation_and_staff_management(): void
    {
        $admin = User::where('role', 'admin')->first();
        $this->actingAs($admin);

        // 1. Enforce strict 5 entries rotation: completing 5 entries should leave exactly 3 in database
        for ($i = 1; $i <= 5; $i++) {
            $startRes = $this->postJson(route('time-tracking.start'), [
                'activity_1' => "Activity {$i} Part 1",
                'activity_2' => "Activity {$i} Part 2",
                'activity_3' => "Activity {$i} Part 3",
                'activity_4' => "Activity {$i} Part 4",
                'activity_5' => "Activity {$i} Part 5",
            ]);
            $startRes->assertStatus(200);

            $stopRes = $this->postJson(route('time-tracking.stop.active'));
            $stopRes->assertStatus(200);
        }

        // Must have at most 3 completed time entries in the database (oldest deleted)
        $completedCount = \App\Models\TimeEntry::whereIn('status', ['stopped', 'completed'])->count();
        $this->assertEquals(3, $completedCount);

        // Verify the newest entries exist (entries 3, 4, 5) and entry 1 is deleted
        $remainingDescriptions = \App\Models\TimeEntry::whereIn('status', ['stopped', 'completed'])->pluck('activity_1')->toArray();
        $this->assertNotContains('Activity 1 Part 1', $remainingDescriptions);
        $this->assertContains('Activity 5 Part 1', $remainingDescriptions);

        // 2. Admin dashboard renders Section MA and staff time entries
        $dashRes = $this->get('/admin/dashboard');
        $dashRes->assertStatus(200);
        $dashRes->assertSee('Mitarbeiter sicher einsetzen');
        $dashRes->assertSee('Erfasste Mitarbeiterzeiten &amp; Aktivitäten', false);
        $dashRes->assertSee('Activity 5 Part 1');

        // 3. Kopierschutz page matches reference
        $kopierRes = $this->get('/kopierschutz');
        $kopierRes->assertStatus(200);
        $kopierRes->assertSee('Technisches Kursportal');
        $kopierRes->assertSee('So sieht dein persönlicher Kopierschutz aus.');
        $kopierRes->assertSee('Gerät 1 von 1 registriert');

        // 4. Test authenticated media stream for dnl-kompakt
        $streamRes = $this->get(route('media.stream', [
            'courseSlug' => 'dnl-kompakt',
            'lessonSlug' => 'einfuehrung-und-orientierung',
            'type' => 'audio',
        ]));
        $streamRes->assertStatus(200);
        $streamRes->assertHeader('Content-Type', 'audio/mpeg');

        // 5. Staff preview route for admin
        $previewRes = $this->actingAs($admin)->get('/verwaltung/mitarbeiter-vorschau');
        $previewRes->assertStatus(200);
        $previewRes->assertSee('MITARBEITER-KONTO');
        $previewRes->assertSee('ARBEITSFLÄCHE');
        $previewRes->assertSee('Schreibgeschützte Prüfansicht');
        $previewRes->assertDontSee('Nur Administrator');
    }

    /**
     * Test Rio Negro 2002 Player matches Reference Portal 1:1
     */
    public function test_rio_negro_2002_player_matches_reference_portal_1_to_1(): void
    {
        $admin = User::where('role', 'admin')->first();
        $this->actingAs($admin);

        $res = $this->get('/kurs/rio-negro-2002');
        $res->assertStatus(200);

        // Sidebar and step progress
        $res->assertSee('Audio-Abenteuer');
        $res->assertSee('Rio Negro 2002');
        $res->assertSee('Schritt 1 von 14');
        $res->assertSee('00 · Die Vermisstenmeldung');

        // Customer details and watermark
        $res->assertSee('course-customer-watermark', false);
        $res->assertSee('Rech-Nr.: ADMIN-PRÜFANSICHT');
        $res->assertSee('Administrator-Prüfansicht');
        $res->assertSee('200 € Hinweisprämie');
        $res->assertSee('Rechtsverletzung an Dennis melden');
        $res->assertSee('Offizielle Onlinewache der Polizei');

        // Main unit content
        $res->assertSee('rio-action.jpg');
        $res->assertSee('Persönliche Lizenz · keine Weitergabe');
        $res->assertSee('story-instruction', false);
        $res->assertSee('Alarm');
        $res->assertSee('So arbeitest du in dieser Etappe');
        $res->assertSee('Erfasse die Ausgangslage. Noch ist nicht klar, was am Rio Negro geschehen ist.');
        $res->assertSee('Die Vermisstenmeldung');
        $res->assertSee('unit-audio-player', false);

        // Underscore URL route compatibility
        $res2 = $this->get('/kurs/rio_negro_2002?step=1');
        $res2->assertStatus(200);
        $res2->assertSee('00 · Die Vermisstenmeldung');
    }
}

