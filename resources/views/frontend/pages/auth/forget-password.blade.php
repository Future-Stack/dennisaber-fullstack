@extends('frontend.layouts.app')

@section('contents')
    <main class="customer-login-page cat-academy">
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
            </nav>
        </header>

        <section class="password-request-page">
            <div>
                <p class="eyebrow">Zugang wiederherstellen</p>
                <h1>Benutzername oder Passwort vergessen?</h1>
                <p>Die Rechnungsnummer und der richtige Kurs ordnen Ihre Anfrage dem bestehenden Kundenkonto zu. Aus Sicherheitsgründen wird hier weder ein Passwort angezeigt noch bestätigt, ob ein Konto existiert.</p>
                <a href="{{ route('login') }}" style="display:inline-block; margin-top:1rem; color:#38bdf8; text-decoration:none; font-weight:500;">← Zurück zum Kundenlogin</a>
            </div>

            <aside class="course-login">
                <p class="login-label">Zugangsdaten anfordern</p>
                <h2>Anfrage sicher zuordnen</h2>

                @if(session('request_submitted'))
                    <div style="background:#14532d; color:#86efac; padding:1rem; border-radius:6px; margin-bottom:1rem; font-size:0.9rem;">
                        ✓ {{ session('request_submitted') }}
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

                <form method="POST" action="{{ route('forgot-password.store') }}" class="password-request-form">
                    @csrf
                    <label>
                        <span>Benutzername oder Vorname</span>
                        <input type="text" name="username" required autocomplete="off" placeholder="Ihr Benutzername" value="{{ old('username') }}"/>
                    </label>

                    <label>
                        <span>Kunden-/Rechnungsnummer</span>
                        <input type="text" name="invoice_number" required autocomplete="off" placeholder="z. B. RE-2026-001" value="{{ old('invoice_number') }}"/>
                    </label>

                    <label>
                        <span>E-Mail-Adresse für Rückmeldung</span>
                        <input type="email" name="email" required placeholder="Ihre registrierte E-Mail-Adresse" value="{{ old('email') }}"/>
                    </label>

                    <label>
                        <span>Freigeschalteter Kurs</span>
                        <select name="course" required>
                            <option value="" disabled selected>Kurs auswählen</option>
                            <option value="5-Tage-Kompaktlehrgang">5-Tage-Kompaktlehrgang</option>
                            <option value="Vertiefungsausbildung">Vertiefungsausbildung</option>
                            <option value="Premium-Seminar">Premium-Seminar</option>
                            <option value="Stress und Ressourcen">Stress und Ressourcen</option>
                            <option value="Rauchfrei">Rauchfrei</option>
                            <option value="Ernährung">Ernährung</option>
                            <option value="Klar entscheiden">Klar entscheiden</option>
                            <option value="Erfolgreich gründen">Erfolgreich gründen</option>
                            <option value="Presse & Öffentlichkeit">Presse & Öffentlichkeit</option>
                            <option value="Rhetorik unter Druck">Rhetorik unter Druck</option>
                            <option value="Rio Negro 2002">Rio Negro 2002</option>
                        </select>
                    </label>

                    <button type="submit">Neue Zugangsdaten anfordern <span>→</span></button>
                </form>

                <p class="login-help">
                    Die neuen Zugangsdaten werden erst nach manuellem Abgleich mit der Buchhaltung übermittelt. Es wird keine zusätzliche E-Mail-Adresse dauerhaft im Kursportal gespeichert.
                </p>
            </aside>
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
