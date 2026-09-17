@extends('admin.layouts.app2')

@section('contents')
    <main class="admin-workspace" id="admin-page-top">
        {{-- Topbar (Reference A Exact Header with Role & Logout) --}}
        {{-- Topbar (Photo 1 Exact Header: • ADMIN-KONTO DENNIS BESSELER • KUNDENZUGÄNGE) --}}
        <header class="admin-topbar">
            <div>
                @if($isStaffPreview ?? false)
                    <span class="account-role-badge is-staff">MITARBEITER-KONTO</span>
                    <strong>ARBEITSFLÄCHE</strong>
                @else
                    <span class="account-role-badge is-admin">ADMIN-KONTO</span>
                    <strong>DENNIS BESSELER · KUNDENZUGÄNGE</strong>
                @endif
            </div>
            <nav>
                @if($isStaffPreview ?? false)
                    <a href="{{ route('admin.dashboard') }}">← ZURÜCK ZUR ADMIN-VERWALTUNG</a>
                @else
                    <a href="{{ route('home') }}" target="_blank" rel="noreferrer">
                        KURSPORTAL ÖFFNEN
                    </a>
                    <form method="POST" action="{{ route('verwaltung.logout') }}" style="display:inline; margin:0; padding:0;">
                        @csrf
                        <button type="submit" class="admin-logout-button">
                            ABMELDEN
                        </button>
                    </form>
                @endif
            </nav>
        </header>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div style="background:#14532d; color:#86efac; padding:1rem 1.5rem; border-radius:8px; margin:1rem 2rem; font-weight:500; display:flex; justify-content:space-between; align-items:center;">
                <span>✓ {{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div style="background:#7f1d1d; color:#fca5a5; padding:1rem 1.5rem; border-radius:8px; margin:1rem 2rem; font-weight:500;">
                ⚠ {{ session('error') }}
            </div>
        @endif

        {{-- Staff Temporary Credentials Banner --}}
        @if(session('staff_credentials'))
            @php $cred = session('staff_credentials'); @endphp
            <div class="credential-box staff-admin-credential" id="staff-credentials-box" style="margin:1rem 2rem;">
                <strong>{{ $cred['title'] ?? 'Mitarbeiterzugang – nur jetzt vollständig sichtbar' }}</strong>
                <p>Login: <b>{{ url('/mitarbeiter-login') }}</b></p>
                <p>Benutzername: <b>{{ $cred['username'] }}</b></p>
                <p>Passwort: <b>{{ $cred['password'] }}</b></p>
                <small>Den persönlichen Wiederherstellungscode richtet der Mitarbeiter nach der Anmeldung selbst ein. Er wird dem Administrator nicht angezeigt.</small>
                <button type="button" onclick="document.getElementById('staff-credentials-box').style.display='none'">Als sicher übermittelt markieren</button>
            </div>
        @endif

        {{-- Customer Temporary Credentials Banner --}}
        @if(session('reset_customer_credentials'))
            @php $cCred = session('reset_customer_credentials'); @endphp
            <div class="credential-box" id="customer-credentials-box" style="margin:1rem 2rem; background:#1e293b; border:2px solid #38bdf8; padding:1.25rem; border-radius:8px;">
                <strong style="color:#38bdf8;">Neues Kundenpasswort – Zugangsdaten jetzt sicher übermitteln</strong>
                <p style="margin:0.5rem 0;">Benutzername: <b>{{ $cCred['username'] }}</b></p>
                <p style="margin:0.5rem 0;">Neues Passwort: <b style="color:#4ade80;">{{ $cCred['password'] }}</b></p>
                <small style="color:#94a3b8;">Zugangsdaten über die in der Buchhaltung hinterlegte Kontaktmöglichkeit übermitteln.</small><br>
                <button type="button" onclick="document.getElementById('customer-credentials-box').style.display='none'" style="margin-top:0.75rem; background:#38bdf8; color:#0f172a; border:none; padding:6px 14px; border-radius:4px; font-weight:600; cursor:pointer;">Als sicher übermittelt markieren</button>
            </div>
        @endif

        @if(session('created_customer'))
            @php $newCust = session('created_customer'); @endphp
            <div style="background:#1e293b; border:2px solid #38bdf8; color:#f8fafc; padding:1.5rem; border-radius:8px; margin:1rem 2rem;">
                <h3 style="margin-top:0; color:#38bdf8;">✓ Neuer Kundenzugang erfolgreich erstellt</h3>
                <p style="margin-bottom:0.75rem;">Zugangsdaten bitte für die Übergabe kopieren:</p>
                <div style="background:#0f172a; padding:1rem; border-radius:6px; font-family:monospace; font-size:0.95rem;">
                    <strong>Vorname:</strong> {{ $newCust['name'] }}<br>
                    <strong>Benutzername:</strong> {{ $newCust['username'] }}<br>
                    <strong>Passwort:</strong> <span style="color:#4ade80; font-weight:bold;">{{ $newCust['password'] }}</span><br>
                    <strong>Rechnungs-Nr:</strong> {{ $newCust['invoice'] }}<br>
                    <strong>Login-URL:</strong> {{ url('/login') }}
                </div>
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div style="background:#7f1d1d; color:#fca5a5; padding:1rem 1.5rem; border-radius:8px; margin:1rem 2rem;">
                <ul style="margin:0; padding-left:1.25rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Index Navigation (Exact Reference A Styles from index-D96dYb_L.css) --}}
        <nav class="admin-index" id="admin-navigation" aria-label="Inhaltsverzeichnis">
            <div class="admin-index-links">
                @if(!($isStaffPreview ?? false) && Auth::user()->isAdmin())
                    <a href="#arbeitsmittel"><span>00</span> Bank &amp; Cloud</a>
                    <a href="#mitarbeiter"><span>MA</span> Mitarbeiter</a>
                    <a href="#hauptadmin-sicherheit"><span>SI</span> Admin-Sicherheit</a>
                    <a href="#datenaustausch"><span>DT</span> Datentausch</a>
                    <a href="#zugangsanfragen"><span>02</span> Anfragen</a>
                    <a href="#kunden"><span>03</span> Kunden</a>
                    <a href="#anlegen"><span>04</span> Anlegen</a>
                    <a href="#auslieferung"><span>05</span> Auslieferung</a>
                    <a href="#sicherheit"><span>06</span> Ablauf</a>
                    <a href="#naechste-version"><span>NV</span> Nächste Version</a>
                    <a href="#pinnwand"><span>01</span> Notizen</a>
                    <a href="https://dennisbesseler.papierkram.de/login?email=mail%40besseler.de" target="_blank" rel="noreferrer"><span>RE</span> Rechnungen</a>
                @else
                    {{-- Staff Navigation (Exact match to Reference A /verwaltung/mitarbeiter-vorschau) --}}
                    <a href="#arbeitsmittel"><span>00</span> Bank &amp; Cloud</a>
                    <a href="#sicherheit"><span>02</span> Sicherheit</a>
                    <a href="#anlegen"><span>03</span> Anlegen</a>
                    <a href="#kunden"><span>04</span> Bearbeiten</a>
                    <a href="#auslieferung"><span>05</span> Kurslinks</a>
                    <a href="#zugangsanfragen"><span>06</span> Support</a>
                    <a href="#pinnwand"><span>01</span> Notizen</a>
                    <a href="https://dennisbesseler.papierkram.de/login?email=mail%40besseler.de" target="_blank" rel="noreferrer"><span>RE</span> Rechnungen</a>
                @endif
            </div>

            <div class="work-timer is-compact">
                <button class="work-timer-toggle" id="admin-timer-toggle-btn" type="button" aria-expanded="false" onclick="toggleAdminWorkTimerPanel()">
                    <span id="admin-timer-toggle-label">Timer</span>
                    <b id="admin-timer-clock">00:00:00</b>
                </button>

                {{-- Timer Panel --}}
                <div class="work-timer-panel" id="admin-timer-panel" style="display: none;">
                    <div class="work-timer-panel-head">
                        <strong>Zeitmessung</strong>
                        <button type="button" aria-label="Timer minimieren" onclick="toggleAdminWorkTimerPanel(false)">
                            <span aria-hidden="true">×</span> Minimieren
                        </button>
                    </div>

                    {{-- Active Running Box --}}
                    <div class="work-timer-running" id="admin-timer-running-box" style="display: none;">
                        <span id="admin-timer-status-headline">Aktuelle Zeitmessung</span>
                        <strong id="admin-timer-active-subject">Kundenbetreuung</strong>
                        <div id="admin-timer-active-activities" style="font-size: 0.8rem; color: #334155; margin-top: 0.25rem;"></div>
                        <b id="admin-timer-big-clock" class="notranslate" translate="no">00:00:00</b>
                        <div style="display: flex; gap: 0.5rem; justify-content: center; margin-top: 0.5rem; flex-wrap: wrap;">
                            <button type="button" id="admin-timer-pause-btn" onclick="adminPauseTimer()" style="background: #d97706; color: #fff;">❚❚ Pausieren</button>
                            <button type="button" id="admin-timer-resume-btn" onclick="adminResumeTimer()" style="display: none; background: #16a34a; color: #fff;">▶ Fortsetzen</button>
                            <button type="button" onclick="adminStopTimer()" style="background: #bd1717; color: #fff;">Zeit stoppen</button>
                        </div>
                    </div>

                    {{-- Start Form (5 Eingabefelder für Tätigkeitsangaben entsprechend Referenz A) --}}
                    <form id="admin-timer-start-form" onsubmit="adminStartTimer(event)">
                        <label>
                            <span>1. Haupttätigkeit / Betreff *</span>
                            <input required maxlength="120" id="admin-timer-input-1" placeholder="Wofür wird die Zeit gestoppt? (z. B. Kundenbetreuung)">
                        </label>
                        <label>
                            <span>2. Tätigkeit / Vorgang</span>
                            <input maxlength="120" id="admin-timer-input-2" placeholder="Zusätzliche Tätigkeit oder Anlass">
                        </label>
                        <label>
                            <span>3. Tätigkeit / Bereich</span>
                            <input maxlength="120" id="admin-timer-input-3" placeholder="Zusätzlicher Arbeitsbereich / Grund">
                        </label>
                        <label>
                            <span>4. Tätigkeit / Details</span>
                            <input maxlength="120" id="admin-timer-input-4" placeholder="Zusätzlicher Vorgang / Ticket">
                        </label>
                        <label>
                            <span>5. Tätigkeit / Notiz</span>
                            <input maxlength="120" id="admin-timer-input-5" placeholder="Abschließende Notiz / Ergänzung">
                        </label>
                        @if(Auth::user()->isAdmin() && isset($staffMembers) && $staffMembers->count() > 0)
                        <label>
                            <span>Mitarbeiterzuordnung (Optional)</span>
                            <select id="admin-timer-staff-select">
                                <option value="">Für mich selbst erfassen ({{ Auth::user()->name }})</option>
                                @foreach($staffMembers as $staff)
                                    <option value="{{ $staff->id }}">{{ $staff->name }} ({{ $staff->username }})</option>
                                @endforeach
                            </select>
                        </label>
                        @endif
                        <button type="submit" id="admin-timer-start-submit-btn">Zeitmessung starten</button>
                    </form>

                    <p role="alert" id="admin-timer-alert" style="display: none;"></p>

                    {{-- History (Max 3 Completed Measurements - Rotation Rule Enforced) --}}
                    <div class="work-timer-history">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span>Die drei letzten Messungen</span>
                            <button type="button" onclick="copyTimerHistorySummary()" style="background: #ece9e2; color: #171715; font-size: 0.62rem; padding: 2px 6px; min-height: 24px; border: 1px solid #bbb7ae;">Kopieren</button>
                        </div>
                        <p class="work-timer-limit" role="note">
                            Wichtig: Es werden höchstens drei abgeschlossene Zeitmessungen gespeichert. Sobald eine vierte Messung abgeschlossen wird, wird der älteste Eintrag automatisch gelöscht.
                        </p>
                        <div id="admin-timer-history-container">
                            <small style="color:#64748b;">Noch keine abgeschlossene Zeitmessung.</small>
                        </div>
                    </div>

                    {{-- Send to Dennis --}}
                    <div class="work-timer-send">
                        <strong>An Dennis übergeben</strong>
                        <small>Es öffnet sich Ihr eigenes E-Mail-Programm. Das Portal versendet nichts automatisch.</small>
                        <label>
                            <input type="checkbox" id="admin-timer-cc-check" onchange="toggleAdminSendBtn()">
                            <span>Ich weiß, dass ich mir im geöffneten E-Mail-Programm über „Cc/Kopie“ eine Kopie an meine eigene Adresse senden kann.</span>
                        </label>
                        <button type="button" id="admin-timer-send-btn" disabled onclick="adminSendTimerMail()">E-Mail vorbereiten</button>
                    </div>
                </div>
            </div>

            <a class="portal-jump-arrow portal-jump-down" href="#admin-page-end" aria-label="Zum unteren Ende des Verwaltungsbereichs">
                <span aria-hidden="true">↓</span>
            </a>
        </nav>

        @if($isStaffPreview ?? false)
            <div class="staff-preview-banner" style="background: #fef3c7; color: #92400e; padding: 0.85rem clamp(1rem, 4vw, 4rem); font-weight: 700; font-size: 0.95rem; border-bottom: 1px solid #fde68a;">
                Schreibgeschützte Prüfansicht
            </div>
        @endif

        {{-- 00 Bank Card --}}
        <section class="admin-bank-card" id="arbeitsmittel" aria-labelledby="business-account-title">
            <div>
                <p class="eyebrow">Interne Zahlungsdaten</p>
                <h2 id="business-account-title">Geschäftskonto</h2>
                <p>Für Rechnung, Zahlungsabgleich und Kundenservice. Nicht öffentlich im Kundenportal anzeigen.</p>
            </div>
            <div class="admin-bank-value">
                <span>IBAN</span>
                <strong id="iban-text">DE25 2022 0800 0043 2794 71</strong>
            </div>
            <button type="button" onclick="copyToClipboard('DE25 2022 0800 0043 2794 71', this)">IBAN kopieren</button>
        </section>

        {{-- Cloud Card --}}
        <section class="admin-cloud-card" aria-labelledby="admin-cloud-title">
            <div>
                <p class="eyebrow">Gemeinsamer Arbeitsordner</p>
                <h2 id="admin-cloud-title">Drive-Cloud</h2>
                <code>https://drive.google.com/drive/folders/1KSr6zNf4IT3-Rq58Hj2mfr52ugJBq8Xk?usp=drive_link</code>
                <p>Für nicht sicherheitskritische Arbeitsdateien bis insgesamt 500 MB. Der Ordner bleibt privat; Mitarbeitende fordern über den Link Zugriff an und werden von Dennis freigegeben.</p>
                <small>Keine Passwörter, Zugangsdaten, vollständigen Bankdaten oder besonders sensiblen personenbezogenen Daten hochladen.</small>
            </div>
            <div>
                <a href="https://drive.google.com/drive/folders/1KSr6zNf4IT3-Rq58Hj2mfr52ugJBq8Xk?usp=drive_link" target="_blank" rel="noreferrer">Drive-Ordner öffnen</a>
                <button type="button" onclick="copyToClipboard('https://drive.google.com/drive/folders/1KSr6zNf4IT3-Rq58Hj2mfr52ugJBq8Xk?usp=drive_link', this)">Drive-Link kopieren</button>
            </div>
        </section>

        @if(!($isStaffPreview ?? false) && Auth::user()->isAdmin())
        {{-- Staff Portal Link Card --}}
        <section class="admin-staff-portal-link" aria-labelledby="staff-portal-link-title">
            <div>
                <p class="eyebrow">Direkter Mitarbeiterzugang</p>
                <h2 id="staff-portal-link-title">Mitarbeiter-Login</h2>
                <code>/mitarbeiter-login</code>
                <p>Diesen Link an Mitarbeiter weitergeben oder selbst zur Kontrolle öffnen.</p>
            </div>
            <div>
                <a href="{{ route('verwaltung.staff-preview') }}" target="_blank" rel="noreferrer">Arbeitsfläche prüfen</a>
                <a href="{{ route('staff.login') }}" target="_blank" rel="noreferrer">Mitarbeiter-Login öffnen</a>
                <button type="button" onclick="copyToClipboard('{{ url('/mitarbeiter-login') }}', this)">Link kopieren</button>
            </div>
        </section>
        @endif

        {{-- Hero Section --}}
        @if($isStaffPreview ?? false)
            <section class="staff-hero" style="padding: 3rem clamp(1rem, 4vw, 4rem); background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                <div>
                    <p class="eyebrow" style="color: #0284c7; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.08em; margin-bottom: 0.5rem;">Begrenzter Arbeitsbereich</p>
                    <h1 style="font-size: 2.5rem; font-weight: 700; line-height: 1.1; margin: 0 0 1rem; color: #0f172a;">Kundenzugänge<br>bearbeiten.</h1>
                    <p style="color: #64748b; font-size: 0.95rem; max-width: 600px; line-height: 1.5; margin: 0;">Nur die vom Administrator freigegebenen Tätigkeiten sind möglich. Mitarbeiterkonten, Berechtigungen und geschützte Kursinhalte sind technisch ausgeschlossen.</p>
                </div>
            </section>
        @else
            <section class="admin-hero">
                <p class="eyebrow">Kundenverwaltung</p>
                <h1>Kunden anlegen.<br/>Kurse freigeben.<br/>Zugänge steuern.</h1>
                <p>Wartungsarme Kundenverwaltung mit bewusst minimalen personenbezogenen Daten.</p>
                <div class="admin-warning">
                    <strong>Datensparsam aufgebaut</strong>
                    <span>Gespeichert werden nur Vorname, technischer Benutzername, Kunden-/Rechnungsnummer sowie Kurs-, Laufzeit- und Gerätedaten. Nach Ablauf der letzten Freigabe wird das Portalkonto automatisch gelöscht; die gesetzlich erforderliche Rechnung bleibt getrennt in der Buchhaltung.</span>
                </div>
            </section>
        @endif

        {{-- MA Mitarbeiter (Vollständige Mitarbeiterverwaltung entsprechend Referenz A) --}}
        @if(!($isStaffPreview ?? false) && Auth::user()->isAdmin())
        <section class="admin-section admin-staff" id="mitarbeiter">
            <header>
                <div>
                    <span>MA</span>
                    <p class="eyebrow">Nur Administrator</p>
                </div>
                <h2>Mitarbeiter sicher einsetzen.</h2>
            </header>
            <div class="staff-security-note">
                <strong>Strikte Trennung</strong>
                <span>Mitarbeiter erhalten einen eigenen zeitlich begrenzten Zugang. Sie sehen niemals Mitarbeiterkonten, Bankdaten oder kostenpflichtige Kursinhalte und können ihre Tätigkeit, Laufzeit oder Berechtigungen nicht selbst verändern.</span>
            </div>

            {{-- Create Staff Form --}}
            <form method="POST" action="{{ route('admin.staff.store') }}" class="admin-form-preview staff-admin-form">
                @csrf
                <label>
                    <span>Name</span>
                    <input type="text" name="name" required placeholder="z. B. Sarah Schmidt" value="{{ old('name') }}"/>
                </label>
                <label>
                    <span>Tätigkeit</span>
                    <input type="text" name="occupation" required placeholder="z. B. Kundenservice oder Freelancer" value="{{ old('occupation') }}"/>
                </label>
                <label>
                    <span>Benutzername</span>
                    <input type="text" name="username" required placeholder="z. B. sarah.service" value="{{ old('username') }}"/>
                </label>
                <label>
                    <span>Passwort optional</span>
                    <input type="password" name="password" autocomplete="new-password" maxLength="128" placeholder="Leer lassen: sicher erzeugen"/>
                    <small>10 bis 128 Zeichen, mindestens ein Buchstabe und eine Zahl. Leer lassen erzeugt automatisch ein sicheres Passwort.</small>
                </label>
                <label>
                    <span>Zugang ab</span>
                    <input type="date" name="access_from" required value="{{ old('access_from', date('Y-m-d')) }}"/>
                </label>
                <label>
                    <span>Zugang bis einschließlich</span>
                    <input type="date" name="access_until" required value="{{ old('access_until', date('Y-m-d', strtotime('+30 days'))) }}"/>
                </label>
                <fieldset class="staff-permissions">
                    <legend>Berechtigungen · nur hier durch den Administrator änderbar</legend>
                    <label><input type="checkbox" name="permissions[view_customers]" value="1" checked/><span>Kunden sehen und suchen</span></label>
                    <label><input type="checkbox" name="permissions[create_customers]" value="1" checked/><span>Kundenkonten anlegen · maximal 11 pro Tag</span></label>
                    <label><input type="checkbox" name="permissions[manage_courses]" value="1" checked/><span>Kursfreigaben und Laufzeiten verwalten</span></label>
                    <label><input type="checkbox" name="permissions[reset_passwords]" value="1" checked/><span>Kundenpasswörter neu erzeugen</span></label>
                    <label><input type="checkbox" name="permissions[manage_customer_status]" value="1" checked/><span>Kundenkonten aktivieren und sperren</span></label>
                </fieldset>
                <button type="submit">Mitarbeiterkonto verbindlich anlegen</button>
            </form>

            {{-- Existing Staff List --}}
            <div class="admin-staff-list">
                @forelse($staffMembers as $staff)
                    @php
                        $now = now()->startOfDay();
                        $startsAt = $staff->access_from ? $staff->access_from->startOfDay() : null;
                        $expiresAt = $staff->access_until ? $staff->access_until->endOfDay() : null;
                        if (!$staff->is_active) {
                            $statusText = 'Gesperrt';
                        } elseif ($startsAt && $startsAt->greaterThan($now)) {
                            $statusText = 'Vorgemerkt';
                        } elseif ($expiresAt && $expiresAt->lessThan($now)) {
                            $statusText = 'Abgelaufen';
                        } else {
                            $statusText = 'Aktiv';
                        }
                    @endphp
                    <article>
                        <header>
                            <div>
                                <span>{{ $statusText }}</span>
                                <h3>{{ $staff->name }}</h3>
                                <p>{{ $staff->username }}</p>
                            </div>
                            <b>{{ $staff->occupation ?: 'Mitarbeiter' }}</b>
                        </header>

                        <form method="POST" action="{{ route('admin.staff.update', $staff->id) }}" id="staff-form-{{ $staff->id }}">
                            @csrf
                            <div class="admin-staff-fields">
                                <label>
                                    <span>Name</span>
                                    <input type="text" name="name" value="{{ $staff->name }}" required>
                                </label>
                                <label>
                                    <span>Tätigkeit</span>
                                    <input type="text" name="occupation" value="{{ $staff->occupation }}" required>
                                </label>
                                <label>
                                    <span>Zugang ab</span>
                                    <input type="date" name="access_from" value="{{ $staff->access_from?->format('Y-m-d') }}" required>
                                </label>
                                <label>
                                    <span>Zugang bis</span>
                                    <input type="date" name="access_until" value="{{ $staff->access_until?->format('Y-m-d') }}" required>
                                </label>
                            </div>

                            <fieldset class="staff-permissions">
                                <legend>Berechtigungen</legend>
                                <label>
                                    <input type="checkbox" name="permissions[view_customers]" value="1" {{ $staff->hasPermission('view_customers') ? 'checked' : '' }}>
                                    <span>Kunden sehen und suchen</span>
                                </label>
                                <label>
                                    <input type="checkbox" name="permissions[create_customers]" value="1" {{ $staff->hasPermission('create_customers') ? 'checked' : '' }}>
                                    <span>Kundenkonten anlegen · maximal 11 pro Tag</span>
                                </label>
                                <label>
                                    <input type="checkbox" name="permissions[manage_courses]" value="1" {{ ($staff->hasPermission('manage_courses') || $staff->hasPermission('manage_enrollments')) ? 'checked' : '' }}>
                                    <span>Kursfreigaben und Laufzeiten verwalten</span>
                                </label>
                                <label>
                                    <input type="checkbox" name="permissions[reset_passwords]" value="1" {{ $staff->hasPermission('reset_passwords') ? 'checked' : '' }}>
                                    <span>Kundenpasswörter neu erzeugen</span>
                                </label>
                                <label>
                                    <input type="checkbox" name="permissions[manage_customer_status]" value="1" {{ ($staff->hasPermission('manage_customer_status') || $staff->hasPermission('toggle_active')) ? 'checked' : '' }}>
                                    <span>Kundenkonten aktivieren und sperren</span>
                                </label>
                            </fieldset>

                            <label class="staff-delete-confirm">
                                <input type="checkbox" id="staff-del-check-{{ $staff->id }}" onchange="document.getElementById('staff-del-btn-{{ $staff->id }}').disabled = !this.checked">
                                <span>Der Google-Drive-Zugriff dieses Mitarbeiters wurde entfernt.</span>
                            </label>

                            <footer>
                                <button type="submit">Änderungen speichern</button>
                                <button type="button" onclick="document.getElementById('staff-pw-form-{{ $staff->id }}').submit()">Neues Passwort</button>
                                <button type="button" onclick="document.getElementById('staff-toggle-form-{{ $staff->id }}').submit()">{{ $staff->is_active ? 'Zugang sperren' : 'Zugang mit neuen Daten aktivieren' }}</button>
                                <button class="danger-button" type="button" id="staff-del-btn-{{ $staff->id }}" disabled onclick="if(confirm('Mitarbeiterkonto unwiderruflich löschen?')) document.getElementById('staff-delete-form-{{ $staff->id }}').submit()">Mitarbeiterkonto löschen</button>
                            </footer>
                        </form>

                        <form id="staff-pw-form-{{ $staff->id }}" method="POST" action="{{ route('admin.staff.reset-password', $staff->id) }}" style="display:none;">
                            @csrf
                        </form>
                        <form id="staff-toggle-form-{{ $staff->id }}" method="POST" action="{{ route('admin.staff.toggle-active', $staff->id) }}" style="display:none;">
                            @csrf
                        </form>
                        <form id="staff-delete-form-{{ $staff->id }}" method="POST" action="{{ route('admin.staff.delete', $staff->id) }}" style="display:none;">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="drive_revoked_confirmed" value="1">
                        </form>
                    </article>
                @empty
                    <p class="staff-empty">Noch keine Mitarbeiterkonten angelegt.</p>
                @endforelse
            </div>

            {{-- Staff Time Tracking Overview Table --}}
            <div style="margin-top: 3rem; background: #ffffff; border: 1px solid #d6d1c7; border-radius: 4px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
                <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 0.5rem;">
                    <div>
                        <h3 style="font-size: 1.1rem; color: #11110f; margin: 0; font-weight: 700;">Erfasste Mitarbeiterzeiten &amp; Aktivitäten</h3>
                        <span style="font-size: 0.8rem; color: #64748b;">Übersicht der übertragenen Arbeitszeitmessungen für Abrechnung und Nachweis.</span>
                    </div>
                    <span style="font-size: 0.75rem; font-weight: 700; color: #0284c7; background: #e0f2fe; padding: 0.2rem 0.6rem; border-radius: 3px;">
                        Letzte {{ $staffTimeEntries->count() }} Einträge
                    </span>
                </div>

                @if($staffTimeEntries->count() > 0)
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem; text-align: left;">
                            <thead>
                                <tr style="border-bottom: 2px solid #e2e8f0; color: #475569; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.05em;">
                                    <th style="padding: 0.65rem 0.5rem;">Datum / Beginn</th>
                                    <th style="padding: 0.65rem 0.5rem;">Mitarbeiter</th>
                                    <th style="padding: 0.65rem 0.5rem;">Haupttätigkeit</th>
                                    <th style="padding: 0.65rem 0.5rem;">Tätigkeitsdetails</th>
                                    <th style="padding: 0.65rem 0.5rem; text-align: right;">Dauer</th>
                                    <th style="padding: 0.65rem 0.5rem; text-align: center;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($staffTimeEntries as $entry)
                                <tr style="border-bottom: 1px solid #f1f5f9; color: #1e293b;">
                                    <td style="padding: 0.65rem 0.5rem; font-weight: 600;">
                                        {{ $entry->started_at ? $entry->started_at->format('d.m.Y H:i') : '–' }}
                                    </td>
                                    <td style="padding: 0.65rem 0.5rem;">
                                        <strong>{{ $entry->assignedStaff->name ?? ($entry->user->name ?? 'Dennis') }}</strong>
                                    </td>
                                    <td style="padding: 0.65rem 0.5rem; font-weight: 500;">
                                        {{ $entry->activity_1 ?: ($entry->subject ?: ($entry->activity_description ?: '–')) }}
                                    </td>
                                    <td style="padding: 0.65rem 0.5rem; color: #64748b; font-size: 0.8rem; max-width: 320px;">
                                        @php
                                            $acts = $entry->activities_list;
                                        @endphp
                                        @if(count($acts) > 0)
                                            {{ implode(' · ', $acts) }}
                                        @elseif(is_array($entry->activities) && count($entry->activities) > 0)
                                            {{ implode(' · ', $entry->activities) }}
                                        @else
                                            –
                                        @endif
                                    </td>
                                    <td style="padding: 0.65rem 0.5rem; text-align: right; font-family: monospace; font-weight: 700; color: #0f172a;">
                                        {{ sprintf('%02d:%02d:%02d', floor($entry->duration_seconds / 3600), floor(($entry->duration_seconds % 3600) / 60), $entry->duration_seconds % 60) }}
                                    </td>
                                    <td style="padding: 0.65rem 0.5rem; text-align: center;">
                                        @if($entry->status === 'running')
                                            <span style="background: #dcfce7; color: #15803d; padding: 0.15rem 0.5rem; border-radius: 2px; font-size: 0.72rem; font-weight: 700;">Läuft</span>
                                        @elseif($entry->status === 'paused')
                                            <span style="background: #fef3c7; color: #b45309; padding: 0.15rem 0.5rem; border-radius: 2px; font-size: 0.72rem; font-weight: 700;">Pausiert</span>
                                        @else
                                            <span style="background: #f1f5f9; color: #475569; padding: 0.15rem 0.5rem; border-radius: 2px; font-size: 0.72rem; font-weight: 700;">Beendet</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p style="font-size: 0.85rem; color: #64748b; font-style: italic; margin: 0;">Bisher wurden keine Mitarbeiterzeiten erfasst.</p>
                @endif
            </div>
        </section>
        @endif

        {{-- NV Nächste Version (Dauerhaft) --}}
        @if(!($isStaffPreview ?? false) && Auth::user()->isAdmin())
        <section class="admin-section admin-version-pinboard" id="naechste-version" aria-labelledby="version-pinboard-title">
            <header>
                <div>
                    <span>NV</span>
                    <p class="eyebrow">Nur Dennis · dauerhaft</p>
                </div>
                <h2>Ideen für die nächste Portalversion</h2>
            </header>
            <p class="version-pinboard-intro">Dieser feste Planungsblock bleibt ausschließlich in Dennis’ Administrationsbereich sichtbar. Seine Einträge werden nicht automatisch gelöscht. Ein Eintrag kann nur nach ausdrücklicher Löschbestätigung entfernt werden.</p>
            
            <form method="POST" action="{{ route('admin.version-notes.store') }}" class="note-form version-note-form" id="version-pinboard-form">
                @csrf
                <input type="text" name="title" maxLength="120" placeholder="Kurzer Titel der Änderung" aria-label="Titel für die nächste Portalversion" required/>
                <textarea name="body" id="version-pinboard-body" maxLength="3000" rows="5" placeholder="Was soll bei der nächsten Portalversion geändert oder ergänzt werden?" aria-label="Änderungsidee für die nächste Portalversion" required></textarea>
                <button type="submit">Dauerhaft eintragen</button>
            </form>

            <div class="version-note-list">
                @forelse($versionNotes as $vNote)
                    <article class="version-note-card">
                        <span>Dauerhafter Planungseintrag</span>
                        <h3>{{ $vNote->title }}</h3>
                        <p>{{ $vNote->body }}</p>
                        <footer>
                            <form method="POST" action="{{ route('admin.version-notes.delete', $vNote->id) }}" onsubmit="return confirm('Möchten Sie diesen dauerhaften Eintrag wirklich entfernen?');">
                                @csrf
                                @method('DELETE')
                                <button class="danger-button" type="submit">Löschen · Bestätigung nötig</button>
                            </form>
                        </footer>
                    </article>
                @empty
                    <p class="version-note-empty">Noch keine Änderung für die nächste Portalversion eingetragen.</p>
                @endforelse
            </div>
        </section>
        @endif

        {{-- 01 Notizen (10-Tage automatische Löschung) --}}
        <section class="admin-section admin-service admin-pinboard" id="pinnwand">
            <header>
                <div>
                    <span>01</span>
                    <p class="eyebrow">{{ ($isStaffPreview ?? false) ? 'Persönliche Notizen' : 'Persönliche Admin-Notizen' }}</p>
                </div>
                <h2>Eigene Arbeitsnotizen festhalten.</h2>
            </header>
            <p class="pinboard-intro">
                @if($isStaffPreview ?? false)
                    Nur du siehst diese Notizen. Andere Mitarbeitende und der Administrator sehen sie in ihren Portalen nicht. Es bleiben höchstens fünf persönliche Notizen gespeichert; jede Notiz wird nach zehn Tagen automatisch gelöscht.
                @else
                    Nur dein Administratorkonto sieht diese Notizen. Mitarbeiterkonten sehen sie nicht. Maximal fünf persönliche Notizen bleiben gespeichert; nach zehn Tagen werden sie automatisch gelöscht.
                @endif
            </p>
            
            <form method="POST" action="{{ route('admin.notes.store') }}" class="note-form" id="admin-pinboard-form">
                @csrf
                <input type="text" name="title" maxLength="120" placeholder="Kurzer Titel" aria-label="Titel der persönlichen Admin-Notiz" required/>
                <textarea name="body" id="admin-pinboard-body" maxLength="2000" rows="4" placeholder="Eigene Erinnerung, Aufgabe oder Arbeitsnotiz" aria-label="Inhalt der persönlichen Admin-Notiz" required></textarea>
                <button type="submit">Notiz speichern</button>
            </form>

            <div class="note-board" style="margin-top:1.5rem; display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:1rem;">
                @forelse($adminNotes as $note)
                    <div style="background:#1e293b; padding:1.25rem; border-radius:8px; border:1px solid #334155; position:relative;">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                            <strong style="color:#f8fafc;">{{ $note->title }}</strong>
                            <form method="POST" action="{{ route('admin.notes.delete', $note->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background:none; border:none; color:#94a3b8; cursor:pointer; font-size:1.1rem;">×</button>
                            </form>
                        </div>
                        <p style="color:#cbd5e1; font-size:0.95rem; margin-top:0.5rem; white-space:pre-wrap;">{{ $note->body }}</p>
                        <small style="color:#64748b; font-size:0.75rem;">Läuft ab am: {{ $note->expires_at?->format('d.m.Y') ?: 'In 10 Tagen' }}</small>
                    </div>
                @empty
                    <p style="grid-column:1/-1; color:#94a3b8;">Keine aktiven Notizen vorhanden.</p>
                @endforelse
            </div>
        </section>

        @if(!($isStaffPreview ?? false) && Auth::user()->isAdmin())
        {{-- DT Datentausch (Exact Position 5 in Reference A) --}}
        <section class="admin-section cloud-transfer" id="datenaustausch" aria-labelledby="admin-cloud-transfer-title">
            <header>
                <div>
                    <span>DT</span>
                    <p class="eyebrow">Gemeinsamer Arbeitsordner</p>
                </div>
                <h2 id="admin-cloud-transfer-title">Dateien einfach übergeben.</h2>
            </header>
            <div class="cloud-transfer-grid">
                <div class="cloud-transfer-main">
                    <span>Externer Google-Drive-Ordner</span>
                    <h3>Nicht vertrauliche Arbeitsdateien austauschen</h3>
                    <p>Der Ordner öffnet sich außerhalb des Portals und bleibt bei Google auf „Eingeschränkt“. Mitarbeiter werden von Dennis einzeln mit ihrem Google-Konto freigegeben. Alle freigegebenen Bearbeiter können die dort abgelegten Dateien grundsätzlich sehen, verändern und löschen.</p>
                    <a href="https://drive.google.com/drive/folders/1KSr6zNf4IT3-Rq58Hj2mfr52ugJBq8Xk?usp=drive_link" target="_blank" rel="noreferrer">Google-Drive-Ordner öffnen ↗</a>
                </div>
                <div class="cloud-transfer-rules">
                    <strong>Verbindliche Arbeitsregeln</strong>
                    <ul>
                        <li>Maximal 500 MB je Datenübergabe.</li>
                        <li>Keine Passwörter, Zugangsdaten oder Wiederherstellungscodes.</li>
                        <li>Keine Kunden-, Rechnungs-, Gesundheits- oder sonstigen personenbezogenen Daten.</li>
                        <li>Keine weiteren Personen selbst für den Ordner freigeben.</li>
                        <li>Dateien eindeutig benennen und nach Abschluss wieder entfernen.</li>
                    </ul>
                    <small>Die 500-MB-Grenze ist eine Arbeitsregel. Sie wird weder vom Portal noch vom öffentlichen Drive-Link technisch erzwungen.</small>
                </div>
            </div>
        </section>
        @endif

        {{-- 02 Zugangsanfragen --}}
        <section class="admin-section admin-service" id="zugangsanfragen">
            <header>
                <div>
                    <span>02</span>
                    <p class="eyebrow">Zugangsanfragen</p>
                </div>
                <h2>Vergessene Zugangsdaten bearbeiten.</h2>
            </header>
            <div style="margin-top:1rem;">
                @forelse($accessRequests as $req)
                    <div style="background:#1e293b; padding:1.25rem; border-radius:8px; margin-bottom:1rem; border:1px solid #eab308; display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <strong style="color:#facc15; font-size:1.05rem;">Anfrage von: {{ $req->username ?: $req->first_name }}</strong>
                            <span style="color:#cbd5e1; margin-left:0.5rem;">(Rechnung: {{ $req->invoice_number ?: 'Keine Angabe' }})</span>
                            <div style="color:#94a3b8; font-size:0.9rem; margin-top:0.25rem;">
                                Kurs: <strong>{{ $req->course_name ?: 'Allgemein' }}</strong> · E-Mail: {{ $req->email ?: 'Keine' }} · Datum: {{ $req->created_at->format('d.m.Y H:i') }}
                            </div>
                            @if($req->note)
                                <p style="color:#e2e8f0; font-size:0.85rem; margin-top:0.5rem; background:#0f172a; padding:0.5rem; border-radius:4px;">{{ $req->note }}</p>
                            @endif
                        </div>
                        <div style="display:flex; gap:0.5rem;">
                            <form method="POST" action="{{ route('admin.access-requests.resolve', $req->id) }}">
                                @csrf
                                <button type="submit" style="background:#16a34a; color:#fff; border:none; padding:0.5rem 0.9rem; border-radius:4px; cursor:pointer;">Als erledigt markieren</button>
                            </form>
                            <form method="POST" action="{{ route('admin.access-requests.delete', $req->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background:#dc2626; color:#fff; border:none; padding:0.5rem 0.9rem; border-radius:4px; cursor:pointer;">Löschen</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="admin-empty">
                        <strong>Keine offenen Anfragen</strong>
                        <p>Neue Anfragen aus dem Kundenlogin erscheinen automatisch an dieser Stelle.</p>
                    </div>
                @endforelse
            </div>
        </section>

        {{-- 03 Kundenkonten (Vollständige Kundenverwaltung entsprechend Referenz A) --}}
        <section class="admin-section" id="kunden">
            <header>
                <div>
                    <span>03</span>
                    <p class="eyebrow">Kundenkonten ({{ $customers->count() }})</p>
                </div>
                <h2>Alle Zugänge auf einen Blick.</h2>
            </header>
            
            <div class="admin-toolbar">
                <label>
                    <span>Kunden suchen</span>
                    <input type="search" placeholder="Vorname, Benutzername oder Rechnungsnummer" value="{{ $search }}" oninput="filterCustomerCards(this.value)" id="customer-search-input"/>
                </label>
                <a class="admin-primary-link" href="#anlegen">Neuen Kundenzugang anlegen</a>
            </div>

            <div class="customer-list">
                @forelse($customers as $customer)
                    <article class="customer-card {{ $customer->is_active ? '' : 'is-inactive' }}">
                        <header>
                            <div>
                                <span>Vorname</span>
                                <h3>{{ $customer->first_name ?: $customer->name }}</h3>
                            </div>
                            <div class="customer-status">
                                <b>{{ $customer->is_active ? 'Konto aktiv' : 'Konto gesperrt' }}</b>
                                <b>{{ $customer->device_id ? 'Gerät gebunden' : 'Noch kein Gerät' }}</b>
                            </div>
                        </header>

                        <dl>
                            <div>
                                <dt>Benutzername</dt>
                                <dd>{{ $customer->username }}</dd>
                            </div>
                            <div>
                                <dt>Kunden-/Rechnungsnummer</dt>
                                <dd>{{ $customer->invoice_number ?: 'N/A' }}</dd>
                            </div>
                        </dl>

                        {{-- Active Enrollments (Reference A 6-column Grid) --}}
                        <div class="customer-enrollments">
                            @forelse($customer->enrollments as $enrollment)
                                <div>
                                    <span>{{ $enrollment->course?->catalog_title ?: $enrollment->course?->title }}</span>
                                    <small>{{ $enrollment->is_active ? 'Aktiv' : 'Gesperrt' }} · {{ $enrollment->started_at?->format('d.m.Y') }} bis {{ $enrollment->expires_at?->format('d.m.Y') }}</small>

                                    <form method="POST" action="{{ route('admin.enrollments.update', $enrollment->id) }}" style="display: contents;">
                                        @csrf
                                        <label>
                                            <span>Startdatum</span>
                                            <input type="date" name="starts_at" value="{{ $enrollment->started_at?->format('Y-m-d') }}" required/>
                                        </label>
                                        <label>
                                            <span>Enddatum</span>
                                            <input type="date" name="expires_at" value="{{ $enrollment->expires_at?->format('Y-m-d') }}" required/>
                                        </label>
                                        <button type="submit">Termine speichern</button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.enrollments.toggle', $enrollment->id) }}" style="display: contents;">
                                        @csrf
                                        <button type="submit">{{ $enrollment->is_active ? 'Kurs sperren' : 'Kurs aktivieren' }}</button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.enrollments.immediate-start', $enrollment->id) }}" style="display: contents;">
                                        @csrf
                                        <label class="early-start-confirmation">
                                            <input type="checkbox" name="early_start_agreed" value="1" id="early-check-{{ $enrollment->id }}" onchange="document.getElementById('early-btn-{{ $enrollment->id }}').disabled = !this.checked"/>
                                            <span>Ausdrückliche Kundenerklärung zum vorzeitigen Beginn liegt dokumentiert vor.</span>
                                        </label>
                                        <button class="early-start-button" type="submit" id="early-btn-{{ $enrollment->id }}" disabled>
                                            Sofortstart mit voller Laufzeit setzen
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <p>Noch kein Kurs freigeschaltet.</p>
                            @endforelse
                        </div>

                        {{-- Additional Course Assignment (Reference A 4-column Grid) --}}
                        <form method="POST" action="{{ route('admin.customers.assign-course', $customer->id) }}" class="customer-assignment" id="assign-form-{{ $customer->id }}">
                            @csrf
                            <select name="course_slug" id="assign-course-{{ $customer->id }}" onchange="updateAssignCourseDates({{ $customer->id }})" required>
                                <option value="">Kurs auswählen</option>
                                @foreach($courses->where('order', '<=', 11)->sortBy('order') as $c)
                                    <option value="{{ $c->slug }}" data-duration="{{ $c->duration_days ?: 120 }}">{{ $c->catalog_title }}</option>
                                @endforeach
                            </select>
                            <input type="date" name="starts_at" id="assign-start-{{ $customer->id }}" value="{{ date('Y-m-d', strtotime('+14 days')) }}" required aria-label="Startdatum" onchange="recalcAssignCourseEndDate({{ $customer->id }})"/>
                            <input type="date" name="expires_at" id="assign-end-{{ $customer->id }}" value="{{ date('Y-m-d', strtotime('+134 days')) }}" required aria-label="Enddatum"/>
                            <button type="submit" id="assign-submit-btn-{{ $customer->id }}">Kurs freigeben</button>
                            <small id="assign-hint-{{ $customer->id }}">Standard: Start in 14 Tagen · beide Termine frei änderbar</small>
                            <label class="early-start-confirmation assignment-early-start">
                                <input type="checkbox" name="early_start_confirmed" value="1" id="assign-early-check-{{ $customer->id }}" onchange="document.getElementById('assign-early-btn-{{ $customer->id }}').disabled = !this.checked"/>
                                <span>Ausdrückliche Kundenerklärung zum vorzeitigen Beginn liegt dokumentiert vor.</span>
                            </label>
                            <button class="early-start-button" type="submit" name="is_immediate" value="1" id="assign-early-btn-{{ $customer->id }}" disabled>
                                Sofortstart mit voller Laufzeit freigeben
                            </button>
                        </form>

                        {{-- Card Footer Buttons --}}
                        <footer>
                            <form method="POST" action="{{ route('admin.customers.reset-password', $customer->id) }}" onsubmit="return confirm('Neues sicheres Passwort für {{ $customer->first_name }} ({{ $customer->username }}) erzeugen? Alle bestehenden Sitzungen werden beendet.');" style="display:inline;">
                                @csrf
                                <button type="submit">Neues Passwort</button>
                            </form>
                            @if($customer->device_id)
                                <form method="POST" action="{{ route('admin.customers.reset-device', $customer->id) }}" onsubmit="return confirm('Gerätebindung für {{ $customer->username }} zurücksetzen?');" style="display:inline;">
                                    @csrf
                                    <button type="submit">Gerät freigeben</button>
                                </form>
                            @else
                                <button type="button" disabled style="opacity:0.45; cursor:not-allowed;" title="Kunde hat sich noch mit keinem Gerät eingeloggt">Gerät freigeben</button>
                            @endif
                            <form method="POST" action="{{ route('admin.customers.toggle', $customer->id) }}" style="display:inline;">
                                @csrf
                                <button type="submit">{{ $customer->is_active ? 'Konto sperren' : 'Konto aktivieren' }}</button>
                            </form>
                            @if(Auth::user()->isAdmin())
                                <form method="POST" action="{{ route('admin.customers.delete', $customer->id) }}" onsubmit="return confirm('Kundenkonto {{ $customer->first_name }} ({{ $customer->invoice_number }}) vollständig löschen?\n\nKurse, Gerätebindung und alle Sitzungen werden unwiderruflich entfernt.');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="danger-button">Konto vollständig löschen</button>
                                </form>
                            @endif
                        </footer>
                    </article>
                @empty
                    <div class="admin-empty">
                        <strong>Noch keine Kundenkonten angelegt</strong>
                        <p>Neue Zugänge können direkt im nächsten Abschnitt erstellt und einem Kurs zugewiesen werden.</p>
                    </div>
                @endforelse
                <div class="admin-empty" id="customer-filter-empty" style="display:none;">
                    <strong>Kein passender Kunde gefunden</strong>
                    <p>Überprüfen Sie Ihre Sucheingabe nach Vorname, Benutzername oder Rechnungsnummer.</p>
                </div>
            </div>
        </section>

        {{-- 04 Anlegen (1:1 from Reference A VerwaltungClient) --}}
        <section class="admin-section admin-public" id="anlegen">
            <header>
                <div>
                    <span>04</span>
                    <p class="eyebrow">Zugang anlegen</p>
                </div>
                <h2>Nur das Nötigste speichern.</h2>
            </header>
            
            <form method="POST" action="{{ route('admin.customers.store') }}" class="admin-form-preview" id="admin-create-customer-form">
                @csrf
                <label>
                    <span>Vorname</span>
                    <input type="text" name="first_name" required placeholder="Nur Vorname" value="{{ old('first_name') }}"/>
                </label>
                <label>
                    <span>Technischer Benutzername</span>
                    <input type="text" name="username" required placeholder="Eindeutiger Loginname" value="{{ old('username') }}"/>
                </label>
                <label>
                    <span>Kunden-/Rechnungsnummer</span>
                    <input type="text" name="invoice_number" required placeholder="Rückverfolgung nur über Buchhaltung" value="{{ old('invoice_number') }}"/>
                </label>
                <label>
                    <span>Passwort (optional)</span>
                    <input type="password" name="password" autocomplete="new-password" placeholder="Leer lassen: wird sicher erzeugt"/>
                    <small>Eigenes Passwort: mindestens 10 Zeichen. Leer lassen erzeugt automatisch ein sicheres Passwort.</small>
                </label>
                <label>
                    <span>Kurs zuweisen (optional)</span>
                    <select name="course_slug" id="new-cust-course-select" onchange="handleNewCustCourse(this)">
                        <option value="">Noch keinen Kurs zuweisen</option>
                        @foreach($courses->where('order', '<=', 11)->sortBy('order') as $course)
                            <option value="{{ $course->slug }}" data-duration="{{ $course->duration_days ?: 120 }}" {{ old('course_slug') == $course->slug ? 'selected' : '' }}>
                                {{ $course->catalog_title }}
                            </option>
                        @endforeach
                    </select>
                </label>
                <label>
                    <span>Startdatum · Standard plus 14 Tage</span>
                    <input type="date" name="start_date" id="new-cust-start-date" value="{{ old('start_date', date('Y-m-d', strtotime('+14 days'))) }}" onchange="recalcNewCustEnd()"/>
                    <small>Bei dokumentiertem vorzeitigem Beginn frei änderbar.</small>
                </label>
                <label>
                    <span>Enddatum</span>
                    <input type="date" name="expires_on" id="new-cust-end-date" value="{{ old('expires_on', date('Y-m-d', strtotime('+134 days'))) }}"/>
                    <small id="new-cust-duration-hint">Wird nach der Kursauswahl berechnet.</small>
                </label>
                <label class="early-start-confirmation">
                    <input type="checkbox" name="early_start" value="1" id="new-cust-early-check" onchange="document.getElementById('new-cust-early-btn').disabled = !this.checked" {{ old('early_start') ? 'checked' : '' }}/>
                    <span>Ausdrückliche Kundenerklärung zum vorzeitigen Beginn liegt dokumentiert vor.</span>
                </label>
                <button class="early-start-button" type="submit" id="new-cust-early-btn" disabled name="immediate_start" value="1">
                    Sofortstart mit voller Laufzeit und Konto anlegen
                </button>
                <button type="submit">
                    Kundenkonto sicher anlegen
                </button>
            </form>
        </section>

        {{-- 05 Auslieferung (1:1 from Reference A VerwaltungClient) --}}
        <section class="admin-section admin-public" id="auslieferung">
            <header>
                <div>
                    <span>05</span>
                    <p class="eyebrow">Auslieferung und Support</p>
                </div>
                <h2>Kundenwege öffnen und Adressen kopieren.</h2>
            </header>

            {{-- 1. Main Delivery Login Card --}}
            <div class="delivery-login-card">
                <div>
                    <span>Wichtigste Kundenadresse</span>
                    <strong>Kunden-Anmeldung</strong>
                    <code>{{ url('/login') }}</code>
                    <p>Diese Adresse erhält der Kunde für die Anmeldung in seinem freigeschalteten Kursbereich.</p>
                </div>
                <div>
                    <a href="{{ url('/login') }}" target="_blank" rel="noreferrer">Anmeldeseite öffnen</a>
                    <button type="button" onclick="copyToClipboard('{{ url('/login') }}', this)">Adresse kopieren</button>
                </div>
            </div>

            {{-- 2. Delivery Course Directory (Geschützte Kursauslieferung) --}}
            <div class="delivery-course-directory">
                <div class="delivery-course-heading">
                    <strong>Geschützte Kursauslieferung</strong>
                    <span>Als Administrator öffnest du hier die echte Kursansicht mit einer klar gekennzeichneten Admin-Prüfansicht.</span>
                </div>
                @foreach($courses->where('order', '<=', 11)->sortBy('order') as $course)
                    <article>
                        <div>
                            <strong>{{ $course->catalog_title }}</strong>
                            <span>Nur interne Administrator-Prüfansicht</span>
                        </div>
                        <nav aria-label="Auslieferung {{ $course->catalog_title }}">
                            <a href="{{ url('/kurs/' . $course->slug) }}" target="_blank" rel="noreferrer">Wie der Kunde ansehen</a>
                        </nav>
                    </article>
                @endforeach
            </div>

            {{-- 3. Public Course Directory (Kursseiten) --}}
            <div class="public-course-directory">
                <div class="delivery-course-heading">
                    <strong>Kursseiten</strong>
                    <span>Je Kurs getrennt: öffentliche Kursseite auf der Website und echter geschützter Kurszugang in diesem Portal.</span>
                </div>
                @foreach($courses->where('order', '<=', 11)->sortBy('order') as $course)
                    <article>
                        <strong>{{ $course->catalog_title }}</strong>
                        <div class="public-course-address">
                            <span>Öffentliche Kursseite</span>
                            <code>{{ $course->public_course_url }}</code>
                            <a href="{{ $course->public_course_url }}" target="_blank" rel="noreferrer">Öffnen</a>
                            <button type="button" onclick="copyToClipboard('{{ $course->public_course_url }}', this)">Kopieren</button>
                        </div>
                        <div class="public-course-address">
                            <span>Echter Kurszugang</span>
                            <code>{{ url('/kurs/' . $course->slug) }}</code>
                            <a href="{{ url('/kurs/' . $course->slug) }}" target="_blank" rel="noreferrer">Öffnen</a>
                            <button type="button" onclick="copyToClipboard('{{ url('/kurs/' . $course->slug) }}', this)">Kopieren</button>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- 4. Directory Intro & Stats --}}
            <p class="admin-directory-intro">Hier sind sämtliche vorhandenen Oberflächen direkt erreichbar. Echte Mitarbeiter- und Kundenbereiche bleiben geschützt; dafür stehen dem Administrator gekennzeichnete Prüfansichten zur Verfügung.</p>
            <div class="admin-overview-status">
                <span><b>9</b> extern erreichbare Portalseiten</span>
                <span><b>{{ 9 + $courses->count() }}</b> interne Arbeits- und Prüfansichten</span>
            </div>

            {{-- 5. 1:1 Link Panels from Reference A --}}
            <div class="admin-communication-grid">
                <section class="admin-link-panel is-external">
                    <header>
                        <span>Extern veröffentlicht</span>
                        <strong>Kunden und Interessenten</strong>
                    </header>
                    <nav aria-label="Extern veröffentlichte Portalseiten">
                        <a href="{{ route('home') }}" target="_blank" rel="noreferrer"><span>Portalstart</span><b>↗</b></a>
                        <a href="{{ route('login') }}" target="_blank" rel="noreferrer"><span>Kundenlogin</span><b>↗</b></a>
                        <a href="{{ route('forgot-password') }}" target="_blank" rel="noreferrer"><span>Passwort vergessen</span><b>↗</b></a>
                        <a href="{{ route('payment') }}" target="_blank" rel="noreferrer"><span>Zahlung</span><b>↗</b></a>
                        <a href="{{ route('payment-participation') }}" target="_blank" rel="noreferrer"><span>Zahlungsbedingungen</span><b>↗</b></a>
                        <a href="{{ route('service-rio-negro') }}" target="_blank" rel="noreferrer"><span>Rio-Negro-Service</span><b>↗</b></a>
                        <a href="{{ route('copy-protection') }}" target="_blank" rel="noreferrer"><span>Kopierschutz</span><b>↗</b></a>
                        <a href="{{ route('privacy-policy') }}" target="_blank" rel="noreferrer"><span>Datenschutz</span><b>↗</b></a>
                        <a href="{{ route('imprint') }}" target="_blank" rel="noreferrer"><span>Impressum</span><b>↗</b></a>
                    </nav>
                </section>
                <section class="admin-link-panel is-internal">
                    <header>
                        <span>Arbeits- und Prüfansichten</span>
                        <strong>Verwaltung, Mitarbeiter und Testseiten</strong>
                    </header>
                    <nav aria-label="Interne Arbeits- und Prüfansichten">
                        <a href="{{ route('admin.dashboard') }}" target="_blank" rel="noreferrer"><span>Kundenverwaltung</span><b>↗</b></a>
                        <a href="{{ route('staff.login') }}" target="_blank" rel="noreferrer"><span>Mitarbeiterlogin</span><b>↗</b></a>
                        <a href="{{ route('verwaltung.staff-preview') }}" target="_blank" rel="noreferrer"><span>Mitarbeiter-Arbeitsfläche · Admin-Prüfansicht</span><b>↗</b></a>
                        <a href="{{ route('staff.workspace') }}" target="_blank" rel="noreferrer"><span>Mitarbeiterbereich · nach Login</span><b>↗</b></a>
                        <a href="{{ route('staff.forgot-password') }}" target="_blank" rel="noreferrer"><span>Mitarbeiterpasswort wiederherstellen</span><b>↗</b></a>
                        <a href="{{ route('verwaltung.audio-website') }}" target="_blank" rel="noreferrer"><span>Rio-Negro-Audio-Struktur</span><b>↗</b></a>
                        <a href="{{ route('kurs-test') }}" target="_blank" rel="noreferrer"><span>Allgemeine Kurs-Testseite</span><b>↗</b></a>
                        <a href="{{ route('kurs-test.nutrition') }}" target="_blank" rel="noreferrer"><span>Ernährung · Testseite</span><b>↗</b></a>
                        <a href="{{ route('kurs-test.press') }}" target="_blank" rel="noreferrer"><span>Presse &amp; Öffentlichkeit · Testseite</span><b>↗</b></a>
                    </nav>
                    <div class="admin-compact-courses">
                        <strong>Geschützte Kundenkurse</strong>
                        @foreach($courses->where('order', '<=', 11)->sortBy('order') as $c)
                            <div>
                                <span>{{ $c->catalog_title }}</span>
                                <nav>
                                    <a href="{{ route('course.show', $c->slug) }}" target="_blank" rel="noreferrer">Kundenkurs</a>
                                </nav>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
        </section>

        {{-- ME Medien & Kursinhalte verwalten (Audio, PDF, Video, Text) --}}
        @if(!($isStaffPreview ?? false) && Auth::user()->isAdmin())
        <section class="admin-section admin-public" id="medien" style="margin-top: 2rem;">
            <header>
                <div>
                    <span>ME</span>
                    <p class="eyebrow">Kursinhalte &amp; Dateiverwaltung</p>
                </div>
                <h2>Audio-, PDF- und Video-Lektionen hochladen.</h2>
            </header>

            <div style="background: #ffffff; border: 1px solid #d6d1c7; border-radius: 6px; padding: 1.5rem; margin-bottom: 2rem; box-shadow: 0 4px 12px rgba(0,0,0,0.04);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <strong style="font-size: 1.05rem; color: #0f172a; display: block;">Kurs auswählen für Lektionen &amp; Upload</strong>
                        <span style="font-size: 0.8rem; color: #64748b;">Wählen Sie einen Kurs aus, um vorhandene Lektionen anzuzeigen oder neue Audio- und PDF-Inhalte hochzuladen.</span>
                    </div>
                    <div style="min-width: 260px;">
                        <select id="media-course-selector" onchange="switchMediaCourse(this.value)" style="width: 100%; padding: 8px 12px; border: 1px solid #bbb7ae; font-size: 0.88rem; font-weight: 600; background: #fff; color: #1e293b;">
                            @foreach($courses as $cIdx => $c)
                                <option value="{{ $c->id }}" {{ $cIdx === 0 ? 'selected' : '' }}>
                                    {{ $c->catalog_title ?: $c->title }} ({{ $c->lessons_count }} Lektionen)
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Course Lessons Lists --}}
                @foreach($courses as $cIdx => $c)
                    <div class="media-course-content-panel" id="course-media-panel-{{ $c->id }}" style="{{ $cIdx === 0 ? '' : 'display: none;' }}">
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.75rem; border-bottom: 1px solid #e2e8f0; margin-bottom: 1rem;">
                            <span style="font-weight: 700; color: #334155; font-size: 0.9rem;">
                                Vorhandene Lektionen in "{{ $c->catalog_title ?: $c->title }}" ({{ $c->lessons->count() }})
                            </span>
                            <a href="{{ route('course.show', $c->slug) }}" target="_blank" rel="noreferrer" style="font-size: 0.8rem; color: #0284c7; text-decoration: underline; font-weight: 600;">
                                Im Kursplayer ansehen ↗
                            </a>
                        </div>

                        @if($c->lessons->count() > 0)
                            <div style="display: flex; flex-direction: column; gap: 0.6rem; margin-bottom: 1.5rem;">
                                @foreach($c->lessons as $lesson)
                                    <div style="background: #f8f7f4; border: 1px solid #e0dcd3; border-radius: 4px; padding: 0.85rem 1rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
                                        <div style="flex: 1; min-width: 240px;">
                                            <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                                                <strong style="color: #0f172a; font-size: 0.92rem;">
                                                    {{ $lesson->lesson_number }}. {{ $lesson->title }}
                                                </strong>
                                                <span style="font-size: 0.75rem; color: #64748b;">
                                                    ({{ $lesson->chapter_name ?: 'Hauptmodul' }})
                                                </span>
                                            </div>
                                            <div style="display: flex; gap: 0.4rem; margin-top: 0.35rem; flex-wrap: wrap;">
                                                @if($lesson->audio_path)
                                                    <span style="background: #dcfce7; color: #166534; font-size: 0.72rem; font-weight: 700; padding: 2px 7px; border-radius: 3px;">
                                                        🎧 Audio (MP3)
                                                    </span>
                                                @endif
                                                @if($lesson->pdf_attachment_path)
                                                    <span style="background: #f3e8ff; color: #6b21a8; font-size: 0.72rem; font-weight: 700; padding: 2px 7px; border-radius: 3px;">
                                                        📄 PDF ({{ $lesson->pdf_attachment_name ?: 'Arbeitsbuch' }})
                                                    </span>
                                                @endif
                                                @if(!$lesson->audio_path && ($lesson->video_path || $lesson->video_url))
                                                    <span style="background: #e0f2fe; color: #0369a1; font-size: 0.72rem; font-weight: 700; padding: 2px 7px; border-radius: 3px;">
                                                        🎬 Video
                                                    </span>
                                                @endif
                                                @if(!$lesson->audio_path && !$lesson->pdf_attachment_path && !$lesson->video_path && !$lesson->video_url)
                                                    <span style="background: #f1f5f9; color: #475569; font-size: 0.72rem; font-weight: 700; padding: 2px 7px; border-radius: 3px;">
                                                        📝 Text-Lektion
                                                    </span>
                                                @endif
                                                <span style="color: #64748b; font-size: 0.72rem; padding: 2px 4px;">
                                                    ⏱ {{ $lesson->duration_minutes }} Min
                                                </span>
                                            </div>
                                        </div>

                                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                                            <a href="{{ route('course.lesson', [$c->slug, $lesson->slug]) }}" target="_blank" rel="noreferrer" style="background: #ffffff; border: 1px solid #bbb7ae; color: #1e293b; padding: 4px 10px; font-size: 0.75rem; border-radius: 3px; font-weight: 600; text-decoration: none;">
                                                Vorschau ↗
                                            </a>
                                            <form method="POST" action="{{ route('admin.lessons.delete', $lesson->id) }}" onsubmit="return confirm('Lektion \'{{ addslashes($lesson->title) }}\' und alle zugehörigen Mediendateien wirklich löschen?');" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="background: #fef2f2; border: 1px solid #fca5a5; color: #dc2626; padding: 4px 10px; font-size: 0.75rem; border-radius: 3px; font-weight: 600; cursor: pointer;">
                                                    Löschen
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p style="color: #64748b; font-size: 0.85rem; padding: 0.75rem; background: #f8f7f4; border-radius: 4px; margin-bottom: 1.5rem;">
                                Dieser Kurs hat bisher noch keine hochgeladenen Lektionen. Verwenden Sie das Formular unten, um die erste Lektion hinzuzufügen.
                            </p>
                        @endif

                        {{-- Upload Form for this Course --}}
                        <div style="background: #f1eee7; border: 1px solid #d6d1c7; border-radius: 6px; padding: 1.25rem;">
                            <strong style="color: #0f172a; font-size: 0.95rem; display: block; margin-bottom: 0.75rem;">
                                + Neue Lektion für "{{ $c->catalog_title ?: $c->title }}" anlegen &amp; Medien hochladen
                            </strong>

                            <form method="POST" action="{{ route('admin.lessons.store', $c->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 0.75rem; margin-bottom: 0.75rem;">
                                    <label style="display: flex; flex-direction: column; gap: 0.25rem;">
                                        <span style="font-size: 0.78rem; font-weight: 700; color: #334155;">Titel der Lektion *</span>
                                        <input type="text" name="title" required placeholder="z. B. Stressregulation &amp; Ressourcen" style="background: #fff; border: 1px solid #bbb7ae; padding: 8px 10px; font-size: 0.85rem;">
                                    </label>
                                    <label style="display: flex; flex-direction: column; gap: 0.25rem;">
                                        <span style="font-size: 0.78rem; font-weight: 700; color: #334155;">Kapitel / Modul</span>
                                        <input type="text" name="chapter_name" placeholder="z. B. Modul 1 · Einführung" style="background: #fff; border: 1px solid #bbb7ae; padding: 8px 10px; font-size: 0.85rem;">
                                    </label>
                                    <label style="display: flex; flex-direction: column; gap: 0.25rem;">
                                        <span style="font-size: 0.78rem; font-weight: 700; color: #334155;">Dauer in Minuten</span>
                                        <input type="number" name="duration_minutes" value="15" min="1" max="600" style="background: #fff; border: 1px solid #bbb7ae; padding: 8px 10px; font-size: 0.85rem;">
                                    </label>
                                </div>

                                {{-- File Upload Rows --}}
                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 0.75rem; margin-bottom: 0.75rem;">
                                    <div style="background: #fff; border: 1px dashed #0284c7; padding: 0.75rem; border-radius: 4px;">
                                        <label style="display: flex; flex-direction: column; gap: 0.35rem;">
                                            <span style="font-size: 0.78rem; font-weight: 750; color: #0369a1;">🎧 Audio-Datei hochladen (MP3, WAV, M4A)</span>
                                            <input type="file" name="audio_file" accept=".mp3,.wav,.m4a,.ogg,.aac" style="font-size: 0.8rem;">
                                            <small style="font-size: 0.7rem; color: #64748b;">Wird im geschützten Audio-Player ohne Video-Frame abgespielt.</small>
                                        </label>
                                    </div>

                                    <div style="background: #fff; border: 1px dashed #7c3aed; padding: 0.75rem; border-radius: 4px;">
                                        <label style="display: flex; flex-direction: column; gap: 0.35rem;">
                                            <span style="font-size: 0.78rem; font-weight: 750; color: #6d28d9;">📄 PDF-Arbeitsbuch hochladen</span>
                                            <input type="file" name="pdf_file" accept=".pdf" style="font-size: 0.8rem;">
                                            <input type="text" name="pdf_attachment_name" placeholder="Dokument-Name (z.B. Arbeitsbuch Kapitel 1)" style="font-size: 0.78rem; border: 1px solid #ddd; padding: 4px 8px; margin-top: 4px;">
                                        </label>
                                    </div>

                                    <div style="background: #fff; border: 1px dashed #475569; padding: 0.75rem; border-radius: 4px;">
                                        <label style="display: flex; flex-direction: column; gap: 0.35rem;">
                                            <span style="font-size: 0.78rem; font-weight: 750; color: #334155;">🎬 Video-Datei oder Video-URL</span>
                                            <input type="file" name="video_file" accept=".mp4,.mov,.webm,.mkv" style="font-size: 0.8rem;">
                                            <input type="text" name="video_url" placeholder="Oder externe Video-URL" style="font-size: 0.78rem; border: 1px solid #ddd; padding: 4px 8px; margin-top: 4px;">
                                        </label>
                                    </div>
                                </div>

                                <label style="display: flex; flex-direction: column; gap: 0.25rem; margin-bottom: 1rem;">
                                    <span style="font-size: 0.78rem; font-weight: 700; color: #334155;">Lektionstext / Begleitende Beschreibung (HTML)</span>
                                    <textarea name="content_html" rows="3" placeholder="Zusätzliche Notizen, Lektionstexte oder Übungen..." style="background: #fff; border: 1px solid #bbb7ae; padding: 8px 10px; font-size: 0.85rem;"></textarea>
                                </label>

                                <button type="submit" style="background: #0284c7; color: #fff; border: none; padding: 10px 18px; font-size: 0.85rem; font-weight: 750; border-radius: 4px; cursor: pointer; text-transform: uppercase; letter-spacing: 0.05em;">
                                    Lektion &amp; Medien speichern
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <script>
                function switchMediaCourse(courseId) {
                    document.querySelectorAll('.media-course-content-panel').forEach(function(el) {
                        el.style.display = 'none';
                    });
                    var target = document.getElementById('course-media-panel-' + courseId);
                    if (target) {
                        target.style.display = 'block';
                    }
                }
            </script>
        </section>
        @endif

        {{-- 06 Ablauf / Arbeitsprozess (Photo 13 Exact Match: Dark Card & 6 Clean Cards) --}}
        <section class="admin-section admin-backend" id="sicherheit" style="background: #141412; color: #ffffff; padding: 3.5rem clamp(1.5rem, 5vw, 4rem); border-top: 1px solid #262624;">
            <header style="margin-bottom: 2rem;">
                <div style="display: flex; align-items: baseline; gap: 0.75rem; margin-bottom: 0.75rem;">
                    <span style="color: #38bdf8; font-size: 2.2rem; font-weight: 850; line-height: 1; letter-spacing: -0.02em;">06</span>
                    <span style="color: #38bdf8; font-size: 0.78rem; font-weight: 850; letter-spacing: 0.1em; text-transform: uppercase;">ARBEITSPROZESS</span>
                </div>
                <h2 style="color: #ffffff; font-size: 2.75rem; font-weight: 700; margin: 0; letter-spacing: -0.03em; line-height: 1.15;">
                    Einfach und nachvollziehbar.
                </h2>
            </header>

            {{-- 6 Cards Grid (Photo 13: 4 Columns top row, 2 cards bottom row) --}}
            <div class="backend-functions" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 0; border: 1px solid #333330; background: #141412;">
                <article style="border: 1px solid #333330; padding: 1.5rem; background: transparent; display: flex; flex-direction: column; gap: 0.65rem; min-height: 160px;">
                    <strong style="color: #ffffff; font-size: 0.95rem; font-weight: 700;">Ein Gerät</strong>
                    <span style="color: #a1a1aa; font-size: 0.8rem; line-height: 1.5;">Das erste erfolgreiche Login bindet das Kundenkonto an dieses Gerät.</span>
                </article>

                <article style="border: 1px solid #333330; padding: 1.5rem; background: transparent; display: flex; flex-direction: column; gap: 0.65rem; min-height: 160px;">
                    <strong style="color: #ffffff; font-size: 0.95rem; font-weight: 700;">Kein Geräte-Reset</strong>
                    <span style="color: #a1a1aa; font-size: 0.8rem; line-height: 1.5;">Bei Gerätewechsel das alte Kundenkonto vollständig löschen.</span>
                </article>

                <article style="border: 1px solid #333330; padding: 1.5rem; background: transparent; display: flex; flex-direction: column; gap: 0.65rem; min-height: 160px;">
                    <strong style="color: #ffffff; font-size: 0.95rem; font-weight: 700;">Neu anlegen</strong>
                    <span style="color: #a1a1aa; font-size: 0.8rem; line-height: 1.5;">Neues Konto, neue Zugangsdaten, Kurs und Laufzeit bewusst neu vergeben.</span>
                </article>

                <article style="border: 1px solid #333330; padding: 1.5rem; background: transparent; display: flex; flex-direction: column; gap: 0.65rem; min-height: 160px;">
                    <strong style="color: #ffffff; font-size: 0.95rem; font-weight: 700;">Datensparsam</strong>
                    <span style="color: #a1a1aa; font-size: 0.8rem; line-height: 1.5;">Vorname und Kunden-/Rechnungsnummer ermöglichen die pseudonymisierte Zuordnung. Abgelaufene Konten werden automatisch entfernt; Buchungsbelege bleiben nur nach gesetzlicher Frist erhalten.</span>
                </article>

                <article style="border: 1px solid #333330; padding: 1.5rem; background: transparent; display: flex; flex-direction: column; gap: 0.65rem; min-height: 160px; grid-column: span 1;">
                    <strong style="color: #ffffff; font-size: 0.95rem; font-weight: 700;">Passwort vergessen</strong>
                    <span style="color: #a1a1aa; font-size: 0.8rem; line-height: 1.5;">Rechnungsnummer und Kurs ordnen die Anfrage zu. Neues Passwort erst nach Abgleich über die Buchhaltung übermitteln.</span>
                </article>

                <article class="integration-pending" style="border: 1px solid #333330; padding: 1.5rem; background: transparent; display: flex; flex-direction: column; gap: 0.65rem; min-height: 160px; grid-column: span 1;">
                    <strong style="color: #ffffff; font-size: 0.95rem; font-weight: 700;">Papierkram-Rechnungen</strong>
                    <span style="color: #a1a1aa; font-size: 0.8rem; line-height: 1.5;">Mitarbeiter müssen vor der ersten Anmeldung von Dennis als Benutzer bei Papierkram freigeschaltet werden. Bei technischen Login-, Passwort- oder Systemproblemen hilft ausschließlich der Papierkram-Support.</span>
                    <div style="margin-top: 0.5rem; display: flex; flex-direction: column; gap: 0.4rem; border-top: 1px solid #333330; padding-top: 0.6rem;">
                        <a href="https://dennisbesseler.papierkram.de/login?email=mail%40besseler.de" target="_blank" rel="noreferrer" style="color: #ffffff; font-size: 0.72rem; font-weight: 850; text-transform: uppercase; letter-spacing: 0.05em; text-decoration: none;">PAPIERKRAM ÖFFNEN ↗</a>
                        <a href="https://hilfe.papierkram.de/system-status/" target="_blank" rel="noreferrer" style="color: #ffffff; font-size: 0.72rem; font-weight: 850; text-transform: uppercase; letter-spacing: 0.05em; text-decoration: none; border-top: 1px solid #262624; padding-top: 0.4rem;">PAPIERKRAM-SUPPORT ↗</a>
                    </div>
                </article>
            </div>

            {{-- Audit-Protokoll für Gerätebindung & Sicherheit direkt in Sektion 06 --}}
            @if(!($isStaffPreview ?? false) && Auth::user()->isAdmin())
            <div style="margin-top:2rem; background:#0f172a; border:1px solid #334155; border-radius:8px; padding:1.25rem;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem; flex-wrap:wrap; gap:0.5rem;">
                    <div>
                        <strong style="color:#38bdf8; font-size:0.95rem; text-transform:uppercase; letter-spacing:0.05em;">Audit-Protokoll: Gerätebindung &amp; Anmeldeversuche</strong>
                        <p style="color:#94a3b8; font-size:0.8rem; margin:0.2rem 0 0 0;">Protokolliert alle Bindungs-, Entsperrungs- und abgewiesenen Login-Ereignisse ({{ $auditLogs->total() }} Einträge).</p>
                    </div>
                    @if($auditLogs->total() > 0)
                        <span style="background:rgba(56, 189, 248, 0.15); color:#38bdf8; border:1px solid rgba(56, 189, 248, 0.3); padding:0.2rem 0.6rem; border-radius:12px; font-size:0.75rem; font-weight:700;">
                            Live aktiv
                        </span>
                    @endif
                </div>

                @if($auditLogs->count() > 0)
                    <div style="overflow-x:auto;">
                        <table style="width:100%; border-collapse:collapse; text-align:left; background:#1e293b; border-radius:6px; overflow:hidden; font-size:0.85rem;">
                            <thead>
                                <tr style="background:#0b1120; color:#94a3b8; font-size:0.75rem; text-transform:uppercase; letter-spacing:0.05em;">
                                    <th style="padding:0.6rem 0.85rem;">Zeitpunkt</th>
                                    <th style="padding:0.6rem 0.85rem;">Ereignis</th>
                                    <th style="padding:0.6rem 0.85rem;">Benutzer</th>
                                    <th style="padding:0.6rem 0.85rem;">Details</th>
                                    <th style="padding:0.6rem 0.85rem;">IP-Adresse</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($auditLogs as $log)
                                    <tr style="border-bottom:1px solid #334155; color:#f8fafc;">
                                        <td style="padding:0.55rem 0.85rem; color:#94a3b8; white-space:nowrap; font-size:0.8rem;">
                                             {{ $log->created_at->format('d.m.Y H:i:s') }}
                                        </td>
                                        <td style="padding:0.55rem 0.85rem;">
                                            @if(str_contains($log->event, 'REJECTED') || str_contains($log->event, 'FAILED'))
                                                <span style="background:#7f1d1d; color:#fca5a5; padding:2px 6px; border-radius:3px; font-weight:700; font-size:0.72rem;">⚠ {{ $log->event }}</span>
                                            @elseif(str_contains($log->event, 'BOUND') || str_contains($log->event, 'SUCCESS'))
                                                <span style="background:#14532d; color:#86efac; padding:2px 6px; border-radius:3px; font-weight:700; font-size:0.72rem;">✓ {{ $log->event }}</span>
                                            @else
                                                <span style="background:#1e3a5f; color:#38bdf8; padding:2px 6px; border-radius:3px; font-weight:700; font-size:0.72rem;">ℹ {{ $log->event }}</span>
                                            @endif
                                        </td>
                                        <td style="padding:0.55rem 0.85rem; font-weight:600;">
                                            {{ $log->user ? $log->user->username : '—' }}
                                        </td>
                                        <td style="padding:0.55rem 0.85rem; color:#cbd5e1; font-size:0.8rem;">
                                            {{ $log->detail }}
                                        </td>
                                        <td style="padding:0.55rem 0.85rem; font-family:monospace; color:#94a3b8; font-size:0.75rem;">
                                            {{ $log->ip ?: '—' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p style="color:#94a3b8; font-size:0.85rem; margin:0.5rem 0 0 0;">Bisher keine abgewiesenen Login-Versuche oder Sicherheitsereignisse protokolliert.</p>
                @endif
            </div>
            @endif
        </section>

        {{-- 08 Hauptadmin-Sicherheit (100% Forensic Match to Reference A) --}}
        @if(!($isStaffPreview ?? false) && Auth::user()->isAdmin())
        <section class="admin-section admin-security-settings" id="hauptadmin-sicherheit" style="background: #f2eee5; border-top: 1px solid #d2cabd; padding: clamp(4rem, 8vw, 8rem) clamp(1rem, 6vw, 7rem); scroll-margin-top: 82px;">
            <header style="border-bottom: 1px solid #d4cfc5; grid-template-columns: auto 1fr; align-items: end; gap: clamp(2rem, 4vw, 4rem); padding-bottom: 1.5rem; margin-bottom: 3rem; display: grid;">
                <div style="align-items: center; gap: 1rem; display: flex;">
                    <span style="color: var(--academy); font-size: 3rem; font-weight: 200;">08</span>
                    <h2 style="letter-spacing: -.055em; margin: 0; font-size: clamp(2.8rem, 5vw, 5.5rem); font-weight: 300; line-height: .9; white-space: nowrap;">
                        Hauptadmin-<br/>Sicherheit.
                    </h2>
                </div>
                <p style="color: var(--muted); max-width: 780px; margin: 0; line-height: 1.6; font-size: 1.15rem;">
                    Das Admin-Passwort kann hier sicher geändert werden. Der vierstellige Sicherheitscode bleibt fest hinterlegt und wird im Portal niemals angezeigt. Eine Passwortänderung beendet alle Hauptadmin-Sitzungen.
                </p>
            </header>

            <div class="admin-security-grid">
                <form method="POST" action="{{ route('admin.change-password') }}" autoComplete="off" style="background: #f8f5ee; border: 0; border-top: 7px solid #2460a0; padding: clamp(1.5rem, 3.5vw, 3rem); max-width: 560px; box-shadow: none; border-radius: 0; display: flex; flex-direction: column; gap: 1.15rem;">
                    @csrf
                    <div>
                        <h3 style="font-size: 1.25rem; font-weight: 700; color: #11110f; margin: 0 0 0.35rem;">Admin-Passwort ändern</h3>
                        <p style="font-size: 0.85rem; color: #6f6a61; margin: 0; line-height: 1.5;">Mindestens 12 Zeichen mit Groß- und Kleinbuchstaben, Zahl und Sonderzeichen.</p>
                    </div>

                    @if(session('password_success'))
                        <div style="background:#14532d; color:#86efac; padding:0.75rem; border-radius:4px;">
                            ✓ {{ session('password_success') }}
                        </div>
                    @endif

                    <label style="gap: 0.35rem; display: grid;">
                        <span style="font-size: 0.62rem; font-weight: 850; letter-spacing: 0.08em; text-transform: uppercase; color: var(--muted);">Bisheriges Admin-Passwort</span>
                        <input type="password" name="current_password" required autoComplete="current-password" style="background: #fff; border: 1px solid #c9c5bc; width: 100%; min-height: 50px; padding: 0.8rem; box-sizing: border-box;">
                    </label>

                    <label style="gap: 0.35rem; display: grid;">
                        <span style="font-size: 0.62rem; font-weight: 850; letter-spacing: 0.08em; text-transform: uppercase; color: var(--muted);">Bisheriger Sicherheitscode</span>
                        <input type="password" name="security_code" required inputmode="numeric" pattern="[0-9]{4}" maxlength="4" style="background: #fff; border: 1px solid #c9c5bc; width: 100%; min-height: 50px; padding: 0.8rem; box-sizing: border-box;">
                    </label>

                    <label style="gap: 0.35rem; display: grid;">
                        <span style="font-size: 0.62rem; font-weight: 850; letter-spacing: 0.08em; text-transform: uppercase; color: var(--muted);">Neues Admin-Passwort</span>
                        <input type="password" name="new_password" required minlength="12" maxLength="128" autoComplete="new-password" style="background: #fff; border: 1px solid #c9c5bc; width: 100%; min-height: 50px; padding: 0.8rem; box-sizing: border-box;">
                    </label>

                    <label style="gap: 0.35rem; display: grid;">
                        <span style="font-size: 0.62rem; font-weight: 850; letter-spacing: 0.08em; text-transform: uppercase; color: var(--muted);">Neues Passwort wiederholen</span>
                        <input type="password" name="new_password_confirmation" required minlength="12" maxLength="128" autoComplete="new-password" style="background: #fff; border: 1px solid #c9c5bc; width: 100%; min-height: 50px; padding: 0.8rem; box-sizing: border-box;">
                    </label>

                    <button type="submit" style="background: #2460a0; color: #fff; border: 0; min-height: 50px; padding: 1.1rem; font-size: 0.72rem; font-weight: 850; letter-spacing: 0.08em; text-transform: uppercase; cursor: pointer; margin-top: 0.5rem;">
                        Sicher ändern
                    </button>
                </form>
            </div>
        </section>
        @endif

        {{-- AL Audit-Protokoll (Sicherheits- & Geräte-Ereignisse bei gezieltem Aufruf) --}}
        @if(!($isStaffPreview ?? false) && Auth::user()->isAdmin() && (request()->has('audit_page') || request()->has('audit')))
        <section class="admin-section" id="audit-log">
            <header>
                <div>
                    <span>AL</span>
                    <p class="eyebrow">Sicherheits- &amp; Audit-Protokoll ({{ $auditLogs->total() }})</p>
                </div>
                <h2>Protokollierte Anmelde- und Geräteereignisse.</h2>
            </header>

            <div style="margin-top:1.5rem; overflow-x:auto;">
                @if($auditLogs->count() > 0)
                    <table style="width:100%; border-collapse:collapse; text-align:left; background:#1e293b; border-radius:8px; overflow:hidden;">
                        <thead>
                            <tr style="background:#0f172a; color:#94a3b8; font-size:0.85rem; text-transform:uppercase;">
                                <th style="padding:1rem;">Zeitpunkt</th>
                                <th style="padding:1rem;">Ereignis</th>
                                <th style="padding:1rem;">Benutzer</th>
                                <th style="padding:1rem;">Details</th>
                                <th style="padding:1rem;">IP-Adresse</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($auditLogs as $log)
                                <tr style="border-bottom:1px solid #334155; color:#f8fafc; font-size:0.9rem;">
                                    <td style="padding:0.75rem 1rem; color:#94a3b8; white-space:nowrap;">
                                        {{ $log->created_at->format('d.m.Y H:i:s') }}
                                    </td>
                                    <td style="padding:0.75rem 1rem;">
                                        @if(str_contains($log->event, 'REJECTED') || str_contains($log->event, 'FAILED'))
                                            <span style="background:#7f1d1d; color:#fca5a5; padding:0.2rem 0.5rem; border-radius:4px; font-weight:600; font-size:0.8rem;">⚠ {{ $log->event }}</span>
                                        @elseif(str_contains($log->event, 'BOUND') || str_contains($log->event, 'SUCCESS'))
                                            <span style="background:#14532d; color:#86efac; padding:0.2rem 0.5rem; border-radius:4px; font-weight:600; font-size:0.8rem;">✓ {{ $log->event }}</span>
                                        @else
                                            <span style="background:#1e3a5f; color:#38bdf8; padding:0.2rem 0.5rem; border-radius:4px; font-weight:600; font-size:0.8rem;">ℹ {{ $log->event }}</span>
                                        @endif
                                    </td>
                                    <td style="padding:0.75rem 1rem;">
                                        @if($log->user)
                                            <strong>{{ $log->user->username }}</strong>
                                        @else
                                            <span style="color:#64748b;">—</span>
                                        @endif
                                    </td>
                                    <td style="padding:0.75rem 1rem; color:#cbd5e1;">
                                        {{ $log->detail }}
                                    </td>
                                    <td style="padding:0.75rem 1rem; color:#94a3b8; font-family:monospace;">
                                        {{ $log->ip ?: '—' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($auditLogs->hasPages())
                        <div style="margin-top: 1.25rem; display: flex; justify-content: space-between; align-items: center; background: #0f172a; padding: 0.85rem 1.25rem; border-radius: 8px; border: 1px solid #334155; flex-wrap: wrap; gap: 0.75rem;">
                            <span style="color: #94a3b8; font-size: 0.85rem;">
                                Einträge {{ $auditLogs->firstItem() }} bis {{ $auditLogs->lastItem() }} von insgesamt {{ $auditLogs->total() }}
                            </span>
                            <div style="display: flex; gap: 0.5rem; align-items: center;">
                                @if($auditLogs->onFirstPage())
                                    <span style="background: #1e293b; color: #64748b; padding: 0.4rem 0.85rem; border-radius: 4px; font-size: 0.82rem; cursor: not-allowed; border: 1px solid #334155;">« Zurück</span>
                                @else
                                    <a href="{{ $auditLogs->previousPageUrl() }}" style="background: #1e3a5f; color: #38bdf8; padding: 0.4rem 0.85rem; border-radius: 4px; font-size: 0.82rem; text-decoration: none; border: 1px solid #0284c7; font-weight: 600;">« Zurück</a>
                                @endif

                                <span style="color: #cbd5e1; font-size: 0.85rem; padding: 0 0.5rem; font-weight: 600;">
                                    Seite {{ $auditLogs->currentPage() }} von {{ $auditLogs->lastPage() }}
                                </span>

                                @if($auditLogs->hasMorePages())
                                    <a href="{{ $auditLogs->nextPageUrl() }}" style="background: #1e3a5f; color: #38bdf8; padding: 0.4rem 0.85rem; border-radius: 4px; font-size: 0.82rem; text-decoration: none; border: 1px solid #0284c7; font-weight: 600;">Weiter »</a>
                                @else
                                    <span style="background: #1e293b; color: #64748b; padding: 0.4rem 0.85rem; border-radius: 4px; font-size: 0.82rem; cursor: not-allowed; border: 1px solid #334155;">Weiter »</span>
                                @endif
                            </div>
                        </div>
                    @endif
                @else
                    <p style="color:#94a3b8;">Keine Audit-Einträge vorhanden.</p>
                @endif
            </div>
        </section>
        @endif

        {{-- Portal Bottom Navigation (Reference A Exact Footer) --}}
        <nav class="portal-bottom-navigation" id="admin-page-end" aria-label="Seitenende-Navigation">
            <a class="portal-jump-arrow portal-jump-up" href="#admin-page-top" aria-label="Zum Seitenanfang">
                <span aria-hidden="true">↑</span>
            </a>
        </nav>
    </main>

    {{-- Work Timer Script (5 Input Fields + Rotation Rule + Copy + Mailto) --}}
    <script>
        function copyToClipboard(text, button) {
            function showSuccess() {
                const orig = button.innerText;
                button.innerText = 'Kopiert!';
                button.style.background = '#16a34a';
                button.style.color = '#ffffff';
                setTimeout(() => {
                    button.innerText = orig;
                    button.style.background = '';
                    button.style.color = '';
                }, 2000);
            }
            function fallbackCopy(str) {
                const ta = document.createElement('textarea');
                ta.value = str;
                ta.style.position = 'fixed';
                ta.style.left = '-9999px';
                document.body.appendChild(ta);
                ta.focus();
                ta.select();
                try {
                    document.execCommand('copy');
                    showSuccess();
                } catch (e) {
                    console.error('Fallback copy failed', e);
                }
                document.body.removeChild(ta);
            }

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(showSuccess).catch(() => fallbackCopy(text));
            } else {
                fallbackCopy(text);
            }
        }

        // Toggle employee delete button based on Google Drive revocation checkbox
        function toggleStaffDeleteBtn(staffId) {
            const cb = document.getElementById('drive-revoked-' + staffId);
            const btn = document.getElementById('staff-delete-btn-' + staffId);
            if (cb && btn) {
                btn.disabled = !cb.checked;
                btn.style.opacity = cb.checked ? '1' : '0.5';
                btn.style.cursor = cb.checked ? 'pointer' : 'not-allowed';
            }
        }

        function confirmStaffDelete(staffId, staffName) {
            const cb = document.getElementById('drive-revoked-' + staffId);
            if (!cb || !cb.checked) {
                alert('Vor dem Löschen muss bestätigt werden, dass der Google-Drive-Zugriff dieses Mitarbeiters entzogen wurde.');
                return false;
            }
            return confirm('Mitarbeiterkonto ' + staffName + ' endgültig löschen?');
        }

        // Automatic course assignment date calculations
        function updateAssignCourseDates(customerId) {
            const select = document.getElementById('assign-course-' + customerId);
            const startInput = document.getElementById('assign-start-' + customerId);
            const endInput = document.getElementById('assign-end-' + customerId);
            if (!select || !select.value) return;

            const selectedOption = select.options[select.selectedIndex];
            const duration = parseInt(selectedOption.getAttribute('data-duration') || '120', 10);

            if (startInput && endInput) {
                const start = new Date(startInput.value || new Date());
                const end = new Date(start.getTime() + duration * 24 * 60 * 60 * 1000);
                endInput.value = end.toISOString().split('T')[0];
            }
        }

        function recalcAssignCourseEndDate(customerId) {
            const select = document.getElementById('assign-course-' + customerId);
            const startInput = document.getElementById('assign-start-' + customerId);
            const endInput = document.getElementById('assign-end-' + customerId);
            if (!select || !select.value || !startInput || !endInput) return;

            const selectedOption = select.options[select.selectedIndex];
            const duration = parseInt(selectedOption.getAttribute('data-duration') || '120', 10);
            const start = new Date(startInput.value);
            if (!isNaN(start.getTime())) {
                const end = new Date(start.getTime() + duration * 24 * 60 * 60 * 1000);
                endInput.value = end.toISOString().split('T')[0];
            }
        }

        function updateNewCustDates() {
            const select = document.getElementById('new-cust-course-select');
            const startInput = document.getElementById('new-cust-start-date');
            if (!select || !select.value || !startInput) return;
        }

        // Work Timer Script (Dennis Besseler Reference Implementation)
        let adminTimerState = {
            active: null,
            completed: [],
            durationSeconds: 0,
            interval: null,
            isPanelOpen: false
        };

        function formatTimerClock(totalSec) {
            const sec = Math.max(0, Math.floor(totalSec));
            const hrs = String(Math.floor(sec / 3600)).padStart(2, '0');
            const mins = String(Math.floor((sec % 3600) / 60)).padStart(2, '0');
            const secs = String(sec % 60).padStart(2, '0');
            return `${hrs}:${mins}:${secs}`;
        }

        function formatTimerHuman(totalSec) {
            const hrs = Math.floor(totalSec / 3600);
            const mins = Math.floor((totalSec % 3600) / 60);
            if (hrs > 0) return `${hrs}h ${mins}m`;
            return `${mins}m ${totalSec % 60}s`;
        }

        function toggleAdminWorkTimerPanel(force) {
            const panel = document.getElementById('admin-timer-panel');
            const toggleBtn = document.getElementById('admin-timer-toggle-btn');
            if (typeof force === 'boolean') {
                adminTimerState.isPanelOpen = force;
            } else {
                adminTimerState.isPanelOpen = !adminTimerState.isPanelOpen;
            }
            if (panel) panel.style.display = adminTimerState.isPanelOpen ? 'block' : 'none';
            if (toggleBtn) toggleBtn.setAttribute('aria-expanded', adminTimerState.isPanelOpen ? 'true' : 'false');
        }

        function updateAdminTimerUI() {
            const toggleBtn = document.getElementById('admin-timer-toggle-btn');
            const labelEl = document.getElementById('admin-timer-label');
            const clockEl = document.getElementById('admin-timer-clock');
            const bigClockEl = document.getElementById('admin-timer-big-clock');
            const runningBox = document.getElementById('admin-timer-running-box');
            const startForm = document.getElementById('admin-timer-start-form');
            const activeSubject = document.getElementById('admin-timer-active-subject');
            const activeActivitiesEl = document.getElementById('admin-timer-active-activities');
            const historyContainer = document.getElementById('admin-timer-history-container');

            const timeFormatted = formatTimerClock(adminTimerState.durationSeconds);
            if (clockEl) clockEl.textContent = timeFormatted;
            if (bigClockEl) bigClockEl.textContent = timeFormatted;

            const pauseBtn = document.getElementById('admin-timer-pause-btn');
            const resumeBtn = document.getElementById('admin-timer-resume-btn');
            const statusHeadline = document.getElementById('admin-timer-status-headline');

            if (adminTimerState.active && (adminTimerState.active.status === 'running' || adminTimerState.active.status === 'paused')) {
                if (toggleBtn) toggleBtn.classList.add('is-running');
                if (runningBox) runningBox.style.display = 'block';
                if (startForm) startForm.style.display = 'none';
                if (activeSubject) activeSubject.textContent = adminTimerState.active.subject || adminTimerState.active.activity_description || 'Zeitmessung';
                
                if (activeActivitiesEl && adminTimerState.active.activities && adminTimerState.active.activities.length > 0) {
                    activeActivitiesEl.innerHTML = adminTimerState.active.activities.map((a, i) => `<div>${i + 1}. ${a}</div>`).join('');
                }

                if (adminTimerState.active.status === 'running') {
                    if (labelEl) labelEl.textContent = 'Timer läuft';
                    if (statusHeadline) statusHeadline.textContent = 'Aktuelle Zeitmessung (Läuft)';
                    if (pauseBtn) pauseBtn.style.display = 'inline-block';
                    if (resumeBtn) resumeBtn.style.display = 'none';
                } else {
                    if (labelEl) labelEl.textContent = 'Timer pausiert';
                    if (statusHeadline) statusHeadline.textContent = 'Aktuelle Zeitmessung (Pausiert)';
                    if (pauseBtn) pauseBtn.style.display = 'none';
                    if (resumeBtn) resumeBtn.style.display = 'inline-block';
                }
            } else {
                if (toggleBtn) toggleBtn.classList.remove('is-running');
                if (labelEl) labelEl.textContent = 'Timer';
                if (runningBox) runningBox.style.display = 'none';
                if (startForm) startForm.style.display = 'block';
            }

            // Render History (Max 3 completed entries - Dennis Reference Rotation Rule)
            if (historyContainer) {
                const isEn = localStorage.getItem('portal_lang') === 'en' || document.documentElement.classList.contains('translated-ltr');
                if (!adminTimerState.completed || adminTimerState.completed.length === 0) {
                    historyContainer.innerHTML = `<small style="color:#64748b;" data-i18n-de="Noch keine abgeschlossene Zeitmessung." data-i18n-en="No completed time measurements yet.">${isEn ? 'No completed time measurements yet.' : 'Noch keine abgeschlossene Zeitmessung.'}</small>`;
                } else {
                    let html = '';
                    adminTimerState.completed.slice(0, 3).forEach((item, idx) => {
                        const dateStr = item.stopped_at_formatted || (item.ended_at ? new Date(item.ended_at).toLocaleString(isEn ? 'en-US' : 'de-DE') : '');
                        const acts = item.activities && item.activities.length > 0 ? item.activities : [item.subject || item.activity_description || (isEn ? 'Task' : 'Aufgabe')];
                        const actsHtml = acts.map((a, i) => `<span style="display:block; font-size:0.75rem; color:#1e293b; line-height:1.45; font-weight:500;">${i+1}. ${a}</span>`).join('');
                        const staffLabel = isEn ? 'Employee:' : 'Mitarbeiter:';
                        const staffHtml = item.assigned_staff_name ? `<small style="color:#0369a1; font-weight:700;">${staffLabel} ${item.assigned_staff_name}</small>` : '';

                        html += `
                            <div style="display: block !important; width: 100% !important; box-sizing: border-box !important; padding: 0.75rem !important; background: #f1eee7 !important; border: 1px solid #d6d1c7 !important; border-radius: 4px !important;">
                                <div style="display:flex; justify-content:space-between; align-items:center; gap:0.5rem; margin-bottom: 0.35rem;">
                                    <strong style="color:#0f172a; font-size:0.9rem; font-weight:750; word-break:break-word;">${item.subject || item.activity_description || (isEn ? 'Task' : 'Aufgabe')}</strong>
                                    <b style="color:#0284c7; font-size:0.85rem; font-family: ui-monospace, monospace; font-weight:700; white-space:nowrap;" class="notranslate" translate="no">${formatTimerHuman(item.duration_seconds || 0)}</b>
                                </div>
                                <div style="margin: 0.35rem 0;">${actsHtml}</div>
                                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:0.4rem; margin-top:0.4rem; padding-top:0.35rem; border-top:1px dashed #d6d1c7;">
                                    ${staffHtml}
                                    <small style="color:#64748b; font-size:0.72rem; margin-left:auto;">${dateStr}</small>
                                </div>
                            </div>
                        `;
                    });
                    historyContainer.innerHTML = html;
                }
            }

            toggleAdminSendBtn();
        }

        function startAdminTimerLoop() {
            stopAdminTimerLoop();
            adminTimerState.interval = setInterval(() => {
                adminTimerState.durationSeconds += 1;
                const clockEl = document.getElementById('admin-timer-clock');
                const bigClockEl = document.getElementById('admin-timer-big-clock');
                const timeFormatted = formatTimerClock(adminTimerState.durationSeconds);
                if (clockEl) clockEl.textContent = timeFormatted;
                if (bigClockEl) bigClockEl.textContent = timeFormatted;
            }, 1000);
        }

        function stopAdminTimerLoop() {
            if (adminTimerState.interval) {
                clearInterval(adminTimerState.interval);
                adminTimerState.interval = null;
            }
        }

        function fetchAdminTimerStatus() {
            fetch("{{ route('time-tracking.status') }}", {
                headers: { 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                adminTimerState.completed = data.recent_entries || [];
                if (data.active_entry && (data.active_entry.status === 'running' || data.active_entry.status === 'paused')) {
                    adminTimerState.active = data.active_entry;
                    adminTimerState.durationSeconds = data.current_duration || 0;
                    if (data.active_entry.status === 'running') {
                        startAdminTimerLoop();
                    } else {
                        stopAdminTimerLoop();
                    }
                } else {
                    adminTimerState.active = null;
                    adminTimerState.durationSeconds = 0;
                    stopAdminTimerLoop();
                }
                updateAdminTimerUI();
            })
            .catch(err => console.error('Timer Status Error:', err));
        }

        function adminStartTimer(e) {
            e.preventDefault();
            const act1 = document.getElementById('admin-timer-input-1')?.value.trim() || 'Kundenbetreuung';
            const act2 = document.getElementById('admin-timer-input-2')?.value.trim() || '';
            const act3 = document.getElementById('admin-timer-input-3')?.value.trim() || '';
            const act4 = document.getElementById('admin-timer-input-4')?.value.trim() || '';
            const act5 = document.getElementById('admin-timer-input-5')?.value.trim() || '';
            const staffSelect = document.getElementById('admin-timer-staff-select');
            const staffId = staffSelect ? staffSelect.value : null;

            const actsList = [act1, act2, act3, act4, act5].filter(Boolean);

            adminTimerState.active = { 
                subject: act1, 
                activities: actsList, 
                activity_description: actsList.join(' · '), 
                status: 'running' 
            };
            adminTimerState.durationSeconds = 0;
            updateAdminTimerUI();
            startAdminTimerLoop();

            fetch("{{ route('time-tracking.start') }}", {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ 
                    activity_1: act1,
                    activity_2: act2,
                    activity_3: act3,
                    activity_4: act4,
                    activity_5: act5,
                    assigned_staff_id: staffId,
                    activity_description: actsList.join(' · ')
                })
            })
            .then(res => res.json())
            .then(data => {
                for (let i = 1; i <= 5; i++) {
                    const el = document.getElementById('admin-timer-input-' + i);
                    if (el) el.value = '';
                }
                fetchAdminTimerStatus();
            })
            .catch(err => {
                console.error('Start error:', err);
                fetchAdminTimerStatus();
            });
        }

        function adminPauseTimer() {
            if (adminTimerState.active) {
                adminTimerState.active.status = 'paused';
            }
            stopAdminTimerLoop();
            updateAdminTimerUI();

            fetch("{{ route('time-tracking.pause.active') }}", {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(() => fetchAdminTimerStatus())
            .catch(err => {
                console.error('Pause error:', err);
                fetchAdminTimerStatus();
            });
        }

        function adminResumeTimer() {
            if (adminTimerState.active) {
                adminTimerState.active.status = 'running';
            }
            startAdminTimerLoop();
            updateAdminTimerUI();

            fetch("{{ route('time-tracking.resume.active') }}", {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(() => fetchAdminTimerStatus())
            .catch(err => {
                console.error('Resume error:', err);
                fetchAdminTimerStatus();
            });
        }

        function adminStopTimer() {
            adminTimerState.active = null;
            stopAdminTimerLoop();
            adminTimerState.durationSeconds = 0;
            updateAdminTimerUI();

            fetch("{{ route('time-tracking.stop.active') }}", {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.recent_entries) {
                    adminTimerState.completed = data.recent_entries;
                }
                fetchAdminTimerStatus();
            })
            .catch(err => {
                console.error('Stop error:', err);
                fetchAdminTimerStatus();
            });
        }

        function copyTimerHistorySummary() {
            const isEn = localStorage.getItem('portal_lang') === 'en' || document.documentElement.classList.contains('translated-ltr');
            if (!adminTimerState.completed || adminTimerState.completed.length === 0) {
                alert(isEn ? 'No completed time measurements available.' : 'Noch keine abgeschlossene Zeitmessung vorhanden.');
                return;
            }
            let text = isEn ? 'COMPLETED TIME MEASUREMENTS:\n\n' : 'ABGESCHLOSSENE ZEITMESSUNGEN:\n\n';
            adminTimerState.completed.slice(0, 3).forEach((item, idx) => {
                const dateStr = item.stopped_at_formatted || (item.ended_at ? new Date(item.ended_at).toLocaleString(isEn ? 'en-US' : 'de-DE') : '');
                const acts = item.activities && item.activities.length > 0 ? item.activities.join('; ') : (item.subject || item.activity_description || (isEn ? 'Task' : 'Aufgabe'));
                text += `${idx + 1}. ${item.subject || item.activity_description || (isEn ? 'Task' : 'Aufgabe')}\n`;
                text += `   ${isEn ? 'Activities' : 'Tätigkeiten'}: ${acts}\n`;
                text += `   ${isEn ? 'Duration' : 'Dauer'}: ${formatTimerHuman(item.duration_seconds || 0)}\n`;
                text += `   ${isEn ? 'Ended' : 'Ende'}: ${dateStr}\n\n`;
            });
            navigator.clipboard.writeText(text).then(() => {
                alert(isEn ? 'Summary of 3 measurements copied to clipboard!' : 'Zusammenfassung der 3 Messungen in die Zwischenablage kopiert!');
            });
        }

        function toggleAdminSendBtn() {
            const check = document.getElementById('admin-timer-cc-check');
            const btn = document.getElementById('admin-timer-send-btn');
            if (btn && check) {
                btn.disabled = !check.checked;
            }
        }

        function adminSendTimerMail() {
            const isEn = localStorage.getItem('portal_lang') === 'en' || document.documentElement.classList.contains('translated-ltr');
            
            // Gather current inputs if filled
            const act1 = document.getElementById('admin-timer-input-1')?.value.trim();
            const act2 = document.getElementById('admin-timer-input-2')?.value.trim();
            const act3 = document.getElementById('admin-timer-input-3')?.value.trim();
            const act4 = document.getElementById('admin-timer-input-4')?.value.trim();
            const act5 = document.getElementById('admin-timer-input-5')?.value.trim();
            const currentInputs = [act1, act2, act3, act4, act5].filter(Boolean);

            let e = [
                isEn ? 'Hello Dennis,' : 'Hallo Dennis,',
                '',
                isEn ? 'I hereby submit the following time information:' : 'hiermit übermittle ich folgende Zeitinformationen:',
                ''
            ];

            if (adminTimerState.completed && adminTimerState.completed.length > 0) {
                e.push(isEn ? '--- Completed Measurements (Max 3) ---' : '--- Abgeschlossene Zeitmessungen (Max 3) ---');
                adminTimerState.completed.slice(0, 3).forEach((item, idx) => {
                    const startStr = item.started_at_formatted || (item.started_at ? new Date(item.started_at).toLocaleString(isEn ? 'en-US' : 'de-DE') : '');
                    const endStr = item.stopped_at_formatted || (item.ended_at ? new Date(item.ended_at).toLocaleString(isEn ? 'en-US' : 'de-DE') : startStr);
                    const acts = item.activities && item.activities.length > 0 
                        ? item.activities.map((a, i) => `   ${i+1}. ${a}`).join('\n') 
                        : `   - ${item.subject || item.activity_description || (isEn ? 'Activity' : 'Tätigkeit')}`;
                    const staff = item.assigned_staff_name ? ` (${isEn ? 'Staff:' : 'Mitarbeiter:'} ${item.assigned_staff_name})` : '';
                    e.push(`${idx + 1}. ${item.subject || item.activity_description || (isEn ? 'Activity' : 'Tätigkeit')}${staff}`);
                    e.push(`${isEn ? 'Activities:' : 'Tätigkeiten:'}\n${acts}`);
                    e.push(`   ${isEn ? 'Start' : 'Beginn'}: ${startStr}`);
                    e.push(`   ${isEn ? 'End' : 'Ende'}: ${endStr}`);
                    e.push(`   ${isEn ? 'Duration' : 'Dauer'}: ${formatTimerHuman(item.duration_seconds || 0)}`);
                    e.push('');
                });
            }

            if (adminTimerState.active && (adminTimerState.active.status === 'running' || adminTimerState.active.status === 'paused')) {
                e.push(isEn ? '--- Currently Running / Paused Measurement ---' : '--- Aktuell laufende / pausierte Zeitmessung ---');
                e.push(`${isEn ? 'Status:' : 'Status:'} ${adminTimerState.active.status}`);
                e.push(`${isEn ? 'Subject:' : 'Haupttätigkeit:'} ${adminTimerState.active.subject || adminTimerState.active.activity_description}`);
                if (adminTimerState.active.activities && adminTimerState.active.activities.length > 0) {
                    e.push(`${isEn ? 'Activities:' : 'Tätigkeiten:'}\n` + adminTimerState.active.activities.map((a, i) => `   ${i+1}. ${a}`).join('\n'));
                }
                e.push(`${isEn ? 'Current Duration:' : 'Bisherige Dauer:'} ${formatTimerHuman(adminTimerState.durationSeconds || 0)}`);
                e.push('');
            }

            if (currentInputs.length > 0 && (!adminTimerState.active || adminTimerState.active.status === 'stopped')) {
                e.push(isEn ? '--- Entered Activities (Pending) ---' : '--- Eingegebene Tätigkeiten ---');
                currentInputs.forEach((a, i) => e.push(`   ${i+1}. ${a}`));
                e.push('');
            }

            if ((!adminTimerState.completed || adminTimerState.completed.length === 0) && !adminTimerState.active && currentInputs.length === 0) {
                e.push(isEn ? '(No completed time measurements recorded yet. Notice of time handover.)' : '(Bisher noch keine abgeschlossene Zeitmessung hinterlegt. Benachrichtigung zur Zeitübergabe.)');
                e.push('');
            }

            e.push(isEn ? 'This message is for internal information purposes only.' : 'Diese Nachricht dient ausschließlich der internen Information.');
            e.push('');
            e.push(isEn ? 'Best regards,' : 'Viele Grüße,');
            e.push('{{ Auth::user()->name }}');

            const dateStr = new Date().toLocaleDateString('de-DE');
            const subject = `${isEn ? 'Time Tracking Handover' : 'Zeitmessung Übergabe'} - {{ Auth::user()->name }} - ${dateStr}`;
            const userEmail = '{{ Auth::user()->email ?? "" }}';
            let mailto = `mailto:dennis@besseler.de?subject=${encodeURIComponent(subject)}`;
            if (userEmail) {
                mailto += `&cc=${encodeURIComponent(userEmail)}`;
            }
            mailto += `&body=${encodeURIComponent(e.join('\n'))}`;

            window.location.href = mailto;
        }

        // React to global language changes
        window.addEventListener('portalLanguageChanged', () => {
            renderAdminTimer();
        });

        function handleNewCustCourse(select) {
            const opt = select.options[select.selectedIndex];
            const duration = parseInt(opt?.getAttribute('data-duration') || '120', 10);
            const startInput = document.getElementById('new-cust-start-date');
            const endInput = document.getElementById('new-cust-end-date');
            const hint = document.getElementById('new-cust-duration-hint');
            const check = document.getElementById('new-cust-early-check');
            const btn = document.getElementById('new-cust-early-btn');

            if (!select.value) {
                if (startInput) startInput.disabled = true;
                if (endInput) endInput.disabled = true;
                if (check) check.disabled = true;
                if (btn) btn.disabled = true;
                if (hint) hint.innerText = 'Wird nach der Kursauswahl berechnet.';
                return;
            }

            if (startInput) startInput.disabled = false;
            if (endInput) endInput.disabled = false;
            if (check) check.disabled = false;
            if (btn && check) btn.disabled = !check.checked;

            recalcNewCustEnd();
        }

        function recalcNewCustEnd() {
            const select = document.getElementById('new-cust-course-select');
            const startInput = document.getElementById('new-cust-start-date');
            const endInput = document.getElementById('new-cust-end-date');
            const hint = document.getElementById('new-cust-duration-hint');
            if (!select || !select.value || !startInput || !startInput.value) return;

            const opt = select.options[select.selectedIndex];
            const duration = parseInt(opt?.getAttribute('data-duration') || '120', 10);
            const startDate = new Date(startInput.value);
            if (isNaN(startDate.getTime())) return;

            const endDate = new Date(startDate.getTime() + duration * 24 * 60 * 60 * 1000);
            const yyyy = endDate.getFullYear();
            const mm = String(endDate.getMonth() + 1).padStart(2, '0');
            const dd = String(endDate.getDate()).padStart(2, '0');
            if (endInput) endInput.value = `${yyyy}-${mm}-${dd}`;
            if (hint) hint.innerText = `${duration} Tage · danach automatische Deaktivierung · kein Abo · frei änderbar`;
        }

        function updateAssignCourseDates(customerId) {
            const select = document.getElementById('assign-course-' + customerId);
            const startInput = document.getElementById('assign-start-' + customerId);
            const endInput = document.getElementById('assign-end-' + customerId);
            const check = document.getElementById('assign-early-check-' + customerId);
            const btn = document.getElementById('assign-early-btn-' + customerId);
            const hint = document.getElementById('assign-hint-' + customerId);
            if (!select) return;

            const opt = select.options[select.selectedIndex];
            const duration = parseInt(opt?.getAttribute('data-duration') || '120', 10);
            
            if (check) check.disabled = !select.value;
            if (btn) btn.disabled = !select.value || !check.checked;
            
            if (!select.value) {
                if (hint) hint.innerText = 'Kurs auswählen';
                return;
            }

            if (hint) {
                hint.innerText = `Standard: Start in 14 Tagen · ${duration} Tage · beide Termine frei änderbar`;
            }

            recalcAssignCourseEndDate(customerId);
        }

        function recalcAssignCourseEndDate(customerId) {
            const select = document.getElementById('assign-course-' + customerId);
            const startInput = document.getElementById('assign-start-' + customerId);
            const endInput = document.getElementById('assign-end-' + customerId);
            if (!select || !startInput || !endInput) return;

            const opt = select.options[select.selectedIndex];
            const duration = parseInt(opt?.getAttribute('data-duration') || '120', 10);
            const startDate = new Date(startInput.value);
            if (isNaN(startDate.getTime())) return;

            const endDate = new Date(startDate.getTime() + duration * 24 * 60 * 60 * 1000);
            const yyyy = endDate.getFullYear();
            const mm = String(endDate.getMonth() + 1).padStart(2, '0');
            const dd = String(endDate.getDate()).padStart(2, '0');
            endInput.value = `${yyyy}-${mm}-${dd}`;
        }

        function filterCustomerCards(query) {
            const q = (query || '').toLowerCase().trim();
            const cards = document.querySelectorAll('.customer-list .customer-card');
            let visible = 0;
            cards.forEach(card => {
                const text = (card.textContent || '').toLowerCase();
                if (!q || text.includes(q)) {
                    card.style.display = '';
                    visible++;
                } else {
                    card.style.display = 'none';
                }
            });
            const emptyEl = document.getElementById('customer-filter-empty');
            if (emptyEl) {
                emptyEl.style.display = (visible === 0 && cards.length > 0) ? 'block' : 'none';
            }
        }

        // Initialize WorkTimer on load
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', fetchAdminTimerStatus);
        } else {
            fetchAdminTimerStatus();
        }
    </script>
@endsection
