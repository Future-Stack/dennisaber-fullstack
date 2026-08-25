@extends('admin.layouts.app1')

@section('contents')
    <main class="admin-login-page">
        <header><a href="{{ route('admin.login') }}"><strong>DENNIS BESSELER</strong><span>Kursportal</span></a>
        </header>
        <section>
            <div>
                <p class="eyebrow">Persönlicher Hauptzugang</p>
                <h1>Admin-<br/>anmeldung.</h1>
                <p>Dieser Zugang ist ausschließlich für das wichtigste Hauptadministratorkonto bestimmt. Mitarbeiter-
                    und
                    Kundenkonten melden sich weiterhin über ihre eigenen Zugänge an.</p>
            </div>
            <div class="admin-login-form-column">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('admin.loginStore') }}" class="admin-login-form" autocomplete="off">
                    @csrf

                    <label>
                        <span>E-Mail Address</span>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            autocomplete="username"
                            required
                            autofocus>

                        @error('email')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </label>

                    <label>
                        <span>Password</span>

                        <input
                            type="password"
                            name="password"
                            autocomplete="current-password"
                            required>

                        @error('password')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </label>

                    <label>
                        <span>Security Code</span>

                        <input
                            type="password"
                            name="security_code"
                            inputmode="numeric"
                            maxlength="4"
                            pattern="[0-9]{4}"
                            autocomplete="off"
                            required>

                        @error('security_code')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </label>

                    {{-- Hidden Device Information --}}
                    <input type="hidden" name="device_id" id="device_id">
                    <input type="hidden" name="device_name" id="device_name">

                    <small>
                        Additional security verification for the main administrator.
                    </small>

                    <button type="submit">
                        Secure Login
                    </button>
                </form>

                <a href="{{ route('admin.forget-password') }}" class="admin-code-recovery-link">Passwort vergessen?</a>
            </div>
        </section>
    </main>

    <script>
        (() => {

            const deviceName =
                navigator.platform +
                " | " +
                navigator.userAgent;

            const raw =
                navigator.userAgent +
                navigator.platform +
                screen.width +
                screen.height +
                Intl.DateTimeFormat().resolvedOptions().timeZone;

            async function sha256(text) {
                const buffer = await crypto.subtle.digest(
                    "SHA-256",
                    new TextEncoder().encode(text)
                );

                return [...new Uint8Array(buffer)]
                    .map(b => b.toString(16).padStart(2, "0"))
                    .join("");
            }

            sha256(raw).then(hash => {
                document.getElementById('device_id').value = hash;
                document.getElementById('device_name').value = deviceName;
            });

        })();
    </script>
@endsection
