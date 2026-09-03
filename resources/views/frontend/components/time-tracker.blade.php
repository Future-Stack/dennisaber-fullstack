@if(Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isStaff()))
<div id="time-tracker-widget" class="notranslate" translate="no" style="position: fixed; top: 12px; right: 20px; z-index: 99999; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
    {{-- Floating Header Pill Button --}}
    <button type="button" id="tt-toggle-btn" onclick="toggleTimeTrackerDrawer()" class="notranslate" translate="no" style="background: rgba(15, 23, 42, 0.95); border: 1px solid #334155; color: #f8fafc; padding: 6px 14px; border-radius: 20px; font-size: 0.82rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.3); backdrop-filter: blur(8px); transition: all 0.2s ease;">
        <span id="tt-status-dot" style="width: 8px; height: 8px; border-radius: 50%; background: #64748b; display: inline-block;"></span>
        <span style="color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;">Zeiterfassung</span>
        <strong id="tt-pill-time" class="notranslate" translate="no" style="font-family: monospace; font-size: 0.88rem; color: #38bdf8;">00:00:00</strong>
    </button>

    {{-- Sliding Drawer / Modal Window --}}
    <div id="tt-drawer" class="notranslate" translate="no" style="display: none; position: absolute; top: 42px; right: 0; width: 360px; background: #0f172a; border: 1px solid #334155; border-radius: 12px; box-shadow: 0 20px 40px rgba(0,0,0,0.6); padding: 18px; color: #f8fafc; z-index: 100000;">
        
        {{-- Header --}}
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #1e293b; padding-bottom: 10px; margin-bottom: 14px;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 1.1rem;">⏱</span>
                <div>
                    <strong style="font-size: 0.92rem; display: block;">Arbeitszeiterfassung</strong>
                    <span style="font-size: 0.72rem; color: #94a3b8;">{{ Auth::user()->name }} ({{ Auth::user()->role === 'admin' ? 'Administrator' : 'Mitarbeiter' }})</span>
                </div>
            </div>
            <button type="button" onclick="toggleTimeTrackerDrawer()" style="background: none; border: none; color: #64748b; font-size: 1.2rem; cursor: pointer; padding: 2px 6px;">✕</button>
        </div>

        {{-- Big Timer Display --}}
        <div style="background: #020617; border: 1px solid #1e293b; border-radius: 8px; padding: 14px; text-align: center; margin-bottom: 14px;">
            <div id="tt-big-time" class="notranslate" translate="no" style="font-family: monospace; font-size: 2rem; font-weight: 700; color: #38bdf8; letter-spacing: 0.05em;">00:00:00</div>
            <div id="tt-active-task" style="font-size: 0.78rem; color: #94a3b8; margin-top: 4px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                Kein aktiver Timer
            </div>
        </div>

        {{-- Task Description Input (When Starting) --}}
        <div id="tt-input-box" style="margin-bottom: 12px;">
            <label style="display: block; font-size: 0.75rem; color: #94a3b8; margin-bottom: 4px; font-weight: 600;">Begründung / Aufgabe:</label>
            <input type="text" id="tt-task-input" placeholder="z. B. Kundenbetreuung, Rechnungsprüfung, Portalwartung..." style="width: 100%; box-sizing: border-box; background: #1e293b; border: 1px solid #334155; color: #f8fafc; padding: 8px 10px; border-radius: 6px; font-size: 0.82rem;">
        </div>

        {{-- Control Buttons --}}
        <div style="display: flex; gap: 8px; margin-bottom: 16px;">
            <button type="button" id="tt-start-btn" onclick="ttStart()" style="flex: 1; background: #0284c7; color: #fff; border: none; padding: 8px 12px; border-radius: 6px; font-weight: 700; font-size: 0.82rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 4px;">
                ▶ Starten
            </button>
            <button type="button" id="tt-pause-btn" onclick="ttPause()" style="display: none; flex: 1; background: #d97706; color: #fff; border: none; padding: 8px 12px; border-radius: 6px; font-weight: 700; font-size: 0.82rem; cursor: pointer; align-items: center; justify-content: center; gap: 4px;">
                ❚❚ Pausieren
            </button>
            <button type="button" id="tt-resume-btn" onclick="ttResume()" style="display: none; flex: 1; background: #16a34a; color: #fff; border: none; padding: 8px 12px; border-radius: 6px; font-weight: 700; font-size: 0.82rem; cursor: pointer; align-items: center; justify-content: center; gap: 4px;">
                ▶ Fortsetzen
            </button>
            <button type="button" id="tt-stop-btn" onclick="ttStop()" style="display: none; background: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.4); color: #f87171; padding: 8px 12px; border-radius: 6px; font-weight: 700; font-size: 0.82rem; cursor: pointer;">
                ■ Stopp
            </button>
        </div>

        {{-- History Section --}}
        <div style="border-top: 1px solid #1e293b; padding-top: 12px; margin-bottom: 14px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <strong style="font-size: 0.78rem; color: #cbd5e1; text-transform: uppercase; letter-spacing: 0.05em;">Letzte Einträge</strong>
                <span id="tt-today-total" style="font-size: 0.75rem; color: #38bdf8; font-weight: 600;">Heute: 0h 0m</span>
            </div>
            <div id="tt-history-list" style="max-height: 140px; overflow-y: auto; font-size: 0.78rem; color: #94a3b8; display: flex; flex-direction: column; gap: 6px;">
                <div style="text-align: center; padding: 10px 0; color: #64748b;">Keine Einträge vorhanden</div>
            </div>
        </div>

        {{-- Actions: Copy Summary & Prepare Mail --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; border-top: 1px solid #1e293b; padding-top: 12px;">
            <button type="button" onclick="ttCopySummary()" style="background: #1e293b; border: 1px solid #334155; color: #cbd5e1; padding: 7px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 4px;">
                📋 Zusammenfassung
            </button>
            <a id="tt-mail-btn" href="mailto:mail@besseler.de?subject=Arbeitszeiterfassung" style="background: #1e293b; border: 1px solid #334155; color: #cbd5e1; padding: 7px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 600; text-decoration: none; text-align: center; display: flex; align-items: center; justify-content: center; gap: 4px;">
                ✉ E-Mail Entwurf
            </a>
        </div>
    </div>
</div>

<script>
    let ttState = {
        status: 'stopped', // running, paused, stopped
        activeEntry: null,
        durationSeconds: 0,
        recentEntries: [],
        timerInterval: null
    };

    function toggleTimeTrackerDrawer() {
        const drawer = document.getElementById('tt-drawer');
        if (drawer) {
            drawer.style.display = drawer.style.display === 'none' ? 'block' : 'none';
        }
    }

    function formatTTTime(totalSec) {
        const sec = Math.max(0, Math.floor(totalSec));
        const hrs = Math.floor(sec / 3600);
        const mins = Math.floor((sec % 3600) / 60);
        const secs = sec % 60;
        return `${hrs.toString().padStart(2, '0')}:${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
    }

    function formatDurationHuman(totalSec) {
        const hrs = Math.floor(totalSec / 3600);
        const mins = Math.floor((totalSec % 3600) / 60);
        if (hrs > 0) return `${hrs}h ${mins}m`;
        return `${mins}m ${totalSec % 60}s`;
    }

    function updateTTUI() {
        const pillTime = document.getElementById('tt-pill-time');
        const bigTime = document.getElementById('tt-big-time');
        const statusDot = document.getElementById('tt-status-dot');
        const activeTask = document.getElementById('tt-active-task');
        const startBtn = document.getElementById('tt-start-btn');
        const pauseBtn = document.getElementById('tt-pause-btn');
        const resumeBtn = document.getElementById('tt-resume-btn');
        const stopBtn = document.getElementById('tt-stop-btn');
        const inputBox = document.getElementById('tt-input-box');

        const timeStr = formatTTTime(ttState.durationSeconds);
        if (pillTime) pillTime.textContent = timeStr;
        if (bigTime) bigTime.textContent = timeStr;

        if (ttState.status === 'running') {
            if (statusDot) statusDot.style.background = '#4ade80';
            if (activeTask) activeTask.textContent = 'Läuft: ' + (ttState.activeEntry?.activity_description || 'Aufgabe');
            if (startBtn) startBtn.style.display = 'none';
            if (pauseBtn) pauseBtn.style.display = 'flex';
            if (resumeBtn) resumeBtn.style.display = 'none';
            if (stopBtn) stopBtn.style.display = 'block';
            if (inputBox) inputBox.style.display = 'none';
        } else if (ttState.status === 'paused') {
            if (statusDot) statusDot.style.background = '#fbbf24';
            if (activeTask) activeTask.textContent = 'Pausiert: ' + (ttState.activeEntry?.activity_description || 'Aufgabe');
            if (startBtn) startBtn.style.display = 'none';
            if (pauseBtn) pauseBtn.style.display = 'none';
            if (resumeBtn) resumeBtn.style.display = 'flex';
            if (stopBtn) stopBtn.style.display = 'block';
            if (inputBox) inputBox.style.display = 'none';
        } else {
            if (statusDot) statusDot.style.background = '#64748b';
            if (activeTask) activeTask.textContent = 'Kein aktiver Timer';
            if (startBtn) startBtn.style.display = 'flex';
            if (pauseBtn) pauseBtn.style.display = 'none';
            if (resumeBtn) resumeBtn.style.display = 'none';
            if (stopBtn) stopBtn.style.display = 'none';
            if (inputBox) inputBox.style.display = 'block';
        }

        renderTTHistory();
        updateTTMailLink();
    }

    function renderTTHistory() {
        const listEl = document.getElementById('tt-history-list');
        const totalEl = document.getElementById('tt-today-total');
        if (!listEl) return;

        if (!ttState.recentEntries || ttState.recentEntries.length === 0) {
            listEl.innerHTML = '<div style="text-align: center; padding: 10px 0; color: #64748b;">Keine Einträge vorhanden</div>';
            if (totalEl) totalEl.textContent = 'Gesamt: 0h 0m';
            return;
        }

        let totalSec = 0;
        let html = '';
        ttState.recentEntries.forEach(item => {
            totalSec += (item.duration_seconds || 0);
            const durationFormatted = formatDurationHuman(item.duration_seconds || 0);
            const dateStr = item.started_at ? new Date(item.started_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : '';
            
            html += `
                <div style="display: flex; justify-content: space-between; align-items: center; background: #020617; padding: 6px 8px; border-radius: 4px; border: 1px solid #1e293b;">
                    <div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; padding-right: 8px;">
                        <span style="color: #f8fafc; font-weight: 500; display: block; overflow: hidden; text-overflow: ellipsis;">${item.activity_description || 'Aufgabe'}</span>
                        <span style="color: #64748b; font-size: 0.7rem;">${dateStr}</span>
                    </div>
                    <strong style="color: #38bdf8; font-family: monospace; font-size: 0.78rem; flex-shrink: 0;">${durationFormatted}</strong>
                </div>
            `;
        });

        listEl.innerHTML = html;
        if (totalEl) totalEl.textContent = 'Gesamt: ' + formatDurationHuman(totalSec);
    }

    function updateTTMailLink() {
        const mailBtn = document.getElementById('tt-mail-btn');
        if (!mailBtn) return;

        const dateStr = new Date().toLocaleDateString('de-DE');
        const subject = encodeURIComponent(`Arbeitszeiterfassung ${dateStr} - ${ttState.userName || 'Mitarbeiter'}`);
        
        let body = `Hallo Dennis,\n\nhier ist die Zusammenfassung meiner erfassten Arbeitszeiten für den ${dateStr}:\n\n`;
        let totalSec = 0;
        if (ttState.recentEntries && ttState.recentEntries.length > 0) {
            ttState.recentEntries.forEach(e => {
                totalSec += (e.duration_seconds || 0);
                body += `- ${e.activity_description || 'Tätigkeit'}: ${formatDurationHuman(e.duration_seconds || 0)}\n`;
            });
        }
        body += `\nGesamtarbeitszeit: ${formatDurationHuman(totalSec)}\n\nBeste Grüße,\n${ttState.userName || ''}`;
        
        mailBtn.href = `mailto:mail@besseler.de?subject=${subject}&body=${encodeURIComponent(body)}`;
    }

    function ttFetchStatus() {
        fetch("{{ route('time-tracking.status') }}")
            .then(res => res.json())
            .then(data => {
                ttState.userName = data.user_name || '';
                ttState.recentEntries = data.recent_entries || [];
                if (data.active_entry) {
                    ttState.activeEntry = data.active_entry;
                    ttState.status = data.active_entry.status;
                    ttState.durationSeconds = data.current_duration || 0;
                    startTimerLoop();
                } else {
                    ttState.activeEntry = null;
                    ttState.status = 'stopped';
                    ttState.durationSeconds = 0;
                    stopTimerLoop();
                }
                updateTTUI();
            })
            .catch(e => console.error('TT Status Error:', e));
    }

    function startTimerLoop() {
        stopTimerLoop();
        if (ttState.status === 'running') {
            ttState.timerInterval = setInterval(() => {
                ttState.durationSeconds += 1;
                const pillTime = document.getElementById('tt-pill-time');
                const bigTime = document.getElementById('tt-big-time');
                const timeStr = formatTTTime(ttState.durationSeconds);
                if (pillTime) pillTime.textContent = timeStr;
                if (bigTime) bigTime.textContent = timeStr;
            }, 1000);
        }
    }

    function stopTimerLoop() {
        if (ttState.timerInterval) {
            clearInterval(ttState.timerInterval);
            ttState.timerInterval = null;
        }
    }

    function ttStart() {
        const input = document.getElementById('tt-task-input');
        const desc = (input && input.value.trim()) ? input.value.trim() : 'Kundenbetreuung & Portalverwaltung';

        // Optimistic instant UI transition
        ttState.status = 'running';
        ttState.durationSeconds = 0;
        ttState.activeEntry = { activity_description: desc, status: 'running' };
        updateTTUI();
        startTimerLoop();

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
        .then(res => {
            if (!res.ok) throw new Error('HTTP ' + res.status);
            return res.json();
        })
        .then(data => {
            if (data && data.success) {
                if (input) input.value = '';
                ttFetchStatus();
            }
        })
        .catch(err => {
            console.error('Time tracking start error:', err);
            ttFetchStatus();
        });
    }

    function ttPause() {
        ttState.status = 'paused';
        stopTimerLoop();
        updateTTUI();

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
        .then(data => {
            ttFetchStatus();
        })
        .catch(err => {
            console.error('Time tracking pause error:', err);
            ttFetchStatus();
        });
    }

    function ttResume() {
        ttState.status = 'running';
        updateTTUI();
        startTimerLoop();

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
        .then(data => {
            ttFetchStatus();
        })
        .catch(err => {
            console.error('Time tracking resume error:', err);
            ttFetchStatus();
        });
    }

    function ttStop() {
        ttState.status = 'stopped';
        stopTimerLoop();
        ttState.durationSeconds = 0;
        updateTTUI();

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
            ttFetchStatus();
        })
        .catch(err => {
            console.error('Time tracking stop error:', err);
            ttFetchStatus();
        });
    }

    function ttCopySummary() {
        const dateStr = new Date().toLocaleDateString('de-DE');
        let text = `Arbeitszeiterfassung ${dateStr} - ${ttState.userName || 'Mitarbeiter'}\n`;
        text += `==========================================\n`;
        let totalSec = 0;
        if (ttState.recentEntries && ttState.recentEntries.length > 0) {
            ttState.recentEntries.forEach(e => {
                totalSec += (e.duration_seconds || 0);
                text += `• ${e.activity_description || 'Tätigkeit'}: ${formatDurationHuman(e.duration_seconds || 0)}\n`;
            });
        }
        text += `==========================================\n`;
        text += `Gesamt: ${formatDurationHuman(totalSec)}\n`;

        navigator.clipboard.writeText(text).then(() => {
            alert('Zusammenfassung wurde in die Zwischenablage kopiert!');
        }).catch(() => {
            prompt('Zusammenfassung kopieren:', text);
        });
    }

    // Auto-init on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', ttFetchStatus);
    } else {
        ttFetchStatus();
    }
</script>
@endif
