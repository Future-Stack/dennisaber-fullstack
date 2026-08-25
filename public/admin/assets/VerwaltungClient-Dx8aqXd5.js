import {
    r as e
} from "./rolldown-runtime-S-ySWqyJ.js";
import {
    i as t,
    r as n
} from "./framework-CXnKph_e.js";
import r from "./PortalJumpButton-DZRHtLGt.js";
import {
    r as i,
    t as a
} from "./portalLinks-1EHtAtrv.js";
import ee from "./WorkTimer-Bi_tirqK.js";
import {
    t as o
} from "./courses-D6PjcnQ9.js";
import {
    n as s,
    r as c,
    t as te
} from "./course-access-BagSh7Q1.js";
var l = e(t(), 1),
    u = n(),
    d = [{
        key: `view_customers`,
        label: `Kunden sehen und suchen`
    }, {
        key: `create_customers`,
        label: `Kundenkonten anlegen · maximal 11 pro Tag`
    }, {
        key: `manage_courses`,
        label: `Kursfreigaben und Laufzeiten verwalten`
    }, {
        key: `reset_passwords`,
        label: `Kundenpasswörter neu erzeugen`
    }, {
        key: `manage_customer_status`,
        label: `Kundenkonten aktivieren und sperren`
    }];

function ne() {
    let e = x(Date.now());
    return {
        name: ``,
        jobTitle: ``,
        username: ``,
        password: ``,
        startsOn: e,
        expiresOn: v(e, 30),
        permissions: d.map(e => e.key)
    }
}

function re() {
    return {
        firstName: ``,
        username: ``,
        invoiceNumber: ``,
        password: ``,
        courseSlug: ``,
        startsOn: x(c(Date.now())),
        expiresOn: ``,
        earlyStartConfirmed: !1
    }
}
var ie = [{
        label: `Portalstart`,
        href: `/`
    }, {
        label: `Kundenlogin`,
        href: `/login`
    }, {
        label: `Passwort vergessen`,
        href: `/passwort-vergessen`
    }, {
        label: `Zahlung`,
        href: `/zahlung`
    }, {
        label: `Zahlungsbedingungen`,
        href: `/zahlungsbedingungen`
    }, {
        label: `Rio-Negro-Service`,
        href: `/service/rio-negro`
    }, {
        label: `Kopierschutz`,
        href: `/kopierschutz`
    }, {
        label: `Datenschutz`,
        href: `/datenschutz`
    }, {
        label: `Impressum`,
        href: `/impressum`
    }],
    ae = [{
        label: `Kundenverwaltung`,
        href: `/verwaltung`
    }, {
        label: `Mitarbeiterlogin`,
        href: `/mitarbeiter-login`
    }, {
        label: `Mitarbeiter-Arbeitsfläche · Admin-Prüfansicht`,
        href: `/verwaltung/mitarbeiter-vorschau`
    }, {
        label: `Mitarbeiterbereich · nach Login`,
        href: `/mitarbeiter`
    }, {
        label: `Mitarbeiterpasswort wiederherstellen`,
        href: `/mitarbeiter-passwort`
    }, {
        label: `Rio-Negro-Audio-Struktur`,
        href: `/verwaltung/audio-website`
    }, {
        label: `Allgemeine Kurs-Testseite`,
        href: `/kurs-test`
    }, {
        label: `Ernährung · Testseite`,
        href: `/kurs-test/ernaehrung`
    }, {
        label: `Presse & Öffentlichkeit · Testseite`,
        href: `/kurs-test/presse-oeffentlichkeit`
    }],
    oe = `DE25 2022 0800 0043 2794 71`,
    f = `https://drive.google.com/drive/folders/1KSr6zNf4IT3-Rq58Hj2mfr52ugJBq8Xk?usp=drive_link`,
    p = `https://dennisbesseler.papierkram.de/login?email=mail%40besseler.de`,
    se = `https://hilfe.papierkram.de/system-status/`;

function m() {
    let [e, t] = (0, l.useState)({
        customers: [],
        notes: [],
        versionNotes: [],
        passwordRequests: [],
        staff: []
    }), [n, c] = (0, l.useState)(!0), [m, v] = (0, l.useState)(``), [y, b] = (0, l.useState)(``), [C, he] = (0, l.useState)(``), [w, T] = (0, l.useState)(() => re()), [E, D] = (0, l.useState)(null), [O, k] = (0, l.useState)(null), [A, j] = (0, l.useState)(null), [M, N] = (0, l.useState)(() => ne()), [ge, P] = (0, l.useState)({}), [F, I] = (0, l.useState)({}), [L, R] = (0, l.useState)({
        id: 0,
        title: ``,
        body: ``
    }), [_e, z] = (0, l.useState)(``), [B, V] = (0, l.useState)({
        id: 0,
        title: ``,
        body: ``
    }), [ve, H] = (0, l.useState)(``), [U, W] = (0, l.useState)({}), [ye, G] = (0, l.useState)({}), [K, q] = (0, l.useState)({}), [J, be] = (0, l.useState)({}), [Y, xe] = (0, l.useState)(``), X = (0, l.useCallback)(async () => {
        c(!0);
        try {
            let e = await fetch(`/api/verwaltung`, {
                    cache: `no-store`
                }),
                n = await e.json();
            if (!e.ok) throw Error(n.error || `Verwaltung konnte nicht geladen werden.`);
            t(n), P(Object.fromEntries(n.staff.map(e => [e.id, {
                name: e.name,
                jobTitle: e.jobTitle,
                startsOn: x(e.startsAt),
                expiresOn: x(e.expiresAt),
                permissions: e.permissions
            }]))), q(Object.fromEntries(n.customers.flatMap(e => e.enrollments.map(e => [e.id, {
                startsOn: x(e.startsAt),
                expiresOn: x(e.expiresAt)
            }]))))
        } catch (e) {
            b(e instanceof Error ? e.message : `Verwaltung konnte nicht geladen werden.`)
        } finally {
            c(!1)
        }
    }, []);
    (0, l.useEffect)(() => {
        let e = window.requestAnimationFrame(() => void X());
        return () => window.cancelAnimationFrame(e)
    }, [X]), (0, l.useEffect)(() => {
        let e = window.requestAnimationFrame(() => {
            xe(window.location.origin)
        });
        return () => window.cancelAnimationFrame(e)
    }, []);
    let Se = (0, l.useMemo)(() => {
        let t = C.trim().toLowerCase();
        return t ? e.customers.filter(e => [e.firstName, e.username, e.invoiceNumber].some(e => e.toLowerCase().includes(t))) : e.customers
    }, [C, e.customers]);
    async function Z(e, t, n) {
        v(t), b(``);
        try {
            let t = await fetch(`/api/verwaltung`, {
                    method: `POST`,
                    headers: {
                        "content-type": `application/json`
                    },
                    body: JSON.stringify(e)
                }),
                n = await t.json();
            if (!t.ok) throw Error(n.error || `Aktion fehlgeschlagen.`);
            return await X(), n
        } catch (e) {
            let t = e instanceof Error ? e.message : `Aktion fehlgeschlagen.`;
            return b(t), n ? .(t), null
        } finally {
            v(``)
        }
    }
    async function Ce(e) {
        e.preventDefault(), await we(w)
    }
    async function we(e) {
        D(null);
        let t = le(e);
        if (t) {
            D({
                kind: `error`,
                text: t
            });
            return
        }
        D({
            kind: `working`,
            text: `Kundenkonto wird angelegt …`
        });
        let n = await Z({
            action: `create-customer`,
            firstName: e.firstName,
            username: e.username,
            invoiceNumber: e.invoiceNumber,
            password: e.password,
            courseSlug: e.courseSlug,
            startsAt: e.courseSlug ? _(e.startsOn) : 0,
            expiresAt: e.courseSlug ? _(e.expiresOn) : 0,
            earlyStartConfirmed: e.earlyStartConfirmed
        }, `create`, e => {
            D({
                kind: `error`,
                text: e
            })
        });
        n ? .temporaryPassword && (k({
            username: e.username,
            password: n.temporaryPassword
        }), T(re()), D({
            kind: `success`,
            text: `Kundenkonto wurde angelegt und ist jetzt oben in der Kundenliste sichtbar.`
        }), b(`Kundenkonto wurde angelegt. Zugangsdaten jetzt sicher übermitteln.`))
    }
    async function Te(e, t) {
        let n = t || U[e],
            r = ce(n);
        if (r) {
            G(t => ({ ...t,
                [e]: r
            }));
            return
        }
        G(t => ({ ...t,
            [e]: `Kursfreigabe wird gespeichert …`
        })), await Z({
            action: `assign-course`,
            customerId: e,
            courseSlug: n.courseSlug,
            startsAt: _(n.startsOn),
            expiresAt: _(n.expiresOn),
            earlyStartConfirmed: n.earlyStartConfirmed
        }, `assign-${e}`, t => {
            G(n => ({ ...n,
                [e]: t
            }))
        }) && (W(t => {
            let n = { ...t
            };
            return delete n[e], n
        }), G(t => ({ ...t,
            [e]: `Kursfreigabe wurde gespeichert und ist jetzt oben beim Kunden sichtbar.`
        })), b(`Kursfreigabe wurde gespeichert.`))
    }
    async function Ee(e) {
        let t = K[e.id];
        if (!t ? .startsOn || !t.expiresOn) {
            b(`Bitte Start- und Enddatum vollständig eintragen.`);
            return
        }
        await Z({
            action: `update-enrollment-dates`,
            enrollmentId: e.id,
            startsAt: _(t.startsOn),
            expiresAt: _(t.expiresOn),
            earlyStartConfirmed: J[e.id] === !0
        }, `dates-${e.id}`) && b(`Start- und Enddatum wurden gespeichert.`)
    }
    async function De(e) {
        if (J[e.id] !== !0) return;
        let t = S(),
            n = te(e.courseSlug, t);
        await Z({
            action: `update-enrollment-dates`,
            enrollmentId: e.id,
            startsAt: t,
            expiresAt: n,
            earlyStartConfirmed: !0
        }, `immediate-${e.id}`) && (be(t => ({ ...t,
            [e.id]: !1
        })), b(`Sofortstart wurde gesetzt und die volle Kurslaufzeit neu berechnet.`))
    }
    async function Oe(e) {
        window.confirm(`Kundenkonto ${e.firstName} (${e.invoiceNumber}) vollständig löschen?\n\nKurse, Gerätebindung und alle Sitzungen werden unwiderruflich entfernt. Für ein neues Gerät danach ein neues Konto anlegen.`) && await Z({
            action: `delete-customer`,
            customerId: e.id
        }, `delete-${e.id}`) && b(`Altes Kundenkonto wurde vollständig gelöscht. Jetzt kann ein neues Konto angelegt werden.`)
    }
    async function ke(e, t) {
        if (!window.confirm(`Ein neues sicheres Passwort erzeugen? Alle bestehenden Sitzungen werden beendet. Kursfreigabe, Laufzeit und Gerätebindung bleiben erhalten.`)) return;
        let n = await Z({
            action: `reset-password`,
            customerId: e,
            requestId: t || 0
        }, `reset-${t||e}`);
        !n ? .temporaryPassword || !n.username || (k({
            username: n.username,
            password: n.temporaryPassword
        }), b(`Neues Passwort wurde erzeugt. Zugangsdaten jetzt über die in der Buchhaltung hinterlegte Kontaktmöglichkeit übermitteln.`))
    }
    async function Ae(e) {
        e.preventDefault();
        let t = ue(M.startsOn),
            n = de(M.expiresOn);
        if (!t || !n || n <= t) {
            b(`Bitte einen gültigen Beschäftigungszeitraum eintragen.`);
            return
        }
        if (M.password && !/^(?=.*[A-Za-z])(?=.*\d).{10,128}$/.test(M.password)) {
            b(`Das Mitarbeiterpasswort muss 10 bis 128 Zeichen lang sein und mindestens einen Buchstaben sowie eine Zahl enthalten oder leer bleiben.`);
            return
        }
        let r = await Z({
            action: `create-staff`,
            ...M,
            startsAt: t,
            expiresAt: n
        }, `create-staff`);
        !r ? .temporaryPassword || !r.username || (j({
            username: r.username,
            password: r.temporaryPassword
        }), N(ne()), b(`Mitarbeiterkonto wurde angelegt.`))
    }
    async function je(e) {
        let t = ge[e.id];
        t && await Z({
            action: `update-staff`,
            staffId: e.id,
            ...t,
            startsAt: ue(t.startsOn),
            expiresAt: de(t.expiresOn)
        }, `staff-update-${e.id}`) && b(`Tätigkeit, Zeitraum und Berechtigungen wurden gespeichert. Bestehende Mitarbeiter-Sitzungen wurden beendet.`)
    }
    async function Me(e) {
        let t = await Z({
            action: `reset-staff-password`,
            staffId: e.id
        }, `staff-password-${e.id}`);
        t ? .temporaryPassword && t.username && (j({
            username: t.username,
            password: t.temporaryPassword
        }), b(`Neues Mitarbeiterpasswort wurde erzeugt. Alle bisherigen Sitzungen wurden beendet.`))
    }
    async function Ne(e) {
        let t = !e.active,
            n = await Z({
                action: `toggle-staff`,
                staffId: e.id,
                active: t
            }, `staff-toggle-${e.id}`);
        n && (t && n.temporaryPassword && n.username ? (j({
            username: n.username,
            password: n.temporaryPassword
        }), b(`Mitarbeiterzugang wurde mit vollständig neuen Zugangsdaten aktiviert.`)) : b(`Mitarbeiterzugang wurde gesperrt. Passwort, Wiederherstellungscode und alle Sitzungen sind jetzt ungültig.`))
    }
    async function Pe(e) {
        if (F[e.id] !== !0) {
            b(`Vor dem Löschen muss bestätigt werden, dass der Google-Drive-Zugriff dieses Mitarbeiters entzogen wurde.`);
            return
        }
        window.confirm(`Mitarbeiterkonto ${e.name} (${e.username}) endgültig löschen?`) && await Z({
            action: `delete-staff`,
            staffId: e.id,
            cloudAccessRevoked: !0
        }, `staff-delete-${e.id}`) && (I(t => {
            let n = { ...t
            };
            return delete n[e.id], n
        }), b(`Mitarbeiterkonto wurde gelöscht. Der separate Google-Drive-Zugriff war zuvor als entzogen bestätigt.`))
    }
    async function Fe(e) {
        e.preventDefault(), await Ie()
    }
    async function Ie() {
        if (!L.title.trim() || !L.body.trim()) {
            z(`Bitte Betreff und Nachricht vollständig eintragen.`);
            return
        }
        z(`Persönliche Notiz wird gespeichert …`), await Z({
            action: `save-note`,
            ...L
        }, `note`, z) && (R({
            id: 0,
            title: ``,
            body: ``
        }), z(`Persönliche Notiz wurde in deinem Administratorkonto gespeichert.`))
    }

    function Le(e) {
        R({
            id: e.id,
            title: e.title,
            body: e.body
        }), z(`Die Notiz steht jetzt im Eingabefeld und kann geändert werden.`), window.requestAnimationFrame(() => {
            document.getElementById(`admin-pinboard-form`) ? .scrollIntoView({
                behavior: `smooth`,
                block: `center`
            }), document.getElementById(`admin-pinboard-body`) ? .focus()
        })
    }
    async function Re(e) {
        window.confirm(`Persönliche Notiz „${e.title}“ wirklich löschen?`) && (z(`Persönliche Notiz wird gelöscht …`), await Z({
            action: `delete-note`,
            id: e.id
        }, `note-${e.id}`, z) && z(`Persönliche Notiz wurde gelöscht.`))
    }
    async function ze(e) {
        if (e.preventDefault(), !B.title.trim() || !B.body.trim()) {
            H(`Bitte Titel und Änderungsidee vollständig eintragen.`);
            return
        }
        H(`Eintrag wird dauerhaft gespeichert …`), await Z({
            action: `save-version-note`,
            ...B
        }, `version-note`, H) && (V({
            id: 0,
            title: ``,
            body: ``
        }), H(`Eintrag für die nächste Portalversion wurde dauerhaft gespeichert.`))
    }

    function Be(e) {
        V({
            id: e.id,
            title: e.title,
            body: e.body
        }), H(`Der Eintrag kann jetzt geändert werden.`), window.requestAnimationFrame(() => {
            document.getElementById(`version-pinboard-form`) ? .scrollIntoView({
                behavior: `smooth`,
                block: `center`
            }), document.getElementById(`version-pinboard-body`) ? .focus()
        })
    }
    async function Ve(e) {
        window.confirm(`Eintrag „${e.title}“ wirklich endgültig aus der Planung für die nächste Portalversion löschen?`) && (H(`Bestätigter Eintrag wird gelöscht …`), await Z({
            action: `delete-version-note`,
            id: e.id,
            deletionConfirmed: !0
        }, `version-note-${e.id}`, H) && H(`Der bestätigte Eintrag wurde gelöscht.`))
    }
    async function Q(e, t) {
        await $(`${window.location.origin}${e}`, `${t}: Adresse`)
    }
    async function $(e, t) {
        try {
            await navigator.clipboard.writeText(e), b(`${t} wurde kopiert.`)
        } catch {
            b(`${t} konnte nicht automatisch kopiert werden: ${e}`)
        }
    }
    return (0, u.jsxs)(u.Fragment, {
        children: [(0, u.jsxs)(`nav`, {
            className: `admin-index`,
            id: `admin-navigation`,
            "aria-label": `Inhaltsverzeichnis`,
            children: [(0, u.jsxs)(`div`, {
                className: `admin-index-links`,
                children: [(0, u.jsxs)(`a`, {
                    href: `#arbeitsmittel`,
                    children: [(0, u.jsx)(`span`, {
                        children: `00`
                    }), `Bank & Cloud`]
                }), (0, u.jsxs)(`a`, {
                    href: `#mitarbeiter`,
                    children: [(0, u.jsx)(`span`, {
                        children: `MA`
                    }), `Mitarbeiter`]
                }), (0, u.jsxs)(`a`, {
                    href: `#hauptadmin-sicherheit`,
                    children: [(0, u.jsx)(`span`, {
                        children: `SI`
                    }), `Admin-Sicherheit`]
                }), (0, u.jsxs)(`a`, {
                    href: `#datenaustausch`,
                    children: [(0, u.jsx)(`span`, {
                        children: `DT`
                    }), `Datentausch`]
                }), (0, u.jsxs)(`a`, {
                    href: `#zugangsanfragen`,
                    children: [(0, u.jsx)(`span`, {
                        children: `02`
                    }), `Anfragen`]
                }), (0, u.jsxs)(`a`, {
                    href: `#kunden`,
                    children: [(0, u.jsx)(`span`, {
                        children: `03`
                    }), `Kunden`]
                }), (0, u.jsxs)(`a`, {
                    href: `#anlegen`,
                    children: [(0, u.jsx)(`span`, {
                        children: `04`
                    }), `Anlegen`]
                }), (0, u.jsxs)(`a`, {
                    href: `#auslieferung`,
                    children: [(0, u.jsx)(`span`, {
                        children: `05`
                    }), `Auslieferung`]
                }), (0, u.jsxs)(`a`, {
                    href: `#sicherheit`,
                    children: [(0, u.jsx)(`span`, {
                        children: `06`
                    }), `Ablauf`]
                }), (0, u.jsxs)(`a`, {
                    href: `#naechste-version`,
                    children: [(0, u.jsx)(`span`, {
                        children: `NV`
                    }), `Nächste Version`]
                }), (0, u.jsxs)(`a`, {
                    href: `#pinnwand`,
                    children: [(0, u.jsx)(`span`, {
                        children: `01`
                    }), `Notizen`]
                }), (0, u.jsxs)(`a`, {
                    href: p,
                    target: `_blank`,
                    rel: `noreferrer`,
                    children: [(0, u.jsx)(`span`, {
                        children: `RE`
                    }), `Rechnungen`]
                })]
            }), (0, u.jsx)(ee, {
                compact: !0
            }), (0, u.jsx)(r, {
                direction: `down`,
                label: `Zum unteren Ende des Verwaltungsbereichs`,
                targetId: `admin-page-end`
            })]
        }), (0, u.jsxs)(`section`, {
            className: `admin-bank-card`,
            id: `arbeitsmittel`,
            "aria-labelledby": `business-account-title`,
            children: [(0, u.jsxs)(`div`, {
                children: [(0, u.jsx)(`p`, {
                    className: `eyebrow`,
                    children: `Interne Zahlungsdaten`
                }), (0, u.jsx)(`h2`, {
                    id: `business-account-title`,
                    children: `Geschäftskonto`
                }), (0, u.jsx)(`p`, {
                    children: `Für Rechnung, Zahlungsabgleich und Kundenservice. Nicht öffentlich im Kundenportal anzeigen.`
                })]
            }), (0, u.jsxs)(`div`, {
                className: `admin-bank-value`,
                children: [(0, u.jsx)(`span`, {
                    children: `IBAN`
                }), (0, u.jsx)(`strong`, {
                    children: oe
                })]
            }), (0, u.jsx)(`button`, {
                type: `button`,
                onClick: () => void $(oe.replaceAll(` `, ``), `IBAN`),
                children: `IBAN kopieren`
            })]
        }), (0, u.jsxs)(`section`, {
            className: `admin-cloud-card`,
            "aria-labelledby": `admin-cloud-title`,
            children: [(0, u.jsxs)(`div`, {
                children: [(0, u.jsx)(`p`, {
                    className: `eyebrow`,
                    children: `Gemeinsamer Arbeitsordner`
                }), (0, u.jsx)(`h2`, {
                    id: `admin-cloud-title`,
                    children: `Drive-Cloud`
                }), (0, u.jsx)(`code`, {
                    children: f
                }), (0, u.jsx)(`p`, {
                    children: `Für nicht sicherheitskritische Arbeitsdateien bis insgesamt 500 MB. Der Ordner bleibt privat; Mitarbeitende fordern über den Link Zugriff an und werden von Dennis freigegeben.`
                }), (0, u.jsx)(`small`, {
                    children: `Keine Passwörter, Zugangsdaten, vollständigen Bankdaten oder besonders sensiblen personenbezogenen Daten hochladen.`
                })]
            }), (0, u.jsxs)(`div`, {
                children: [(0, u.jsx)(`a`, {
                    href: f,
                    target: `_blank`,
                    rel: `noreferrer`,
                    children: `Drive-Ordner öffnen`
                }), (0, u.jsx)(`button`, {
                    type: `button`,
                    onClick: () => void $(f, `Drive-Link`),
                    children: `Drive-Link kopieren`
                })]
            })]
        }), (0, u.jsxs)(`section`, {
            className: `admin-staff-portal-link`,
            "aria-labelledby": `staff-portal-link-title`,
            children: [(0, u.jsxs)(`div`, {
                children: [(0, u.jsx)(`p`, {
                    className: `eyebrow`,
                    children: `Direkter Mitarbeiterzugang`
                }), (0, u.jsx)(`h2`, {
                    id: `staff-portal-link-title`,
                    children: `Mitarbeiter-Login`
                }), (0, u.jsx)(`code`, {
                    children: Y ? `${Y}/mitarbeiter-login` : `/mitarbeiter-login`
                }), (0, u.jsx)(`p`, {
                    children: `Diesen Link an Mitarbeiter weitergeben oder selbst zur Kontrolle öffnen.`
                })]
            }), (0, u.jsxs)(`div`, {
                children: [(0, u.jsx)(`a`, {
                    href: `/verwaltung/mitarbeiter-vorschau`,
                    target: `_blank`,
                    rel: `noreferrer`,
                    children: `Arbeitsfläche prüfen`
                }), (0, u.jsx)(`a`, {
                    href: `/mitarbeiter-login`,
                    target: `_blank`,
                    rel: `noreferrer`,
                    children: `Mitarbeiter-Login öffnen`
                }), (0, u.jsx)(`button`, {
                    type: `button`,
                    onClick: () => void Q(`/mitarbeiter-login`, `Mitarbeiter-Login`),
                    children: `Link kopieren`
                })]
            })]
        }), (0, u.jsxs)(`section`, {
            className: `admin-hero`,
            children: [(0, u.jsx)(`p`, {
                className: `eyebrow`,
                children: `Kundenverwaltung`
            }), (0, u.jsxs)(`h1`, {
                children: [`Kunden anlegen.`, (0, u.jsx)(`br`, {}), `Kurse freigeben.`, (0, u.jsx)(`br`, {}), `Zugänge steuern.`]
            }), (0, u.jsx)(`p`, {
                children: `Wartungsarme Kundenverwaltung mit bewusst minimalen personenbezogenen Daten.`
            }), (0, u.jsxs)(`div`, {
                className: `admin-warning`,
                children: [(0, u.jsx)(`strong`, {
                    children: `Datensparsam aufgebaut`
                }), (0, u.jsx)(`span`, {
                    children: `Gespeichert werden nur Vorname, technischer Benutzername, Kunden-/Rechnungsnummer sowie Kurs-, Laufzeit- und Gerätedaten. Nach Ablauf der letzten Freigabe wird das Portalkonto automatisch gelöscht; die gesetzlich erforderliche Rechnung bleibt getrennt in der Buchhaltung.`
                })]
            })]
        }), y && (0, u.jsx)(`div`, {
            className: `admin-message`,
            role: `status`,
            children: y
        }), (0, u.jsxs)(`section`, {
            className: `admin-section admin-staff`,
            id: `mitarbeiter`,
            children: [(0, u.jsxs)(`header`, {
                children: [(0, u.jsxs)(`div`, {
                    children: [(0, u.jsx)(`span`, {
                        children: `MA`
                    }), (0, u.jsx)(`p`, {
                        className: `eyebrow`,
                        children: `Nur Administrator`
                    })]
                }), (0, u.jsx)(`h2`, {
                    children: `Mitarbeiter sicher einsetzen.`
                })]
            }), (0, u.jsxs)(`div`, {
                className: `staff-security-note`,
                children: [(0, u.jsx)(`strong`, {
                    children: `Strikte Trennung`
                }), (0, u.jsx)(`span`, {
                    children: `Mitarbeiter erhalten einen eigenen zeitlich begrenzten Zugang. Sie sehen niemals Mitarbeiterkonten, Bankdaten oder kostenpflichtige Kursinhalte und können ihre Tätigkeit, Laufzeit oder Berechtigungen nicht selbst verändern.`
                })]
            }), (0, u.jsxs)(`form`, {
                className: `admin-form-preview staff-admin-form`,
                onSubmit: Ae,
                children: [(0, u.jsxs)(`label`, {
                    children: [(0, u.jsx)(`span`, {
                        children: `Name`
                    }), (0, u.jsx)(`input`, {
                        required: !0,
                        value: M.name,
                        onChange: e => N({ ...M,
                            name: e.target.value
                        })
                    })]
                }), (0, u.jsxs)(`label`, {
                    children: [(0, u.jsx)(`span`, {
                        children: `Tätigkeit`
                    }), (0, u.jsx)(`input`, {
                        required: !0,
                        value: M.jobTitle,
                        onChange: e => N({ ...M,
                            jobTitle: e.target.value
                        }),
                        placeholder: `z. B. Kundenservice oder Freelancer`
                    })]
                }), (0, u.jsxs)(`label`, {
                    children: [(0, u.jsx)(`span`, {
                        children: `Benutzername`
                    }), (0, u.jsx)(`input`, {
                        required: !0,
                        value: M.username,
                        onChange: e => N({ ...M,
                            username: e.target.value
                        })
                    })]
                }), (0, u.jsxs)(`label`, {
                    children: [(0, u.jsx)(`span`, {
                        children: `Passwort optional`
                    }), (0, u.jsx)(`input`, {
                        autoComplete: `new-password`,
                        maxLength: 128,
                        type: `password`,
                        value: M.password,
                        onChange: e => N({ ...M,
                            password: e.target.value
                        }),
                        placeholder: `Leer lassen: sicher erzeugen`
                    }), (0, u.jsx)(`small`, {
                        children: `10 bis 128 Zeichen, mindestens ein Buchstabe und eine Zahl. Der Mitarbeiter muss das vorläufige Passwort beim ersten Login ersetzen.`
                    })]
                }), (0, u.jsxs)(`label`, {
                    children: [(0, u.jsx)(`span`, {
                        children: `Zugang ab`
                    }), (0, u.jsx)(`input`, {
                        required: !0,
                        type: `date`,
                        value: M.startsOn,
                        onChange: e => N({ ...M,
                            startsOn: e.target.value
                        })
                    })]
                }), (0, u.jsxs)(`label`, {
                    children: [(0, u.jsx)(`span`, {
                        children: `Zugang bis einschließlich`
                    }), (0, u.jsx)(`input`, {
                        required: !0,
                        type: `date`,
                        value: M.expiresOn,
                        onChange: e => N({ ...M,
                            expiresOn: e.target.value
                        })
                    })]
                }), (0, u.jsxs)(`fieldset`, {
                    className: `staff-permissions`,
                    children: [(0, u.jsx)(`legend`, {
                        children: `Berechtigungen · nur hier durch den Administrator änderbar`
                    }), d.map(e => (0, u.jsxs)(`label`, {
                        children: [(0, u.jsx)(`input`, {
                            type: `checkbox`,
                            checked: M.permissions.includes(e.key),
                            onChange: t => N({ ...M,
                                permissions: t.target.checked ? [...M.permissions, e.key] : M.permissions.filter(t => t !== e.key)
                            })
                        }), (0, u.jsx)(`span`, {
                            children: e.label
                        })]
                    }, e.key))]
                }), (0, u.jsx)(`button`, {
                    type: `submit`,
                    disabled: m === `create-staff`,
                    children: m === `create-staff` ? `Mitarbeiterkonto wird angelegt …` : `Mitarbeiterkonto verbindlich anlegen`
                })]
            }), A && (0, u.jsxs)(`div`, {
                className: `credential-box staff-admin-credential`,
                children: [(0, u.jsx)(`strong`, {
                    children: `Mitarbeiterzugang – nur jetzt vollständig sichtbar`
                }), (0, u.jsxs)(`p`, {
                    children: [`Login: `, (0, u.jsx)(`b`, {
                        children: Y ? `${Y}/mitarbeiter-login` : `/mitarbeiter-login`
                    })]
                }), (0, u.jsxs)(`p`, {
                    children: [`Benutzername: `, (0, u.jsx)(`b`, {
                        children: A.username
                    })]
                }), (0, u.jsxs)(`p`, {
                    children: [`Passwort: `, (0, u.jsx)(`b`, {
                        children: A.password
                    })]
                }), (0, u.jsx)(`small`, {
                    children: `Den persönlichen Wiederherstellungscode richtet der Mitarbeiter nach der Anmeldung selbst ein. Er wird dem Administrator nicht angezeigt.`
                }), (0, u.jsx)(`button`, {
                    type: `button`,
                    onClick: () => j(null),
                    children: `Als sicher übermittelt markieren`
                })]
            }), (0, u.jsx)(`div`, {
                className: `admin-staff-list`,
                children: e.staff.length === 0 ? (0, u.jsx)(`p`, {
                    children: `Noch keine Mitarbeiterkonten angelegt.`
                }) : e.staff.map(e => {
                    let t = ge[e.id] || {
                        name: e.name,
                        jobTitle: e.jobTitle,
                        startsOn: x(e.startsAt),
                        expiresOn: x(e.expiresAt),
                        permissions: e.permissions
                    };
                    return (0, u.jsxs)(`article`, {
                        children: [(0, u.jsxs)(`header`, {
                            children: [(0, u.jsxs)(`div`, {
                                children: [(0, u.jsx)(`span`, {
                                    children: e.active ? e.startsAt > Date.now() ? `Vorgemerkt` : e.expiresAt <= Date.now() ? `Abgelaufen` : `Aktiv` : `Gesperrt`
                                }), (0, u.jsx)(`h3`, {
                                    children: e.name
                                }), (0, u.jsx)(`p`, {
                                    children: e.username
                                })]
                            }), (0, u.jsx)(`b`, {
                                children: e.jobTitle
                            })]
                        }), (0, u.jsxs)(`div`, {
                            className: `admin-staff-fields`,
                            children: [(0, u.jsxs)(`label`, {
                                children: [(0, u.jsx)(`span`, {
                                    children: `Name`
                                }), (0, u.jsx)(`input`, {
                                    value: t.name,
                                    onChange: n => P(r => ({ ...r,
                                        [e.id]: { ...t,
                                            name: n.target.value
                                        }
                                    }))
                                })]
                            }), (0, u.jsxs)(`label`, {
                                children: [(0, u.jsx)(`span`, {
                                    children: `Tätigkeit`
                                }), (0, u.jsx)(`input`, {
                                    value: t.jobTitle,
                                    onChange: n => P(r => ({ ...r,
                                        [e.id]: { ...t,
                                            jobTitle: n.target.value
                                        }
                                    }))
                                })]
                            }), (0, u.jsxs)(`label`, {
                                children: [(0, u.jsx)(`span`, {
                                    children: `Zugang ab`
                                }), (0, u.jsx)(`input`, {
                                    type: `date`,
                                    value: t.startsOn,
                                    onChange: n => P(r => ({ ...r,
                                        [e.id]: { ...t,
                                            startsOn: n.target.value
                                        }
                                    }))
                                })]
                            }), (0, u.jsxs)(`label`, {
                                children: [(0, u.jsx)(`span`, {
                                    children: `Zugang bis`
                                }), (0, u.jsx)(`input`, {
                                    type: `date`,
                                    value: t.expiresOn,
                                    onChange: n => P(r => ({ ...r,
                                        [e.id]: { ...t,
                                            expiresOn: n.target.value
                                        }
                                    }))
                                })]
                            })]
                        }), (0, u.jsxs)(`fieldset`, {
                            className: `staff-permissions`,
                            children: [(0, u.jsx)(`legend`, {
                                children: `Berechtigungen`
                            }), d.map(n => (0, u.jsxs)(`label`, {
                                children: [(0, u.jsx)(`input`, {
                                    type: `checkbox`,
                                    checked: t.permissions.includes(n.key),
                                    onChange: r => P(i => ({ ...i,
                                        [e.id]: { ...t,
                                            permissions: r.target.checked ? [...t.permissions, n.key] : t.permissions.filter(e => e !== n.key)
                                        }
                                    }))
                                }), (0, u.jsx)(`span`, {
                                    children: n.label
                                })]
                            }, n.key))]
                        }), (0, u.jsxs)(`label`, {
                            className: `staff-delete-confirm`,
                            children: [(0, u.jsx)(`input`, {
                                type: `checkbox`,
                                checked: F[e.id] === !0,
                                onChange: t => I(n => ({ ...n,
                                    [e.id]: t.target.checked
                                }))
                            }), (0, u.jsx)(`span`, {
                                children: `Der Google-Drive-Zugriff dieses Mitarbeiters wurde entfernt.`
                            })]
                        }), (0, u.jsxs)(`footer`, {
                            children: [(0, u.jsx)(`button`, {
                                type: `button`,
                                onClick: () => void je(e),
                                disabled: m === `staff-update-${e.id}`,
                                children: `Änderungen speichern`
                            }), (0, u.jsx)(`button`, {
                                type: `button`,
                                onClick: () => void Me(e),
                                disabled: m === `staff-password-${e.id}`,
                                children: `Neues Passwort`
                            }), (0, u.jsx)(`button`, {
                                type: `button`,
                                onClick: () => void Ne(e),
                                disabled: m === `staff-toggle-${e.id}`,
                                children: e.active ? `Zugang sperren` : `Zugang mit neuen Daten aktivieren`
                            }), (0, u.jsx)(`button`, {
                                className: `danger-button`,
                                type: `button`,
                                onClick: () => void Pe(e),
                                disabled: m === `staff-delete-${e.id}` || F[e.id] !== !0,
                                children: `Mitarbeiterkonto löschen`
                            })]
                        })]
                    }, e.id)
                })
            })]
        }), (0, u.jsxs)(`section`, {
            className: `admin-section admin-version-pinboard`,
            id: `naechste-version`,
            "aria-labelledby": `version-pinboard-title`,
            children: [(0, u.jsxs)(`header`, {
                children: [(0, u.jsxs)(`div`, {
                    children: [(0, u.jsx)(`span`, {
                        children: `NV`
                    }), (0, u.jsx)(`p`, {
                        className: `eyebrow`,
                        children: `Nur Dennis · dauerhaft`
                    })]
                }), (0, u.jsx)(`h2`, {
                    id: `version-pinboard-title`,
                    children: `Ideen für die nächste Portalversion`
                })]
            }), (0, u.jsx)(`p`, {
                className: `version-pinboard-intro`,
                children: `Dieser feste Planungsblock bleibt ausschließlich in Dennis’ Administrationsbereich sichtbar. Seine Einträge werden nicht automatisch gelöscht. Ein Eintrag kann nur nach ausdrücklicher Löschbestätigung entfernt werden.`
            }), ve && (0, u.jsx)(`div`, {
                className: `admin-message pinboard-local-message`,
                role: `status`,
                children: ve
            }), (0, u.jsxs)(`form`, {
                className: `note-form version-note-form`,
                id: `version-pinboard-form`,
                noValidate: !0,
                onSubmit: ze,
                children: [(0, u.jsx)(`input`, {
                    maxLength: 120,
                    value: B.title,
                    onChange: e => V({ ...B,
                        title: e.target.value
                    }),
                    placeholder: `Kurzer Titel der Änderung`,
                    "aria-label": `Titel für die nächste Portalversion`
                }), (0, u.jsx)(`textarea`, {
                    id: `version-pinboard-body`,
                    maxLength: 3e3,
                    rows: 5,
                    value: B.body,
                    onChange: e => V({ ...B,
                        body: e.target.value
                    }),
                    placeholder: `Was soll bei der nächsten Portalversion geändert oder ergänzt werden?`,
                    "aria-label": `Änderungsidee für die nächste Portalversion`
                }), (0, u.jsx)(`button`, {
                    type: `submit`,
                    disabled: m === `version-note`,
                    children: B.id ? `Änderung speichern` : `Dauerhaft eintragen`
                }), B.id ? (0, u.jsx)(`button`, {
                    type: `button`,
                    onClick: () => V({
                        id: 0,
                        title: ``,
                        body: ``
                    }),
                    children: `Bearbeitung abbrechen`
                }) : null]
            }), (0, u.jsx)(`div`, {
                className: `version-note-list`,
                children: e.versionNotes.length === 0 ? (0, u.jsx)(`p`, {
                    className: `version-note-empty`,
                    children: `Noch keine Änderung für die nächste Portalversion eingetragen.`
                }) : e.versionNotes.map(e => (0, u.jsxs)(`article`, {
                    className: `version-note-card`,
                    children: [(0, u.jsx)(`span`, {
                        children: `Dauerhafter Planungseintrag`
                    }), (0, u.jsx)(`h3`, {
                        children: e.title
                    }), (0, u.jsx)(`p`, {
                        children: e.body
                    }), (0, u.jsxs)(`footer`, {
                        children: [(0, u.jsx)(`button`, {
                            type: `button`,
                            onClick: () => Be(e),
                            children: `Bearbeiten`
                        }), (0, u.jsx)(`button`, {
                            className: `danger-button`,
                            type: `button`,
                            disabled: m === `version-note-${e.id}`,
                            onClick: () => void Ve(e),
                            children: `Löschen · Bestätigung nötig`
                        })]
                    })]
                }, e.id))
            })]
        }), (0, u.jsxs)(`section`, {
            className: `admin-section admin-service admin-pinboard`,
            id: `pinnwand`,
            children: [(0, u.jsxs)(`header`, {
                children: [(0, u.jsxs)(`div`, {
                    children: [(0, u.jsx)(`span`, {
                        children: `01`
                    }), (0, u.jsx)(`p`, {
                        className: `eyebrow`,
                        children: `Persönliche Admin-Notizen`
                    })]
                }), (0, u.jsx)(`h2`, {
                    children: `Eigene Arbeitsnotizen festhalten.`
                })]
            }), (0, u.jsx)(`p`, {
                className: `pinboard-intro`,
                children: `Nur dein Administratorkonto sieht diese Notizen. Mitarbeiterkonten sehen sie nicht. Maximal fünf persönliche Notizen bleiben gespeichert; nach zehn Tagen werden sie automatisch gelöscht.`
            }), _e && (0, u.jsx)(`div`, {
                className: `admin-message pinboard-local-message`,
                role: `status`,
                children: _e
            }), (0, u.jsxs)(`form`, {
                className: `note-form`,
                id: `admin-pinboard-form`,
                noValidate: !0,
                onSubmit: Fe,
                children: [(0, u.jsx)(`input`, {
                    maxLength: 120,
                    value: L.title,
                    onChange: e => R({ ...L,
                        title: e.target.value
                    }),
                    placeholder: `Kurzer Titel`,
                    "aria-label": `Titel der persönlichen Admin-Notiz`
                }), (0, u.jsx)(`textarea`, {
                    id: `admin-pinboard-body`,
                    maxLength: 2e3,
                    rows: 4,
                    value: L.body,
                    onChange: e => R({ ...L,
                        body: e.target.value
                    }),
                    placeholder: `Eigene Erinnerung, Aufgabe oder Arbeitsnotiz`,
                    "aria-label": `Inhalt der persönlichen Admin-Notiz`
                }), (0, u.jsx)(`button`, {
                    type: `button`,
                    disabled: m === `note`,
                    onClick: () => void Ie(),
                    children: L.id ? `Änderung speichern` : `Notiz speichern`
                }), L.id ? (0, u.jsx)(`button`, {
                    type: `button`,
                    onClick: () => R({
                        id: 0,
                        title: ``,
                        body: ``
                    }),
                    children: `Bearbeitung abbrechen`
                }) : null]
            }), (0, u.jsx)(`div`, {
                className: `note-board`,
                children: e.notes.map((e, t) => (0, u.jsxs)(`article`, {
                    className: `note-card note-color-${t%6+1}`,
                    children: [(0, u.jsx)(`span`, {
                        children: `Persönliche Notiz`
                    }), (0, u.jsx)(`h3`, {
                        children: e.title
                    }), (0, u.jsx)(`p`, {
                        children: e.body
                    }), (0, u.jsxs)(`footer`, {
                        children: [(0, u.jsx)(`button`, {
                            type: `button`,
                            onClick: () => Le(e),
                            children: `Bearbeiten`
                        }), (0, u.jsx)(`button`, {
                            type: `button`,
                            disabled: m === `note-${e.id}`,
                            onClick: () => void Re(e),
                            children: `Löschen`
                        })]
                    })]
                }, e.id))
            })]
        }), (0, u.jsxs)(`section`, {
            className: `admin-section cloud-transfer`,
            id: `datenaustausch`,
            "aria-labelledby": `admin-cloud-transfer-title`,
            children: [(0, u.jsxs)(`header`, {
                children: [(0, u.jsxs)(`div`, {
                    children: [(0, u.jsx)(`span`, {
                        children: `DT`
                    }), (0, u.jsx)(`p`, {
                        className: `eyebrow`,
                        children: `Gemeinsamer Arbeitsordner`
                    })]
                }), (0, u.jsx)(`h2`, {
                    id: `admin-cloud-transfer-title`,
                    children: `Dateien einfach übergeben.`
                })]
            }), (0, u.jsxs)(`div`, {
                className: `cloud-transfer-grid`,
                children: [(0, u.jsxs)(`div`, {
                    className: `cloud-transfer-main`,
                    children: [(0, u.jsx)(`span`, {
                        children: `Externer Google-Drive-Ordner`
                    }), (0, u.jsx)(`h3`, {
                        children: `Nicht vertrauliche Arbeitsdateien austauschen`
                    }), (0, u.jsx)(`p`, {
                        children: `Der Ordner öffnet sich außerhalb des Portals und bleibt bei Google auf „Eingeschränkt“. Mitarbeiter werden von Dennis einzeln mit ihrem Google-Konto freigegeben. Alle freigegebenen Bearbeiter können die dort abgelegten Dateien grundsätzlich sehen, verändern und löschen.`
                    }), (0, u.jsx)(`a`, {
                        href: a,
                        target: `_blank`,
                        rel: `noreferrer`,
                        children: `Google-Drive-Ordner öffnen ↗`
                    })]
                }), (0, u.jsxs)(`div`, {
                    className: `cloud-transfer-rules`,
                    children: [(0, u.jsx)(`strong`, {
                        children: `Verbindliche Arbeitsregeln`
                    }), (0, u.jsxs)(`ul`, {
                        children: [(0, u.jsx)(`li`, {
                            children: `Maximal 500 MB je Datenübergabe.`
                        }), (0, u.jsx)(`li`, {
                            children: `Keine Passwörter, Zugangsdaten oder Wiederherstellungscodes.`
                        }), (0, u.jsx)(`li`, {
                            children: `Keine Kunden-, Rechnungs-, Gesundheits- oder sonstigen personenbezogenen Daten.`
                        }), (0, u.jsx)(`li`, {
                            children: `Keine weiteren Personen selbst für den Ordner freigeben.`
                        }), (0, u.jsx)(`li`, {
                            children: `Dateien eindeutig benennen und nach Abschluss wieder entfernen.`
                        })]
                    }), (0, u.jsx)(`small`, {
                        children: `Die 500-MB-Grenze ist eine Arbeitsregel. Sie wird weder vom Portal noch vom öffentlichen Drive-Link technisch erzwungen.`
                    })]
                })]
            })]
        }), (0, u.jsxs)(`section`, {
            className: `admin-section admin-service`,
            id: `zugangsanfragen`,
            children: [(0, u.jsxs)(`header`, {
                children: [(0, u.jsxs)(`div`, {
                    children: [(0, u.jsx)(`span`, {
                        children: `02`
                    }), (0, u.jsx)(`p`, {
                        className: `eyebrow`,
                        children: `Zugangsanfragen`
                    })]
                }), (0, u.jsx)(`h2`, {
                    children: `Vergessene Zugangsdaten bearbeiten.`
                })]
            }), e.passwordRequests.length === 0 ? (0, u.jsxs)(`div`, {
                className: `admin-empty`,
                children: [(0, u.jsx)(`strong`, {
                    children: `Keine offenen Anfragen`
                }), (0, u.jsx)(`p`, {
                    children: `Neue Anfragen aus dem Kundenlogin erscheinen automatisch an dieser Stelle.`
                })]
            }) : (0, u.jsx)(`div`, {
                className: `password-request-list`,
                children: e.passwordRequests.map(e => {
                    let t = o.find(t => t.slug === e.courseSlug);
                    return (0, u.jsxs)(`article`, {
                        children: [(0, u.jsxs)(`div`, {
                            children: [(0, u.jsx)(`span`, {
                                children: me(e.createdAt)
                            }), (0, u.jsx)(`h3`, {
                                children: e.firstName
                            }), (0, u.jsxs)(`p`, {
                                children: [e.invoiceNumber, ` · `, t ? .catalogTitle || e.courseSlug]
                            })]
                        }), (0, u.jsxs)(`div`, {
                            children: [(0, u.jsx)(`button`, {
                                type: `button`,
                                disabled: m === `reset-${e.id}`,
                                onClick: () => void ke(e.customerId, e.id),
                                children: `Neues Passwort erzeugen`
                            }), (0, u.jsx)(`button`, {
                                type: `button`,
                                disabled: m === `dismiss-${e.id}`,
                                onClick: () => void Z({
                                    action: `dismiss-password-request`,
                                    requestId: e.id
                                }, `dismiss-${e.id}`),
                                children: `Als erledigt markieren`
                            })]
                        })]
                    }, e.id)
                })
            })]
        }), (0, u.jsxs)(`section`, {
            className: `admin-section`,
            id: `kunden`,
            children: [(0, u.jsxs)(`header`, {
                children: [(0, u.jsxs)(`div`, {
                    children: [(0, u.jsx)(`span`, {
                        children: `03`
                    }), (0, u.jsx)(`p`, {
                        className: `eyebrow`,
                        children: `Kundenkonten`
                    })]
                }), (0, u.jsx)(`h2`, {
                    children: `Alle Zugänge auf einen Blick.`
                })]
            }), (0, u.jsxs)(`div`, {
                className: `admin-toolbar`,
                children: [(0, u.jsxs)(`label`, {
                    children: [(0, u.jsx)(`span`, {
                        children: `Kunden suchen`
                    }), (0, u.jsx)(`input`, {
                        value: C,
                        onChange: e => he(e.target.value),
                        type: `search`,
                        placeholder: `Vorname, Benutzername oder Rechnungsnummer`
                    })]
                }), (0, u.jsx)(`a`, {
                    className: `admin-primary-link`,
                    href: `#anlegen`,
                    children: `Neuen Kundenzugang anlegen`
                })]
            }), n ? (0, u.jsx)(`div`, {
                className: `admin-empty`,
                children: (0, u.jsx)(`strong`, {
                    children: `Daten werden geladen …`
                })
            }) : Se.length === 0 ? (0, u.jsxs)(`div`, {
                className: `admin-empty`,
                children: [(0, u.jsx)(`strong`, {
                    children: e.customers.length ? `Kein passender Kunde gefunden` : `Noch keine Kundenkonten angelegt`
                }), (0, u.jsx)(`p`, {
                    children: `Neue Zugänge können direkt im nächsten Abschnitt erstellt und einem Kurs zugewiesen werden.`
                })]
            }) : (0, u.jsx)(`div`, {
                className: `customer-list`,
                children: Se.map(e => (0, u.jsxs)(`article`, {
                    className: e.active ? `customer-card` : `customer-card is-inactive`,
                    children: [(0, u.jsxs)(`header`, {
                        children: [(0, u.jsxs)(`div`, {
                            children: [(0, u.jsx)(`span`, {
                                children: `Vorname`
                            }), (0, u.jsx)(`h3`, {
                                children: e.firstName
                            })]
                        }), (0, u.jsxs)(`div`, {
                            className: `customer-status`,
                            children: [(0, u.jsx)(`b`, {
                                children: e.active ? `Konto aktiv` : `Konto gesperrt`
                            }), (0, u.jsx)(`b`, {
                                children: e.deviceBound ? `Gerät gebunden` : `Noch kein Gerät`
                            })]
                        })]
                    }), (0, u.jsxs)(`dl`, {
                        children: [(0, u.jsxs)(`div`, {
                            children: [(0, u.jsx)(`dt`, {
                                children: `Benutzername`
                            }), (0, u.jsx)(`dd`, {
                                children: e.username
                            })]
                        }), (0, u.jsxs)(`div`, {
                            children: [(0, u.jsx)(`dt`, {
                                children: `Kunden-/Rechnungsnummer`
                            }), (0, u.jsx)(`dd`, {
                                children: e.invoiceNumber
                            })]
                        })]
                    }), (0, u.jsx)(`div`, {
                        className: `customer-enrollments`,
                        children: e.enrollments.length ? e.enrollments.map(e => (0, u.jsxs)(`div`, {
                            children: [(0, u.jsx)(`span`, {
                                children: o.find(t => t.slug === e.courseSlug) ? .catalogTitle || e.courseSlug
                            }), (0, u.jsxs)(`small`, {
                                children: [fe(e), ` · `, pe(e.startsAt), ` bis `, pe(e.expiresAt)]
                            }), (0, u.jsxs)(`label`, {
                                children: [(0, u.jsx)(`span`, {
                                    children: `Startdatum`
                                }), (0, u.jsx)(`input`, {
                                    type: `date`,
                                    value: K[e.id] ? .startsOn || x(e.startsAt),
                                    onChange: t => {
                                        let n = t.target.value;
                                        q(t => ({ ...t,
                                            [e.id]: {
                                                startsOn: n,
                                                expiresOn: g(e.courseSlug, n)
                                            }
                                        }))
                                    }
                                })]
                            }), (0, u.jsxs)(`label`, {
                                children: [(0, u.jsx)(`span`, {
                                    children: `Enddatum`
                                }), (0, u.jsx)(`input`, {
                                    type: `date`,
                                    value: K[e.id] ? .expiresOn || x(e.expiresAt),
                                    onChange: t => q(n => ({ ...n,
                                        [e.id]: {
                                            startsOn: n[e.id] ? .startsOn || x(e.startsAt),
                                            expiresOn: t.target.value
                                        }
                                    }))
                                })]
                            }), (0, u.jsxs)(`label`, {
                                className: `early-start-confirmation`,
                                children: [(0, u.jsx)(`input`, {
                                    type: `checkbox`,
                                    checked: J[e.id] === !0,
                                    onChange: t => be(n => ({ ...n,
                                        [e.id]: t.target.checked
                                    }))
                                }), (0, u.jsx)(`span`, {
                                    children: `Ausdrückliche Kundenerklärung zum vorzeitigen Beginn liegt dokumentiert vor.`
                                })]
                            }), (0, u.jsx)(`button`, {
                                className: `early-start-button`,
                                type: `button`,
                                disabled: J[e.id] !== !0 || m === `immediate-${e.id}`,
                                onClick: () => void De(e),
                                children: `Sofortstart mit voller Laufzeit setzen`
                            }), (0, u.jsx)(`button`, {
                                type: `button`,
                                disabled: m === `dates-${e.id}`,
                                onClick: () => void Ee(e),
                                children: `Termine speichern`
                            }), (0, u.jsx)(`button`, {
                                type: `button`,
                                disabled: m === `enrollment-${e.id}`,
                                onClick: () => void Z({
                                    action: `toggle-enrollment`,
                                    enrollmentId: e.id,
                                    active: !e.active
                                }, `enrollment-${e.id}`),
                                children: e.active ? `Kurs sperren` : `Kurs aktivieren`
                            })]
                        }, e.id)) : (0, u.jsx)(`p`, {
                            children: `Noch kein Kurs freigeschaltet.`
                        })
                    }), (0, u.jsxs)(`div`, {
                        className: `customer-assignment`,
                        children: [(0, u.jsxs)(`select`, {
                            value: U[e.id] ? .courseSlug || ``,
                            onChange: t => W(n => ({ ...n,
                                [e.id]: h(t.target.value)
                            })),
                            children: [(0, u.jsx)(`option`, {
                                value: ``,
                                children: `Kurs auswählen`
                            }), o.map(e => (0, u.jsx)(`option`, {
                                value: e.slug,
                                children: e.catalogTitle
                            }, e.slug))]
                        }), (0, u.jsx)(`input`, {
                            type: `date`,
                            "aria-label": `Startdatum`,
                            value: U[e.id] ? .startsOn || ``,
                            onChange: t => {
                                let n = t.target.value;
                                W(t => ({ ...t,
                                    [e.id]: {
                                        courseSlug: t[e.id] ? .courseSlug || ``,
                                        startsOn: n,
                                        expiresOn: g(t[e.id] ? .courseSlug || ``, n),
                                        earlyStartConfirmed: t[e.id] ? .earlyStartConfirmed || !1
                                    }
                                }))
                            }
                        }), (0, u.jsx)(`input`, {
                            type: `date`,
                            "aria-label": `Enddatum`,
                            value: U[e.id] ? .expiresOn || ``,
                            onChange: t => W(n => ({ ...n,
                                [e.id]: {
                                    courseSlug: n[e.id] ? .courseSlug || ``,
                                    startsOn: n[e.id] ? .startsOn || ``,
                                    expiresOn: t.target.value,
                                    earlyStartConfirmed: n[e.id] ? .earlyStartConfirmed || !1
                                }
                            }))
                        }), (0, u.jsx)(`button`, {
                            type: `button`,
                            disabled: m === `assign-${e.id}`,
                            onClick: () => void Te(e.id),
                            children: `Kurs freigeben`
                        }), (0, u.jsx)(`small`, {
                            children: U[e.id] ? .courseSlug ? `Standard: Start in 14 Tagen · ${s(U[e.id].courseSlug)} · beide Termine frei änderbar` : `Kurs auswählen`
                        }), (0, u.jsxs)(`label`, {
                            className: `early-start-confirmation assignment-early-start`,
                            children: [(0, u.jsx)(`input`, {
                                type: `checkbox`,
                                disabled: !U[e.id] ? .courseSlug,
                                checked: U[e.id] ? .earlyStartConfirmed || !1,
                                onChange: t => W(n => ({ ...n,
                                    [e.id]: { ...n[e.id] || h(``),
                                        earlyStartConfirmed: t.target.checked
                                    }
                                }))
                            }), (0, u.jsx)(`span`, {
                                children: `Ausdrückliche Kundenerklärung zum vorzeitigen Beginn liegt dokumentiert vor.`
                            })]
                        }), (0, u.jsx)(`button`, {
                            className: `early-start-button`,
                            type: `button`,
                            disabled: !U[e.id] ? .courseSlug || !U[e.id] ? .earlyStartConfirmed || m === `assign-${e.id}`,
                            onClick: async () => {
                                let t = U[e.id] ? .courseSlug || ``,
                                    n = x(S()),
                                    r = {
                                        courseSlug: t,
                                        startsOn: n,
                                        expiresOn: g(t, n),
                                        earlyStartConfirmed: !0
                                    };
                                W(t => ({ ...t,
                                    [e.id]: r
                                })), await Te(e.id, r)
                            },
                            children: `Sofortstart mit voller Laufzeit freigeben`
                        }), ye[e.id] && (0, u.jsx)(`p`, {
                            className: `assignment-status`,
                            role: `status`,
                            children: ye[e.id]
                        })]
                    }), (0, u.jsxs)(`footer`, {
                        children: [(0, u.jsx)(`button`, {
                            type: `button`,
                            onClick: () => void ke(e.id),
                            disabled: m === `reset-${e.id}`,
                            children: `Neues Passwort`
                        }), (0, u.jsx)(`button`, {
                            type: `button`,
                            onClick: () => void Z({
                                action: `toggle-customer`,
                                customerId: e.id,
                                active: !e.active
                            }, `toggle-${e.id}`),
                            disabled: m === `toggle-${e.id}`,
                            children: e.active ? `Konto sperren` : `Konto aktivieren`
                        }), (0, u.jsx)(`button`, {
                            className: `danger-button`,
                            type: `button`,
                            onClick: () => void Oe(e),
                            disabled: m === `delete-${e.id}`,
                            children: `Konto vollständig löschen`
                        })]
                    })]
                }, e.id))
            })]
        }), (0, u.jsxs)(`section`, {
            className: `admin-section admin-public`,
            id: `anlegen`,
            children: [(0, u.jsxs)(`header`, {
                children: [(0, u.jsxs)(`div`, {
                    children: [(0, u.jsx)(`span`, {
                        children: `04`
                    }), (0, u.jsx)(`p`, {
                        className: `eyebrow`,
                        children: `Zugang anlegen`
                    })]
                }), (0, u.jsx)(`h2`, {
                    children: `Nur das Nötigste speichern.`
                })]
            }), (0, u.jsxs)(`form`, {
                className: `admin-form-preview`,
                onSubmit: Ce,
                noValidate: !0,
                children: [(0, u.jsxs)(`label`, {
                    children: [(0, u.jsx)(`span`, {
                        children: `Vorname`
                    }), (0, u.jsx)(`input`, {
                        required: !0,
                        value: w.firstName,
                        onChange: e => T({ ...w,
                            firstName: e.target.value
                        }),
                        placeholder: `Nur Vorname`
                    })]
                }), (0, u.jsxs)(`label`, {
                    children: [(0, u.jsx)(`span`, {
                        children: `Technischer Benutzername`
                    }), (0, u.jsx)(`input`, {
                        required: !0,
                        value: w.username,
                        onChange: e => T({ ...w,
                            username: e.target.value
                        }),
                        placeholder: `Eindeutiger Loginname`
                    })]
                }), (0, u.jsxs)(`label`, {
                    children: [(0, u.jsx)(`span`, {
                        children: `Kunden-/Rechnungsnummer`
                    }), (0, u.jsx)(`input`, {
                        required: !0,
                        value: w.invoiceNumber,
                        onChange: e => T({ ...w,
                            invoiceNumber: e.target.value
                        }),
                        placeholder: `Rückverfolgung nur über Buchhaltung`
                    })]
                }), (0, u.jsxs)(`label`, {
                    children: [(0, u.jsx)(`span`, {
                        children: `Passwort (optional)`
                    }), (0, u.jsx)(`input`, {
                        value: w.password,
                        onChange: e => T({ ...w,
                            password: e.target.value
                        }),
                        type: `password`,
                        autoComplete: `new-password`,
                        placeholder: `Leer lassen: wird sicher erzeugt`
                    }), (0, u.jsx)(`small`, {
                        children: `Eigenes Passwort: mindestens 10 Zeichen. Leer lassen erzeugt automatisch ein sicheres Passwort.`
                    })]
                }), (0, u.jsxs)(`label`, {
                    children: [(0, u.jsx)(`span`, {
                        children: `Kurs zuweisen (optional)`
                    }), (0, u.jsxs)(`select`, {
                        value: w.courseSlug,
                        onChange: e => {
                            let t = h(e.target.value);
                            T({ ...w,
                                ...t
                            })
                        },
                        children: [(0, u.jsx)(`option`, {
                            value: ``,
                            children: `Noch keinen Kurs zuweisen`
                        }), o.map(e => (0, u.jsx)(`option`, {
                            value: e.slug,
                            children: e.catalogTitle
                        }, e.slug))]
                    })]
                }), (0, u.jsxs)(`label`, {
                    children: [(0, u.jsx)(`span`, {
                        children: `Startdatum · Standard plus 14 Tage`
                    }), (0, u.jsx)(`input`, {
                        type: `date`,
                        disabled: !w.courseSlug,
                        value: w.startsOn,
                        onChange: e => T({ ...w,
                            startsOn: e.target.value,
                            expiresOn: g(w.courseSlug, e.target.value)
                        })
                    }), (0, u.jsx)(`small`, {
                        children: `Bei dokumentiertem vorzeitigem Beginn frei änderbar.`
                    })]
                }), (0, u.jsxs)(`label`, {
                    children: [(0, u.jsx)(`span`, {
                        children: `Enddatum`
                    }), (0, u.jsx)(`input`, {
                        type: `date`,
                        disabled: !w.courseSlug,
                        value: w.expiresOn,
                        onChange: e => T({ ...w,
                            expiresOn: e.target.value
                        })
                    }), (0, u.jsx)(`small`, {
                        children: w.courseSlug ? `${s(w.courseSlug)} · danach automatische Deaktivierung · kein Abo · frei änderbar` : `Wird nach der Kursauswahl berechnet.`
                    })]
                }), (0, u.jsxs)(`label`, {
                    className: `early-start-confirmation`,
                    children: [(0, u.jsx)(`input`, {
                        type: `checkbox`,
                        disabled: !w.courseSlug,
                        checked: w.earlyStartConfirmed,
                        onChange: e => T({ ...w,
                            earlyStartConfirmed: e.target.checked
                        })
                    }), (0, u.jsx)(`span`, {
                        children: `Ausdrückliche Kundenerklärung zum vorzeitigen Beginn liegt dokumentiert vor.`
                    })]
                }), (0, u.jsx)(`button`, {
                    className: `early-start-button`,
                    type: `button`,
                    disabled: !w.courseSlug || !w.earlyStartConfirmed || m === `create`,
                    onClick: async () => {
                        let e = x(S()),
                            t = { ...w,
                                startsOn: e,
                                expiresOn: g(w.courseSlug, e)
                            };
                        T(t), await we(t)
                    },
                    children: m === `create` ? `Konto wird angelegt …` : `Sofortstart mit voller Laufzeit und Konto anlegen`
                }), (0, u.jsx)(`button`, {
                    type: `submit`,
                    disabled: m === `create`,
                    children: m === `create` ? `Konto wird angelegt …` : `Kundenkonto sicher anlegen`
                }), E && (0, u.jsx)(`div`, {
                    className: `admin-form-message is-${E.kind}`,
                    role: E.kind === `error` ? `alert` : `status`,
                    children: E.text
                })]
            }), O && (0, u.jsxs)(`div`, {
                className: `credential-box`,
                children: [(0, u.jsx)(`strong`, {
                    children: `Zugangsdaten – nur jetzt vollständig sichtbar`
                }), (0, u.jsxs)(`p`, {
                    children: [`Benutzername: `, (0, u.jsx)(`b`, {
                        children: O.username
                    })]
                }), (0, u.jsxs)(`p`, {
                    children: [`Passwort: `, (0, u.jsx)(`b`, {
                        children: O.password
                    })]
                }), (0, u.jsx)(`button`, {
                    type: `button`,
                    onClick: () => k(null),
                    children: `Als sicher übermittelt markieren`
                })]
            })]
        }), (0, u.jsxs)(`section`, {
            className: `admin-section admin-public`,
            id: `auslieferung`,
            children: [(0, u.jsxs)(`header`, {
                children: [(0, u.jsxs)(`div`, {
                    children: [(0, u.jsx)(`span`, {
                        children: `05`
                    }), (0, u.jsx)(`p`, {
                        className: `eyebrow`,
                        children: `Auslieferung und Support`
                    })]
                }), (0, u.jsx)(`h2`, {
                    children: `Kundenwege öffnen und Adressen kopieren.`
                })]
            }), (0, u.jsxs)(`div`, {
                className: `delivery-login-card`,
                children: [(0, u.jsxs)(`div`, {
                    children: [(0, u.jsx)(`span`, {
                        children: `Wichtigste Kundenadresse`
                    }), (0, u.jsx)(`strong`, {
                        children: `Kunden-Anmeldung`
                    }), (0, u.jsx)(`code`, {
                        children: Y ? `${Y}/login` : `/login`
                    }), (0, u.jsx)(`p`, {
                        children: `Diese Adresse erhält der Kunde für die Anmeldung in seinem freigeschalteten Kursbereich.`
                    })]
                }), (0, u.jsxs)(`div`, {
                    children: [(0, u.jsx)(`a`, {
                        href: `/login`,
                        target: `_blank`,
                        rel: `noreferrer`,
                        children: `Anmeldeseite öffnen`
                    }), (0, u.jsx)(`button`, {
                        type: `button`,
                        onClick: () => void Q(`/login`, `Kunden-Anmeldung`),
                        children: `Adresse kopieren`
                    })]
                })]
            }), (0, u.jsxs)(`div`, {
                className: `delivery-course-directory`,
                children: [(0, u.jsxs)(`div`, {
                    className: `delivery-course-heading`,
                    children: [(0, u.jsx)(`strong`, {
                        children: `Geschützte Kursauslieferung`
                    }), (0, u.jsx)(`span`, {
                        children: `Als Administrator öffnest du hier die echte Kursansicht mit einer klar gekennzeichneten Admin-Prüfansicht.`
                    })]
                }), o.map(e => (0, u.jsxs)(`article`, {
                    children: [(0, u.jsxs)(`div`, {
                        children: [(0, u.jsx)(`strong`, {
                            children: e.catalogTitle
                        }), (0, u.jsx)(`span`, {
                            children: `Nur interne Administrator-Prüfansicht`
                        })]
                    }), (0, u.jsx)(`nav`, {
                        "aria-label": `Auslieferung ${e.catalogTitle}`,
                        children: (0, u.jsx)(`a`, {
                            href: `/kurs/${e.slug}`,
                            target: `_blank`,
                            rel: `noreferrer`,
                            children: `Wie der Kunde ansehen`
                        })
                    })]
                }, e.slug))]
            }), (0, u.jsxs)(`div`, {
                className: `public-course-directory`,
                children: [(0, u.jsxs)(`div`, {
                    className: `delivery-course-heading`,
                    children: [(0, u.jsx)(`strong`, {
                        children: `Kursseiten`
                    }), (0, u.jsx)(`span`, {
                        children: `Je Kurs getrennt: öffentliche Kursseite auf der Website und echter geschützter Kurszugang in diesem Portal.`
                    })]
                }), o.map(e => {
                    let t = i(e.slug);
                    return (0, u.jsxs)(`article`, {
                        children: [(0, u.jsx)(`strong`, {
                            children: e.catalogTitle
                        }), (0, u.jsxs)(`div`, {
                            className: `public-course-address`,
                            children: [(0, u.jsx)(`span`, {
                                children: `Öffentliche Kursseite`
                            }), (0, u.jsx)(`code`, {
                                children: t
                            }), (0, u.jsx)(`a`, {
                                href: t,
                                target: `_blank`,
                                rel: `noreferrer`,
                                children: `Öffnen`
                            }), (0, u.jsx)(`button`, {
                                type: `button`,
                                onClick: () => void $(t, `${e.catalogTitle} – öffentliche Kursseite`),
                                children: `Kopieren`
                            })]
                        }), (0, u.jsxs)(`div`, {
                            className: `public-course-address`,
                            children: [(0, u.jsx)(`span`, {
                                children: `Echter Kurszugang`
                            }), (0, u.jsx)(`code`, {
                                children: Y ? `${Y}/kurs/${e.slug}` : `/kurs/${e.slug}`
                            }), (0, u.jsx)(`a`, {
                                href: `/kurs/${e.slug}`,
                                target: `_blank`,
                                rel: `noreferrer`,
                                children: `Öffnen`
                            }), (0, u.jsx)(`button`, {
                                type: `button`,
                                onClick: () => void Q(`/kurs/${e.slug}`, `${e.catalogTitle} – echter Kurszugang`),
                                children: `Kopieren`
                            })]
                        })]
                    }, e.slug)
                })]
            }), (0, u.jsx)(`p`, {
                className: `admin-directory-intro`,
                children: `Hier sind sämtliche vorhandenen Oberflächen direkt erreichbar. Echte Mitarbeiter- und Kundenbereiche bleiben geschützt; dafür stehen dem Administrator gekennzeichnete Prüfansichten zur Verfügung.`
            }), (0, u.jsxs)(`div`, {
                className: `admin-overview-status`,
                children: [(0, u.jsxs)(`span`, {
                    children: [(0, u.jsx)(`b`, {
                        children: ie.length
                    }), ` extern erreichbare Portalseiten`]
                }), (0, u.jsxs)(`span`, {
                    children: [(0, u.jsx)(`b`, {
                        children: ae.length + o.length
                    }), ` interne Arbeits- und Prüfansichten`]
                })]
            }), (0, u.jsxs)(`div`, {
                className: `admin-communication-grid`,
                children: [(0, u.jsxs)(`section`, {
                    className: `admin-link-panel is-external`,
                    children: [(0, u.jsxs)(`header`, {
                        children: [(0, u.jsx)(`span`, {
                            children: `Extern veröffentlicht`
                        }), (0, u.jsx)(`strong`, {
                            children: `Kunden und Interessenten`
                        })]
                    }), (0, u.jsx)(`nav`, {
                        "aria-label": `Extern veröffentlichte Portalseiten`,
                        children: ie.map(e => (0, u.jsxs)(`a`, {
                            href: e.href,
                            target: `_blank`,
                            rel: `noreferrer`,
                            children: [(0, u.jsx)(`span`, {
                                children: e.label
                            }), (0, u.jsx)(`b`, {
                                children: `↗`
                            })]
                        }, e.href))
                    })]
                }), (0, u.jsxs)(`section`, {
                    className: `admin-link-panel is-internal`,
                    children: [(0, u.jsxs)(`header`, {
                        children: [(0, u.jsx)(`span`, {
                            children: `Arbeits- und Prüfansichten`
                        }), (0, u.jsx)(`strong`, {
                            children: `Verwaltung, Mitarbeiter und Testseiten`
                        })]
                    }), (0, u.jsx)(`nav`, {
                        "aria-label": `Interne Arbeits- und Prüfansichten`,
                        children: ae.map(e => (0, u.jsxs)(`a`, {
                            href: e.href,
                            target: `_blank`,
                            rel: `noreferrer`,
                            children: [(0, u.jsx)(`span`, {
                                children: e.label
                            }), (0, u.jsx)(`b`, {
                                children: `↗`
                            })]
                        }, e.href))
                    }), (0, u.jsxs)(`div`, {
                        className: `admin-compact-courses`,
                        children: [(0, u.jsx)(`strong`, {
                            children: `Geschützte Kundenkurse`
                        }), o.map(e => (0, u.jsxs)(`div`, {
                            children: [(0, u.jsx)(`span`, {
                                children: e.catalogTitle
                            }), (0, u.jsx)(`nav`, {
                                children: (0, u.jsx)(`a`, {
                                    href: `/kurs/${e.slug}`,
                                    target: `_blank`,
                                    rel: `noreferrer`,
                                    children: `Kundenkurs`
                                })
                            })]
                        }, e.slug))]
                    })]
                })]
            })]
        }), (0, u.jsxs)(`section`, {
            className: `admin-section admin-backend`,
            id: `sicherheit`,
            children: [(0, u.jsxs)(`header`, {
                children: [(0, u.jsxs)(`div`, {
                    children: [(0, u.jsx)(`span`, {
                        children: `06`
                    }), (0, u.jsx)(`p`, {
                        className: `eyebrow`,
                        children: `Arbeitsprozess`
                    })]
                }), (0, u.jsx)(`h2`, {
                    children: `Einfach und nachvollziehbar.`
                })]
            }), (0, u.jsxs)(`div`, {
                className: `backend-functions`,
                children: [(0, u.jsxs)(`article`, {
                    children: [(0, u.jsx)(`strong`, {
                        children: `Ein Gerät`
                    }), (0, u.jsx)(`span`, {
                        children: `Das erste erfolgreiche Login bindet das Kundenkonto an dieses Gerät.`
                    })]
                }), (0, u.jsxs)(`article`, {
                    children: [(0, u.jsx)(`strong`, {
                        children: `Kein Geräte-Reset`
                    }), (0, u.jsx)(`span`, {
                        children: `Bei Gerätewechsel das alte Kundenkonto vollständig löschen.`
                    })]
                }), (0, u.jsxs)(`article`, {
                    children: [(0, u.jsx)(`strong`, {
                        children: `Neu anlegen`
                    }), (0, u.jsx)(`span`, {
                        children: `Neues Konto, neue Zugangsdaten, Kurs und Laufzeit bewusst neu vergeben.`
                    })]
                }), (0, u.jsxs)(`article`, {
                    children: [(0, u.jsx)(`strong`, {
                        children: `Datensparsam`
                    }), (0, u.jsx)(`span`, {
                        children: `Vorname und Kunden-/Rechnungsnummer ermöglichen die pseudonymisierte Zuordnung. Abgelaufene Konten werden automatisch entfernt; Buchungsbelege bleiben nur nach gesetzlicher Frist erhalten.`
                    })]
                }), (0, u.jsxs)(`article`, {
                    children: [(0, u.jsx)(`strong`, {
                        children: `Passwort vergessen`
                    }), (0, u.jsx)(`span`, {
                        children: `Rechnungsnummer und Kurs ordnen die Anfrage zu. Neues Passwort erst nach Abgleich über die Buchhaltung übermitteln.`
                    })]
                }), (0, u.jsxs)(`article`, {
                    className: `integration-pending`,
                    children: [(0, u.jsx)(`strong`, {
                        children: `Papierkram-Rechnungen`
                    }), (0, u.jsx)(`span`, {
                        children: `Mitarbeiter müssen vor der ersten Anmeldung von Dennis als Benutzer bei Papierkram freigeschaltet werden. Bei technischen Login-, Passwort- oder Systemproblemen hilft ausschließlich der Papierkram-Support.`
                    }), (0, u.jsx)(`a`, {
                        href: p,
                        target: `_blank`,
                        rel: `noreferrer`,
                        children: `Papierkram öffnen ↗`
                    }), (0, u.jsx)(`a`, {
                        href: se,
                        target: `_blank`,
                        rel: `noreferrer`,
                        children: `Papierkram-Support ↗`
                    })]
                })]
            })]
        })]
    })
}

function h(e) {
    let t = x(c(Date.now()));
    return {
        courseSlug: e,
        startsOn: t,
        expiresOn: g(e, t),
        earlyStartConfirmed: !1
    }
}

function ce(e) {
    if (!e ? .courseSlug) return `Bitte zuerst einen Kurs auswählen.`;
    let t = _(e.startsOn),
        n = _(e.expiresOn);
    return !t || !n ? `Bitte Start- und Enddatum vollständig eintragen.` : n <= t ? `Das Enddatum muss nach dem Startdatum liegen.` : t < c(Date.now()) && !e.earlyStartConfirmed ? `Für einen Start vor Ablauf der 14 Tage zuerst die dokumentierte Kundenerklärung bestätigen.` : ``
}

function le(e) {
    if (!e.firstName.trim()) return `Bitte den Vornamen eintragen.`;
    if (!e.username.trim()) return `Bitte einen technischen Benutzernamen eintragen.`;
    if (!e.invoiceNumber.trim()) return `Bitte die Kunden- oder Rechnungsnummer eintragen.`;
    if (e.password && e.password.length < 10) return `Das eigene Passwort muss mindestens 10 Zeichen lang sein. Alternativ das Feld leer lassen.`;
    if (!e.courseSlug) return ``;
    let t = _(e.startsOn),
        n = _(e.expiresOn);
    return !t || !n ? `Bitte Start- und Enddatum vollständig eintragen.` : n <= t ? `Das Enddatum muss nach dem Startdatum liegen.` : t < c(Date.now()) && !e.earlyStartConfirmed ? `Für einen Start vor Ablauf der 14 Tage zuerst die dokumentierte Kundenerklärung bestätigen.` : ``
}

function g(e, t) {
    return !e || !t ? `` : x(te(e, _(t)))
}

function _(e) {
    if (!/^\d{4}-\d{2}-\d{2}$/.test(e)) return 0;
    let [t, n, r] = e.split(`-`).map(Number);
    return Date.UTC(t, n - 1, r, 12)
}

function v(e, t) {
    let n = _(e);
    return n ? x(n + t * 24 * 60 * 60 * 1e3) : ``
}

function ue(e) {
    let t = y(e);
    return t ? b(t.year, t.month, t.day) : 0
}

function de(e) {
    let t = y(e);
    return t ? b(t.year, t.month, t.day + 1) - 1 : 0
}

function y(e) {
    if (!/^\d{4}-\d{2}-\d{2}$/.test(e)) return null;
    let [t, n, r] = e.split(`-`).map(Number);
    return {
        year: t,
        month: n,
        day: r
    }
}

function b(e, t, n) {
    let r = Date.UTC(e, t - 1, n),
        i = new Intl.DateTimeFormat(`en-CA`, {
            timeZone: `Europe/Berlin`,
            year: `numeric`,
            month: `2-digit`,
            day: `2-digit`,
            hour: `2-digit`,
            minute: `2-digit`,
            second: `2-digit`,
            hourCycle: `h23`
        }).formatToParts(new Date(r)),
        a = e => Number(i.find(t => t.type === e) ? .value || 0);
    return r - (Date.UTC(a(`year`), a(`month`) - 1, a(`day`), a(`hour`), a(`minute`), a(`second`)) - r)
}

function x(e) {
    let t = new Date(e);
    return [t.getUTCFullYear(), String(t.getUTCMonth() + 1).padStart(2, `0`), String(t.getUTCDate()).padStart(2, `0`)].join(`-`)
}

function S() {
    let e = new Date;
    return Date.UTC(e.getUTCFullYear(), e.getUTCMonth(), e.getUTCDate(), 12)
}

function fe(e) {
    let t = Date.now();
    return e.active ? e.startsAt > t ? `Start vorgemerkt` : e.expiresAt <= t ? `Abgelaufen` : `Aktiv` : `Gesperrt`
}

function pe(e) {
    return new Intl.DateTimeFormat(`de-DE`).format(new Date(e))
}

function me(e) {
    return new Intl.DateTimeFormat(`de-DE`, {
        dateStyle: `short`,
        timeStyle: `short`
    }).format(new Date(e))
}
export {
    m as
    default
};