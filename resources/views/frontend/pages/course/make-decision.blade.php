@extends('frontend.layouts.app')

@section('contents')
    <main class="course-landing cat-prevention">
<div class="portal-notice"><strong>Technisches Kursportal</strong><span>Keine Bestellung auf dieser Website. <a href="../../besseler-kursvorschau.dennis-bes.chatgpt.site/angebote/index.html">Kurse im Verkaufsportal ansehen →</a></span></div><header class="portal-header course-header"><a href="{{ route('home') }}" class="portal-brand"><strong>DENNIS BESSELER</strong><span>Kursportal</span></a><nav><a href="{{ route('home') }}">Alle Kurse</a><a href="{{ route('copy-protection') }}">Kopierschutz</a><a href="{{ route('payment') }}">Zahlung</a><a href="{{ route('faster-processing') }}">Schnellere Bearbeitung</a><a href="#anmelden">Anmelden</a></nav></header><section class="course-hero"><div class="course-hero-copy"><p class="eyebrow">Psychologie · digitaler 1-Tages-Entscheidungskurs</p><h1>Klar entscheiden, wenn andere mitentscheiden.</h1><p class="course-lead">Du führst eine reale Entscheidung von der Benennung über Einfluss, Fakten und eigene Kriterien bis zur sichtbaren Handlung und zu deinem persönlichen Entscheidungssystem.</p><div class="course-price"><strong>199 €</strong><span>einmalig · kein Abo</span></div><div class="access-badge"><b>Persönlicher Kurszugang</b><span>Drei Monate ab Freischaltung</span><small>Kein Abonnement · keine automatische Verlängerung</small></div><a class="order-cta" href="../../besseler-kursvorschau.dennis-bes.chatgpt.site/angebote/index.html">Kurs im Verkaufsportal ansehen <span>→</span></a></div><aside class="course-login" id="anmelden"><p class="login-label">Bereits freigeschaltet?</p><h2>Persönlichen Kurs öffnen</h2><form method="POST" action="{{ route('login.store') }}" autocomplete="off">
                @csrf
                <label>
                    <span>Benutzername oder E-Mail</span>
                    <input type="text" name="login" required autocomplete="username" placeholder="z. B. testkunde"/>
                </label>
                <label>
                    <span>Passwort</span>
                    <input type="password" name="password" required autocomplete="current-password" placeholder="Ihr Passwort"/>
                </label>
                <input type="hidden" name="device_id" class="course_device_id">
                <input type="hidden" name="device_name" class="course_device_name">
                <button type="submit">Anmelden und Kurs öffnen <span>→</span></button>
            </form><a href="{{ route('forgot-password') }}" class="password-forgotten-link">Benutzername oder Passwort vergessen?</a><p class="login-help">Sicherheitshinweis: Der persönliche Zugang wird beim ersten erfolgreichen Login einem Gerät zugeordnet. Bei einem Gerätewechsel wenden Sie sich bitte an den persönlichen Support.</p><div class="course-preview-links"><a href="{{ route('copy-protection') }}" class="course-preview-link">Aktuellen Kopierschutz ansehen</a></div></aside></section><section class="course-details"><div class="course-intro"><p class="eyebrow">Der vollständige Leistungsrahmen</p><h2>Was dieser Kurs konkret leistet.</h2><blockquote>Keine Therapie, Diagnose oder medizinische, rechtliche, steuerliche oder finanzielle Beratung.</blockquote></div><dl class="facts-grid"><div><dt>Umfang</dt><dd>Acht klare Audioführungen</dd></div><div><dt>Arbeitsmaterial</dt><dd>Ausfüllbares digitales Arbeitsbuch</dd></div><div><dt>Zeitrahmen</dt><dd>Ein vollständiger Arbeitstag</dd></div><div><dt>Ergebnis</dt><dd>Konkrete Handlung und Prüftermin</dd></div></dl></section><section class="course-content"><div><p class="eyebrow">Inhalte und Ergebnis</p><h2>Konkreter Kurs. Klare Arbeit.</h2><ul><li>Die Entscheidung benennen</li><li>Einfluss sichtbar machen</li><li>Fakten, Deutungen, Prognosen und Interessen trennen</li><li>Eigene Kriterien zurückgewinnen</li></ul></div><div class="module-list"><article><span>A01–A02</span><h3>Entscheidung und Einfluss</h3></article><article><span>A03–A04</span><h3>Fakten und eigene Kriterien</h3></article><article><span>A05–A06</span><h3>Wahrnehmen und ausreichend sicher entscheiden</h3></article><article><span>A07–A08</span><h3>Handeln und persönliches System sichern</h3></article></div></section><section class="course-final-login"><div><p class="eyebrow">Persönlicher Zugang</p><h2>Dieser Kurs beginnt mit deinem Login.</h2><p>Benutzername und Passwort werden nach Freischaltung für genau diesen Kurs vergeben.</p></div><a href="#anmelden">Zur Anmeldung ↑</a></section><section class="payment-process payment-process-compact" id="bezahlung"><header><p class="eyebrow">Klare Trennung</p><h2>Information und Buchung auf besseler.de. Kursnutzung hier.</h2><p>Diese Website ist ausschließlich die technische Kursplattform für bereits freigeschaltete Kunden. Sie dient weder der Werbung noch der Beratung oder Bestellung.</p></header><div class="payment-steps"><article><span>01</span><h3>Auf besseler.de informieren</h3><p>Alle Informationen, Beratung und die verbindliche Buchung finden ausschließlich auf besseler.de statt.</p></article><article><span>02</span><h3>Persönlichen Zugang erhalten</h3><p>Nach der Buchung und dem eindeutig zugeordneten Zahlungseingang wird das Kundenkonto freigeschaltet.</p></article><article><span>03</span><h3>Überweisung ausführen</h3><p>Rechnung, GiroCode, Bankdaten und eindeutigen Verwendungszweck verwenden.</p></article><article><span>04</span><h3>Kurs hier nutzen</h3><p>Bereits freigeschaltete Kunden melden sich an und bearbeiten ihre gebuchten Kursinhalte.</p></article></div></section><footer class="site-footer"><div><strong>DENNIS BESSELER</strong><p>Persönliche Kurszugänge · einmalige Zahlung · kein Abonnement</p></div><nav aria-label="Rechtliche Hinweise"><a href="{{ route('login') }}">Kundenlogin</a><a href="{{ route('copy-protection') }}">Kopierschutz</a><a href="{{ route('payment') }}">Zahlung</a><a href="{{ route('faster-processing') }}">Schnellere Bearbeitung</a><a href="{{ route('imprint') }}">Impressum</a><a href="{{ route('privacy-policy') }}">Datenschutz</a><a href="{{ route('payment-participation') }}">Zahlungsbedingungen</a></nav></footer>
    </main>

    <script>
        (() => {
            const deviceName = navigator.platform + " | " + navigator.userAgent;
            const raw = navigator.userAgent + navigator.platform + screen.width + screen.height + Intl.DateTimeFormat().resolvedOptions().timeZone;

            async function sha256(text) {
                const buffer = await crypto.subtle.digest("SHA-256", new TextEncoder().encode(text));
                return [...new Uint8Array(buffer)].map(b => b.toString(16).padStart(2, "0")).join("");
            }

            sha256(raw).then(hash => {
                document.querySelectorAll('.course_device_id').forEach(el => el.value = hash);
                document.querySelectorAll('.course_device_name').forEach(el => el.value = deviceName);
            });
        })();
    </script>
@endsection
