@extends('frontend.layouts.app')

@section('contents')
    <main class="customer-login-page cat-academy" style="min-height: 100vh; display: flex; flex-direction: column;">
        <div class="portal-notice">
            <strong>Geschützter Kundenbereich</strong>
            <span>Persönliches Dashboard für Ihre freigeschalteten Kurse.</span>
        </div>
        <header class="portal-header course-header">
            <a href="{{ route('home') }}" class="portal-brand">
                <strong>DENNIS BESSELER</strong>
                <span>Kursportal</span>
            </a>
            <nav>
                <a href="{{ route('home') }}">Startseite</a>
                <a href="{{ route('member.dashboard') }}" aria-current="page">Mein Lernbereich</a>
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" style="color:#38bdf8; font-weight:bold;">Admin-Verwaltung ↗</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" style="background:none; border:none; color:#f87171; cursor:pointer; font-weight:500; font-size:inherit;">Abmelden</button>
                </form>
            </nav>
        </header>

        <div style="max-width: 1200px; width: 100%; margin: 2rem auto; padding: 0 1.5rem; flex: 1;">
            {{-- Welcome Hero --}}
            <div style="background: #1e293b; border-radius: 12px; padding: 2rem; border: 1px solid #334155; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <span style="display: inline-block; padding: 0.25rem 0.75rem; background: #0284c7; color: #fff; border-radius: 20px; font-size: 0.8rem; font-weight: bold; margin-bottom: 0.5rem;">
                        {{ Auth::user()->isAdmin() ? 'ADMINISTRATOR-VORSCHAU' : 'KUNDENKONTO' }}
                    </span>
                    <h1 style="color: #f8fafc; font-size: 1.8rem; margin: 0.25rem 0 0.5rem 0;">
                        Willkommen zurück, {{ Auth::user()->first_name ?: Auth::user()->name }}!
                    </h1>
                    <p style="color: #94a3b8; margin: 0; font-size: 0.95rem;">
                        Rechnungsnummer: <strong style="color: #cbd5e1;">{{ Auth::user()->invoice_number ?: 'Interne Freischaltung' }}</strong> · Benutzername: <code style="color: #38bdf8;">{{ Auth::user()->username }}</code>
                    </p>
                </div>
                <div style="background: #0f172a; padding: 0.75rem 1.25rem; border-radius: 8px; border: 1px solid #334155; font-size: 0.85rem; color: #94a3b8;">
                    <div style="color: #4ade80; font-weight: bold; margin-bottom: 0.25rem;">🔒 Einzelgeräte-Schutz aktiv</div>
                    <div>Gebunden an: {{ Auth::user()->device_name ?: 'Dieses Gerät' }}</div>
                </div>
            </div>

            <h2 style="color: #f8fafc; font-size: 1.4rem; margin-bottom: 1.25rem;">Meine freigeschalteten Kurse</h2>

            @if($coursesWithProgress->count() > 0)
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
                    @foreach($coursesWithProgress as $item)
                        @php
                            $course = $item['course'];
                            $progress = $item['progress'];
                            $nextLesson = $item['next_lesson'];
                        @endphp
                        <div style="background: #1e293b; border-radius: 12px; padding: 1.75rem; border: 1px solid #334155; display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.2s, border-color 0.2s;">
                            <div>
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem;">
                                    <span style="font-size: 0.8rem; color: #38bdf8; text-transform: uppercase; font-weight: bold;">
                                        {{ $course->category ?: 'Kurs' }}
                                    </span>
                                    <span style="font-size: 0.85rem; color: #94a3b8; font-weight: 500;">
                                        {{ $course->lessons_count ?: $item['total_lessons'] }} Lektionen
                                    </span>
                                </div>
                                <h3 style="color: #f8fafc; font-size: 1.3rem; margin: 0 0 0.5rem 0;">{{ $course->title }}</h3>
                                <p style="color: #94a3b8; font-size: 0.9rem; line-height: 1.5; margin-bottom: 1.25rem;">
                                    {{ $course->subtitle ?: Str::limit($course->description, 100) }}
                                </p>
                            </div>

                            <div>
                                {{-- Progress bar --}}
                                <div style="margin-bottom: 1.25rem;">
                                    <div style="display: flex; justify-content: space-between; font-size: 0.85rem; color: #cbd5e1; margin-bottom: 0.4rem;">
                                        <span>Fortschritt ({{ $item['completed_count'] }}/{{ $item['total_lessons'] }})</span>
                                        <strong style="color: #38bdf8;">{{ $progress }}%</strong>
                                    </div>
                                    <div style="width: 100%; height: 8px; background: #0f172a; border-radius: 4px; overflow: hidden;">
                                        <div style="width: {{ $progress }}%; height: 100%; background: linear-gradient(90deg, #0284c7, #38bdf8); transition: width 0.4s ease;"></div>
                                    </div>
                                </div>

                                {{-- Action Button --}}
                                @if($nextLesson)
                                    <a href="{{ route('course.lesson', ['courseSlug' => $course->slug, 'lessonSlug' => $nextLesson->slug]) }}" style="display: block; text-align: center; background: #0284c7; color: #fff; font-weight: bold; padding: 0.75rem 1.25rem; border-radius: 6px; text-decoration: none; transition: background 0.2s;">
                                        @if($progress === 0)
                                            Kurs starten →
                                        @elseif($progress === 100)
                                            Kurs wiederholen →
                                        @else
                                            Weiterlernen (Lektion {{ $nextLesson->lesson_number }}) →
                                        @endif
                                    </a>
                                @else
                                    <a href="{{ route('course.show', $course->slug) }}" style="display: block; text-align: center; background: #334155; color: #94a3b8; font-weight: bold; padding: 0.75rem 1.25rem; border-radius: 6px; text-decoration: none;">
                                        Kursübersicht öffnen →
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="background: #1e293b; padding: 2.5rem; border-radius: 12px; text-align: center; color: #94a3b8; border: 1px dashed #475569; margin-bottom: 2rem;">
                    <p style="font-size: 1.1rem; color: #cbd5e1; margin-bottom: 0.5rem;">Aktuell sind keine aktiven Kurse für Ihr Konto hinterlegt.</p>
                    <p style="font-size: 0.9rem;">Nach erfolgter Buchung und Zahlungseingang wird Ihr gewünschter Kurs automatisch für Sie freigeschaltet.</p>
                </div>
            @endif

            {{-- Info Banner --}}
            <div style="background: #0f172a; border-radius: 8px; padding: 1.5rem; border-left: 4px solid #0284c7; color: #94a3b8; font-size: 0.9rem; line-height: 1.6;">
                <strong style="color: #f8fafc; display: block; margin-bottom: 0.25rem;">Hinweis zum geschützten Lernportal:</strong>
                Sämtliche Kursmaterialien, Videos und PDF-Arbeitsblätter sind urheberrechtlich geschützt und ausschließlich für Ihre persönliche Weiterbildung lizenziert. Der Bearbeitungsstand Ihrer Lektionen wird serverseitig gespeichert, sodass Sie jederzeit an Ihrer letzten Lektion fortfahren können.
            </div>
        </div>

        <footer class="site-footer">
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
@endsection
