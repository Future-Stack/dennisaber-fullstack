function e(e) {
    let t = new Date(e);
    if (Number.isNaN(t.getTime())) throw Error(`Ungültiger Anlagezeitpunkt.`);
    return Date.UTC(t.getUTCFullYear(), t.getUTCMonth(), t.getUTCDate() + 14, 12)
}

function t(e, t) {
    let n = new Date(t);
    if (Number.isNaN(n.getTime())) throw Error(`Ungültiger Freischaltungszeitpunkt.`);
    if (e === `rio-negro-2002`) {
        let e = new Date(n);
        return e.setUTCDate(e.getUTCDate() + 30), e.getTime()
    }
    let r = new Date(n),
        i = r.getUTCDate();
    r.setUTCDate(1), r.setUTCMonth(r.getUTCMonth() + 4);
    let a = new Date(Date.UTC(r.getUTCFullYear(), r.getUTCMonth() + 1, 0)).getUTCDate();
    return r.setUTCDate(Math.min(i, a)), r.getTime()
}

function n(e) {
    return e === `rio-negro-2002` ? `30 Tage ab Freischaltung` : `Vier Monate ab Freischaltung`
}
export {
    n,
    e as r,
    t
};