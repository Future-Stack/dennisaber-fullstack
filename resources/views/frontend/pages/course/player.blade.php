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
                <span>Persönlicher Zugang für: {{ Auth::user()->first_name ?: Auth::user()->name }}</span>
            @endif
        </div>

        {{-- Course Top Navigation --}}
        <header class="portal-header course-header" style="border-bottom: 1px solid #1e293b; background: #0f172a;">
            <a href="{{ route('member.dashboard') }}" class="portal-brand">
                <strong>DENNIS BESSELER</strong>
                <span>{{ $course->title }}</span>
            </a>
            <nav style="display: flex; align-items: center; gap: 1rem;">
                <a href="{{ route('member.dashboard') }}" style="color: #94a3b8; font-weight: 500; text-decoration: none;">
                    ← Mein Lernbereich
                </a>
                <div style="background: #1e293b; padding: 0.35rem 0.75rem; border-radius: 20px; font-size: 0.85rem; color: #38bdf8; font-weight: bold; border: 1px solid #334155;">
                    <span id="progress-percent-display">{{ $progressPercent }}%</span> abgeschlossen
                </div>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" style="background:none; border:none; color:#f87171; cursor:pointer; font-weight:500; font-size:0.9rem;">Abmelden</button>
                </form>
            </nav>
        </header>

        {{-- Main Player & Curriculum Layout --}}
        <div style="max-width: 1400px; width: 100%; margin: 1.5rem auto; padding: 0 1.5rem; flex: 1; display: grid; grid-template-columns: 1fr 360px; gap: 2rem; align-items: start;">
            
            {{-- Left Column: Active Lesson Video, Content, and Controls --}}
            <div style="background: #131d31; border-radius: 12px; border: 1px solid #1e293b; overflow: hidden; padding: 1.75rem;">
                
                {{-- Module & Lesson Title --}}
                <div style="margin-bottom: 1.25rem;">
                    <span style="font-size: 0.85rem; color: #38bdf8; text-transform: uppercase; font-weight: bold; letter-spacing: 0.05em;">
                        {{ $lesson->chapter_name ?: 'Hauptmodul' }} · Lektion {{ $lesson->lesson_number }}
                    </span>
                    <h1 style="color: #f8fafc; font-size: 1.75rem; margin: 0.35rem 0 0.5rem 0; line-height: 1.3;">
                        {{ $lesson->title }}
                    </h1>
                    <div style="display: flex; gap: 1rem; color: #94a3b8; font-size: 0.85rem;">
                        <span>⏱ Dauer: {{ $lesson->duration_minutes }} Minuten</span>
                        <span>🔒 Geschütztes Medium</span>
                    </div>
                </div>

                {{-- Video Player Container --}}
                <div style="background: #020617; border-radius: 8px; overflow: hidden; position: relative; aspect-ratio: 16/9; margin-bottom: 1.5rem; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5); border: 1px solid #1e293b;">
                    @if($lesson->video_url)
                        <video controls style="width: 100%; height: 100%; object-fit: cover;" poster="/frontend/assets/video-poster.jpg">
                            <source src="{{ $lesson->video_url }}" type="video/mp4">
                            Ihr Browser unterstützt das Video-Tag leider nicht.
                        </video>
                    @else
                        <div style="width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #64748b;">
                            <span style="font-size: 3rem; margin-bottom: 0.5rem;">🎬</span>
                            <p style="margin: 0; font-size: 0.95rem;">Lektionsvideo wird geladen …</p>
                        </div>
                    @endif
                </div>

                {{-- Lesson Completion & Action Bar --}}
                <div style="background: #0f172a; padding: 1rem 1.25rem; border-radius: 8px; border: 1px solid #1e293b; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem;">
                    
                    {{-- Toggle Completed Button (AJAX) --}}
                    <button id="toggle-complete-btn" onclick="toggleLessonComplete()" style="background: {{ $isCurrentCompleted ? '#16a34a' : '#0284c7' }}; color: #fff; border: none; font-weight: bold; padding: 0.65rem 1.25rem; border-radius: 6px; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; transition: background 0.2s;">
                        <span id="btn-icon">{{ $isCurrentCompleted ? '✓' : '○' }}</span>
                        <span id="btn-text">{{ $isCurrentCompleted ? 'Lektion abgeschlossen' : 'Als abgeschlossen markieren' }}</span>
                    </button>

                    {{-- Previous / Next Navigation --}}
                    <div style="display: flex; gap: 0.5rem;">
                        @if($prevLesson)
                            <a href="{{ route('course.lesson', ['courseSlug' => $course->slug, 'lessonSlug' => $prevLesson->slug]) }}" style="background: #1e293b; color: #cbd5e1; padding: 0.65rem 1rem; border-radius: 6px; text-decoration: none; font-size: 0.9rem; font-weight: 500; border: 1px solid #334155;">
                                ← Vorherige
                            </a>
                        @endif

                        @if($nextLesson)
                            <a href="{{ route('course.lesson', ['courseSlug' => $course->slug, 'lessonSlug' => $nextLesson->slug]) }}" style="background: #38bdf8; color: #0f172a; padding: 0.65rem 1rem; border-radius: 6px; text-decoration: none; font-size: 0.9rem; font-weight: bold;">
                                Nächste Lektion →
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Lesson Content & Reading Material --}}
                <div style="color: #cbd5e1; font-size: 1rem; line-height: 1.7; margin-bottom: 2rem;" class="lesson-rich-text">
                    @if($lesson->content_html)
                        {!! $lesson->content_html !!}
                    @else
                        <p>Bearbeiten Sie die Lektion und führen Sie die begleitenden Reflexionsübungen durch.</p>
                    @endif
                </div>

                {{-- Downloadable Protected Materials Card --}}
                @if($lesson->pdf_attachment_name || $lesson->pdf_attachment_path)
                    <div style="background: #1e293b; border-radius: 8px; padding: 1.25rem; border: 1px solid #334155; display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <span style="font-size: 2rem;">📄</span>
                            <div>
                                <strong style="color: #f8fafc; display: block; font-size: 0.95rem;">
                                    {{ $lesson->pdf_attachment_name ?: 'Begleitendes Arbeitsblatt (PDF)' }}
                                </strong>
                                <span style="color: #94a3b8; font-size: 0.8rem;">Geschütztes Lernmaterial · Persönlicher Download</span>
                            </div>
                        </div>
                        <a href="{{ route('media.stream', ['courseSlug' => $course->slug, 'lessonSlug' => $lesson->slug, 'type' => 'pdf']) }}" target="_blank" style="background: #334155; color: #38bdf8; border: 1px solid #38bdf8; padding: 0.5rem 1rem; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 0.85rem; transition: background 0.2s;">
                            PDF öffnen / herunterladen ↗
                        </a>
                    </div>
                @endif

                {{-- Audio Player Card (if present) --}}
                @if($lesson->audio_path)
                    <div style="background: #1e293b; border-radius: 8px; padding: 1.25rem; border: 1px solid #334155; margin-top: 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                            <span style="font-size: 1.75rem;">🎧</span>
                            <div>
                                <strong style="color: #f8fafc; display: block; font-size: 0.95rem;">Begleitende Audio-Reflexionsübung</strong>
                                <span style="color: #94a3b8; font-size: 0.8rem;">Geführte Audio-Sequenz für die praktische Umsetzung</span>
                            </div>
                        </div>
                        <audio controls style="width: 100%; border-radius: 4px;">
                            <source src="{{ route('media.stream', ['courseSlug' => $course->slug, 'lessonSlug' => $lesson->slug, 'type' => 'audio']) }}" type="audio/mpeg">
                            Ihr Browser unterstützt das Audio-Element nicht.
                        </audio>
                    </div>
                @endif
            </div>

            {{-- Right Column: Course Curriculum Sidebar --}}
            <aside style="background: #131d31; border-radius: 12px; border: 1px solid #1e293b; overflow: hidden;">
                <div style="padding: 1.25rem 1.5rem; background: #0f172a; border-bottom: 1px solid #1e293b;">
                    <h2 style="color: #f8fafc; font-size: 1.1rem; margin: 0 0 0.25rem 0;">Inhaltsverzeichnis</h2>
                    <span style="color: #94a3b8; font-size: 0.85rem;">{{ $allLessons->count() }} Lektionen im Lehrgang</span>
                </div>

                <div style="padding: 1rem 0;">
                    @foreach($chapters as $chapterName => $chapterLessons)
                        <div style="margin-bottom: 1rem;">
                            <div style="padding: 0.4rem 1.5rem; font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: bold; letter-spacing: 0.05em;">
                                {{ $chapterName }}
                            </div>
                            <div>
                                @foreach($chapterLessons as $item)
                                    @php
                                        $isItemActive = $item->id === $lesson->id;
                                        $isItemCompleted = in_array($item->id, $completedIds);
                                    @endphp
                                    <a href="{{ route('course.lesson', ['courseSlug' => $course->slug, 'lessonSlug' => $item->slug]) }}" style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1.5rem; text-decoration: none; background: {{ $isItemActive ? '#1e293b' : 'transparent' }}; border-left: 3px solid {{ $isItemActive ? '#38bdf8' : 'transparent' }}; transition: background 0.15s;">
                                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                                            <span id="sidebar-icon-{{ $item->id }}" style="color: {{ $isItemCompleted ? '#4ade80' : '#64748b' }}; font-weight: bold; font-size: 1rem;">
                                                {{ $isItemCompleted ? '✓' : '○' }}
                                            </span>
                                            <span style="color: {{ $isItemActive ? '#f8fafc' : ($isItemCompleted ? '#cbd5e1' : '#94a3b8') }}; font-size: 0.9rem; font-weight: {{ $isItemActive ? '600' : 'normal' }};">
                                                {{ $item->lesson_number }}. {{ $item->title }}
                                            </span>
                                        </div>
                                        <span style="color: #64748b; font-size: 0.75rem;">{{ $item->duration_minutes }}m</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </aside>
        </div>

        <footer class="site-footer" style="background: #0f172a; border-top: 1px solid #1e293b; margin-top: auto;">
            <div>
                <strong>DENNIS BESSELER</strong>
                <p>Persönliche Kurszugänge · einmalige Zahlung · kein Abonnement</p>
            </div>
            <nav aria-label="Rechtliche Hinweise">
                <a href="{{ route('login') }}">Kundenlogin</a>
                <a href="{{ route('copy-protection') }}">Kopierschutz</a>
                <a href="{{ route('payment') }}">Zahlung</a>
                <a href="{{ route('imprint') }}">Impressum</a>
                <a href="{{ route('privacy-policy') }}">Datenschutz</a>
            </nav>
        </footer>
    </main>

    {{-- Interactive AJAX completion script --}}
    <script>
        function toggleLessonComplete() {
            const btn = document.getElementById('toggle-complete-btn');
            const icon = document.getElementById('btn-icon');
            const text = document.getElementById('btn-text');
            const currentLessonId = {{ $lesson->id }};

            fetch("{{ route('course.lesson.toggle', ['courseSlug' => $course->slug, 'lessonSlug' => $lesson->slug]) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (data.is_completed) {
                        btn.style.background = '#16a34a';
                        icon.innerText = '✓';
                        text.innerText = 'Lektion abgeschlossen';
                        const sidebarIcon = document.getElementById(`sidebar-icon-${currentLessonId}`);
                        if (sidebarIcon) {
                            sidebarIcon.innerText = '✓';
                            sidebarIcon.style.color = '#4ade80';
                        }
                    } else {
                        btn.style.background = '#0284c7';
                        icon.innerText = '○';
                        text.innerText = 'Als abgeschlossen markieren';
                        const sidebarIcon = document.getElementById(`sidebar-icon-${currentLessonId}`);
                        if (sidebarIcon) {
                            sidebarIcon.innerText = '○';
                            sidebarIcon.style.color = '#64748b';
                        }
                    }
                    // Update header progress percent
                    const progressEl = document.getElementById('progress-percent-display');
                    if (progressEl) {
                        progressEl.innerText = `${data.progress_percent}%`;
                    }
                }
            })
            .catch(err => {
                console.error('Fehler beim Speichern des Fortschritts:', err);
            });
        }
    </script>
@endsection
