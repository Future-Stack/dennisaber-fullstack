@extends('frontend.layouts.app')

@section('contents')
    <main class="customer-login-page cat-academy" style="min-height: 100vh; display: flex; flex-direction: column; background: #0b1120;">
        {{-- Top Notification Bar --}}
        <div class="portal-notice">
            @if($isAdminPreview)
                <strong style="color: #facc15;">Administrator-Prüfansicht</strong>
                <span>Sie betrachten diesen Kurs als Administrator im Prüfmodus.</span>
            @else
                <strong>Geschützte Kursauslieferung</strong>
                <span>Persönlicher Zugang für: {{ Auth::user()->first_name ?: Auth::user()->name }} · Rechnungs-Nr: {{ Auth::user()->invoice_number ?: 'RN-7X4K-2026' }}</span>
            @endif
        </div>

        {{-- Course Top Navigation (Aligned with Portal Reference) --}}
        <header class="portal-header course-header" style="border-bottom: 1px solid #1e293b; background: #0f172a; position: sticky; top: 0; z-index: 40;">
            <a href="{{ route('member.dashboard') }}" class="portal-brand">
                <strong>DENNIS BESSELER</strong>
                <span>Kursportal</span>
            </a>
            <nav style="display: flex; align-items: center; gap: 1.25rem; flex-wrap: wrap;">
                <a href="{{ route('member.dashboard') }}" style="color: #94a3b8; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem;">
                    ← Alle Kurse
                </a>
                <a href="{{ route('copy-protection') }}" style="color: #94a3b8; font-weight: 500; text-decoration: none;">
                    Kopierschutz
                </a>
                <a href="{{ route('payment') }}" style="color: #94a3b8; font-weight: 500; text-decoration: none;">
                    Zahlung
                </a>
                <a href="{{ route('faster-processing') }}" style="color: #94a3b8; font-weight: 500; text-decoration: none;">
                    Schnellere Bearbeitung
                </a>
                
                {{-- Course Progress Pill --}}
                <div style="background: #1e293b; padding: 0.35rem 0.85rem; border-radius: 20px; font-size: 0.85rem; color: #38bdf8; font-weight: 700; border: 1px solid #334155; display: inline-flex; align-items: center; gap: 0.5rem;">
                    <span id="progress-percent-display">{{ $progressPercent }}%</span>
                    <span style="color: #64748b; font-weight: 400;">abgeschlossen</span>
                </div>

                {{-- Logout Button --}}
                <form method="POST" action="{{ route('logout') }}" style="display:inline; margin-left: 0.5rem;">
                    @csrf
                    <button type="submit" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.25); color: #f87171; cursor: pointer; font-weight: 600; font-size: 0.82rem; padding: 0.35rem 0.75rem; border-radius: 6px; transition: background 0.2s;">
                        Abmelden
                    </button>
                </form>
            </nav>
        </header>

        {{-- Breadcrumb Navigation --}}
        <div style="background: #0f172a; border-bottom: 1px solid #1e293b; padding: 0.6rem 1.5rem;">
            <div style="max-width: 1400px; margin: 0 auto; display: flex; align-items: center; gap: 0.5rem; font-size: 0.82rem; color: #64748b; flex-wrap: wrap;">
                <a href="{{ route('member.dashboard') }}" style="color: #94a3b8; text-decoration: none;">Kursportal</a>
                <span>/</span>
                <span style="color: #cbd5e1; font-weight: 600;">{{ $course->title }}</span>
                <span>/</span>
                <span style="color: #64748b;">{{ $lesson->chapter_name ?: 'Modul' }}</span>
                <span>/</span>
                <span style="color: #38bdf8; font-weight: 600;">Lektion {{ $lesson->lesson_number }}: {{ $lesson->title }}</span>
            </div>
        </div>

        {{-- Main Player & Curriculum Layout --}}
        <div style="max-width: 1400px; width: 100%; margin: 1.5rem auto; padding: 0 1.5rem; flex: 1; display: grid; grid-template-columns: 1fr 360px; gap: 2rem; align-items: start;">
            
            {{-- Left Column: Active Lesson Media, Embedded Content, and Controls --}}
            <div style="background: #131d31; border-radius: 12px; border: 1px solid #1e293b; overflow: hidden; padding: 1.75rem;">
                
                {{-- Module & Lesson Title Header --}}
                <div style="margin-bottom: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; flex-wrap: wrap;">
                        <div>
                            <span style="font-size: 0.82rem; color: #38bdf8; text-transform: uppercase; font-weight: 800; letter-spacing: 0.06em;">
                                {{ $lesson->chapter_name ?: 'Hauptmodul' }} · Lektion {{ $lesson->lesson_number }}
                            </span>
                            <h1 style="color: #f8fafc; font-size: 1.75rem; margin: 0.4rem 0 0.5rem 0; line-height: 1.3;">
                                {{ $lesson->title }}
                            </h1>
                        </div>
                        <div style="display: inline-flex; gap: 0.4rem; flex-wrap: wrap;">
                            @if($lesson->video_path || $lesson->video_url)
                                <span style="background: rgba(56, 189, 248, 0.15); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.3); padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 700;">🎬 Video</span>
                            @endif
                            @if($lesson->audio_path)
                                <span style="background: rgba(74, 222, 128, 0.15); color: #4ade80; border: 1px solid rgba(74, 222, 128, 0.3); padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 700;">🎧 Audio-Lektion</span>
                            @endif
                            @if($lesson->pdf_attachment_name || $lesson->pdf_attachment_path)
                                <span style="background: rgba(192, 132, 252, 0.15); color: #c084fc; border: 1px solid rgba(192, 132, 252, 0.3); padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 700;">📄 Eingebettetes PDF</span>
                            @endif
                        </div>
                    </div>

                    <div style="display: flex; gap: 1rem; color: #94a3b8; font-size: 0.85rem; flex-wrap: wrap; align-items: center; margin-top: 0.5rem;">
                        <span id="lesson-duration-display" style="color: #f8fafc; font-weight: 600;">⏱ Dauer: {{ $lesson->duration_minutes }} Minuten</span>
                        <span>🔒 Geschütztes Kursmedium (Kopierschutz aktiv)</span>
                    </div>
                </div>

                {{-- MEDIA DISPLAY SECTION (Audio-first or Video based on lesson type) --}}
                @php
                    $hasVideo = !empty($lesson->video_path) || !empty($lesson->video_url);
                    $hasAudio = !empty($lesson->audio_path);
                    $isAudioFirst = $hasAudio && (!$hasVideo || str_contains(strtolower($course->slug), 'rio-negro') || str_contains(strtolower($course->category), 'audio'));
                @endphp

                {{-- Case 1: Audio Primary Player (for Audio Courses / Lessons) --}}
                @if($isAudioFirst)
                    <div style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%); border-radius: 12px; padding: 2rem; border: 1px solid #334155; margin-bottom: 2rem; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5); position: relative; overflow: hidden;">
                        {{-- Audio Badge & Track Meta --}}
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 1rem;">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <span style="font-size: 2.2rem; background: rgba(56, 189, 248, 0.15); border: 1px solid rgba(56, 189, 248, 0.3); border-radius: 50%; width: 52px; height: 52px; display: flex; align-items: center; justify-content: center;">🎧</span>
                                <div>
                                    <span style="font-size: 0.75rem; color: #38bdf8; text-transform: uppercase; font-weight: 800; letter-spacing: 0.08em; display: block;">
                                        Original-Audioaufzeichnung · Dennis Besseler
                                    </span>
                                    <strong style="color: #f8fafc; font-size: 1.1rem; display: block;">
                                        {{ $lesson->title }}
                                    </strong>
                                </div>
                            </div>
                            <span style="background: rgba(74, 222, 128, 0.15); color: #4ade80; border: 1px solid rgba(74, 222, 128, 0.3); padding: 0.25rem 0.6rem; border-radius: 20px; font-size: 0.75rem; font-weight: 700;">
                                ● MP3 Stream bereit
                            </span>
                        </div>

                        {{-- Simulated Waveform Visualizer --}}
                        <div style="display: flex; align-items: center; gap: 3px; height: 45px; margin-bottom: 1.5rem; padding: 0 0.5rem; justify-content: space-between;">
                            @for ($i = 0; $i < 36; $i++)
                                @php $barHeight = rand(20, 95); @endphp
                                <div style="flex: 1; height: {{ $barHeight }}%; background: {{ $i < 12 ? '#38bdf8' : '#334155' }}; border-radius: 2px; transition: height 0.2s, background 0.2s;" class="audio-waveform-bar" data-index="{{ $i }}"></div>
                            @endfor
                        </div>

                        {{-- HTML5 Audio Element with Protected Stream URL --}}
                        <audio id="lesson-audio" controls style="width: 100%; border-radius: 8px; outline: none; background: #020617;" preload="metadata">
                            <source src="{{ route('media.stream', ['courseSlug' => $course->slug, 'lessonSlug' => $lesson->slug, 'type' => 'audio']) }}" type="audio/mpeg">
                            Ihr Browser unterstützt das Audio-Element leider nicht.
                        </audio>

                        {{-- Audio Player Quick Controls Bar --}}
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; flex-wrap: wrap; gap: 0.75rem; font-size: 0.85rem; color: #94a3b8;">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <button type="button" onclick="skipAudio(-10)" style="background: #1e293b; color: #cbd5e1; border: 1px solid #334155; padding: 0.35rem 0.65rem; border-radius: 4px; cursor: pointer; font-size: 0.8rem; font-weight: 600;">
                                    ↺ 10s zurück
                                </button>
                                <button type="button" onclick="skipAudio(10)" style="background: #1e293b; color: #cbd5e1; border: 1px solid #334155; padding: 0.35rem 0.65rem; border-radius: 4px; cursor: pointer; font-size: 0.8rem; font-weight: 600;">
                                    ↻ 10s vor
                                </button>
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <span style="font-size: 0.78rem;">Geschwindigkeit:</span>
                                <button type="button" onclick="setAudioSpeed(1.0, this)" class="speed-btn active" style="background: #38bdf8; color: #0f172a; border: none; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.78rem; font-weight: bold; cursor: pointer;">1.0x</button>
                                <button type="button" onclick="setAudioSpeed(1.25, this)" class="speed-btn" style="background: #1e293b; color: #cbd5e1; border: 1px solid #334155; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.78rem; font-weight: 600; cursor: pointer;">1.25x</button>
                                <button type="button" onclick="setAudioSpeed(1.5, this)" class="speed-btn" style="background: #1e293b; color: #cbd5e1; border: 1px solid #334155; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.78rem; font-weight: 600; cursor: pointer;">1.5x</button>
                            </div>
                        </div>
                    </div>

                {{-- Case 2: Video Player (for Video Lessons) --}}
                @elseif($hasVideo)
                    <div style="background: #020617; border-radius: 8px; overflow: hidden; position: relative; aspect-ratio: 16/9; margin-bottom: 2rem; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5); border: 1px solid #1e293b;">
                        <video id="lesson-video" controls style="width: 100%; height: 100%; object-fit: cover;" poster="/frontend/assets/video-poster.jpg" preload="metadata">
                            @if($lesson->video_path)
                                <source src="{{ route('media.stream', ['courseSlug' => $course->slug, 'lessonSlug' => $lesson->slug, 'type' => 'video']) }}" type="video/mp4">
                            @elseif($lesson->video_url)
                                <source src="{{ $lesson->video_url }}" type="video/mp4">
                            @endif
                            Ihr Browser unterstützt das Video-Tag leider nicht.
                        </video>
                    </div>

                    {{-- Secondary Audio Player (if video lesson also has audio meditation) --}}
                    @if($hasAudio)
                        <div style="background: #0f172a; border-radius: 8px; padding: 1.25rem; border: 1px solid #334155; margin-bottom: 2rem;">
                            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                                <span style="font-size: 1.75rem;">🎧</span>
                                <div>
                                    <strong style="color: #f8fafc; display: block; font-size: 0.95rem;">Begleitende Audio-Reflexionsübung</strong>
                                    <span style="color: #94a3b8; font-size: 0.8rem;">Geführte Audio-Sequenz zur Lektion</span>
                                </div>
                            </div>
                            <audio id="lesson-audio" controls style="width: 100%; border-radius: 4px;" preload="metadata">
                                <source src="{{ route('media.stream', ['courseSlug' => $course->slug, 'lessonSlug' => $lesson->slug, 'type' => 'audio']) }}" type="audio/mpeg">
                                Ihr Browser unterstützt das Audio-Element nicht.
                            </audio>
                        </div>
                    @endif
                @endif

                {{-- Lesson Completion & Action Bar --}}
                <div style="background: #0f172a; padding: 1.15rem 1.35rem; border-radius: 8px; border: 1px solid #1e293b; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem;">
                    
                    {{-- Toggle Completed Button (AJAX) --}}
                    <button id="toggle-complete-btn" onclick="toggleLessonComplete()" style="background: {{ $isCurrentCompleted ? '#16a34a' : '#0284c7' }}; color: #fff; border: none; font-weight: 700; padding: 0.7rem 1.35rem; border-radius: 6px; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; transition: background 0.2s;">
                        <span id="btn-icon" style="font-size: 1.1rem;">{{ $isCurrentCompleted ? '✓' : '○' }}</span>
                        <span id="btn-text">{{ $isCurrentCompleted ? 'Lektion abgeschlossen' : 'Als abgeschlossen markieren' }}</span>
                    </button>

                    {{-- Previous / Next Navigation --}}
                    <div style="display: flex; gap: 0.6rem;">
                        @if($prevLesson)
                            <a href="{{ route('course.lesson', ['courseSlug' => $course->slug, 'lessonSlug' => $prevLesson->slug]) }}" style="background: #1e293b; color: #cbd5e1; padding: 0.7rem 1.15rem; border-radius: 6px; text-decoration: none; font-size: 0.9rem; font-weight: 600; border: 1px solid #334155;">
                                ← Vorherige
                            </a>
                        @endif

                        @if($nextLesson)
                            <a href="{{ route('course.lesson', ['courseSlug' => $course->slug, 'lessonSlug' => $nextLesson->slug]) }}" style="background: #38bdf8; color: #0f172a; padding: 0.7rem 1.25rem; border-radius: 6px; text-decoration: none; font-size: 0.9rem; font-weight: 800;">
                                Nächste Lektion →
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Lesson Content & Reading Material --}}
                <div style="color: #cbd5e1; font-size: 1.05rem; line-height: 1.75; margin-bottom: 2.5rem; background: #0f172a; padding: 1.5rem; border-radius: 8px; border: 1px solid #1e293b;" class="lesson-rich-text">
                    <h3 style="color: #f8fafc; font-size: 1.15rem; margin-top: 0; margin-bottom: 0.75rem; border-bottom: 1px solid #1e293b; padding-bottom: 0.5rem;">
                        Lektionsinhalte & Übungsleitfaden
                    </h3>
                    @if($lesson->content_html)
                        {!! $lesson->content_html !!}
                    @else
                        <p>Bearbeiten Sie die Lektion und führen Sie die begleitenden Reflexionsübungen durch.</p>
                    @endif
                </div>

                {{-- IN-PAGE EMBEDDED PDF WORKBOOK VIEWER (Requirement 3: PDF Embedded in Portal) --}}
                @if($lesson->pdf_attachment_name || $lesson->pdf_attachment_path)
                    <div style="background: #0f172a; border-radius: 10px; border: 1px solid #334155; overflow: hidden; margin-top: 2rem;">
                        {{-- PDF Viewer Header Bar --}}
                        <div style="padding: 1rem 1.25rem; background: #1e293b; border-bottom: 1px solid #334155; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <span style="font-size: 1.6rem; color: #c084fc;">📄</span>
                                <div>
                                    <strong style="color: #f8fafc; font-size: 0.98rem; display: block;">
                                        {{ $lesson->pdf_attachment_name ?: 'Begleitendes Arbeitsbuch (PDF)' }}
                                    </strong>
                                    <span style="color: #94a3b8; font-size: 0.78rem;">
                                        Eingebettetes Dokument mit persönlichem Wasserzeichen (Kopierschutz)
                                    </span>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.6rem;">
                                <button type="button" onclick="togglePdfFullscreen()" style="background: #334155; color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.4); padding: 0.4rem 0.8rem; border-radius: 4px; font-size: 0.8rem; font-weight: 700; cursor: pointer;">
                                    ⛶ Vollbild
                                </button>
                                <a href="{{ route('media.stream', ['courseSlug' => $course->slug, 'lessonSlug' => $lesson->slug, 'type' => 'pdf']) }}" target="_blank" style="background: transparent; color: #94a3b8; border: 1px solid #475569; padding: 0.4rem 0.8rem; border-radius: 4px; font-size: 0.8rem; text-decoration: none;">
                                    Separates Fenster ↗
                                </a>
                            </div>
                        </div>

                        {{-- Embedded PDF Viewer Iframe --}}
                        <div id="pdf-viewer-wrapper" style="position: relative; width: 100%; height: 720px; background: #0b1120;">
                            <iframe 
                                id="embedded-pdf-frame"
                                src="{{ route('media.stream', ['courseSlug' => $course->slug, 'lessonSlug' => $lesson->slug, 'type' => 'pdf']) }}#toolbar=0&navpanes=0" 
                                style="width: 100%; height: 100%; border: none;"
                                title="{{ $lesson->pdf_attachment_name ?: 'PDF-Dokument' }}"
                                loading="lazy">
                            </iframe>
                        </div>

                        {{-- PDF Viewer Footer Note --}}
                        <div style="padding: 0.65rem 1.25rem; background: #131d31; border-top: 1px solid #1e293b; display: flex; justify-content: space-between; align-items: center; font-size: 0.75rem; color: #64748b;">
                            <span>🔒 Technischer Kopierschutz aktiv · Direkt im Kursportal eingebettet</span>
                            <span>Lizenz: {{ Auth::user()->first_name ?: Auth::user()->name }}</span>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Right Column: Course Curriculum Sidebar --}}
            <aside style="background: #131d31; border-radius: 12px; border: 1px solid #1e293b; overflow: hidden; position: sticky; top: 80px;">
                <div style="padding: 1.25rem 1.5rem; background: #0f172a; border-bottom: 1px solid #1e293b;">
                    <h2 style="color: #f8fafc; font-size: 1.1rem; margin: 0 0 0.25rem 0;">Inhaltsverzeichnis</h2>
                    <span style="color: #94a3b8; font-size: 0.85rem;">{{ $allLessons->count() }} Lektionen im Lehrgang</span>
                </div>

                <div style="padding: 0.75rem 0; max-height: calc(100vh - 200px); overflow-y: auto;">
                    @foreach($chapters as $chapterName => $chapterLessons)
                        <div style="margin-bottom: 0.75rem;">
                            <div style="padding: 0.4rem 1.25rem; font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 800; letter-spacing: 0.06em;">
                                {{ $chapterName }}
                            </div>
                            <div>
                                @foreach($chapterLessons as $item)
                                    @php
                                        $isItemActive = $item->id === $lesson->id;
                                        $isItemCompleted = in_array($item->id, $completedIds);
                                    @endphp
                                    <a href="{{ route('course.lesson', ['courseSlug' => $course->slug, 'lessonSlug' => $item->slug]) }}" style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1.25rem; text-decoration: none; background: {{ $isItemActive ? '#1e293b' : 'transparent' }}; border-left: 3px solid {{ $isItemActive ? '#38bdf8' : 'transparent' }}; transition: background 0.15s;">
                                        <div style="display: flex; align-items: center; gap: 0.75rem; overflow: hidden;">
                                            <span id="sidebar-icon-{{ $item->id }}" style="color: {{ $isItemCompleted ? '#4ade80' : '#64748b' }}; font-weight: bold; font-size: 0.95rem; flex-shrink: 0;">
                                                {{ $isItemCompleted ? '✓' : '○' }}
                                            </span>
                                            <div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                <span style="color: {{ $isItemActive ? '#f8fafc' : ($isItemCompleted ? '#cbd5e1' : '#94a3b8') }}; font-size: 0.88rem; font-weight: {{ $isItemActive ? '700' : 'normal' }}; display: block; overflow: hidden; text-overflow: ellipsis;">
                                                    {{ $item->lesson_number }}. {{ $item->title }}
                                                </span>
                                                <div style="display: flex; gap: 0.4rem; font-size: 0.7rem; color: #64748b; margin-top: 0.15rem;">
                                                    @if($item->audio_path)
                                                        <span style="color: #4ade80;">🎧 Audio</span>
                                                    @elseif($item->video_path || $item->video_url)
                                                        <span style="color: #38bdf8;">🎬 Video</span>
                                                    @endif
                                                    @if($item->pdf_attachment_name || $item->pdf_attachment_path)
                                                        <span style="color: #c084fc;">📄 PDF</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <span id="sidebar-duration-{{ $item->id }}" style="color: #64748b; font-size: 0.75rem; flex-shrink: 0; margin-left: 0.5rem;">{{ $item->duration_minutes }}m</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </aside>
        </div>

        {{-- Site Footer --}}
        <footer class="site-footer" style="background: #0f172a; border-top: 1px solid #1e293b; margin-top: auto;">
            <div>
                <strong>DENNIS BESSELER</strong>
                <p>Persönliche Kurszugänge · einmalige Zahlung · kein Abonnement</p>
            </div>
            <nav aria-label="Rechtliche Hinweise">
                <a href="{{ route('login') }}">Kundenlogin</a>
                <a href="{{ route('copy-protection') }}">Kopierschutz</a>
                <a href="{{ route('payment') }}">Zahlung</a>
                <a href="{{ route('faster-processing') }}">Schnellere Bearbeitung</a>
                <a href="{{ route('imprint') }}">Impressum</a>
                <a href="{{ route('privacy-policy') }}">Datenschutz</a>
            </nav>
        </footer>
    </main>

    {{-- Interactive AJAX Scripts for Media, Completion, Speed & Fullscreen --}}
    <script>
        // 1. Audio Control Helpers
        function skipAudio(seconds) {
            const audio = document.getElementById('lesson-audio');
            if (audio) {
                audio.currentTime = Math.max(0, Math.min(audio.duration || 9999, audio.currentTime + seconds));
            }
        }

        function setAudioSpeed(speed, btn) {
            const audio = document.getElementById('lesson-audio');
            if (audio) {
                audio.playbackRate = speed;
                document.querySelectorAll('.speed-btn').forEach(b => {
                    b.style.background = '#1e293b';
                    b.style.color = '#cbd5e1';
                    b.style.border = '1px solid #334155';
                });
                if (btn) {
                    btn.style.background = '#38bdf8';
                    btn.style.color = '#0f172a';
                    btn.style.border = 'none';
                }
            }
        }

        // 2. Fullscreen Toggle for Embedded PDF Viewer
        function togglePdfFullscreen() {
            const wrapper = document.getElementById('pdf-viewer-wrapper');
            if (!wrapper) return;
            if (!document.fullscreenElement) {
                wrapper.requestFullscreen().catch(err => {
                    alert(`Vollbildmodus nicht möglich: ${err.message}`);
                });
            } else {
                document.exitFullscreen();
            }
        }

        // 3. Dynamic Media Duration Detection
        document.addEventListener('DOMContentLoaded', () => {
            const videoEl = document.getElementById('lesson-video');
            const audioEl = document.getElementById('lesson-audio');
            const mediaEl = audioEl || videoEl;

            if (mediaEl) {
                function updateMediaDuration() {
                    if (mediaEl.duration && !isNaN(mediaEl.duration) && mediaEl.duration > 0 && isFinite(mediaEl.duration)) {
                        const totalSec = Math.round(mediaEl.duration);
                        const mins = Math.floor(totalSec / 60);
                        const secs = totalSec % 60;
                        
                        const formattedLong = mins > 0 
                            ? (secs > 0 ? `${mins} Min. ${secs} Sek.` : `${mins} Minuten`) 
                            : `${secs} Sekunden`;
                        const formattedShort = mins > 0 ? `${mins}m` : `${secs}s`;

                        const mainDisplay = document.getElementById('lesson-duration-display');
                        if (mainDisplay) {
                            mainDisplay.innerHTML = `⏱ Dauer: ${formattedLong}`;
                        }

                        const currentSidebar = document.getElementById('sidebar-duration-{{ $lesson->id }}');
                        if (currentSidebar) {
                            currentSidebar.innerText = formattedShort;
                        }
                    }
                }

                mediaEl.addEventListener('loadedmetadata', updateMediaDuration);
                mediaEl.addEventListener('durationchange', updateMediaDuration);
                mediaEl.addEventListener('canplay', updateMediaDuration);
                if (mediaEl.readyState >= 1) {
                    updateMediaDuration();
                }

                // Audio Waveform Animation effect on play/pause
                const bars = document.querySelectorAll('.audio-waveform-bar');
                if (bars.length > 0) {
                    let waveInterval;
                    mediaEl.addEventListener('play', () => {
                        waveInterval = setInterval(() => {
                            bars.forEach(b => {
                                const r = Math.floor(Math.random() * 85) + 15;
                                b.style.height = r + '%';
                            });
                        }, 250);
                    });
                    mediaEl.addEventListener('pause', () => clearInterval(waveInterval));
                    mediaEl.addEventListener('ended', () => clearInterval(waveInterval));
                }
            }
        });

        // 4. Toggle Lesson Completion via AJAX
        let isCompleted = {{ $isCurrentCompleted ? 'true' : 'false' }};
        let isSaving = false;

        function toggleLessonComplete() {
            if (isSaving) return;
            isSaving = true;

            const btn = document.getElementById('toggle-complete-btn');
            const icon = document.getElementById('btn-icon');
            const text = document.getElementById('btn-text');
            const progressPercent = document.getElementById('progress-percent-display');
            const sidebarIcon = document.getElementById('sidebar-icon-{{ $lesson->id }}');

            btn.style.opacity = '0.7';

            fetch("{{ route('course.lesson.toggle', ['courseSlug' => $course->slug, 'lessonSlug' => $lesson->slug]) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                isSaving = false;
                btn.style.opacity = '1';

                if (data.status === 'success') {
                    isCompleted = data.is_completed;
                    
                    if (isCompleted) {
                        btn.style.background = '#16a34a';
                        icon.innerText = '✓';
                        text.innerText = 'Lektion abgeschlossen';
                        if (sidebarIcon) {
                            sidebarIcon.style.color = '#4ade80';
                            sidebarIcon.innerText = '✓';
                        }
                    } else {
                        btn.style.background = '#0284c7';
                        icon.innerText = '○';
                        text.innerText = 'Als abgeschlossen markieren';
                        if (sidebarIcon) {
                            sidebarIcon.style.color = '#64748b';
                            sidebarIcon.innerText = '○';
                        }
                    }

                    if (progressPercent && data.progress_percent !== undefined) {
                        progressPercent.innerText = data.progress_percent + '%';
                    }
                }
            })
            .catch(err => {
                isSaving = false;
                btn.style.opacity = '1';
                console.error('Fehler beim Aktualisieren:', err);
            });
        }
    </script>
@endsection
