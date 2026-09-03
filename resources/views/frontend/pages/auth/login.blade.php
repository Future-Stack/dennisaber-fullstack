@extends('frontend.layouts.app')

@section('contents')
    <main class="customer-login-page cat-academy">
        <div class="portal-notice">
            <strong>Technisches Kursportal</strong>
            <span>Keine Bestellung auf dieser Website. <a href="https://www.besseler.de">Kurse im Verkaufsportal ansehen →</a></span>
        </div>
        <header class="portal-header course-header">
            <a href="{{ route('home') }}" class="portal-brand">
                <strong>DENNIS BESSELER</strong>
                <span>Kursportal</span>
            </a>
            <nav>
                <a href="{{ route('home') }}">Alle Kurse</a>
                <a href="{{ route('login') }}" aria-current="page">Kundenlogin</a>
                <a href="{{ route('copy-protection') }}">Kopierschutz</a>
                <a href="{{ route('payment') }}">Zahlung</a>
            </nav>
        </header>

        <section class="customer-login-hero">
            <div>
                <p class="eyebrow">Aktuelles Kursportal</p>
                <h1>Direkt zum persönlichen Kurs.</h1>
                <p>Melden Sie sich mit Ihren zugesandten Zugangsdaten an. Sie gelangen direkt in Ihren freigeschalteten Kursbereich.</p>
                <div class="login-route-note">
                    <strong>Der richtige Kundenlogin</strong>
                    <span>{{ url('/login') }}</span>
                </div>
            </div>

            <aside class="course-login" id="anmelden">
                <p class="login-label">Bereits freigeschaltet?</p>
                <h2>Persönlichen Kurs öffnen</h2>

                @if(session('success'))
                    <div style="background:#14532d; color:#86efac; padding:0.75rem; border-radius:6px; margin-bottom:1rem; font-size:0.9rem;">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div style="background:#7f1d1d; color:#fca5a5; padding:0.75rem; border-radius:6px; margin-bottom:1rem; font-size:0.9rem;">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div style="background:#7f1d1d; color:#fca5a5; padding:0.75rem; border-radius:6px; margin-bottom:1rem; font-size:0.9rem;">
                        <ul style="margin:0; padding-left:1.2rem;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store') }}" autocomplete="off">
                    @csrf
                    <label>
                        <span>Benutzername</span>
                        <input type="text" name="login" required autocomplete="username" value="{{ old('login') }}" placeholder="z. B. testkunde"/>
                    </label>

                    <label>
                        <span>Passwort</span>
                        <input type="password" name="password" required autocomplete="current-password" placeholder="Ihr persönliches Passwort"/>
                    </label>

                    {{-- Hidden device binding tokens --}}
                    <input type="hidden" name="device_id" id="customer_device_id">
                    <input type="hidden" name="device_name" id="customer_device_name">

                    <button type="submit">Anmelden und Kurs öffnen <span>→</span></button>
                </form>

                <a href="{{ route('forgot-password') }}" class="password-forgotten-link">Benutzername oder Passwort vergessen?</a>
                
                <p class="login-help">
                    <strong>Sicherheitshinweis:</strong> Der persönliche Zugang wird beim ersten erfolgreichen Login dynamisch Ihrem Gerät zugeordnet. Bei einem Gerätewechsel wenden Sie sich bitte an den Support.
                </p>

                <div class="course-preview-links">
                    <a href="{{ route('copy-protection') }}" class="course-preview-link">Aktuellen Kopierschutz ansehen</a>
                </div>
            </aside>
        </section>

        <section class="customer-login-support">
            <div>
                <p class="eyebrow">Zugang funktioniert nicht?</p>
                <h2>Keine Zugangsdaten mehrfach ausprobieren.</h2>
            </div>
            <p>Bei einem neuen Gerät oder einem gesperrten Zugang wenden Sie sich bitte an den persönlichen Support. Passwörter und Zahlungsdaten gehören nicht in eine Supportnachricht.</p>
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

    <script>
        (() => {
            const deviceName = navigator.platform + " | " + navigator.userAgent;
            const raw = navigator.userAgent + navigator.platform + screen.width + screen.height + Intl.DateTimeFormat().resolvedOptions().timeZone;

            async function sha256(text) {
                const buffer = await crypto.subtle.digest("SHA-256", new TextEncoder().encode(text));
                return [...new Uint8Array(buffer)].map(b => b.toString(16).padStart(2, "0")).join("");
            }

            sha256(raw).then(hash => {
                const idEl = document.getElementById('customer_device_id');
                const nameEl = document.getElementById('customer_device_name');
                if (idEl) idEl.value = hash;
                if (nameEl) nameEl.value = deviceName;
            });
        })();
    </script>
@endsection
