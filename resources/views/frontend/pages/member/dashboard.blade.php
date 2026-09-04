@extends('frontend.layouts.app')

@section('contents')
    <main class="customer-login-page cat-academy" style="min-height: 100vh; display: flex; flex-direction: column;">
        <div class="portal-notice">
            @if(Auth::user()->isStaff())
                <strong>Geschützter Mitarbeiterbereich</strong>
                <span>Interner Arbeitsplatz &amp; Zeiterfassung für Kundenbetreuung und Freigaben.</span>
            @elseif(Auth::user()->isAdmin())
                <strong>Geschützter Kundenbereich (Admin-Vorschau)</strong>
                <span>Persönliches Dashboard für Ihre freigeschalteten Kurse.</span>
            @else
                <strong>Geschützter Kundenbereich</strong>
                <span>Persönliches Dashboard für Ihre freigeschalteten Kurse.</span>
            @endif
        </div>
        <header class="portal-header course-header">
            <a href="{{ route('home') }}" class="portal-brand">
                <strong>DENNIS BESSELER</strong>
                <span>Kursportal</span>
            </a>
            <nav>
                <a href="{{ route('home') }}">Startseite</a>
                <a href="{{ route('member.dashboard') }}" aria-current="page">{{ Auth::user()->isStaff() ? 'Mitarbeiterbereich' : 'Mein Lernbereich' }}</a>
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" style="color:#38bdf8; font-weight:bold;">Admin-Verwaltung ↗</a>
                @elseif(Auth::user()->isStaff())
                    <a href="{{ route('admin.dashboard') }}" style="color:#38bdf8; font-weight:bold;">Kundenverwaltung ↗</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" style="background:none; border:none; color:#f87171; cursor:pointer; font-weight:500; font-size:inherit;">Abmelden</button>
                </form>
            </nav>
        </header>

        <div style="max-width: 1200px; width: 100%; margin: 2rem auto; padding: 0 1.5rem; flex: 1;">
            
            @if(Auth::user()->isStaff())
                {{-- ======================================================== --}}
                {{-- DEDICATED STAFF / MITARBEITER WORKSPACE --}}
                {{-- ======================================================== --}}
                
                {{-- Staff Hero --}}
                <div style="background: #1e293b; border-radius: 12px; padding: 2rem; border: 1px solid #334155; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <div style="display: flex; gap: 0.5rem; align-items: center; margin-bottom: 0.5rem; flex-wrap: wrap;">
                            <span style="display: inline-block; padding: 0.25rem 0.75rem; background: #0284c7; color: #fff; border-radius: 20px; font-size: 0.8rem; font-weight: bold; letter-spacing: 0.04em;">
                                MITARBEITER-ARBEITSPLATZ
                            </span>
                            <a href="{{ route('admin.dashboard') }}" style="display: inline-flex; align-items: center; gap: 4px; padding: 0.25rem 0.75rem; background: rgba(56, 189, 248, 0.2); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.4); border-radius: 20px; font-size: 0.8rem; font-weight: bold; text-decoration: none;">
                                ⚙ Kundenverwaltung öffnen ↗
                            </a>
                        </div>
                        <h1 style="color: #f8fafc; font-size: 1.8rem; margin: 0.25rem 0 0.5rem 0;">
                            Willkommen zurück, {{ Auth::user()->first_name ?: Auth::user()->name }}!
                        </h1>
                        <p style="color: #94a3b8; margin: 0; font-size: 0.95rem;">
                            Tätigkeit: <strong style="color: #38bdf8;">{{ Auth::user()->occupation ?: 'Kundenservice & Freigaben' }}</strong> · Benutzername: <code style="color: #cbd5e1;">{{ Auth::user()->username }}</code>
                            @if(Auth::user()->access_until)
                                · Gültig bis: <span style="color: #cbd5e1;">{{ Auth::user()->access_until->format('d.m.Y') }}</span>
                            @endif
                        </p>
                    </div>
                    <div style="background: #0f172a; padding: 0.75rem 1.25rem; border-radius: 8px; border: 1px solid #334155; font-size: 0.85rem; color: #94a3b8;">
                        <div style="color: #4ade80; font-weight: bold; margin-bottom: 0.25rem;">🔒 Einzelgeräte-Schutz aktiv</div>
                        <div>Gebunden an: {{ Auth::user()->device_name ?: 'Dieses Arbeitsgerät' }}</div>
                    </div>
                </div>

                {{-- Staff Workspace Panels Grid --}}
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
                    
                    {{-- Panel 1: Live Zeiterfassung & Stoppuhr --}}
                    <div style="background: #1e293b; border-radius: 12px; padding: 1.75rem; border: 1px solid #334155; display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="font-size: 1.25rem;">⏱</span>
                                    <h2 style="color: #f8fafc; font-size: 1.2rem; margin: 0; font-weight: 700;">Arbeitszeiterfassung</h2>
                                </div>
                                <span style="background: rgba(56, 189, 248, 0.15); color: #38bdf8; font-size: 0.75rem; font-weight: 700; padding: 0.2rem 0.6rem; border-radius: 12px; border: 1px solid rgba(56, 189, 248, 0.3);">
                                    Pflichtfunktion
                                </span>
                            </div>
                            <p style="color: #94a3b8; font-size: 0.9rem; line-height: 1.5; margin-bottom: 1.25rem;">
                                Bitte erfassen Sie Ihre Arbeitszeiten für Kundenbetreuung, Rechnungsprüfung und Freigaben minutengenau.
                            </p>
                            
                            <div style="background: #0f172a; border-radius: 8px; border: 1px solid #334155; padding: 1.2rem; text-align: center; margin-bottom: 1.25rem;">
                                <div style="font-size: 0.78rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem;">Stoppuhr-Schnellzugriff</div>
                                <button type="button" onclick="toggleTimeTrackerDrawer()" style="background: #0284c7; hover: #0369a1; color: #fff; border: none; font-weight: 700; font-size: 0.95rem; padding: 0.75rem 1.5rem; border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(2, 132, 199, 0.3); transition: all 0.2s;">
                                    <span>⏱</span> Zeiterfassung öffnen / Zeit buchen
                                </button>
                            </div>
                        </div>

                        <div style="display: flex; gap: 8px; border-top: 1px solid #334155; padding-top: 1rem;">
                            <button type="button" onclick="toggleTimeTrackerDrawer(); setTimeout(ttCopySummary, 200);" style="flex: 1; background: #0f172a; border: 1px solid #334155; color: #cbd5e1; padding: 8px 10px; border-radius: 6px; font-size: 0.8rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px;">
                                📋 Zusammenfassung kopieren
                            </button>
                            <a href="mailto:mail@besseler.de?subject=Arbeitszeiterfassung%20Sarah%20Schmidt" style="flex: 1; background: #0f172a; border: 1px solid #334155; color: #38bdf8; padding: 8px 10px; border-radius: 6px; font-size: 0.8rem; font-weight: 600; text-decoration: none; text-align: center; display: flex; align-items: center; justify-content: center; gap: 6px;">
                                ✉ E-Mail an Dennis
                            </a>
                        </div>
                    </div>

                    {{-- Panel 2: Aufgaben & Zuständigkeiten --}}
                    <div style="background: #1e293b; border-radius: 12px; padding: 1.75rem; border: 1px solid #334155; display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="font-size: 1.25rem;">📋</span>
                                    <h2 style="color: #f8fafc; font-size: 1.2rem; margin: 0; font-weight: 700;">Zuständigkeitsbereich</h2>
                                </div>
                                <span style="background: rgba(74, 222, 128, 0.15); color: #4ade80; font-size: 0.75rem; font-weight: 700; padding: 0.2rem 0.6rem; border-radius: 12px; border: 1px solid rgba(74, 222, 128, 0.3);">
                                    Aktiv
                                </span>
                            </div>
                            <ul style="color: #cbd5e1; font-size: 0.88rem; line-height: 1.7; margin: 0; padding-left: 1.25rem;">
                                <li><strong>Kundenanfragen &amp; Support:</strong> Schnelle und verbindliche Betreuung eingehender Teilnehmer-Nachrichten.</li>
                                <li><strong>Rechnungsprüfung:</strong> Abgleich von Zahlungseingängen vor der Kursfreischaltung.</li>
                                <li><strong>Gerätebindung &amp; Urheberrecht:</strong> Beachtung des Einzelgeräte-Schutzes und Prüfung von Missbrauchsmeldungen.</li>
                            </ul>
                        </div>

                        <div style="background: #0f172a; border-radius: 8px; border: 1px solid #334155; padding: 0.85rem 1rem; margin-top: 1.25rem; font-size: 0.82rem; color: #94a3b8;">
                            <strong style="color: #f8fafc; display: block; margin-bottom: 0.2rem;">Support-Kontakt für Mitarbeiter:</strong>
                            Bei administrativen Fragen wenden Sie sich direkt an Dennis Besseler unter <a href="mailto:mail@besseler.de" style="color: #38bdf8; text-decoration: none;">mail@besseler.de</a>.
                        </div>
                    </div>
                </div>

                {{-- Schulungskurse (Optional für Mitarbeiter) --}}
                <h2 style="color: #0f172a; font-size: 1.3rem; font-weight: 700; margin-bottom: 1rem;">Interne Schulungs- &amp; Prüfungskurse</h2>
                @if($coursesWithProgress->count() > 0)
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
                        @foreach($coursesWithProgress as $item)
                            @php
                                $course = $item['course'];
                                $progress = $item['progress'];
                                $nextLesson = $item['next_lesson'];
                            @endphp
                            <div style="background: #1e293b; border-radius: 12px; padding: 1.75rem; border: 1px solid #334155; display: flex; flex-direction: column; justify-content: space-between;">
                                <div>
                                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem;">
                                        <span style="font-size: 0.8rem; color: #38bdf8; text-transform: uppercase; font-weight: bold;">{{ $course->category ?: 'Schulungskurs' }}</span>
                                        <span style="font-size: 0.85rem; color: #94a3b8;">{{ $course->lessons_count ?: $item['total_lessons'] }} Lektionen</span>
                                    </div>
                                    <h3 style="color: #f8fafc; font-size: 1.3rem; margin: 0 0 0.5rem 0;">{{ $course->title }}</h3>
                                    <p style="color: #94a3b8; font-size: 0.9rem; line-height: 1.5; margin-bottom: 1.25rem;">
                                        {{ $course->subtitle ?: Str::limit($course->description, 100) }}
                                    </p>
                                </div>
                                <div>
                                    @if($nextLesson)
                                        <a href="{{ route('course.lesson', ['courseSlug' => $course->slug, 'lessonSlug' => $nextLesson->slug]) }}" style="display: block; text-align: center; background: #0284c7; color: #fff; font-weight: bold; padding: 0.75rem 1.25rem; border-radius: 6px; text-decoration: none;">
                                            Schulung öffnen →
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="background: #1e293b; padding: 1.5rem 2rem; border-radius: 10px; border: 1px solid #334155; color: #94a3b8; font-size: 0.88rem; margin-bottom: 2rem;">
                        <span style="color: #cbd5e1; font-weight: 600;">Information:</span> Derzeit sind Ihrem Mitarbeiterkonto keine internen Lehrgänge zugewiesen. Ihre Arbeitszeiten erfassen Sie bitte über das Stoppuhr-Modul.
                    </div>
                @endif

            @else
                {{-- ======================================================== --}}
                {{-- STANDARD CUSTOMER / MEMBER AREA --}}
                {{-- ======================================================== --}}
                
                {{-- Customer Welcome Hero --}}
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

                <h2 style="color: #0f172a; font-size: 1.4rem; font-weight: 700; margin-bottom: 1.25rem;">Meine freigeschalteten Kurse</h2>

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
            @endif
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
