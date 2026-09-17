<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>{{ $course->title }} · Dennis Besseler Kursportal</title>
    <meta name="description" content="Elf digitale Kurse mit eigener Landingpage und persönlichem, geschütztem Kurszugang."/>
    <link rel="shortcut icon" href="/favicon.svg"/>
    <link rel="icon" href="/favicon.svg"/>
    
    {{-- Exact Reference Stylesheets from Portal --}}
    <link rel="stylesheet" href="/assets/index-D96dYb_L.css"/>
    <link rel="stylesheet" href="/assets/index-BFVSiNtN.css"/>

    <style>
        /* Continuous Repeating Diagonal Watermark (1:1 Reference Portal) */
        .course-customer-watermark {
            pointer-events: none;
            z-index: 90;
            justify-content: center;
            align-items: center;
            display: flex;
            position: fixed;
            inset: 0;
            overflow: hidden;
        }
        .course-customer-watermark span {
            color: #ffffff3d;
            letter-spacing: .1em;
            text-align: center;
            text-shadow: 0 1px 3px #000000c2;
            text-transform: uppercase;
            white-space: nowrap;
            background: #08080817;
            width: 145vw;
            padding: .55rem 0;
            font-size: clamp(.68rem, 1.35vw, 1.05rem);
            font-weight: 850;
            transform: rotate(-27deg);
        }

        /* Story Instruction Callout (1:1 Reference) */
        .story-instruction {
            border-left: 4px solid var(--adventure, #c83828);
            gap: .35rem;
            margin: .5rem 0 2rem;
            padding: .25rem 0 .25rem 1rem;
            display: grid;
        }
        .story-instruction>span {
            color: var(--adventure, #c83828);
            letter-spacing: .12em;
            text-transform: uppercase;
            font-size: .67rem;
            font-weight: 900;
        }
        .story-instruction>strong {
            letter-spacing: .06em;
            text-transform: uppercase;
            font-size: .78rem;
        }
        .story-instruction>p {
            color: #cbc8bd;
            max-width: 720px;
            margin: 0;
            line-height: 1.55;
        }

        /* Adventure Image Flush Card Top (1:1 Reference) */
        .protected-adventure-image {
            background: #080b09;
            height: clamp(300px, 48vw, 560px);
            margin: calc(-1 * clamp(1.5rem, 5vw, 4rem)) calc(-1 * clamp(1.5rem, 5vw, 4rem)) 2.3rem;
            position: relative;
            overflow: hidden;
        }
        .protected-adventure-image img {
            object-fit: cover;
            width: 100%;
            height: 100%;
        }
        .protected-adventure-image-complete {
            aspect-ratio: 4/3;
            height: auto;
        }
        .protected-adventure-image-complete img {
            object-fit: contain;
        }
        .protected-adventure-image-ship img {
            object-position: left bottom;
            transform-origin: 0 100%;
            transform: scale(1.32);
        }
        .protected-adventure-image figcaption {
            background: linear-gradient(#0000, #050806eb);
            align-items: end;
            gap: .35rem;
            padding: 4rem 1.3rem 1.1rem;
            display: grid;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
        }
        .protected-adventure-image figcaption span {
            color: #fff;
            font-size: .82rem;
            font-weight: 750;
        }
        .protected-adventure-image figcaption b {
            color: #d6c35c;
            letter-spacing: .08em;
            text-transform: uppercase;
            font-size: .66rem;
            font-weight: 850;
        }

        /* 1:1 Reference Course License Card from index-D96dYb_L.css */
        .course-license-card {
            border: 1px solid #45443f;
            border-top: 3px solid #d4af37;
            background: #20201e;
            gap: .55rem;
            margin: 0 0 1.4rem;
            padding: 1rem;
            display: grid;
        }
        .course-license-card>span {
            color: #d4af37;
            letter-spacing: .11em;
            text-transform: uppercase;
            font-size: .57rem;
            font-weight: 900;
        }
        .course-license-card>strong {
            color: #fff;
            font-size: 1.05rem;
            font-weight: 650;
            line-height: 1.2;
        }
        .course-license-card>b {
            color: #aaa79f;
            letter-spacing: .06em;
            text-transform: uppercase;
            font-size: .63rem;
        }
        .course-license-card>p {
            color: #c4c1b8;
            margin: .2rem 0 0;
            font-size: .67rem;
            line-height: 1.5;
        }
        .course-license-card .course-license-reward {
            border-left: 3px solid var(--accent, #e53e3e);
            background: #151514;
            gap: .3rem;
            margin-inline: -.2rem;
            padding: .65rem .7rem;
            display: grid;
            font-size: 0.64rem;
            color: #c4c1b8;
            line-height: 1.45;
        }
        .course-license-card .course-license-reward strong {
            color: #fff;
            font-size: .7rem;
        }
        .course-license-card>small {
            color: #85827b;
            font-size: .56rem;
            line-height: 1.4;
        }
        .course-license-card>a {
            color: #e4e0d6;
            text-align: center;
            text-transform: uppercase;
            border: 1px solid #5a5851;
            padding: .65rem;
            font-size: .6rem;
            font-weight: 850;
            text-decoration: none;
            display: block;
        }
        .course-license-card>a:hover {
            border-color: #d4af37;
            color: #fff;
        }
        .global-support-btn:hover {
            background: #222 !important;
            border-color: #666 !important;
        }

        /* Print Layout */
        @media print {
            body {
                background: #fff !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .protected-nav, .course-step-controls, .no-print, header, .global-support-btn {
                display: none !important;
            }
            .protected-course {
                display: block !important;
                background: #fff !important;
                color: #000 !important;
            }
            .protected-content {
                padding: 0 !important;
                max-width: none !important;
            }
            .protected-module {
                border: none !important;
                box-shadow: none !important;
                padding: 1rem 0 !important;
                max-width: 100% !important;
            }
            .global-license-diagonal {
                display: block !important;
                position: fixed !important;
                top: 50% !important;
                left: 50% !important;
                transform: translate(-50%, -50%) rotate(-31deg) !important;
                width: 155vw !important;
                z-index: 9999 !important;
                pointer-events: none !important;
                color: rgba(0, 0, 0, 0.45) !important;
                border-top: 1px solid rgba(0, 0, 0, 0.25) !important;
                border-bottom: 1px solid rgba(0, 0, 0, 0.25) !important;
                background: rgba(0, 0, 0, 0.04) !important;
                padding: 0.35rem 0 !important;
                white-space: nowrap !important;
                font-size: 0.68rem !important;
                font-weight: 800 !important;
                letter-spacing: 0.1em !important;
                text-transform: uppercase !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .global-license-track {
                display: flex !important;
                justify-content: space-around !important;
                width: 100% !important;
            }
            .global-license-track span {
                display: inline-flex !important;
                gap: 2.5rem !important;
                padding-inline: 2.5rem !important;
            }
            .global-license-track b {
                font-weight: 900 !important;
                color: rgba(0, 0, 0, 0.65) !important;
            }
            .global-license-track i {
                font-weight: 650 !important;
                font-style: normal !important;
                color: rgba(0, 0, 0, 0.45) !important;
            }
        }
        
        .copy-success-badge {
            display: inline-block;
            background: #16a34a;
            color: #fff;
            padding: 0.2rem 0.6rem;
            font-size: 0.68rem;
            border-radius: 2px;
            margin-left: 0.5rem;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .copy-success-badge.show {
            opacity: 1;
        }

        .workbook-zoom-wrapper {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100%;
        }
    </style>
</head>
<body class="__variable_geist_0tvmz3h __variable_geist_mono_1diim1n antialiased">

<main class="protected-course {{ $categoryClass }}">

    {{-- 1:1 REFERENCE DIAGONAL REPEATING WATERMARK RIBBON --}}
    <div class="course-customer-watermark notranslate" translate="no" aria-hidden="true">
        <span>
            @php
                $wmText = 'Rech-Nr.: ' . $customerInvoice;
                $wmRepeated = implode('   *   ', array_fill(0, 40, $wmText));
            @endphp
            {{ $wmRepeated }}
        </span>
    </div>

    {{-- PRINT WATERMARK --}}
    <div class="global-license-diagonal notranslate" translate="no" aria-hidden="true" style="display: none;">
        <div class="global-license-track">
            @for ($i = 0; $i < 8; $i++)
                <span><b>{{ $isAdminPreview ? 'PRÜFANSICHT' : $customerName }}</b><i>RECHNUNGSNR. {{ $customerInvoice }}</i></span>
            @endfor
        </div>
    </div>

    {{-- FIXED BOTTOM-RIGHT SUPPORT BUTTON (Reference Portal 1:1) --}}
    <a href="mailto:web@besseler.de?subject={{ urlencode('Support: ' . $course->title) }}" class="global-support-btn no-print" style="position: fixed; bottom: 1.25rem; right: 1.25rem; background: #000000; color: #ffffff; padding: 0.65rem 1.25rem; font-size: 0.72rem; font-weight: 850; letter-spacing: 0.08em; text-transform: uppercase; text-decoration: none; border: 1px solid #333333; z-index: 99; box-shadow: 0 4px 14px rgba(0,0,0,0.4);">
        Support
    </a>

    {{-- LEFT SIDEBAR --}}
    <aside class="protected-nav protected-nav-focus">
        <p class="eyebrow">{{ $categoryLabel }}</p>
        <h1>{{ $course->title }}</h1>
        
        <div class="protected-license">
            <span>Persönlicher Kundenzugang</span>
            <b>{{ $unitsCountText ?? (count($units) . ' vollständige Einheiten') }}</b>
            <small>Freigeschaltet bis {{ $expiresAtText }}</small>
        </div>

        {{-- Dynamic Step Status --}}
        <div class="course-focus-status">
            <span id="sidebar-step-indicator">Schritt {{ $course->slug === 'rio-negro-2002' ? ($initialStep > 0 ? $initialStep : 1) : 1 }} von {{ $course->slug === 'rio-negro-2002' ? '14' : count($units) + 2 }}</span>
            <strong id="sidebar-step-title">
                @if($course->slug === 'rio-negro-2002')
                    {{ $units[0]['number'] ?? '00' }} · {{ $units[0]['title'] ?? 'Die Vermisstenmeldung' }}
                @else
                    Start &amp; Arbeitsbuch
                @endif
            </strong>
            <div>
                <i id="sidebar-progress-bar" style="width: {{ $course->slug === 'rio-negro-2002' ? ((($initialStep > 0 ? $initialStep : 1) / 14) * 100) : ((1 / (count($units) + 2)) * 100) }}%"></i>
            </div>
        </div>

        {{-- Protected Customer License Card (1:1 Reference Portal) --}}
        <section class="course-license-card" aria-labelledby="course-license-title">
            <span>Persönliche Kursansicht für</span>
            <strong id="course-license-title">Vorname: {{ $customerName }}</strong>
            <b>Rechnungsnummer: {{ $customerInvoice }}</b>
            <p>Diese Inhalte sind urheberrechtlich geschützt und ausschließlich für deine persönliche Nutzung freigegeben. Unberechtigte Weitergabe, Vervielfältigung oder Veröffentlichung kann zivil- und strafrechtliche Folgen haben und wird von mir konsequent geprüft.</p>
            <div class="course-license-reward">
                <strong>200 € Hinweisprämie</strong>
                Für den ersten konkreten und nachprüfbaren Hinweis auf eine mir zuvor unbekannte unberechtigte Nutzung, wenn dieser wesentlich zu einer rechtskräftigen strafrechtlichen Verurteilung oder rechtskräftigen zivilgerichtlichen Feststellung gegen den Rechtsverletzer führt.
            </div>
            <small>Danke, dass du meine Arbeit schützt. Bitte nur rechtmäßig erlangte Informationen übermitteln. Tatbeteiligte sind von der Prämie ausgeschlossen.</small>
            <a href="mailto:dennis@besseler.de?subject=Hinweis%20auf%20unberechtigte%20Kursnutzung">Rechtsverletzung an Dennis melden</a>
            <small>Für eine Strafanzeige oder einen polizeilichen Hinweis bitte ausschließlich das offizielle Portal der Polizeien der Bundesländer nutzen. Nicht für Notfälle – in dringenden Fällen 110 wählen.</small>
            <a href="https://portal.onlinewache.polizei.de/de/" target="_blank" rel="noreferrer">Offizielle Onlinewache der Polizei</a>
        </section>

        @if($isAdminPreview)
            <a href="{{ url('/verwaltung') }}" style="margin-top: 1rem; color: #aaa79f; font-size: 0.75rem; text-decoration: none;">
                ← Zurück zur Verwaltung
            </a>
        @else
            <a href="{{ route('member.dashboard') }}" style="margin-top: 1rem; color: #aaa79f; font-size: 0.75rem; text-decoration: none;">
                ← Zur Kursübersicht
            </a>
        @endif
    </aside>

    {{-- MAIN CONTENT STAGE --}}
    <section class="protected-content protected-content-focus">
        <header>
            <div>
                <span>Aktuelle Kursseite</span>
                <strong id="topbar-workbook-title">{{ $workbookTitle }}</strong>
            </div>
            <span>{{ $accessText }}</span>
        </header>

        <div class="course-focus-stage">
            
            {{-- STEP 0 / 13: START & ARBEITSBUCH / SO FUNKTIONIERT DAS ABENTEUER --}}
            <article class="protected-module course-game-start" id="step-panel-0" style="display: none;">
                @if($course->slug === 'rio-negro-2002')
                    <p class="eyebrow">So funktioniert das Abenteuer</p>
                    <h2>{{ $courseHeading }}</h2>
                    <p>Du gehst Etappe für Etappe vor. Du triffst Entscheidungen, bevor der tatsächliche Verlauf sichtbar wird. Deine Eingaben werden lokal auf diesem Gerät zwischengespeichert.</p>
                    <p class="structure-promise">
                        <strong>Verbindlich:</strong> Die zwölf Originaletappen, Audios, Reihenfolge und Auflösungen bleiben vollständig bestehen. Zusätzliche Spielaufgaben sind optional und klar gekennzeichnet.
                    </p>
                    <div class="game-start-grid">
                        <div><b>01</b><strong>Situation erleben</strong><span>Originalaudio und Expeditionsbilder führen in die Lage.</span></div>
                        <div><b>02</b><strong>Selbst entscheiden</strong><span>Auswählen, priorisieren, prüfen und begründen.</span></div>
                        <div><b>03</b><strong>Ergebnis sichern</strong><span>Am Ende entsteht Ihr persönlicher Ergebnisbogen als PDF.</span></div>
                    </div>
                @else
                    <p class="eyebrow">Audiolehrgang · digitales Arbeitsbuch</p>
                    <h2>{{ $courseHeading }}</h2>
                    <p>Du bearbeitest den Kurs exakt in der Reihenfolge des Arbeitsbuchs. Jede Einheit bleibt mit ihrem Audio und Arbeitsauftrag verbunden.</p>
                    <p class="structure-promise">
                        <strong>Verbindlich:</strong> Arbeitsbuchstruktur, Einheiten und Audio-Reihenfolge bleiben erhalten. Deine Antworten werden auf diesem Gerät gespeichert.
                    </p>
                    <div class="game-start-grid">
                        <div><b>01</b><strong>Originaleinheit hören</strong><span>Das Audio führt durch die zugehörige Seite des Arbeitsbuchs.</span></div>
                        <div><b>02</b><strong>Arbeitsauftrag bearbeiten</strong><span>Die Aufgabe wird digital ausgefüllt und lokal gespeichert.</span></div>
                        <div><b>03</b><strong>Ergebnis sichern</strong><span>Am Ende entsteht Ihr persönlicher Ergebnisbogen als PDF.</span></div>
                    </div>
                @endif

                {{-- Digital Workbook Viewer --}}
                <section class="workbook-document">
                    <header>
                        <div>
                            <p class="eyebrow">{{ $workbookEyebrow }}</p>
                            <h3>Arbeitsbuch lesen</h3>
                        </div>
                        <div class="workbook-page-controls">
                            <button type="button" id="wb-btn-prev" onclick="changeWbPage(-1)" aria-label="Vorherige Seite">←</button>
                            <strong id="wb-page-display">Seite 1 von {{ $workbookPages }}</strong>
                            <button type="button" id="wb-btn-next" onclick="changeWbPage(1)" aria-label="Nächste Seite">→</button>
                        </div>
                        <div class="workbook-view-controls">
                            <button type="button" onclick="changeWbZoom(-25)">−</button>
                            <strong id="wb-zoom-display">125 %</strong>
                            <button type="button" onclick="changeWbZoom(25)">+</button>
                            <button type="button" onclick="toggleWbFullscreen()">Vollbild</button>
                        </div>
                    </header>
                    <div class="protected-workbook-viewer" id="protected-workbook-viewer">
                        <div class="workbook-zoom-wrapper">
                            <figure class="protected-workbook-page" style="position: relative; overflow: hidden;">
                                <img id="workbook-page-img" 
                                     src="/workbooks/{{ $workbookSlug }}/page-01.jpg" 
                                     alt="{{ $workbookEyebrow }}, Seite 1" 
                                     draggable="false" 
                                     style="width: 125%; display: block;" 
                                     onerror="handleWorkbookImgError(this)" />
                                <div class="workbook-diagonal-watermark watermark-overlay-layer notranslate" translate="no" aria-hidden="true" style="position: absolute; inset: 0; pointer-events: none; display: flex; flex-direction: column; justify-content: space-around; align-items: center; transform: rotate(-25deg) scale(1.1); opacity: 0.15; font-weight: 850; font-size: 1.15rem; color: #000; text-transform: uppercase; white-space: nowrap; user-select: none;">
                                    <div>PERSÖNLICHE PRIVATLIZENZ · {{ $customerName }} · {{ $customerInvoice }}</div>
                                    <div>GESCHÜTZTES KURSMATERIAL · DENNIS BESSELER · KEINE WEITERGABE</div>
                                    <div>LIZENZ-NACHWEIS · {{ $customerName }} · {{ $customerInvoice }}</div>
                                    <div>GESCHÜTZTES KURSMATERIAL · DENNIS BESSELER · KEINE WEITERGABE</div>
                                </div>
                                <figcaption aria-hidden="true">
                                    <span>{{ $customerName }} · {{ $customerInvoice }}</span>
                                    <span>{{ $customerName }} · {{ $customerInvoice }}</span>
                                </figcaption>
                            </figure>
                        </div>
                    </div>
                </section>
            </article>

            {{-- LESSON UNITS CONTAINER (1:1 Reference Portal Element Order) --}}
            <article class="protected-module" id="step-panel-unit" style="display: none;">
                
                {{-- 1. Adventure Image (FLUSH AT THE VERY TOP OF CARD) --}}
                <figure class="protected-adventure-image" id="unit-image-wrapper" style="display: none;">
                    <img id="unit-image" src="" alt="Etappenbild" />
                    <figcaption>
                        <span id="unit-caption"></span>
                        <b>Persönliche Lizenz · keine Weitergabe</b>
                    </figcaption>
                </figure>

                {{-- 2. Eyebrow --}}
                <p class="eyebrow" id="unit-eyebrow"></p>

                {{-- 3. Story Instruction Callout (Rio Negro) --}}
                <div class="story-instruction" id="unit-story-instruction" style="display: none;">
                    <span id="story-instruction-tag"></span>
                    <strong>So arbeitest du in dieser Etappe</strong>
                    <p id="story-instruction-text"></p>
                </div>

                {{-- 4. Title & Summary --}}
                <h2 id="unit-title">{{ $units[0]['title'] ?? 'Die Vermisstenmeldung' }}</h2>
                <p id="unit-summary">{{ $units[0]['summary'] ?? 'Originaletappe aus dem vollständigen Audio-Abenteuer.' }}</p>

                {{-- 5. Media Container (Audio Player OR Practice Station) --}}
                <div class="protected-media" id="unit-audio-container">
                    <div>
                        <b>Original MP3</b>
                        <span id="unit-media-subtitle">Direkt in dieser Kurseinheit abspielbar</span>
                    </div>
                    <audio id="unit-audio-player" controls controlsList="nodownload" preload="metadata">
                        Ihr Browser unterstützt die Audiowiedergabe nicht.
                    </audio>
                </div>
                <div class="protected-media practice-station" id="unit-practice-container" style="display: none;">
                    <div>
                        <b>Geführte Praxisstation</b>
                        <span>Diese Einheit wird direkt im Arbeitsauftrag bearbeitet und benötigt kein Audio.</span>
                    </div>
                    <strong>Beobachten · festhalten · in den Alltag übertragen</strong>
                </div>

                {{-- 6. Press Evidence Document (Rio Negro Unit 09) --}}
                <section class="press-evidence" id="rio-press-evidence" style="display: none;">
                    <img src="/images/rio/pressespiegel-cover.jpg" alt="Cover des Pressespiegels einer Jugend von Dennis Besseler"/>
                    <div>
                        <span class="bonus-tag">Optionales Bonusmaterial</span>
                        <p class="eyebrow">Historisches Beweisstück · Pressespiegel</p>
                        <h3>Während Dennis unterwegs war, entstand in Deutschland eine andere Geschichte.</h3>
                        <p>Der Pressespiegel enthält 22 Seiten aus den Jahren 1991 bis 2002. Für diese Etappe sind die Berichte über die Vermisstensuche von 2002 relevant.</p>
                        <div class="press-headlines">
                            <span>„Kölner Abenteurer im Dschungel vermisst“</span>
                            <span>„Allein mit dem Floß durch den Urwald“</span>
                            <span>„Deutscher Abenteurer verschollen …“</span>
                        </div>
                        <small>Unabhängiger Zusatz zur abgeschlossenen Geschichte. Die Schlagzeilen sind historische Pressequellen und werden nicht automatisch als bestätigte Tatsachen übernommen.</small>
                    </div>
                    <div class="press-document">
                        <object data="/documents/pressespiegel-einer-jugend.pdf" type="application/pdf" aria-label="Pressespiegel einer Jugend als PDF">
                            <p>Die PDF-Vorschau wird von diesem Browser nicht unterstützt.</p>
                        </object>
                        <div>
                            <a href="/documents/pressespiegel-einer-jugend.pdf" target="_blank" rel="noopener">PDF vollständig öffnen</a>
                            <a href="/documents/pressespiegel-einer-jugend.pdf" download>PDF herunterladen</a>
                        </div>
                    </div>
                </section>

                {{-- 7. Main Task Field & Interactive Bonus Missions (Dynamically Rendered 1:1) --}}
                <div id="unit-interactive-exercises"></div>
            </article>

            {{-- STEP N+1 / 14: ANTWORTEN ALS PDF / ABSCHLUSS-PROTOKOLL --}}
            <article class="protected-module result-sheet" id="step-panel-finish" style="display: none;">
                <p class="eyebrow">Persönliche Kursunterlagen</p>
                <h2>Deine Antworten als PDF</h2>
                <p class="protocol-intro">
                    Alle bearbeiteten Aufgaben, Antworten, Auswahlentscheidungen und Spielergebnisse dieses Kurses sind hier zusammengeführt.
                </p>

                @if($course->slug === 'rio-negro-2002')
                    <section class="safety-result" id="rio-safety-result" style="display: none;">
                        <span id="rio-safety-score">0 / 5</span>
                        <div>
                            <h3>Abfahrtscheck</h3>
                            <p id="rio-safety-text">Die Vorbereitung wird ausgewertet.</p>
                            <small>Spielauswertung – keine reale Sicherheitsfreigabe.</small>
                        </div>
                    </section>
                @endif

                {{-- Compiled Answers List --}}
                <div class="result-list" id="compiled-answers-container">
                    {{-- Dynamically populated via JS --}}
                </div>

                <div class="result-actions no-print">
                    <button type="button" onclick="window.print()">
                        Gesamtes Protokoll drucken / als PDF speichern
                    </button>
                    <small>Der Druckdialog enthält sämtliche oben aufgeführten Fragen und Antworten. Dort „Als PDF speichern“ auswählen.</small>
                </div>

                {{-- Voluntary Course Feedback (1:1 Reference A) --}}
                <section class="course-feedback no-print" aria-labelledby="course-feedback-title">
                    <div class="course-feedback-content">
                        <p class="eyebrow">Freiwilliger Kursabschluss</p>
                        <h3 id="course-feedback-title">Wie war Ihre Erfahrung mit diesem Kurs?</h3>
                        <p>Ihre Rückmeldung hilft uns, Inhalte und Technik gezielt zu verbessern. Beim Absenden wird eine vorbereitete E-Mail geöffnet; Sie entscheiden selbst, ob Sie sie versenden.</p>
                        <div class="feedback-grid">
                            <label>
                                <span>Gesamteindruck</span>
                                <select id="feedback-rating">
                                    <option value="">Bitte auswählen</option>
                                    <option value="5">5 – ausgezeichnet</option>
                                    <option value="4">4 – sehr gut</option>
                                    <option value="3">3 – gut</option>
                                    <option value="2">2 – verbesserungsbedürftig</option>
                                    <option value="1">1 – nicht überzeugend</option>
                                </select>
                            </label>
                            <label>
                                <span>Technische Funktion</span>
                                <select id="feedback-technical">
                                    <option value="">Bitte auswählen</option>
                                    <option value="Alles hat funktioniert">Alles hat funktioniert</option>
                                    <option value="Ein kleiner Fehler ist aufgetreten">Ein kleiner Fehler ist aufgetreten</option>
                                    <option value="Eine Funktion war nicht nutzbar">Eine Funktion war nicht nutzbar</option>
                                    <option value="Der Kurs konnte nicht abgeschlossen werden">Der Kurs konnte nicht abgeschlossen werden</option>
                                </select>
                            </label>
                            <label class="wide">
                                <span>Was hat technisch nicht funktioniert?</span>
                                <textarea id="feedback-issue" rows="3" placeholder="Gerät, Browser, Kurseinheit und beobachteter Fehler helfen bei der Prüfung."></textarea>
                            </label>
                            <label class="wide">
                                <span>Was sollten wir außerdem verbessern?</span>
                                <textarea id="feedback-note" rows="3"></textarea>
                            </label>
                        </div>
                        <button type="button" onclick="sendFeedbackMail()">Rückmeldung als E-Mail vorbereiten</button>
                    </div>
                </section>
            </article>

            {{-- FIXED BOTTOM STEP CONTROLS --}}
            <nav class="course-step-controls no-print" aria-label="Kursnavigation">
                <button type="button" id="btn-nav-start" onclick="goToStep(courseSlug === 'rio-negro-2002' ? 1 : 0)">Start</button>
                <button type="button" id="btn-nav-prev" onclick="goToPrevStep()">← Zurück</button>
                
                <label>
                    <span>Direktsprung</span>
                    <select id="direct-step-select" onchange="goToStep(parseInt(this.value, 10))">
                        @if($course->slug === 'rio-negro-2002')
                            @foreach($units as $idx => $u)
                                <option value="{{ $idx + 1 }}">
                                    {{ $u['number'] ?? sprintf('%02d', $idx) }} · {{ $u['title'] ?? ('Einheit ' . ($idx + 1)) }}
                                </option>
                            @endforeach
                            <option value="13">So funktioniert das Abenteuer</option>
                            <option value="14">Antworten als PDF</option>
                        @else
                            <option value="0">Start &amp; Übersicht</option>
                            @foreach($units as $idx => $u)
                                <option value="{{ $idx + 1 }}">
                                    {{ $u['number'] ?? ($idx + 1) }} · {{ $u['title'] ?? ('Einheit ' . ($idx + 1)) }}
                                </option>
                            @endforeach
                            <option value="{{ count($units) + 1 }}">Antworten als PDF</option>
                        @endif
                    </select>
                </label>

                <button type="button" id="btn-nav-next" onclick="goToNextStep()">Weiter →</button>
                <button type="button" id="btn-nav-finish" onclick="goToStep(courseSlug === 'rio-negro-2002' ? 14 : totalSteps - 1)">Antworten als PDF</button>
            </nav>

        </div>
    </section>
</main>

{{-- JAVASCRIPT LOGIC (1:1 Complete CourseStepper-DJLI4yDN.js Implementation) --}}
<script>
    const courseSlug = @json($course->slug);
    const courseTitle = @json($course->title);
    const workbookSlug = @json($workbookSlug);
    const workbookTotalPages = {{ $workbookPages }};
    const unitsData = @json($units);
    const isRio = (courseSlug === 'rio-negro-2002');
    const totalSteps = isRio ? 14 : (unitsData.length + 2);

    // Initial step
    let currentStep = {{ $initialStep }};
    if (isRio) {
        if (currentStep < 1 || currentStep > 14) currentStep = 1;
    } else {
        if (currentStep < 0 || currentStep >= totalSteps) currentStep = 0;
    }

    // Story Instructions for Rio Negro 2002
    const storyInstructions = {
        "00": ["Alarm", "Erfasse die Ausgangslage. Noch ist nicht klar, was am Rio Negro geschehen ist."],
        "01": ["Auftrag", "Prüfe den Plan und achte darauf, welche Annahmen vor dem Aufbruch getroffen wurden."],
        "02": ["Vorbereitung", "Setze Prioritäten, triff deine erste Entscheidung und führe den Abfahrtscheck durch."],
        "03": ["Orientierung", "Lies die Karten, bestimme die Flussrichtung und kontrolliere das Floß vor dem Ablegen."],
        "04": ["Isolation", "Höre genau hin. Ab jetzt wächst die Entfernung zur nächsten sicheren Verbindung."],
        "05": ["Nachtlager", "Bringe fünf notwendige Maßnahmen in eine klare Reihenfolge und begründe Platz eins."],
        "06": ["Entscheidung", "Triff deine Entscheidung, bevor du erfährst, wie Dennis tatsächlich reagierte."],
        "07": ["Auflösung", "Vergleiche deine vorherige Entscheidung mit dem bestätigten Verlauf."],
        "08": ["Verlust", "Entscheide mit der verbliebenen Ausrüstung, wie du jetzt handlungsfähig bleibst."],
        "09": ["Beweisstück", "Prüfe die damalige Berichterstattung. Trenne belegte Erinnerung und Presseaussage."],
        "10": ["Weg heraus", "Verfolge den Rückweg durch den Regenwald. Hier wird später die historische Videosequenz eingebaut."],
        "11": ["Debriefing", "Fasse deine Entscheidungen zu deiner persönlichen Expeditionsakte zusammen."]
    };

    // Label mappings for answers
    const answerKeyLabels = {
        "safety-kommunikation": "Kommunikation geprüft",
        "safety-wasser": "Trinkwasser gesichert",
        "safety-wetterschutz": "Wetterschutz gesichert",
        "safety-orientierung": "Orientierung gesichert",
        "safety-erste-hilfe": "Erste Hilfe gesichert",
        "entscheidung-vorbereitung": "Wichtigste Entscheidung vor dem Aufbruch",
        "karte-schwarzwasser": "Fluss mit dunklem Wasser",
        "karte-stadt": "Stadt am Zusammenfluss",
        "karte-fluss": "Entstehender Fluss",
        "karte-richtung": "Grobe Fließrichtung",
        "floss-kontrolle": "Drei Kontrollen vor dem Ablegen",
        "lager-grund": "Begründung für Priorität eins im Lager",
        "ueberfall": "Entscheidung beim Überfall",
        "verlust": "Entscheidung nach dem Verlust",
        "verlust-grund": "Begründung nach dem Verlust",
        "archiv-waffe": "Im Bericht genannte Waffe",
        "archiv-deutschland": "Behauptung über Hilfe aus Deutschland",
        "archiv-artikel": "Genannte Artikel",
        "archiv-zweifel": "Zweifelhafte Aussagen",
        "archiv-trennung": "Pressebericht und Erinnerung trennen",
        "bericht-ausruestung": "Meine wichtigste Ausrüstung",
        "bericht-lager": "Meine erste Maßnahme im Lager",
        "bericht-ueberfall": "Meine Reaktion auf den Überfall",
        "bericht-verlust": "Mein Plan nach dem Verlust",
        "bericht-ueberraschung": "Überraschende Entscheidung",
        "bericht-begleitung": "Entscheidung der Begleitperson",
        "bonus-funknachricht": "Bonus: letzte Funknachricht",
        "bonus-zeitdruck": "Bonus: Entscheidung unter Zeitdruck",
        "dnl-beobachtung-1": "Bonus Tag 1: Aussage 1",
        "dnl-beobachtung-2": "Bonus Tag 1: Aussage 2",
        "dnl-beobachtung-3": "Bonus Tag 1: Aussage 3",
        "dnl-blinder-fleck": "Bonus Tag 1: unsichtbarer Informationskanal",
        "dnl-signal": "Bonus Tag 2: handlungsrelevantes Signal",
        "dnl-einordnung": "Bonus Tag 2: alternative Einordnung",
        "dnl-widerstand": "Bonus Tag 4: Widerstand prüfen",
        "dnl-einstieg": "Bonus Tag 5: Einstieg in den DNL-Kreislauf",
        "dnl-entscheidung": "Bonus Tag 3: Entscheidung unter Zeitdruck",
        "dnl-handlung": "Bonus Tag 4: erster sichtbarer Schritt",
        "dnl-routine": "Bonus Tag 5: persönliche Navigationsroutine"
    };

    const rioEquipItems = ["Kommunikation", "Wasser", "Wetterschutz", "Orientierung", "Nahrung", "Feuer", "Erste Hilfe", "Kamera"];
    const rioCampItems = ["Hängematte", "Regendach", "Trinkwasser", "Feuerholz", "Ausrüstung sichern"];

    // Nutrition (KLAR ESSEN) Question Bank
    const nutritionQuizBank = {
        "E01-A01": { key: "essen-spiel-kurslogik", title: "Vier Schritte in zehn Sekunden", question: "Welche Reihenfolge entspricht der DNL-Kurslogik?", options: ["Wahrnehmen → Einordnen → Entscheiden → Handeln", "Entscheiden → Wahrnehmen → Handeln → Einordnen", "Handeln → Bewerten → Verbieten → Kontrollieren"], correct: "Wahrnehmen → Einordnen → Entscheiden → Handeln", explanation: "Zuerst wird die Situation beobachtet. Danach folgen Einordnung, Entscheidung und konkrete Handlung." },
        "E01-A04": { key: "essen-spiel-ausgangslage", title: "Beobachtung statt Bewertung", question: "Welche Notiz ist für eine Ausgangsanalyse am brauchbarsten?", options: ["Was, wann und in welcher Situation gegessen wurde", "Der Tag war ernährungstechnisch schlecht", "Ab morgen wird alles perfekt"], correct: "Was, wann und in welcher Situation gegessen wurde", explanation: "Konkrete Beobachtungen liefern eine belastbare Grundlage. Pauschale Bewertungen erklären das Muster nicht." },
        "E02-A02": { key: "essen-spiel-qualitaet", title: "Alltagsvergleich", question: "Welche Entscheidung verbindet Qualität und Alltagstauglichkeit?", options: ["Eine passende Mahlzeit wählen, die auch realistisch verfügbar ist", "Nur Lebensmittel mit Gesundheitsversprechen kaufen", "Eine einzelne Mahlzeit als endgültigen Erfolg bewerten"], correct: "Eine passende Mahlzeit wählen, die auch realistisch verfügbar ist", explanation: "Eine tragfähige Entscheidung muss fachlich sinnvoll und im eigenen Alltag umsetzbar sein." },
        "E02-A01": { key: "essen-spiel-energiebilanz", title: "Ein Tag ist noch kein Muster", question: "Welche Aussage ist für eine sachliche Auswertung richtig?", options: ["Entscheidend ist die Entwicklung über einen längeren Zeitraum", "Eine einzelne Mahlzeit bestimmt dauerhaft das Ergebnis", "Nur perfekte Tage dürfen ausgewertet werden"], correct: "Entscheidend ist die Entwicklung über einen längeren Zeitraum", explanation: "Einzelne Situationen liefern Daten. Erst die wiederkehrende Entwicklung zeigt ein belastbares Muster." },
        "E03-A01": { key: "essen-spiel-hunger", title: "Hunger oder Impuls?", question: "Was hilft vor einer spontanen Essentscheidung zuerst?", options: ["Körperliches Signal, Situation und Auslöser kurz trennen", "Den Impuls grundsätzlich verbieten", "Sofort eine neue Diätregel festlegen"], correct: "Körperliches Signal, Situation und Auslöser kurz trennen", explanation: "Die kurze Trennung macht sichtbar, ob Hunger, Appetit, Gewohnheit oder eine Situation die Entscheidung auslöst." },
        "E03-A02": { key: "essen-spiel-gewohnheit", title: "Die Gewohnheitsschleife", question: "Welche drei Elemente helfen beim Erkennen einer Gewohnheit?", options: ["Auslöser → bisherige Handlung → kurzfristige Wirkung", "Verbot → Ausnahme → Schuldgefühl", "Produktname → Preis → Verpackungsfarbe"], correct: "Auslöser → bisherige Handlung → kurzfristige Wirkung", explanation: "Die Schleife wird veränderbar, wenn Auslöser, Handlung und ihre unmittelbare Wirkung getrennt sichtbar werden." },
        "E04-A02": { key: "essen-spiel-getraenk", title: "Nebenentscheidung erkennen", question: "Welche Veränderung lässt sich am zuverlässigsten prüfen?", options: ["Ein konkretes Getränkemuster sieben Tage beobachten", "Alle Getränke gleichzeitig neu regeln", "Nur den besten Tag der Woche auswerten"], correct: "Ein konkretes Getränkemuster sieben Tage beobachten", explanation: "Ein begrenztes, messbares Muster lässt sich erkennen und anschließend gezielt verändern." },
        "E04-A03": { key: "essen-spiel-kette", title: "Die Entscheidungskette kürzen", question: "Welche Veränderung ist am einfachsten überprüfbar?", options: ["Eine wiederkehrende Beilage oder einen Snack bewusst auswählen", "Den gesamten Alltag gleichzeitig umbauen", "Jede spontane Entscheidung vollständig verhindern"], correct: "Eine wiederkehrende Beilage oder einen Snack bewusst auswählen", explanation: "Eine einzelne wiederkehrende Nebenentscheidung lässt sich beobachten, testen und bei Bedarf anpassen." },
        "E05-A03": { key: "essen-spiel-wenn-dann", title: "Wenn-dann-Regel", question: "Welche Regel ist konkret ausführbar?", options: ["Wenn ich gestresst nach Hause komme, trinke ich zuerst Wasser und entscheide nach zehn Minuten", "Ich esse künftig bewusster", "Ich darf nie wieder spontan essen"], correct: "Wenn ich gestresst nach Hause komme, trinke ich zuerst Wasser und entscheide nach zehn Minuten", explanation: "Auslöser, Handlung und Zeitpunkt sind eindeutig. Dadurch wird aus einem Vorsatz ein überprüfbarer Ablauf." },
        "E05-A04": { key: "essen-spiel-genuss", title: "Genuss mit Priorität", question: "Welche Entscheidung ist flexibel und trotzdem klar?", options: ["Ich wähle bewusst, was mir heute wirklich wichtig ist", "Ich verzichte vorsorglich auf alles", "Ich nehme alles, weil der Tag ohnehin nicht perfekt ist"], correct: "Ich wähle bewusst, was mir heute wirklich wichtig ist", explanation: "Priorität bedeutet Auswahl. Sie erhält Genuss, ohne jede verfügbare Möglichkeit automatisch mitzunehmen." },
        "E06-A02": { key: "essen-spiel-ausloeser", title: "Auslöser-Landkarte", question: "Welche Kombination beschreibt einen Auslöser vollständig?", options: ["Situation, innerer Zustand und bisherige Reaktion", "Kalorienzahl und Körpergewicht", "Erlaubte und verbotene Lebensmittel"], correct: "Situation, innerer Zustand und bisherige Reaktion", explanation: "Eine Auslöser-Landkarte verbindet den äußeren Moment mit dem inneren Zustand und der gewohnten Handlung." },
        "E06-A03": { key: "essen-spiel-alternative", title: "Alternative unter Anspannung", question: "Welche Alternative ist in einer stressigen Situation am ehesten nutzbar?", options: ["Eine vorher festgelegte Handlung, die sofort möglich ist", "Eine umfangreiche neue Wochenplanung", "Eine Regel, die maximale Konzentration verlangt"], correct: "Eine vorher festgelegte Handlung, die sofort möglich ist", explanation: "Unter Anspannung muss die Alternative einfach, erreichbar und bereits entschieden sein." },
        "E07-A02": { key: "essen-spiel-einkauf", title: "Einkaufsdetektiv", question: "Welche Information ist belastbarer als eine Werbeaussage auf der Vorderseite?", options: ["Zutatenliste und Nährwertangaben im Zusammenhang", "Die Größe des Gesundheitsversprechens", "Die Farbe der Verpackung"], correct: "Zutatenliste und Nährwertangaben im Zusammenhang", explanation: "Werbung lenkt Aufmerksamkeit. Die konkrete Produktinformation ermöglicht den sachlichen Vergleich." },
        "E07-A03": { key: "essen-spiel-saettigung", title: "Pause vor dem Nachschlag", question: "Welche Handlung schafft neue Information für die nächste Entscheidung?", options: ["Kurz pausieren und das Sättigungssignal erneut prüfen", "Automatisch dieselbe Portion nachnehmen", "Die Mahlzeit nach einem starren Ideal bewerten"], correct: "Kurz pausieren und das Sättigungssignal erneut prüfen", explanation: "Die Pause ist kein Verbot. Sie schafft einen Moment, in dem ein aktuelles Signal wahrgenommen werden kann." },
        "E08-A01": { key: "essen-spiel-restaurant", title: "Restaurant-Strategie", question: "Welche Vorbereitung erhält Entscheidungsspielraum?", options: ["Vorher eine einfache Priorität festlegen und vor Ort bewusst auswählen", "Zu Hause nichts essen und jede Entscheidung offenlassen", "Nur Gerichte wählen, die als leicht bezeichnet werden"], correct: "Vorher eine einfache Priorität festlegen und vor Ort bewusst auswählen", explanation: "Eine klare Priorität gibt Richtung, ohne die reale Situation oder den Genuss auszublenden." },
        "E08-A02": { key: "essen-spiel-feier", title: "Feier ohne Alles-oder-nichts", question: "Welche Strategie lässt soziale Teilhabe und eine eigene Entscheidung gleichzeitig zu?", options: ["Vorher eine persönliche Priorität setzen und vor Ort flexibel bleiben", "Die Einladung grundsätzlich absagen", "Ohne Entscheidung hingehen und später streng ausgleichen"], correct: "Vorher eine persönliche Priorität setzen und vor Ort flexibel bleiben", explanation: "Die eigene Priorität gibt Orientierung. Die konkrete Situation darf trotzdem berücksichtigt werden." },
        "E09-A01": { key: "essen-spiel-ausnahme", title: "Ausnahme oder Abbruch?", question: "Was ist nach einer ungeplanten Ausnahme der sinnvollste nächste Schritt?", options: ["Zur nächsten normalen Entscheidung zurückkehren", "Den gesamten Tag als gescheitert betrachten", "Mit einer besonders strengen Gegenmaßnahme reagieren"], correct: "Zur nächsten normalen Entscheidung zurückkehren", explanation: "Eine einzelne Ausnahme wird nicht durch Bewertung größer. Die Rückkehr zur normalen Struktur stabilisiert den Verlauf." },
        "E09-A03": { key: "essen-spiel-rueckkehr", title: "Der nächste normale Schritt", question: "Was gehört in eine belastbare Rückkehrroutine?", options: ["Eine einfache nächste Handlung ohne Bestrafung", "Eine vollständige Analyse aller vergangenen Fehler", "Ein besonders strenger Ausgleichstag"], correct: "Eine einfache nächste Handlung ohne Bestrafung", explanation: "Die Routine verkürzt den Weg zurück in die normale Struktur und verhindert unnötige Gegenreaktionen." },
        "E10-A01": { key: "essen-spiel-stabilitaet", title: "Dauerplan statt Diätmodus", question: "Woran erkennt man eine tragfähige Regel?", options: ["Sie funktioniert auch an gewöhnlichen, unperfekten Tagen", "Sie verlangt dauerhaft maximale Disziplin", "Sie verhindert jede Ausnahme"], correct: "Sie funktioniert auch an gewöhnlichen, unperfekten Tagen", explanation: "Der Dauerplan muss den realen Alltag tragen. Perfektion ist dafür kein belastbares Kriterium." },
        "E10-A04": { key: "essen-spiel-abschluss", title: "Was bleibt nach dem Kurs?", question: "Welches Ergebnis ist für den Alltag am wertvollsten?", options: ["Wenige persönliche Regeln mit klarer Rückkehrroutine", "Möglichst viele Verbote für jede Situation", "Ein Plan, der nur unter idealen Bedingungen funktioniert"], correct: "Wenige persönliche Regeln mit klarer Rückkehrroutine", explanation: "Ein überschaubares persönliches System ist leichter abrufbar und kann bei Veränderungen angepasst werden." },
        "A01": { key: "essen-spiel-akut-impuls", title: "Akut: Erst beobachten", question: "Was ist vor einer impulsiven Entscheidung ein sinnvoller erster Schritt?", options: ["Den aktuellen Auslöser kurz benennen", "Sofort eine dauerhafte Regel beschließen", "Den Impuls moralisch bewerten"], correct: "Den aktuellen Auslöser kurz benennen", explanation: "Die kurze Benennung schafft Abstand und liefert Information, ohne die Entscheidung vorwegzunehmen." },
        "A02": { key: "essen-spiel-akut-restaurant", title: "Akut: Eine Priorität", question: "Was reduziert im Restaurant unnötige Entscheidungslast?", options: ["Eine persönliche Priorität für diesen Besuch", "Alle Möglichkeiten gleichzeitig vergleichen", "Die Auswahl vollständig anderen überlassen"], correct: "Eine persönliche Priorität für diesen Besuch", explanation: "Eine Priorität vereinfacht die Auswahl, ohne eine starre allgemeine Regel daraus zu machen." },
        "A03": { key: "essen-spiel-akut-ausnahme", title: "Akut: Ausnahme einordnen", question: "Welche Aussage verhindert das Alles-oder-nichts-Muster?", options: ["Eine Ausnahme ist ein einzelnes Ereignis", "Der gesamte Plan ist jetzt gescheitert", "Nur ein strenger Ausgleich stellt Kontrolle wieder her"], correct: "Eine Ausnahme ist ein einzelnes Ereignis", explanation: "Die sachliche Einordnung hält das Ereignis klein und ermöglicht die nächste normale Entscheidung." },
        "A04": { key: "essen-spiel-akut-stress", title: "Akut: Handlung verkleinern", question: "Welche Entscheidung passt am besten in eine Stresssituation?", options: ["Eine kleine, sofort ausführbare Alternative", "Eine vollständige langfristige Neuplanung", "Eine komplizierte Abwägung mit vielen Regeln"], correct: "Eine kleine, sofort ausführbare Alternative", explanation: "Unter Stress hilft eine einfache vorbereitete Handlung mehr als ein komplexer Plan." }
    };

    // Press (Presse & Öffentlichkeit) Question Bank
    const pressQuizBank = {
        "A02": { key: "presse-spiel-werbung", title: "Wer entscheidet?", question: "Welche Aussage beschreibt Pressearbeit korrekt?", options: ["Die Redaktion entscheidet unabhängig", "Die Veröffentlichung ist mit Versand garantiert", "Bezahlte Reichweite ist Pressearbeit"], correct: "Die Redaktion entscheidet unabhängig", explanation: "Pressearbeit bietet ein Thema an. Die redaktionelle Entscheidung bleibt vollständig beim Medium." },
        "A05": { key: "presse-spiel-filter", title: "Durch den Redaktionsfilter", question: "Was trägt am ehesten zur Auswahl eines Themas bei?", options: ["Konkrete Relevanz für das Publikum", "Möglichst viele Werbeadjektive", "Ein sehr langer Unternehmenslebenslauf"], correct: "Konkrete Relevanz für das Publikum", explanation: "Redaktionen prüfen den Nachrichten- und Publikumswert, nicht die Begeisterung des Absenders." },
        "A12": { key: "presse-spiel-zitat", title: "Zitat oder Leerformel?", question: "Welches Zitat ist für eine Redaktion am brauchbarsten?", options: ["Ein belegbarer Satz mit eigener Aussage", "Wir freuen uns sehr", "Unser Angebot ist einzigartig"], correct: "Ein belegbarer Satz mit eigener Aussage", explanation: "Ein gutes Zitat ergänzt Inhalt oder Haltung. Eine austauschbare Werbeformel leistet das nicht." },
        "A13": { key: "presse-spiel-aussageart", title: "Aussage sauber einordnen", question: "„Wir sind der führende Anbieter“ – ohne Nachweis ist das:", options: ["Eine belegte Tatsache", "Eine unbelegte Bewertung", "Eine persönliche Erfahrung"], correct: "Eine unbelegte Bewertung", explanation: "Ohne nachvollziehbaren Beleg darf die Behauptung nicht als Tatsache behandelt werden." },
        "A16": { key: "presse-spiel-nachfassen", title: "Nachfassen ohne Druck", question: "Wann ist ein Nachfassen professionell?", options: ["Einmalig und mit einem konkreten Anlass", "Täglich bis eine Antwort kommt", "Sofort nach dem Versand"], correct: "Einmalig und mit einem konkreten Anlass", explanation: "Ein begründetes einmaliges Nachfassen respektiert den Redaktionstakt und schafft einen echten Anknüpfungspunkt." },
        "A22": { key: "presse-spiel-risiko", title: "Versenden oder klären?", question: "Eine zentrale Bildfreigabe ist unklar. Was ist der nächste Schritt?", options: ["Konkreten Klärungsauftrag formulieren", "Trotzdem versenden", "Den Hinweis aus den Unterlagen löschen"], correct: "Konkreten Klärungsauftrag formulieren", explanation: "Ein erkanntes Risiko wird dokumentiert und fachlich geklärt. Das Screening selbst ist keine Rechtsberatung." },
        "A24": { key: "presse-spiel-90-tage", title: "Plan wird Handlung", question: "Welches Element macht den 90-Tage-Plan arbeitsfähig?", options: ["Ein konkreter Termin im Kalender", "Eine allgemeine Absicht", "Eine möglichst lange Ideenliste"], correct: "Ein konkreter Termin im Kalender", explanation: "Erst ein terminierter, sichtbarer Schritt übersetzt die Absicht in umsetzbares Handeln." }
    };

    // Founder (Erfolgreich Gründen) Question Bank
    const founderQuizBank = {
        "A01": { key: "gruender-spiel-aussenkontakt", title: "Markt oder Echokammer?", question: "Welche Reaktion liefert für einen ersten Markttest den stärksten Hinweis?", options: ["Eine dokumentierte Reaktion außerhalb des engen Umfelds", "Eigenes Nachdenken über die Zielgruppe", "Lob einer vertrauten Person"], correct: "Eine dokumentierte Reaktion außerhalb des engen Umfelds", explanation: "Der Außenkontakt erzeugt reale Daten. Eigene Annahmen und freundliches Lob ersetzen diesen Test nicht." },
        "A02": { key: "gruender-spiel-einordnung", title: "Beobachtung oder Deutung?", question: "Welche Aussage ist zunächst eine Beobachtung?", options: ["Zwei angesprochene Personen fragten nach dem Preis", "Das Angebot ist noch nicht gut genug", "Die Zielgruppe hat kein Interesse"], correct: "Zwei angesprochene Personen fragten nach dem Preis", explanation: "Eine dokumentierte Reaktion ist beobachtbar. Ihre Bedeutung muss anschließend getrennt eingeordnet werden." },
        "A04": { key: "gruender-spiel-verkauf", title: "Ist das schon ein Verkaufstest?", question: "Welcher Schritt erzeugt eine echte Marktreaktion?", options: ["Ein konkretes Angebot mit Bitte um Entscheidung", "Eine unverbindliche Ideenumfrage", "Das Überarbeiten des Logos"], correct: "Ein konkretes Angebot mit Bitte um Entscheidung", explanation: "Erst ein konkretes Angebot mit echter Entscheidungssituation prüft Zahlungs- oder Abschlussbereitschaft." },
        "A08": { key: "gruender-spiel-ki", title: "KI nutzen, Verantwortung behalten", question: "Wann ist ein KI-Ergebnis arbeitsfähig?", options: ["Nach eigener fachlicher Prüfung", "Sobald es überzeugend formuliert ist", "Wenn es ohne Änderung übernommen werden kann"], correct: "Nach eigener fachlicher Prüfung", explanation: "KI kann Arbeit beschleunigen. Prüfung, Auswahl und Verantwortung bleiben beim Unternehmer." },
        "A10": { key: "gruender-spiel-deckungsbeitrag", title: "Zahl oder Scheinpräzision?", question: "Was zeigt der Deckungsbeitrag zunächst?", options: ["Was nach direkten Kosten vom Erlös verbleibt", "Den vollständigen Unternehmenswert", "Den sicheren Jahresgewinn"], correct: "Was nach direkten Kosten vom Erlös verbleibt", explanation: "Die Kennzahl unterstützt Entscheidungen, beantwortet aber nicht automatisch alle Fragen zu Gewinn oder Unternehmenswert." },
        "A13": { key: "gruender-spiel-uebergabe", title: "Hält der Ablauf ohne Sie?", question: "Was liefert ein reales Übergabegespräch?", options: ["Konkrete Hinweise auf Unklarheiten im Ablauf", "Den Beweis, dass keine Fehler mehr auftreten", "Eine automatische Skalierung des Unternehmens"], correct: "Konkrete Hinweise auf Unklarheiten im Ablauf", explanation: "Die Übergabe macht Lücken sichtbar. Sie ist eine Belastungsprüfung, keine Erfolgsgarantie." }
    };

    // Workbook viewer state
    let wbPage = 1;
    let wbZoom = 125;

    // Storage
    const storageKey = 'besseler-course-answers-' + courseSlug;

    function getAnswers() {
        try {
            return JSON.parse(localStorage.getItem(storageKey) || '{}');
        } catch (e) {
            return {};
        }
    }

    function setAnswer(key, val) {
        const ans = getAnswers();
        ans[key] = val;
        try {
            localStorage.setItem(storageKey, JSON.stringify(ans));
        } catch (e) {}
    }

    function formatKeyLabel(key) {
        if (answerKeyLabels[key]) return answerKeyLabels[key];
        if (key.startsWith('ausruestung-')) return `Ausrüstungspriorität: ${key.replace('ausruestung-', '')}`;
        if (key.startsWith('lager-')) return `Lagerpriorität: ${key.replace('lager-', '')}`;
        if (key.startsWith('notiz-')) return `Notiz zu Etappe ${key.replace('notiz-', '')}`;
        if (key.startsWith('dnl-wirkung-')) return `Bonus Tag 3: Priorität ${key.replace('dnl-wirkung-', '')}`;
        if (key.startsWith('generic-')) {
            const num = key.replace('generic-', '');
            const unit = unitsData.find(u => u.number === num);
            if (unit) return `${unit.number} · ${unit.title} — ${unit.task}`;
            return `Antwort zu Einheit ${num}`;
        }
        return key;
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    // UI Helper: Render Radio Field
    function renderRadioField(name, legend, options) {
        const ans = getAnswers()[name] || '';
        return `
            <fieldset class="decision-field">
                <legend>${escapeHtml(legend)}</legend>
                <div class="decision-options">
                    ${options.map(opt => `
                        <label class="${ans === opt ? 'is-selected' : ''}">
                            <input type="radio" name="${escapeHtml(name)}" value="${escapeHtml(opt)}" ${ans === opt ? 'checked' : ''} onchange="handleRadioChange('${escapeHtml(name)}', this.value, this)"/>
                            <span>${escapeHtml(opt)}</span>
                        </label>
                    `).join('')}
                </div>
            </fieldset>
        `;
    }

    // UI Helper: Render Ranking 1..5 Field
    function renderRankingField(name, title, items) {
        const ans = getAnswers();
        return `
            <section class="ranking-game">
                <h3>${escapeHtml(title)}</h3>
                <p>Vergib die Plätze 1 bis 5. Platz 1 hat für dich die höchste Priorität.</p>
                <div>
                    ${items.map(item => `
                        <label>
                            <span>${escapeHtml(item)}</span>
                            <select onchange="setAnswer('${escapeHtml(name)}-${escapeHtml(item)}', this.value)">
                                <option value="">–</option>
                                ${[1, 2, 3, 4, 5].map(n => `
                                    <option value="${n}" ${(ans[`${name}-${item}`] == n) ? 'selected' : ''}>${n}</option>
                                `).join('')}
                            </select>
                        </label>
                    `).join('')}
                </div>
            </section>
        `;
    }

    // UI Helper: Render Workbook Task Field (Input or Textarea)
    function renderWorkbookField(name, labelText, isTextarea) {
        const val = getAnswers()[name] || '';
        const btnText = val.trim() ? 'Aufgabe und Antwort für KI kopieren' : 'Text eingeben – Kopieren danach möglich';
        const disabledAttr = val.trim() ? '' : 'disabled';
        return `
            <label class="workbook-field">
                <span>${escapeHtml(labelText)}</span>
                ${isTextarea ? `
                    <textarea rows="4" oninput="handleTextInputChange('${escapeHtml(name)}', this.value, '${escapeHtml(labelText)}')">${escapeHtml(val)}</textarea>
                ` : `
                    <input type="text" value="${escapeHtml(val)}" oninput="handleTextInputChange('${escapeHtml(name)}', this.value, '${escapeHtml(labelText)}')"/>
                `}
                <button class="copy-answer" type="button" id="copy-btn-${escapeHtml(name)}" onclick="copyFieldTaskAndAnswer('${escapeHtml(name)}', '${escapeHtml(labelText)}')" ${disabledAttr} aria-live="polite">
                    ${btnText}
                </button>
            </label>
        `;
    }

    // UI Helper: Render Quiz with instant feedback
    function renderQuizBlock(q) {
        const ans = getAnswers()[q.key] || '';
        const feedbackHtml = ans ? `
            <p class="game-answer ${ans === q.correct ? 'is-correct' : 'is-review'}">
                <strong>${ans === q.correct ? 'Treffer.' : 'Noch einmal prüfen.'}</strong> ${escapeHtml(q.explanation)}
            </p>
        ` : '';

        return `
            <section class="mission game-mission bonus-mission press-quick-game" id="quiz-block-${q.key}">
                <span class="bonus-tag">Optional · unabhängiges Kurzspiel</span>
                <h3>${escapeHtml(q.title)}</h3>
                ${renderRadioField(q.key, q.question, q.options)}
                <div id="quiz-feedback-${q.key}">${feedbackHtml}</div>
            </section>
        `;
    }

    function handleRadioChange(name, val, radioEl) {
        setAnswer(name, val);
        const parentFieldset = radioEl.closest('.decision-options');
        if (parentFieldset) {
            parentFieldset.querySelectorAll('label').forEach(lbl => lbl.classList.remove('is-selected'));
            const selectedLabel = radioEl.closest('label');
            if (selectedLabel) selectedLabel.classList.add('is-selected');
        }

        // Check if this is a quiz question with instant feedback
        const allQuizzes = { ...nutritionQuizBank, ...pressQuizBank, ...founderQuizBank };
        for (const k in allQuizzes) {
            const q = allQuizzes[k];
            if (q.key === name) {
                const feedbackContainer = document.getElementById('quiz-feedback-' + name);
                if (feedbackContainer) {
                    feedbackContainer.innerHTML = `
                        <p class="game-answer ${val === q.correct ? 'is-correct' : 'is-review'}">
                            <strong>${val === q.correct ? 'Treffer.' : 'Noch einmal prüfen.'}</strong> ${escapeHtml(q.explanation)}
                        </p>
                    `;
                }
                break;
            }
        }
    }

    function handleTextInputChange(name, val, labelText) {
        setAnswer(name, val);
        const btn = document.getElementById('copy-btn-' + name);
        if (btn) {
            if (val.trim()) {
                btn.disabled = false;
                if (btn.textContent !== 'Kopiert ✓') {
                    btn.textContent = 'Aufgabe und Antwort für KI kopieren';
                }
            } else {
                btn.disabled = true;
                btn.textContent = 'Text eingeben – Kopieren danach möglich';
            }
        }
    }

    async function copyFieldTaskAndAnswer(name, labelText) {
        const val = (getAnswers()[name] || '').trim();
        if (!val) return;
        const textToCopy = `${labelText}\n\n${val}`;
        const btn = document.getElementById('copy-btn-' + name);

        try {
            if (navigator.clipboard && window.isSecureContext) {
                await navigator.clipboard.writeText(textToCopy);
            } else {
                const ta = document.createElement('textarea');
                ta.value = textToCopy;
                ta.style.position = 'fixed';
                ta.style.left = '-9999px';
                document.body.appendChild(ta);
                ta.focus();
                ta.select();
                document.execCommand('copy');
                document.body.removeChild(ta);
            }
            if (btn) {
                btn.textContent = 'Kopiert ✓';
                setTimeout(() => {
                    handleTextInputChange(name, val, labelText);
                }, 1800);
            }
        } catch (err) {
            console.error('Kopieren fehlgeschlagen', err);
        }
    }

    // Countdown Timer State
    let countdownRemaining = null;
    let countdownTimerId = null;

    function startInteractiveCountdown(seconds = 30) {
        if (countdownTimerId) clearInterval(countdownTimerId);
        countdownRemaining = seconds;
        const btn = document.getElementById('countdown-timer-btn');
        const displaySection = document.getElementById('countdown-timer-followup');

        if (btn) {
            btn.disabled = true;
            btn.textContent = `${countdownRemaining} Sekunden`;
        }

        countdownTimerId = setInterval(() => {
            countdownRemaining--;
            if (btn) {
                if (countdownRemaining > 0) {
                    btn.textContent = `${countdownRemaining} Sekunden`;
                } else {
                    btn.textContent = 'Zeit abgelaufen';
                    btn.disabled = false;
                    clearInterval(countdownTimerId);
                }
            }
            if (displaySection) {
                displaySection.style.display = 'block';
            }
        }, 1000);

        if (displaySection) {
            displaySection.style.display = 'block';
        }
    }

    // Interactive exercises generator for current unit
    function buildInteractiveExercises(unit) {
        let html = '';
        const num = unit.number;

        // 1. Rio Negro 2002 Exercises (ie)
        if (isRio) {
            if (num === '02') {
                html += `
                    <section class="mission game-mission">
                        <p class="eyebrow">Expeditionsspiel · Vorbereitung</p>
                        ${renderRankingField('ausruestung', 'Welche fünf Bereiche haben Vorrang?', rioEquipItems)}
                        ${renderRadioField('entscheidung-vorbereitung', 'Welche Entscheidung triffst du zuerst?', [
                            'Die Kommunikationstechnik prüfen',
                            'Die Route und Rückzugswege klären',
                            'Genug Vorräte und Ausrüstung einplanen',
                            'Eigene Antwort'
                        ])}
                        <div class="yes-no-check">
                            <span class="bonus-tag">Optionale Bonusaufgabe</span>
                            <h3>Sicherheitscheck</h3>
                            <p>Unabhängige spielerische Abfahrtskontrolle. Kein Bestandteil der abgeschlossenen Originalgeschichte.</p>
                            ${renderRadioField('safety-kommunikation', 'Ist die Kommunikationstechnik geprüft?', ['Ja', 'Nein'])}
                            ${renderRadioField('safety-wasser', 'Ist ausreichend Trinkwasser gesichert?', ['Ja', 'Nein'])}
                            ${renderRadioField('safety-wetterschutz', 'Ist der Wetterschutz einsatzbereit?', ['Ja', 'Nein'])}
                            ${renderRadioField('safety-orientierung', 'Sind Orientierung und Rückzugsweg geklärt?', ['Ja', 'Nein'])}
                            ${renderRadioField('safety-erste-hilfe', 'Ist Erste Hilfe unmittelbar erreichbar?', ['Ja', 'Nein'])}
                        </div>
                    </section>
                `;
            } else if (num === '03') {
                html += `
                    <section class="mission game-mission">
                        <p class="eyebrow">Karten- und Floßmission</p>
                        ${renderWorkbookField('karte-schwarzwasser', 'Welcher Fluss führt dunkles Wasser?', false)}
                        ${renderWorkbookField('karte-stadt', 'Bei welcher Stadt treffen die Flüsse zusammen?', false)}
                        ${renderWorkbookField('karte-fluss', 'Welcher Fluss entsteht daraus?', false)}
                        ${renderWorkbookField('karte-richtung', 'In welche grobe Richtung fließt das Wasser?', false)}
                        ${renderWorkbookField('floss-kontrolle', 'Welche drei Punkte kontrollierst du vor dem Ablegen?', true)}
                    </section>
                `;
            } else if (num === '04') {
                html += `
                    <section class="mission game-mission bonus-mission">
                        <span class="bonus-tag">Optionale Bonusaufgabe</span>
                        <h3>Die letzte Funknachricht</h3>
                        <p>Du hast nur 160 Zeichen. Welche Information muss Deutschland unbedingt erreichen?</p>
                        ${renderWorkbookField('bonus-funknachricht', 'Deine Nachricht', true)}
                    </section>
                `;
            } else if (num === '05') {
                html += `
                    <section class="mission game-mission">
                        <p class="eyebrow">Entscheidung · Lager</p>
                        ${renderRankingField('lager', 'In welcher Reihenfolge sicherst du das Lager?', rioCampItems)}
                        ${renderWorkbookField('lager-grund', 'Warum steht dieser Punkt an erster Stelle?', true)}
                    </section>
                `;
            } else if (num === '06') {
                html += `
                    <section class="mission game-mission">
                        <p class="eyebrow">Entscheidung · Ohne Vorwarnung</p>
                        ${renderRadioField('ueberfall', 'Du wirst am Lager mit einer sichtbaren Pistole bedroht. Was tust du?', [
                            'Ruhig bleiben und abwarten',
                            'Sofort kooperieren',
                            'Versuchen, das Gespräch zu suchen',
                            'Eigene Antwort'
                        ])}
                        <section class="timed-bonus">
                            <span class="bonus-tag">Optionale Bonusaufgabe</span>
                            <h3>30 Sekunden unter Unsicherheit</h3>
                            <p>Starte den Countdown und entscheide anschließend: Handelst du mit den vorhandenen Informationen oder wartest du auf mehr Klarheit?</p>
                            <div>
                                <button type="button" id="countdown-timer-btn" onclick="startInteractiveCountdown(30)">Countdown starten</button>
                                <div id="countdown-timer-followup" style="display: none;">
                                    ${renderRadioField('bonus-zeitdruck', 'Deine Entscheidung nach dem Countdown', [
                                        'Jetzt handeln',
                                        'Auf weitere Informationen warten'
                                    ])}
                                </div>
                            </div>
                        </section>
                    </section>
                `;
            } else if (num === '08') {
                html += `
                    <section class="mission game-mission">
                        <p class="eyebrow">Entscheidung · Was bleibt</p>
                        ${renderRadioField('verlust', 'Was ist dein unmittelbarer nächster Schritt?', [
                            'Mit der verbliebenen Ausrüstung weiterziehen',
                            'Den nächsten bewohnten Ort suchen',
                            'Am Lager bleiben und auf vorbeikommende Menschen hoffen',
                            'Eigener Plan'
                        ])}
                        ${renderWorkbookField('verlust-grund', 'Begründe deine Entscheidung.', true)}
                    </section>
                `;
            } else if (num === '09') {
                html += `
                    <section class="mission game-mission">
                        <p class="eyebrow">Archivmission</p>
                        ${renderWorkbookField('archiv-waffe', 'Welche Waffe wird im Bericht genannt?', false)}
                        ${renderWorkbookField('archiv-deutschland', 'Welche weitere Behauptung betrifft Hilfe aus Deutschland?', false)}
                        ${renderWorkbookField('archiv-artikel', 'Welche Artikel werden genannt?', false)}
                        ${renderWorkbookField('archiv-zweifel', 'Welche zwei Aussagen erscheinen dir zweifelhaft?', true)}
                        ${renderWorkbookField('archiv-trennung', 'Warum müssen Pressebericht und bestätigte Erinnerung getrennt werden?', true)}
                    </section>
                `;
            } else if (num === '11') {
                html += `
                    <section class="mission game-mission">
                        <p class="eyebrow">Dein Expeditionsbericht</p>
                        ${renderWorkbookField('bericht-ausruestung', 'Meine wichtigste Ausrüstung', false)}
                        ${renderWorkbookField('bericht-lager', 'Meine erste Maßnahme im Lager', false)}
                        ${renderWorkbookField('bericht-ueberfall', 'Meine Reaktion auf den bewaffneten Überfall', false)}
                        ${renderWorkbookField('bericht-verlust', 'Mein Plan nach dem Verlust', false)}
                        ${renderWorkbookField('bericht-ueberraschung', 'Welche Entscheidung hat dich überrascht und warum?', true)}
                        ${renderWorkbookField('bericht-begleitung', 'Entscheidung meiner Begleitperson', false)}
                    </section>
                `;
            } else {
                html += `
                    <section class="mission game-mission game-mission-compact">
                        <span class="bonus-tag">Optionale Bonusaufgabe</span>
                        <p class="eyebrow">Deine Spur</p>
                        ${renderWorkbookField(`notiz-${num}`, 'Was nimmst du aus dieser Etappe mit?', true)}
                    </section>
                `;
            }
            return html;
        }

        // 2. Standard Courses: Main Task Textarea
        const isRauchfrei = (courseSlug === 'rauchfrei');
        const eyebrowText = isRauchfrei ? 'Ergänzende digitale Kursnotiz' : 'Originalaufgabe aus dem Workbook';
        html += `
            <section class="mission game-mission">
                <p class="eyebrow">${eyebrowText}</p>
                ${renderWorkbookField(`generic-${num}`, unit.task || 'Arbeitsauftrag im Arbeitsbuch', true)}
            </section>
        `;

        // 3. DNL Kompakt Bonus Missions (ae)
        if (courseSlug === 'dnl-kompakt') {
            if (num === '1-A03') {
                html += `
                    <section class="mission game-mission bonus-mission">
                        <span class="bonus-tag">Optional · unabhängige Denkmission</span>
                        <h3>Der unsichtbare Informationskanal</h3>
                        <p>Eine Entscheidung wirkt eindeutig. Welche Information prüfen Sie zuerst, weil sie leicht fehlen kann?</p>
                        ${renderRadioField('dnl-blinder-fleck', 'Wählen Sie einen Prüfpunkt.', [
                            'Wer von der Entscheidung betroffen ist, aber nicht gefragt wurde',
                            'Welche Zahl die bestehende Meinung bestätigt',
                            'Welche Lösung am schnellsten erklärt ist',
                            'Welche Person zuletzt gesprochen hat'
                        ])}
                    </section>
                `;
            } else if (num === '1-A06') {
                html += `
                    <section class="mission game-mission bonus-mission">
                        <span class="bonus-tag">Optional · unabhängige Zusatzaufgabe</span>
                        <h3>Kamera oder Film?</h3>
                        <p>Ordnen Sie jede Aussage per Klick ein. Diese Übung ergänzt Tag 1, verändert aber keine Aufgabe des Workbooks.</p>
                        ${renderRadioField('dnl-beobachtung-1', '„Die Nachricht kam um 8:14 Uhr.“', ['Wahrnehmung', 'Interpretation'])}
                        ${renderRadioField('dnl-beobachtung-2', '„Die Person nimmt mich nicht ernst.“', ['Wahrnehmung', 'Interpretation'])}
                        ${renderRadioField('dnl-beobachtung-3', '„Im Protokoll fehlt eine Freigabe.“', ['Wahrnehmung', 'Interpretation'])}
                    </section>
                `;
            } else if (num === '2-A09') {
                html += `
                    <section class="mission game-mission bonus-mission">
                        <span class="bonus-tag">Optional · unabhängige Denkmission</span>
                        <h3>Signal oder Rauschen?</h3>
                        <p>Ein Projekt verzögert sich. Welche Information ist für den nächsten Schritt am ehesten handlungsrelevant?</p>
                        ${renderRadioField('dnl-signal', 'Treffen Sie eine Auswahl.', [
                            'Der konkret blockierende Arbeitsschritt',
                            'Die allgemeine Stimmung im Team',
                            'Die Länge der letzten Besprechung',
                            'Die Zahl früherer Projektideen'
                        ])}
                    </section>
                `;
            } else if (num === '2-A12') {
                html += `
                    <section class="mission game-mission bonus-mission">
                        <span class="bonus-tag">Optional · unabhängige Zusatzaufgabe</span>
                        <h3>Drei mögliche Bedeutungen</h3>
                        <p>Wählen Sie zunächst die Einordnung, die Sie normalerweise am wenigsten prüfen würden.</p>
                        ${renderRadioField('dnl-einordnung', 'Eine Rückmeldung bleibt aus. Welche alternative Einordnung prüfen Sie zuerst?', [
                            'Die Person lehnt den Vorschlag ab',
                            'Die Information ist noch nicht angekommen',
                            'Eine andere Aufgabe hat aktuell Vorrang',
                            'Ich habe noch zu wenig Daten für eine Einordnung'
                        ])}
                    </section>
                `;
            } else if (num === '3-A15') {
                html += `
                    <section class="mission game-mission bonus-mission">
                        <span class="bonus-tag">Optional · unabhängige Denkmission</span>
                        ${renderRankingField('dnl-wirkung', 'Welche offenen Entscheidungen verdienen zuerst Aufmerksamkeit?', [
                            'Hohe Wirkung und Zeitdruck',
                            'Hohe Wirkung ohne Zeitdruck',
                            'Geringe Wirkung und Zeitdruck',
                            'Geringe Wirkung ohne Zeitdruck',
                            'Noch nicht entscheidungsreif'
                        ])}
                    </section>
                `;
            } else if (num === '3-A18') {
                html += `
                    <section class="mission game-mission bonus-mission">
                        <span class="bonus-tag">Optional · unabhängige Zusatzaufgabe</span>
                        <h3>30 Sekunden: Kurs setzen</h3>
                        <p>Der Countdown simuliert Zeitdruck. Die eigentliche Workbook-Aufgabe bleibt davon unberührt.</p>
                        <button class="bonus-countdown" type="button" id="countdown-timer-btn" onclick="startInteractiveCountdown(30)">Countdown starten</button>
                        <div id="countdown-timer-followup" style="display: none;">
                            ${renderRadioField('dnl-entscheidung', 'Welche Art von Entscheidung treffen Sie?', [
                                'Reversibel entscheiden und beginnen',
                                'Weitere Informationen mit Termin beschaffen',
                                'Bewusst nicht entscheiden und begründen'
                            ])}
                        </div>
                    </section>
                `;
            } else if (num === '4-A21') {
                html += `
                    <section class="mission game-mission bonus-mission">
                        <span class="bonus-tag">Optional · unabhängige Denkmission</span>
                        <h3>Widerstand: halten oder anpassen?</h3>
                        ${renderRadioField('dnl-widerstand', 'Der erste Umsetzungsschritt erzeugt Kritik. Was prüfen Sie zuerst?', [
                            'Ob neue Fakten die ursprüngliche Einordnung verändern',
                            'Ob sich die Kritik unangenehm anfühlt',
                            'Ob sofort eine völlig neue Lösung möglich ist',
                            'Ob jemand anderes die Verantwortung übernehmen kann'
                        ])}
                    </section>
                `;
            } else if (num === '4-A24') {
                html += `
                    <section class="mission game-mission bonus-mission">
                        <span class="bonus-tag">Optional · unabhängige Zusatzaufgabe</span>
                        <h3>Aus Entscheidung wird Bewegung</h3>
                        ${renderWorkbookField('dnl-handlung', 'Formulieren Sie einen von außen sichtbaren ersten Schritt mit Datum und Uhrzeit.', true)}
                    </section>
                `;
            } else if (num === '5-A27') {
                html += `
                    <section class="mission game-mission bonus-mission">
                        <span class="bonus-tag">Optional · unabhängige Denkmission</span>
                        <h3>Wo steigen Sie in den Kreislauf ein?</h3>
                        ${renderRadioField('dnl-einstieg', 'Es liegen viele Daten vor, aber niemand kann ihre Bedeutung für die Lage erklären.', [
                            'Wahrnehmen',
                            'Einordnen',
                            'Entscheiden',
                            'Handeln'
                        ])}
                    </section>
                `;
            } else if (num === '5-A30') {
                html += `
                    <section class="mission game-mission bonus-mission">
                        <span class="bonus-tag">Optional · unabhängige Zusatzaufgabe</span>
                        <h3>Ihr DNL-Kurzprotokoll</h3>
                        ${renderWorkbookField('dnl-routine', 'Wahrnehmen → Einordnen → Entscheiden → Handeln: Formulieren Sie Ihre persönliche Routine in vier kurzen Sätzen.', true)}
                    </section>
                `;
            }
        }

        // 4. Erfolgreich Gründen Quiz (ce)
        if (courseSlug === 'erfolgreich-gruenden' && founderQuizBank[num]) {
            html += renderQuizBlock(founderQuizBank[num]);
        }

        // 5. Ernährung (KLAR ESSEN) Quiz (oe)
        if (courseSlug === 'ernaehrung' && nutritionQuizBank[num]) {
            html += renderQuizBlock(nutritionQuizBank[num]);
        }

        // 6. Presse & Öffentlichkeit Quiz (se)
        if (courseSlug === 'presse-oeffentlichkeit' && pressQuizBank[num]) {
            html += renderQuizBlock(pressQuizBank[num]);
        }

        return html;
    }

    function goToStep(step) {
        const audio = document.getElementById('unit-audio-player');
        if (audio) {
            audio.pause();
        }

        const minStep = isRio ? 1 : 0;
        const maxStep = isRio ? 14 : (totalSteps - 1);
        currentStep = Math.max(minStep, Math.min(maxStep, step));

        const url = new URL(window.location.href);
        url.searchParams.set('step', currentStep);
        window.history.replaceState(null, '', url.toString());

        renderCurrentStep();
    }

    function goToPrevStep() {
        const minStep = isRio ? 1 : 0;
        if (currentStep > minStep) goToStep(currentStep - 1);
    }

    function goToNextStep() {
        const maxStep = isRio ? 14 : (totalSteps - 1);
        if (currentStep < maxStep) goToStep(currentStep + 1);
    }

    function renderCurrentStep() {
        document.getElementById('step-panel-0').style.display = 'none';
        document.getElementById('step-panel-unit').style.display = 'none';
        document.getElementById('step-panel-finish').style.display = 'none';

        const minStep = isRio ? 1 : 0;
        const maxStep = isRio ? 14 : (totalSteps - 1);

        // Direct Step Select dropdown
        const select = document.getElementById('direct-step-select');
        if (select) select.value = currentStep;

        // Button disabled states
        document.getElementById('btn-nav-start').disabled = (currentStep === minStep);
        document.getElementById('btn-nav-prev').disabled = (currentStep === minStep);
        const nextBtn = document.getElementById('btn-nav-next');
        if (nextBtn) {
            nextBtn.disabled = (currentStep === maxStep);
            nextBtn.textContent = (currentStep === maxStep - 1) ? 'Zu deinen Antworten →' : 'Weiter →';
        }

        if (isRio) {
            if (currentStep === 13) {
                document.getElementById('step-panel-0').style.display = 'block';
                document.getElementById('sidebar-step-indicator').textContent = 'Schritt 13 von 14';
                document.getElementById('sidebar-progress-bar').style.width = ((13 / 14) * 100) + '%';
                document.getElementById('sidebar-step-title').textContent = 'So funktioniert das Abenteuer';
                window.scrollTo({ top: 0, behavior: 'smooth' });
                return;
            } else if (currentStep === 14) {
                document.getElementById('step-panel-finish').style.display = 'block';
                document.getElementById('sidebar-step-indicator').textContent = 'Schritt 14 von 14';
                document.getElementById('sidebar-progress-bar').style.width = '100%';
                document.getElementById('sidebar-step-title').textContent = 'Antworten als PDF';
                populateCompiledAnswers();
                window.scrollTo({ top: 0, behavior: 'smooth' });
                return;
            }

            // Steps 1..12 correspond to Units 00..11
            const unitIndex = currentStep - 1;
            const unit = unitsData[unitIndex];
            document.getElementById('step-panel-unit').style.display = 'block';

            document.getElementById('sidebar-step-indicator').textContent = 'Schritt ' + currentStep + ' von 14';
            document.getElementById('sidebar-progress-bar').style.width = ((currentStep / 14) * 100) + '%';
            document.getElementById('sidebar-step-title').textContent = (unit.number ? unit.number + ' · ' : '') + unit.title;

            // Eyebrow
            document.getElementById('unit-eyebrow').textContent = unit.number + (unit.duration ? ' · ' + unit.duration : '');
            document.getElementById('unit-title').textContent = unit.title;
            document.getElementById('unit-summary').textContent = unit.summary || '';

            // Story Instruction Callout
            const story = storyInstructions[unit.number];
            const storyBox = document.getElementById('unit-story-instruction');
            if (story && storyBox) {
                document.getElementById('story-instruction-tag').textContent = story[0];
                document.getElementById('story-instruction-text').textContent = story[1];
                storyBox.style.display = 'grid';
            } else if (storyBox) {
                storyBox.style.display = 'none';
            }

            // Image & Caption
            const imgWrapper = document.getElementById('unit-image-wrapper');
            const imgEl = document.getElementById('unit-image');
            const captionEl = document.getElementById('unit-caption');

            if (unit.image) {
                imgEl.src = unit.image;
                captionEl.textContent = unit.caption || '';
                imgWrapper.className = 'protected-adventure-image' + 
                    (unit.number === '04' ? ' protected-adventure-image-complete' : '') +
                    (unit.number === '09' ? ' protected-adventure-image-ship' : '');
                imgWrapper.style.display = 'block';
            } else {
                imgWrapper.style.display = 'none';
            }

            // Audio Player
            const audioContainer = document.getElementById('unit-audio-container');
            const practiceContainer = document.getElementById('unit-practice-container');
            const mediaSubtitle = document.getElementById('unit-media-subtitle');
            const audioPlayer = document.getElementById('unit-audio-player');

            if (unit.audio && !unit.audio.includes('undefined')) {
                audioContainer.style.display = 'flex';
                practiceContainer.style.display = 'none';
                audioPlayer.style.display = 'block';
                audioPlayer.src = unit.audio;
                if (mediaSubtitle) mediaSubtitle.textContent = 'Direkt in dieser Kurseinheit abspielbar';
            } else {
                audioContainer.style.display = 'none';
                practiceContainer.style.display = 'flex';
                audioPlayer.removeAttribute('src');
            }

            // Rio Negro Unit 09 Pressespiegel
            const pressDoc = document.getElementById('rio-press-evidence');
            if (pressDoc) pressDoc.style.display = (unit.number === '09') ? 'grid' : 'none';

            // Dynamic Interactive Exercises
            document.getElementById('unit-interactive-exercises').innerHTML = buildInteractiveExercises(unit);

            window.scrollTo({ top: 0, behavior: 'smooth' });
            return;
        }

        // Standard Courses (0 = Start, 1..N = Units, N+1 = Finish)
        const stepDisplayNumber = currentStep + 1;
        document.getElementById('sidebar-step-indicator').textContent = 'Schritt ' + stepDisplayNumber + ' von ' + totalSteps;
        document.getElementById('sidebar-progress-bar').style.width = ((stepDisplayNumber / totalSteps) * 100) + '%';

        if (currentStep === 0) {
            document.getElementById('step-panel-0').style.display = 'block';
            document.getElementById('sidebar-step-title').textContent = 'Start & Arbeitsbuch';
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } else if (currentStep === totalSteps - 1) {
            document.getElementById('step-panel-finish').style.display = 'block';
            document.getElementById('sidebar-step-title').textContent = 'Antworten als PDF';
            populateCompiledAnswers();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } else {
            const unitIndex = currentStep - 1;
            const unit = unitsData[unitIndex];

            document.getElementById('step-panel-unit').style.display = 'block';
            document.getElementById('sidebar-step-title').textContent = (unit.number ? unit.number + ' · ' : '') + unit.title;

            document.getElementById('unit-eyebrow').textContent = (unit.number || ('Einheit ' + (unitIndex + 1))) + (unit.duration ? ' · ' + unit.duration : '');
            document.getElementById('unit-title').textContent = unit.title;
            document.getElementById('unit-summary').textContent = unit.summary || '';

            const storyBox = document.getElementById('unit-story-instruction');
            if (storyBox) storyBox.style.display = 'none';

            const imgWrapper = document.getElementById('unit-image-wrapper');
            if (unit.image) {
                document.getElementById('unit-image').src = unit.image;
                document.getElementById('unit-caption').textContent = unit.caption || '';
                imgWrapper.style.display = 'block';
            } else {
                imgWrapper.style.display = 'none';
            }

            // Audio Player vs Practice Station
            const audioContainer = document.getElementById('unit-audio-container');
            const practiceContainer = document.getElementById('unit-practice-container');
            const mediaSubtitle = document.getElementById('unit-media-subtitle');
            const audioPlayer = document.getElementById('unit-audio-player');

            if (unit.audio && !unit.audio.includes('undefined')) {
                audioContainer.style.display = 'flex';
                practiceContainer.style.display = 'none';
                audioPlayer.style.display = 'block';
                audioPlayer.src = unit.audio;
                if (mediaSubtitle) mediaSubtitle.textContent = 'Direkt in dieser Kurseinheit abspielbar';
            } else {
                audioContainer.style.display = 'none';
                practiceContainer.style.display = 'flex';
                audioPlayer.removeAttribute('src');
            }

            // Press evidence hidden for standard courses
            const pressDoc = document.getElementById('rio-press-evidence');
            if (pressDoc) pressDoc.style.display = 'none';

            // Dynamic Interactive Exercises (including radio buttons and main task)
            document.getElementById('unit-interactive-exercises').innerHTML = buildInteractiveExercises(unit);

            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }

    function populateCompiledAnswers() {
        const container = document.getElementById('compiled-answers-container');
        if (!container) return;

        const ans = getAnswers();
        const entries = Object.entries(ans).filter(([k, v]) => String(v).trim() !== '');

        // Rio Negro Safety Check Score
        if (isRio) {
            const safetyKeys = ['safety-kommunikation', 'safety-wasser', 'safety-wetterschutz', 'safety-orientierung', 'safety-erste-hilfe'];
            const safetyCount = safetyKeys.filter(k => ans[k] === 'Ja').length;
            const safetySec = document.getElementById('rio-safety-result');
            const safetyScore = document.getElementById('rio-safety-score');
            const safetyText = document.getElementById('rio-safety-text');
            if (safetySec && safetyScore && safetyText) {
                safetySec.style.display = 'grid';
                safetyScore.textContent = `${safetyCount} / 5`;
                safetyText.textContent = (safetyCount <= 2)
                    ? 'Die Basis ist noch nicht ausreichend gesichert.'
                    : (safetyCount <= 4)
                        ? 'Die Vorbereitung ist weit fortgeschritten; offene Punkte bleiben.'
                        : 'Alle fünf Prüfpunkte wurden bestätigt.';
            }
        }

        if (entries.length === 0) {
            container.innerHTML = '<p>Du hast noch keine Antworten eingetragen. Gehe zurück und bearbeite mindestens eine Aufgabe.</p>';
            return;
        }

        let html = '';
        entries.forEach(([key, val]) => {
            html += `
                <section>
                    <small>Frage / Aufgabe</small>
                    <h3>${escapeHtml(formatKeyLabel(key))}</h3>
                    <small>Antwort</small>
                    <p>${escapeHtml(val)}</p>
                </section>
            `;
        });

        container.innerHTML = html;
    }

    function sendFeedbackMail() {
        const rating = document.getElementById('feedback-rating')?.value || 'nicht angegeben';
        const technical = document.getElementById('feedback-technical')?.value || 'nicht angegeben';
        const issue = document.getElementById('feedback-issue')?.value || 'Kein Hinweis';
        const note = document.getElementById('feedback-note')?.value || 'Keine';

        const subject = encodeURIComponent(`Kursbewertung: ${courseTitle}`);
        const bodyLines = [
            `Kurs: ${courseTitle}`,
            `Bewertung: ${rating} von 5`,
            `Technik: ${technical}`,
            ``,
            `Technischer Hinweis:`,
            issue,
            ``,
            `Weitere Rückmeldung:`,
            note
        ];
        const body = encodeURIComponent(bodyLines.join('\n'));

        window.location.href = `mailto:mail@besseler.de?subject=${subject}&body=${body}`;
    }

    // Digital Workbook Controls (Step 0)
    function changeWbPage(delta) {
        const newPage = wbPage + delta;
        if (newPage >= 1 && newPage <= workbookTotalPages) {
            wbPage = newPage;
            const img = document.getElementById('workbook-page-img');
            const pageStr = String(wbPage).padStart(2, '0');
            img.src = `/workbooks/${workbookSlug}/page-${pageStr}.jpg`;
            document.getElementById('wb-page-display').textContent = `Seite ${wbPage} von ${workbookTotalPages}`;
            document.getElementById('wb-btn-prev').disabled = (wbPage === 1);
            document.getElementById('wb-btn-next').disabled = (wbPage === workbookTotalPages);
        }
    }

    function changeWbZoom(delta) {
        const newZoom = wbZoom + delta;
        if (newZoom >= 100 && newZoom <= 175) {
            wbZoom = newZoom;
            document.getElementById('workbook-page-img').style.width = wbZoom + '%';
            document.getElementById('wb-zoom-display').textContent = wbZoom + ' %';
        }
    }

    function toggleWbFullscreen() {
        const viewer = document.getElementById('protected-workbook-viewer');
        if (!document.fullscreenElement) {
            viewer.requestFullscreen().catch(err => alert('Vollbildmodus konnte nicht aktiviert werden.'));
        } else {
            document.exitFullscreen();
        }
    }

    function handleWorkbookImgError(img) {
        if (!img.src.endsWith('page-01.jpg')) {
            img.src = `/workbooks/${workbookSlug}/page-01.jpg`;
        }
    }

    document.addEventListener('keydown', function(e) {
        if (['TEXTAREA', 'INPUT', 'SELECT'].includes(document.activeElement.tagName)) return;
        if (e.key === 'ArrowLeft') goToPrevStep();
        if (e.key === 'ArrowRight') goToNextStep();
    });

    document.addEventListener('DOMContentLoaded', function() {
        renderCurrentStep();
    });
</script>

    {{-- Missbrauch melden Modal & Trigger --}}
    <div style="padding: 1.5rem 0; text-align: center; font-size: 0.75rem;">
        <button type="button" onclick="document.getElementById('abuse-modal').style.display='block'" style="background:none; border:none; color:#64748b; text-decoration:underline; cursor:pointer;">Missbrauch melden</button>
    </div>

    <div id="abuse-modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 99999; padding: 2rem;">
        <div style="background: #fff; max-width: 480px; margin: 5rem auto; padding: 2rem; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
            <h3 style="margin-top:0; color:#0f172a;">Missbrauch melden</h3>
            <p style="color:#475569; font-size:0.9rem; line-height:1.5;">Wenn Sie unbefugte Kopien, Screenshots oder Weitergaben dieses urheberrechtlich geschützten Kursmaterials bemerken, informieren Sie uns bitte vertraulich:</p>
            <p style="font-weight:700; color:#0284c7;">Dennis Besseler Support: web@besseler.de</p>
            <button type="button" onclick="document.getElementById('abuse-modal').style.display='none'" style="background:#0f172a; color:#fff; border:none; padding:0.5rem 1rem; border-radius:4px; font-weight:700; cursor:pointer;">Schließen</button>
        </div>
    </div>

</body>
</html>').style.display='none'" style="background:#0f172a; color:#fff; border:none; padding:0.5rem 1rem; border-radius:4px; font-weight:700; cursor:pointer;">Schließen</button>
        </div>
    </div>

</body>
</html>
