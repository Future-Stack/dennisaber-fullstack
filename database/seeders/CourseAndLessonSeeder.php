<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseAndLessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('data/all_courses_extracted.json');
        if (! file_exists($jsonPath)) {
            $this->command?->error("JSON file not found at: {$jsonPath}");
            return;
        }

        $coursesData = json_decode(file_get_contents($jsonPath), true);
        if (! is_array($coursesData)) {
            $this->command?->error("Invalid JSON data in {$jsonPath}");
            return;
        }

        // Exact order from reference portal (https://besseler-kursportal.dennis-bes.chatgpt.site/verwaltung)
        $referenceCourseOrder = [
            'dnl-kompakt',
            'dnl-vertiefung',
            'dnl-premium',
            'stress-und-ressourcen',
            'rauchfrei',
            'ernaehrung',
            'klar-entscheiden',
            'erfolgreich-gruenden',
            'presse-oeffentlichkeit',
            'rhetorik-unter-druck',
            'rio-negro-2002',
        ];

        // Delete rogue/archive courses not belonging to the 11 official portal courses
        Course::whereNotIn('slug', $referenceCourseOrder)->delete();

        $order = 1;
        $allCreatedCourses = [];

        foreach ($referenceCourseOrder as $slug) {
            if (! isset($coursesData[$slug])) {
                continue;
            }
            $c = $coursesData[$slug];
            $units = $c['units'] ?? [];
            $unitsCount = count($units);

            $course = Course::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $c['catalogTitle'] ?? Str::headline($slug),
                    'slug' => $slug,
                    'category' => $c['categoryLabel'] ?? 'Allgemein',
                    'subtitle' => ($c['access'] ?? '') . ' · ' . ($c['workbook'] ?? ''),
                    'description' => "Vollständiger Online-Kurs mit {$unitsCount} Einheiten und digitalem Arbeitsmaterial.",
                    'thumbnail' => "/frontend/assets/{$slug}-thumb.jpg",
                    'duration_days' => ($slug === 'rio-negro-2002') ? 30 : 120,
                    'total_hours' => "{$unitsCount} Einheiten",
                    'public_url' => "/kurse/{$slug}",
                    'order' => $order++,
                    'is_published' => true,
                ]
            );

            $allCreatedCourses[] = $course;

            // Delete old lessons for this course to ensure clean 1:1 state
            Lesson::where('course_id', $course->id)->delete();

            foreach ($units as $index => $u) {
                $lessonNumber = $index + 1;
                $unitNumber = $u['number'] ?? (string) $lessonNumber;
                $unitTitle = $u['title'] ?? "Einheit {$unitNumber}";

                // Parse duration
                $durationMinutes = 1;
                if (! empty($u['duration'])) {
                    if (preg_match('/(\d+):(\d+)/', $u['duration'], $m)) {
                        $durationMinutes = (int) $m[1] + ((int) $m[2] > 30 ? 1 : 0);
                    } elseif (preg_match('/(\d+)/', $u['duration'], $m)) {
                        $durationMinutes = (int) $m[1];
                    }
                }

                // Audio path
                $audioPath = null;
                if (! empty($u['audio']) && ! str_contains($u['audio'], 'undefined')) {
                    $rawAudio = ltrim($u['audio'], '/');
                    if (file_exists(public_path($rawAudio))) {
                        $audioPath = $rawAudio;
                    }
                }
                if (! $audioPath) {
                    $audioDir = public_path("audio/{$slug}");
                    if (file_exists($audioDir)) {
                        $files = glob($audioDir . '/*.mp3');
                        if (!empty($files)) {
                            $audioPath = "audio/{$slug}/" . basename($files[$index % count($files)]);
                        }
                    }
                }

                // Create lesson slug
                $lessonSlug = ($index === 0 && $slug === 'dnl-kompakt') 
                    ? 'einfuehrung-und-orientierung' 
                    : Str::slug("{$unitNumber}-{$unitTitle}");
                if (empty($lessonSlug)) {
                    $lessonSlug = "einheit-{$lessonNumber}";
                }

                $companionPdfsByCourse = [
                    'dnl-kompakt' => ['path' => 'materials/01_Uebersicht_und_Lernleitfaden.pdf', 'name' => '01_Uebersicht_und_Lernleitfaden.pdf'],
                    'dnl-vertiefung' => ['path' => 'materials/klar-entscheiden-arbeitsbuch57bd.pdf', 'name' => 'DNL_Vertiefung_Arbeitsbuch.pdf'],
                    'dnl-premium' => ['path' => 'materials/abenteuer-expeditionsbuch-probe57bd.pdf', 'name' => 'DNL_Premium_Workbook.pdf'],
                    'stress-und-ressourcen' => ['path' => 'materials/stress-arbeitsbuch-probe57bd.pdf', 'name' => 'Stress_und_Ressourcen_Arbeitsbuch.pdf'],
                    'rauchfrei' => ['path' => 'materials/rauchfrei-arbeitsbuch-probe57bd.pdf', 'name' => 'Rauchstopp_Arbeitsbuch_Probe.pdf'],
                    'ernaehrung' => ['path' => 'materials/ernaehrung-arbeitsbuch-probe57bd.pdf', 'name' => 'Klar_Essen_Arbeitsbuch_Probe.pdf'],
                    'klar-entscheiden' => ['path' => 'materials/klar-entscheiden-arbeitsbuch57bd.pdf', 'name' => 'Klar_Entscheiden_Arbeitsbuch.pdf'],
                    'erfolgreich-gruenden' => ['path' => 'materials/gruenden-arbeitsbuch-probe57bd.pdf', 'name' => 'Erfolgreich_Gruenden_Arbeitsbuch.pdf'],
                    'presse-oeffentlichkeit' => ['path' => 'materials/presse-arbeitsbuch-probe.pdf', 'name' => 'Presse_Arbeitsbuch_Probe.pdf'],
                    'rhetorik-unter-druck' => ['path' => 'materials/rhetorik-arbeitsbuch-probe.pdf', 'name' => 'Rhetorik_Arbeitsbuch_Probe.pdf'],
                    'rio-negro-2002' => ['path' => 'materials/abenteuer-expeditionsbuch-probe57bd.pdf', 'name' => 'Rio_Negro_Expeditionsbuch.pdf'],
                ];
                $comp = $companionPdfsByCourse[$slug] ?? ['path' => 'materials/01_Uebersicht_und_Lernleitfaden.pdf', 'name' => 'Begleitendes_Arbeitsblatt.pdf'];
                $pdfName = $comp['name'];
                $pdfPath = $comp['path'];

                Lesson::create([
                    'course_id' => $course->id,
                    'chapter_name' => "Einheit {$unitNumber}",
                    'title' => $unitTitle,
                    'slug' => $lessonSlug,
                    'lesson_number' => $lessonNumber,
                    'duration_minutes' => max(1, $durationMinutes),
                    'video_url' => null,
                    'video_path' => null,
                    'pdf_attachment_name' => $pdfName,
                    'pdf_attachment_path' => $pdfPath,
                    'audio_path' => $audioPath,
                    'is_preview' => ($index === 0),
                    'order' => $lessonNumber,
                    'content_html' => json_encode($u, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                ]);
            }
        }

        // Enroll test member in all courses
        $member = User::where('username', 'testkunde')->first();
        if ($member) {
            foreach ($allCreatedCourses as $course) {
                Enrollment::updateOrCreate(
                    ['user_id' => $member->id, 'course_id' => $course->id],
                    [
                        'invoice_number' => $member->invoice_number ?: 'RE-2026-001',
                        'started_at' => now()->subDays(5)->toDateString(),
                        'expires_at' => now()->addDays($course->duration_days)->toDateString(),
                        'is_active' => true,
                        'early_start_agreed' => true,
                    ]
                );
            }
        }

        // Enroll admin user in all courses
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            foreach ($allCreatedCourses as $course) {
                Enrollment::updateOrCreate(
                    ['user_id' => $admin->id, 'course_id' => $course->id],
                    [
                        'invoice_number' => 'ADMIN-PRÜFANSICHT',
                        'started_at' => now()->toDateString(),
                        'expires_at' => now()->addYears(50)->toDateString(),
                        'is_active' => true,
                        'early_start_agreed' => true,
                    ]
                );
            }
        }
    }
}
