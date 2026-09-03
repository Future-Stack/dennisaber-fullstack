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

        {{-- Course Top Navigation --}}
        <header class="portal-header course-header" style="border-bottom: 1px solid #1e293b; background: #0f172a; position: sticky; top: 0; z-index: 40; padding: 0.85rem 1.5rem;">
            <div style="max-width: 1400px; width: 100%; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <a href="{{ route('member.dashboard') }}" class="portal-brand" style="text-decoration: none;">
                    <strong>DENNIS BESSELER</strong>
                    <span>Kursportal</span>
                </a>
                <nav style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
                    <a href="{{ route('member.dashboard') }}" style="color: #cbd5e1; font-weight: 600; font-size: 0.85rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem; background: #1e293b; padding: 0.4rem 0.85rem; border-radius: 6px; border: 1px solid #334155;">
                        ← Mein Lernbereich
                    </a>

                    {{-- Support Button --}}
                    <button type="button" onclick="openSupportAssistant()" style="background: #1e293b; border: 1px solid #334155; color: #38bdf8; font-weight: 600; font-size: 0.82rem; padding: 0.4rem 0.75rem; border-radius: 6px; cursor: pointer; display: inline-flex; align-items: center; gap: 0.35rem;">
                        💬 Support
                    </button>

                    {{-- Missbrauch melden / Aufbereitung für Polizeibehörden --}}
                    <button type="button" onclick="openAbuseModal()" style="background: rgba(239, 68, 68, 0.12); border: 1px solid rgba(239, 68, 68, 0.3); color: #f87171; font-weight: 600; font-size: 0.82rem; padding: 0.4rem 0.75rem; border-radius: 6px; cursor: pointer; display: inline-flex; align-items: center; gap: 0.35rem;">
                        🛡 Missbrauch melden
                    </button>
                    
                    {{-- Course Progress Pill --}}
                    <div style="background: #0f172a; padding: 0.35rem 0.85rem; border-radius: 20px; font-size: 0.82rem; color: #38bdf8; font-weight: 700; border: 1px solid #334155; display: inline-flex; align-items: center; gap: 0.5rem;">
                        <span id="progress-percent-display">{{ $progressPercent }}%</span>
                        <span style="color: #64748b; font-weight: 400;">abgeschlossen</span>
                    </div>

                    {{-- Customer Identity Pill --}}
                    <div style="background: #1e293b; padding: 0.35rem 0.75rem; border-radius: 6px; font-size: 0.82rem; color: #94a3b8; border: 1px solid #334155;">
                        <span style="color: #f8fafc; font-weight: 600;">{{ Auth::user()->first_name ?: Auth::user()->name }}</span>
                        @if(Auth::user()->invoice_number)
                            <span style="color: #64748b;">· {{ Auth::user()->invoice_number }}</span>
                        @endif
                    </div>

                    {{-- Logout Button --}}
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.25); color: #f87171; cursor: pointer; font-weight: 600; font-size: 0.82rem; padding: 0.4rem 0.75rem; border-radius: 6px; transition: background 0.2s;">
                            Abmelden
                        </button>
                    </form>
                </nav>
            </div>
        </header>

        {{-- Breadcrumb Navigation --}}
        <div style="background: #0b1120; border-bottom: 1px solid #1e293b; padding: 0.6rem 1.5rem;">
            <div style="max-width: 1400px; margin: 0 auto; display: flex; align-items: center; gap: 0.5rem; font-size: 0.82rem; color: #64748b; flex-wrap: wrap;">
                <a href="{{ route('member.dashboard') }}" style="color: #94a3b8; text-decoration: none;">Mein Lernbereich</a>
                <span>/</span>
                <span style="color: #cbd5e1; font-weight: 600;">{{ $course->title }}</span>
                <span>/</span>
                <span style="color: #64748b;">{{ $lesson->chapter_name ?: 'Modul' }}</span>
                <span>/</span>
                <span style="color: #38bdf8; font-weight: 600;">Lektion {{ $lesson->lesson_number }}: {{ $lesson->title }}</span>
            </div>
        </div>

        {{-- Media Type Detection & Watermark Payload --}}
        @php
            $hasAudio = true; // Dennis's audio courses use pure compact MP3 playback
            $hasPdf = !empty($lesson->pdf_attachment_name) || !empty($lesson->pdf_attachment_path);

            $watermarkText = (Auth::user()->first_name ?: Auth::user()->name) . ' · ' . (Auth::user()->invoice_number ?: 'RN-7X4K-2026');
        @endphp

        {{-- Main Player & Curriculum Layout --}}
        <div style="max-width: 1400px; width: 100%; margin: 1.5rem auto; padding: 0 1.5rem; flex: 1; display: grid; grid-template-columns: 1fr 360px; gap: 2rem; align-items: start;">
            
            {{-- Left Column: Active Lesson Content, Compact MP3 Player & Dynamic Watermark Overlay --}}
            <div style="background: #131d31; border-radius: 12px; border: 1px solid #1e293b; overflow: hidden; padding: 1.75rem; position: relative;">
                
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

                        {{-- Content Type Badges --}}
                        <div style="display: inline-flex; gap: 0.4rem; flex-wrap: wrap; align-items: center;">
                            <span style="background: rgba(74, 222, 128, 0.15); color: #4ade80; border: 1px solid rgba(74, 222, 128, 0.3); padding: 0.25rem 0.65rem; border-radius: 6px; font-size: 0.78rem; font-weight: 700; display: inline-flex; align-items: center; gap: 0.35rem;">
                                🎧 Audiolektion (MP3)
                            </span>

                            @if($hasPdf)
                                <span style="background: rgba(192, 132, 252, 0.15); color: #c084fc; border: 1px solid rgba(192, 132, 252, 0.3); padding: 0.25rem 0.65rem; border-radius: 6px; font-size: 0.78rem; font-weight: 700; display: inline-flex; align-items: center; gap: 0.35rem;">
                                    📄 PDF-Arbeitsbuch
                                </span>
                            @endif
                        </div>
                    </div>

                    <div style="display: flex; gap: 1rem; color: #94a3b8; font-size: 0.85rem; flex-wrap: wrap; align-items: center; margin-top: 0.5rem;">
                        <span id="lesson-duration-display" style="color: #f8fafc; font-weight: 600;">⏱ Dauer: {{ $lesson->duration_minutes }} Minuten</span>
                        <span style="color: #64748b;">🔒 Dynamischer Lizenzschutz: {{ $watermarkText }}</span>
                    </div>
                </div>

                {{-- ========================================================= --}}
                {{-- COMPACT PURE AUDIO MP3 PLAYER (Single Slim Diagonal Stripe) --}}
                {{-- ========================================================= --}}
                <div style="background: linear-gradient(135deg, #0f172a 0%, #172554 100%); border-radius: 12px; padding: 1.25rem 1.5rem; border: 1px solid #334155; margin-bottom: 2rem; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4); position: relative; overflow: hidden;">
                    
                    {{-- Exactly ONE Single Slim Diagonal Watermark Overlay Stripe --}}
                    <div class="watermark-overlay-layer" aria-hidden="true" style="position: absolute; inset: 0; pointer-events: none; overflow: hidden; z-index: 10; border-radius: 12px;">
                        <div style="position: absolute; top: 50%; left: 50%; width: 200%; transform: translate(-50%, -50%) rotate(-24deg); background: rgba(255, 255, 255, 0.035); border-top: 1px solid rgba(255, 255, 255, 0.06); border-bottom: 1px solid rgba(255, 255, 255, 0.06); padding: 5px 0; display: flex; justify-content: center; user-select: none;">
                            <span style="color: rgba(255, 255, 255, 0.15); font-size: 0.76rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; white-space: nowrap;">
                                {{ $watermarkText }} &nbsp;&nbsp;&nbsp;&nbsp;·&nbsp;&nbsp;&nbsp;&nbsp; {{ $watermarkText }}
                            </span>
                        </div>
                    </div>

                    {{-- Compact Audio Top: Track Meta & Format Status --}}
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.9rem; flex-wrap: wrap; gap: 0.5rem; position: relative; z-index: 2;">
                        <div style="display: flex; align-items: center; gap: 0.6rem;">
                            <span style="font-size: 1.25rem; color: #38bdf8;">🎧</span>
                            <div>
                                <span style="font-size: 0.72rem; color: #38bdf8; text-transform: uppercase; font-weight: 800; letter-spacing: 0.08em; display: block;">
                                    Original-Audioaufzeichnung · Dennis Besseler
                                </span>
                                <strong style="color: #f8fafc; font-size: 0.98rem; display: block;">
                                    {{ $lesson->title }}
                                </strong>
                            </div>
                        </div>
                        <span style="background: rgba(74, 222, 128, 0.15); color: #4ade80; border: 1px solid rgba(74, 222, 128, 0.3); padding: 0.2rem 0.55rem; border-radius: 20px; font-size: 0.72rem; font-weight: 700;">
                            ● MP3 bereit
                        </span>
                    </div>

                    {{-- Compact Audio Controls Bar --}}
                    <div style="display: flex; align-items: center; gap: 1rem; background: #020617; padding: 0.75rem 1rem; border-radius: 8px; border: 1px solid #1e293b; position: relative; z-index: 2; flex-wrap: wrap;">
                        {{-- Play / Pause Button --}}
                        <button type="button" id="audio-play-btn" onclick="toggleAudioPlay()" style="width: 42px; height: 42px; border-radius: 50%; background: #38bdf8; color: #0b1120; border: none; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; cursor: pointer; font-weight: bold; flex-shrink: 0; box-shadow: 0 0 15px rgba(56, 189, 248, 0.4); transition: transform 0.15s, background 0.15s;">
                            <span id="audio-play-icon">▶</span>
                        </button>

                        {{-- Time & Interactive Scrubber --}}
                        <div style="flex: 1; min-width: 180px; display: flex; flex-direction: column; gap: 0.3rem;">
                            <div style="display: flex; justify-content: space-between; font-size: 0.75rem; color: #94a3b8; font-family: monospace;">
                                <span id="audio-current-time">00:00</span>
                                <span id="audio-total-time">{{ sprintf('%02d:00', $lesson->duration_minutes) }}</span>
                            </div>
                            <input type="range" id="audio-scrubber" min="0" max="100" value="0" step="0.1" oninput="onScrubberInput(this.value)" onchange="onScrubberChange(this.value)" style="width: 100%; cursor: pointer; accent-color: #38bdf8; height: 5px;">
                        </div>

                        {{-- Skip ±10s Buttons --}}
                        <div style="display: flex; align-items: center; gap: 0.35rem;">
                            <button type="button" onclick="skipAudio(-10)" title="10 Sekunden zurück" style="background: #1e293b; color: #cbd5e1; border: 1px solid #334155; padding: 0.35rem 0.6rem; border-radius: 4px; cursor: pointer; font-size: 0.75rem; font-weight: 600;">
                                ↺ -10s
                            </button>
                            <button type="button" onclick="skipAudio(10)" title="10 Sekunden vor" style="background: #1e293b; color: #cbd5e1; border: 1px solid #334155; padding: 0.35rem 0.6rem; border-radius: 4px; cursor: pointer; font-size: 0.75rem; font-weight: 600;">
                                ↻ +10s
                            </button>
                        </div>

                        {{-- Playback Speed Switcher --}}
                        <div style="display: flex; align-items: center; gap: 0.25rem;">
                            <button type="button" onclick="setAudioSpeed(1.0, this)" class="speed-btn active" style="background: #38bdf8; color: #0f172a; border: none; padding: 0.3rem 0.5rem; border-radius: 4px; font-size: 0.72rem; font-weight: bold; cursor: pointer;">1.0x</button>
                            <button type="button" onclick="setAudioSpeed(1.25, this)" class="speed-btn" style="background: #1e293b; color: #cbd5e1; border: 1px solid #334155; padding: 0.3rem 0.5rem; border-radius: 4px; font-size: 0.72rem; font-weight: 600; cursor: pointer;">1.25x</button>
                            <button type="button" onclick="setAudioSpeed(1.5, this)" class="speed-btn" style="background: #1e293b; color: #cbd5e1; border: 1px solid #334155; padding: 0.3rem 0.5rem; border-radius: 4px; font-size: 0.72rem; font-weight: 600; cursor: pointer;">1.5x</button>
                        </div>
                    </div>

                    {{-- Native HTML5 Audio Element --}}
                    <audio id="lesson-audio" preload="metadata" style="display: none;">
                        <source src="{{ route('media.stream', ['courseSlug' => $course->slug, 'lessonSlug' => $lesson->slug, 'type' => 'audio']) }}" type="audio/mpeg">
                    </audio>
                </div>

                {{-- Lesson Completion & Navigation Action Bar --}}
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

                {{-- Lesson Content & Reading Material (Single Diagonal Watermark Overlay) --}}
                <div style="position: relative; color: #cbd5e1; font-size: 1.05rem; line-height: 1.75; margin-bottom: 2.5rem; background: #0f172a; padding: 1.5rem; border-radius: 8px; border: 1px solid #1e293b; overflow: hidden;" class="lesson-rich-text">
                    
                    {{-- Exactly ONE Single Slim Diagonal Watermark Overlay Stripe --}}
                    <div class="watermark-overlay-layer" aria-hidden="true" style="position: absolute; inset: 0; pointer-events: none; overflow: hidden; z-index: 5; border-radius: 8px;">
                        <div style="position: absolute; top: 50%; left: 50%; width: 200%; transform: translate(-50%, -50%) rotate(-24deg); background: rgba(255, 255, 255, 0.025); border-top: 1px solid rgba(255, 255, 255, 0.05); border-bottom: 1px solid rgba(255, 255, 255, 0.05); padding: 5px 0; display: flex; justify-content: center; user-select: none;">
                            <span style="color: rgba(255, 255, 255, 0.12); font-size: 0.76rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; white-space: nowrap;">
                                {{ $watermarkText }} &nbsp;&nbsp;&nbsp;&nbsp;·&nbsp;&nbsp;&nbsp;&nbsp; {{ $watermarkText }}
                            </span>
                        </div>
                    </div>

                    <h3 style="color: #f8fafc; font-size: 1.15rem; margin-top: 0; margin-bottom: 0.75rem; border-bottom: 1px solid #1e293b; padding-bottom: 0.5rem; position: relative; z-index: 6;">
                        Lektionsinhalte &amp; Übungsleitfaden
                    </h3>
                    <div style="position: relative; z-index: 6;">
                        @if($lesson->content_html)
                            {!! $lesson->content_html !!}
                        @else
                            <p>Bearbeiten Sie die Lektion und führen Sie die begleitenden Reflexionsübungen durch.</p>
                        @endif
                    </div>
                </div>

                {{-- Embedded PDF Workbook (if applicable) --}}
                @if($hasPdf)
                    <div style="background: #0f172a; border-radius: 10px; border: 1px solid #334155; overflow: hidden; margin-top: 2rem; position: relative;">
                        <div style="padding: 0.85rem 1.25rem; background: #1e293b; border-bottom: 1px solid #334155; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                            <div style="display: flex; align-items: center; gap: 0.65rem;">
                                <span style="font-size: 1.4rem; color: #c084fc;">📄</span>
                                <div>
                                    <strong style="color: #f8fafc; font-size: 0.95rem; display: block;">
                                        {{ $lesson->pdf_attachment_name ?: 'Begleitendes Arbeitsbuch (PDF)' }}
                                    </strong>
                                    <span style="color: #94a3b8; font-size: 0.75rem;">
                                        Eingebundenes Arbeitsmaterial mit persönlicher Lizenzierung
                                    </span>
                                </div>
                            </div>
                            <button type="button" onclick="togglePdfFullscreen('companion-pdf-wrapper')" style="background: #334155; color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.4); padding: 0.35rem 0.75rem; border-radius: 4px; font-size: 0.8rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 0.35rem;">
                                <span>⛶</span> Vollbild-Ansicht
                            </button>
                        </div>

                        {{-- PDF Viewer Container with Single Diagonal Watermark --}}
                        <div id="companion-pdf-wrapper" style="position: relative; width: 100%; height: 750px; background: #0b1120;">
                            <div class="watermark-overlay-layer" aria-hidden="true" style="position: absolute; inset: 0; pointer-events: none; overflow: hidden; z-index: 10;">
                                <div style="position: absolute; top: 50%; left: 50%; width: 200%; transform: translate(-50%, -50%) rotate(-24deg); background: rgba(255, 255, 255, 0.035); border-top: 1px solid rgba(255, 255, 255, 0.06); border-bottom: 1px solid rgba(255, 255, 255, 0.06); padding: 6px 0; display: flex; justify-content: center; user-select: none;">
                                    <span style="color: rgba(255, 255, 255, 0.15); font-size: 0.76rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; white-space: nowrap;">
                                        {{ $watermarkText }} &nbsp;&nbsp;&nbsp;&nbsp;·&nbsp;&nbsp;&nbsp;&nbsp; {{ $watermarkText }}
                                    </span>
                                </div>
                            </div>

                            <iframe 
                                src="{{ route('media.stream', ['courseSlug' => $course->slug, 'lessonSlug' => $lesson->slug, 'type' => 'pdf']) }}#toolbar=0&navpanes=0" 
                                style="width: 100%; height: 100%; border: none;"
                                title="{{ $lesson->pdf_attachment_name ?: 'PDF-Dokument' }}"
                                loading="lazy">
                            </iframe>
                        </div>

                        <div style="padding: 0.65rem 1.25rem; background: #131d31; border-top: 1px solid #1e293b; display: flex; justify-content: space-between; align-items: center; font-size: 0.75rem; color: #64748b; flex-wrap: wrap; gap: 0.5rem;">
                            <span>🔒 Urheberrechtlich geschützt · Nur zur persönlichen Bearbeitung im Kursportal</span>
                            <span>Lizenznehmer: {{ $watermarkText }}</span>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Right Column: Course Curriculum Sidebar --}}
            <aside style="background: #131d31; border-radius: 12px; border: 1px solid #1e293b; overflow: hidden; position: sticky; top: 80px;">
                <div style="padding: 1.25rem 1.5rem; background: #0f172a; border-bottom: 1px solid #1e293b; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h2 style="color: #f8fafc; font-size: 1.05rem; margin: 0 0 0.25rem 0;">Inhaltsverzeichnis</h2>
                        <span style="color: #94a3b8; font-size: 0.8rem;">{{ $allLessons->count() }} Lektionen im Lehrgang</span>
                    </div>
                    <button type="button" onclick="openAbuseModal()" title="Urheberrechtsverletzung oder Missbrauch melden" style="background: transparent; border: 1px solid rgba(239, 68, 68, 0.4); color: #f87171; border-radius: 4px; padding: 4px 8px; font-size: 0.72rem; font-weight: 600; cursor: pointer;">
                        🛡 Missbrauch
                    </button>
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
                                        $itemHasPdf = !empty($item->pdf_attachment_name) || !empty($item->pdf_attachment_path);
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
                                                <div style="display: flex; gap: 0.4rem; font-size: 0.7rem; color: #64748b; margin-top: 0.15rem; flex-wrap: wrap;">
                                                    <span style="color: #4ade80;">🎧 Audio (MP3)</span>
                                                    @if($itemHasPdf)
                                                        <span style="color: #c084fc;">+ Arbeitsbuch</span>
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

        {{-- Missbrauch Melden / Aufbereitung für Polizeibehörden Modal --}}
        <div id="abuse-modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.8); z-index: 100000; align-items: center; justify-content: center; padding: 1.5rem; backdrop-filter: blur(5px);">
            <div style="background: #0f172a; border: 1px solid #334155; border-radius: 12px; max-width: 640px; width: 100%; max-height: 90vh; overflow-y: auto; padding: 1.75rem; color: #f8fafc; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.7);">
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #1e293b; padding-bottom: 1rem; margin-bottom: 1.25rem;">
                    <div>
                        <span style="color: #ef4444; font-size: 0.78rem; text-transform: uppercase; font-weight: 800; letter-spacing: 0.06em;">Rechtsschutz &amp; Strafantrag</span>
                        <h2 style="font-size: 1.25rem; margin: 0.25rem 0 0 0; color: #f8fafc;">Missbrauch melden / Polizeidokumentation</h2>
                    </div>
                    <button type="button" onclick="closeAbuseModal()" style="background: none; border: none; color: #94a3b8; font-size: 1.4rem; cursor: pointer;">✕</button>
                </div>

                <div style="font-size: 0.88rem; color: #94a3b8; line-height: 1.6; margin-bottom: 1.25rem;">
                    <p style="margin-top: 0;">
                        Alle Kursinhalte, Audioaufzeichnungen und Begleitmaterialien von <strong>Dennis Besseler</strong> sind urheberrechtlich geschützt. Die unbefugte Vervielfältigung, öffentliche Zugänglichmachung oder Weitergabe erfüllt den Straftatbestand des <strong>§ 106 UrhG</strong> und wird ausnahmslos zivil- und strafrechtlich verfolgt.
                    </p>
                </div>

                <div style="background: #020617; border: 1px solid #1e293b; border-radius: 8px; padding: 1rem; margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.8rem; color: #cbd5e1; font-weight: 600; margin-bottom: 0.4rem;">Fundort / Plattform / URL des Verstoßes:</label>
                    <input type="text" id="abuse-url" placeholder="z. B. https://... oder Telegram / WhatsApp Gruppe" style="width: 100%; box-sizing: border-box; background: #0f172a; border: 1px solid #334155; color: #f8fafc; padding: 0.6rem 0.8rem; border-radius: 6px; font-size: 0.85rem; margin-bottom: 0.8rem;">

                    <label style="display: block; font-size: 0.8rem; color: #cbd5e1; font-weight: 600; margin-bottom: 0.4rem;">Sachverhalt / Beobachtung:</label>
                    <textarea id="abuse-description" rows="3" placeholder="Genaue Beschreibung des Verstoßes, beteiligte Personen, Dateinamen..." style="width: 100%; box-sizing: border-box; background: #0f172a; border: 1px solid #334155; color: #f8fafc; padding: 0.6rem 0.8rem; border-radius: 6px; font-size: 0.85rem;"></textarea>
                </div>

                {{-- Live Criminal Complaint / Legal Action Generator --}}
                <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                    <button type="button" onclick="generatePoliceDraft()" style="flex: 1; background: #dc2626; color: #fff; border: none; font-weight: 700; font-size: 0.85rem; padding: 0.75rem 1rem; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.4rem;">
                        📋 Strafanzeige-Entwurf generieren
                    </button>
                    <a id="abuse-mail-link" href="mailto:mail@besseler.de?subject=Missbrauchsmeldung%20Urheberrecht" style="background: #1e293b; border: 1px solid #334155; color: #cbd5e1; font-weight: 600; font-size: 0.85rem; padding: 0.75rem 1rem; border-radius: 6px; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 0.4rem;">
                        ✉ Direkt an Dennis melden
                    </a>
                </div>
            </div>
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
                <a href="{{ route('payment-participation') }}">Zahlungsbedingungen</a>
            </nav>
        </footer>
    </main>

    {{-- Interactive JavaScript for Audio Controls, PDF Fullscreen, Progress & Abuse Reporting --}}
    <script>
        // ==========================================
        // 1. Audio Player Interaction Logic (MP3)
        // ==========================================
        const audioEl = document.getElementById('lesson-audio');
        const playBtn = document.getElementById('audio-play-btn');
        const playIcon = document.getElementById('audio-play-icon');
        const scrubber = document.getElementById('audio-scrubber');
        const curTimeDisplay = document.getElementById('audio-current-time');
        const totalTimeDisplay = document.getElementById('audio-total-time');

        function formatTime(seconds) {
            if (isNaN(seconds) || seconds < 0) return '00:00';
            const m = Math.floor(seconds / 60);
            const s = Math.floor(seconds % 60);
            return `${m < 10 ? '0' : ''}${m}:${s < 10 ? '0' : ''}${s}`;
        }

        function toggleAudioPlay() {
            if (!audioEl) return;
            if (audioEl.paused) {
                audioEl.play().catch(e => console.log('Audio playback prevented:', e));
                if (playIcon) playIcon.innerText = '❚❚';
                if (playBtn) playBtn.style.background = '#4ade80';
            } else {
                audioEl.pause();
                if (playIcon) playIcon.innerText = '▶';
                if (playBtn) playBtn.style.background = '#38bdf8';
            }
        }

        function skipAudio(seconds) {
            if (!audioEl) return;
            audioEl.currentTime = Math.max(0, Math.min(audioEl.duration || 9999, audioEl.currentTime + seconds));
        }

        function setAudioSpeed(speed, btn) {
            if (!audioEl) return;
            audioEl.playbackRate = speed;
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

        let isDraggingScrubber = false;
        function onScrubberInput(val) {
            isDraggingScrubber = true;
            if (audioEl && audioEl.duration) {
                const targetSec = (val / 100) * audioEl.duration;
                if (curTimeDisplay) curTimeDisplay.innerText = formatTime(targetSec);
            }
        }

        function onScrubberChange(val) {
            if (audioEl && audioEl.duration) {
                audioEl.currentTime = (val / 100) * audioEl.duration;
            }
            isDraggingScrubber = false;
        }

        if (audioEl) {
            audioEl.addEventListener('play', () => {
                if (playIcon) playIcon.innerText = '❚❚';
                if (playBtn) playBtn.style.background = '#4ade80';
            });

            audioEl.addEventListener('pause', () => {
                if (playIcon) playIcon.innerText = '▶';
                if (playBtn) playBtn.style.background = '#38bdf8';
            });

            audioEl.addEventListener('timeupdate', () => {
                if (!isDraggingScrubber && audioEl.duration) {
                    const percent = (audioEl.currentTime / audioEl.duration) * 100;
                    if (scrubber) scrubber.value = percent;
                    if (curTimeDisplay) curTimeDisplay.innerText = formatTime(audioEl.currentTime);
                }
            });

            audioEl.addEventListener('loadedmetadata', () => {
                if (audioEl.duration && totalTimeDisplay) {
                    totalTimeDisplay.innerText = formatTime(audioEl.duration);
                    updateDurationHeaders(audioEl.duration);
                }
            });
        }

        function updateDurationHeaders(durationSeconds) {
            const totalSec = Math.round(durationSeconds);
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

        // ==========================================
        // 2. Fullscreen Toggle for PDF Viewers
        // ==========================================
        function togglePdfFullscreen(wrapperId) {
            const wrapper = document.getElementById(wrapperId);
            if (!wrapper) return;
            if (!document.fullscreenElement) {
                wrapper.requestFullscreen().catch(err => {
                    alert(`Vollbildmodus nicht möglich: ${err.message}`);
                });
            } else {
                document.exitFullscreen();
            }
        }

        // ==========================================
        // 3. Toggle Lesson Completion via AJAX
        // ==========================================
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

                if (data.success) {
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

        // ==========================================
        // 4. Abuse & Police Report Modal Handling
        // ==========================================
        function openAbuseModal() {
            const modal = document.getElementById('abuse-modal');
            if (modal) modal.style.display = 'flex';
        }

        function closeAbuseModal() {
            const modal = document.getElementById('abuse-modal');
            if (modal) modal.style.display = 'none';
        }

        function openSupportAssistant() {
            const btn = document.querySelector('.support-assistant__toggle');
            if (btn) {
                btn.click();
            } else {
                window.location.href = "mailto:mail@besseler.de?subject=Supportanfrage%20Kursportal";
            }
        }

        function generatePoliceDraft() {
            const urlVal = document.getElementById('abuse-url')?.value.trim() || 'Nicht angegeben';
            const descVal = document.getElementById('abuse-description')?.value.trim() || 'Keine nähere Beschreibung';
            const now = new Date().toLocaleString('de-DE');

            const draft = `STRAFANZEIGE & STRAFANTRAG gem. § 106 UrhG\n` +
                          `============================================================\n` +
                          `An: Zuständige Polizeidienststelle / Staatsanwaltschaft\n` +
                          `Datum/Zeit: ${now}\n` +
                          `Geschädigter Rechteinhaber: Dennis Besseler, Aachenerstr. 1193, 50858 Köln\n` +
                          `Betroffener Kurs: {{ $course->title }}\n` +
                          `Lektion: {{ $lesson->title }} (Lektion {{ $lesson->lesson_number }})\n\n` +
                          `Sachverhalt:\n` +
                          `Unerlaubte öffentliche Zugänglichmachung bzw. Weitergabe urheberrechtlich\n` +
                          `geschützter Kursdateien und Audio-Werke.\n\n` +
                          `Fundort / Übertragungsmedium: ${urlVal}\n` +
                          `Festgestellte Tatsachen: ${descVal}\n\n` +
                          `Digitales Wasserzeichen / Lizenzreferenz im Werk:\n` +
                          `Lizenz: {{ $watermarkText }}\n\n` +
                          `Hiermit wird ausdrücklich Strafantrag wegen aller in Betracht kommenden\n` +
                          `Delikte gestellt.\n` +
                          `============================================================`;

            navigator.clipboard.writeText(draft).then(() => {
                alert('Der Strafanzeige-Entwurf wurde in die Zwischenablage kopiert!');
            }).catch(() => {
                prompt('Strafanzeige-Entwurf:', draft);
            });
        }
    </script>
@endsection
