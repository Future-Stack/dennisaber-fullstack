@extends('frontend.layouts.app')

@section('contents')
    <main class="payment-info-page">
        <div class="portal-notice"><strong>Technisches Kursportal</strong><span>Keine Bestellung auf dieser Website. <a
                    href="https://www.besseler.de">Kurse im Verkaufsportal ansehen →</a></span>
        </div>
       @include('frontend.components.header')
        <section class="payment-info-hero"><p class="eyebrow">Information · keine Bestellmöglichkeit</p>
            <h1>Zahlung und Freischaltung.</h1>
            <p>Hier sehen Sie, wie die spätere Zahlung per Überweisung abläuft. Eine Bestellung oder Zahlung kann auf dieser
                Website nicht ausgelöst werden. Für eine bestehende Rechnung steht eine lokale GiroCode-Hilfe bereit.</p><a
                href="https://www.besseler.de">Kurse im Verkaufsportal ansehen
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
                        href="https://www.besseler.de">Zum Verkaufsportal →</a><a
                        href="#banking-qr">Hinweise für bestehende Rechnungen →</a></div>
            </div>
        </section>
        <section class="payment-helper" id="banking-qr" aria-labelledby="payment-helper-title">
            <header>
                <p class="eyebrow">Hilfe für bestehende Rechnungen</p>
                <h2 id="payment-helper-title">GiroCode aus der Rechnung erstellen.</h2>
                <p>Falls Ihre Rechnung keinen lesbaren GiroCode enthält, können Sie die dort genannten Zahlungsdaten hier lokal in einen neuen Banking-QR-Code umwandeln. Es werden keine Bankdaten vorbelegt.</p>
            </header>
            <div class="payment-helper-layout">
                <form id="girocode-form" onsubmit="generateGiroCode(event)">
                    <div style="background: rgba(15, 23, 42, 0.6); border: 2px dashed #334155; border-radius: 8px; padding: 1rem; text-align: center; margin-bottom: 1.25rem; transition: border-color 0.2s;" id="invoice-dropzone">
                        <label for="invoice-file" style="cursor: pointer; display: block; margin: 0; font-size: 0.85rem; color: #94a3b8;">
                            <span style="font-size: 1.5rem; display: block; margin-bottom: 0.25rem;">📄</span>
                            <strong style="color: #38bdf8; display: block;">Rechnung auswählen oder hier ablegen</strong>
                            <span style="font-size: 0.75rem; color: #64748b;">(PDF oder Textdatei – Zahlungsdaten werden automatisch erkannt)</span>
                        </label>
                        <input type="file" id="invoice-file" accept=".pdf,.txt,.text" style="display: none;" onchange="handleInvoiceUpload(this.files)">
                        <div id="invoice-file-name" style="font-size: 0.78rem; color: #4ade80; font-weight: 600; margin-top: 0.5rem; display: none;"></div>
                    </div>

                    <label>Kontoinhaber laut Rechnung
                        <input type="text" id="giro-recipient" maxLength="70" autoComplete="off" required placeholder="z. B. Dennis Besseler" value="" oninput="hideError()"/>
                    </label>
                    <label>IBAN laut Rechnung
                        <input type="text" id="giro-iban" inputMode="text" maxLength="42" autoComplete="off" spellCheck="false" required placeholder="z. B. DE89 3704 0044 0532 0130 00" oninput="hideError()"/>
                    </label>
                    <label>BIC laut Rechnung (falls angegeben)
                        <input type="text" id="giro-bic" maxLength="11" autoComplete="off" spellCheck="false" placeholder="z. B. COBADEFFXXX" oninput="hideError()"/>
                    </label>
                    <label>Rechnungsbetrag in Euro
                        <input type="text" id="giro-amount" inputMode="decimal" placeholder="z. B. 149,00" maxLength="13" autoComplete="off" required oninput="hideError()"/>
                    </label>
                    <label>Verwendungszweck laut Rechnung
                        <input type="text" id="giro-purpose" maxLength="140" autoComplete="off" required placeholder="z. B. RN-7X4K-2026 Max Mustermann" oninput="hideError()"/>
                    </label>

                    <div id="giro-error" style="display: none; background: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #fca5a5; padding: 0.75rem; border-radius: 6px; font-size: 0.85rem; margin-bottom: 1rem;"></div>

                    <button class="generate-giro" type="submit">GiroCode lokal erstellen <span>→</span></button>
                    <button class="copy-payment" type="button" onclick="resetGiroForm()">Eingaben löschen</button>
                    <p class="payment-safety">Die Verarbeitung erfolgt ausschließlich in diesem Browser. Die Angaben werden nicht versendet oder gespeichert.</p>
                </form>

                <div class="giro-output" id="giro-output" aria-live="polite">
                    <div class="giro-empty" id="giro-empty">
                        <span>GIROCODE</span>
                        <p>Der QR-Code erscheint erst nach einer formalen Prüfung der eingegebenen Rechnungsdaten.</p>
                    </div>
                </div>
            </div>
            <div class="payment-helper-warning">
                <strong>Kein Zahlungsauftrag</strong>
                <span>Der QR-Code bereitet nur Zahlungsdaten für Ihre Banking-App vor. Er löst keine Überweisung aus, bestätigt keinen Zahlungseingang und führt nicht automatisch zur Freischaltung.</span>
            </div>
        </section>

        <section class="payment-service-link" aria-labelledby="payment-service-title">
            <div>
                <p class="eyebrow">Bereits bestellt oder überwiesen?</p>
                <h2 id="payment-service-title">Schnellere Bearbeitung.</h2>
                <p>Für einen bereits bestehenden Rio-Negro-Vorgang können Sie freiwillig Ihren Gutscheincode aus dem Buch übermitteln oder eine Zahlungsbestätigung für Ihre E-Mail vorbereiten.</p>
                <small>Dadurch entstehen keine Bestellung, keine Zahlungspflicht und keine automatische Freischaltung. Die Angaben werden manuell geprüft.</small>
            </div>
            <a href="{{ route('faster-processing') }}">Angaben zur schnelleren Bearbeitung öffnen <span>→</span></a>
        </section>

        <section class="transfer-preview">
            <div>
                <p class="eyebrow">Vorbereiteter Überweisungsablauf</p>
                <h2>Rechnung, Bankdaten und Verwendungszweck.</h2>
                <p>Nach der Bestellung auf besseler.de erhält der Kunde seine persönlichen Zahlungsunterlagen. Die vollständigen Bankdaten werden nicht öffentlich auf diesem Portal angezeigt. Die Überweisung wird anhand der Rechnung geprüft und vom Kunden selbst mit TAN bestätigt.</p>
                <div class="no-payment-box">
                    <strong>Keine Zahlung auf dieser Seite</strong>
                    <span>Die optionale GiroCode-Hilfe verarbeitet übertragene Rechnungsangaben nur lokal im Browser. Sie versendet nichts und löst keine Überweisung aus.</span>
                </div>
            </div>
            <div class="transfer-preview-card">
                <span>1</span>
                <p>Rechnung mit eindeutiger Bestell- oder Rechnungsnummer</p>
                <span>2</span>
                <p>GiroCode oder Bankdaten ausschließlich aus der persönlichen Rechnung verwenden</p>
                <span>3</span>
                <p>Verwendungszweck unverändert übernehmen</p>
                <span>4</span>
                <p>Zahlungsprüfung täglich zwischen 13 und 16 Uhr</p>
                <span>5</span>
                <p>Persönliche Freischaltung per E-Mail</p>
            </div>
        </section>
        @include('frontend.components.footer')
    </main>

    <script src="{{ asset('frontend/assets/qrcode.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/pdf.min.js') }}"></script>
    <script>
        if (typeof pdfjsLib !== 'undefined') {
            pdfjsLib.GlobalWorkerOptions.workerSrc = "{{ asset('frontend/assets/pdf.worker.min.js') }}";
        }

        function cleanIban(iban) {
            return (iban || '').replace(/\s+/g, '').toUpperCase();
        }

        function validateIban(iban) {
            const clean = cleanIban(iban);
            if (!/^[A-Z]{2}\d{2}[A-Z0-9]{11,30}$/.test(clean)) return false;
            const rearranged = clean.slice(4) + clean.slice(0, 4);
            let remainder = 0;
            for (let char of rearranged) {
                let code = /\d/.test(char) ? char : String(char.charCodeAt(0) - 55);
                for (let digit of code) {
                    remainder = (remainder * 10 + Number(digit)) % 97;
                }
            }
            return remainder === 1;
        }

        function formatAmount(amount) {
            let clean = (amount || '').trim().replace(/\s/g, '').replace(',', '.');
            if (!/^\d{1,9}(?:\.\d{1,2})?$/.test(clean)) return null;
            let num = Number(clean);
            return !Number.isFinite(num) || num <= 0 || num > 999999999.99 ? null : num.toFixed(2);
        }

        function showError(msg) {
            const errEl = document.getElementById('giro-error');
            if (errEl) {
                errEl.innerText = msg;
                errEl.style.display = 'block';
            }
        }

        function hideError() {
            const errEl = document.getElementById('giro-error');
            if (errEl) {
                errEl.style.display = 'none';
                errEl.innerText = '';
            }
        }

        function generateGiroCode(e) {
            if (e) e.preventDefault();
            hideError();

            const recipient = document.getElementById('giro-recipient').value.trim();
            const iban = document.getElementById('giro-iban').value.trim();
            const bic = document.getElementById('giro-bic').value.trim();
            const rawAmount = document.getElementById('giro-amount').value.trim();
            const purpose = document.getElementById('giro-purpose').value.trim();

            if (!recipient) {
                showError('Bitte den Kontoinhaber genau wie auf der Rechnung eintragen.');
                return;
            }

            if (!validateIban(iban)) {
                showError('Die IBAN ist formal nicht gültig. Bitte noch einmal mit der Rechnung vergleichen.');
                return;
            }

            const formattedAmount = formatAmount(rawAmount);
            if (!formattedAmount) {
                showError('Bitte einen gültigen Rechnungsbetrag größer als 0 eingeben.');
                return;
            }

            if (!purpose) {
                showError('Bitte den Verwendungszweck unverändert von der Rechnung übernehmen.');
                return;
            }

            const epcPayload = [
                'BCD',
                '002',
                '1',
                'SCT',
                cleanIban(bic),
                recipient.slice(0, 70),
                cleanIban(iban),
                'EUR' + formattedAmount,
                '',
                '',
                purpose.slice(0, 140),
                ''
            ].join('\n');

            const outputContainer = document.getElementById('giro-output');

            try {
                if (typeof qrcode !== 'undefined') {
                    if (qrcode.stringToBytesFuncs && qrcode.stringToBytesFuncs['UTF-8']) {
                        qrcode.stringToBytes = qrcode.stringToBytesFuncs['UTF-8'];
                    }

                    let qr = null;
                    // Try auto-detect (0) with M error correction
                    try {
                        const candidate = qrcode(0, 'M');
                        candidate.addData(epcPayload);
                        candidate.make();
                        qr = candidate;
                    } catch (e0) {
                        // If auto-detect fails, iteratively search suitable type number (1 to 40)
                        for (let t = 1; t <= 40; t++) {
                            try {
                                const candidate = qrcode(t, 'M');
                                candidate.addData(epcPayload);
                                candidate.make();
                                qr = candidate;
                                break;
                            } catch (et) {}
                        }
                    }

                    // Fallback to L error correction if still not fitting
                    if (!qr) {
                        for (let t = 1; t <= 40; t++) {
                            try {
                                const candidate = qrcode(t, 'L');
                                candidate.addData(epcPayload);
                                candidate.make();
                                qr = candidate;
                                break;
                            } catch (et) {}
                        }
                    }

                    if (!qr) {
                        throw new Error('QR Code Kapazität überschritten');
                    }

                    const svgTag = qr.createSvgTag({ scalable: true });
                    outputContainer.innerHTML = `
                        <div style="background: #ffffff; padding: 14px; border-radius: 8px; display: inline-block; max-width: 220px; width: 100%; box-shadow: 0 4px 12px rgba(0,0,0,0.4); margin: 0 auto;">
                            ${svgTag}
                        </div>
                        <p style="margin-top: 10px; font-size: 0.85rem; color: #4ade80; font-weight: 700;">
                            ✓ GiroCode erfolgreich erzeugt
                        </p>
                        <p style="font-size: 0.75rem; color: #94a3b8; margin-top: 2px;">
                            Mit der Banking-App scannen, um die Überweisungsdaten direkt zu übernehmen.
                        </p>
                    `;
                } else {
                    console.error('QRCode engine not loaded');
                    showError('QR-Code-Bibliothek wird geladen. Bitte kurz warten und erneut versuchen.');
                }
            } catch (err) {
                console.error('QR Code generation error:', err);
                showError('Der GiroCode konnte nicht erzeugt werden. Bitte die Rechnungsangaben prüfen.');
            }
        }

        async function handleInvoiceUpload(files) {
            if (!files || files.length === 0) return;
            const file = files[0];
            const nameEl = document.getElementById('invoice-file-name');
            if (nameEl) {
                nameEl.innerText = `Lade Rechnung: ${file.name}...`;
                nameEl.style.display = 'block';
            }

            try {
                if (file.type === 'application/pdf' || file.name.toLowerCase().endsWith('.pdf')) {
                    // Parse PDF using PDF.js
                    const arrayBuffer = await file.arrayBuffer();
                    const pdf = await pdfjsLib.getDocument({ data: arrayBuffer }).promise;
                    let fullText = '';
                    for (let i = 1; i <= pdf.numPages; i++) {
                        const page = await pdf.getPage(i);
                        const textContent = await page.getTextContent();
                        const pageText = textContent.items.map(item => item.str).join(' ');
                        fullText += pageText + '\n';
                    }
                    if (nameEl) nameEl.innerText = `Ausgewählt: ${file.name} (Erfolgreich ausgelesen)`;
                    parseInvoiceText(fullText);
                } else {
                    // Plain text fallback
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const text = e.target.result;
                        if (nameEl) nameEl.innerText = `Ausgewählt: ${file.name} (Erfolgreich ausgelesen)`;
                        parseInvoiceText(text);
                    };
                    reader.readAsText(file);
                }
            } catch (err) {
                console.error('Invoice parsing error:', err);
                showError('Die Rechnungsdatei konnte nicht automatisch ausgelesen werden. Bitte geben Sie die Daten manuell ein.');
            }
        }

        function parseInvoiceText(content) {
            hideError();
            if (!content || typeof content !== 'string') return;

            const cleanText = content.replace(/\r\n/g, '\n');

            // 1. IBAN: Match German or European IBAN with optional spaces
            let detectedIban = '';
            const ibanMatch = cleanText.match(/\b(DE\s*\d{2}(?:\s*\d{4}){4}\s*\d{2})\b/i)
                || cleanText.match(/\b([A-Z]{2}\s*\d{2}(?:[\s\-]?[A-Z0-9]){11,30})\b/i);
            
            if (ibanMatch) {
                const raw = cleanIban(ibanMatch[1]);
                if (raw.startsWith('DE') && raw.length >= 22) {
                    detectedIban = raw.slice(0, 22);
                } else if (validateIban(raw)) {
                    detectedIban = raw;
                }
            }

            if (!detectedIban) {
                const potentialIbans = cleanText.match(/DE[0-9\s]{20,28}/gi) || [];
                for (let p of potentialIbans) {
                    const c = cleanIban(p);
                    if (c.length === 22 && validateIban(c)) {
                        detectedIban = c;
                        break;
                    }
                }
            }

            if (detectedIban) {
                document.getElementById('giro-iban').value = detectedIban;
            }

            // 2. BIC: Require explicit BIC or SWIFT keyword
            const bicMatch = cleanText.match(/(?:BIC|SWIFT)\s*:?\s*([A-Z0-9]{8,11})\b/i);
            if (bicMatch) {
                document.getElementById('giro-bic').value = cleanIban(bicMatch[1]);
            }

            // 3. Amount: Prioritize Gesamtbetrag / Zahlbetrag / Rechnungsbetrag over partial netto amounts
            let detectedAmount = '';
            const totalMatch = cleanText.match(/(?:Gesamtbetrag|Zahlbetrag|Endbetrag|Rechnungsbetrag)\s*(?:\([^\)]*\))?\s*:?\s*(\d{1,6}[,\.]\d{2})/i);
            if (totalMatch) {
                detectedAmount = totalMatch[1].replace('.', ',');
            } else {
                const anyAmountMatch = cleanText.match(/(?:Summe|Betrag)\s*:?\s*(\d{1,6}[,\.]\d{2})/i)
                    || cleanText.match(/(\d{1,6}[,\.]\d{2})\s*(?:EUR|€)/i);
                if (anyAmountMatch) {
                    detectedAmount = anyAmountMatch[1].replace('.', ',');
                }
            }
            if (detectedAmount) {
                document.getElementById('giro-amount').value = detectedAmount;
            }

            // 4. Purpose / Invoice number (Look for explicit Verwendungszweck line first)
            const explicitPurposeMatch = cleanText.match(/(?:Verwendungszweck|Zweck)\s*:?\s*([^\n\r]+)/i);
            if (explicitPurposeMatch && explicitPurposeMatch[1]) {
                let pText = explicitPurposeMatch[1].trim();
                // Clean trailing words if any
                pText = pText.replace(/(?:Hinweis|IBAN|BIC|Betrag|Rechnungsdatum|Datum).*$/i, '').trim();
                if (pText.length > 2) {
                    document.getElementById('giro-purpose').value = pText;
                }
            } else {
                const invNumMatch = cleanText.match(/(?:Rechnungs-?Nr\.?|Rechnungsnummer)\s*:?\s*([A-Z0-9\-\_\/ ]{4,40})/i);
                if (invNumMatch && invNumMatch[1]) {
                    let invText = invNumMatch[1].trim().replace(/(?:Rechnungsdatum|Datum).*$/i, '').trim();
                    document.getElementById('giro-purpose').value = invText;
                }
            }

            // 5. Recipient
            const recipientMatch = cleanText.match(/(?:Kontoinhaber|Zahlungsempfänger|Empfänger)\s*:?\s*([^\n\r,;]+?)(?=(?:\s+(?:IBAN|BIC|Betrag|Rechnungsbetrag|Verwendungszweck|$))|\n|\r|$)/i);
            if (recipientMatch && recipientMatch[1].trim().length > 2) {
                document.getElementById('giro-recipient').value = recipientMatch[1].trim();
            } else {
                document.getElementById('giro-recipient').value = 'Dennis Besseler';
            }

            // Automatically generate GiroCode if all required fields are present
            const hasIban = document.getElementById('giro-iban').value;
            const hasAmount = document.getElementById('giro-amount').value;
            const hasPurpose = document.getElementById('giro-purpose').value;
            const hasRecipient = document.getElementById('giro-recipient').value;

            if (hasIban && hasAmount && hasPurpose && hasRecipient) {
                generateGiroCode();
            }
        }

        function clearGiroForm() {
            resetGiroForm();
        }

        function resetGiroForm() {
            document.getElementById('girocode-form').reset();

            hideError();
            const nameEl = document.getElementById('invoice-file-name');
            if (nameEl) {
                nameEl.style.display = 'none';
                nameEl.innerText = '';
            }
            const outputContainer = document.getElementById('giro-output');
            outputContainer.innerHTML = `
                <div class="giro-empty" id="giro-empty">
                    <span>GIROCODE</span>
                    <p>Der QR-Code erscheint erst nach einer formalen Prüfung der eingegebenen Rechnungsdaten.</p>
                </div>
            `;
        }

        // Drag & Drop Support
        document.addEventListener('DOMContentLoaded', () => {
            const dropzone = document.getElementById('invoice-dropzone');
            if (dropzone) {
                ['dragenter', 'dragover'].forEach(eventName => {
                    dropzone.addEventListener(eventName, (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        dropzone.style.borderColor = '#38bdf8';
                        dropzone.style.background = 'rgba(56, 189, 248, 0.1)';
                    }, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dropzone.addEventListener(eventName, (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        dropzone.style.borderColor = '#334155';
                        dropzone.style.background = 'rgba(15, 23, 42, 0.6)';
                    }, false);
                });

                dropzone.addEventListener('drop', (e) => {
                    const dt = e.dataTransfer;
                    const files = dt.files;
                    handleInvoiceUpload(files);
                }, false);
            }
        });
    </script>
@endsection
