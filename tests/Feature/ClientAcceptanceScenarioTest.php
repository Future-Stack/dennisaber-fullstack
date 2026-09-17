<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\TimeEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ClientAcceptanceScenarioTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * PRIORITY 1: Single-device / browser binding lifecycle
     */
    public function test_single_device_browser_binding_lifecycle(): void
    {
        $member = User::where('username', 'testkunde')->first();
        $this->assertNull($member->device_id, "testkunde must start unbound");

        $device1 = hash('sha256', 'Browser-Profile-A');
        $device2 = hash('sha256', 'Browser-Profile-B-Incognito');

        // 1. First login binds device1
        $res1 = $this->post(route('login.store'), [
            'login' => 'testkunde',
            'password' => 'KundeTest2026!',
            'device_id' => $device1,
            'device_name' => 'Chrome Normal',
        ]);
        $res1->assertRedirect(route('member.dashboard'));
        $member->refresh();
        $this->assertEquals($device1, $member->device_id);

        auth()->logout();

        // 2. Re-login from same browser profile (device1) succeeds
        $res2 = $this->post(route('login.store'), [
            'login' => 'testkunde',
            'password' => 'KundeTest2026!',
            'device_id' => $device1,
            'device_name' => 'Chrome Normal',
        ]);
        $res2->assertRedirect(route('member.dashboard'));

        auth()->logout();

        // 3. Different browser / Incognito (device2) is rejected
        $res3 = $this->post(route('login.store'), [
            'login' => 'testkunde',
            'password' => 'KundeTest2026!',
            'device_id' => $device2,
            'device_name' => 'Chrome Incognito',
        ]);
        $res3->assertSessionHasErrors('login');
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $member->id,
            'event' => 'LOGIN_REJECTED_DEVICE_MISMATCH',
        ]);

        // 4. Admin resets device binding
        $admin = User::where('role', 'admin')->first();
        $resReset = $this->actingAs($admin)->post(route('admin.customers.reset-device', $member->id));
        $resReset->assertSessionHas('success');
        $member->refresh();
        $this->assertNull($member->device_id);
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $member->id,
            'event' => 'DEVICE_RESET',
        ]);

        auth()->logout();

        // 5. New browser profile can now bind
        $res5 = $this->post(route('login.store'), [
            'login' => 'testkunde',
            'password' => 'KundeTest2026!',
            'device_id' => $device2,
            'device_name' => 'Chrome Incognito (Now Allowed)',
        ]);
        $res5->assertRedirect(route('member.dashboard'));
        $member->refresh();
        $this->assertEquals($device2, $member->device_id);

        // Reset testkunde back to null
        $member->update(['device_id' => null]);
    }

    /**
     * PRIORITY 5 & 20: Timer 5 Input Fields & Strict 3-Entry FIFO Rotation Test
     */
    public function test_timer_five_input_fields_and_rotation_rule(): void
    {
        $admin = User::where('role', 'admin')->first();
        $this->actingAs($admin);

        $savedIds = [];

        // Run 5 measurements sequentially
        for ($m = 1; $m <= 5; $m++) {
            $startRes = $this->postJson(route('time-tracking.start'), [
                'activity_1' => "Measurement {$m} - Field 1",
                'activity_2' => "Measurement {$m} - Field 2",
                'activity_3' => "Measurement {$m} - Field 3",
                'activity_4' => "Measurement {$m} - Field 4",
                'activity_5' => "Measurement {$m} - Field 5",
            ]);
            $startRes->assertStatus(200);
            $entry = $startRes->json('entry');
            $savedIds[$m] = $entry['id'];

            // Check 5 fields in DB
            $dbEntry = TimeEntry::find($entry['id']);
            $this->assertEquals("Measurement {$m} - Field 1", $dbEntry->activity_1);
            $this->assertEquals("Measurement {$m} - Field 2", $dbEntry->activity_2);
            $this->assertEquals("Measurement {$m} - Field 3", $dbEntry->activity_3);
            $this->assertEquals("Measurement {$m} - Field 4", $dbEntry->activity_4);
            $this->assertEquals("Measurement {$m} - Field 5", $dbEntry->activity_5);

            $stopRes = $this->postJson(route('time-tracking.stop.active'));
            $stopRes->assertStatus(200);

            $stored = TimeEntry::where('user_id', $admin->id)
                ->where('status', 'stopped')
                ->orderByDesc('ended_at')
                ->orderByDesc('id')
                ->get();

            if ($m === 1) {
                $this->assertCount(1, $stored);
                $this->assertEquals([$savedIds[1]], $stored->pluck('id')->toArray());
            } elseif ($m === 2) {
                $this->assertCount(2, $stored);
                $this->assertEquals([$savedIds[2], $savedIds[1]], $stored->pluck('id')->toArray());
            } elseif ($m === 3) {
                $this->assertCount(3, $stored);
                $this->assertEquals([$savedIds[3], $savedIds[2], $savedIds[1]], $stored->pluck('id')->toArray());
            } elseif ($m === 4) {
                // Measurement 4 completed -> Measurement 1 must be deleted!
                $this->assertCount(3, $stored);
                $this->assertFalse($stored->contains('id', $savedIds[1]), "Measurement 1 MUST be deleted from DB!");
                $this->assertEquals([$savedIds[4], $savedIds[3], $savedIds[2]], $stored->pluck('id')->toArray());
            } elseif ($m === 5) {
                // Measurement 5 completed -> Measurement 2 must be deleted!
                $this->assertCount(3, $stored);
                $this->assertFalse($stored->contains('id', $savedIds[1]), "Measurement 1 already deleted");
                $this->assertFalse($stored->contains('id', $savedIds[2]), "Measurement 2 MUST be deleted from DB!");
                $this->assertEquals([$savedIds[5], $savedIds[4], $savedIds[3]], $stored->pluck('id')->toArray());
            }
        }
    }

    /**
     * PRIORITY 2 & 3: Audio & PDF Protected Media Access
     */
    public function test_audio_and_pdf_protected_media_access(): void
    {
        $member = User::where('username', 'testkunde')->first();
        $course = Course::where('slug', 'dnl-kompakt')->first();
        $lesson = $course->lessons()->first();

        // 1. Unauthenticated guest -> 403 / redirect
        auth()->logout();
        $guestRes = $this->get(route('media.stream', [
            'courseSlug' => $course->slug,
            'lessonSlug' => $lesson->slug,
            'type' => 'audio',
        ]));
        $guestRes->assertRedirect(route('login'));

        // 2. Member enrolled -> 200 with audio/mpeg
        $this->actingAs($member);
        $audioRes = $this->get(route('media.stream', [
            'courseSlug' => $course->slug,
            'lessonSlug' => $lesson->slug,
            'type' => 'audio',
        ]));
        $audioRes->assertStatus(200);
        $audioRes->assertHeader('Content-Type', 'audio/mpeg');
        $audioRes->assertHeader('Accept-Ranges', 'bytes');

        // 3. Member enrolled -> 200 with application/pdf watermarked
        $pdfRes = $this->get(route('media.stream', [
            'courseSlug' => $course->slug,
            'lessonSlug' => $lesson->slug,
            'type' => 'pdf',
        ]));
        $pdfRes->assertStatus(200);
        $pdfRes->assertHeader('Content-Type', 'application/pdf');
        $content = $pdfRes->getContent();
        $this->assertStringStartsWith('%PDF', $content);
    }
}
