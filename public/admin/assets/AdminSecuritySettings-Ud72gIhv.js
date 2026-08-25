import {
    r as e
} from "./rolldown-runtime-S-ySWqyJ.js";
import {
    i as t,
    r as n
} from "./framework-CXnKph_e.js";
var r = e(t(), 1),
    i = n();

function a() {
    return (0, i.jsxs)(`section`, {
        className: `admin-section admin-security-settings`,
        id: `hauptadmin-sicherheit`,
        children: [(0, i.jsxs)(`header`, {
            children: [(0, i.jsxs)(`div`, {
                children: [(0, i.jsx)(`span`, {
                    children: `08`
                }), (0, i.jsxs)(`h2`, {
                    children: [`Hauptadmin-`, (0, i.jsx)(`br`, {}), `Sicherheit.`]
                })]
            }), (0, i.jsx)(`p`, {
                children: `Das Admin-Passwort kann hier sicher geändert werden. Der vierstellige Sicherheitscode bleibt fest hinterlegt und wird im Portal niemals angezeigt. Eine Passwortänderung beendet alle Hauptadmin-Sitzungen.`
            })]
        }), (0, i.jsx)(`div`, {
            className: `admin-security-grid`,
            children: (0, i.jsx)(o, {})
        })]
    })
}

function o() {
    let [e, t] = (0, r.useState)(``), [n, a] = (0, r.useState)(``), [o, s] = (0, r.useState)(``), [c, l] = (0, r.useState)(``), [u, d] = (0, r.useState)(!1), [f, p] = (0, r.useState)(``);
    async function m(r) {
        r.preventDefault(), d(!0), p(``);
        try {
            let r = await fetch(`/api/verwaltung/sicherheit`, {
                    method: `POST`,
                    headers: {
                        "content-type": `application/json`
                    },
                    body: JSON.stringify({
                        action: `change-password`,
                        currentPassword: e,
                        currentSecurityCode: n,
                        newPassword: o,
                        confirmation: c
                    })
                }),
                i = await r.json();
            if (!r.ok) throw Error(i.error || `Änderung fehlgeschlagen.`);
            t(``), a(``), s(``), l(``), p(i.message || `Änderung gespeichert.`), i.redirectTo && window.setTimeout(() => window.location.replace(i.redirectTo), 900)
        } catch (e) {
            p(e instanceof Error ? e.message : `Änderung fehlgeschlagen.`)
        } finally {
            d(!1)
        }
    }
    return (0, i.jsxs)(`form`, {
        autoComplete: `off`,
        onSubmit: m,
        children: [(0, i.jsx)(`h3`, {
            children: `Admin-Passwort ändern`
        }), (0, i.jsx)(`p`, {
            children: `Mindestens 12 Zeichen mit Groß- und Kleinbuchstaben, Zahl und Sonderzeichen.`
        }), (0, i.jsxs)(`label`, {
            children: [(0, i.jsx)(`span`, {
                children: `Bisheriges Admin-Passwort`
            }), (0, i.jsx)(`input`, {
                autoComplete: `current-password`,
                required: !0,
                type: `password`,
                value: e,
                onChange: e => t(e.target.value)
            })]
        }), (0, i.jsxs)(`label`, {
            children: [(0, i.jsx)(`span`, {
                children: `Bisheriger Sicherheitscode`
            }), (0, i.jsx)(`input`, {
                autoComplete: `off`,
                inputMode: `numeric`,
                maxLength: 4,
                pattern: `[0-9]{4}`,
                required: !0,
                type: `password`,
                value: n,
                onChange: e => a(e.target.value.replace(/\D/g, ``).slice(0, 4))
            })]
        }), (0, i.jsxs)(`label`, {
            children: [(0, i.jsx)(`span`, {
                children: `Neues Admin-Passwort`
            }), (0, i.jsx)(`input`, {
                autoComplete: `new-password`,
                maxLength: 128,
                minLength: 12,
                required: !0,
                type: `password`,
                value: o,
                onChange: e => s(e.target.value)
            })]
        }), (0, i.jsxs)(`label`, {
            children: [(0, i.jsx)(`span`, {
                children: `Neues Passwort wiederholen`
            }), (0, i.jsx)(`input`, {
                autoComplete: `new-password`,
                maxLength: 128,
                minLength: 12,
                required: !0,
                type: `password`,
                value: c,
                onChange: e => l(e.target.value)
            })]
        }), (0, i.jsx)(`button`, {
            type: `submit`,
            disabled: u,
            children: u ? `Wird geprüft …` : `Sicher ändern`
        }), f && (0, i.jsx)(`p`, {
            role: `status`,
            children: f
        })]
    })
}
export {
    a as
    default
};