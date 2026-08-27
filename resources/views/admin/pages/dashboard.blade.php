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
                <a href="#auslieferung"><span>05</span>Auslieferung</a>
                <a href="#sicherheit"><span>06</span>Ablauf</a>
                <a href="#naechste-version"><span>NV</span>Nächste Version ({{ $versionNotes->count() }})</a>
                <a href="#pinnwand"><span>01</span>Notizen ({{ $adminNotes->count() }})</a>
                <a href="https://dennisbesseler.papierkram.de/login?email=mail%40besseler.de" target="_blank" rel="noreferrer"><span>RE</span>Rechnungen</a>
            </div>
            <div class="work-timer is-compact">
                <button class="work-timer-toggle" id="timer-btn" type="button" aria-expanded="false" onclick="toggleTimer()">
                    <span>Timer</span><b id="timer-display">00:00:00</b>
                </button>
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

        // Work Timer Script
        let timerRunning = false;
        let timerSeconds = 0;
        let timerInterval = null;

        function toggleTimer() {
            timerRunning = !timerRunning;
            const btn = document.getElementById('timer-btn');
            if (timerRunning) {
                btn.classList.add('is-running');
                timerInterval = setInterval(() => {
                    timerSeconds++;
                    const h = String(Math.floor(timerSeconds / 3600)).padStart(2, '0');
                    const m = String(Math.floor((timerSeconds % 3600) / 60)).padStart(2, '0');
                    const s = String(timerSeconds % 60).padStart(2, '0');
                    document.getElementById('timer-display').innerText = `${h}:${m}:${s}`;
                }, 1000);
            } else {
                btn.classList.remove('is-running');
                clearInterval(timerInterval);
            }
        }
    </script>
@endsection
