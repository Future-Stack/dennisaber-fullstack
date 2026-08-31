{{-- Support Assistant Component (Vanilla JS, Zero Dependency) --}}
<aside class="support-assistant" id="portal-support-assistant" aria-label="Support">
    <section class="support-assistant__panel" id="support-assistant-panel" style="display: none;">
        <header>
            <div>
                <span>Kursportal-Hilfe</span>
                <h2>Wobei brauchst du Hilfe?</h2>
            </div>
            <button type="button" aria-label="Hilfe schließen" onclick="toggleSupportAssistant(false)">×</button>
        </header>

        <p class="support-assistant__notice">
            Lokale Hilfe ohne externe KI. Bitte gib keine Passwörter, Rechnungsnummern oder Zahlungsdaten ein.
        </p>

        <div class="support-assistant__topics" aria-label="Häufige Hilfethemen">
            <button type="button" onclick="setSupportQuery('Wie bestelle ich einen Kurs?')">Kurs bestellen</button>
            <button type="button" onclick="setSupportQuery('Kann ich hier bezahlen?')">Im Portal bezahlen</button>
            <button type="button" onclick="setSupportQuery('Wo finde ich Beratung zu den Kursinhalten?')">Kursberatung</button>
            <button type="button" onclick="setSupportQuery('Was kostet ein Kurs?')">Kurskosten</button>
            <button type="button" onclick="setSupportQuery('Wie lange kann ich einen Kurs nutzen?')">Zugangsdauer</button>
        </div>

        <form class="support-assistant__search" onsubmit="event.preventDefault(); searchSupportFaq();">
            <label for="support-query">Frage eingeben</label>
            <div>
                <input id="support-query" type="text" maxlength="240" autocomplete="off" placeholder="Zum Beispiel: Audio startet nicht" oninput="searchSupportFaq()" />
                <button type="submit">Suchen</button>
            </div>
        </form>

        <div class="support-assistant__results" id="support-results" aria-live="polite">
            {{-- Dynamically populated search results --}}
        </div>

        <footer>
            <a class="support-assistant__mail" id="support-mail-link" href="mailto:mail@besseler.de?subject=Supportanfrage%20Kursportal">
                Persönlichen Support kontaktieren
            </a>
            <a href="{{ route('privacy-policy') }}">Datenschutzhinweise</a>
        </footer>
    </section>

    <button type="button" class="support-assistant__toggle" id="support-assistant-toggle-btn" aria-expanded="false" aria-controls="support-assistant-panel" onclick="toggleSupportAssistant()">
        Support
    </button>
</aside>

<script>
(function() {
    const supportFaqs = [
        {
            id: 'PO-01', area: 'Portal', title: 'Kurs bestellen', question: 'Wie bestelle ich einen Kurs?',
            keywords: ['kaufen', 'buchen', 'bestellen', 'kurs erwerben', 'order'],
            answer: 'Über dieses Kursportal kannst du keinen Kurs bestellen. Information, Beratung und verbindliche Buchung findest du ausschließlich auf besseler.de. Dieses Portal stellt bereits freigeschalteten Kunden ihre Kurse bereit.',
            href: 'https://www.besseler.de', linkLabel: 'Zu besseler.de', support: false
        },
        {
            id: 'PO-02', area: 'Portal', title: 'Im Portal bezahlen', question: 'Kann ich hier bezahlen?',
            keywords: ['zahlung', 'bezahlvorgang', 'kreditkarte', 'überweisung', 'girocode'],
            answer: 'Nein. Das Portal löst keine Überweisung aus. Du kannst Angaben aus deiner persönlichen Rechnung lediglich lokal in einen GiroCode umwandeln; sie werden nicht versendet oder gespeichert. Die Zahlung bestätigst du ausschließlich selbst in deiner Banking-App.',
            href: '/zahlung#banking-qr', linkLabel: 'Zur sicheren GiroCode-Hilfe', support: false
        },
        {
            id: 'PO-03', area: 'Portal', title: 'Kursberatung', question: 'Wo finde ich Beratung zu den Kursinhalten?',
            keywords: ['beratung', 'welcher kurs passt', 'empfehlung', 'auswahl'],
            answer: 'Beratung und Leistungsbeschreibungen findest du ausschließlich auf besseler.de. Dieses Portal stellt nur bereits gebuchte Kurse technisch bereit.',
            href: 'https://www.besseler.de', linkLabel: 'Zu besseler.de', support: false
        },
        {
            id: 'KP-01', area: 'Kurse', title: 'Kurskosten', question: 'Was kostet ein Kurs?',
            keywords: ['preis', 'kosten', 'wie teuer', 'preisliste', 'gebühr'],
            answer: 'Den aktuell gültigen Preis findest du auf der Landingpage des jeweiligen Kurses in der Kursübersicht.',
            href: '/', linkLabel: 'Zur Kursübersicht', support: false
        },
        {
            id: 'KP-02', area: 'Kurse', title: 'Kursübersicht', question: 'Wie viele Kurse gibt es?',
            keywords: ['kursangebot', 'übersicht', 'welche kurse', 'katalog'],
            answer: 'Das Portal umfasst elf Kurse in vier Bereichen: Entscheiden und führen, Gesundheit verändern, Gründen und Wirkung sowie Abenteuer. Jeder Kurs hat eine eigene Landingpage.',
            href: '/', linkLabel: 'Alle Kurse ansehen', support: false
        },
        {
            id: 'KP-03', area: 'Kurse', title: 'Zugangsdauer', question: 'Wie lange kann ich einen Kurs nutzen?',
            keywords: ['laufzeit', 'zugangsdauer', 'wie lange zugriff', 'abgelaufen', 'dauer'],
            answer: 'Reguläre Kurse laufen drei Monate ab der individuellen Freischaltung. Das Audio-Abenteuer Rio Negro 2002 ist die einzige Ausnahme und läuft 30 Tage.',
            href: '/', linkLabel: 'Zur Kursübersicht', support: false
        },
        {
            id: 'KP-04', area: 'Kurse', title: 'Kein Abo', question: 'Ist das ein Abo?',
            keywords: ['abo', 'automatische verlängerung', 'kündigen', 'abbuchung', 'vertrag'],
            answer: 'Nein. Es gilt eine einmalige Zahlung. Es gibt keine automatische Verlängerung und keine weitere Abbuchung. Der Zugang endet automatisch.',
            support: false
        },
        {
            id: 'KP-05', area: 'Kurse', title: 'Zugang verlängern', question: 'Kann ich meinen abgelaufenen Kurs verlängern?',
            keywords: ['kurs verlängern', 'zugang verlängern', 'reaktivieren', 'nochmal freischalten'],
            answer: 'Nein. Nach Ablauf der letzten Freigabe wird das Kundenkonto automatisch aus dem Kursportal gelöscht und kann nicht reaktiviert werden. Für einen neuen Zugang muss der Kurs erneut gekauft werden. Nur bei Präventionskursen mit mehr als zehn Zugängen kann vorab eine individuelle Laufzeitregelung vereinbart werden.',
            href: 'https://www.besseler.de', linkLabel: 'Kurs erneut buchen', support: true
        },
        {
            id: 'ZA-01', area: 'Zahlung', title: 'Zahlungsablauf', question: 'Wie läuft die Zahlung ab?',
            keywords: ['überweisung', 'wie bezahle ich', 'ablauf zahlung', 'rechnung bezahlen'],
            answer: 'Nach der Bestellung auf besseler.de erhältst du deine persönlichen Zahlungsunterlagen. Verwende GiroCode oder Bankdaten ausschließlich aus deiner persönlichen Rechnung und übernimm den Verwendungszweck unverändert.',
            href: '/zahlung', linkLabel: 'Zahlungsablauf ansehen', support: false
        },
        {
            id: 'ZA-03', area: 'Zahlung', title: 'Zahlungsprüfung', question: 'Wann wird meine Zahlung geprüft?',
            keywords: ['zahlungseingang', 'wann kommt die freischaltung', 'bearbeitungszeit', 'prüfung'],
            answer: 'Die Zahlungsprüfung erfolgt täglich zwischen 13 und 16 Uhr. Deine persönliche Freischaltung wird anschließend per E-Mail mitgeteilt.',
            href: '/zahlung', linkLabel: 'Zum Zahlungsablauf', support: true
        },
        {
            id: 'ZA-04', area: 'Zahlung', title: 'Zahlungsstatus', question: 'Ist mein Geld angekommen?',
            keywords: ['status', 'geld da', 'zahlung eingegangen', 'bestätigung'],
            answer: 'Diese Hilfe kann Zahlungseingänge weder einsehen noch bestätigen. Den konkreten Bearbeitungsstand klärt der persönliche Support.',
            support: true
        },
        {
            id: 'LO-01', area: 'Anmeldung', title: 'Anmelden', question: 'Wie melde ich mich an?',
            keywords: ['login', 'einloggen', 'anmelden', 'zugang öffnen', 'passwort'],
            answer: 'Bereits freigeschaltete Kunden gelangen mit Benutzername und Passwort direkt in ihren gebuchten Kurs.',
            href: '/login', linkLabel: 'Zum Kundenlogin', support: false
        },
        {
            id: 'LO-02', area: 'Anmeldung', title: 'Passwort vergessen', question: 'Ich habe mein Passwort vergessen.',
            keywords: ['passwort zurücksetzen', 'zugangsdaten vergessen', 'benutzername vergessen', 'neues passwort'],
            answer: 'Nutze die sichere Zugangsanfrage mit deiner Rechnungs- oder Kundennummer und dem gebuchten Kurs. Das Portal bestätigt nicht, ob ein Konto existiert. Neue Zugangsdaten werden erst nach dem internen Abgleich übermittelt; es wird kein automatischer Rücksetzlink versendet.',
            href: '/passwort-vergessen', linkLabel: 'Zugangsdaten anfordern', support: false
        },
        {
            id: 'KN-03', area: 'Kursnutzung', title: 'Audio startet nicht', question: 'Ein Audio startet nicht.',
            keywords: ['audio funktioniert nicht', 'mp3 startet nicht', 'kein ton', 'player kaputt', 'video'],
            answer: 'Lade die Kursseite neu, prüfe Browser- und Gerätelautstärke und öffne den Kurs nur in einem Browserfenster. Bleibt der Fehler bestehen, nenne dem Support Kurs, Einheit und Browser – niemals dein Passwort.',
            support: true
        },
        {
            id: 'GB-01', area: 'Gerät', title: 'Neues Gerät', question: 'Ich brauche ein neues Gerät für meinen Zugang.',
            keywords: ['gerätewechsel', 'neues handy', 'neuer laptop', 'anderes gerät', 'gerät zurücksetzen'],
            answer: 'Bitte wende dich für die Freischaltung eines neuen Geräts an den persönlichen Support.',
            support: true
        },
        {
            id: 'GR-08', area: 'Grenzen', title: 'Mit einem Menschen sprechen', question: 'Ich möchte mit einem Menschen sprechen.',
            keywords: ['mensch', 'support', 'e-mail', 'mail', 'echter mitarbeiter', 'kontakt'],
            answer: 'Über „Persönlichen Support kontaktieren“ erreichst du direkt den persönlichen Support.',
            support: true
        }
    ];

    function normalize(str) {
        return (str || '')
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/ß/g, 'ss')
            .replace(/[^a-z0-9]+/g, ' ')
            .trim();
    }

    window.toggleSupportAssistant = function(forceOpen) {
        const assistant = document.getElementById('portal-support-assistant');
        const panel = document.getElementById('support-assistant-panel');
        const toggleBtn = document.getElementById('support-assistant-toggle-btn');
        if (!assistant || !panel || !toggleBtn) return;

        const isOpen = forceOpen !== undefined ? forceOpen : (panel.style.display === 'none' || !panel.style.display);

        if (isOpen) {
            assistant.classList.add('is-open');
            panel.style.display = 'block';
            toggleBtn.setAttribute('aria-expanded', 'true');
            const input = document.getElementById('support-query');
            if (input) {
                setTimeout(() => input.focus(), 50);
                if (!input.value.trim()) {
                    window.searchSupportFaq();
                }
            }
        } else {
            assistant.classList.remove('is-open');
            panel.style.display = 'none';
            toggleBtn.setAttribute('aria-expanded', 'false');
            toggleBtn.focus();
        }
    };

    window.setSupportQuery = function(text) {
        const input = document.getElementById('support-query');
        if (input) {
            input.value = text;
            window.searchSupportFaq();
            input.focus();
        }
    };

    window.searchSupportFaq = function() {
        const input = document.getElementById('support-query');
        const resultsContainer = document.getElementById('support-results');
        if (!resultsContainer) return;

        const query = input ? input.value : '';
        const normalizedQuery = normalize(query);

        // Security check for password / IBAN / sensitive data
        const isSensitive = /\bDE\d{20}\b/i.test(query.replace(/\s/g, '')) || 
                            /\b(?:passwort|password|pin|kartennummer|kreditkarte)\s*[:=]\s*\S+/i.test(query) || 
                            /\b\d{12,19}\b/.test(query.replace(/\s/g, ''));

        let html = '';

        if (isSensitive) {
            html += '<p class="support-assistant__warning">Bitte gib hier keine Passwörter oder Zahlungsdaten ein. Die Eingabe wird nicht gespeichert oder übertragen.</p>';
        }

        const mailSubject = encodeURIComponent('Supportanfrage Kursportal');
        const mailBody = encodeURIComponent('Bitte beschreibe dein Anliegen. Sende keine Passwörter oder Zahlungsdaten:\n\n---\nGeöffnete Portalseite: ' + window.location.pathname);
        const mailHref = 'mailto:mail@besseler.de?subject=' + mailSubject + '&body=' + mailBody;

        const updateMailLink = document.getElementById('support-mail-link');
        if (updateMailLink) {
            updateMailLink.href = mailHref;
        }

        if (normalizedQuery.length < 2) {
            // Show top 3 default FAQs
            const defaultFaqs = supportFaqs.slice(0, 3);
            defaultFaqs.forEach(faq => {
                html += `
                    <article>
                        <small>${faq.area}</small>
                        <h3>${faq.title}</h3>
                        <p>${faq.answer}</p>
                        <div class="support-assistant__actions">
                            ${faq.href ? `<a href="${faq.href}">${faq.linkLabel || 'Mehr erfahren'}</a>` : ''}
                            ${faq.support ? `<a href="${mailHref}">Persönlichen Support kontaktieren</a>` : ''}
                        </div>
                    </article>
                `;
            });
        } else {
            const queryWords = normalizedQuery.split(' ').filter(w => w.length > 1);

            const scoredFaqs = supportFaqs.map(faq => {
                const combined = normalize([faq.title, faq.question, faq.area, faq.keywords.join(' '), faq.answer].join(' '));
                let score = 0;
                if (combined.includes(normalizedQuery)) score += 6;
                queryWords.forEach(word => {
                    if (combined.includes(word)) score += 2;
                });
                return { faq, score };
            }).filter(item => item.score > 0).sort((a, b) => b.score - a.score).slice(0, 3);

            if (scoredFaqs.length > 0) {
                scoredFaqs.forEach(({ faq }) => {
                    html += `
                        <article>
                            <small>${faq.area}</small>
                            <h3>${faq.title}</h3>
                            <p>${faq.answer}</p>
                            <div class="support-assistant__actions">
                                ${faq.href ? `<a href="${faq.href}">${faq.linkLabel || 'Mehr erfahren'}</a>` : ''}
                                ${faq.support ? `<a href="${mailHref}">Persönlichen Support kontaktieren</a>` : ''}
                            </div>
                        </article>
                    `;
                });
            } else {
                html += `
                    <article>
                        <small>Persönlicher Support</small>
                        <h3>Keine passende Schnellhilfe gefunden?</h3>
                        <p>Unser Support-Team hilft dir gerne persönlich weiter.</p>
                        <div class="support-assistant__actions">
                            <a href="${mailHref}">Persönlichen Support kontaktieren</a>
                        </div>
                    </article>
                `;
            }
        }

        resultsContainer.innerHTML = html;
    };

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const panel = document.getElementById('support-assistant-panel');
            if (panel && panel.style.display !== 'none') {
                window.toggleSupportAssistant(false);
            }
        }
    });
})();
</script>
