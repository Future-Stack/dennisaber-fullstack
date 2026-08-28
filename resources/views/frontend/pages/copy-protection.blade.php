@extends('frontend.layouts.app')

@section('contents')
    <main class="copy-protection-page">
        {{-- Top Gold Notice Bar --}}
        <div class="portal-notice">
            <strong>TECHNISCHES KURSPORTAL</strong>
            <span>Keine Bestellung auf dieser Website. <a href="{{ route('home') }}">Kurse im Verkaufsportal ansehen →</a></span>
        </div>

        {{-- Header Navigation with Language Switcher --}}
        <header class="portal-header">
            <a href="{{ route('home') }}" class="portal-brand">
                <strong>DENNIS BESSELER</strong>
                <span>Kursportal</span>
            </a>
            <nav style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                <a href="{{ route('home') }}">Alle Kurse</a>
                <a href="{{ route('login') }}">Kundenlogin</a>
                <a href="{{ route('copy-protection') }}" aria-current="page">Kopierschutz</a>
                <a href="{{ route('payment') }}">Zahlung</a>
                <a href="{{ route('faster-processing') }}">Schnellere Bearbeitung</a>

                {{-- Language Switcher Pill --}}
                <div class="lang-switch-box" style="display: inline-flex; align-items: center; background: #1e293b; border: 1px solid #334155; border-radius: 20px; padding: 2px 6px; font-size: 0.78rem; font-weight: bold; margin-left: 0.5rem;">
                    <button type="button" onclick="setPortalLanguage('de')" id="lang-btn-de" style="background: #0284c7; color: #fff; border: none; border-radius: 12px; padding: 0.25rem 0.55rem; cursor: pointer; font-size: 0.75rem; font-weight: 700; transition: all 0.2s;">DE</button>
                    <button type="button" onclick="setPortalLanguage('en')" id="lang-btn-en" style="background: transparent; color: #94a3b8; border: none; border-radius: 12px; padding: 0.25rem 0.55rem; cursor: pointer; font-size: 0.75rem; font-weight: 700; transition: all 0.2s;">EN</button>
                </div>

                {{-- Google Translate Hidden Mount --}}
                <div id="google_translate_element" style="display: none;"></div>
            </nav>
        </header>

        {{-- Hero Section --}}
        <section class="copy-protection-hero">
            <div>
                <p class="eyebrow" style="color: #38bdf8;" data-i18n-de="TRANSPARENTE VORSCHAU" data-i18n-en="TRANSPARENT PREVIEW">TRANSPARENTE VORSCHAU</p>
                <h1 data-i18n-de="SO SIEHT IHR<br/>PERSÖNLICHER<br/>KOPIERSCHUTZ<br/>AUS." data-i18n-en="THIS IS WHAT<br/>YOUR<br/>PERSONAL<br/>COPY<br/>PROTECTION<br/>LOOKS LIKE.">
                    SO SIEHT IHR<br/>PERSÖNLICHER<br/>KOPIERSCHUTZ<br/>AUS.
                </h1>
            </div>
            <div>
                <p data-i18n-de="Im freigeschalteten Kurs werden Ihre Inhalte mit Ihrem Vornamen und Ihrer Kunden-/Rechnungsnummer als persönliche Privat-Lizenz gekennzeichnet. Diese Seite verwendet dasselbe Wasserzeichen wie der eigentliche Kursbereich." data-i18n-en="In the activated course, your content will be marked with your first name and customer/invoice number as a personal private license. This page uses the same watermark as the actual course area.">
                    Im freigeschalteten Kurs werden Ihre Inhalte mit Ihrem Vornamen und Ihrer Kunden-/Rechnungsnummer als persönliche Privat-Lizenz gekennzeichnet. Diese Seite verwendet dasselbe Wasserzeichen wie der eigentliche Kursbereich.
                </p>
                <div class="copy-protection-live-note" data-i18n-de="Ändert sich der Kopierschutz im Portal, ändert sich diese Vorschau automatisch." data-i18n-en="If the copy protection in the portal changes, this preview will change automatically.">
                    Ändert sich der Kopierschutz im Portal, ändert sich diese Vorschau automatisch.
                </div>
            </div>
        </section>

        {{-- 3-Column Feature Cards Section --}}
        <section class="copy-protection-explainer">
            <article>
                <span>01</span>
                <h2 data-i18n-de="Persönliche Kennzeichnung" data-i18n-en="Personal identification">Persönliche Kennzeichnung</h2>
                <p data-i18n-de="Vorname und Kunden-/Rechnungsnummer weisen die persönliche Privat-Lizenz aus. Adresse, E-Mail-Adresse und Zahlungsdaten werden nicht angezeigt." data-i18n-en="First name and customer/invoice number identify the personal private license. Address, email address, and payment details are not displayed.">
                    Vorname und Kunden-/Rechnungsnummer weisen die persönliche Privat-Lizenz aus. Adresse, E-Mail-Adresse und Zahlungsdaten werden nicht angezeigt.
                </p>
            </article>
            <article>
                <span>02</span>
                <h2 data-i18n-de="Auch auf Dokumenten" data-i18n-en="Also on documents">Auch auf Dokumenten</h2>
                <p data-i18n-de="Geschützte Arbeitsbuchseiten erhalten dieselbe persönliche Kennzeichnung — sichtbar, aber nicht dominant." data-i18n-en="Protected workbook pages receive the same personal marking — visible, but not dominant.">
                    Geschützte Arbeitsbuchseiten erhalten dieselbe persönliche Kennzeichnung — sichtbar, aber nicht dominant.
                </p>
            </article>
            <article>
                <span>03</span>
                <h2 data-i18n-de="Gerätebindung" data-i18n-en="Device binding">Gerätebindung</h2>
                <p data-i18n-de="Das erste erfolgreiche Login bindet den persönlichen Zugang an ein Browser-Profil." data-i18n-en="The first successful login links the personal access to a browser profile.">
                    Das erste erfolgreiche Login bindet den persönlichen Zugang an ein Browser-Profil.
                </p>
            </article>
        </section>

        {{-- Live Display with Test Data Section --}}
        <section class="copy-protection-demo-section" style="background: #f4f0e8;">
            <header>
                <p class="eyebrow" style="color: #0284c7;" data-i18n-de="AKTUELLER STAND IM PORTAL" data-i18n-en="CURRENT STATUS IN THE PORTAL">AKTUELLER STAND IM PORTAL</p>
                <h2 style="color: #0f172a;" data-i18n-de="Live-Darstellung mit Testdaten" data-i18n-en="Live display with test data">Live-Darstellung mit Testdaten</h2>
            </header>

            <div class="copy-protection-demo">
                <aside>
                    <p class="eyebrow" style="color: #38bdf8;" data-i18n-de="PERSÖNLICHER KURSBEREICH" data-i18n-en="PERSONAL COURSE AREA">PERSÖNLICHER KURSBEREICH</p>
                    <h3 data-i18n-de="Klar entscheiden" data-i18n-en="Decide clearly">Klar entscheiden</h3>
                </aside>

                <article style="position: relative;">
                    {{-- Watermark Layer --}}
                    <div class="media-license-watermark" style="color: rgba(56, 189, 248, 0.45); pointer-events: none; text-shadow: 0 1px #ffffffbf;">
                        <div class="license-line license-line-1" style="transform: rotate(-18deg); font-weight: 750; font-size: 0.82rem; letter-spacing: 0.08em;" data-i18n-de="PERSÖNLICHE PRIVAT-LIZENZ · ALEX · KUNDEN-/RECHNUNGS-NR. RN-7X4K-2026 · KEINE WEITERGABE" data-i18n-en="PERSONAL PRIVATE LICENSE · ALEX · CUSTOMER/INVOICE NO. RN-7X4K-2026 · NO DISTRIBUTION">
                            PERSÖNLICHE PRIVAT-LIZENZ · ALEX · KUNDEN-/RECHNUNGS-NR. RN-7X4K-2026 · KEINE WEITERGABE
                        </div>
                        <div class="license-line license-line-2" style="transform: rotate(-18deg); font-weight: 750; font-size: 0.82rem; letter-spacing: 0.08em;" data-i18n-de="PERSÖNLICHE PRIVAT-LIZENZ · ALEX · KUNDEN-/RECHNUNGS-NR. RN-7X4K-2026 · KEINE WEITERGABE" data-i18n-en="PERSONAL PRIVATE LICENSE · ALEX · CUSTOMER/INVOICE NO. RN-7X4K-2026 · NO DISTRIBUTION">
                            PERSÖNLICHE PRIVAT-LIZENZ · ALEX · KUNDEN-/RECHNUNGS-NR. RN-7X4K-2026 · KEINE WEITERGABE
                        </div>
                        <div class="license-line license-line-3" style="transform: rotate(-18deg); font-weight: 750; font-size: 0.82rem; letter-spacing: 0.08em;" data-i18n-de="PERSÖNLICHE PRIVAT-LIZENZ · ALEX · KUNDEN-/RECHNUNGS-NR. RN-7X4K-2026 · KEINE WEITERGABE" data-i18n-en="PERSONAL PRIVATE LICENSE · ALEX · CUSTOMER/INVOICE NO. RN-7X4K-2026 · NO DISTRIBUTION">
                            PERSÖNLICHE PRIVAT-LIZENZ · ALEX · KUNDEN-/RECHNUNGS-NR. RN-7X4K-2026 · KEINE WEITERGABE
                        </div>
                    </div>

                    <div class="copy-protection-demo-topline">
                        <span style="color: #64748b; font-size: 0.75rem; font-weight: 700;" data-i18n-de="AKTUELLE KURSEINHEIT" data-i18n-en="CURRENT COURSE UNIT">AKTUELLE KURSEINHEIT</span>
                        <span style="color: #64748b; font-size: 0.75rem; font-weight: 700;" data-i18n-de="GERÄT 1 VON 1 REGISTRIERT" data-i18n-en="DEVICE 1 OF 1 REGISTERED">GERÄT 1 VON 1 REGISTRIERT</span>
                    </div>

                    <p class="eyebrow" style="color: #0284c7; margin-bottom: 0.5rem;" data-i18n-de="BEISPIEL-INHALT" data-i18n-en="EXAMPLE CONTENT">BEISPIEL-INHALT</p>
                    <h3 style="color: #0f172a; margin-top: 0;" data-i18n-de="Erst wahrnehmen, dann einordnen." data-i18n-en="Observe before you categorize.">Erst wahrnehmen, dann einordnen.</h3>
                    <p style="color: #475569; font-size: 1.05rem; line-height: 1.7;" data-i18n-de="Die Inhalte bleiben gut lesbar. Die persönlichen Kennzeichnungen sind sichtbar, überlagern den Text jedoch nicht unnötig." data-i18n-en="The content remains easily readable. The personal markings are visible, but they do not unnecessarily overshadow the text.">
                        Die Inhalte bleiben gut lesbar. Die persönlichen Kennzeichnungen sind sichtbar, überlagern den Text jedoch nicht unnötig.
                    </p>
                </article>
            </div>
        </section>

        {{-- Blue CTA Banner --}}
        <section class="copy-protection-next" style="background: #1d64c2;">
            <div>
                <p class="eyebrow" style="color: rgba(255,255,255,0.85); font-weight: 700; letter-spacing: 0.08em;" data-i18n-de="BEREITS FREIGESCHALTET?" data-i18n-en="ALREADY UNLOCKED?">BEREITS FREIGESCHALTET?</p>
                <h2 style="color: #ffffff;" data-i18n-de="Persönlichen Kurs öffnen." data-i18n-en="Open your personal course.">Persönlichen Kurs öffnen.</h2>
            </div>
            <a href="{{ route('login') }}" style="background: transparent; color: #ffffff; border: 1px solid #ffffff; padding: 1rem 1.5rem; text-decoration: none; font-weight: 800; font-size: 0.8rem; letter-spacing: 0.05em; display: inline-flex; align-items: center; gap: 0.5rem; transition: background 0.2s;" data-i18n-de="ZUM AKTUELLEN KUNDENLOGIN →" data-i18n-en="GO TO CURRENT CUSTOMER LOGIN →">
                ZUM AKTUELLEN KUNDENLOGIN →
            </a>
        </section>

        {{-- Footer --}}
        <footer class="site-footer">
            <div>
                <strong>DENNIS BESSELER</strong>
                <p data-i18n-de="Persönliche Kurszugänge · einmalige Zahlung · kein Abonnement" data-i18n-en="Personal course access · one-time payment · no subscription">Persönliche Kurszugänge · einmalige Zahlung · kein Abonnement</p>
            </div>
            <nav aria-label="Rechtliche Hinweise">
                <a href="{{ route('login') }}" data-i18n-de="Kundenlogin" data-i18n-en="Customer login">Kundenlogin</a>
                <a href="{{ route('copy-protection') }}" data-i18n-de="Kopierschutz" data-i18n-en="copy protection">Kopierschutz</a>
                <a href="{{ route('payment') }}" data-i18n-de="Zahlung" data-i18n-en="payment">Zahlung</a>
                <a href="{{ route('faster-processing') }}" data-i18n-de="Schnellere Bearbeitung" data-i18n-en="Faster processing">Schnellere Bearbeitung</a>
                <a href="{{ route('imprint') }}" data-i18n-de="Impressum" data-i18n-en="Imprint">Impressum</a>
                <a href="{{ route('privacy-policy') }}" data-i18n-de="Datenschutz" data-i18n-en="Data protection">Datenschutz</a>
                <a href="{{ route('payment-participation') }}" data-i18n-de="Zahlungsbedingungen" data-i18n-en="Payment terms">Zahlungsbedingungen</a>
            </nav>
        </footer>
    </main>

    <script>
        function setPortalLanguage(lang) {
            localStorage.setItem('portal_lang', lang);
            const isEn = lang === 'en';

            const deBtn = document.getElementById('lang-btn-de');
            const enBtn = document.getElementById('lang-btn-en');
            if (deBtn && enBtn) {
                if (isEn) {
                    enBtn.style.background = '#0284c7';
                    enBtn.style.color = '#fff';
                    deBtn.style.background = 'transparent';
                    deBtn.style.color = '#94a3b8';
                } else {
                    deBtn.style.background = '#0284c7';
                    deBtn.style.color = '#fff';
                    enBtn.style.background = 'transparent';
                    enBtn.style.color = '#94a3b8';
                }
            }

            document.querySelectorAll('[data-i18n-de]').forEach(el => {
                const text = isEn ? el.getAttribute('data-i18n-en') : el.getAttribute('data-i18n-de');
                if (text) {
                    if (text.includes('<br/>') || text.includes('<strong>') || text.includes('<span>')) {
                        el.innerHTML = text;
                    } else {
                        el.innerText = text;
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            const savedLang = localStorage.getItem('portal_lang') || 'de';
            setPortalLanguage(savedLang);
        });
    </script>
@endsection
