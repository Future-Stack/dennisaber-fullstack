import {
    r as e
} from "./rolldown-runtime-S-ySWqyJ.js";
import {
    i as t,
    r as n
} from "./framework-CXnKph_e.js";
var r = e(t(), 1),
    i = n();

function a({
    compact: e = !1
}) {
    let [t, n] = (0, r.useState)(!1), [a, c] = (0, r.useState)(``), [l, u] = (0, r.useState)({
        active: null,
        completed: []
    }), [d, f] = (0, r.useState)(0), [p, m] = (0, r.useState)(!1), [h, g] = (0, r.useState)(``), [_, v] = (0, r.useState)(!1), y = (0, r.useCallback)(async () => {
        try {
            let e = await fetch(`/api/arbeitszeit`, {
                cache: `no-store`
            });
            if (!e.ok) return;
            u(await e.json()), f(Date.now())
        } catch {
            g(`Timer konnte nicht geladen werden.`)
        }
    }, []);
    (0, r.useEffect)(() => {
        let e = window.requestAnimationFrame(() => void y());
        return () => window.cancelAnimationFrame(e)
    }, [y]), (0, r.useEffect)(() => {
        if (!l.active) return;
        let e = window.setInterval(() => f(Date.now()), 1e3);
        return () => window.clearInterval(e)
    }, [l.active]), (0, r.useEffect)(() => {
        if (!t) return;
        let e = e => {
            e.key === `Escape` && n(!1)
        };
        return window.addEventListener(`keydown`, e), () => window.removeEventListener(`keydown`, e)
    }, [t]);
    async function b(e) {
        m(!0), g(``);
        try {
            let t = await fetch(`/api/arbeitszeit`, {
                    method: `POST`,
                    headers: {
                        "content-type": `application/json`
                    },
                    body: JSON.stringify({
                        action: e,
                        subject: a
                    })
                }),
                n = await t.json();
            if (!t.ok) throw Error(n.error || `Timer-Aktion fehlgeschlagen.`);
            u(n), e === `start` && c(``), f(Date.now())
        } catch (e) {
            g(e instanceof Error ? e.message : `Timer-Aktion fehlgeschlagen.`)
        } finally {
            m(!1)
        }
    }

    function x(e) {
        e.preventDefault(), b(`start`)
    }
    let S = l.active ? Math.max(0, Math.floor((d - l.active.startedAt) / 1e3)) : 0;

    function C() {
        if (!_ || l.completed.length === 0) return;
        let e = [`Hallo Dennis,`, ``, `hiermit übermittle ich folgende Zeitinformationen:`, ``, ...l.completed.map((e, t) => {
            let n = s(e.startedAt),
                r = s(e.stoppedAt || e.startedAt);
            return `${t+1}. ${e.subject}\n   Beginn: ${n}\n   Ende: ${r}\n   Dauer: ${o(e.durationSeconds||0)}`
        }), ``, `Diese Nachricht dient ausschließlich der internen Information.`, ``, `Viele Grüße`].join(`
`);
        window.location.href = `mailto:dennis@besseler.de?subject=Interne%20Zeitinformation&body=${encodeURIComponent(e)}`
    }
    return (0, i.jsxs)(`div`, {
        className: `work-timer${e?` is-compact`:``}`,
        children: [(0, i.jsxs)(`button`, {
            className: `work-timer-toggle${l.active?` is-running`:``}`,
            type: `button`,
            "aria-expanded": t,
            onClick: () => n(e => !e),
            children: [(0, i.jsx)(`span`, {
                children: l.active ? `Timer läuft` : `Timer`
            }), (0, i.jsx)(`b`, {
                children: l.active ? o(S) : `00:00:00`
            })]
        }), t && (0, i.jsxs)(`div`, {
            className: `work-timer-panel`,
            children: [(0, i.jsxs)(`div`, {
                className: `work-timer-panel-head`,
                children: [(0, i.jsx)(`strong`, {
                    children: `Zeitmessung`
                }), (0, i.jsxs)(`button`, {
                    type: `button`,
                    "aria-label": `Timer minimieren`,
                    onClick: () => n(!1),
                    children: [(0, i.jsx)(`span`, {
                        "aria-hidden": `true`,
                        children: `×`
                    }), `Minimieren`]
                })]
            }), l.active ? (0, i.jsxs)(`div`, {
                className: `work-timer-running`,
                children: [(0, i.jsx)(`span`, {
                    children: `Aktuelle Zeitmessung`
                }), (0, i.jsx)(`strong`, {
                    children: l.active.subject
                }), (0, i.jsx)(`b`, {
                    children: o(S)
                }), (0, i.jsx)(`button`, {
                    type: `button`,
                    disabled: p,
                    onClick: () => void b(`stop`),
                    children: `Zeit stoppen`
                })]
            }) : (0, i.jsxs)(`form`, {
                onSubmit: x,
                children: [(0, i.jsxs)(`label`, {
                    children: [(0, i.jsx)(`span`, {
                        children: `Betreff`
                    }), (0, i.jsx)(`input`, {
                        required: !0,
                        maxLength: 120,
                        value: a,
                        onChange: e => c(e.target.value),
                        placeholder: `Wofür wird die Zeit gestoppt?`
                    })]
                }), (0, i.jsx)(`button`, {
                    type: `submit`,
                    disabled: p,
                    children: `Zeitmessung starten`
                })]
            }), h && (0, i.jsx)(`p`, {
                role: `alert`,
                children: h
            }), (0, i.jsxs)(`div`, {
                className: `work-timer-history`,
                children: [(0, i.jsx)(`span`, {
                    children: `Die drei letzten Messungen`
                }), (0, i.jsx)(`p`, {
                    className: `work-timer-limit`,
                    role: `note`,
                    children: `Wichtig: Es werden höchstens drei abgeschlossene Zeitmessungen gespeichert. Sobald eine vierte Messung abgeschlossen wird, wird der älteste Eintrag automatisch gelöscht.`
                }), l.completed.length === 0 ? (0, i.jsx)(`small`, {
                    children: `Noch keine abgeschlossene Zeitmessung.`
                }) : l.completed.map(e => (0, i.jsxs)(`div`, {
                    children: [(0, i.jsx)(`strong`, {
                        children: e.subject
                    }), (0, i.jsx)(`b`, {
                        children: o(e.durationSeconds || 0)
                    }), (0, i.jsx)(`small`, {
                        children: s(e.stoppedAt || e.startedAt)
                    })]
                }, e.id))]
            }), (0, i.jsxs)(`div`, {
                className: `work-timer-send`,
                children: [(0, i.jsx)(`strong`, {
                    children: `An Dennis übergeben`
                }), (0, i.jsx)(`small`, {
                    children: `Es öffnet sich Ihr eigenes E-Mail-Programm. Das Portal versendet nichts automatisch.`
                }), (0, i.jsxs)(`label`, {
                    children: [(0, i.jsx)(`input`, {
                        type: `checkbox`,
                        checked: _,
                        onChange: e => v(e.target.checked)
                    }), (0, i.jsx)(`span`, {
                        children: `Ich weiß, dass ich mir im geöffneten E-Mail-Programm über „Cc/Kopie“ eine Kopie an meine eigene Adresse senden kann.`
                    })]
                }), (0, i.jsx)(`button`, {
                    type: `button`,
                    disabled: !_ || l.completed.length === 0,
                    onClick: C,
                    children: `E-Mail vorbereiten`
                })]
            })]
        })]
    })
}

function o(e) {
    return [Math.floor(e / 3600), Math.floor(e % 3600 / 60), e % 60].map(e => String(e).padStart(2, `0`)).join(`:`)
}

function s(e) {
    return new Intl.DateTimeFormat(`de-DE`, {
        dateStyle: `short`,
        timeStyle: `short`
    }).format(new Date(e))
}
export {
    a as
    default
};