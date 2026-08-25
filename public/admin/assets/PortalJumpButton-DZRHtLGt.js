import {
    r as e
} from "./framework-CXnKph_e.js";
var t = e();

function n({
    direction: e,
    label: n,
    targetId: r
}) {
    function i() {
        let t = document.getElementById(r);
        if (e === `up`) {
            document.documentElement.scrollTop = 0, document.body.scrollTop = 0, window.scrollTo(0, 0);
            return
        }
        let n = t ? t.getBoundingClientRect().top + window.scrollY : Math.max(document.body.scrollHeight, document.documentElement.scrollHeight),
            i = window.matchMedia(`(prefers-reduced-motion: reduce)`).matches ? `auto` : `smooth`;
        window.scrollTo({
            top: n,
            left: 0,
            behavior: i
        }), document.scrollingElement ? .scrollTo({
            top: n,
            left: 0,
            behavior: i
        })
    }
    return (0, t.jsx)(`a`, {
        className: `portal-jump-arrow portal-jump-${e}`,
        href: `#${r}`,
        onClick: i,
        "aria-label": n,
        children: (0, t.jsx)(`span`, {
            "aria-hidden": `true`,
            children: e === `up` ? `↑` : `↓`
        })
    })
}
export {
    n as
    default
};