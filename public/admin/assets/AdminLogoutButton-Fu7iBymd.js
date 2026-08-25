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
    let [e, t] = (0, r.useState)(!1);
    async function n() {
        t(!0);
        try {
            let e = await (await fetch(`/api/admin-logout`, {
                method: `POST`
            })).json();
            window.location.replace(e.redirectTo || `/verwaltung/anmelden`)
        } finally {
            t(!1)
        }
    }
    return (0, i.jsx)(`button`, {
        className: `admin-logout-button`,
        type: `button`,
        disabled: e,
        onClick: () => void n(),
        children: e ? `Abmeldung …` : `Abmelden`
    })
}
export {
    a as
    default
};