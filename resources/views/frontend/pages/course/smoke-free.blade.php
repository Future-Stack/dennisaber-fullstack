@extends('frontend.layouts.app')

@section('contents')
    <main class="course-landing cat-prevention">
<div class="portal-notice"><strong>Technisches Kursportal</strong><span>Keine Bestellung auf dieser Website. <a href="https://www.besseler.de">Kurse im Verkaufsportal ansehen →</a></span></div><header class="portal-header course-header"><a href="{{ route('home') }}" class="portal-brand"><strong>DENNIS BESSELER</strong><span>Kursportal</span></a><nav><a href="{{ route('home') }}">Alle Kurse</a><a href="{{ route('copy-protection') }}">Kopierschutz</a><a href="{{ route('payment') }}">Zahlung</a><a href="{{ route('faster-processing') }}">Schnellere Bearbeitung</a><a href="#anmelden">Anmelden</a></nav></header><section class="course-hero"><div class="course-hero-copy"><p class="eyebrow">Gesund Voraus · digitales Selbstlernprogramm</p><h1>Rauchfrei</h1><p class="course-lead">Nicht nur aufhören. Verstehen, welche Situationen, Rituale und Abläufe das Rauchen bisher stabilisieren.</p><div class="course-price"><strong>199 €</strong><span>einmalig · kein Abo</span></div><div class="access-badge"><b>Persönlicher Kurszugang</b><span>Vier Monate ab Freischaltung</span><small>Kein Abonnement · keine automatische Verlängerung</small></div><a class="order-cta" href="https://www.besseler.de">Kurs im Verkaufsportal ansehen <span>→</span></a></div><aside class="course-login" id="anmelden"><p class="login-label">Bereits freigeschaltet?</p><h2>Persönlichen Kurs öffnen</h2><form method="POST" action="{{ route('login.store') }}" autocomplete="off">
                @csrf
                <label>
                    <span>Benutzername</span>
                    <input type="text" name="login" required autocomplete="username" placeholder="z. B. testkunde"/>
                </label>
                <label>
                    <span>Passwort</span>
                    <input type="password" name="password" required autocomplete="current-password" placeholder="Ihr Passwort"/>
                </label>
                <input type="hidden" name="device_id" class="course_device_id">
                <input type="hidden" name="device_name" class="course_device_name">
                <button type="submit">Anmelden und Kurs öffnen <span>→</span></button>
            </form><a href="{{ route('forgot-password') }}" class="password-forgotten-link">Benutzername oder Passwort vergessen?</a><p class="login-help">Sicherheitshinweis: Der persönliche Zugang wird beim ersten erfolgreichen Login einem Gerät zugeordnet. Bei einem Gerätewechsel wenden Sie sich bitte an den persönlichen Support.</p><div class="course-preview-links"><a href="{{ route('copy-protection') }}" class="course-preview-link">Aktuellen Kopierschutz ansehen</a></div></aside></section><section class="course-details"><div class="course-intro"><p class="eyebrow">Der vollständige Leistungsrahmen</p><h2>Was dieser Kurs konkret leistet.</h2><blockquote>Geführte Selbstarbeit ohne Heil- oder Erfolgsversprechen.</blockquote></div><dl class="facts-grid"><div><dt>Arbeitsweise</dt><dd>Audio-geführt</dd></div><div><dt>Arbeitsmaterial</dt><dd>Digitales Arbeitsbuch</dd></div><div><dt>Start</dt><dd>Sechs-Tage-Startphase</dd></div><div><dt>Verlängerung</dt><dd>Keine; automatische Deaktivierung</dd></div></dl></section><section class="course-content"><div><p class="eyebrow">Inhalte und Ergebnis</p><h2>Konkreter Kurs. Klare Arbeit.</h2><ul><li>Ausgangslage und Rauchstopptermin klären</li><li>Auslöser und Abhängigkeit realistisch einschätzen</li><li>Wenn-dann-Pläne für kritische Situationen entwickeln</li><li>Erste Tage und den Abend vor dem Rauchstopp vorbereiten</li></ul></div><div class="module-list"><article><span>A01</span><h3>Ankommen und Rauchstopptermin</h3></article><article><span>A02</span><h3>Deine Ausgangslage</h3></article><article><span>A03a</span><h3>Dein Vier-Tage-Protokoll</h3></article><article><span>A03b</span><h3>Deine Startphase abschließen</h3></article></div></section><section class="course-final-login"><div><p class="eyebrow">Persönlicher Zugang</p><h2>Dieser Kurs beginnt mit deinem Login.</h2><p>Benutzername und Passwort werden nach Freischaltung für genau diesen Kurs vergeben.</p></div><a href="#anmelden">Zur Anmeldung ↑</a></section><section class="payment-process payment-process-compact" id="bezahlung"><header><p class="eyebrow">Klare Trennung</p><h2>Information und Buchung auf besseler.de. Kursnutzung hier.</h2><p>Diese Website ist ausschließlich die technische Kursplattform für bereits freigeschaltete Kunden. Sie dient weder der Werbung noch der Beratung oder Bestellung.</p></header><div class="payment-steps"><article><span>01</span><h3>Auf besseler.de informieren</h3><p>Alle Informationen, Beratung und die verbindliche Buchung finden ausschließlich auf besseler.de statt.</p></article><article><span>02</span><h3>Persönlichen Zugang erhalten</h3><p>Nach der Buchung und dem eindeutig zugeordneten Zahlungseingang wird das Kundenkonto freigeschaltet.</p></article><article><span>03</span><h3>Überweisung ausführen</h3><p>Rechnung, GiroCode, Bankdaten und eindeutigen Verwendungszweck verwenden.</p></article><article><span>04</span><h3>Kurs hier nutzen</h3><p>Bereits freigeschaltete Kunden melden sich an und bearbeiten ihre gebuchten Kursinhalte.</p></article></div></section><footer class="site-footer"><div><strong>DENNIS BESSELER</strong><p>Persönliche Kurszugänge · einmalige Zahlung · kein Abonnement</p></div><nav aria-label="Rechtliche Hinweise"><a href="{{ route('login') }}">Kundenlogin</a><a href="{{ route('copy-protection') }}">Kopierschutz</a><a href="{{ route('payment') }}">Zahlung</a><a href="{{ route('faster-processing') }}">Schnellere Bearbeitung</a><a href="{{ route('imprint') }}">Impressum</a><a href="{{ route('privacy-policy') }}">Datenschutz</a><a href="{{ route('payment-participation') }}">Zahlungsbedingungen</a></nav></footer>
    </main>
    <script>
        (() => {
            function getBesselerDeviceId() {
                const key = 'besseler-device-id';
                let id = '';
                try {
                    id = window.localStorage.getItem(key);
                    if (id && /^[0-9a-f]{64}$/.test(id)) {
                        return id;
                    }
                    const bytes = new Uint8Array(32);
                    window.crypto.getRandomValues(bytes);
                    id = Array.from(bytes, b => b.toString(16).padStart(2, '0')).join('');
                    window.localStorage.setItem(key, id);
                    return id;
                } catch (e) {
                    const bytes = new Uint8Array(32);
                    window.crypto.getRandomValues(bytes);
                    return Array.from(bytes, b => b.toString(16).padStart(2, '0')).join('');
                }
            }

            function getBesselerDeviceName() {
                const platform = navigator.platform || 'Desktop';
                const ua = navigator.userAgent || '';
                let browser = 'Browser';
                if (ua.indexOf('Firefox') !== -1) browser = 'Firefox';
                else if (ua.indexOf('Edg') !== -1 || ua.indexOf('Edge') !== -1) browser = 'Edge';
                else if (ua.indexOf('Chrome') !== -1) browser = 'Chrome';
                else if (ua.indexOf('Safari') !== -1) browser = 'Safari';
                return platform + ' · ' + browser;
            }

            const deviceId = getBesselerDeviceId();
            const deviceName = getBesselerDeviceName();

            document.querySelectorAll('.course_device_id').forEach(el => el.value = deviceId);
            document.querySelectorAll('.course_device_name').forEach(el => el.value = deviceName);

            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', () => {
                    const currentId = getBesselerDeviceId();
                    document.querySelectorAll('.course_device_id').forEach(el => el.value = currentId);
                    document.querySelectorAll('.course_device_name').forEach(el => el.value = deviceName);
                });
            });
        })();
    </script>
@endsection
