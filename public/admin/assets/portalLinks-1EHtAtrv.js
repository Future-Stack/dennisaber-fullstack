var e = `https://besseler-kursvorschau.dennis-bes.chatgpt.site/`,
    t = {
        "dnl-kompakt": `/akademie/bildungsurlaub/`,
        "dnl-vertiefung": `/akademie/vertiefung/`,
        "dnl-premium": `/akademie/premium/`,
        "stress-und-ressourcen": `/praevention/stress/`,
        rauchfrei: `/praevention/rauchfrei/`,
        ernaehrung: `/praevention/ernaehrung/`,
        "klar-entscheiden": `/praevention/klar-entscheiden/`,
        "erfolgreich-gruenden": `/gruenden/`,
        "presse-oeffentlichkeit": `/presse/`,
        "rhetorik-unter-druck": `/rhetorik/`,
        "rio-negro-2002": `/service/rio-negro/`
    };

function n(n) {
    let r = t[n];
    if (!r) throw Error(`Für den Kurs ${n} ist keine öffentliche Kursseite hinterlegt.`);
    return new URL(r, e).toString()
}
var r = `https://drive.google.com/drive/folders/1KSr6zNf4IT3-Rq58Hj2mfr52ugJBq8Xk?usp=drive_link`;
export {
    e as n, n as r, r as t
};