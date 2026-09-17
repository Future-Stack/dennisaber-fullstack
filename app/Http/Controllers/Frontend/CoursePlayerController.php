<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoursePlayerController extends Controller
{
    public function showCourse(Request $request, string $slug)
    {
        $slug = str_replace('_', '-', $slug);
        $defaultStep = ($slug === 'rio-negro-2002') ? 1 : 0;
        $step = $request->has('step') ? (int) $request->query('step') : $defaultStep;
        return $this->renderPlayer($request, $slug, $step);
    }

    public function showLesson(Request $request, string $courseSlug, string $lessonSlug)
    {
        $courseSlug = str_replace('_', '-', $courseSlug);
        $course = Course::where('slug', $courseSlug)->firstOrFail();
        $lessons = $course->lessons()->orderBy('order')->get();

        $step = 0;
        foreach ($lessons as $idx => $l) {
            if ($l->slug === $lessonSlug) {
                $step = $idx + 1;
                break;
            }
        }

        return $this->renderPlayer($request, $courseSlug, $step);
    }

    private function renderPlayer(Request $request, string $slug, int $initialStep = 0)
    {
        $slug = str_replace('_', '-', $slug);
        if ($slug === 'rio-negro-2002' && $initialStep === 0) {
            $initialStep = 1;
        }

        $course = Course::with(['lessons' => function ($query) {
            $query->orderBy('order');
        }])->where('slug', $slug)->firstOrFail();

        $user = Auth::user();

        // Admin preview or enrollment verification
        $isAdminPreview = ($user && $user->isAdmin()) || $request->has('admin_preview') || session('admin_preview');
        if ($user && ! $user->isEnrolledIn($course) && ! $isAdminPreview) {
            return redirect()->route('member.dashboard')
                ->with('error', "Zugriff verweigert: Sie haben keine aktive Freischaltung für diesen Kurs.");
        }

        // Customer details for license box and watermark
        $customerName = $isAdminPreview ? 'Administrator-Prüfansicht' : ($user ? ($user->first_name ?: $user->name) : 'TESTKUNDE');
        $customerInvoice = $isAdminPreview ? 'ADMIN-PRÜFANSICHT' : ($user ? ($user->invoice_number ?: 'TEST-2026') : 'KUNDENNR. TEST-2026');
        $expiresAtText = $isAdminPreview ? '1. Januar 2100' : ($course->duration_days ? now()->addDays($course->duration_days)->format('d.m.Y') : '1. Januar 2100');

        // Exact Course Headings from Reference Platform
        $courseHeadings = [
            'dnl-kompakt' => 'Fünf Tage. Dreißig Einheiten. Ein System.',
            'dnl-vertiefung' => 'Vier Wochen. Dreißig Einheiten. Nachhaltiger Transfer.',
            'erfolgreich-gruenden' => 'Drei Tage. Vierzehn Kapitel. Dein vollständiger Unternehmensbauplan.',
            'klar-entscheiden' => 'Acht Module. Eine reale Entscheidung. Dein persönliches System.',
            'rauchfrei' => 'Zwölf Wochen. Siebenundzwanzig Audios. Dein persönlicher Dauerplan.',
            'stress-und-ressourcen' => 'Zehn Einheiten. Eigene Muster erkennen. Ressourcen aktivieren.',
            'rio-negro-2002' => 'Hören. Entscheiden. Vergleichen.',
            'presse-oeffentlichkeit' => 'Drei Lerntage. Vierundzwanzig Einheiten. Ihre vollständige Pressearbeitsstruktur.',
            'ernaehrung' => 'Zehn Einheiten. Vierzig Kursplätze. Vier Hilfen für akute Situationen.',
            'dnl-premium' => '30 Audioeinheiten · Executive Workbook · Direktkontakt',
            'rhetorik-unter-druck' => 'Zehn Einheiten. Praxisnahe Rhetorik unter Druck.',
        ];
        $courseHeading = $courseHeadings[$course->slug] ?? ($course->lessons->count() . ' Einheiten. Ein verbindliches System.');

        // Determine Category aesthetics
        $categoryClass = 'cat-academy';
        $categoryLabel = 'DNL-Akademie';
        $categoryColor = '#2460a0';

        if ($course->slug === 'rio-negro-2002') {
            $categoryClass = 'cat-adventure';
            $categoryLabel = 'Audio-Abenteuer';
            $categoryColor = '#c83828';
        } elseif (in_array($course->slug, ['stress-und-ressourcen', 'rauchfrei', 'ernaehrung', 'klar-entscheiden'])) {
            $categoryClass = 'cat-prevention';
            $categoryLabel = 'Prävention & Gesundheit';
            $categoryColor = '#4a7a2a';
        } elseif (in_array($course->slug, ['erfolgreich-gruenden', 'presse-oeffentlichkeit', 'rhetorik-unter-druck'])) {
            $categoryClass = 'cat-business';
            $categoryLabel = 'Unternehmer & Wirkung';
            $categoryColor = '#dc7814';
        }

        // Extract units data
        $units = [];
        foreach ($course->lessons as $lesson) {
            $data = json_decode($lesson->content_html, true);
            if (! is_array($data)) {
                $data = [];
            }
            $data['number'] = $data['number'] ?? (string) ($lesson->lesson_number ?: ($lesson->order ?: count($units) + 1));
            $data['title'] = $data['title'] ?? ($lesson->title ?: 'Einheit ' . (count($units) + 1));
            $data['duration'] = $data['duration'] ?? ($lesson->duration_minutes ? $lesson->duration_minutes . ' Min.' : '');
            $data['summary'] = $data['summary'] ?? ($lesson->chapter_name ?: 'Originaleinheit aus dem Lehrgang.');
            $data['task'] = $data['task'] ?? 'Bearbeite die Aufgaben im Kundenarbeitsbuch.';

            $hasAudio = !empty($lesson->audio_path) || !empty($data['audio']);
            $data['audio'] = $hasAudio
                ? route('media.stream', ['courseSlug' => $course->slug, 'lessonSlug' => $lesson->slug, 'type' => 'audio'])
                : null;
            $data['pdf_name'] = $lesson->pdf_attachment_name ?: ($data['pdf_name'] ?? 'Begleitendes_Arbeitsblatt.pdf');
            $data['pdf_url'] = route('media.stream', ['courseSlug' => $course->slug, 'lessonSlug' => $lesson->slug, 'type' => 'pdf']);
            $units[] = $data;
        }

        // Exact units count label from Reference CourseStepper
        $unitsCountText = match($course->slug) {
            'presse-oeffentlichkeit' => '24 Einheiten · 24 vollständige Audios',
            'erfolgreich-gruenden' => '14 Kapitel · 12 Audios · 2 Praxisstationen',
            'ernaehrung' => '36 Audios · 8 Praxisstationen · Arbeitsbuch',
            'dnl-premium' => '30 Audioeinheiten · Executive Workbook · Direktkontakt',
            default => count($units) . ' vollständige Einheiten',
        };

        // Determine workbook mapping
        $workbookConfig = [
            'dnl-kompakt' => ['slug' => 'dnl-executive', 'pages' => 37, 'title' => 'Vollständiges Executive Workbook · 37 Seiten', 'eyebrow' => 'Executive Workbook V5.2'],
            'dnl-vertiefung' => ['slug' => 'dnl-vertiefung', 'pages' => 48, 'title' => 'DNL Vertiefungsausbildung · Release 1.0 · 48 Seiten', 'eyebrow' => 'Vertiefungsausbildung V1.0'],
            'dnl-premium' => ['slug' => 'dnl-executive', 'pages' => 37, 'title' => 'Executive Workbook · 37 Seiten', 'eyebrow' => 'Executive Workbook V5.2'],
            'erfolgreich-gruenden' => ['slug' => 'erfolgreich-gruenden', 'pages' => 71, 'title' => 'Premium-Unternehmerkurs · Arbeitsbuch · 71 Seiten', 'eyebrow' => 'Gründer-Workbook V1.0'],
            'klar-entscheiden' => ['slug' => 'klar-entscheiden', 'pages' => 104, 'title' => 'Klar entscheiden · ausfüllbares Arbeitsbuch · 104 Seiten', 'eyebrow' => 'Entscheidungs-Kompass V3.0'],
            'rauchfrei' => ['slug' => 'rauchfrei', 'pages' => 71, 'title' => 'GESUND VORAUS · Rauchstopp · Arbeitsbuch V2.0 · 71 Seiten', 'eyebrow' => 'Rauchstopp-Workbook V2.0'],
            'stress-und-ressourcen' => ['slug' => 'stress-und-ressourcen', 'pages' => 22, 'title' => 'Arbeitsbuch Stress und Ressourcen · Version 1.0 · 22 Seiten', 'eyebrow' => 'Stress & Ressourcen V1.0'],
            'rio-negro-2002' => ['slug' => 'rio-negro-2002', 'pages' => 32, 'title' => '12 Originaletappen · Bonusaufgaben · persönliche Auswertung', 'eyebrow' => 'Expeditionsbuch V1.0'],
            'ernaehrung' => ['slug' => 'ernaehrung', 'pages' => 35, 'title' => 'KLAR ESSEN · Kundenarbeitsbuch · 35 Seiten', 'eyebrow' => 'KLAR ESSEN V1.0'],
            'presse-oeffentlichkeit' => ['slug' => 'presse-oeffentlichkeit', 'pages' => 56, 'title' => 'DNL Pressearbeit · Premium-Arbeitsbuch V1.2 · 56 Seiten', 'eyebrow' => 'DNL Pressearbeit V1.2'],
            'rhetorik-unter-druck' => ['slug' => 'rhetorik-unter-druck', 'pages' => 20, 'title' => 'Digitales Arbeitsmaterial', 'eyebrow' => 'Rhetorik-Trainingshandbuch'],
        ];

        $wb = $workbookConfig[$course->slug] ?? ['slug' => $course->slug, 'pages' => 30, 'title' => 'Digitales Arbeitsmaterial', 'eyebrow' => 'Arbeitsmaterial'];
        $workbookSlug = $wb['slug'];
        $workbookPages = $wb['pages'];
        $workbookTitle = $wb['title'];
        $workbookEyebrow = $wb['eyebrow'];

        $accessText = ($course->slug === 'rio-negro-2002') ? '30 Tage ab Freischaltung' : 'Drei Monate ab Freischaltung';

        return view('frontend.pages.course.player', compact(
            'course',
            'units',
            'initialStep',
            'user',
            'isAdminPreview',
            'customerName',
            'customerInvoice',
            'expiresAtText',
            'categoryClass',
            'categoryLabel',
            'categoryColor',
            'workbookSlug',
            'workbookPages',
            'workbookTitle',
            'workbookEyebrow',
            'accessText',
            'courseHeading',
            'unitsCountText'
        ));
    }

    public function toggleComplete(Request $request, string $courseSlug, string $lessonSlug)
    {
        $course = Course::where('slug', $courseSlug)->firstOrFail();
        $lesson = $course->lessons()->where('slug', $lessonSlug)->firstOrFail();
        $user = Auth::user();

        if (! $user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $progress = LessonProgress::firstOrNew([
            'user_id' => $user->id,
            'lesson_id' => $lesson->id,
            'course_id' => $course->id,
        ]);

        $newStatus = ! $progress->is_completed;
        $progress->is_completed = $newStatus;
        $progress->completed_at = $newStatus ? now() : null;
        $progress->save();

        $newPercentage = $course->getProgressForUser($user);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'is_completed' => $newStatus,
                'progress_percent' => $newPercentage,
                'message' => $newStatus ? 'Lektion als abgeschlossen markiert.' : 'Lektion wieder als offen markiert.',
            ]);
        }

        return back()->with('success', $newStatus ? 'Lektion als abgeschlossen markiert.' : 'Lektion wieder als offen markiert.');
    }
}
