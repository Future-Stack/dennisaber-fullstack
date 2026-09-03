<?php

namespace Database\Seeders;

use App\Models\AccessRequest;
use App\Models\AdminNote;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\User;
use App\Models\VersionNote;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Admin User (Dennis Besseler)
        $admin = User::create([
            'name' => 'Dennis Besseler',
            'first_name' => 'Dennis',
            'username' => 'dennis.besseler',
            'email' => 'dennis@besseler.de',
            'password' => Hash::make('TestTestTest00!'),
            'role' => 'admin',
            'security_code_hash' => Hash::make('1979'),
            'security_code_expires_at' => null,
            'is_active' => true,
        ]);

        // 2. Seed Test Member User (Max Mustermann)
        $member = User::create([
            'name' => 'Max Mustermann',
            'first_name' => 'Max',
            'username' => 'testkunde',
            'email' => 'kunde@besseler.de',
            'password' => Hash::make('KundeTest2026!'),
            'role' => 'member',
            'invoice_number' => 'RE-2026-001',
            'is_active' => true,
        ]);

        // 3. Seed Staff User (Sarah Kundenservice)
        $staff = User::create([
            'name' => 'Sarah Schmidt',
            'first_name' => 'Sarah',
            'username' => 'sarah.service',
            'email' => 'sarah@besseler.de',
            'password' => Hash::make('Mitarbeiter2026!'),
            'role' => 'staff',
            'occupation' => 'Kundenservice & Freigaben',
            'access_from' => now()->subDays(5)->toDateString(),
            'access_until' => now()->addDays(30)->toDateString(),
            'permissions' => [
                'view_customers' => true,
                'create_customers' => true,
                'manage_enrollments' => true,
                'reset_passwords' => true,
            ],
            'is_active' => true,
        ]);

        // 4. Seed All 11 Courses
        $coursesData = [
            [
                'title' => '5-Tage-Kompaktlehrgang',
                'slug' => 'dnl-kompakt',
                'category' => 'Akademie / Bildungsurlaub',
                'subtitle' => 'DNL Kompakt — Kompakte Qualifikation & praxisnahe Methodik',
                'description' => 'Der 5-Tage-Kompaktlehrgang vermittelt in komprimierter Form die zentralen Werkzeuge für gelingende Kommunikation, systemische Analyse und persönliche Wirksamkeit.',
                'thumbnail' => '/frontend/assets/kompakt-thumb.jpg',
                'duration_days' => 120,
                'total_hours' => '40 Unterrichtsstunden',
                'public_url' => 'https://www.besseler.de',
                'order' => 1,
                'is_published' => true,
            ],
            [
                'title' => 'Vertiefungsausbildung',
                'slug' => 'dnl-vertiefung',
                'category' => 'Akademie',
                'subtitle' => 'Fortgeschrittene Techniken und Vertiefung',
                'description' => 'Aufbauend auf dem Kompaktlehrgang vertieft diese Ausbildung die methodischen Kompetenzen in Beratung und Gesprächsführung.',
                'thumbnail' => '/frontend/assets/vertiefung-thumb.jpg',
                'duration_days' => 120,
                'total_hours' => '60 Unterrichtsstunden',
                'public_url' => 'https://www.besseler.de',
                'order' => 2,
                'is_published' => true,
            ],
            [
                'title' => 'Premium-Seminar',
                'slug' => 'dnl-premium',
                'category' => 'Akademie',
                'subtitle' => 'Exklusives Intensivseminar mit individuellem Mentoring',
                'description' => 'Das Premium-Seminar für Führungskräfte und Entscheidungsträger mit maximalem Praxisbezug.',
                'thumbnail' => '/frontend/assets/premium-thumb.jpg',
                'duration_days' => 120,
                'total_hours' => '80 Unterrichtsstunden',
                'public_url' => 'https://www.besseler.de',
                'order' => 3,
                'is_published' => true,
            ],
            [
                'title' => 'Stress und Ressourcen',
                'slug' => 'stress-und-ressourcen',
                'category' => 'Prävention',
                'subtitle' => 'Widerstandskraft stärken und Stress nachhaltig abbauen',
                'description' => 'Wissenschaftlich fundierte Strategien zur Stressbewältigung und Aktivierung persönlicher Ressourcen.',
                'thumbnail' => '/frontend/assets/stress-thumb.jpg',
                'duration_days' => 120,
                'total_hours' => '20 Unterrichtsstunden',
                'public_url' => 'https://www.besseler.de',
                'order' => 4,
                'is_published' => true,
            ],
            [
                'title' => 'Rauchfrei',
                'slug' => 'rauchfrei',
                'category' => 'Prävention',
                'subtitle' => 'Schritt für Schritt rauchfrei leben',
                'description' => 'Verhaltenstherapeutisch orientiertes Programm für dauerhafte Tabak- und Nikotinfreiheit.',
                'thumbnail' => '/frontend/assets/rauchfrei-thumb.jpg',
                'duration_days' => 120,
                'total_hours' => '15 Unterrichtsstunden',
                'public_url' => 'https://www.besseler.de',
                'order' => 5,
                'is_published' => true,
            ],
            [
                'title' => 'Ernährung',
                'slug' => 'ernaehrung',
                'category' => 'Prävention',
                'subtitle' => 'Gesunde Ernährung im Alltag etablieren',
                'description' => 'Praktischer Leitfaden für alltagstaugliche und typgerechte Ernährungsoptimierung.',
                'thumbnail' => '/frontend/assets/ernaehrung-thumb.jpg',
                'duration_days' => 120,
                'total_hours' => '15 Unterrichtsstunden',
                'public_url' => 'https://www.besseler.de',
                'order' => 6,
                'is_published' => true,
            ],
            [
                'title' => 'Klar entscheiden',
                'slug' => 'klar-entscheiden',
                'category' => 'Prävention & Führung',
                'subtitle' => 'Entscheidungskompetenz in komplexen Lagen',
                'description' => 'Systematische Entscheidungsfindung unter Zeitdruck und Unsicherheit.',
                'thumbnail' => '/frontend/assets/entscheiden-thumb.jpg',
                'duration_days' => 120,
                'total_hours' => '12 Unterrichtsstunden',
                'public_url' => 'https://www.besseler.de',
                'order' => 7,
                'is_published' => true,
            ],
            [
                'title' => 'Erfolgreich gründen',
                'slug' => 'erfolgreich-gruenden',
                'category' => 'Business',
                'subtitle' => 'Vom Konzept zum tragfähigen Geschäftsmodell',
                'description' => 'Praxiswissen für Solopreneure und Gründer: Positionierung, Vertrieb und Struktur.',
                'thumbnail' => '/frontend/assets/gruenden-thumb.jpg',
                'duration_days' => 120,
                'total_hours' => '30 Unterrichtsstunden',
                'public_url' => 'https://www.besseler.de',
                'order' => 8,
                'is_published' => true,
            ],
            [
                'title' => 'Presse & Öffentlichkeit',
                'slug' => 'presse-oeffentlichkeit',
                'category' => 'Kommunikation',
                'subtitle' => 'Gezielte Medienarbeit und professionelle Außenwirkung',
                'description' => 'Pressemitteilungen schreiben, Journalistenkontakte aufbauen und Krisenkommunikation meistern.',
                'thumbnail' => '/frontend/assets/presse-thumb.jpg',
                'duration_days' => 120,
                'total_hours' => '20 Unterrichtsstunden',
                'public_url' => 'https://www.besseler.de',
                'order' => 9,
                'is_published' => true,
            ],
            [
                'title' => 'Rhetorik unter Druck',
                'slug' => 'rhetorik-unter-druck',
                'category' => 'Kommunikation',
                'subtitle' => 'Souverän argumentieren in schwierigen Verhandlungssituationen',
                'description' => 'Schlagfertigkeit, Körpersprache und Deeskalationstechniken in anspruchsvollen Gesprächen.',
                'thumbnail' => '/frontend/assets/rhetorik-thumb.jpg',
                'duration_days' => 120,
                'total_hours' => '15 Unterrichtsstunden',
                'public_url' => 'https://www.besseler.de',
                'order' => 10,
                'is_published' => true,
            ],
            [
                'title' => 'Rio Negro 2002',
                'slug' => 'rio-negro-2002',
                'category' => 'Spezial / Audio',
                'subtitle' => 'Das interaktive Audio-Entscheidungs-Erlebnis',
                'description' => 'Ein didaktisch einzigartiges Audio-Erlebnis zum Trainieren intuitiver und strategischer Entscheidungen.',
                'thumbnail' => '/frontend/assets/rionegro-thumb.jpg',
                'duration_days' => 30,
                'total_hours' => '10 Unterrichtsstunden',
                'public_url' => 'https://www.besseler.de',
                'order' => 11,
                'is_published' => true,
            ],
        ];

        $courses = [];
        foreach ($coursesData as $c) {
            $courses[$c['slug']] = Course::create($c);
        }

        // 5. Seed Comprehensive Lessons for Test Course (dnl-kompakt)
        $kompaktCourse = $courses['dnl-kompakt'];

        $lessonsData = [
            [
                'course_id' => $kompaktCourse->id,
                'chapter_name' => 'Modul 1: Grundlagen & Einführung',
                'title' => '1. Einführung in den 5-Tage-Kompaktlehrgang',
                'slug' => 'einfuehrung-und-orientierung',
                'lesson_number' => 1,
                'duration_minutes' => 18,
                'video_url' => null,
                'video_path' => null,
                'pdf_attachment_name' => '01_Uebersicht_und_Lernleitfaden.pdf',
                'pdf_attachment_path' => 'materials/DjtP2gYwdR7gFgq6mB3z3LpeCymMZms5WmWxli5h.pdf',
                'audio_path' => 'audio/SMdGRmsH0Z5eaFJnHcOo3VWWz9FLpT1drtPy8Ccc.wav',
                'is_preview' => true,
                'order' => 1,
                'content_html' => '<h3>Willkommen zum 5-Tage-Kompaktlehrgang</h3>
<p>In dieser ersten Lektion verschaffen wir uns einen vollständigen Überblick über den Ablauf, die didaktische Struktur sowie die angestrebten Lernziele des Lehrgangs.</p>
<h4>Kerninhalte der Lektion:</h4>
<ul>
    <li>Struktur des Lehrgangs und empfohlener Lernrhythmus</li>
    <li>Die Grundannahmen der systemischen Gesprächsführung</li>
    <li>Einrichtung Ihres persönlichen Studienarbeitsplatzes</li>
    <li>Nutzung der begleitenden Arbeitsblätter und Reflexionsbögen</li>
</ul>
<div class="note-box" style="background: rgba(56, 189, 248, 0.1); border-left: 4px solid #38bdf8; padding: 1rem; border-radius: 4px; margin: 1rem 0;">
    <strong>Wichtiger Hinweis:</strong> Bitte nutzen Sie das direkt unten eingebettete Arbeitsbuch für Ihre praktischen Notizen und Reflexionsübungen.
</div>',
            ],
            [
                'course_id' => $kompaktCourse->id,
                'chapter_name' => 'Modul 1: Grundlagen & Einführung',
                'title' => '2. Wahrnehmung, Rapport und Kommunikationsmuster',
                'slug' => 'wahrnehmung-und-rapport',
                'lesson_number' => 2,
                'duration_minutes' => 25,
                'video_url' => null,
                'video_path' => null,
                'pdf_attachment_name' => '02_Arbeitsblatt_Rapport_und_Wahrnehmung.pdf',
                'pdf_attachment_path' => 'materials/K88JPYZ8688tNOe3K7n6O0tzk5jN8FM0RutZaZd5.pdf',
                'audio_path' => 'audio/w5RTq6i8FMgDxZC9UAeEUsgnk1IS2hl0L8aodp2T.wav',
                'is_preview' => false,
                'order' => 2,
                'content_html' => '<h3>Wahrnehmung und Rapport in der Praxis</h3>
<p>Erfolgreiche Kommunikation beginnt mit präziser Beobachtung. In diesem Modul trainieren wir die Fähigkeit, nonverbale Signale sensibel wahrzunehmen und einen tragfähigen Rapport aufzubauen.</p>
<h4>Schwerpunkte:</h4>
<ul>
    <li>Kalibrieren: Feinheiten in Mimik, Gestik und Stimmlage deuten</li>
    <li>Pacing & Leading: Den Gesprächspartner abholen und zielgerichtet leiten</li>
    <li>Vermeidung typischer Kommunikationsfallen und unbewusster Blockaden</li>
</ul>',
            ],
            [
                'course_id' => $kompaktCourse->id,
                'chapter_name' => 'Modul 2: Werkzeuge & Interventionen',
                'title' => '3. Stressregulation und Ressourcen-Aktivierung',
                'slug' => 'stressregulation-und-ressourcen',
                'lesson_number' => 3,
                'duration_minutes' => 22,
                'video_url' => null,
                'video_path' => null,
                'pdf_attachment_name' => '03_Uebungsblatt_Ressourcen_Anker.pdf',
                'pdf_attachment_path' => 'materials/DjtP2gYwdR7gFgq6mB3z3LpeCymMZms5WmWxli5h.pdf',
                'audio_path' => 'audio/6rdxBBAcSuOaEy2NuoqQYOqxIBcBLTJha5NsxDnY.wav',
                'is_preview' => false,
                'order' => 3,
                'content_html' => '<h3>Stressregulation & mentale Ressourcen</h3>
<p>Wie bleiben wir auch in herausfordernden Momenten handlungsfähig? Diese Lektion widmet sich der gezielten Aktivierung mentaler Ressourcen und dem Setzen stabiler Anker.</p>
<h4>Praxisübungen:</h4>
<ul>
    <li>Die 4-7-8 Atemtechnik zur schnellen Beruhigung des vegetativen Nervensystems</li>
    <li>Erstellen einer persönlichen Ressourcen-Landkarte</li>
    <li>Anker-Technik: Positive emotionale Zustände gezielt abrufbar machen</li>
</ul>',
            ],
            [
                'course_id' => $kompaktCourse->id,
                'chapter_name' => 'Modul 2: Werkzeuge & Interventionen',
                'title' => '4. Fragetechniken und systemisches Reframing',
                'slug' => 'fragetechniken-und-reframing',
                'lesson_number' => 4,
                'duration_minutes' => 28,
                'video_url' => null,
                'video_path' => null,
                'pdf_attachment_name' => '04_Checkliste_Systemische_Fragen.pdf',
                'pdf_attachment_path' => 'materials/K88JPYZ8688tNOe3K7n6O0tzk5jN8FM0RutZaZd5.pdf',
                'audio_path' => 'audio/SMdGRmsH0Z5eaFJnHcOo3VWWz9FLpT1drtPy8Ccc.wav',
                'is_preview' => false,
                'order' => 4,
                'content_html' => '<h3>Systemische Fragetechniken & Umdeutung</h3>
<p>Wer fragt, der führt. Lernen Sie zirkuläre Fragen, Skalierungsfragen und das gezielte Reframing kennen, um festgefahrene Denkmuster aufzubrechen.</p>
<h4>Methodenübersicht:</h4>
<ul>
    <li>Zirkuläres Fragen: Perspektivwechsel gezielt anregen</li>
    <li>Kontext- und Bedeutungs-Reframing in Konfliktsituationen</li>
    <li>Die Wunderfrage nach Steve de Shazer</li>
</ul>',
            ],
            [
                'course_id' => $kompaktCourse->id,
                'chapter_name' => 'Modul 3: Praxistransfer & Abschluss',
                'title' => '5. Nachhaltiger Praxistransfer und Zertifikatsnachweis',
                'slug' => 'praxistransfer-und-abschluss',
                'lesson_number' => 5,
                'duration_minutes' => 20,
                'video_url' => null,
                'video_path' => null,
                'pdf_attachment_name' => '05_Leitfaden_Praxistransfer.pdf',
                'pdf_attachment_path' => 'materials/DjtP2gYwdR7gFgq6mB3z3LpeCymMZms5WmWxli5h.pdf',
                'audio_path' => 'audio/w5RTq6i8FMgDxZC9UAeEUsgnk1IS2hl0L8aodp2T.wav',
                'is_preview' => false,
                'order' => 5,
                'content_html' => '<h3>Abschluss und Umsetzung in den Berufsalltag</h3>
<p>Herzlichen Glückwunsch zum Erreichen des letzten Moduls! In dieser Lektion bündeln wir die erarbeiteten Erkenntnisse und entwickeln Ihren individuellen Umsetzungsplan für die kommenden 30 Tage.</p>
<h4>Abschlussschritte:</h4>
<ul>
    <li>Erstellung des persönlichen 30-Tage-Aktionsplans</li>
    <li>Kriterien für den Erhalt Ihrer Teilnahmebescheinigung</li>
    <li>Feedbackbogen und fortführende Lernempfehlungen</li>
</ul>',
            ],
        ];

        $createdLessons = [];
        foreach ($lessonsData as $l) {
            $createdLessons[] = Lesson::create($l);
        }

        // 6. Seed Lessons for Stress Course
        $stressCourse = $courses['stress-und-ressourcen'];
        Lesson::create([
            'course_id' => $stressCourse->id,
            'chapter_name' => 'Modul 1: Stress verstehen',
            'title' => '1. Die Neurobiologie von akutem und chronischem Stress',
            'slug' => 'neurobiologie-des-stresses',
            'lesson_number' => 1,
            'duration_minutes' => 20,
            'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',
            'video_path' => 'videos/stress-lektion-1.mp4',
            'pdf_attachment_name' => 'Stress_Selbstanalyse_Bogen.pdf',
            'pdf_attachment_path' => 'materials/Stress_Selbstanalyse_Bogen.pdf',
            'audio_path' => 'audio/SMdGRmsH0Z5eaFJnHcOo3VWWz9FLpT1drtPy8Ccc.wav',
            'is_preview' => true,
            'order' => 1,
            'content_html' => '<p>Wie wirkt Stress auf Körper und Geist? Erfahren Sie die biochemischen Abläufe der Stressachse.</p>',
        ]);

        Lesson::create([
            'course_id' => $stressCourse->id,
            'chapter_name' => 'Modul 1: Stress verstehen',
            'title' => '2. Individuelle Stressoren und Antreiber identifizieren',
            'slug' => 'stressoren-identifizieren',
            'lesson_number' => 2,
            'duration_minutes' => 24,
            'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4',
            'video_path' => 'videos/stress-lektion-2.mp4',
            'pdf_attachment_name' => 'Innere_Antreiber_Test.pdf',
            'pdf_attachment_path' => 'materials/Innere_Antreiber_Test.pdf',
            'audio_path' => 'audio/w5RTq6i8FMgDxZC9UAeEUsgnk1IS2hl0L8aodp2T.wav',
            'is_preview' => false,
            'order' => 2,
            'content_html' => '<p>Die 5 inneren Antreiber: Sei perfekt, sei schnell, streng dich an, mach es allen recht, sei stark.</p>',
        ]);

        Lesson::create([
            'course_id' => $stressCourse->id,
            'chapter_name' => 'Modul 2: Sofortinterventionen',
            'title' => '3. Die SOS-Entspannungsübung für den Arbeitsalltag',
            'slug' => 'sos-entspannung',
            'lesson_number' => 3,
            'duration_minutes' => 15,
            'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4',
            'video_path' => 'videos/stress-lektion-3.mp4',
            'pdf_attachment_name' => 'Atemtechniken_Uebersicht.pdf',
            'pdf_attachment_path' => 'materials/Atemtechniken_Uebersicht.pdf',
            'audio_path' => 'audio/SMdGRmsH0Z5eaFJnHcOo3VWWz9FLpT1drtPy8Ccc.wav',
            'is_preview' => false,
            'order' => 3,
            'content_html' => '<p>Gezielte Atem- und Körperübungen zur schnellen Senkung des Herzschlags und Cortisolspiegels.</p>',
        ]);

        // 6.b Seed Audio Adventure Lessons for Rio Negro 2002
        $rioCourse = $courses['rio-negro-2002'];
        Lesson::create([
            'course_id' => $rioCourse->id,
            'chapter_name' => 'Teil 1: Die Expedition beginnt',
            'title' => '1. Einführung in das Audio-Abenteuer Rio Negro',
            'slug' => 'einfuehrung-audio-abenteuer',
            'lesson_number' => 1,
            'duration_minutes' => 14,
            'video_url' => null,
            'video_path' => null,
            'pdf_attachment_name' => 'Rio_Negro_Expeditionsbuch.pdf',
            'pdf_attachment_path' => 'materials/DjtP2gYwdR7gFgq6mB3z3LpeCymMZms5WmWxli5h.pdf',
            'audio_path' => 'audio/SMdGRmsH0Z5eaFJnHcOo3VWWz9FLpT1drtPy8Ccc.wav',
            'is_preview' => true,
            'order' => 1,
            'content_html' => '<h3>Das Rio Negro Audio-Abenteuer</h3><p>Hören Sie die Einführung und bereiten Sie Ihr persönliches Expeditionsbuch für die Reise vor.</p>',
        ]);

        Lesson::create([
            'course_id' => $rioCourse->id,
            'chapter_name' => 'Teil 1: Die Expedition beginnt',
            'title' => '2. Die erste Etappe – Aufbruch in Manaus',
            'slug' => 'die-erste-etappe-manaus',
            'lesson_number' => 2,
            'duration_minutes' => 22,
            'video_url' => null,
            'video_path' => null,
            'pdf_attachment_name' => 'Etappe_1_Entscheidungskarte.pdf',
            'pdf_attachment_path' => 'materials/DjtP2gYwdR7gFgq6mB3z3LpeCymMZms5WmWxli5h.pdf',
            'audio_path' => 'audio/w5RTq6i8FMgDxZC9UAeEUsgnk1IS2hl0L8aodp2T.wav',
            'is_preview' => false,
            'order' => 2,
            'content_html' => '<h3>Erste Etappe: Manaus</h3><p>Hören Sie die Originalaufnahmen der ersten Station und treffen Sie Ihre erste Richtungsentscheidung.</p>',
        ]);

        Lesson::create([
            'course_id' => $rioCourse->id,
            'chapter_name' => 'Teil 2: Tiefer in den Dschungel',
            'title' => '3. Die Fortsetzung – Unerwartete Hindernisse',
            'slug' => 'die-fortsetzung-hindernisse',
            'lesson_number' => 3,
            'duration_minutes' => 19,
            'video_url' => null,
            'video_path' => null,
            'pdf_attachment_name' => 'Etappe_2_Tagebuch.pdf',
            'pdf_attachment_path' => 'materials/DjtP2gYwdR7gFgq6mB3z3LpeCymMZms5WmWxli5h.pdf',
            'audio_path' => 'audio/SMdGRmsH0Z5eaFJnHcOo3VWWz9FLpT1drtPy8Ccc.wav',
            'is_preview' => false,
            'order' => 3,
            'content_html' => '<h3>Zweite Etappe: Der Flusslauf</h3><p>Erleben Sie die dynamische Fortsetzung der Reise auf dem Rio Negro.</p>',
        ]);

        Lesson::create([
            'course_id' => $rioCourse->id,
            'chapter_name' => 'Teil 3: Das Fazit',
            'title' => '4. Der Abschluss – Erkenntnisse für eigene Entscheidungen',
            'slug' => 'der-abschluss-erkenntnisse',
            'lesson_number' => 4,
            'duration_minutes' => 26,
            'video_url' => null,
            'video_path' => null,
            'pdf_attachment_name' => 'Expeditions_Fazit_Leitfaden.pdf',
            'pdf_attachment_path' => 'materials/DjtP2gYwdR7gFgq6mB3z3LpeCymMZms5WmWxli5h.pdf',
            'audio_path' => 'audio/w5RTq6i8FMgDxZC9UAeEUsgnk1IS2hl0L8aodp2T.wav',
            'is_preview' => false,
            'order' => 4,
            'content_html' => '<h3>Abschluss & Erkenntnisse</h3><p>Wie Dennis tatsächlich handelte und welche Prinzipien für reale Lebensentscheidungen daraus folgen.</p>',
        ]);

        // 7. Enroll Test Member in Test Courses & Seed Initial Progress
        Enrollment::create([
            'user_id' => $member->id,
            'course_id' => $kompaktCourse->id,
            'invoice_number' => 'RE-2026-001',
            'started_at' => now()->subDays(5)->toDateString(),
            'expires_at' => now()->addDays(85)->toDateString(),
            'is_active' => true,
            'early_start_agreed' => true,
        ]);

        Enrollment::create([
            'user_id' => $member->id,
            'course_id' => $stressCourse->id,
            'invoice_number' => 'RE-2026-002',
            'started_at' => now()->subDays(3)->toDateString(),
            'expires_at' => now()->addDays(87)->toDateString(),
            'is_active' => true,
            'early_start_agreed' => true,
        ]);

        Enrollment::create([
            'user_id' => $member->id,
            'course_id' => $rioCourse->id,
            'invoice_number' => 'RE-2026-003',
            'started_at' => now()->subDays(2)->toDateString(),
            'expires_at' => now()->addDays(28)->toDateString(),
            'is_active' => true,
            'early_start_agreed' => true,
        ]);

        // Mark first 2 lessons as completed for test member
        LessonProgress::create([
            'user_id' => $member->id,
            'lesson_id' => $createdLessons[0]->id,
            'course_id' => $kompaktCourse->id,
            'is_completed' => true,
            'completed_at' => now()->subDays(3),
            'last_position_seconds' => 1080,
        ]);

        LessonProgress::create([
            'user_id' => $member->id,
            'lesson_id' => $createdLessons[1]->id,
            'course_id' => $kompaktCourse->id,
            'is_completed' => true,
            'completed_at' => now()->subDay(),
            'last_position_seconds' => 1500,
        ]);

        // 8. Seed Admin Notes & Version Notes & Access Requests
        AdminNote::create([
            'user_id' => $admin->id,
            'title' => 'Papierkram Rechnungsabgleich',
            'body' => 'Kontoauszüge für August abgleichen und Rechnungsnummern für Neuanmeldungen prüfen.',
            'expires_at' => now()->addDays(9),
        ]);

        AdminNote::create([
            'user_id' => $admin->id,
            'title' => 'Testphase mit Auftraggeber abstimmen',
            'body' => 'Phase 1 Funktionen (Login, Testkurs, Fortschrittsspeicherung, Adminverwaltung) vollständig verifiziert.',
            'expires_at' => now()->addDays(10),
        ]);

        VersionNote::create([
            'user_id' => $admin->id,
            'title' => 'Zertifikats-PDF Download für Kunden',
            'body' => 'Nach 100% Kursabschluss automatische Generierung eines personalisierten Teilnahme-Zertifikats (Phase 2).',
        ]);

        VersionNote::create([
            'user_id' => $admin->id,
            'title' => 'Mitarbeiter-Portal Erweiterung',
            'body' => 'Mitarbeiterbereich mit direkter CRM-Anbindung für Kundensupport und Telefonnotizen einbinden.',
        ]);

        AccessRequest::create([
            'first_name' => 'Thomas',
            'username' => 'thomas.k',
            'invoice_number' => 'RE-2026-089',
            'course_slug' => 'dnl-kompakt',
            'course_name' => '5-Tage-Kompaktlehrgang',
            'email' => 'thomas@example.de',
            'note' => 'Passwort verlegt nach Gerätewechsel. Bitte um Zusendung eines neuen Kennworts.',
            'status' => 'open',
        ]);
    }
}
