<?php

$mapping = [
    'dnl-kompakt.html' => 'compact.blade.php',
    'dnl-vertiefung.html' => 'advanced.blade.php',
    'dnl-premium.html' => 'premium.blade.php',
    'stress-und-ressourcen.html' => 'stress-resources.blade.php',
    'rauchfrei.html' => 'smoke‑free.blade.php',
    'ernaehrung.html' => 'nutrition.blade.php',
    'klar-entscheiden.html' => 'make-decision.blade.php',
    'erfolgreich-gruenden.html' => 'successful‑startup.blade.php',
    'presse-oeffentlichkeit.html' => 'press-public.blade.php',
    'rhetorik-unter-druck.html' => 'rhetoric-under-pressure.blade.php',
    'rio-negro-2002.html' => 'rio-negro.blade.php',
];

$sourceDir = __DIR__ . '/../public/frontend/kurse';
$targetDir = __DIR__ . '/../resources/views/frontend/pages/course';

foreach ($mapping as $srcFile => $targetFile) {
    $srcPath = $sourceDir . '/' . $srcFile;
    if (!file_exists($srcPath)) {
        echo "Source file not found: $srcPath\n";
        continue;
    }

    $html = file_get_contents($srcPath);

    // Extract <main ...> ... </main>
    if (preg_match('/<main\b[^>]*>(.*?)<\/main>/s', $html, $matches)) {
        $mainClassMatch = [];
        preg_match('/<main\s+class="([^"]+)"/s', $html, $mainClassMatch);
        $mainClass = $mainClassMatch[1] ?? 'course-landing';

        $innerContent = $matches[1];

        // Replace relative paths
        $innerContent = str_replace('../dnl-master.svg', '/frontend/dnl-master.svg', $innerContent);
        $innerContent = str_replace('/dnl-master.svg', '/frontend/dnl-master.svg', $innerContent);
        $innerContent = str_replace('../index.html', "{{ route('home') }}", $innerContent);
        $innerContent = str_replace('../kopierschutz.html', "{{ route('copy-protection') }}", $innerContent);
        $innerContent = str_replace('../zahlung.html', "{{ route('payment') }}", $innerContent);
        $innerContent = str_replace('../service/rio-negro.html', "{{ route('faster-processing') }}", $innerContent);
        $innerContent = str_replace('../impressum.html', "{{ route('imprint') }}", $innerContent);
        $innerContent = str_replace('../datenschutz.html', "{{ route('privacy-policy') }}", $innerContent);
        $innerContent = str_replace('../zahlungsbedingungen.html', "{{ route('payment-participation') }}", $innerContent);
        $innerContent = str_replace('../login.html', "{{ route('login') }}", $innerContent);
        $innerContent = str_replace('../passwort-vergessen.html', "{{ route('forgot-password') }}", $innerContent);

        // Replace form inside course-login with Laravel dynamic login form
        $loginFormRegex = '/<form>(.*?)<\/form>/s';
        $laravelForm = '<form method="POST" action="{{ route(\'login.store\') }}" autocomplete="off">
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
            </form>';

        $innerContent = preg_replace($loginFormRegex, $laravelForm, $innerContent, 1);

        // Build Blade file
        $blade = "@extends('frontend.layouts.app')\n\n@section('contents')\n    <main class=\"{$mainClass}\">\n{$innerContent}\n    </main>\n\n    <script>\n        (() => {\n            const deviceName = navigator.platform + \" | \" + navigator.userAgent;\n            const raw = navigator.userAgent + navigator.platform + screen.width + screen.height + Intl.DateTimeFormat().resolvedOptions().timeZone;\n\n            async function sha256(text) {\n                const buffer = await crypto.subtle.digest(\"SHA-256\", new TextEncoder().encode(text));\n                return [...new Uint8Array(buffer)].map(b => b.toString(16).padStart(2, \"0\")).join(\"\");\n            }\n\n            sha256(raw).then(hash => {\n                document.querySelectorAll('.course_device_id').forEach(el => el.value = hash);\n                document.querySelectorAll('.course_device_name').forEach(el => el.value = deviceName);\n            });\n        })();\n    </script>\n@endsection\n";

        file_put_contents($targetDir . '/' . $targetFile, $blade);
        echo "Updated {$targetFile} from {$srcFile}\n";
    }
}
