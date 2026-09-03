<!DOCTYPE html>
<html lang="de">
<!-- Mirrored from besseler-kursportal.dennis-bes.chatgpt.site/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 28 Jul 2026 23:25:39 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8"/><!-- /Added by HTTrack -->
<head>
    <meta charSet="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/index-ChrHLfZ9.css" data-rsc-css-href="/assets/index-ChrHLfZ9.css"
          data-precedence="vite-rsc/importer-resources"/>
    <title>Dennis Besseler Kursportal</title>
    <meta name="description"
          content="Elf digitale Kurse mit eigener Landingpage und persönlichem, geschütztem Kurszugang."/>
    <link rel="shortcut icon" href="{{ asset('frontend') }}/favicon.svg"/>
    <link rel="icon" href="{{ asset('frontend') }}/favicon.svg"/>
    <link rel="preload" href="{{ asset('frontend') }}/workspace/sites/besseler-kursportal/.vinext/fonts/geist-8ac0455e797f/geist-ff2310f5.woff2"
          as="font" type="font/woff2" crossorigin/>
    <link rel="preload" href="{{ asset('frontend') }}/workspace/sites/besseler-kursportal/.vinext/fonts/geist-8ac0455e797f/geist-875ccdd4.woff2"
          as="font" type="font/woff2" crossorigin/>
    <link rel="preload" href="{{ asset('frontend') }}/workspace/sites/besseler-kursportal/.vinext/fonts/geist-8ac0455e797f/geist-52306abf.woff2"
          as="font" type="font/woff2" crossorigin/>
    <link rel="preload" href="{{ asset('frontend') }}/workspace/sites/besseler-kursportal/.vinext/fonts/geist-8ac0455e797f/geist-001175b1.woff2"
          as="font" type="font/woff2" crossorigin/>
    <link rel="preload" href="{{ asset('frontend') }}/workspace/sites/besseler-kursportal/.vinext/fonts/geist-8ac0455e797f/geist-98bbbccb.woff2"
          as="font" type="font/woff2" crossorigin/>
    <link rel="preload"
          href="{{ asset('frontend') }}/workspace/sites/besseler-kursportal/.vinext/fonts/geist-mono-00e989178794/geist-mono-f6b33328.woff2"
          as="font" type="font/woff2" crossorigin/>
    <link rel="preload"
          href="{{ asset('frontend') }}/workspace/sites/besseler-kursportal/.vinext/fonts/geist-mono-00e989178794/geist-mono-44e03052.woff2"
          as="font" type="font/woff2" crossorigin/>
    <link rel="preload"
          href="{{ asset('frontend') }}/workspace/sites/besseler-kursportal/.vinext/fonts/geist-mono-00e989178794/geist-mono-0638449e.woff2"
          as="font" type="font/woff2" crossorigin/>
    <link rel="preload"
          href="{{ asset('frontend') }}/workspace/sites/besseler-kursportal/.vinext/fonts/geist-mono-00e989178794/geist-mono-971fb274.woff2"
          as="font" type="font/woff2" crossorigin/>
    <link rel="preload"
          href="{{ asset('frontend') }}/workspace/sites/besseler-kursportal/.vinext/fonts/geist-mono-00e989178794/geist-mono-44745446.woff2"
          as="font" type="font/woff2" crossorigin/>
    <link rel="preload"
          href="{{ asset('frontend') }}/workspace/sites/besseler-kursportal/.vinext/fonts/geist-mono-00e989178794/geist-mono-013b2f2f.woff2"
          as="font" type="font/woff2" crossorigin/>
    <style data-vinext-fonts>/* cyrillic-ext */
        @font-face {
            font-family: 'Geist';
            font-style: normal;
            font-weight: 100 900;
            font-display: swap;
            src: url("{{ asset('frontend/workspace/sites/besseler-kursportal/.vinext/fonts/geist-8ac0455e797f/geist-ff2310f5.woff2') }}") format('woff2');
            unicode-range: U+0460-052F, U+1C80-1C8A, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
        }

        /* cyrillic */
        @font-face {
            font-family: 'Geist';
            font-style: normal;
            font-weight: 100 900;
            font-display: swap;
            src: url("{{ asset('frontend/workspace/sites/besseler-kursportal/.vinext/fonts/geist-8ac0455e797f/geist-875ccdd4.woff2') }}") format('woff2');
            unicode-range: U+0301, U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }

        /* vietnamese */
        @font-face {
            font-family: 'Geist';
            font-style: normal;
            font-weight: 100 900;
            font-display: swap;
            src: url("{{ asset('workspace/sites/besseler-kursportal/.vinext/fonts/geist-8ac0455e797f/geist-52306abf.woff2') }}") format('woff2');
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
        }

        /* latin-ext */
        @font-face {
            font-family: 'Geist';
            font-style: normal;
            font-weight: 100 900;
            font-display: swap;
            src: url("{{ asset('workspace/sites/besseler-kursportal/.vinext/fonts/geist-8ac0455e797f/geist-001175b1.woff2') }}") format('woff2');
            unicode-range: U+0100-02BA, U+02BD-02C5, U+02C7-02CC, U+02CE-02D7, U+02DD-02FF, U+0304, U+0308, U+0329, U+1D00-1DBF, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        /* latin */
        @font-face {
            font-family: 'Geist';
            font-style: normal;
            font-weight: 100 900;
            font-display: swap;
            src: url(workspace/sites/besseler-kursportal/.vinext/fonts/geist-8ac0455e797f/geist-98bbbccb.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        .__font_geist_1vfytoh {
            font-family: 'Geist', sans-serif;
        }

        .__variable_geist_1vfytoh {
            --font-geist-sans: 'Geist', sans-serif;
        }

        /* cyrillic-ext */
        @font-face {
            font-family: 'Geist Mono';
            font-style: normal;
            font-weight: 100 900;
            font-display: swap;
            src: url(workspace/sites/besseler-kursportal/.vinext/fonts/geist-mono-00e989178794/geist-mono-f6b33328.woff2) format('woff2');
            unicode-range: U+0460-052F, U+1C80-1C8A, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
        }

        /* cyrillic */
        @font-face {
            font-family: 'Geist Mono';
            font-style: normal;
            font-weight: 100 900;
            font-display: swap;
            src: url(workspace/sites/besseler-kursportal/.vinext/fonts/geist-mono-00e989178794/geist-mono-44e03052.woff2) format('woff2');
            unicode-range: U+0301, U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }

        /* symbols2 */
        @font-face {
            font-family: 'Geist Mono';
            font-style: normal;
            font-weight: 100 900;
            font-display: swap;
            src: url(workspace/sites/besseler-kursportal/.vinext/fonts/geist-mono-00e989178794/geist-mono-0638449e.woff2) format('woff2');
            unicode-range: U+2000-2001, U+2004-2008, U+200A, U+23B8-23BD, U+2500-259F;
        }

        /* vietnamese */
        @font-face {
            font-family: 'Geist Mono';
            font-style: normal;
            font-weight: 100 900;
            font-display: swap;
            src: url(workspace/sites/besseler-kursportal/.vinext/fonts/geist-mono-00e989178794/geist-mono-971fb274.woff2) format('woff2');
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
        }

        /* latin-ext */
        @font-face {
            font-family: 'Geist Mono';
            font-style: normal;
            font-weight: 100 900;
            font-display: swap;
            src: url(workspace/sites/besseler-kursportal/.vinext/fonts/geist-mono-00e989178794/geist-mono-44745446.woff2) format('woff2');
            unicode-range: U+0100-02BA, U+02BD-02C5, U+02C7-02CC, U+02CE-02D7, U+02DD-02FF, U+0304, U+0308, U+0329, U+1D00-1DBF, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        /* latin */
        @font-face {
            font-family: 'Geist Mono';
            font-style: normal;
            font-weight: 100 900;
            font-display: swap;
            src: url(workspace/sites/besseler-kursportal/.vinext/fonts/geist-mono-00e989178794/geist-mono-013b2f2f.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        .__font_geist_mono_1gf5fol {
            font-family: 'Geist Mono', sans-serif;
        }

        .__variable_geist_mono_1gf5fol {
            --font-geist-mono: 'Geist Mono', sans-serif;
        }
    </style>
</head>
<body class="__variable_geist_1vfytoh __variable_geist_mono_1gf5fol antialiased">
@yield('contents')

{{-- Fully interactive Support Assistant (bottom right) --}}
@include('frontend.components.support-assistant')

{{-- Global Language & Translation Script --}}
<div id="google_translate_element" style="display:none;"></div>
<script type="text/javascript">
    function googleTranslateElementInit() {
        if (window.google && window.google.translate) {
            new google.translate.TranslateElement({
                pageLanguage: 'de',
                includedLanguages: 'de,en,fr,es,it',
                autoDisplay: false
            }, 'google_translate_element');
        }
    }

    function setGlobalPortalLanguage(lang) {
        localStorage.setItem('portal_lang', lang);
        const isEn = lang === 'en';

        // Update Button States
        document.querySelectorAll('#global-lang-btn-de, #lang-btn-de').forEach(btn => {
            btn.style.background = isEn ? 'transparent' : '#0284c7';
            btn.style.color = isEn ? '#94a3b8' : '#fff';
        });
        document.querySelectorAll('#global-lang-btn-en, #lang-btn-en').forEach(btn => {
            btn.style.background = isEn ? '#0284c7' : 'transparent';
            btn.style.color = isEn ? '#fff' : '#94a3b8';
        });

        // Trigger Google Translate cookie
        document.cookie = "googtrans=" + (isEn ? "/de/en" : "/de/de") + "; path=/; domain=" + window.location.hostname;
        document.cookie = "googtrans=" + (isEn ? "/de/en" : "/de/de") + "; path=/;";

        // Translate data-i18n attributes if available
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

        // If Google translate select is available in DOM, change it
        const select = document.querySelector('.goog-te-combo');
        if (select) {
            select.value = isEn ? 'en' : 'de';
            select.dispatchEvent(new Event('change'));
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const savedLang = localStorage.getItem('portal_lang') || 'de';
        if (savedLang === 'en') {
            setGlobalPortalLanguage('en');
        }
    });
</script>
<script type="text/javascript" defer src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
@include('frontend.components.time-tracker')
</body>
</html>
