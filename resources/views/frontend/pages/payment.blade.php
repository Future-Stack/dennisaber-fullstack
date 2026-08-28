@extends('frontend.layouts.app')

@section('contents')
    <main class="payment-info-page">
        <div class="portal-notice"><strong>Technisches Kursportal</strong><span>Keine Bestellung auf dieser Website. <a
                    href="../besseler-kursvorschau.dennis-bes.chatgpt.site/angebote/index.html">Kurse im Verkaufsportal ansehen →</a></span>
        </div>
       @include('frontend.components.header')
        <section class="payment-info-hero"><p class="eyebrow">Information · keine Bestellmöglichkeit</p>
            <h1>Zahlung und Freischaltung.</h1>
            <p>Hier sehen Sie, wie die spätere Zahlung per Überweisung abläuft. Eine Bestellung oder Zahlung kann auf dieser
                Website nicht ausgelöst werden. Für eine bestehende Rechnung steht eine lokale GiroCode-Hilfe bereit.</p><a
                href="../besseler-kursvorschau.dennis-bes.chatgpt.site/angebote/index.html">Kurse im Verkaufsportal ansehen
                <span>→</span></a></section>
        <section class="payment-process" id="bezahlung">
            <header><p class="eyebrow">Klare Trennung</p>
                <h2>Information und Buchung auf besseler.de. Kursnutzung hier.</h2>
                <p>Diese Website ist ausschließlich die technische Kursplattform für bereits freigeschaltete Kunden. Sie
                    dient weder der Werbung noch der Beratung oder Bestellung.</p></header>
            <div class="payment-steps">
                <article><span>01</span>
                    <h3>Auf besseler.de informieren</h3>
                    <p>Alle Informationen, Beratung und die verbindliche Buchung finden ausschließlich auf besseler.de
                        statt.</p></article>
                <article><span>02</span>
                    <h3>Persönlichen Zugang erhalten</h3>
                    <p>Nach der Buchung und dem eindeutig zugeordneten Zahlungseingang wird das Kundenkonto
                        freigeschaltet.</p></article>
                <article><span>03</span>
                    <h3>Überweisung ausführen</h3>
                    <p>Rechnung, GiroCode, Bankdaten und eindeutigen Verwendungszweck verwenden.</p></article>
                <article><span>04</span>
                    <h3>Kurs hier nutzen</h3>
                    <p>Bereits freigeschaltete Kunden melden sich an und bearbeiten ihre gebuchten Kursinhalte.</p>
                </article>
            </div>
            <div class="payment-note"><p><strong>Dieses Portal verkauft nichts:</strong> Es stellt ausschließlich die von
                    uns erbrachte technische Kursleistung für bereits freigeschaltete Kunden bereit.</p>
                <div class="payment-note-links"><a
                        href="../besseler-kursvorschau.dennis-bes.chatgpt.site/angebote/index.html">Zum Verkaufsportal →</a><a
                        href="zahlung.html">Hinweise für bestehende Rechnungen →</a></div>
            </div>
        </section>
        <section class="payment-helper" id="banking-qr" aria-labelledby="payment-helper-title">
            <header><p class="eyebrow">Hilfe für bestehende Rechnungen</p>
                <h2 id="payment-helper-title">GiroCode aus der Rechnung erstellen.</h2>
                <p>Falls Ihre Rechnung keinen lesbaren GiroCode enthält, können Sie die dort genannten Zahlungsdaten hier
                    lokal in einen neuen Banking-QR-Code umwandeln. Es werden keine Bankdaten vorbelegt.</p></header>
            <div class="payment-helper-layout">
                <form><label>Kontoinhaber laut Rechnung<input maxLength="70" autoComplete="off" required=""
                                                              value=""/></label><label>IBAN laut Rechnung<input
                            inputMode="text" maxLength="42" autoComplete="off" spellCheck="false" required=""
                            value=""/></label><label>BIC laut Rechnung (falls angegeben)<input maxLength="11"
                                                                                               autoComplete="off"
                                                                                               spellCheck="false" value=""/></label><label>Rechnungsbetrag
                        in Euro<input inputMode="decimal" placeholder="z. B. 99,00" maxLength="13" autoComplete="off"
                                      required="" value=""/></label><label>Verwendungszweck laut Rechnung<input
                            maxLength="140" autoComplete="off" required="" value=""/></label>
                    <button class="generate-giro" type="submit">GiroCode lokal erstellen <span>→</span></button>
                    <button class="copy-payment" type="button">Eingaben löschen</button>
                    <p class="payment-safety">Die Verarbeitung erfolgt ausschließlich in diesem Browser. Die Angaben werden
                        nicht versendet oder gespeichert.</p></form>
                <div class="giro-output" aria-live="polite">
                    <div class="giro-empty"><span>GIROCODE</span>
                        <p>Der QR-Code erscheint erst nach einer formalen Prüfung der eingegebenen Rechnungsdaten.</p></div>
                </div>
            </div>
            <div class="payment-helper-warning"><strong>Kein Zahlungsauftrag</strong><span>Der QR-Code bereitet nur Zahlungsdaten für Ihre Banking-App vor. Er löst keine Überweisung aus, bestätigt keinen Zahlungseingang und führt nicht automatisch zur Freischaltung.</span>
            </div>
        </section>
        <section class="payment-service-link" aria-labelledby="payment-service-title">
            <div><p class="eyebrow">Bereits bestellt oder überwiesen?</p>
                <h2 id="payment-service-title">Schnellere Bearbeitung.</h2>
                <p>Für einen bereits bestehenden Rio-Negro-Vorgang können Sie freiwillig Ihren Gutscheincode aus dem Buch
                    übermitteln oder eine Zahlungsbestätigung für Ihre E-Mail vorbereiten.</p><small>Dadurch entstehen keine
                    Bestellung, keine Zahlungspflicht und keine automatische Freischaltung. Die Angaben werden manuell
                    geprüft.</small></div>
            <a href="service/rio-negro.html">Angaben zur schnelleren Bearbeitung öffnen <span>→</span></a></section>
        <section class="transfer-preview">
            <div><p class="eyebrow">Vorbereiteter Überweisungsablauf</p>
                <h2>Rechnung, Bankdaten und Verwendungszweck.</h2>
                <p>Nach der Bestellung auf besseler.de erhält der Kunde seine persönlichen Zahlungsunterlagen. Die
                    vollständigen Bankdaten werden nicht öffentlich auf diesem Portal angezeigt. Die Überweisung wird anhand
                    der Rechnung geprüft und vom Kunden selbst mit TAN bestätigt.</p>
                <div class="no-payment-box"><strong>Keine Zahlung auf dieser Seite</strong><span>Die optionale GiroCode-Hilfe verarbeitet übertragene Rechnungsangaben nur lokal im Browser. Sie versendet nichts und löst keine Überweisung aus.</span>
                </div>
            </div>
            <div class="transfer-preview-card"><span>1</span>
                <p>Rechnung mit eindeutiger Bestell- oder Rechnungsnummer</p><span>2</span>
                <p>GiroCode oder Bankdaten ausschließlich aus der persönlichen Rechnung verwenden</p><span>3</span>
                <p>Verwendungszweck unverändert übernehmen</p><span>4</span>
                <p>Zahlungsprüfung täglich zwischen 13 und 16 Uhr</p><span>5</span>
                <p>Persönliche Freischaltung per E-Mail</p></div>
        </section>
       @include('frontend.components.footer')
    </main>
@endsection
