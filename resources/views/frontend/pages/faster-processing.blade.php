@extends('frontend.layouts.app')

@section('contents')
    <main class="rio-service-page">
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
                <a href="{{ route('home') }}">Alle Kurse</a>
                <a href="{{ route('rio-negro') }}">Rio Negro 2002</a>
                <a href="{{ route('login') }}">Kundenlogin</a>
            </nav>
        </header>

        <section class="rio-service-hero">
            <div>
                <p class="eyebrow">Rio Negro 2002 · freiwilliger Kundenservice</p>
                <p class="rio-service-kicker">Der nächste Schritt</p>
                <h1>Schnellere Bearbeitung</h1>
                <p>Sie haben bereits bestellt oder überwiesen? Hier können Sie freiwillig zusätzliche Angaben für eine schnellere Prüfung und Bearbeitung vorbereiten.</p>
                <strong>Diese Seite stellt keine Bestellung dar und löst keine Zahlungspflicht aus.</strong>
            </div>
            <div class="rio-service-compass" aria-hidden="true">
                <b>N</b>
                <span>RIO NEGRO</span>
            </div>
        </section>

        <form method="POST" action="{{ route('inquiry.mailto') }}" class="rio-service-form">
            @csrf
            <input type="hidden" name="course" value="Rio Negro 2002 - Schnellere Bearbeitung"/>
            
            <section class="rio-service-panel rio-service-left">
                <p class="eyebrow">Ihr bestehender Vorgang</p>
                <div class="rio-service-product">
                    <div>
                        <strong>Rio Negro 2002</strong>
                        <span>Digitales Audio-Abenteuer · 30 Tage Zugang</span>
                    </div>
                </div>
                <fieldset>
                    <legend>Zuordnung</legend>
                    <p>Bestellnummer und Vorname dienen ausschließlich der Zuordnung zu einem bereits bestehenden Vorgang.</p>
                    <div class="rio-service-fields">
                        <label>
                            <span>Bestellnummer *</span>
                            <input type="text" name="message" required placeholder="z. B. RN-2026-001" value="{{ old('message') }}"/>
                        </label>
                        <label>
                            <span>Vorname *</span>
                            <input type="text" name="first_name" required autocomplete="given-name" placeholder="Ihr Vorname" value="{{ old('first_name') }}"/>
                        </label>
                    </div>
                    <label style="margin-top: 0.75rem;">
                        <span>E-Mail-Adresse *</span>
                        <input type="email" name="email" required placeholder="Ihre registrierte E-Mail" value="{{ old('email') }}"/>
                    </label>
                </fieldset>
                <section class="rio-service-voucher">
                    <span class="rio-service-voucher-label">Optional</span>
                    <strong class="rio-service-voucher-title">Gutscheincode aus dem Buch</strong>
                    <p>Wenn Sie das Rio-Negro-Buch besitzen, können Sie den darin enthaltenen 10-€-Gutscheincode freiwillig übermitteln. Der Code wird manuell geprüft.</p>
                    <label>
                        <span>Gutscheincode</span>
                        <input type="text" name="voucher" placeholder="Code eingeben"/>
                    </label>
                </section>
            </section>

            <section class="rio-service-panel rio-service-right">
                <p class="eyebrow">Optional</p>
                <h2>Zahlungsbestätigung per E-Mail senden</h2>
                <p>Sie haben bereits überwiesen und möchten Ihren Vorgang möglichst schnell prüfen lassen? Wir bereiten Ihre Nachricht vollständig vor.</p>
                <div class="rio-service-attachment">
                    <span aria-hidden="true">PDF</span>
                    <strong>Zahlungsbeleg anschließend anhängen</strong>
                    <small>PDF, JPG oder PNG im geöffneten E-Mail-Programm auswählen</small>
                </div>
                <label class="rio-service-check">
                    <input type="checkbox" name="attach_receipt" value="1"/>
                    <span>Ich möchte eine Zahlungsbestätigung manuell an die vorbereitete E-Mail anhängen.</span>
                </label>
                <p class="rio-service-privacy">Nicht benötigte Kontodaten und andere Kontobewegungen können Sie vorher schwärzen. Die Zahlungsbestätigung ersetzt nicht den tatsächlichen Zahlungseingang.</p>
                <button class="rio-service-submit" type="submit">E-Mail vorbereiten</button>
                <p class="rio-service-small">Die Seite speichert selbst keine Daten. Erst wenn Sie die vorbereitete E-Mail in Ihrem E-Mail-Programm absenden, werden Ihre Angaben übermittelt.</p>
            </section>
        </form>

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
