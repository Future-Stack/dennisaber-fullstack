@extends('frontend.layouts.app')

@section('contents')
    <main class="copy-protection-page">
        <div class="portal-notice">
            <strong>Technisches Kursportal</strong>
            <span>Informationen zum Kopierschutz und zur technischen Datensicherheit.</span>
        </div>
        <header class="portal-header">
            <a href="{{ route('home') }}" class="portal-brand">
                <strong>DENNIS BESSELER</strong>
                <span>Kursportal</span>
            </a>
            <nav>
                <a href="{{ route('home') }}">Alle Kurse</a>
                <a href="{{ route('login') }}">Kundenlogin</a>
                <a href="{{ route('copy-protection') }}" aria-current="page">Kopierschutz</a>
                <a href="{{ route('payment') }}">Zahlung</a>
            </nav>
        </header>

        <section class="copy-protection-hero" style="max-width: 1000px; margin: 3rem auto; padding: 0 1.5rem;">
            <p class="eyebrow">Schutz persönlicher Inhalte</p>
            <h1 style="font-size: 2.2rem; color: #f8fafc; margin-bottom: 1rem;">Technischer Kopierschutz &amp; Einzelgeräte-Bindung</h1>
            <p style="color: #94a3b8; font-size: 1.1rem; line-height: 1.6; margin-bottom: 2rem;">
                Die Inhalte unserer Kurse, Video-Lektionen, Audio-Einheiten und PDF-Arbeitsunterlagen sind durch ein mehrstufiges technisches Schutzkonzept gegen unbefugte Weitergabe und öffentliche Vervielfältigung gesichert.
            </p>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
                <div style="background: #1e293b; padding: 1.75rem; border-radius: 8px; border: 1px solid #334155;">
                    <span style="font-size: 1.75rem; display: block; margin-bottom: 0.75rem;">🔒</span>
                    <h2 style="color: #f8fafc; font-size: 1.2rem; margin-bottom: 0.5rem;">Dynamische Einzelgeräte-Bindung</h2>
                    <p style="color: #cbd5e1; font-size: 0.95rem; line-height: 1.6;">
                        Beim ersten erfolgreichen Login wird das Kundenkonto kryptografisch an den verwendeten Webbrowser gebunden. Parallele Logins von anderen Geräten werden blockiert.
                    </p>
                </div>

                <div style="background: #1e293b; padding: 1.75rem; border-radius: 8px; border: 1px solid #334155;">
                    <span style="font-size: 1.75rem; display: block; margin-bottom: 0.75rem;">🛡</span>
                    <h2 style="color: #f8fafc; font-size: 1.2rem; margin-bottom: 0.5rem;">Geschützte Medienauslieferung</h2>
                    <p style="color: #cbd5e1; font-size: 0.95rem; line-height: 1.6;">
                        Videos und PDFs liegen in geschützten Serververzeichnissen ohne öffentliche URL. Der Zugriff erfolgt ausschließlich über autorisierte Sessions freigeschalteter Teilnehmer.
                    </p>
                </div>

                <div style="background: #1e293b; padding: 1.75rem; border-radius: 8px; border: 1px solid #334155;">
                    <span style="font-size: 1.75rem; display: block; margin-bottom: 0.75rem;">⚖</span>
                    <h2 style="color: #f8fafc; font-size: 1.2rem; margin-bottom: 0.5rem;">Personalisierte Arbeitsblätter</h2>
                    <p style="color: #cbd5e1; font-size: 0.95rem; line-height: 1.6;">
                        Begleitende PDF-Leitfäden werden beim Download dynamisch mit den Rechnungsdaten des autorisierten Kunden gekennzeichnet, um Missbrauch nachverfolgbar zu machen.
                    </p>
                </div>
            </div>

            <div style="background: #0f172a; padding: 2rem; border-radius: 8px; border-left: 4px solid #38bdf8;">
                <h3 style="color: #f8fafc; margin-top: 0;">Was tun bei einem Gerätewechsel?</h3>
                <p style="color: #cbd5e1; line-height: 1.6;">
                    Falls Sie ein neues Tablet, Smartphone oder einen neuen Computer verwenden, kann die Gerätebindung über den Administrator im Support-Abgleich sicher zurückgesetzt werden. Wenden Sie sich hierzu an <a href="mailto:mail@besseler.de" style="color: #38bdf8;">mail@besseler.de</a> unter Angabe Ihrer Rechnungsnummer.
                </p>
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
