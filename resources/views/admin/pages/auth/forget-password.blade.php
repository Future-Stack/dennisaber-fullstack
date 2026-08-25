@extends('admin.layouts.app1')

@section('contents')

    <main class="admin-login-page">
        <header><a href="{{ route('admin.login') }}"><strong>DENNIS BESSELER</strong><span>Admin-Zugang</span></a></header>
        <section>
            <div>
                <p class="eyebrow">Passwort neu vergeben</p>
                <h1>Neues Admin-<br/>passwort.</h1>
                <p>Gib die fest hinterlegte Admin-E-Mail und deinen Sicherheitscode ein. Danach kannst du direkt ein neues Admin-Passwort festlegen.</p>
            </div>
            <div class="admin-login-form-column">
                <form class="admin-login-form admin-code-recovery-form" autoComplete="off"><label><span>Admin-E-Mail-Adresse</span><input autoComplete="username" inputMode="email" readOnly="" required="" type="email" value="dennis@besseler.de"/></label><label><span>Sicherheitscode</span><input autoComplete="off" inputMode="numeric" maxLength="4" pattern="[0-9]{4}" required="" type="password" value=""/></label><label><span>Neues Admin-Passwort</span><input autoComplete="new-password" maxLength="128" minLength="12" required="" type="password" value=""/></label><label><span>Neues Admin-Passwort wiederholen</span><input autoComplete="new-password" maxLength="128" minLength="12" required="" type="password" value=""/></label>
                    <button
                        type="submit">Neues Admin-Passwort speichern</button>
                </form><a href="{{ route('admin.login') }}" class="admin-code-recovery-link">Zurück zur Admin-Anmeldung</a></div>
        </section>
    </main>

@endsection
