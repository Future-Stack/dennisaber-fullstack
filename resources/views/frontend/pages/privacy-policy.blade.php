@extends('frontend.layouts.app')

@section('contents')
    <main class="legal-page">
        <div class="portal-notice">
            <strong>Technisches Kursportal</strong>
            <span>Keine Bestellung auf dieser Website. <a href="{{ route('home') }}">Kurse im Überblick ansehen →</a></span>
        </div>
        <header class="portal-header">
            <a href="{{ route('home') }}" class="portal-brand">
                <strong>DENNIS BESSELER</strong>
                <span>Kursportal</span>
            </a>
            <nav>
                <a href="{{ route('home') }}">Zurück zum Kursportal</a>
                <a href="{{ route('login') }}">Kundenlogin</a>
            </nav>
        </header>
        <article>
            <p class="eyebrow">Stand: August 2026</p>
            <h1>Datenschutzerklärung für das Kursportal</h1>
            <h2>1. Verantwortlicher und Datenschutzkontakt</h2>
            <p>Dennis Besseler, Aachenerstraße 1193, 50858 Köln, Deutschland. E-Mail: <a href="mailto:mail@besseler.de">mail@besseler.de</a></p>
            <h2>2. Grundsatz der Datenminimierung</h2>
            <p>Dieses Kursportal verarbeitet nur die Angaben, die für Freischaltung, sicheren Zugang, Kursbereitstellung und Support erforderlich sind. Die Verarbeitung erfolgt datensparsam und nach den Vorgaben der DSGVO.</p>
            <h2>3. Hosting und Server-Logfiles</h2>
            <p>Beim Aufruf verarbeitet der Server technisch notwendige Verbindungsdaten (IP-Adresse, Zeitpunkt, User-Agent) zur Sicherstellung des Betriebs und zur Abwehr von Angriffen gemäß Art. 6 Abs. 1 lit. f DSGVO.</p>
            <h2>4. Kundenkonto, Kursfreigabe und Einzelgeräte-Bindung</h2>
            <p>Für ein freigeschaltetes Kundenkonto werden Vorname, Benutzername, Rechnungsnummer sowie verschlüsselte Passwörter und Geräte-Prüfsummen verarbeitet. Dies verhindert den unberechtigten Missbrauch persönlicher Lizenzen.</p>
            <h2>5. Ihre Rechte</h2>
            <p>Sie haben das Recht auf Auskunft, Berichtigung oder Löschung Ihrer personenbezogenen Daten gemäß DSGVO.</p>
        </article>
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
