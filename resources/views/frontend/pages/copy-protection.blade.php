@extends('frontend.layouts.app')

@section('contents')
    <main class="copy-protection-page cat-academy">
        <div class="portal-notice">
            <strong>Technisches Kursportal</strong>
            <span>Ausschließlich für bereits freigeschaltete Kunden.</span>
            <a href="https://besseler.de/">Noch keinen Zugang? Kurse und Preise ansehen →</a>
        </div>

        <header class="portal-header course-header">
            <a href="{{ route('home') }}" class="portal-brand">
                <strong>DENNIS BESSELER</strong>
                <span>Kursportal</span>
            </a>
            <nav style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                <a href="{{ route('login') }}">Kundenlogin</a>
                <a href="{{ route('forgot-password') }}">Passwort vergessen</a>
                <a href="{{ route('copy-protection') }}" aria-current="page">Kopierschutz</a>
            </nav>
        </header>

        <section class="copy-protection-hero">
            <div>
                <p class="eyebrow">Transparente Vorschau</p>
                <h1>So sieht dein persönlicher Kopierschutz aus.</h1>
            </div>
            <div>
                <p>Im freigeschalteten Kurs werden deine Inhalte mit Vorname und Kunden- beziehungsweise Rechnungsnummer als persönliche Privatlizenz gekennzeichnet. Dafür verläuft ein einzelner schmaler Wasserzeichenstreifen von links unten nach rechts oben. Diese Seite verwendet dieselbe Darstellung wie der echte Kursbereich.</p>
                <p class="copy-protection-live-note">Ändert sich der Kopierschutz im Portal, ändert sich diese Vorschau automatisch mit.</p>
            </div>
        </section>

        <section class="copy-protection-explainer">
            <article>
                <span>01</span>
                <h2>Persönliche Kennzeichnung</h2>
                <p>Vorname und Kunden- beziehungsweise Rechnungsnummer kennzeichnen die persönliche Privatlizenz. Anschrift, E-Mail-Adresse und Zahlungsdaten werden nicht angezeigt.</p>
            </article>
            <article>
                <span>02</span>
                <h2>Auch auf Dokumenten</h2>
                <p>Geschützte Arbeitsbuchseiten erhalten einen einzelnen schmalen diagonalen Streifen – sichtbar, aber nicht dominant.</p>
            </article>
            <article>
                <span>03</span>
                <h2>Gerätebindung</h2>
                <p>Der erste erfolgreiche Login verbindet den persönlichen Zugang mit einem Browserprofil.</p>
            </article>
        </section>

        <section class="copy-protection-demo-section">
            <header>
                <p class="eyebrow">Aktueller Stand im Portal</p>
                <h2>Live-Darstellung mit Testdaten</h2>
            </header>
            <div class="copy-protection-demo" aria-label="Vorschau des aktuellen Kopierschutzes">
                <aside>
                    <p class="eyebrow">Persönlicher Kursbereich</p>
                    <h3>Klar entscheiden</h3>
                </aside>
                <article style="position: relative; overflow: hidden; min-height: 240px;">
                    <div class="course-customer-watermark" aria-hidden="true" style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; pointer-events: none; z-index: 5; color: rgba(30, 41, 59, 0.40); text-shadow: 0 1px #ffffffbf; overflow: hidden;">
                        <span style="transform: rotate(-25deg); font-weight: 750; font-size: 0.85rem; letter-spacing: 0.08em; white-space: nowrap; width: 140%; text-align: center;">
                            Rech-Nr.: RN-7X4K-2026 &nbsp;&bull;&nbsp; Rech-Nr.: RN-7X4K-2026 &nbsp;&bull;&nbsp; Rech-Nr.: RN-7X4K-2026 &nbsp;&bull;&nbsp; Rech-Nr.: RN-7X4K-2026 &nbsp;&bull;&nbsp; Rech-Nr.: RN-7X4K-2026 &nbsp;&bull;&nbsp; Rech-Nr.: RN-7X4K-2026 &nbsp;&bull;&nbsp; Rech-Nr.: RN-7X4K-2026 &nbsp;&bull;&nbsp; Rech-Nr.: RN-7X4K-2026
                        </span>
                    </div>
                    <div class="copy-protection-demo-topline">
                        <span>Aktuelle Kurseinheit</span>
                        <strong>Gerät 1 von 1 registriert</strong>
                    </div>
                    <p class="eyebrow">Beispielinhalt</p>
                    <h3>Wahrnehmen, bevor du einordnest.</h3>
                    <p>Der Inhalt bleibt gut lesbar. Die persönliche Kennzeichnung läuft nur einmal diagonal durch die Darstellung und überlagert den Kurs nicht unnötig.</p>
                </article>
            </div>
        </section>

        <section class="copy-protection-next">
            <div>
                <p class="eyebrow">Bereits freigeschaltet?</p>
                <h2>Deinen persönlichen Kurs öffnen.</h2>
            </div>
            <a href="{{ route('login') }}">Zum aktuellen Kundenlogin →</a>
        </section>

        <footer class="site-footer">
            <div>
                <strong>DENNIS BESSELER</strong>
                <p>Persönliche Kurszugänge · einmalige Zahlung · kein Abonnement</p>
                <a href="{{ route('verwaltung.login') }}" class="quiet-admin-login">Admin</a>
            </div>
            <nav aria-label="Rechtliche Hinweise">
                <a href="https://besseler-kursvorschau.dennis-bes.chatgpt.site/">Kurse auf besseler.de</a>
                <a href="{{ route('login') }}">Kundenlogin</a>
                <a href="{{ route('forgot-password') }}">Passwort vergessen</a>
                <a href="{{ route('copy-protection') }}">Kopierschutz</a>
                <a href="{{ route('imprint') }}">Impressum</a>
                <a href="{{ route('privacy-policy') }}">Datenschutz</a>
            </nav>
        </footer>
    </main>
@endsection
