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
            <p class="eyebrow">Rechtliche Angaben</p>
            <h1>Impressum</h1>
            <h2>Angaben gemäß § 5 DDG</h2>
            <p>Dennis Besseler<br/>Aachenerstraße 1193<br/>50858 Köln<br/>Deutschland</p>
            <h2>Kontakt</h2>
            <p>Telefon: <a href="tel:+4922349397768">+49 2234 9397768</a><br/>E-Mail: <a href="mailto:mail@besseler.de">mail@besseler.de</a></p>
            <h2>Umsatzsteuer</h2>
            <p>Umsatzsteuer-Identifikationsnummer gemäß § 27a UStG: DE207153592</p>
            <h2>Verantwortlich für den Inhalt</h2>
            <p>Verantwortlich nach § 18 Abs. 2 MStV: Dennis Besseler, Anschrift wie oben.</p>
            <h2>Streitbeilegung</h2>
            <p>Ich bin nicht verpflichtet und nicht bereit, an einem Streitbeilegungsverfahren vor einer Verbraucherschlichtungsstelle teilzunehmen.</p>
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
