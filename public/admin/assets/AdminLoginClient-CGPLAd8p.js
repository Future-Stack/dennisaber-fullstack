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
    let e = `dennis@besseler.de`,
        [t, n] = (0, r.useState)(``),
        [a, o] = (0, r.useState)(``),
        [s, c] = (0, r.useState)(!1),
        [l, u] = (0, r.useState)(``);
    async function d(r) {
        r.preventDefault(), c(!0), u(``);
        try {
            let r = await fetch(`/api/admin-login`, {
                    method: `POST`,
                    headers: {
                        "content-type": `application/json`
                    },
                    body: JSON.stringify({
                        email: e,
                        password: t,
                        securityCode: a
                    })
                }),
                i = await r.json();
            if (!r.ok || !i.redirectTo) throw Error(i.error || `Die eingegebenen Zugangsdaten sind nicht korrekt.`);
            n(``), o(``), window.location.replace(i.redirectTo)
        } catch (e) {
            n(``), o(``), u(e instanceof Error ? e.message : `Die eingegebenen Zugangsdaten sind nicht korrekt.`)
        } finally {
            c(!1)
        }
    }
    return (0, i.jsxs)(`form`, {
        className: `admin-login-form`,
        autoComplete: `off`,
        onSubmit: d,
        children: [(0, i.jsxs)(`label`, {
            children: [(0, i.jsx)(`span`, {
                children: `E-Mail-Adresse`
            }), (0, i.jsx)(`input`, {
                autoComplete: `username`,
                inputMode: `email`,
                name: `admin-email`,
                readOnly: !0,
                required: !0,
                type: `email`,
                value: e
            })]
        }), (0, i.jsxs)(`label`, {
            children: [(0, i.jsx)(`span`, {
                children: `Passwort`
            }), (0, i.jsx)(`input`, {
                autoComplete: `current-password`,
                name: `admin-password`,
                required: !0,
                type: `password`,
                value: t,
                onChange: e => n(e.target.value)
            })]
        }), (0, i.jsxs)(`label`, {
            children: [(0, i.jsx)(`span`, {
                children: `Sicherheitscode`
            }), (0, i.jsx)(`input`, {
                autoComplete: `off`,
                inputMode: `numeric`,
                maxLength: 4,
                name: `admin-security-check`,
                pattern: `[0-9]{4}`,
                required: !0,
                type: `password`,
                value: a,
                onChange: e => o(e.target.value.replace(/\D/g, ``).slice(0, 4))
            })]
        }), (0, i.jsx)(`small`, {
            children: `Zusätzliche Sicherheitsprüfung für den Hauptadministrator.`
        }), (0, i.jsx)(`button`, {
            type: `submit`,
            disabled: s,
            children: s ? `Anmeldung wird geprüft …` : `Sicher anmelden`
        }), l && (0, i.jsx)(`p`, {
            className: `login-message`,
            role: `alert`,
            children: l
        })]
    })
}
export {
    a as
    default
};