@extends('admin.layouts.app2')

@section('contents')
    <main class="admin-workspace" id="admin-page-top">
        <header class="admin-topbar">
            <div>
                <span class="account-role-badge is-admin">ADMIN-KONTO</span>
                <strong>DENNIS BESSELER · KUNDENZUGÄNGE</strong>
            </div>
            <nav>
                <a href="{{ route('home') }}" target="_blank">Kursportal öffnen</a>
                <a href="{{ route('member.dashboard') }}" target="_blank">Kundenbereich</a>
                <form method="post" action="{{ route('admin.logout') }}" style="display:inline;">
                    @csrf
                    <button class="admin-logout-button" type="submit">Abmelden</button>
                </form>
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

        @if(session('created_staff'))
            @php $newStaff = session('created_staff'); @endphp
            <div style="background:#1e293b; border:2px solid #a855f7; color:#f8fafc; padding:1.5rem; border-radius:8px; margin:1rem 2rem;">
                <h3 style="margin-top:0; color:#c084fc;">✓ Neues Mitarbeiterkonto erfolgreich angelegt</h3>
                <div style="background:#0f172a; padding:1rem; border-radius:6px; font-family:monospace; font-size:0.95rem;">
                    <strong>Name:</strong> {{ $newStaff['name'] }}<br>
                    <strong>Benutzername:</strong> {{ $newStaff['username'] }}<br>
                    <strong>Passwort:</strong> <span style="color:#c084fc; font-weight:bold;">{{ $newStaff['password'] }}</span><br>
                    <strong>Login-URL:</strong> {{ url('/login') }}
                </div>
            </div>
        @endif

        @if($errors->any())
            <div style="background:#7f1d1d; color:#fca5a5; padding:1rem 1.5rem; border-radius:8px; margin:1rem 2rem;">
                <ul style="margin:0; padding-left:1.25rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <nav class="admin-index" id="admin-navigation" aria-label="Inhaltsverzeichnis">
            <div class="admin-index-links">
                <a href="#arbeitsmittel"><span>00</span>Bank &amp; Cloud</a>
                <a href="#mitarbeiter"><span>MA</span>Mitarbeiter ({{ $staffMembers->count() }})</a>
                <a href="#hauptadmin-sicherheit"><span>SI</span>Admin-Sicherheit</a>
                <a href="#datenaustausch"><span>DT</span>Datentausch</a>
                <a href="#zugangsanfragen"><span>02</span>Anfragen ({{ $accessRequests->count() }})</a>
                <a href="#kunden"><span>03</span>Kunden ({{ $customers->count() }})</a>
                <a href="#anlegen"><span>04</span>Anlegen</a>
                <a href="#medien"><span>LM</span>Lektionen &amp; Medien</a>
                <a href="#auslieferung"><span>05</span>Auslieferung</a>
                <a href="#sicherheit"><span>06</span>Ablauf</a>
                <a href="#naechste-version"><span>NV</span>Nächste Version ({{ $versionNotes->count() }})</a>
                <a href="#pinnwand"><span>01</span>Notizen ({{ $adminNotes->count() }})</a>
            </div>
            <div class="work-timer is-compact notranslate" translate="no" id="admin-work-timer-wrapper">
                <button class="work-timer-toggle" id="admin-timer-toggle-btn" type="button" aria-expanded="false" onclick="toggleAdminWorkTimerPanel()">
                    <span id="admin-timer-label">Timer</span>
                    <b id="admin-timer-clock">00:00:00</b>
                </button>
                <div class="work-timer-panel" id="admin-timer-panel" style="display: none;">
                    <div class="work-timer-panel-head">
                        <strong>Zeitmessung</strong>
                        <button type="button" aria-label="Timer minimieren" onclick="toggleAdminWorkTimerPanel(false)">
                            <span aria-hidden="true">×</span> Minimieren
                        </button>
                    </div>

                    {{-- Active Running Box --}}
                    <div class="work-timer-running" id="admin-timer-running-box" style="display: none;">
                        <span>Aktuelle Zeitmessung</span>
                        <strong id="admin-timer-active-subject">Kundenbetreuung</strong>
                        <b id="admin-timer-big-clock">00:00:00</b>
                        <button type="button" onclick="adminStopTimer()">Zeit stoppen</button>
                    </div>

                    {{-- Start Form --}}
                    <form id="admin-timer-start-form" onsubmit="adminStartTimer(event)">
                        <label>
                            <span>Betreff</span>
                            <input required maxlength="120" id="admin-timer-input-subject" placeholder="Wofür wird die Zeit gestoppt?">
                        </label>
                        <button type="submit" id="admin-timer-start-submit-btn">Zeitmessung starten</button>
                    </form>

                    <p role="alert" id="admin-timer-alert" style="display: none; color: #f87171; font-size: 0.82rem; margin-top: 0.5rem;"></p>

                    {{-- History --}}
                    <div class="work-timer-history">
                        <span>Die drei letzten Messungen</span>
                        <p class="work-timer-limit" role="note">
                            Wichtig: Es werden höchstens drei abgeschlossene Zeitmessungen gespeichert. Sobald eine vierte Messung abgeschlossen wird, wird der älteste Eintrag automatisch gelöscht.
                        </p>
                        <div id="admin-timer-history-container">
                            <small>Noch keine abgeschlossene Zeitmessung.</small>
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

        {{-- Staff Portal Link Card --}}
        <section class="admin-staff-portal-link" aria-labelledby="staff-portal-link-title">
            <div>
                <p class="eyebrow">Direkter Mitarbeiterzugang</p>
                <h2 id="staff-portal-link-title">Mitarbeiter-Login</h2>
                <code>/login</code>
                <p>Diesen Link an Mitarbeiter weitergeben oder selbst zur Kontrolle öffnen.</p>
            </div>
            <div>
                <a href="{{ route('login') }}" target="_blank" rel="noreferrer">Mitarbeiter-Login öffnen</a>
                <button type="button" onclick="copyToClipboard('{{ url('/login') }}', this)">Link kopieren</button>
            </div>
        </section>

        {{-- Admin Hero --}}
        <section class="admin-hero">
            <p class="eyebrow">Kundenverwaltung</p>
            <h1>Kunden anlegen.<br/>Kurse freigeben.<br/>Zugänge steuern.</h1>
            <p>Wartungsarme Kundenverwaltung mit bewusst minimalen personenbezogenen Daten.</p>
            <div class="admin-warning">
                <strong>Datensparsam aufgebaut</strong>
                <span>Gespeichert werden nur Vorname, technischer Benutzername, Kunden-/Rechnungsnummer sowie Kurs-, Laufzeit- und Gerätedaten. Nach Ablauf der letzten Freigabe wird das Portalkonto automatisch gelöscht; die gesetzlich erforderliche Rechnung bleibt getrennt in der Buchhaltung.</span>
            </div>
        </section>

        {{-- MA Mitarbeiter --}}
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
                    <label><input type="checkbox" name="permissions[create_customers]" value="1" checked/><span>Kundenkonten anlegen</span></label>
                    <label><input type="checkbox" name="permissions[manage_enrollments]" value="1" checked/><span>Kursfreigaben und Laufzeiten verwalten</span></label>
                    <label><input type="checkbox" name="permissions[reset_passwords]" value="1" checked/><span>Kundenpasswörter neu erzeugen</span></label>
                    <label><input type="checkbox" name="permissions[toggle_active]" value="1" checked/><span>Kundenkonten aktivieren und sperren</span></label>
                </fieldset>
                <button type="submit">Mitarbeiterkonto verbindlich anlegen</button>
            </form>

            <div class="admin-staff-list" style="margin-top:1.5rem;">
                @forelse($staffMembers as $staff)
                    <div style="background:#1e293b; padding:1.25rem; border-radius:8px; margin-bottom:1rem; display:flex; justify-content:space-between; align-items:center; border:1px solid #334155;">
                        <div>
                            <strong style="color:#f8fafc; font-size:1.1rem;">{{ $staff->name }}</strong>
                            <span style="color:#94a3b8; margin-left:0.5rem;">({{ $staff->occupation ?: 'Mitarbeiter' }})</span>
                            <div style="color:#64748b; font-size:0.85rem; margin-top:0.25rem;">
                                Login: <code style="color:#38bdf8;">{{ $staff->username }}</code> · Gültig von: {{ $staff->access_from?->format('d.m.Y') ?: 'Sofort' }} bis: {{ $staff->access_until?->format('d.m.Y') ?: 'Unbegrenzt' }}
                            </div>
                        </div>
                        <form method="POST" action="{{ route('admin.staff.delete', $staff->id) }}" onsubmit="return confirm('Möchten Sie dieses Mitarbeiterkonto wirklich löschen?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:#dc2626; color:#fff; border:none; padding:0.4rem 0.8rem; border-radius:4px; cursor:pointer;">Löschen</button>
                        </form>
                    </div>
                @empty
                    <p>Noch keine Mitarbeiterkonten angelegt.</p>
                @endforelse
            </div>
        </section>

        {{-- NV Nächste Version --}}
        <section class="admin-section admin-version-pinboard" id="naechste-version" aria-labelledby="version-pinboard-title">
            <header>
                <div>
                    <span>NV</span>
                    <p class="eyebrow">Nur Dennis · dauerhaft</p>
                </div>
                <h2 id="version-pinboard-title">Ideen für die nächste Portalversion</h2>
            </header>
            <p class="version-pinboard-intro">Dieser feste Planungsblock bleibt ausschließlich in Dennis’ Administrationsbereich sichtbar. Seine Einträge werden nicht automatisch gelöscht. Ein Eintrag kann nur nach ausdrücklicher Löschbestätigung entfernt werden.</p>
            
            <form method="POST" action="{{ route('admin.version-notes.store') }}" class="note-form version-note-form" id="version-pinboard-form">
                @csrf
                <input type="text" name="title" maxLength="120" placeholder="Kurzer Titel der Änderung" aria-label="Titel für die nächste Portalversion" required/>
                <textarea name="body" id="version-pinboard-body" maxLength="3000" rows="5" placeholder="Was soll bei der nächsten Portalversion geändert oder ergänzt werden?" aria-label="Änderungsidee für die nächste Portalversion" required></textarea>
                <button type="submit">Dauerhaft eintragen</button>
            </form>

            <div class="version-note-list" style="margin-top:1.5rem;">
                @forelse($versionNotes as $vNote)
                    <div style="background:#1e293b; padding:1.25rem; border-radius:8px; margin-bottom:1rem; border-left:4px solid #38bdf8;">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                            <strong style="color:#f8fafc; font-size:1.1rem;">{{ $vNote->title }}</strong>
                            <form method="POST" action="{{ route('admin.version-notes.delete', $vNote->id) }}" onsubmit="return confirm('Möchten Sie diesen dauerhaften Eintrag wirklich entfernen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background:transparent; color:#ef4444; border:1px solid #ef4444; padding:0.25rem 0.6rem; border-radius:4px; cursor:pointer;">Entfernen</button>
                            </form>
                        </div>
                        <p style="color:#cbd5e1; margin-top:0.5rem; white-space:pre-wrap;">{{ $vNote->body }}</p>
                        <small style="color:#64748b;">Eingetragen am {{ $vNote->created_at->format('d.m.Y H:i') }} Uhr</small>
                    </div>
                @empty
                    <p class="version-note-empty">Noch keine Änderung für die nächste Portalversion eingetragen.</p>
                @endforelse
            </div>
        </section>

        {{-- 01 Pinnwand --}}
        <section class="admin-section admin-service admin-pinboard" id="pinnwand">
            <header>
                <div>
                    <span>01</span>
                    <p class="eyebrow">Persönliche Admin-Notizen</p>
                </div>
                <h2>Eigene Arbeitsnotizen festhalten.</h2>
            </header>
            <p class="pinboard-intro">Nur dein Administratorkonto sieht diese Notizen. Mitarbeiterkonten sehen sie nicht. Maximal fünf persönliche Notizen bleiben gespeichert; nach zehn Tagen werden sie automatisch gelöscht.</p>
            
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

        {{-- DT Datenaustausch --}}
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

        {{-- 03 Kundenkonten --}}
        <section class="admin-section" id="kunden">
            <header>
                <div>
                    <span>03</span>
                    <p class="eyebrow">Kundenkonten ({{ $customers->count() }})</p>
                </div>
                <h2>Alle Zugänge auf einen Blick.</h2>
            </header>
            
            <div class="admin-toolbar">
                <form method="GET" action="{{ route('admin.dashboard') }}#kunden" style="display:flex; flex:1; gap:0.5rem;">
                    <label style="flex:1;">
                        <span>Kunden suchen</span>
                        <input type="search" name="search" placeholder="Vorname, Benutzername oder Rechnungsnummer" value="{{ $search }}"/>
                    </label>
                    <button type="submit" style="margin-top:auto; padding:0.75rem 1.25rem; background:#38bdf8; color:#0f172a; font-weight:bold; border:none; border-radius:6px; cursor:pointer;">Suchen</button>
                    @if($search)
                        <a href="{{ route('admin.dashboard') }}#kunden" style="margin-top:auto; padding:0.75rem 1rem; background:#475569; color:#fff; border-radius:6px; text-decoration:none; display:flex; align-items:center;">Zurücksetzen</a>
                    @endif
                </form>
                <a class="admin-primary-link" href="#anlegen">Neuen Kundenzugang anlegen</a>
            </div>

            <div style="margin-top:1.5rem; overflow-x:auto;">
                @if($customers->count() > 0)
                    <table style="width:100%; border-collapse:collapse; text-align:left; background:#1e293b; border-radius:8px; overflow:hidden;">
                        <thead>
                            <tr style="background:#0f172a; color:#94a3b8; font-size:0.85rem; text-transform:uppercase;">
                                <th style="padding:1rem;">Vorname / Name</th>
                                <th style="padding:1rem;">Benutzername</th>
                                <th style="padding:1rem;">Rechnung</th>
                                <th style="padding:1rem;">Freigeschalteter Kurs</th>
                                <th style="padding:1rem;">Laufzeit / Gültig bis</th>
                                <th style="padding:1rem;">Gerätebindung</th>
                                <th style="padding:1rem;">Status</th>
                                <th style="padding:1rem; text-align:right;">Aktionen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                                @php
                                    $enrollment = $customer->enrollments->first();
                                @endphp
                                <tr style="border-bottom:1px solid #334155; color:#f8fafc; font-size:0.95rem;">
                                    <td style="padding:1rem;">
                                        <strong>{{ $customer->first_name ?: $customer->name }}</strong>
                                    </td>
                                    <td style="padding:1rem;">
                                        <code style="color:#38bdf8;">{{ $customer->username }}</code>
                                    </td>
                                    <td style="padding:1rem;">
                                        {{ $customer->invoice_number ?: 'N/A' }}
                                    </td>
                                    <td style="padding:1rem;">
                                        @if($enrollment && $enrollment->course)
                                            <span style="color:#a5f3fc; font-weight:500;">{{ $enrollment->course->title }}</span>
                                        @else
                                            <span style="color:#64748b;">Kein Kurs zugewiesen</span>
                                        @endif
                                    </td>
                                    <td style="padding:1rem;">
                                        @if($enrollment)
                                            <span style="font-size:0.85rem; color:#cbd5e1;">
                                                {{ $enrollment->started_at?->format('d.m.Y') }} bis {{ $enrollment->expires_at?->format('d.m.Y') }}
                                            </span>
                                        @else
                                            <span style="color:#64748b;">—</span>
                                        @endif
                                    </td>
                                    <td style="padding:1rem;">
                                        @if($customer->device_id)
                                            <span style="display:inline-block; padding:0.2rem 0.5rem; background:#1e3a5f; color:#38bdf8; border-radius:4px; font-size:0.8rem;" title="{{ $customer->device_name }}">
                                                🔒 Gebunden ({{ substr($customer->device_id, 0, 8) }}…)
                                            </span>
                                        @else
                                            <span style="color:#64748b; font-size:0.85rem;">Noch kein Gerät</span>
                                        @endif
                                    </td>
                                    <td style="padding:1rem;">
                                        @if($customer->is_active)
                                            <span style="color:#4ade80; font-weight:bold; font-size:0.85rem;">● Aktiv</span>
                                        @else
                                            <span style="color:#f87171; font-weight:bold; font-size:0.85rem;">● Gesperrt</span>
                                        @endif
                                    </td>
                                    <td style="padding:1rem; text-align:right;">
                                        <div style="display:flex; justify-content:flex-end; gap:0.4rem;">
                                            @if($customer->device_id)
                                                <form method="POST" action="{{ route('admin.customers.reset-device', $customer->id) }}" onsubmit="return confirm('Gerätebindung für {{ $customer->username }} zurücksetzen?');">
                                                    @csrf
                                                    <button type="submit" style="background:#0284c7; color:#fff; border:none; padding:0.35rem 0.6rem; border-radius:4px; cursor:pointer; font-size:0.8rem;" title="Gerätebindung zurücksetzen">Gerät reset</button>
                                                </form>
                                            @endif

                                            <form method="POST" action="{{ route('admin.customers.toggle', $customer->id) }}">
                                                @csrf
                                                <button type="submit" style="background:{{ $customer->is_active ? '#ca8a04' : '#16a34a' }}; color:#fff; border:none; padding:0.35rem 0.6rem; border-radius:4px; cursor:pointer; font-size:0.8rem;">
                                                    {{ $customer->is_active ? 'Sperren' : 'Aktivieren' }}
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('admin.customers.delete', $customer->id) }}" onsubmit="return confirm('Möchten Sie das Kundenkonto {{ $customer->username }} endgültig und datensparsam löschen?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="background:#dc2626; color:#fff; border:none; padding:0.35rem 0.6rem; border-radius:4px; cursor:pointer; font-size:0.8rem;">Löschen</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="admin-empty">
                        <strong>Keine Kundenkonten gefunden</strong>
                        <p>Legen Sie über das folgende Formular einen neuen Zugang an.</p>
                    </div>
                @endif
            </div>
        </section>

        {{-- 04 Anlegen --}}
        <section class="admin-section admin-public" id="anlegen">
            <header>
                <div>
                    <span>04</span>
                    <p class="eyebrow">Zugang anlegen</p>
                </div>
                <h2>Nur das Nötigste speichern.</h2>
            </header>
            <form method="POST" action="{{ route('admin.customers.store') }}" class="admin-form-preview">
                @csrf
                <label>
                    <span>Vorname</span>
                    <input type="text" name="first_name" required placeholder="Nur Vorname (z. B. Max)" value="{{ old('first_name') }}"/>
                </label>
                <label>
                    <span>Technischer Benutzername</span>
                    <input type="text" name="username" required placeholder="Eindeutiger Loginname (z. B. max.m)" value="{{ old('username') }}"/>
                </label>
                <label>
                    <span>Kunden-/Rechnungsnummer</span>
                    <input type="text" name="invoice_number" required placeholder="Rückverfolgung nur über Buchhaltung (z. B. RE-2026-042)" value="{{ old('invoice_number') }}"/>
                </label>
                <label>
                    <span>Passwort (optional)</span>
                    <input type="password" name="password" autocomplete="new-password" placeholder="Leer lassen: wird sicher erzeugt"/>
                    <small>Eigenes Passwort: mindestens 8 Zeichen. Leer lassen erzeugt automatisch ein sicheres Passwort zur Übergabe.</small>
                </label>
                <label>
                    <span>Kurs zuweisen</span>
                    <select name="course_slug" id="course_select">
                        <option value="">Noch keinen Kurs zuweisen</option>
                        @foreach($courses as $c)
                            <option value="{{ $c->slug }}" {{ $c->slug === 'dnl-kompakt' ? 'selected' : '' }}>{{ $c->title }} ({{ $c->duration_days }} Tage)</option>
                        @endforeach
                    </select>
                </label>
                <label>
                    <span>Startdatum</span>
                    <input type="date" name="start_date" id="start_date_input" value="{{ date('Y-m-d') }}"/>
                    <small>Standardmäßig ab heute oder nach Vereinbarung frei änderbar.</small>
                </label>
                <label class="early-start-confirmation">
                    <input type="checkbox" name="early_start" value="1" checked/>
                    <span>Ausdrückliche Kundenerklärung zum vorzeitigen Beginn liegt dokumentiert vor (Sofortstart).</span>
                </label>
                <button type="submit">Kundenkonto sicher anlegen</button>
            </form>
        </section>

        {{-- LM Lektionen & Medienverwaltung --}}
        <style>
            .mm-scope * { box-sizing: border-box; }
            .mm-panel {
                background: #0f172a;
                border: 1px solid #1e293b;
                border-radius: 12px;
                padding: 1.75rem;
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4);
                margin-bottom: 2rem;
            }
            .mm-form {
                display: flex;
                flex-direction: column;
                gap: 1.25rem;
            }
            .mm-grid-2 {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
                gap: 1.25rem;
            }
            .mm-grid-3 {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                gap: 1.25rem;
            }
            .mm-grid-media {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 1.25rem;
                margin: 0.5rem 0;
            }
            .mm-label {
                display: flex;
                flex-direction: column;
                gap: 0.45rem;
                width: 100%;
            }
            .mm-label-title {
                color: #94a3b8;
                font-size: 0.78rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }
            .mm-input,
            .mm-select,
            .mm-textarea {
                background: #131d31 !important;
                border: 1px solid #273549 !important;
                color: #f8fafc !important;
                border-radius: 8px !important;
                padding: 0.75rem 1rem !important;
                font-size: 0.95rem !important;
                min-height: 46px !important;
                width: 100% !important;
                transition: all 0.2s ease !important;
                font-family: inherit !important;
            }
            .mm-input:focus,
            .mm-select:focus,
            .mm-textarea:focus {
                border-color: #38bdf8 !important;
                background: #0b1324 !important;
                box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.2) !important;
                outline: none !important;
            }
            .mm-textarea {
                min-height: 130px !important;
                line-height: 1.6 !important;
                resize: vertical;
                font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace !important;
                font-size: 0.88rem !important;
            }
            .mm-media-box {
                background: #131d31;
                border: 1px solid #273549;
                border-radius: 10px;
                padding: 1.25rem;
                display: flex;
                flex-direction: column;
                gap: 0.85rem;
                position: relative;
            }
            .mm-media-box.is-video { border-top: 3px solid #38bdf8; }
            .mm-media-box.is-pdf { border-top: 3px solid #c084fc; }
            .mm-media-box.is-audio { border-top: 3px solid #34d399; }
            .mm-media-header {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                font-weight: 700;
                font-size: 0.95rem;
            }
            .mm-media-box.is-video .mm-media-header { color: #38bdf8; }
            .mm-media-box.is-pdf .mm-media-header { color: #c084fc; }
            .mm-media-box.is-audio .mm-media-header { color: #34d399; }
            .mm-file-zone {
                background: #0b1324;
                border: 1.5px dashed #334155;
                border-radius: 8px;
                padding: 0.85rem 1rem;
                display: flex;
                flex-direction: column;
                gap: 0.4rem;
                transition: border-color 0.2s;
            }
            .mm-file-zone:hover { border-color: #38bdf8; }
            .mm-file-input {
                color: #cbd5e1;
                font-size: 0.85rem;
                cursor: pointer;
                background: transparent !important;
                border: none !important;
                padding: 0 !important;
                min-height: auto !important;
            }
            .mm-file-input::-webkit-file-upload-button {
                background: #1e293b;
                color: #38bdf8;
                border: 1px solid #38bdf8;
                padding: 0.4rem 0.85rem;
                border-radius: 6px;
                font-size: 0.8rem;
                font-weight: 600;
                cursor: pointer;
                margin-right: 0.75rem;
                transition: all 0.2s;
            }
            .mm-file-input::-webkit-file-upload-button:hover {
                background: #0284c7;
                color: #fff;
            }
            .mm-checkbox-wrap {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                cursor: pointer;
                user-select: none;
                margin: 0.5rem 0;
            }
            .mm-checkbox-wrap input[type="checkbox"] {
                width: 20px !important;
                height: 20px !important;
                min-height: 20px !important;
                accent-color: #0284c7;
                cursor: pointer;
                margin: 0 !important;
                padding: 0 !important;
                border-radius: 4px;
            }
            .mm-checkbox-label {
                color: #e2e8f0;
                font-size: 0.9rem;
                font-weight: 500;
            }
            .mm-btn-submit {
                background: linear-gradient(135deg, #0284c7, #0369a1);
                color: #ffffff;
                font-weight: 700;
                font-size: 0.95rem;
                padding: 0.85rem 1.75rem;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                box-shadow: 0 4px 14px rgba(2, 132, 199, 0.35);
                transition: transform 0.15s, box-shadow 0.15s;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
            }
            .mm-btn-submit:hover {
                transform: translateY(-1px);
                box-shadow: 0 6px 20px rgba(2, 132, 199, 0.5);
                background: linear-gradient(135deg, #0369a1, #0284c7);
            }
            .mm-btn-cancel {
                background: #1e293b;
                color: #cbd5e1;
                font-weight: 600;
                font-size: 0.9rem;
                padding: 0.85rem 1.4rem;
                border: 1px solid #334155;
                border-radius: 8px;
                cursor: pointer;
                transition: background 0.15s;
            }
            .mm-btn-cancel:hover {
                background: #334155;
                color: #fff;
            }
            .mm-current-info {
                font-size: 0.82rem;
                color: #94a3b8;
                background: #0b1324;
                padding: 0.4rem 0.6rem;
                border-radius: 6px;
                border: 1px solid #1e293b;
                word-break: break-all;
            }
        </style>

        <section class="admin-section mm-scope" id="medien">
            <header>
                <div>
                    <span>LM</span>
                    <p class="eyebrow">Kurse &amp; Medien-Upload</p>
                </div>
                <h2>Lektionen verwalten &amp; Dateien hochladen.</h2>
            </header>
            
            <div style="background: linear-gradient(135deg, #1e293b, #0f172a); border-left: 4px solid #38bdf8; padding: 1.25rem 1.5rem; border-radius: 10px; margin-bottom: 1.5rem; border-top: 1px solid #334155; border-right: 1px solid #334155; border-bottom: 1px solid #334155;">
                <strong style="color: #38bdf8; font-size: 1.05rem; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.4rem;">
                    <span>🎬 Video</span> · <span>📄 PDF</span> · <span>🎧 Audio Direkt-Upload</span>
                </strong>
                <span style="color: #cbd5e1; font-size: 0.92rem; line-height: 1.55;">
                    Laden Sie hier neue Videodateien (MP4/WebM), begleitende PDF-Arbeitsblätter oder Audio-Reflexionsübungen direkt in den geschützten Speicher hoch. Alternativ können auch externe Video-Stream-URLs hinterlegt werden.
                </span>
            </div>

            {{-- Action Panels: Add Course & Add Lesson --}}
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:1.25rem; margin-bottom:2rem;">
                
                {{-- 1. Create New Course Panel --}}
                <div class="mm-panel" style="margin-bottom:0;">
                    <div style="display:flex; justify-content:space-between; align-items:center; cursor:pointer;" onclick="toggleNewCourseForm()">
                        <h3 style="margin:0; color:#f8fafc; font-size:1.15rem; display:flex; align-items:center; gap:0.6rem;">
                            <span style="background:#059669; color:#fff; width:28px; height:28px; border-radius:50%; display:inline-flex; align-items:center; justify-content:center; font-size:1rem; font-weight:bold;">+</span>
                            Neuen Kurs anlegen
                        </h3>
                        <span id="toggle-course-indicator" style="background:#1e293b; color:#34d399; padding:0.4rem 0.8rem; border-radius:6px; font-size:0.85rem; font-weight:600; border:1px solid #334155;">
                            Kurs anlegen ▼
                        </span>
                    </div>

                    <form id="new-course-form" method="POST" action="{{ route('admin.courses.store') }}" enctype="multipart/form-data" class="mm-form" style="display:none; margin-top:1.5rem; border-top:1px solid #1e293b; padding-top:1.5rem;">
                        @csrf
                        
                        <div class="mm-grid-2">
                            <div class="mm-label">
                                <span class="mm-label-title">Kurstitel *</span>
                                <input type="text" name="title" class="mm-input" required placeholder="z. B. Führungskompetenz &amp; Coaching" value="{{ old('title') }}"/>
                            </div>
                            <div class="mm-label">
                                <span class="mm-label-title">Kategorie *</span>
                                <input type="text" name="category" class="mm-input" required placeholder="z. B. Akademie, Prävention oder Business" value="{{ old('category', 'Akademie') }}"/>
                            </div>
                        </div>

                        <div class="mm-label">
                            <span class="mm-label-title">Untertitel</span>
                            <input type="text" name="subtitle" class="mm-input" placeholder="Kurze zusammenfassende Zeile des Kurses" value="{{ old('subtitle') }}"/>
                        </div>

                        <div class="mm-grid-3">
                            <div class="mm-label">
                                <span class="mm-label-title">Laufzeit in Tagen *</span>
                                <input type="number" name="duration_days" class="mm-input" min="1" required placeholder="z. B. 90" value="{{ old('duration_days', 90) }}"/>
                            </div>
                            <div class="mm-label">
                                <span class="mm-label-title">Unterrichtsstunden</span>
                                <input type="text" name="total_hours" class="mm-input" placeholder="z. B. 40 Unterrichtsstunden" value="{{ old('total_hours', '30 Unterrichtsstunden') }}"/>
                            </div>
                            <div class="mm-label">
                                <span class="mm-label-title">Sortierreihenfolge</span>
                                <input type="number" name="order" class="mm-input" min="1" placeholder="z. B. 12" value="{{ old('order') }}"/>
                            </div>
                        </div>

                        <div class="mm-label">
                            <span class="mm-label-title">Kursbeschreibung</span>
                            <textarea name="description" class="mm-textarea" style="min-height:90px !important;" placeholder="Detaillierte Beschreibung der Kursinhalte und Ziele...">{{ old('description') }}</textarea>
                        </div>

                        <div class="mm-grid-2">
                            <div class="mm-label">
                                <span class="mm-label-title">Thumbnail / Vorschaubild (Upload)</span>
                                <div class="mm-file-zone">
                                    <input type="file" name="thumbnail_file" class="mm-file-input" accept="image/*"/>
                                </div>
                            </div>
                            <div class="mm-label">
                                <span class="mm-label-title">Öffentliche Landingpage URL (optional)</span>
                                <input type="url" name="public_url" class="mm-input" placeholder="https://..."/>
                            </div>
                        </div>

                        <div style="margin-top:0.5rem;">
                            <button type="submit" class="mm-btn-submit" style="background:linear-gradient(135deg, #059669, #047857); box-shadow:0 4px 14px rgba(5, 150, 105, 0.35);">
                                ✓ Neuen Kurs verbindlich erstellen
                            </button>
                        </div>
                    </form>
                </div>

                {{-- 2. Create New Lesson Panel --}}
                <div class="mm-panel" style="margin-bottom:0;">
                    <div style="display:flex; justify-content:space-between; align-items:center; cursor:pointer;" onclick="toggleNewLessonForm()">
                        <h3 style="margin:0; color:#f8fafc; font-size:1.15rem; display:flex; align-items:center; gap:0.6rem;">
                            <span style="background:#0284c7; color:#fff; width:28px; height:28px; border-radius:50%; display:inline-flex; align-items:center; justify-content:center; font-size:1rem; font-weight:bold;">+</span>
                            Neue Lektion anlegen
                        </h3>
                        <span id="toggle-lesson-indicator" style="background:#1e293b; color:#38bdf8; padding:0.4rem 0.8rem; border-radius:6px; font-size:0.85rem; font-weight:600; border:1px solid #334155;">
                            Lektion anlegen ▼
                        </span>
                    </div>

                    <form id="new-lesson-form" method="POST" action="" enctype="multipart/form-data" class="mm-form" style="display:none; margin-top:1.5rem; border-top:1px solid #1e293b; padding-top:1.5rem;">
                        @csrf
                        
                        <div class="mm-label">
                            <span class="mm-label-title">Zielkurs auswählen *</span>
                            <select name="target_course" id="target_course_select" class="mm-select" required onchange="updateLessonFormAction(this.value)">
                                <option value="">-- Zielkurs auswählen --</option>
                                @foreach($courses as $c)
                                    <option value="{{ $c->id }}" data-action="{{ route('admin.lessons.store', $c->id) }}">{{ $c->title }} ({{ $c->lessons->count() }} Lektionen)</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mm-grid-2">
                            <div class="mm-label">
                                <span class="mm-label-title">Modul- / Kapitelname *</span>
                                <input type="text" name="chapter_name" class="mm-input" required placeholder="z. B. Modul 1: Grundlagen" value="{{ old('chapter_name') }}"/>
                            </div>
                            <div class="mm-label">
                                <span class="mm-label-title">Lektionstitel *</span>
                                <input type="text" name="title" class="mm-input" required placeholder="z. B. 1. Einführung und Orientierung" value="{{ old('title') }}"/>
                            </div>
                        </div>

                        <div class="mm-grid-3">
                            <div class="mm-label">
                                <span class="mm-label-title">Lektionsnummer</span>
                                <input type="number" name="lesson_number" class="mm-input" min="1" placeholder="z. B. 1" value="{{ old('lesson_number') }}"/>
                            </div>
                            <div class="mm-label">
                                <span class="mm-label-title">Gesamtdauer in Minuten *</span>
                                <input type="number" name="duration_minutes" id="new_duration_minutes" class="mm-input" min="1" placeholder="z. B. 25" value="{{ old('duration_minutes', 15) }}"/>
                                <div id="new_lesson_duration_breakdown" style="font-size:0.78rem; color:#38bdf8; margin-top:0.35rem; background:#0b1324; padding:0.3rem 0.5rem; border-radius:4px; border:1px solid #1e293b; display:none;"></div>
                            </div>
                            <div class="mm-label">
                                <span class="mm-label-title">Reihenfolge (Sortierung)</span>
                                <input type="number" name="order" class="mm-input" min="1" placeholder="z. B. 1" value="{{ old('order') }}"/>
                            </div>
                        </div>

                        {{-- 3-Column Balanced Media Grid --}}
                        <div class="mm-grid-media">
                            {{-- Video Box --}}
                            <div class="mm-media-box is-video">
                                <div class="mm-media-header">
                                    <span>🎬</span>
                                    <span>Video-Quelle</span>
                                </div>
                                <div class="mm-file-zone">
                                    <span style="color:#94a3b8; font-size:0.75rem; font-weight:700; text-transform:uppercase;">Datei hochladen (MP4 / WebM)</span>
                                    <input type="file" name="video_file" class="mm-file-input" accept="video/mp4,video/webm,video/quicktime"/>
                                </div>
                                <div class="mm-label">
                                    <span class="mm-label-title">Oder Video-URL</span>
                                    <input type="url" name="video_url" class="mm-input" placeholder="https://..."/>
                                </div>
                            </div>

                            {{-- PDF Box --}}
                            <div class="mm-media-box is-pdf">
                                <div class="mm-media-header">
                                    <span>📄</span>
                                    <span>PDF-Arbeitsblatt</span>
                                </div>
                                <div class="mm-file-zone">
                                    <span style="color:#94a3b8; font-size:0.75rem; font-weight:700; text-transform:uppercase;">PDF-Datei hochladen</span>
                                    <input type="file" name="pdf_file" class="mm-file-input" accept="application/pdf"/>
                                </div>
                                <div class="mm-label">
                                    <span class="mm-label-title">Anzeigename</span>
                                    <input type="text" name="pdf_attachment_name" class="mm-input" placeholder="z. B. Arbeitsblatt.pdf"/>
                                </div>
                            </div>

                            {{-- Audio Box --}}
                            <div class="mm-media-box is-audio">
                                <div class="mm-media-header">
                                    <span>🎧</span>
                                    <span>Audio-Reflexion</span>
                                </div>
                                <div class="mm-file-zone">
                                    <span style="color:#94a3b8; font-size:0.75rem; font-weight:700; text-transform:uppercase;">Audiodatei (MP3 / WAV)</span>
                                    <input type="file" name="audio_file" class="mm-file-input" accept="audio/mp3,audio/mpeg,audio/wav,audio/m4a"/>
                                </div>
                            </div>
                        </div>

                        {{-- Text / HTML Content Box --}}
                        <div class="mm-label">
                            <span class="mm-label-title">Lektionsinhalt &amp; Textanleitung (HTML / Text)</span>
                            <textarea name="content_html" class="mm-textarea" placeholder="<h3>Willkommen zur Lektion</h3>&#10;<p>In dieser Lektion lernen wir...</p>">{{ old('content_html') }}</textarea>
                        </div>

                        <label class="mm-checkbox-wrap">
                            <input type="checkbox" name="is_preview" value="1"/>
                            <span class="mm-checkbox-label">Kostenlose Vorschau-Lektion</span>
                        </label>

                        <div style="margin-top:0.5rem;">
                            <button type="submit" id="save-lesson-btn" class="mm-btn-submit">
                                ✓ Lektion mit Mediendateien anlegen
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Course Filter & Lessons Table --}}
            <div>
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem; margin-bottom:1.25rem;">
                    <h3 style="margin:0; color:#f8fafc; font-size:1.15rem; font-weight:600;">Bestehende Lektionen nach Kurs:</h3>
                    <select id="course_filter_select" onchange="filterCourseLessons(this.value)" class="mm-select" style="max-width:360px; min-height:42px !important; color:#38bdf8 !important; font-weight:600;">
                        <option value="all">Alle Kurse anzeigen ({{ $courses->sum('lessons_count') }} Lektionen)</option>
                        @foreach($courses as $c)
                            <option value="course-card-{{ $c->id }}" {{ $c->slug === 'dnl-kompakt' ? 'selected' : '' }}>
                                {{ $c->title }} ({{ $c->lessons->count() }} Lektionen)
                            </option>
                        @endforeach
                    </select>
                </div>

                @foreach($courses as $c)
                    <div class="course-lesson-group course-card-{{ $c->id }}" style="background:#131d31; border-radius:10px; border:1px solid #273549; padding:1.5rem; margin-bottom:1.5rem;">
                        <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #273549; padding-bottom:0.85rem; margin-bottom:1rem; flex-wrap:wrap; gap:0.75rem;">
                            <div>
                                <strong style="color:#38bdf8; font-size:1.2rem;">{{ $c->title }}</strong>
                                <span style="color:#94a3b8; font-size:0.88rem; margin-left:0.5rem;">({{ $c->lessons->count() }} Lektionen · {{ $c->category ?: 'Allgemein' }} · {{ $c->duration_days }} Tage)</span>
                            </div>
                            <div style="display:flex; gap:0.45rem; flex-wrap:wrap;">
                                <a href="{{ route('course.show', $c->slug) }}" target="_blank" style="background:#0f172a; color:#38bdf8; border:1px solid #38bdf8; padding:0.4rem 0.75rem; border-radius:6px; text-decoration:none; font-size:0.82rem; font-weight:600; display:inline-flex; align-items:center; gap:0.35rem;">
                                    Player ↗
                                </a>
                                <button type="button" onclick="openEditCourseModal({{ json_encode($c) }}, '{{ route('admin.courses.update', $c->id) }}')" style="background:#1e293b; color:#cbd5e1; border:1px solid #334155; padding:0.4rem 0.75rem; border-radius:6px; font-size:0.82rem; cursor:pointer; font-weight:600;">
                                    Kurs bearbeiten
                                </button>
                                <button type="button" onclick="prepareNewLessonForCourse('{{ $c->id }}', '{{ route('admin.lessons.store', $c->id) }}')" style="background:#0284c7; color:#fff; border:none; padding:0.4rem 0.75rem; border-radius:6px; font-size:0.82rem; cursor:pointer; font-weight:600; display:inline-flex; align-items:center; gap:0.35rem;">
                                    + Lektion
                                </button>
                                <form method="POST" action="{{ route('admin.courses.delete', $c->id) }}" onsubmit="return confirm('Möchten Sie den gesamten Kurs \'{{ $c->title }}\' und alle zugehörigen Lektionen wirklich löschen?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background:#dc2626; color:#fff; border:none; padding:0.4rem 0.65rem; border-radius:6px; cursor:pointer; font-size:0.82rem; font-weight:600;">
                                        Löschen
                                    </button>
                                </form>
                            </div>
                        </div>

                        @if($c->lessons->count() > 0)
                            <div style="overflow-x:auto;">
                                <table style="width:100%; border-collapse:collapse; text-align:left; font-size:0.92rem;">
                                    <thead>
                                        <tr style="color:#94a3b8; border-bottom:1px solid #273549; font-size:0.8rem; text-transform:uppercase; letter-spacing:0.04em;">
                                            <th style="padding:0.75rem 0.6rem;">Nr.</th>
                                            <th style="padding:0.75rem 0.6rem;">Modul</th>
                                            <th style="padding:0.75rem 0.6rem;">Lektionstitel</th>
                                            <th style="padding:0.75rem 0.6rem;">Dauer</th>
                                            <th style="padding:0.75rem 0.6rem;">Medien</th>
                                            <th style="padding:0.75rem 0.6rem; text-align:right;">Aktionen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($c->lessons as $les)
                                            <tr style="border-bottom:1px solid #1e293b; color:#f8fafc;">
                                                <td style="padding:0.85rem 0.6rem; color:#38bdf8; font-weight:bold;">
                                                    #{{ $les->lesson_number }}
                                                </td>
                                                <td style="padding:0.85rem 0.6rem; color:#cbd5e1; font-size:0.85rem;">
                                                    {{ $les->chapter_name ?: 'Hauptmodul' }}
                                                </td>
                                                <td style="padding:0.85rem 0.6rem;">
                                                    <strong style="color:#f8fafc;">{{ $les->title }}</strong>
                                                    @if($les->is_preview)
                                                        <span style="background:#14532d; color:#86efac; font-size:0.7rem; font-weight:bold; padding:0.15rem 0.45rem; border-radius:4px; margin-left:0.4rem; border:1px solid #16a34a;">Vorschau</span>
                                                    @endif
                                                </td>
                                                <td style="padding:0.85rem 0.6rem; color:#94a3b8; font-size:0.85rem;">
                                                    {{ $les->duration_minutes }} Min.
                                                </td>
                                                <td style="padding:0.85rem 0.6rem;">
                                                    <div style="display:flex; gap:0.4rem; flex-wrap:wrap;">
                                                        @if($les->video_path)
                                                            <span style="background:#1e3a5f; color:#38bdf8; border:1px solid #0284c7; padding:0.25rem 0.5rem; border-radius:4px; font-size:0.75rem; font-weight:600;" title="Upload: {{ $les->video_path }}">
                                                                🎬 Video (Datei)
                                                            </span>
                                                        @elseif($les->video_url)
                                                            <span style="background:#1e293b; color:#94a3b8; border:1px solid #475569; padding:0.25rem 0.5rem; border-radius:4px; font-size:0.75rem;" title="URL: {{ $les->video_url }}">
                                                                🔗 Video (URL)
                                                            </span>
                                                        @else
                                                            <span style="color:#64748b; font-size:0.75rem;">Kein Video</span>
                                                        @endif

                                                        @if($les->pdf_attachment_path || $les->pdf_attachment_name)
                                                            <span style="background:#3b1d5c; color:#c084fc; border:1px solid #9333ea; padding:0.25rem 0.5rem; border-radius:4px; font-size:0.75rem; font-weight:600;" title="{{ $les->pdf_attachment_name ?: 'PDF' }}">
                                                                📄 PDF
                                                            </span>
                                                        @endif

                                                        @if($les->audio_path)
                                                            <span style="background:#14442a; color:#4ade80; border:1px solid #16a34a; padding:0.25rem 0.5rem; border-radius:4px; font-size:0.75rem; font-weight:600;" title="Audio vorhanden">
                                                                🎧 Audio
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td style="padding:0.85rem 0.6rem; text-align:right;">
                                                    <div style="display:flex; justify-content:flex-end; gap:0.4rem;">
                                                        <a href="{{ route('course.lesson', ['courseSlug' => $c->slug, 'lessonSlug' => $les->slug]) }}" target="_blank" style="background:#1e293b; color:#cbd5e1; border:1px solid #334155; padding:0.3rem 0.6rem; border-radius:4px; text-decoration:none; font-size:0.8rem; font-weight:500;" title="Lektion im Player öffnen">
                                                            Vorschau ↗
                                                        </a>
                                                        <button type="button" onclick="openEditLessonModal({{ json_encode($les) }}, '{{ route('admin.lessons.update', $les->id) }}')" style="background:#0284c7; color:#fff; border:none; padding:0.3rem 0.65rem; border-radius:4px; cursor:pointer; font-size:0.8rem; font-weight:600;">
                                                            Bearbeiten
                                                        </button>
                                                        <form method="POST" action="{{ route('admin.lessons.delete', $les->id) }}" onsubmit="return confirm('Möchten Sie die Lektion \'{{ $les->title }}\' und zugehörige Uploads wirklich unwiderruflich löschen?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" style="background:#dc2626; color:#fff; border:none; padding:0.3rem 0.65rem; border-radius:4px; cursor:pointer; font-size:0.8rem; font-weight:600;">
                                                                Löschen
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p style="color:#94a3b8; font-size:0.9rem; margin:0.5rem 0;">Dieser Kurs enthält derzeit noch keine hochgeladenen Lektionen.</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>

        {{-- 05 Auslieferung --}}
        <section class="admin-section admin-public" id="auslieferung">
            <header>
                <div>
                    <span>05</span>
                    <p class="eyebrow">Auslieferung und Support</p>
                </div>
                <h2>Kundenwege öffnen und Adressen kopieren.</h2>
            </header>
            <div class="delivery-login-card">
                <div>
                    <span>Wichtigste Kundenadresse</span>
                    <strong>Kunden-Anmeldung</strong>
                    <code>/login</code>
                    <p>Diese Adresse erhält der Kunde für die Anmeldung in seinem freigeschalteten Kursbereich.</p>
                </div>
                <div>
                    <a href="{{ route('login') }}" target="_blank" rel="noreferrer">Anmeldeseite öffnen</a>
                    <button type="button" onclick="copyToClipboard('{{ url('/login') }}', this)">Adresse kopieren</button>
                </div>
            </div>

            <div class="delivery-course-directory">
                <div class="delivery-course-heading">
                    <strong>Geschützte Kursauslieferung</strong>
                    <span>Als Administrator öffnest du hier die echte Kursansicht mit einer klar gekennzeichneten Admin-Prüfansicht.</span>
                </div>
                @foreach($courses as $course)
                    <article>
                        <div>
                            <strong>{{ $course->title }}</strong>
                            <span>Nur interne Administrator-Prüfansicht ({{ $course->lessons_count }} Lektionen)</span>
                        </div>
                        <nav aria-label="Auslieferung {{ $course->title }}">
                            <a href="{{ route('course.show', $course->slug) }}" target="_blank" rel="noreferrer">Wie der Kunde ansehen ↗</a>
                        </nav>
                    </article>
                @endforeach
            </div>

            <div class="public-course-directory">
                <div class="delivery-course-heading">
                    <strong>Kursseiten</strong>
                    <span>Je Kurs getrennt: öffentliche Kursseite auf der Website und echter geschützter Kurszugang in diesem Portal.</span>
                </div>
                @foreach($courses as $course)
                    <article>
                        <strong>{{ $course->title }}</strong>
                        @if($course->public_url)
                            <div class="public-course-address">
                                <span>Öffentliche Kursseite</span>
                                <code>{{ $course->public_url }}</code>
                                <a href="{{ $course->public_url }}" target="_blank" rel="noreferrer">Öffnen</a>
                                <button type="button" onclick="copyToClipboard('{{ $course->public_url }}', this)">Kopieren</button>
                            </div>
                        @endif
                        <div class="public-course-address">
                            <span>Echter Kurszugang</span>
                            <code>/kurs/{{ $course->slug }}</code>
                            <a href="{{ route('course.show', $course->slug) }}" target="_blank" rel="noreferrer">Öffnen</a>
                            <button type="button" onclick="copyToClipboard('{{ url('/kurs/' . $course->slug) }}', this)">Kopieren</button>
                        </div>
                    </article>
                @endforeach
            </div>

            <p class="admin-directory-intro">Hier sind sämtliche vorhandenen Oberflächen direkt erreichbar. Echte Mitarbeiter- und Kundenbereiche bleiben geschützt; dafür stehen dem Administrator gekennzeichnete Prüfansichten zur Verfügung.</p>
            <div class="admin-overview-status">
                <span><b>{{ $courses->count() }}</b> interaktiv freigeschaltete Kurse</span>
                <span><b>{{ $customers->count() }}</b> aktive Kundenkonten</span>
            </div>

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
                        <a href="{{ route('rio-negro') }}" target="_blank" rel="noreferrer"><span>Rio-Negro-Service</span><b>↗</b></a>
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
                        <a href="{{ route('login') }}" target="_blank" rel="noreferrer"><span>Mitarbeiterlogin</span><b>↗</b></a>
                        <a href="{{ route('member.dashboard') }}" target="_blank" rel="noreferrer"><span>Kundenbereich · nach Login</span><b>↗</b></a>
                        <a href="{{ route('course.show', 'dnl-kompakt') }}" target="_blank" rel="noreferrer"><span>DNL Kompakt · Testkurs</span><b>↗</b></a>
                        <a href="{{ route('course.show', 'stress-und-ressourcen') }}" target="_blank" rel="noreferrer"><span>Stress und Ressourcen · Testkurs</span><b>↗</b></a>
                    </nav>
                </section>
            </div>
        </section>

        {{-- 06 Ablauf --}}
        <section class="admin-section admin-backend" id="sicherheit">
            <header>
                <div>
                    <span>06</span>
                    <p class="eyebrow">Arbeitsprozess</p>
                </div>
                <h2>Einfach und nachvollziehbar.</h2>
            </header>
            <div class="backend-functions">
                <article>
                    <strong>Ein Gerät</strong>
                    <span>Das erste erfolgreiche Login bindet das Kundenkonto an dieses Gerät.</span>
                </article>
                <article>
                    <strong>Kein Geräte-Reset</strong>
                    <span>Bei Gerätewechsel das alte Kundenkonto vollständig löschen oder Gerätebindung über den Adminbereich freigeben.</span>
                </article>
                <article>
                    <strong>Neu anlegen</strong>
                    <span>Neues Konto, neue Zugangsdaten, Kurs und Laufzeit bewusst neu vergeben.</span>
                </article>
                <article>
                    <strong>Datensparsam</strong>
                    <span>Vorname und Kunden-/Rechnungsnummer ermöglichen die pseudonymisierte Zuordnung. Abgelaufene Konten werden automatisch entfernt; Buchungsbelege bleiben nur nach gesetzlicher Frist erhalten.</span>
                </article>
                <article>
                    <strong>Passwort vergessen</strong>
                    <span>Rechnungsnummer und Kurs ordnen die Anfrage zu. Neues Passwort erst nach Abgleich über die Buchhaltung übermitteln.</span>
                </article>
                <article class="integration-pending">
                    <strong>Papierkram-Rechnungen</strong>
                    <span>Mitarbeiter müssen vor der ersten Anmeldung von Dennis als Benutzer bei Papierkram freigeschaltet werden. Bei technischen Login-, Passwort- oder Systemproblemen hilft ausschließlich der Papierkram-Support.</span>
                    <a href="https://dennisbesseler.papierkram.de/login?email=mail%40besseler.de" target="_blank" rel="noreferrer">Papierkram öffnen ↗</a>
                    <a href="https://hilfe.papierkram.de/system-status/" target="_blank" rel="noreferrer">Papierkram-Support ↗</a>
                </article>
            </div>
        </section>

        {{-- 08 Hauptadmin-Sicherheit --}}
        <section class="admin-section admin-security-settings" id="hauptadmin-sicherheit">
            <header>
                <div>
                    <span>08</span>
                    <h2>Hauptadmin-<br/>Sicherheit.</h2>
                </div>
                <p>Das Admin-Passwort kann hier sicher geändert werden. Der vierstellige Sicherheitscode bleibt fest hinterlegt und wird im Portal niemals angezeigt. Eine Passwortänderung beendet alle Hauptadmin-Sitzungen.</p>
            </header>
            <div class="admin-security-grid">
                <form method="POST" action="{{ route('admin.change-password') }}" autoComplete="off">
                    @csrf
                    <h3>Admin-Passwort ändern</h3>
                    <p>Mindestens 12 Zeichen mit Groß- und Kleinbuchstaben, Zahl und Sonderzeichen.</p>

                    @if(session('password_success'))
                        <div style="background:#14532d; color:#86efac; padding:0.75rem; border-radius:4px; margin-bottom:1rem;">
                            ✓ {{ session('password_success') }}
                        </div>
                    @endif

                    <label>
                        <span>Bisheriges Admin-Passwort</span>
                        <input name="current_password" required type="password" autoComplete="current-password"/>
                    </label>
                    <label>
                        <span>Bisheriger Sicherheitscode</span>
                        <input name="security_code" autoComplete="off" inputMode="numeric" maxLength="4" pattern="[0-9]{4}" required type="password"/>
                    </label>
                    <label>
                        <span>Neues Admin-Passwort</span>
                        <input name="new_password" required type="password" minLength="12" maxLength="128" autoComplete="new-password"/>
                    </label>
                    <label>
                        <span>Neues Passwort wiederholen</span>
                        <input name="new_password_confirmation" required type="password" minLength="12" maxLength="128" autoComplete="new-password"/>
                    </label>
                    <button type="submit">Sicher ändern</button>
                </form>
            </div>
        </section>

        <div class="portal-bottom-navigation" id="admin-page-end">
            <a class="portal-jump-arrow portal-jump-up" href="#admin-page-top" aria-label="Zurück zum Seitenanfang">
                <span aria-hidden="true">↑</span>
            </a>
        </div>
    </main>

    {{-- Edit Lesson Modal --}}
    <div id="edit-lesson-modal" class="mm-scope" style="display:none; position:fixed; inset:0; background:rgba(2, 6, 23, 0.88); backdrop-filter:blur(8px); z-index:9999; align-items:center; justify-content:center; padding:1.5rem; overflow-y:auto;">
        <div style="background:#0f172a; border:1px solid #334155; border-radius:14px; max-width:860px; width:100%; max-height:90vh; overflow-y:auto; padding:2rem; box-shadow:0 25px 60px -15px rgba(0,0,0,0.8); position:relative; scrollbar-width:thin; scrollbar-color:#334155 #0f172a;">
            
            {{-- Modal Header --}}
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; border-bottom:1px solid #1e293b; padding-bottom:1rem;">
                <div style="display:flex; align-items:center; gap:0.6rem;">
                    <span style="background:rgba(56, 189, 248, 0.15); color:#38bdf8; width:34px; height:34px; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; font-size:1.1rem; border:1px solid rgba(56, 189, 248, 0.3);">✏️</span>
                    <div>
                        <h3 style="margin:0; color:#f8fafc; font-size:1.25rem; font-weight:700;">Lektion bearbeiten</h3>
                        <span style="color:#94a3b8; font-size:0.82rem;">Texte, Modulzuordnung &amp; Mediendateien anpassen</span>
                    </div>
                </div>
                <button type="button" onclick="closeEditLessonModal()" style="background:#1e293b; border:1px solid #334155; color:#94a3b8; width:32px; height:32px; border-radius:6px; font-size:1.2rem; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all 0.2s;" onmouseover="this.style.color='#fff'; this.style.borderColor='#ef4444';" onmouseout="this.style.color='#94a3b8'; this.style.borderColor='#334155';">&times;</button>
            </div>

            <form id="edit-lesson-form" method="POST" action="" enctype="multipart/form-data" class="mm-form">
                @csrf
                <div class="mm-grid-2">
                    <div class="mm-label">
                        <span class="mm-label-title">Modul- / Kapitelname *</span>
                        <input type="text" name="chapter_name" id="edit_chapter_name" class="mm-input" required/>
                    </div>
                    <div class="mm-label">
                        <span class="mm-label-title">Lektionstitel *</span>
                        <input type="text" name="title" id="edit_title" class="mm-input" required/>
                    </div>
                </div>

                <div class="mm-grid-3">
                    <div class="mm-label">
                        <span class="mm-label-title">Lektionsnummer</span>
                        <input type="number" name="lesson_number" id="edit_lesson_number" class="mm-input" min="1"/>
                    </div>
                    <div class="mm-label">
                        <span class="mm-label-title">Gesamtdauer in Minuten *</span>
                        <input type="number" name="duration_minutes" id="edit_duration_minutes" class="mm-input" min="1"/>
                        <div id="edit_lesson_duration_breakdown" style="font-size:0.78rem; color:#38bdf8; margin-top:0.35rem; background:#0b1324; padding:0.3rem 0.5rem; border-radius:4px; border:1px solid #1e293b; display:none;"></div>
                    </div>
                    <div class="mm-label">
                        <span class="mm-label-title">Reihenfolge (Sortierung)</span>
                        <input type="number" name="order" id="edit_order" class="mm-input" min="1"/>
                    </div>
                </div>

                {{-- 3-Column Balanced Media Grid in Modal --}}
                <div class="mm-grid-media">
                    {{-- Video Update Box --}}
                    <div class="mm-media-box is-video">
                        <div class="mm-media-header">
                            <span>🎬</span>
                            <span>Video ersetzen</span>
                        </div>
                        <div id="current_video_info" class="mm-current-info"></div>
                        <div class="mm-file-zone">
                            <span style="color:#94a3b8; font-size:0.75rem; font-weight:700; text-transform:uppercase;">Neue Videodatei hochladen</span>
                            <input type="file" name="video_file" class="mm-file-input" accept="video/mp4,video/webm,video/quicktime"/>
                        </div>
                        <div class="mm-label">
                            <span class="mm-label-title">Oder externe Video-URL</span>
                            <input type="url" name="video_url" id="edit_video_url" class="mm-input" placeholder="https://..."/>
                        </div>
                    </div>

                    {{-- PDF Update Box --}}
                    <div class="mm-media-box is-pdf">
                        <div class="mm-media-header">
                            <span>📄</span>
                            <span>PDF-Arbeitsblatt</span>
                        </div>
                        <div id="current_pdf_info" class="mm-current-info"></div>
                        <div class="mm-file-zone">
                            <span style="color:#94a3b8; font-size:0.75rem; font-weight:700; text-transform:uppercase;">Neues PDF hochladen</span>
                            <input type="file" name="pdf_file" class="mm-file-input" accept="application/pdf"/>
                        </div>
                        <div class="mm-label">
                            <span class="mm-label-title">Anzeigename für das PDF</span>
                            <input type="text" name="pdf_attachment_name" id="edit_pdf_attachment_name" class="mm-input" placeholder="z. B. 01_Uebersicht.pdf"/>
                        </div>
                    </div>

                    {{-- Audio Update Box --}}
                    <div class="mm-media-box is-audio">
                        <div class="mm-media-header">
                            <span>🎧</span>
                            <span>Audio-Reflexion</span>
                        </div>
                        <div id="current_audio_info" class="mm-current-info"></div>
                        <div class="mm-file-zone">
                            <span style="color:#94a3b8; font-size:0.75rem; font-weight:700; text-transform:uppercase;">Neue Audiodatei hochladen</span>
                            <input type="file" name="audio_file" class="mm-file-input" accept="audio/mp3,audio/mpeg,audio/wav,audio/m4a"/>
                        </div>
                        <small style="color:#94a3b8; font-size:0.8rem; line-height:1.4;">
                            Ersetzt bestehende Audiodatei.
                        </small>
                    </div>
                </div>

                {{-- Content Editor --}}
                <div class="mm-label">
                    <span class="mm-label-title">Lektionsinhalt &amp; Textanleitung (HTML / Text)</span>
                    <textarea name="content_html" id="edit_content_html" class="mm-textarea"></textarea>
                </div>

                <label class="mm-checkbox-wrap">
                    <input type="checkbox" name="is_preview" id="edit_is_preview" value="1"/>
                    <span class="mm-checkbox-label">Kostenlose Vorschau-Lektion (auch ohne Freischaltung sichtbar)</span>
                </label>

                <div style="display:flex; justify-content:flex-end; gap:0.75rem; margin-top:1.5rem; border-top:1px solid #1e293b; padding-top:1.25rem;">
                    <button type="button" onclick="closeEditLessonModal()" class="mm-btn-cancel">
                        Abbrechen
                    </button>
                    <button type="submit" class="mm-btn-submit">
                        ✓ Änderungen speichern
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Course Modal --}}
    <div id="edit-course-modal" class="mm-scope" style="display:none; position:fixed; inset:0; background:rgba(2, 6, 23, 0.88); backdrop-filter:blur(8px); z-index:9999; align-items:center; justify-content:center; padding:1.5rem; overflow-y:auto;">
        <div style="background:#0f172a; border:1px solid #334155; border-radius:14px; max-width:860px; width:100%; max-height:90vh; overflow-y:auto; padding:2rem; box-shadow:0 25px 60px -15px rgba(0,0,0,0.8); position:relative; scrollbar-width:thin; scrollbar-color:#334155 #0f172a;">
            
            {{-- Modal Header --}}
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; border-bottom:1px solid #1e293b; padding-bottom:1rem;">
                <div style="display:flex; align-items:center; gap:0.6rem;">
                    <span style="background:rgba(5, 150, 105, 0.15); color:#34d399; width:34px; height:34px; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; font-size:1.1rem; border:1px solid rgba(5, 150, 105, 0.3);">📚</span>
                    <div>
                        <h3 style="margin:0; color:#f8fafc; font-size:1.25rem; font-weight:700;">Kurs bearbeiten</h3>
                        <span style="color:#94a3b8; font-size:0.82rem;">Titel, Laufzeit, Kategorie &amp; Beschreibung anpassen</span>
                    </div>
                </div>
                <button type="button" onclick="closeEditCourseModal()" style="background:#1e293b; border:1px solid #334155; color:#94a3b8; width:32px; height:32px; border-radius:6px; font-size:1.2rem; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all 0.2s;" onmouseover="this.style.color='#fff'; this.style.borderColor='#ef4444';" onmouseout="this.style.color='#94a3b8'; this.style.borderColor='#334155';">&times;</button>
            </div>

            <form id="edit-course-form" method="POST" action="" enctype="multipart/form-data" class="mm-form">
                @csrf
                <div class="mm-grid-2">
                    <div class="mm-label">
                        <span class="mm-label-title">Kurstitel *</span>
                        <input type="text" name="title" id="edit_course_title" class="mm-input" required/>
                    </div>
                    <div class="mm-label">
                        <span class="mm-label-title">Kategorie *</span>
                        <input type="text" name="category" id="edit_course_category" class="mm-input" required/>
                    </div>
                </div>

                <div class="mm-label">
                    <span class="mm-label-title">Untertitel</span>
                    <input type="text" name="subtitle" id="edit_course_subtitle" class="mm-input"/>
                </div>

                <div class="mm-grid-3">
                    <div class="mm-label">
                        <span class="mm-label-title">Laufzeit in Tagen *</span>
                        <input type="number" name="duration_days" id="edit_course_duration_days" class="mm-input" min="1" required/>
                    </div>
                    <div class="mm-label">
                        <span class="mm-label-title">Unterrichtsstunden</span>
                        <input type="text" name="total_hours" id="edit_course_total_hours" class="mm-input"/>
                    </div>
                    <div class="mm-label">
                        <span class="mm-label-title">Sortierreihenfolge</span>
                        <input type="number" name="order" id="edit_course_order" class="mm-input" min="1"/>
                    </div>
                </div>

                <div class="mm-label">
                    <span class="mm-label-title">Kursbeschreibung</span>
                    <textarea name="description" id="edit_course_description" class="mm-textarea" style="min-height:100px !important;"></textarea>
                </div>

                <div class="mm-grid-2">
                    <div class="mm-label">
                        <span class="mm-label-title">Neues Thumbnail hochladen (optional)</span>
                        <div class="mm-file-zone">
                            <input type="file" name="thumbnail_file" class="mm-file-input" accept="image/*"/>
                        </div>
                    </div>
                    <div class="mm-label">
                        <span class="mm-label-title">Öffentliche Landingpage URL</span>
                        <input type="url" name="public_url" id="edit_course_public_url" class="mm-input"/>
                    </div>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:0.75rem; margin-top:1.5rem; border-top:1px solid #1e293b; padding-top:1.25rem;">
                    <button type="button" onclick="closeEditCourseModal()" class="mm-btn-cancel">
                        Abbrechen
                    </button>
                    <button type="submit" class="mm-btn-submit" style="background:linear-gradient(135deg, #059669, #047857);">
                        ✓ Kurs speichern
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function copyToClipboard(text, button) {
            navigator.clipboard.writeText(text).then(() => {
                const orig = button.innerText;
                button.innerText = 'Kopiert!';
                button.style.background = '#16a34a';
                button.style.color = '#ffffff';
                setTimeout(() => {
                    button.innerText = orig;
                    button.style.background = '';
                    button.style.color = '';
                }, 2000);
            }).catch(err => {
                console.error('Kopieren fehlgeschlagen: ', err);
            });
        }

        // Work Timer Script (Dennis Besseler Original Implementation)
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
            const historyContainer = document.getElementById('admin-timer-history-container');

            const timeFormatted = formatTimerClock(adminTimerState.durationSeconds);
            if (clockEl) clockEl.textContent = timeFormatted;
            if (bigClockEl) bigClockEl.textContent = timeFormatted;

            if (adminTimerState.active && adminTimerState.active.status === 'running') {
                if (toggleBtn) toggleBtn.classList.add('is-running');
                if (labelEl) labelEl.textContent = 'Timer läuft';
                if (runningBox) runningBox.style.display = 'block';
                if (startForm) startForm.style.display = 'none';
                if (activeSubject) activeSubject.textContent = adminTimerState.active.activity_description || 'Zeitmessung';
            } else {
                if (toggleBtn) toggleBtn.classList.remove('is-running');
                if (labelEl) labelEl.textContent = 'Timer';
                if (runningBox) runningBox.style.display = 'none';
                if (startForm) startForm.style.display = 'block';
            }

            // Render History (max 3 completed entries)
            if (historyContainer) {
                if (!adminTimerState.completed || adminTimerState.completed.length === 0) {
                    historyContainer.innerHTML = '<small>Noch keine abgeschlossene Zeitmessung.</small>';
                } else {
                    let html = '';
                    adminTimerState.completed.slice(0, 3).forEach(item => {
                        const dateStr = item.ended_at ? new Date(item.ended_at).toLocaleString('de-DE') : (item.started_at ? new Date(item.started_at).toLocaleString('de-DE') : '');
                        html += `
                            <div>
                                <strong>${item.activity_description || 'Aufgabe'}</strong>
                                <b>${formatTimerHuman(item.duration_seconds || 0)}</b>
                                <small>${dateStr}</small>
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
                if (data.active_entry && data.active_entry.status === 'running') {
                    adminTimerState.active = data.active_entry;
                    adminTimerState.durationSeconds = data.current_duration || 0;
                    startAdminTimerLoop();
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
            const input = document.getElementById('admin-timer-input-subject');
            const desc = (input && input.value.trim()) ? input.value.trim() : 'Kundenbetreuung & Portalverwaltung';

            adminTimerState.active = { activity_description: desc, status: 'running' };
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
                body: JSON.stringify({ activity_description: desc })
            })
            .then(res => res.json())
            .then(data => {
                if (input) input.value = '';
                fetchAdminTimerStatus();
            })
            .catch(err => {
                console.error('Start error:', err);
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
                fetchAdminTimerStatus();
            })
            .catch(err => {
                console.error('Stop error:', err);
                fetchAdminTimerStatus();
            });
        }

        function toggleAdminSendBtn() {
            const check = document.getElementById('admin-timer-cc-check');
            const btn = document.getElementById('admin-timer-send-btn');
            if (btn && check) {
                btn.disabled = (!check.checked || adminTimerState.completed.length === 0);
            }
        }

        function adminSendTimerMail() {
            if (!adminTimerState.completed || adminTimerState.completed.length === 0) return;
            const dateStr = new Date().toLocaleDateString('de-DE');
            
            let body = `Hallo Dennis,\n\nhiermit übermittle ich folgende Zeitinformationen:\n\n`;
            adminTimerState.completed.slice(0, 3).forEach((item, idx) => {
                const startStr = item.started_at ? new Date(item.started_at).toLocaleString('de-DE') : '';
                const endStr = item.ended_at ? new Date(item.ended_at).toLocaleString('de-DE') : startStr;
                body += `${idx + 1}. ${item.activity_description || 'Tätigkeit'}\n   Beginn: ${startStr}\n   Ende: ${endStr}\n   Dauer: ${formatTimerHuman(item.duration_seconds || 0)}\n\n`;
            });
            body += `Diese Nachricht dient ausschließlich der internen Information.\n\nViele Grüße`;

            window.location.href = `mailto:mail@besseler.de?subject=${encodeURIComponent('Interne Zeitinformation ' + dateStr)}&body=${encodeURIComponent(body)}`;
        }

        // Initialize WorkTimer on load
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', fetchAdminTimerStatus);
        } else {
            fetchAdminTimerStatus();
        }

        // Course Management Scripts
        function toggleNewCourseForm() {
            const form = document.getElementById('new-course-form');
            const indicator = document.getElementById('toggle-course-indicator');
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
                indicator.innerText = 'Formular einklappen ▲';
            } else {
                form.style.display = 'none';
                indicator.innerText = 'Kurs anlegen ▼';
            }
        }

        function openEditCourseModal(course, updateUrl) {
            const modal = document.getElementById('edit-course-modal');
            const form = document.getElementById('edit-course-form');
            form.action = updateUrl;

            document.getElementById('edit_course_title').value = course.title || '';
            document.getElementById('edit_course_category').value = course.category || 'Akademie';
            document.getElementById('edit_course_subtitle').value = course.subtitle || '';
            document.getElementById('edit_course_duration_days').value = course.duration_days || 90;
            document.getElementById('edit_course_total_hours').value = course.total_hours || '';
            document.getElementById('edit_course_order').value = course.order || 1;
            document.getElementById('edit_course_description').value = course.description || '';
            document.getElementById('edit_course_public_url').value = course.public_url || '';

            modal.style.display = 'flex';
        }

        function closeEditCourseModal() {
            document.getElementById('edit-course-modal').style.display = 'none';
        }

        // Lesson Management Scripts
        function toggleNewLessonForm() {
            const form = document.getElementById('new-lesson-form');
            const indicator = document.getElementById('toggle-lesson-indicator');
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
                indicator.innerText = 'Formular einklappen ▲';
            } else {
                form.style.display = 'none';
                indicator.innerText = 'Lektion anlegen ▼';
            }
        }

        function updateLessonFormAction(courseId) {
            const select = document.getElementById('target_course_select');
            const selectedOption = select.options[select.selectedIndex];
            const actionUrl = selectedOption.getAttribute('data-action');
            const form = document.getElementById('new-lesson-form');
            if (actionUrl) {
                form.action = actionUrl;
            }
        }

        function prepareNewLessonForCourse(courseId, actionUrl) {
            const form = document.getElementById('new-lesson-form');
            const select = document.getElementById('target_course_select');
            select.value = courseId;
            form.action = actionUrl;
            form.style.display = 'block';
            document.getElementById('toggle-lesson-indicator').innerText = 'Formular einklappen ▲';
            form.scrollIntoView({ behavior: 'smooth' });
        }

        function filterCourseLessons(selectedClass) {
            const groups = document.querySelectorAll('.course-lesson-group');
            groups.forEach(g => {
                if (selectedClass === 'all' || g.classList.contains(selectedClass)) {
                    g.style.display = 'block';
                } else {
                    g.style.display = 'none';
                }
            });
        }

        // Edit Lesson Modal Handling
        function openEditLessonModal(lesson, updateUrl) {
            const modal = document.getElementById('edit-lesson-modal');
            const form = document.getElementById('edit-lesson-form');
            form.action = updateUrl;

            document.getElementById('edit_chapter_name').value = lesson.chapter_name || '';
            document.getElementById('edit_title').value = lesson.title || '';
            document.getElementById('edit_lesson_number').value = lesson.lesson_number || 1;
            document.getElementById('edit_duration_minutes').value = lesson.duration_minutes || 15;
            document.getElementById('edit_order').value = lesson.order || 1;
            document.getElementById('edit_video_url').value = lesson.video_url || '';
            document.getElementById('edit_pdf_attachment_name').value = lesson.pdf_attachment_name || '';
            document.getElementById('edit_content_html').value = lesson.content_html || '';
            document.getElementById('edit_is_preview').checked = !!lesson.is_preview;

            // Info strings
            const vInfo = document.getElementById('current_video_info');
            if (lesson.video_path) {
                vInfo.innerHTML = 'Aktuell gespeichert: <code style="color:#38bdf8;">' + lesson.video_path + '</code>';
            } else if (lesson.video_url) {
                vInfo.innerHTML = 'Aktuelle URL: <code style="color:#94a3b8;">' + lesson.video_url + '</code>';
            } else {
                vInfo.innerHTML = 'Noch kein Video hinterlegt.';
            }

            const pInfo = document.getElementById('current_pdf_info');
            if (lesson.pdf_attachment_path) {
                pInfo.innerHTML = 'Aktuell gespeichert: <code style="color:#c084fc;">' + lesson.pdf_attachment_path + '</code>';
            } else {
                pInfo.innerHTML = 'Noch kein PDF hinterlegt.';
            }

            const aInfo = document.getElementById('current_audio_info');
            if (lesson.audio_path) {
                aInfo.innerHTML = 'Aktuell gespeichert: <code style="color:#4ade80;">' + lesson.audio_path + '</code>';
            } else {
                aInfo.innerHTML = 'Noch keine Audiodatei hinterlegt.';
            }

            modal.style.display = 'flex';
        }

        function closeEditLessonModal() {
            document.getElementById('edit-lesson-modal').style.display = 'none';
        }

        // Intelligent Multi-Media Duration Calculator (Video + Audio + PDF Reading Time)
        function updateCombinedLessonDuration(form) {
            if (!form) return;
            const isEdit = form.id === 'edit-lesson-form';
            const breakdownEl = isEdit 
                ? document.getElementById('edit_lesson_duration_breakdown') 
                : document.getElementById('new_lesson_duration_breakdown');
            const durationInput = form.querySelector('input[name="duration_minutes"]');

            const videoFile = form.querySelector('input[name="video_file"]')?.files[0];
            const audioFile = form.querySelector('input[name="audio_file"]')?.files[0];
            const pdfFile = form.querySelector('input[name="pdf_file"]')?.files[0];
            const pdfName = form.querySelector('input[name="pdf_attachment_name"]')?.value?.trim();
            const videoUrl = form.querySelector('input[name="video_url"]')?.value?.trim();

            let videoSec = form._videoSec || 0;
            let audioSec = form._audioSec || 0;
            let hasPdf = !!(pdfFile || pdfName);
            let pdfMin = hasPdf ? 5 : 0; // 5 min reading/exercise time per PDF worksheet

            const calculateAndRender = () => {
                const vMin = Math.ceil(videoSec / 60);
                const aMin = Math.ceil(audioSec / 60);
                const totalMin = Math.max(1, vMin + aMin + pdfMin);

                if (durationInput) {
                    durationInput.value = totalMin;
                }

                if (breakdownEl) {
                    const parts = [];
                    if (vMin > 0) parts.push(`🎬 ${vMin} Min. Video`);
                    if (aMin > 0) parts.push(`🎧 ${aMin} Min. Audio`);
                    if (pdfMin > 0) parts.push(`📄 ${pdfMin} Min. PDF-Lesezeit`);

                    if (parts.length > 0) {
                        breakdownEl.innerHTML = `<strong>Kombinierte Lehrgangsdauer:</strong> ${parts.join(' + ')} = <strong>${totalMin} Minuten gesamt</strong>`;
                        breakdownEl.style.display = 'block';
                    } else {
                        breakdownEl.style.display = 'none';
                    }
                }
            };

            // Detect video file duration
            if (videoFile && !form._videoFileProcessed) {
                const v = document.createElement('video');
                v.preload = 'metadata';
                v.src = URL.createObjectURL(videoFile);
                v.onloadedmetadata = function() {
                    window.URL.revokeObjectURL(v.src);
                    videoSec = v.duration || 0;
                    form._videoSec = videoSec;
                    form._videoFileProcessed = true;
                    calculateAndRender();
                };
            }

            // Detect audio file duration
            if (audioFile && !form._audioFileProcessed) {
                const a = document.createElement('audio');
                a.preload = 'metadata';
                a.src = URL.createObjectURL(audioFile);
                a.onloadedmetadata = function() {
                    window.URL.revokeObjectURL(a.src);
                    audioSec = a.duration || 0;
                    form._audioSec = audioSec;
                    form._audioFileProcessed = true;
                    calculateAndRender();
                };
            }

            calculateAndRender();
        }

        // Initialize Course Filter & Multi-Media Duration Listeners
        document.addEventListener('DOMContentLoaded', () => {
            const initialFilter = document.getElementById('course_filter_select');
            if (initialFilter) {
                filterCourseLessons(initialFilter.value);
            }

            // Listen to file and text changes in both lesson forms
            ['new-lesson-form', 'edit-lesson-form'].forEach(formId => {
                const form = document.getElementById(formId);
                if (!form) return;

                form.querySelectorAll('input[type="file"], input[name="video_url"], input[name="pdf_attachment_name"]').forEach(input => {
                    input.addEventListener('change', () => {
                        if (input.name === 'video_file') form._videoFileProcessed = false;
                        if (input.name === 'audio_file') form._audioFileProcessed = false;
                        updateCombinedLessonDuration(form);
                    });
                    input.addEventListener('input', () => updateCombinedLessonDuration(form));
                });
            });
        });
    </script>
@endsection
