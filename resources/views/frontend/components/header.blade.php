<header class="portal-header">
    <a href="{{ url('/') }}" class="portal-brand"><strong>DENNIS BESSELER</strong><span>Kursportal</span></a>
    <nav style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
        <a href="{{ url('/#kurse') }}">Alle Kurse</a>
        <a href="{{ route('login') }}">Kundenlogin</a>
        <a href="{{ route('copy-protection') }}">Kopierschutz</a>
        <a href="{{ route('payment') }}">Zahlung</a>
        <a href="{{ route('faster-processing') }}">Schnellere Bearbeitung</a>

        {{-- Global Language Switcher --}}
        <div class="lang-switch-box" style="display: inline-flex; align-items: center; background: #1e293b; border: 1px solid #334155; border-radius: 20px; padding: 2px 6px; font-size: 0.78rem; font-weight: bold; margin-left: 0.5rem;">
            <button type="button" onclick="setGlobalPortalLanguage('de')" id="global-lang-btn-de" style="background: #0284c7; color: #fff; border: none; border-radius: 12px; padding: 0.25rem 0.55rem; cursor: pointer; font-size: 0.75rem; font-weight: 700; transition: all 0.2s;">DE</button>
            <button type="button" onclick="setGlobalPortalLanguage('en')" id="global-lang-btn-en" style="background: transparent; color: #94a3b8; border: none; border-radius: 12px; padding: 0.25rem 0.55rem; cursor: pointer; font-size: 0.75rem; font-weight: 700; transition: all 0.2s;">EN</button>
        </div>
    </nav>
</header>
