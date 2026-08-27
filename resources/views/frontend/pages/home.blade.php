@extends('frontend.layouts.app')

@section('contents')
    <main class="portal-home">
        <div class="portal-notice">
            <strong>Technisches Kursportal</strong>
            <span>Keine Bestellung auf dieser Website. <a href="#kurse">Kurse im Überblick ansehen →</a></span>
        </div>
        @include('frontend.components.header')

        <section class="portal-hero">
            <div>
                <p class="eyebrow">Digitale Kurse · geschützt und persönlich</p>
                <h1>Ein Portal.<br/>Elf klare Einstiege.</h1>
            </div>
            <div class="portal-hero-copy">
                <p>Jeder Kurs besitzt eine eigene Landingpage, einen eigenen persönlichen Zugang und einen geschützten Kursbereich.</p>
                <div>
                    <a href="#academy">11 Kurse <b>↓</b></a>
                    <a href="#bezahlung">Kein Abo <b>↓</b></a>
                    <a href="#laufzeiten">Klare Laufzeiten <b>↓</b></a>
                </div>
                <small>Einmalige Zahlung · der Zugang endet automatisch.</small>
            </div>
        </section>

        <section class="access-terms" id="laufzeiten">
            <header>
                <p class="eyebrow">Klare Laufzeiten</p>
                <h2>Einmal freigeschaltet. Automatisch beendet.</h2>
            </header>
            <div>
                <article>
                    <span>Reguläre Kurse</span>
                    <strong>Drei Monate</strong>
                    <p>Ab der individuellen Freischaltung.</p>
                    <a href="{{ route('course-compact') }}">Zum Fünf-Tage-Kurs →</a>
                </article>
                <article>
                    <span>Rio Negro 2002</span>
                    <strong>30 Tage</strong>
                    <p>Einzige Ausnahme für das Abenteuer für 24,90 €.</p>
                    <a href="{{ route('rio-negro') }}">Zum Abenteuer →</a>
                </article>
                <article>
                    <span>Für alle Kurse</span>
                    <strong>Kein Abo</strong>
                    <p>Keine automatische Verlängerung und keine weitere Abbuchung.</p>
                    <a href="#bezahlung">So funktioniert die Freischaltung →</a>
                </article>
            </div>
        </section>

        <section class="course-catalog" id="kurse">
            {{-- Academy Group --}}
            <section class="catalog-group cat-academy" id="academy">
                <header>
                    <span>01 · Blau</span>
                    <h2>Entscheiden &amp; führen</h2>
                </header>
                <div class="catalog-grid">
                    <a href="{{ route('course-compact') }}" class="catalog-card">
                        <p>DNL-Akademie</p>
                        <h3>5-Tage-Kompaktlehrgang</h3>
                        <div class="catalog-card-bottom">
                            <strong>490 €</strong>
                            <span>Drei Monate ab Freischaltung</span>
                            <b>Landingpage öffnen →</b>
                        </div>
                    </a>
                    <a href="{{ route('course-advanced') }}" class="catalog-card">
                        <p>DNL-Akademie</p>
                        <h3>Vertiefungsausbildung</h3>
                        <div class="catalog-card-bottom">
                            <strong>890 €</strong>
                            <span>Drei Monate ab Freischaltung</span>
                            <b>Landingpage öffnen →</b>
                        </div>
                    </a>
                    <a href="{{ route('course-premium') }}" class="catalog-card">
                        <p>DNL-Akademie</p>
                        <h3>Premium-Seminar</h3>
                        <div class="catalog-card-bottom">
                            <strong>1.490 €</strong>
                            <span>Drei Monate ab Freischaltung</span>
                            <b>Landingpage öffnen →</b>
                        </div>
                    </a>
                </div>
            </section>

            {{-- Prevention Group --}}
            <section class="catalog-group cat-prevention" id="prevention">
                <header>
                    <span>02 · Grün</span>
                    <h2>Gesundheit verändern</h2>
                </header>
                <div class="catalog-grid">
                    <a href="{{ route('stress-resources') }}" class="catalog-card">
                        <p>Gesund Voraus</p>
                        <h3>Stress und Ressourcen</h3>
                        <div class="catalog-card-bottom">
                            <strong>199 €</strong>
                            <span>Drei Monate ab Freischaltung</span>
                            <b>Landingpage öffnen →</b>
                        </div>
                    </a>
                    <a href="{{ route('smoke-free') }}" class="catalog-card">
                        <p>Gesund Voraus</p>
                        <h3>Rauchfrei</h3>
                        <div class="catalog-card-bottom">
                            <strong>199 €</strong>
                            <span>Drei Monate ab Freischaltung</span>
                            <b>Landingpage öffnen →</b>
                        </div>
                    </a>
                    <a href="{{ route('course-nutrition') }}" class="catalog-card">
                        <p>Gesund Voraus</p>
                        <h3>Ernährung</h3>
                        <div class="catalog-card-bottom">
                            <strong>199 €</strong>
                            <span>Drei Monate ab Freischaltung</span>
                            <b>Landingpage öffnen →</b>
                        </div>
                    </a>
                    <a href="{{ route('course-make-decision') }}" class="catalog-card">
                        <p>Psychologie &amp; Prävention</p>
                        <h3>Klar entscheiden</h3>
                        <div class="catalog-card-bottom">
                            <strong>199 €</strong>
                            <span>Drei Monate ab Freischaltung</span>
                            <b>Landingpage öffnen →</b>
                        </div>
                    </a>
                </div>
            </section>

            {{-- Business Group --}}
            <section class="catalog-group cat-business" id="business">
                <header>
                    <span>03 · Orange</span>
                    <h2>Gründen &amp; Wirkung</h2>
                </header>
                <div class="catalog-grid">
                    <a href="{{ route('successful-startup') }}" class="catalog-card">
                        <p>Business</p>
                        <h3>Erfolgreich gründen</h3>
                        <div class="catalog-card-bottom">
                            <strong>1.690 €</strong>
                            <span>Drei Monate ab Freischaltung</span>
                            <b>Landingpage öffnen →</b>
                        </div>
                    </a>
                    <a href="{{ route('course-press-public') }}" class="catalog-card">
                        <p>Erlebte Medienpraxis</p>
                        <h3>Presse &amp; Öffentlichkeit</h3>
                        <div class="catalog-card-bottom">
                            <strong>390 €</strong>
                            <span>Drei Monate ab Freischaltung</span>
                            <b>Landingpage öffnen →</b>
                        </div>
                    </a>
                    <a href="{{ route('course-under-pressure') }}" class="catalog-card">
                        <p>Wirkung</p>
                        <h3>Rhetorik unter Druck</h3>
                        <div class="catalog-card-bottom">
                            <strong>249 €</strong>
                            <span>Drei Monate ab Freischaltung</span>
                            <b>Landingpage öffnen →</b>
                        </div>
                    </a>
                </div>
            </section>

            {{-- Adventure Group --}}
            <section class="catalog-group cat-adventure" id="adventure">
                <header>
                    <span>04 · Rot</span>
                    <h2>Abenteuer</h2>
                </header>
                <div class="catalog-grid">
                    <a href="{{ route('rio-negro') }}" class="catalog-card">
                        <p>Audio-Abenteuer</p>
                        <h3>Rio Negro 2002</h3>
                        <div class="catalog-card-bottom">
                            <strong>24,90 €</strong>
                            <span>30 Tage ab Freischaltung</span>
                            <b>Landingpage öffnen →</b>
                        </div>
                    </a>
                </div>
            </section>
        </section>

        <section class="portal-principles">
            <div>
                <p class="eyebrow">Technische Kursplattform</p>
                <h2>Einloggen. Kurs bearbeiten. Fortschritt sichern.</h2>
            </div>
            <div class="principle-grid">
                <article>
                    <span>01</span>
                    <h3>Information auf besseler.de</h3>
                    <p>Beratung, Leistungsbeschreibung und Buchung erfolgen auf besseler.de.</p>
                </article>
                <article>
                    <span>02</span>
                    <h3>Persönlicher Login</h3>
                    <p>Bereits freigeschaltete Kunden gelangen mit Benutzername und Passwort direkt in ihren gebuchten Kurs.</p>
                    <a href="{{ route('login') }}">Zum aktuellen Kundenlogin →</a>
                </article>
                <article>
                    <span>03</span>
                    <h3>Geschützter Kursbereich</h3>
                    <p>Hier werden die von uns bereitgestellten Kursinhalte technisch ausgeliefert und der Bearbeitungsstand gespeichert.</p>
                </article>
            </div>
        </section>

        <section class="payment-process" id="bezahlung">
            <header>
                <p class="eyebrow">Klare Trennung</p>
                <h2>Information und Buchung auf besseler.de. Kursnutzung hier.</h2>
                <p>Diese Website ist ausschließlich die technische Kursplattform für bereits freigeschaltete Kunden. Sie dient weder der Werbung noch der Beratung oder Bestellung.</p>
            </header>
            <div class="payment-steps">
                <article>
                    <span>01</span>
                    <h3>Auf besseler.de informieren</h3>
                    <p>Alle Informationen, Beratung und die verbindliche Buchung finden auf besseler.de statt.</p>
                </article>
                <article>
                    <span>02</span>
                    <h3>Persönlichen Zugang erhalten</h3>
                    <p>Nach der Buchung und dem eindeutig zugeordneten Zahlungseingang wird das Kundenkonto freigeschaltet.</p>
                </article>
                <article>
                    <span>03</span>
                    <h3>Überweisung ausführen</h3>
                    <p>Rechnung, GiroCode, Bankdaten und eindeutigen Verwendungszweck verwenden.</p>
                </article>
                <article>
                    <span>04</span>
                    <h3>Kurs hier nutzen</h3>
                    <p>Bereits freigeschaltete Kunden melden sich an und bearbeiten ihre gebuchten Kursinhalte.</p>
                </article>
            </div>
            <div class="payment-note">
                <p><strong>Dieses Portal verkauft nichts:</strong> Es stellt ausschließlich die von uns erbrachte technische Kursleistung für bereits freigeschaltete Kunden bereit.</p>
                <div class="payment-note-links">
                    <a href="{{ route('login') }}">Zum Kundenlogin →</a>
                    <a href="{{ route('payment') }}">Hinweise für bestehende Rechnungen →</a>
                </div>
            </div>
        </section>

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
