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
                <p>Falls Ihre Rechnung keinen lesbaren GiroCode enthält, können Sie Ihre Rechnung hier hochladen oder die Zahlungsdaten manuell eingeben, um lokal einen neuen Banking-QR-Code zu erstellen. Es werden keine Bankdaten vorbelegt.</p></header>
            <div class="payment-helper-layout">
                <form id="girocode-form" onsubmit="generateGiroCode(event)">
                    {{-- Optional Invoice File Upload / Drag-and-Drop --}}
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
                        <input id="giro-recipient" maxLength="70" autoComplete="off" required="" placeholder="z. B. Dennis Besseler" value=""/>
                    </label>
                    <label>IBAN laut Rechnung
                        <input id="giro-iban" inputMode="text" maxLength="42" autoComplete="off" spellCheck="false" required="" placeholder="DE..." value=""/>
                    </label>
                    <label>BIC laut Rechnung (falls angegeben)
                        <input id="giro-bic" maxLength="11" autoComplete="off" spellCheck="false" placeholder="z. B. GENODEF1..." value=""/>
                    </label>
                    <label>Rechnungsbetrag in Euro
                        <input id="giro-amount" inputMode="decimal" placeholder="z. B. 99,00" maxLength="13" autoComplete="off" required="" value=""/>
                    </label>
                    <label>Verwendungszweck laut Rechnung
                        <input id="giro-purpose" maxLength="140" autoComplete="off" required="" placeholder="z. B. RE-2026-001 Max Mustermann" value=""/>
                    </label>
                    
                    <p id="giro-error" role="alert" class="payment-safety" style="color: #ef4444; font-weight: 600; display: none;"></p>

                    <button class="generate-giro" type="submit">GiroCode lokal erstellen <span>→</span></button>
                    <button class="copy-payment" type="button" onclick="resetGiroForm()">Eingaben löschen</button>
                    <p class="payment-safety">Die Verarbeitung erfolgt ausschließlich in diesem Browser. Die Angaben werden
                        nicht versendet oder gespeichert.</p>
                </form>
                <div class="giro-output" id="giro-output" aria-live="polite">
                    <div class="giro-empty" id="giro-empty">
                        <span>GIROCODE</span>
                        <p>Der QR-Code erscheint erst nach einer formalen Prüfung der eingegebenen Rechnungsdaten.</p>
                    </div>
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
            <a href="{{ route('faster-processing') }}">Angaben zur schnelleren Bearbeitung öffnen <span>→</span></a></section>
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

    {{-- Interactive Client-side EPC QR Code (GiroCode) Engine & PDF.js Parser --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        if (typeof pdfjsLib !== 'undefined') {
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
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

            if (bic && !/^[A-Z0-9]{8}(?:[A-Z0-9]{3})?$/.test(cleanIban(bic))) {
                showError('Die BIC muss aus 8 oder 11 Zeichen bestehen.');
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

            // EPC QR Code Standard Payload (GiroCode)
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
            outputContainer.innerHTML = `
                <div id="qrcode-canvas-wrapper" style="background:#fff; padding:12px; border-radius:8px; display:inline-block; margin-bottom:1.25rem; box-shadow:0 4px 20px rgba(0,0,0,0.08);"></div>
                <strong style="display:block; color:#0f172a; font-size:1.15rem; font-weight:800; margin-bottom:0.6rem; letter-spacing:-0.01em;">Vor dem Bezahlen alles vergleichen</strong>
                <p style="color:#334155; font-size:0.92rem; line-height:1.65; margin:0 0 1.25rem 0;">
                    Scannen Sie den Code mit Ihrer Banking-App und vergleichen Sie dort Kontoinhaber, IBAN, Betrag und Verwendungszweck erneut mit Ihrer Rechnung. Erst danach bestätigen Sie selbst mit TAN.
                </p>
                <div style="background:#0f172a; border:1px solid #1e293b; border-radius:8px; padding:0.9rem 1.15rem; text-align:left; font-size:0.85rem; color:#cbd5e1; font-family:monospace; line-height:1.7;">
                    <div><strong style="color:#38bdf8;">Empfänger:</strong> <span style="color:#f8fafc; font-weight:600;">${recipient}</span></div>
                    <div><strong style="color:#38bdf8;">IBAN:</strong> <span style="color:#f8fafc; font-weight:600;">${cleanIban(iban)}</span></div>
                    ${bic ? `<div><strong style="color:#38bdf8;">BIC:</strong> <span style="color:#f8fafc; font-weight:600;">${cleanIban(bic)}</span></div>` : ''}
                    <div><strong style="color:#38bdf8;">Betrag:</strong> <span style="color:#4ade80; font-weight:bold; font-size:0.95rem;">${formattedAmount} €</span></div>
                    <div><strong style="color:#38bdf8;">Zweck:</strong> <span style="color:#f8fafc; font-weight:600;">${purpose}</span></div>
                </div>
            `;

            try {
                const qrWrapper = document.getElementById('qrcode-canvas-wrapper');
                new QRCode(qrWrapper, {
                    text: epcPayload,
                    width: 220,
                    height: 220,
                    colorDark: '#0f172a',
                    colorLight: '#ffffff',
                    correctLevel: QRCode.CorrectLevel.M
                });
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

            // 3. Amount: Extract after Rechnungsbetrag, Gesamt, or with EUR/€
            const amountMatch = cleanText.match(/(?:Rechnungsbetrag|Gesamtbetrag|Gesamt|Summe|Betrag)\s*:?\s*(\d{1,6}[,\.]\d{2})/i)
                || cleanText.match(/(\d{1,6}[,\.]\d{2})\s*(?:EUR|€)/i);
            if (amountMatch) {
                document.getElementById('giro-amount').value = amountMatch[1].replace('.', ',');
            }

            // 4. Purpose / Invoice number (Stop before subsequent keywords like IBAN, BIC, etc.)
            const purposeMatch = cleanText.match(/(?:Verwendungszweck|Zweck)\s*:?\s*([^\n\r,;]+?)(?=(?:\s+(?:IBAN|BIC|Betrag|Rechnungsbetrag|Datum|$))|\n|\r|$)/i)
                || cleanText.match(/(?:Rechnungs-?Nr\.?|Rechnungsnummer)\s*:?\s*([A-Z0-9\-\_\/ ]{4,40})/i);
            
            if (purposeMatch && purposeMatch[1]) {
                document.getElementById('giro-purpose').value = purposeMatch[1].trim();
            }

            // 5. Recipient (Stop before subsequent keywords)
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
