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
            <p class="eyebrow">Bedingungen für Kurszugänge</p>
            <h1>Zahlungs- und Teilnahmebedingungen</h1>
            <h2>1. Vertragspartner und Geltungsbereich</h2>
            <p>Vertragspartner für alle Kurszugänge ist Dennis Besseler, Aachenerstraße 1193, 50858 Köln. Diese Bedingungen gelten für die Bereitstellung digitaler Kursinhalte über dieses Kursportal.</p>
            <h2>2. Bereitstellung und Zahlungsabwicklung</h2>
            <p>Der Zugang zu den gebuchten Kursinhalten wird nach Eingang des vereinbarten Rechnungsbetrages und individueller Prüfung für die vereinbarte Laufzeit (in der Regel 90 Tage) freigeschaltet.</p>
            <h2>3. Einzelgeräte-Bindung und Urheberrecht</h2>
            <p>Jeder persönliche Kurszugang ist an ein einzelnes Endgerät gebunden. Die Vervielfältigung, öffentliche Vorführung oder Weitergabe der Zugangsdaten und Kursmaterialien ist untersagt.</p>
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
