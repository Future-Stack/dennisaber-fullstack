@extends('frontend.layouts.app')

@section('contents')
    <main class="course-landing cat-prevention">
        <div class="portal-notice">
            <strong>Technisches Kursportal</strong>
            <span>Keine Bestellung auf dieser Website. <a href="{{ route('home') }}">Kurse im Überblick ansehen →</a></span>
        </div>
        <header class="portal-header course-header">
            <a href="{{ route('home') }}" class="portal-brand">
                <strong>DENNIS BESSELER</strong>
                <span>Kursportal</span>
            </a>
            <nav>
                <a href="{{ route('home') }}">Alle Kurse</a>
                <a href="{{ route('login') }}">Kundenlogin</a>
                <a href="{{ route('copy-protection') }}">Kopierschutz</a>
                <a href="{{ route('payment') }}">Zahlung</a>
                <a href="#anmelden">Anmelden</a>
            </nav>
        </header>

        <section class="course-hero">
            <div class="course-hero-copy">
                <p class="eyebrow">Prävention &amp; Stressbewältigung</p>
                <h1>Stress und Ressourcen</h1>
                <p class="course-lead">Widerstandskraft stärken und Stress nachhaltig abbauen. Wissenschaftlich fundierte Strategien zur Aktivierung Ihrer persönlichen mentalen Ressourcen.</p>
                <div class="course-price"><strong>199 €</strong><span>einmalig · kein Abo</span></div>
                <div class="access-badge">
                    <b>Persönlicher Kurszugang</b>
                    <span>Drei Monate ab Freischaltung</span>
                    <small>Kein Abonnement · keine automatische Verlängerung</small>
                </div>
                <a class="order-cta" href="{{ route('course.show', 'stress-und-ressourcen') }}">Kurs im Mitgliederbereich öffnen <span>→</span></a>
            </div>

            <aside class="course-login" id="anmelden">
                <p class="login-label">Bereits freigeschaltet?</p>
                <h2>Persönlichen Kurs öffnen</h2>

                <form method="POST" action="{{ route('login.store') }}" autocomplete="off">
                    @csrf
                    <label>
                        <span>Benutzername oder E-Mail</span>
                        <input type="text" name="login" required autocomplete="username" placeholder="z. B. testkunde"/>
                    </label>
                    <label>
                        <span>Passwort</span>
                        <input type="password" name="password" required autocomplete="current-password" placeholder="Ihr Passwort"/>
                    </label>

                    <input type="hidden" name="device_id" class="course_device_id">
                    <input type="hidden" name="device_name" class="course_device_name">

                    <button type="submit">Anmelden und Kurs öffnen <span>→</span></button>
                </form>

                <a href="{{ route('forgot-password') }}" class="password-forgotten-link">Benutzername oder Passwort vergessen?</a>
                <p class="login-help">Sicherheitshinweis: Der persönliche Zugang wird beim ersten Login einem Gerät zugeordnet.</p>
                <div class="course-preview-links">
                    <a href="{{ route('copy-protection') }}" class="course-preview-link">Aktuellen Kopierschutz ansehen</a>
                </div>
            </aside>
        </section>

        <section class="course-details">
            <div class="course-intro">
                <p class="eyebrow">Wissenschaftlich fundiert</p>
                <h2>Methoden zur nachhaltigen Stressregulation.</h2>
                <blockquote>Kompakte Lerneinheiten kombiniert mit alltagstauglichen Sofortinterventionen und Audio-Atemführung.</blockquote>
            </div>
            <dl class="facts-grid">
                <div>
                    <dt>Umfang</dt>
                    <dd>3 strukturierte Video- und Audiomodule</dd>
                </div>
                <div>
                    <dt>Arbeitsmaterial</dt>
                    <dd>Selbstanalyse-Bögen &amp; Übungspläne (PDF)</dd>
                </div>
                <div>
                    <dt>Audio-Einheiten</dt>
                    <dd>Geführte SOS-Atemübungen</dd>
                </div>
                <div>
                    <dt>Laufzeit</dt>
                    <dd>3 Monate voller Zugriff</dd>
                </div>
            </dl>
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
                <a href="{{ route('imprint') }}">Impressum</a>
                <a href="{{ route('privacy-policy') }}">Datenschutz</a>
            </nav>
        </footer>
    </main>

    <script>
        (() => {
            const deviceName = navigator.platform + " | " + navigator.userAgent;
            const raw = navigator.userAgent + navigator.platform + screen.width + screen.height + Intl.DateTimeFormat().resolvedOptions().timeZone;

            async function sha256(text) {
                const buffer = await crypto.subtle.digest("SHA-256", new TextEncoder().encode(text));
                return [...new Uint8Array(buffer)].map(b => b.toString(16).padStart(2, "0")).join("");
            }

            sha256(raw).then(hash => {
                document.querySelectorAll('.course_device_id').forEach(el => el.value = hash);
                document.querySelectorAll('.course_device_name').forEach(el => el.value = deviceName);
            });
        })();
    </script>
@endsection
