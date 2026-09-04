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
                        <span>E-Mail-Adresse</span>

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
                        <span>Passwort</span>

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
                        <span>Sicherheitscode</span>

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
                        Zusätzliche Sicherheitsüberprüfung für das Hauptadministratorkonto.
                    </small>

                    <button type="submit">
                        Sicher anmelden <span>→</span>
                    </button>
                </form>

                <a href="{{ route('admin.forget-password') }}" class="admin-code-recovery-link">Passwort vergessen?</a>
            </div>
        </section>
    </main>

    <script>
        (() => {
            function getBesselerDeviceId() {
                const key = 'besseler-admin-device-id';
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

            const idEl = document.getElementById('device_id');
            const nameEl = document.getElementById('device_name');
            if (idEl) idEl.value = getBesselerDeviceId();
            if (nameEl) nameEl.value = getBesselerDeviceName();

            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', () => {
                    if (idEl) idEl.value = getBesselerDeviceId();
                    if (nameEl) nameEl.value = getBesselerDeviceName();
                });
            }
        })();
    </script>
@endsection
