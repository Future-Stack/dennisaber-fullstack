@extends('frontend.layouts.app')

@section('contents')
    <main class="customer-login-page cat-academy">
        <div class="portal-notice"><strong>Technisches Kursportal</strong><span>Keine Bestellung auf dieser Website. <a
                    href="../besseler-kursvorschau.dennis-bes.chatgpt.site/angebote/index.html">Kurse im Verkaufsportal ansehen →</a></span>
        </div>
        <header class="portal-header course-header"><a href="index.html" class="portal-brand"><strong>DENNIS
                    BESSELER</strong><span>Kursportal</span></a>
            <nav><a href="index.html">Alle Kurse</a><a href="login.html" aria-current="page">Kundenlogin</a><a
                    href="kopierschutz.html">Kopierschutz</a><a href="zahlung.html">Zahlung</a></nav>
        </header>
        <section class="customer-login-hero">
            <div><p class="eyebrow">Aktuelles Kursportal</p>
                <h1>Direkt zum persönlichen Kurs.</h1>
                <p>Wählen Sie Ihren freigeschalteten Kurs und melden Sie sich mit den zugesandten Zugangsdaten an. Sie
                    bleiben dabei vollständig in diesem aktuellen Kursportal.</p>
                <div class="login-route-note"><strong>Der richtige Kundenlogin</strong><span>besseler-kursportal.dennis-bes.chatgpt.site/login</span>
                </div>
            </div>
            <aside class="course-login" id="anmelden"><p class="login-label">Bereits freigeschaltet?</p>
                <h2>Persönlichen Kurs öffnen</h2>
                <form><label>Kurs<select name="slug" required="">
                            <option value="" disabled="" selected="">Kurs auswählen</option>
                            <option value="dnl-kompakt">5-Tage-Kompaktlehrgang</option>
                            <option value="dnl-vertiefung">Vertiefungsausbildung</option>
                            <option value="dnl-premium">Premium-Seminar</option>
                            <option value="stress-und-ressourcen">Stress und Ressourcen</option>
                            <option value="rauchfrei">Rauchfrei</option>
                            <option value="ernaehrung">Ernährung</option>
                            <option value="klar-entscheiden">Klar entscheiden</option>
                            <option value="erfolgreich-gruenden">Erfolgreich gründen</option>
                            <option value="presse-oeffentlichkeit">Presse &amp; Öffentlichkeit</option>
                            <option value="rhetorik-unter-druck">Rhetorik unter Druck</option>
                            <option value="rio-negro-2002">Rio Negro 2002</option>
                        </select></label><label>Benutzername<input autoComplete="username" required=""
                                                                   name="username"/></label><label>Passwort<input type="password"
                                                                                                                  autoComplete="current-password"
                                                                                                                  required=""
                                                                                                                  name="password"/></label>
                    <button type="submit">Anmelden und Kurs öffnen<!-- --> <span>→</span></button>
                </form>
                <a href="passwort-vergessen.html" class="password-forgotten-link">Benutzername oder Passwort vergessen?</a>
                <p class="login-help">Sicherheitshinweis: Der persönliche Zugang wird beim ersten erfolgreichen Login einem
                    Gerät zugeordnet. Bei einem Gerätewechsel wenden Sie sich bitte an den persönlichen Support.</p>
                <div class="course-preview-links"><a href="kopierschutz.html" class="course-preview-link">Aktuellen
                        Kopierschutz ansehen</a></div>
            </aside>
        </section>
        <section class="customer-login-support">
            <div><p class="eyebrow">Zugang funktioniert nicht?</p>
                <h2>Keine Zugangsdaten mehrfach ausprobieren.</h2></div>
            <p>Bei einem neuen Gerät oder einem gesperrten Zugang wenden Sie sich bitte an den persönlichen Support.
                Passwörter und Zahlungsdaten gehören nicht in eine Supportnachricht.</p></section>
        <footer class="site-footer">
            <div><strong>DENNIS BESSELER</strong>
                <p>Persönliche Kurszugänge · einmalige Zahlung · kein Abonnement</p></div>
            <nav aria-label="Rechtliche Hinweise"><a href="login.html">Kundenlogin</a><a href="kopierschutz.html">Kopierschutz</a><a
                    href="zahlung.html">Zahlung</a><a href="service/rio-negro.html">Schnellere Bearbeitung</a><a
                    href="impressum.html">Impressum</a><a href="datenschutz.html">Datenschutz</a><a
                    href="zahlungsbedingungen.html">Zahlungsbedingungen</a></nav>
        </footer>
    </main>
@endsection
