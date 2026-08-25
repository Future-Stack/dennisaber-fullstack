@extends('admin.layouts.app2')

@section('contents')
    <main class="admin-workspace" id="admin-page-top">
        <header class="admin-topbar">
            <div><span class="account-role-badge is-admin">ADMIN-KONTO</span><strong>DENNIS BESSELER ·
                    KUNDENZUGÄNGE</strong></div>
            <nav>
                <a href="{{ route('home') }}">Kursportal öffnen</a>
                <form method="post" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="admin-logout-button" type="submit">Abmelden</button>
                </form>
            </nav>
        </header>
        <nav class="admin-index" id="admin-navigation" aria-label="Inhaltsverzeichnis">
            <div class="admin-index-links"><a href="#arbeitsmittel"><span>00</span>Bank &amp; Cloud</a><a
                    href="#mitarbeiter"><span>MA</span>Mitarbeiter</a><a href="#hauptadmin-sicherheit"><span>SI</span>Admin-Sicherheit</a><a
                    href="#datenaustausch"><span>DT</span>Datentausch</a>
                <a
                    href="#zugangsanfragen"><span>02</span>Anfragen</a><a href="#kunden"><span>03</span>Kunden</a><a
                    href="#anlegen"><span>04</span>Anlegen</a><a href="#auslieferung"><span>05</span>Auslieferung</a><a
                    href="#sicherheit"><span>06</span>Ablauf</a><a href="#naechste-version"><span>NV</span>Nächste
                    Version</a>
                <a
                    href="#pinnwand"><span>01</span>Notizen</a><a
                    href="https://dennisbesseler.papierkram.de/login?email=mail%40besseler.de" target="_blank"
                    rel="noreferrer"><span>RE</span>Rechnungen</a></div>
            <div class="work-timer is-compact">
                <button class="work-timer-toggle" type="button" aria-expanded="false"><span>Timer</span><b>00:00:00</b>
                </button>
            </div>
            <a class="portal-jump-arrow portal-jump-down" href="#admin-page-end"
               aria-label="Zum unteren Ende des Verwaltungsbereichs"><span aria-hidden="true">↓</span></a></nav>
        <section
            class="admin-bank-card" id="arbeitsmittel" aria-labelledby="business-account-title">
            <div>
                <p class="eyebrow">Interne Zahlungsdaten</p>
                <h2 id="business-account-title">Geschäftskonto</h2>
                <p>Für Rechnung, Zahlungsabgleich und Kundenservice. Nicht öffentlich im Kundenportal anzeigen.</p>
            </div>
            <div class="admin-bank-value"><span>IBAN</span><strong>DE25 2022 0800 0043 2794 71</strong></div>
            <button type="button">IBAN kopieren</button>
        </section>
        <section class="admin-cloud-card" aria-labelledby="admin-cloud-title">
            <div>
                <p class="eyebrow">Gemeinsamer Arbeitsordner</p>
                <h2 id="admin-cloud-title">Drive-Cloud</h2><code>https://drive.google.com/drive/folders/1KSr6zNf4IT3-Rq58Hj2mfr52ugJBq8Xk?usp=drive_link</code>
                <p>Für nicht sicherheitskritische Arbeitsdateien bis insgesamt 500 MB. Der Ordner bleibt privat;
                    Mitarbeitende fordern über den Link Zugriff an und werden von Dennis freigegeben.</p><small>Keine
                    Passwörter, Zugangsdaten, vollständigen Bankdaten oder besonders sensiblen personenbezogenen Daten
                    hochladen.</small></div>
            <div><a href="https://drive.google.com/drive/folders/1KSr6zNf4IT3-Rq58Hj2mfr52ugJBq8Xk?usp=drive_link"
                    target="_blank" rel="noreferrer">Drive-Ordner öffnen</a>
                <button type="button">Drive-Link kopieren</button>
            </div>
        </section>
        <section class="admin-staff-portal-link" aria-labelledby="staff-portal-link-title">
            <div>
                <p class="eyebrow">Direkter Mitarbeiterzugang</p>
                <h2 id="staff-portal-link-title">Mitarbeiter-Login</h2><code>/mitarbeiter-login</code>
                <p>Diesen Link an Mitarbeiter weitergeben oder selbst zur Kontrolle öffnen.</p>
            </div>
            <div><a href="/verwaltung/mitarbeiter-vorschau" target="_blank" rel="noreferrer">Arbeitsfläche prüfen</a><a
                    href="/mitarbeiter-login" target="_blank" rel="noreferrer">Mitarbeiter-Login öffnen</a>
                <button type="button">Link kopieren</button>
            </div>
        </section>
        <section class="admin-hero">
            <p class="eyebrow">Kundenverwaltung</p>
            <h1>Kunden anlegen.<br/>Kurse freigeben.<br/>Zugänge steuern.</h1>
            <p>Wartungsarme Kundenverwaltung mit bewusst minimalen personenbezogenen Daten.</p>
            <div class="admin-warning"><strong>Datensparsam aufgebaut</strong><span>Gespeichert werden nur Vorname, technischer Benutzername, Kunden-/Rechnungsnummer sowie Kurs-, Laufzeit- und Gerätedaten. Nach Ablauf der letzten Freigabe wird das Portalkonto automatisch gelöscht; die gesetzlich erforderliche Rechnung bleibt getrennt in der Buchhaltung.</span>
            </div>
        </section>
        <section class="admin-section admin-staff" id="mitarbeiter">
            <header>
                <div><span>MA</span>
                    <p class="eyebrow">Nur Administrator</p>
                </div>
                <h2>Mitarbeiter sicher einsetzen.</h2>
            </header>
            <div class="staff-security-note"><strong>Strikte Trennung</strong><span>Mitarbeiter erhalten einen eigenen zeitlich begrenzten Zugang. Sie sehen niemals Mitarbeiterkonten, Bankdaten oder kostenpflichtige Kursinhalte und können ihre Tätigkeit, Laufzeit oder Berechtigungen nicht selbst verändern.</span>
            </div>
            <form
                class="admin-form-preview staff-admin-form"><label><span>Name</span><input required=""
                                                                                           value=""/></label><label><span>Tätigkeit</span><input
                        required="" placeholder="z. B. Kundenservice oder Freelancer" value=""/></label><label><span>Benutzername</span><input
                        required="" value=""/></label><label><span>Passwort optional</span><input
                        autoComplete="new-password" maxLength="128" type="password"
                        placeholder="Leer lassen: sicher erzeugen" value=""/><small>10 bis 128 Zeichen, mindestens ein
                        Buchstabe und eine Zahl. Der Mitarbeiter muss das vorläufige Passwort beim ersten Login
                        ersetzen.</small></label><label><span>Zugang ab</span><input required="" type="date"
                                                                                     value="2026-08-25"/></label><label><span>Zugang bis einschließlich</span><input
                        required="" type="date" value="2026-09-24"/></label>
                <fieldset
                    class="staff-permissions">
                    <legend>Berechtigungen · nur hier durch den Administrator änderbar</legend>
                    <label><input type="checkbox" checked=""/><span>Kunden sehen und suchen</span></label><label><input
                            type="checkbox"
                            checked=""/><span>Kundenkonten anlegen · maximal 11 pro Tag</span></label><label><input
                            type="checkbox"
                            checked=""/><span>Kursfreigaben und Laufzeiten verwalten</span></label><label><input
                            type="checkbox" checked=""/><span>Kundenpasswörter neu erzeugen</span></label><label><input
                            type="checkbox" checked=""/><span>Kundenkonten aktivieren und sperren</span></label>
                </fieldset>
                <button
                    type="submit">Mitarbeiterkonto verbindlich anlegen
                </button>
            </form>
            <div class="admin-staff-list">
                <p>Noch keine Mitarbeiterkonten angelegt.</p>
            </div>
        </section>
        <section class="admin-section admin-version-pinboard" id="naechste-version"
                 aria-labelledby="version-pinboard-title">
            <header>
                <div><span>NV</span>
                    <p class="eyebrow">Nur Dennis · dauerhaft</p>
                </div>
                <h2 id="version-pinboard-title">Ideen für die nächste Portalversion</h2>
            </header>
            <p class="version-pinboard-intro">Dieser feste Planungsblock bleibt ausschließlich in Dennis’
                Administrationsbereich sichtbar. Seine Einträge werden nicht automatisch gelöscht. Ein Eintrag kann nur
                nach
                ausdrücklicher Löschbestätigung entfernt werden.</p>
            <form class="note-form version-note-form"
                  id="version-pinboard-form" noValidate=""><input maxLength="120"
                                                                  placeholder="Kurzer Titel der Änderung"
                                                                  aria-label="Titel für die nächste Portalversion"
                                                                  value=""/><textarea id="version-pinboard-body"
                                                                                      maxLength="3000" rows="5"
                                                                                      placeholder="Was soll bei der nächsten Portalversion geändert oder ergänzt werden?"
                                                                                      aria-label="Änderungsidee für die nächste Portalversion"></textarea>
                <button type="submit">Dauerhaft eintragen</button>
            </form>
            <div class="version-note-list">
                <p class="version-note-empty">Noch keine Änderung für die nächste Portalversion eingetragen.</p>
            </div>
        </section>
        <section class="admin-section admin-service admin-pinboard" id="pinnwand">
            <header>
                <div><span>01</span>
                    <p class="eyebrow">Persönliche Admin-Notizen</p>
                </div>
                <h2>Eigene Arbeitsnotizen festhalten.</h2>
            </header>
            <p class="pinboard-intro">Nur dein Administratorkonto sieht diese Notizen. Mitarbeiterkonten sehen sie
                nicht.
                Maximal fünf persönliche Notizen bleiben gespeichert; nach zehn Tagen werden sie automatisch
                gelöscht.</p>
            <form class="note-form" id="admin-pinboard-form"
                  noValidate=""><input maxLength="120" placeholder="Kurzer Titel"
                                       aria-label="Titel der persönlichen Admin-Notiz" value=""/><textarea
                    id="admin-pinboard-body" maxLength="2000" rows="4"
                    placeholder="Eigene Erinnerung, Aufgabe oder Arbeitsnotiz"
                    aria-label="Inhalt der persönlichen Admin-Notiz"></textarea>
                <button
                    type="button">Notiz speichern
                </button>
            </form>
            <div class="note-board"></div>
        </section>
        <section class="admin-section cloud-transfer" id="datenaustausch" aria-labelledby="admin-cloud-transfer-title">
            <header>
                <div><span>DT</span>
                    <p class="eyebrow">Gemeinsamer Arbeitsordner</p>
                </div>
                <h2 id="admin-cloud-transfer-title">Dateien einfach übergeben.</h2>
            </header>
            <div class="cloud-transfer-grid">
                <div class="cloud-transfer-main"><span>Externer Google-Drive-Ordner</span>
                    <h3>Nicht vertrauliche Arbeitsdateien austauschen</h3>
                    <p>Der Ordner öffnet sich außerhalb des Portals und bleibt bei Google auf „Eingeschränkt“.
                        Mitarbeiter
                        werden von Dennis einzeln mit ihrem Google-Konto freigegeben. Alle freigegebenen Bearbeiter
                        können
                        die dort abgelegten Dateien
                        grundsätzlich sehen, verändern und löschen.</p><a
                        href="https://drive.google.com/drive/folders/1KSr6zNf4IT3-Rq58Hj2mfr52ugJBq8Xk?usp=drive_link"
                        target="_blank" rel="noreferrer">Google-Drive-Ordner öffnen ↗</a></div>
                <div class="cloud-transfer-rules"><strong>Verbindliche Arbeitsregeln</strong>
                    <ul>
                        <li>Maximal 500 MB je Datenübergabe.</li>
                        <li>Keine Passwörter, Zugangsdaten oder Wiederherstellungscodes.</li>
                        <li>Keine Kunden-, Rechnungs-, Gesundheits- oder sonstigen personenbezogenen Daten.</li>
                        <li>Keine weiteren Personen selbst für den Ordner freigeben.</li>
                        <li>Dateien eindeutig benennen und nach Abschluss wieder entfernen.</li>
                    </ul>
                    <small>Die 500-MB-Grenze ist eine Arbeitsregel. Sie wird weder vom Portal noch vom öffentlichen
                        Drive-Link technisch erzwungen.</small></div>
            </div>
        </section>
        <section class="admin-section admin-service" id="zugangsanfragen">
            <header>
                <div><span>02</span>
                    <p class="eyebrow">Zugangsanfragen</p>
                </div>
                <h2>Vergessene Zugangsdaten bearbeiten.</h2>
            </header>
            <div class="admin-empty"><strong>Keine offenen Anfragen</strong>
                <p>Neue Anfragen aus dem Kundenlogin erscheinen automatisch an dieser Stelle.</p>
            </div>
        </section>
        <section class="admin-section" id="kunden">
            <header>
                <div><span>03</span>
                    <p class="eyebrow">Kundenkonten</p>
                </div>
                <h2>Alle Zugänge auf einen Blick.</h2>
            </header>
            <div class="admin-toolbar"><label><span>Kunden suchen</span><input type="search"
                                                                               placeholder="Vorname, Benutzername oder Rechnungsnummer"
                                                                               value=""/></label><a
                    class="admin-primary-link" href="#anlegen">Neuen Kundenzugang anlegen</a></div>
            <div class="admin-empty"><strong>Daten werden geladen …</strong></div>
        </section>
        <section class="admin-section admin-public" id="anlegen">
            <header>
                <div><span>04</span>
                    <p class="eyebrow">Zugang anlegen</p>
                </div>
                <h2>Nur das Nötigste speichern.</h2>
            </header>
            <form class="admin-form-preview" noValidate=""><label><span>Vorname</span><input required=""
                                                                                             placeholder="Nur Vorname"
                                                                                             value=""/></label><label><span>Technischer Benutzername</span><input
                        required="" placeholder="Eindeutiger Loginname" value=""/></label><label><span>Kunden-/Rechnungsnummer</span><input
                        required="" placeholder="Rückverfolgung nur über Buchhaltung" value=""/></label><label><span>Passwort (optional)</span><input
                        type="password" autoComplete="new-password" placeholder="Leer lassen: wird sicher erzeugt"
                        value=""/><small>Eigenes Passwort: mindestens 10 Zeichen. Leer lassen erzeugt automatisch ein
                        sicheres Passwort.</small></label><label><span>Kurs zuweisen (optional)</span><select>
                        <option value="" selected="">Noch keinen Kurs zuweisen</option>
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
                    </select></label><label><span>Startdatum · Standard plus 14 Tage</span><input type="date"
                                                                                                  disabled=""
                                                                                                  value="2026-09-08"/><small>Bei
                        dokumentiertem vorzeitigem Beginn frei
                        änderbar.</small></label><label><span>Enddatum</span><input
                        type="date" disabled="" value=""/><small>Wird nach der Kursauswahl berechnet.</small></label>
                <label
                    class="early-start-confirmation"><input type="checkbox" disabled=""/><span>Ausdrückliche Kundenerklärung zum vorzeitigen Beginn liegt dokumentiert vor.</span></label>
                <button class="early-start-button" type="button" disabled="">Sofortstart mit voller Laufzeit und Konto
                    anlegen
                </button>
                <button
                    type="submit">Kundenkonto sicher anlegen
                </button>
            </form>
        </section>
        <section class="admin-section admin-public" id="auslieferung">
            <header>
                <div><span>05</span>
                    <p class="eyebrow">Auslieferung und Support</p>
                </div>
                <h2>Kundenwege öffnen und Adressen kopieren.</h2>
            </header>
            <div class="delivery-login-card">
                <div><span>Wichtigste Kundenadresse</span><strong>Kunden-Anmeldung</strong><code>/login</code>
                    <p>Diese Adresse erhält der Kunde für die Anmeldung in seinem freigeschalteten Kursbereich.</p>
                </div>
                <div><a href="{{ route('login') }}" target="_blank" rel="noreferrer">Anmeldeseite öffnen</a>
                    <button type="button">Adresse kopieren</button>
                </div>
            </div>
            <div class="delivery-course-directory">
                <div class="delivery-course-heading"><strong>Geschützte Kursauslieferung</strong><span>Als Administrator öffnest du hier die echte Kursansicht mit einer klar gekennzeichneten Admin-Prüfansicht.</span>
                </div>
                <article>
                    <div><strong>5-Tage-Kompaktlehrgang</strong><span>Nur interne Administrator-Prüfansicht</span></div>
                    <nav aria-label="Auslieferung 5-Tage-Kompaktlehrgang"><a href="{{ route('course-compact') }}"
                                                                             target="_blank"
                                                                             rel="noreferrer">Wie der Kunde ansehen</a>
                    </nav>
                </article>
                <article>
                    <div><strong>Vertiefungsausbildung</strong><span>Nur interne Administrator-Prüfansicht</span></div>
                    <nav aria-label="Auslieferung Vertiefungsausbildung"><a href="#" target="_blank"
                                                                            rel="noreferrer">Wie der Kunde ansehen</a>
                    </nav>
                </article>
                <article>
                    <div><strong>Premium-Seminar</strong><span>Nur interne Administrator-Prüfansicht</span></div>
                    <nav aria-label="Auslieferung Premium-Seminar"><a href="#" target="_blank"
                                                                      rel="noreferrer">Wie der Kunde ansehen</a></nav>
                </article>
                <article>
                    <div><strong>Stress und Ressourcen</strong><span>Nur interne Administrator-Prüfansicht</span></div>
                    <nav aria-label="Auslieferung Stress und Ressourcen"><a href="#"
                                                                            target="_blank" rel="noreferrer">Wie der
                            Kunde
                            ansehen</a></nav>
                </article>
                <article>
                    <div><strong>Rauchfrei</strong><span>Nur interne Administrator-Prüfansicht</span></div>
                    <nav aria-label="Auslieferung Rauchfrei"><a href="#" target="_blank" rel="noreferrer">Wie
                            der Kunde ansehen</a></nav>
                </article>
                <article>
                    <div><strong>Ernährung</strong><span>Nur interne Administrator-Prüfansicht</span></div>
                    <nav aria-label="Auslieferung Ernährung"><a href="#" target="_blank" rel="noreferrer">Wie
                            der Kunde ansehen</a></nav>
                </article>
                <article>
                    <div><strong>Klar entscheiden</strong><span>Nur interne Administrator-Prüfansicht</span></div>
                    <nav aria-label="Auslieferung Klar entscheiden"><a href="#" target="_blank"
                                                                       rel="noreferrer">Wie der Kunde ansehen</a></nav>
                </article>
                <article>
                    <div><strong>Erfolgreich gründen</strong><span>Nur interne Administrator-Prüfansicht</span></div>
                    <nav aria-label="Auslieferung Erfolgreich gründen"><a href="#" target="_blank"
                                                                          rel="noreferrer">Wie der Kunde ansehen</a>
                    </nav>
                </article>
                <article>
                    <div><strong>Presse &amp; Öffentlichkeit</strong><span>Nur interne Administrator-Prüfansicht</span>
                    </div>
                    <nav aria-label="Auslieferung Presse &amp; Öffentlichkeit"><a href="#"
                                                                                  target="_blank" rel="noreferrer">Wie
                            der
                            Kunde ansehen</a></nav>
                </article>
                <article>
                    <div><strong>Rhetorik unter Druck</strong><span>Nur interne Administrator-Prüfansicht</span></div>
                    <nav aria-label="Auslieferung Rhetorik unter Druck"><a href="#" target="_blank"
                                                                           rel="noreferrer">Wie der Kunde ansehen</a>
                    </nav>
                </article>
                <article>
                    <div><strong>Rio Negro 2002</strong><span>Nur interne Administrator-Prüfansicht</span></div>
                    <nav aria-label="Auslieferung Rio Negro 2002"><a href="#" target="_blank"
                                                                     rel="noreferrer">Wie der Kunde ansehen</a></nav>
                </article>
            </div>
            <div class="public-course-directory">
                <div class="delivery-course-heading"><strong>Kursseiten</strong><span>Je Kurs getrennt: öffentliche Kursseite auf der Website und echter geschützter Kurszugang in diesem Portal.</span>
                </div>
                <article><strong>5-Tage-Kompaktlehrgang</strong>
                    <div class="public-course-address"><span>Öffentliche Kursseite</span><code>https://besseler-kursvorschau.dennis-bes.chatgpt.site/akademie/bildungsurlaub/</code><a
                            href="https://besseler-kursvorschau.dennis-bes.chatgpt.site/akademie/bildungsurlaub/"
                            target="_blank"
                            rel="noreferrer">Öffnen</a>
                        <button type="button">Kopieren</button>
                    </div>
                    <div class="public-course-address"><span>Echter Kurszugang</span><code>/kurs/dnl-kompakt</code><a
                            href="/kurs/dnl-kompakt" target="_blank" rel="noreferrer">Öffnen</a>
                        <button type="button">Kopieren</button>
                    </div>
                </article>
                <article><strong>Vertiefungsausbildung</strong>
                    <div class="public-course-address"><span>Öffentliche Kursseite</span><code>https://besseler-kursvorschau.dennis-bes.chatgpt.site/akademie/vertiefung/</code><a
                            href="https://besseler-kursvorschau.dennis-bes.chatgpt.site/akademie/vertiefung/"
                            target="_blank" rel="noreferrer">Öffnen</a>
                        <button
                            type="button">Kopieren
                        </button>
                    </div>
                    <div class="public-course-address"><span>Echter Kurszugang</span><code>/kurs/dnl-vertiefung</code><a
                            href="/kurs/dnl-vertiefung" target="_blank" rel="noreferrer">Öffnen</a>
                        <button type="button">Kopieren</button>
                    </div>
                </article>
                <article><strong>Premium-Seminar</strong>
                    <div class="public-course-address"><span>Öffentliche Kursseite</span><code>https://besseler-kursvorschau.dennis-bes.chatgpt.site/akademie/premium/</code><a
                            href="https://besseler-kursvorschau.dennis-bes.chatgpt.site/akademie/premium/"
                            target="_blank"
                            rel="noreferrer">Öffnen</a>
                        <button
                            type="button">Kopieren
                        </button>
                    </div>
                    <div class="public-course-address"><span>Echter Kurszugang</span><code>/kurs/dnl-premium</code><a
                            href="/kurs/dnl-premium" target="_blank" rel="noreferrer">Öffnen</a>
                        <button type="button">Kopieren</button>
                    </div>
                </article>
                <article><strong>Stress und Ressourcen</strong>
                    <div class="public-course-address"><span>Öffentliche Kursseite</span><code>https://besseler-kursvorschau.dennis-bes.chatgpt.site/praevention/stress/</code><a
                            href="https://besseler-kursvorschau.dennis-bes.chatgpt.site/praevention/stress/"
                            target="_blank"
                            rel="noreferrer">Öffnen</a>
                        <button
                            type="button">Kopieren
                        </button>
                    </div>
                    <div class="public-course-address">
                        <span>Echter Kurszugang</span><code>/kurs/stress-und-ressourcen</code><a
                            href="/kurs/stress-und-ressourcen" target="_blank" rel="noreferrer">Öffnen</a>
                        <button type="button">Kopieren</button>
                    </div>
                </article>
                <article><strong>Rauchfrei</strong>
                    <div class="public-course-address"><span>Öffentliche Kursseite</span><code>https://besseler-kursvorschau.dennis-bes.chatgpt.site/praevention/rauchfrei/</code><a
                            href="https://besseler-kursvorschau.dennis-bes.chatgpt.site/praevention/rauchfrei/"
                            target="_blank" rel="noreferrer">Öffnen</a>
                        <button
                            type="button">Kopieren
                        </button>
                    </div>
                    <div class="public-course-address"><span>Echter Kurszugang</span><code>/kurs/rauchfrei</code><a
                            href="/kurs/rauchfrei" target="_blank" rel="noreferrer">Öffnen</a>
                        <button type="button">Kopieren</button>
                    </div>
                </article>
                <article><strong>Ernährung</strong>
                    <div class="public-course-address"><span>Öffentliche Kursseite</span><code>https://besseler-kursvorschau.dennis-bes.chatgpt.site/praevention/ernaehrung/</code><a
                            href="https://besseler-kursvorschau.dennis-bes.chatgpt.site/praevention/ernaehrung/"
                            target="_blank"
                            rel="noreferrer">Öffnen</a>
                        <button type="button">Kopieren</button>
                    </div>
                    <div class="public-course-address"><span>Echter Kurszugang</span><code>/kurs/ernaehrung</code><a
                            href="/kurs/ernaehrung" target="_blank" rel="noreferrer">Öffnen</a>
                        <button type="button">Kopieren</button>
                    </div>
                </article>
                <article><strong>Klar entscheiden</strong>
                    <div class="public-course-address"><span>Öffentliche Kursseite</span><code>https://besseler-kursvorschau.dennis-bes.chatgpt.site/praevention/klar-entscheiden/</code><a
                            href="https://besseler-kursvorschau.dennis-bes.chatgpt.site/praevention/klar-entscheiden/"
                            target="_blank"
                            rel="noreferrer">Öffnen</a>
                        <button type="button">Kopieren</button>
                    </div>
                    <div class="public-course-address"><span>Echter Kurszugang</span><code>/kurs/klar-entscheiden</code><a
                            href="/kurs/klar-entscheiden" target="_blank" rel="noreferrer">Öffnen</a>
                        <button type="button">Kopieren</button>
                    </div>
                </article>
                <article><strong>Erfolgreich gründen</strong>
                    <div class="public-course-address"><span>Öffentliche Kursseite</span><code>https://besseler-kursvorschau.dennis-bes.chatgpt.site/gruenden/</code><a
                            href="https://besseler-kursvorschau.dennis-bes.chatgpt.site/gruenden/" target="_blank"
                            rel="noreferrer">Öffnen</a>
                        <button
                            type="button">Kopieren
                        </button>
                    </div>
                    <div class="public-course-address">
                        <span>Echter Kurszugang</span><code>/kurs/erfolgreich-gruenden</code><a
                            href="/kurs/erfolgreich-gruenden" target="_blank" rel="noreferrer">Öffnen</a>
                        <button type="button">Kopieren</button>
                    </div>
                </article>
                <article><strong>Presse &amp; Öffentlichkeit</strong>
                    <div class="public-course-address"><span>Öffentliche Kursseite</span><code>https://besseler-kursvorschau.dennis-bes.chatgpt.site/presse/</code><a
                            href="https://besseler-kursvorschau.dennis-bes.chatgpt.site/presse/" target="_blank"
                            rel="noreferrer">Öffnen</a>
                        <button
                            type="button">Kopieren
                        </button>
                    </div>
                    <div class="public-course-address">
                        <span>Echter Kurszugang</span><code>/kurs/presse-oeffentlichkeit</code><a
                            href="/kurs/presse-oeffentlichkeit" target="_blank" rel="noreferrer">Öffnen</a>
                        <button type="button">Kopieren</button>
                    </div>
                </article>
                <article><strong>Rhetorik unter Druck</strong>
                    <div class="public-course-address"><span>Öffentliche Kursseite</span><code>https://besseler-kursvorschau.dennis-bes.chatgpt.site/rhetorik/</code><a
                            href="https://besseler-kursvorschau.dennis-bes.chatgpt.site/rhetorik/" target="_blank"
                            rel="noreferrer">Öffnen</a>
                        <button
                            type="button">Kopieren
                        </button>
                    </div>
                    <div class="public-course-address">
                        <span>Echter Kurszugang</span><code>/kurs/rhetorik-unter-druck</code><a
                            href="/kurs/rhetorik-unter-druck" target="_blank" rel="noreferrer">Öffnen</a>
                        <button type="button">Kopieren</button>
                    </div>
                </article>
                <article><strong>Rio Negro 2002</strong>
                    <div class="public-course-address"><span>Öffentliche Kursseite</span><code>https://besseler-kursvorschau.dennis-bes.chatgpt.site/service/rio-negro/</code><a
                            href="https://besseler-kursvorschau.dennis-bes.chatgpt.site/service/rio-negro/"
                            target="_blank"
                            rel="noreferrer">Öffnen</a>
                        <button
                            type="button">Kopieren
                        </button>
                    </div>
                    <div class="public-course-address"><span>Echter Kurszugang</span><code>/kurs/rio-negro-2002</code><a
                            href="/kurs/rio-negro-2002" target="_blank" rel="noreferrer">Öffnen</a>
                        <button type="button">Kopieren</button>
                    </div>
                </article>
            </div>
            <p class="admin-directory-intro">Hier sind sämtliche vorhandenen Oberflächen direkt erreichbar. Echte
                Mitarbeiter- und Kundenbereiche bleiben geschützt; dafür stehen dem Administrator gekennzeichnete
                Prüfansichten zur Verfügung.</p>
            <div class="admin-overview-status"><span><b>9</b> extern erreichbare Portalseiten</span><span><b>20</b> interne Arbeits- und Prüfansichten</span>
            </div>
            <div class="admin-communication-grid">
                <section class="admin-link-panel is-external">
                    <header><span>Extern veröffentlicht</span><strong>Kunden und Interessenten</strong></header>
                    <nav aria-label="Extern veröffentlichte Portalseiten"><a href="/" target="_blank"
                                                                             rel="noreferrer"><span>Portalstart</span><b>↗</b></a><a
                            href="/login" target="_blank" rel="noreferrer"><span>Kundenlogin</span><b>↗</b></a><a
                            href="/passwort-vergessen" target="_blank"
                            rel="noreferrer"><span>Passwort vergessen</span><b>↗</b></a>
                        <a
                            href="/zahlung" target="_blank" rel="noreferrer"><span>Zahlung</span><b>↗</b></a><a
                            href="/zahlungsbedingungen" target="_blank"
                            rel="noreferrer"><span>Zahlungsbedingungen</span><b>↗</b></a><a
                            href="/service/rio-negro" target="_blank"
                            rel="noreferrer"><span>Rio-Negro-Service</span><b>↗</b></a>
                        <a
                            href="/kopierschutz" target="_blank"
                            rel="noreferrer"><span>Kopierschutz</span><b>↗</b></a><a
                            href="/datenschutz" target="_blank" rel="noreferrer"><span>Datenschutz</span><b>↗</b></a><a
                            href="/impressum" target="_blank" rel="noreferrer"><span>Impressum</span><b>↗</b></a></nav>
                </section>
                <section class="admin-link-panel is-internal">
                    <header><span>Arbeits- und Prüfansichten</span><strong>Verwaltung, Mitarbeiter und
                            Testseiten</strong>
                    </header>
                    <nav aria-label="Interne Arbeits- und Prüfansichten"><a href="/verwaltung" target="_blank"
                                                                            rel="noreferrer"><span>Kundenverwaltung</span><b>↗</b></a><a
                            href="/mitarbeiter-login" target="_blank"
                            rel="noreferrer"><span>Mitarbeiterlogin</span><b>↗</b></a><a
                            href="/verwaltung/mitarbeiter-vorschau"
                            target="_blank"
                            rel="noreferrer"><span>Mitarbeiter-Arbeitsfläche · Admin-Prüfansicht</span><b>↗</b></a><a
                            href="/mitarbeiter" target="_blank"
                            rel="noreferrer"><span>Mitarbeiterbereich · nach Login</span><b>↗</b></a><a
                            href="/mitarbeiter-passwort"
                            target="_blank"
                            rel="noreferrer"><span>Mitarbeiterpasswort wiederherstellen</span><b>↗</b></a><a
                            href="/verwaltung/audio-website" target="_blank"
                            rel="noreferrer"><span>Rio-Negro-Audio-Struktur</span><b>↗</b></a><a href="/kurs-test"
                                                                                                 target="_blank"
                                                                                                 rel="noreferrer"><span>Allgemeine Kurs-Testseite</span><b>↗</b></a><a
                            href="/kurs-test/ernaehrung" target="_blank"
                            rel="noreferrer"><span>Ernährung · Testseite</span><b>↗</b></a><a
                            href="/kurs-test/presse-oeffentlichkeit"
                            target="_blank"
                            rel="noreferrer"><span>Presse &amp; Öffentlichkeit · Testseite</span><b>↗</b></a></nav>
                    <div class="admin-compact-courses"><strong>Geschützte Kundenkurse</strong>
                        <div><span>5-Tage-Kompaktlehrgang</span>
                            <nav><a href="/kurs/dnl-kompakt" target="_blank" rel="noreferrer">Kundenkurs</a></nav>
                        </div>
                        <div><span>Vertiefungsausbildung</span>
                            <nav><a href="/kurs/dnl-vertiefung" target="_blank" rel="noreferrer">Kundenkurs</a></nav>
                        </div>
                        <div><span>Premium-Seminar</span>
                            <nav><a href="/kurs/dnl-premium" target="_blank" rel="noreferrer">Kundenkurs</a></nav>
                        </div>
                        <div><span>Stress und Ressourcen</span>
                            <nav><a href="/kurs/stress-und-ressourcen" target="_blank" rel="noreferrer">Kundenkurs</a>
                            </nav>
                        </div>
                        <div><span>Rauchfrei</span>
                            <nav><a href="/kurs/rauchfrei" target="_blank" rel="noreferrer">Kundenkurs</a></nav>
                        </div>
                        <div><span>Ernährung</span>
                            <nav><a href="/kurs/ernaehrung" target="_blank" rel="noreferrer">Kundenkurs</a></nav>
                        </div>
                        <div><span>Klar entscheiden</span>
                            <nav><a href="/kurs/klar-entscheiden" target="_blank" rel="noreferrer">Kundenkurs</a></nav>
                        </div>
                        <div><span>Erfolgreich gründen</span>
                            <nav><a href="/kurs/erfolgreich-gruenden" target="_blank" rel="noreferrer">Kundenkurs</a>
                            </nav>
                        </div>
                        <div><span>Presse &amp; Öffentlichkeit</span>
                            <nav><a href="/kurs/presse-oeffentlichkeit" target="_blank" rel="noreferrer">Kundenkurs</a>
                            </nav>
                        </div>
                        <div><span>Rhetorik unter Druck</span>
                            <nav><a href="/kurs/rhetorik-unter-druck" target="_blank" rel="noreferrer">Kundenkurs</a>
                            </nav>
                        </div>
                        <div><span>Rio Negro 2002</span>
                            <nav><a href="/kurs/rio-negro-2002" target="_blank" rel="noreferrer">Kundenkurs</a></nav>
                        </div>
                    </div>
                </section>
            </div>
        </section>
        <section class="admin-section admin-backend" id="sicherheit">
            <header>
                <div><span>06</span>
                    <p class="eyebrow">Arbeitsprozess</p>
                </div>
                <h2>Einfach und nachvollziehbar.</h2>
            </header>
            <div class="backend-functions">
                <article><strong>Ein Gerät</strong><span>Das erste erfolgreiche Login bindet das Kundenkonto an dieses Gerät.</span>
                </article>
                <article><strong>Kein
                        Geräte-Reset</strong><span>Bei Gerätewechsel das alte Kundenkonto vollständig löschen.</span>
                </article>
                <article><strong>Neu anlegen</strong><span>Neues Konto, neue Zugangsdaten, Kurs und Laufzeit bewusst neu vergeben.</span>
                </article>
                <article><strong>Datensparsam</strong><span>Vorname und Kunden-/Rechnungsnummer ermöglichen die pseudonymisierte Zuordnung. Abgelaufene Konten werden automatisch entfernt; Buchungsbelege bleiben nur nach gesetzlicher Frist erhalten.</span>
                </article>
                <article><strong>Passwort vergessen</strong><span>Rechnungsnummer und Kurs ordnen die Anfrage zu. Neues Passwort erst nach Abgleich über die Buchhaltung übermitteln.</span>
                </article>
                <article class="integration-pending"><strong>Papierkram-Rechnungen</strong><span>Mitarbeiter müssen vor der ersten Anmeldung von Dennis als Benutzer bei Papierkram freigeschaltet werden. Bei technischen Login-, Passwort- oder Systemproblemen hilft ausschließlich der Papierkram-Support.</span>
                    <a
                        href="https://dennisbesseler.papierkram.de/login?email=mail%40besseler.de" target="_blank"
                        rel="noreferrer">Papierkram öffnen ↗</a><a href="https://hilfe.papierkram.de/system-status/"
                                                                   target="_blank" rel="noreferrer">Papierkram-Support
                        ↗</a>
                </article>
            </div>
        </section>
        <section class="admin-section admin-security-settings" id="hauptadmin-sicherheit">
            <header>
                <div><span>08</span>
                    <h2>Hauptadmin-<br/>Sicherheit.</h2>
                </div>
                <p>Das Admin-Passwort kann hier sicher geändert werden. Der vierstellige Sicherheitscode bleibt fest
                    hinterlegt und wird im Portal niemals angezeigt. Eine Passwortänderung beendet alle
                    Hauptadmin-Sitzungen.</p>
            </header>
            <div class="admin-security-grid">
                <form autoComplete="off">
                    <h3>Admin-Passwort ändern</h3>
                    <p>Mindestens 12 Zeichen mit Groß- und Kleinbuchstaben, Zahl und Sonderzeichen.</p><label><span>Bisheriges Admin-Passwort</span><input
                            autoComplete="current-password" required="" type="password" value=""/></label><label><span>Bisheriger Sicherheitscode</span><input
                            autoComplete="off" inputMode="numeric" maxLength="4" pattern="[0-9]{4}" required=""
                            type="password" value=""/></label><label><span>Neues Admin-Passwort</span><input
                            autoComplete="new-password" maxLength="128" minLength="12" required="" type="password"
                            value=""/></label><label><span>Neues Passwort wiederholen</span><input
                            autoComplete="new-password" maxLength="128" minLength="12" required="" type="password"
                            value=""/></label>
                    <button
                        type="submit">Sicher ändern
                    </button>
                </form>
            </div>
        </section>
        <div class="portal-bottom-navigation" id="admin-page-end"><a class="portal-jump-arrow portal-jump-up"
                                                                     href="#admin-page-top"
                                                                     aria-label="Zurück zum Seitenanfang"><span
                    aria-hidden="true">↑</span></a></div>
    </main>
@endsection
