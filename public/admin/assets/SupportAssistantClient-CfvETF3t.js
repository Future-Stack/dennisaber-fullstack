import {
    r as e
} from "./rolldown-runtime-S-ySWqyJ.js";
import {
    i as t,
    r as n
} from "./framework-CXnKph_e.js";
import {
    c as r
} from "./index-BqyFDbzT.js";
import i from "./link-BszFck6q.js";
import {
    n as a
} from "./portalLinks-1EHtAtrv.js";
var o = e(t(), 1),
    s = `Aktuelles Kursportal, geprüft am 28.07.2026`,
    c = `Wissensbasis V2, Live-Portal-Abruf vom 28.07.2026`,
    l = a,
    u = [{
        id: `PO-01`,
        area: `Portal`,
        title: `Kurs bestellen`,
        question: `Wie bestelle ich einen Kurs?`,
        alternatives: [`kaufen`, `buchen`, `bestellen`, `Kurs erwerben`],
        answer: `Über dieses Kursportal kannst du keinen Kurs bestellen. Information, Beratung und verbindliche Buchung findest du im verlinkten Verkaufsportal. Dieses Portal stellt bereits freigeschalteten Kunden ihre Kurse bereit.`,
        href: l,
        linkLabel: `Zum Verkaufsportal`,
        source: c,
        verifiedOn: `2026-07-29`
    }, {
        id: `PO-02`,
        area: `Portal`,
        title: `Im Portal bezahlen`,
        question: `Kann ich hier bezahlen?`,
        alternatives: [`Zahlung auslösen`, `Bezahlvorgang`, `Kreditkarte eingeben`],
        answer: `Nein. Dieses Kursportal nimmt weder Bestellungen noch Zahlungen entgegen. Verwende für eine bestehende Zahlung ausschließlich die Angaben aus deiner persönlichen Rechnung. Informationen zu Bestellung und Zahlungsablauf findest du im Verkaufsportal.`,
        href: l,
        linkLabel: `Zum Verkaufsportal`,
        source: c,
        verifiedOn: `2026-07-29`
    }, {
        id: `PO-03`,
        area: `Portal`,
        title: `Kursberatung`,
        question: `Wo finde ich Beratung zu den Kursinhalten?`,
        alternatives: [`Beratung`, `welcher Kurs passt`, `Empfehlung`],
        answer: `Beratung, kostenfreie Einblicke und Leistungsbeschreibungen findest du im Verkaufsportal. Dieses Portal stellt nur bereits gebuchte Kurse technisch bereit.`,
        href: l,
        linkLabel: `Angebote vergleichen`,
        source: c,
        verifiedOn: `2026-07-29`
    }, {
        id: `KP-01`,
        area: `Kurse`,
        title: `Kurskosten`,
        question: `Was kostet ein Kurs?`,
        alternatives: [`Preis`, `Kosten`, `wie teuer`, `Preisliste`],
        answer: `Aktuelle Preise und Leistungsbeschreibungen findest du ausschließlich im Verkaufsportal. Das Kursportal zeigt bewusst keine Preise.`,
        href: l,
        linkLabel: `Preise im Verkaufsportal ansehen`,
        source: c,
        verifiedOn: `2026-07-29`
    }, {
        id: `KP-02`,
        area: `Kurse`,
        title: `Kursübersicht`,
        question: `Wie viele Kurse gibt es?`,
        alternatives: [`Kursangebot`, `Übersicht`, `welche Kurse`],
        answer: `Das aktuelle Kursangebot und alle öffentlichen Kursinformationen findest du ausschließlich im Verkaufsportal. Dieses technische Portal zeigt nur die Kursauswahl für bereits freigeschaltete Kunden.`,
        href: l,
        linkLabel: `Kursangebot ansehen`,
        source: c,
        verifiedOn: `2026-07-29`
    }, {
        id: `KP-03`,
        area: `Kurse`,
        title: `Zugangsdauer`,
        question: `Wie lange kann ich einen Kurs nutzen?`,
        alternatives: [`Laufzeit`, `Zugangsdauer`, `wie lange Zugriff`, `abgelaufen`],
        answer: `Reguläre Kurse laufen vier Monate ab der individuellen Freischaltung. Das Audio-Abenteuer Rio Negro 2002 ist die einzige Ausnahme und läuft 30 Tage.`,
        href: `/login`,
        linkLabel: `Zum Kundenlogin`,
        source: c,
        verifiedOn: `2026-07-29`
    }, {
        id: `KP-04`,
        area: `Kurse`,
        title: `Kein Abo`,
        question: `Ist das ein Abo?`,
        alternatives: [`Abo`, `automatische Verlängerung`, `kündigen`, `Abbuchung`],
        answer: `Nein. Es gilt eine einmalige Zahlung. Es gibt keine automatische Verlängerung und keine weitere Abbuchung. Der Zugang endet automatisch.`,
        source: c,
        verifiedOn: `2026-07-28`
    }, {
        id: `KP-05`,
        area: `Kurse`,
        title: `Zugang verlängern`,
        question: `Kann ich meinen abgelaufenen Kurs verlängern?`,
        alternatives: [`Kurs verlängern`, `Zugang verlängern`, `weitere 30 Tage`, `weitere vier Monate`, `noch einmal freischalten`, `Kurs abgelaufen`, `weiterlernen`],
        answer: `Nein. Nach Ablauf der letzten Freigabe wird das Kundenkonto automatisch aus dem Kursportal gelöscht und kann nicht reaktiviert werden. Für einen neuen Zugang muss der Kurs erneut gekauft werden. Nur bei Präventionskursen mit mehr als zehn Zugängen kann vorab eine individuelle Laufzeitregelung vereinbart werden.`,
        href: l,
        linkLabel: `Kurs erneut buchen`,
        source: `Verbindliche Laufzeitregelung vom 29.07.2026`,
        verifiedOn: `2026-07-29`
    }, {
        id: `KP-06`,
        area: `Kurse`,
        title: `Keine Zeitgutschrift`,
        question: `Ich habe den Kurs längere Zeit nicht genutzt. Bekomme ich die Zeit gutgeschrieben?`,
        alternatives: [`Pause`, `krank gewesen`, `Urlaub`, `nicht genutzt`, `keine Zeit gehabt`, `Zeit gutschreiben`, `Kurs pausieren`],
        answer: `Nein. Die Zugangszeit läuft ab der individuellen Freischaltung. Eine nachträgliche Gutschrift, Kulanzverlängerung oder Reaktivierung ist nicht vorgesehen. Nach Ablauf kann der Kurs erneut gebucht werden.`,
        href: l,
        linkLabel: `Kurs erneut buchen`,
        source: `Verbindliche Laufzeitregelung vom 29.07.2026`,
        verifiedOn: `2026-07-29`
    }, {
        id: `ZA-01`,
        area: `Zahlung`,
        title: `Zahlungsablauf`,
        question: `Wie läuft die Zahlung ab?`,
        alternatives: [`Überweisung`, `wie bezahle ich`, `Ablauf Zahlung`],
        answer: `Nach der Bestellung auf besseler.de erhältst du deine persönlichen Zahlungsunterlagen. Verwende GiroCode oder Bankdaten ausschließlich aus deiner persönlichen Rechnung und übernimm den Verwendungszweck unverändert.`,
        source: c,
        verifiedOn: `2026-07-29`
    }, {
        id: `ZA-02`,
        area: `Zahlung`,
        title: `IBAN und GiroCode`,
        question: `Wo finde ich die IBAN?`,
        alternatives: [`Bankdaten`, `Kontonummer`, `GiroCode`, `Empfänger`],
        answer: `Die Bankverbindung wird im Kursportal nicht öffentlich ausgegeben. Verwende ausschließlich die Angaben auf deiner persönlichen Rechnung. Bei einer unlesbaren oder fehlenden Angabe wende dich an den persönlichen Support.`,
        support: !0,
        source: c,
        verifiedOn: `2026-07-29`
    }, {
        id: `ZA-03`,
        area: `Zahlung`,
        title: `Zahlungsprüfung`,
        question: `Wann wird meine Zahlung geprüft?`,
        alternatives: [`Zahlungseingang`, `wann kommt die Freischaltung`, `Bearbeitungszeit`, `wann werde ich freigeschaltet`, `Zahlung noch nicht sichtbar`],
        answer: `Die Zahlungsprüfung erfolgt werktags einmal zwischen 13 und 16 Uhr. Deine persönliche Freischaltung wird anschließend per E-Mail mitgeteilt. Später eingehende Zahlungen werden bei der nächsten werktäglichen Prüfung berücksichtigt.`,
        additionalAnswer: `Bitte warte bis zum Ende der nächsten werktäglichen Prüfung. Erst wenn danach keine Freischaltungs-E-Mail vorliegt, ist eine Nachricht an den technischen Support sinnvoll.`,
        support: !0,
        source: c,
        verifiedOn: `2026-07-29`
    }, {
        id: `ZA-04`,
        area: `Zahlung`,
        title: `Zahlungsstatus`,
        question: `Ist mein Geld angekommen?`,
        alternatives: [`Zahlungsstatus`, `habt ihr mein Geld`, `Zahlungseingang prüfen`],
        answer: `Diese Hilfe kann Zahlungseingänge weder einsehen noch bestätigen. Den konkreten Bearbeitungsstand klärt der persönliche Support.`,
        support: !0,
        source: c,
        verifiedOn: `2026-07-28`
    }, {
        id: `ZA-05`,
        area: `Zahlung`,
        title: `Rechnungsfrage`,
        question: `Ich habe eine Frage zu meiner Rechnung.`,
        alternatives: [`Rechnung falsch`, `Rechnungsnummer`, `Beleg`, `Storno`],
        answer: `Fragen zu einer konkreten Rechnung werden persönlich geklärt. Diese Hilfe kann keine Rechnung und keinen Bestellstand einsehen.`,
        support: !0,
        source: c,
        verifiedOn: `2026-07-28`
    }, {
        id: `ZA-06`,
        area: `Zahlung`,
        title: `Zahlungsarten`,
        question: `Welche Zahlungsarten gibt es?`,
        alternatives: [`PayPal`, `Kreditkarte`, `Lastschrift`, `Sofortüberweisung`, `Echtzeitüberweisung`],
        answer: `Die Zahlung erfolgt per Banküberweisung auf Grundlage deiner persönlichen Rechnung. PayPal, Kreditkarte und Lastschrift werden nicht angeboten. Auch bei einer Echtzeitüberweisung erfolgt die Freischaltung erst nach der persönlichen Zahlungsprüfung.`,
        source: c,
        verifiedOn: `2026-07-29`
    }, {
        id: `ZA-07`,
        area: `Zahlung`,
        title: `GiroCode verwenden`,
        question: `Wie benutze ich den GiroCode?`,
        alternatives: [`QR Code scannen`, `QR-Code scannen`, `Banking QR`, `Überweisung QR`, `GiroCode kaputt`, `GiroCode unlesbar`, `QR Code nachbauen`, `Fotoüberweisung`],
        answer: `Öffne in deiner Banking-App die Funktion für Fotoüberweisung oder GiroCode und scanne den Code aus deiner persönlichen Rechnung. Ist der Code unlesbar, kannst du mit dem verlinkten Werkzeug aus den Angaben deiner Rechnung lokal einen neuen GiroCode erzeugen. Vergleiche Kontoinhaber, IBAN, Betrag und Verwendungszweck vollständig und bestätige erst danach selbst mit TAN.`,
        additionalAnswer: `Sende keine TAN, PIN, vollständigen Bankdaten oder Bilder deiner Rechnung über das Hilfe-Feld. Die Zahlung wird ausschließlich in deiner Banking-App bestätigt.`,
        href: `/zahlungsbedingungen#girocode`,
        linkLabel: `GiroCode lokal erstellen`,
        source: c,
        verifiedOn: `2026-07-29`
    }, {
        id: `ZA-08`,
        area: `Zahlung`,
        title: `Nach 16 Uhr überwiesen`,
        question: `Ich habe nach 16 Uhr überwiesen. Wann werde ich freigeschaltet?`,
        alternatives: [`abends überwiesen`, `nach Prüfung überwiesen`, `morgen Freischaltung`, `Wochenende`, `Feiertag`, `Echtzeitüberweisung nach 16 Uhr`, `Zahlung spät`, `noch nicht freigeschaltet`],
        answer: `Zahlungen werden werktags einmal zwischen 13 und 16 Uhr geprüft. Ist der Zahlungseingang bei dieser Prüfung noch nicht sichtbar, wird er bei der nächsten werktäglichen Prüfung berücksichtigt. Der Bot kann den konkreten Eingang nicht einsehen.`,
        additionalAnswer: `Überweisungen am Wochenende oder an einem Feiertag werden frühestens bei der nächsten werktäglichen Prüfung berücksichtigt. Das gilt auch für Echtzeitüberweisungen. Bitte kontaktiere den technischen Support erst, wenn bis zum Ende dieser nächsten Prüfung keine Freischaltungs-E-Mail vorliegt.`,
        support: !0,
        source: c,
        verifiedOn: `2026-07-29`
    }, {
        id: `ZA-09`,
        area: `Zahlung`,
        title: `Überweisung gemeldet`,
        question: `Reicht es, wenn ich melde, dass ich überwiesen habe?`,
        alternatives: [`ich habe überwiesen`, `Zahlung melden`, `Überweisungsbestätigung`, `automatisch freischalten`],
        answer: `Nein. Eine Nachricht oder der Button „Ich habe überwiesen“ ersetzt den tatsächlichen Zahlungseingang nicht und führt nicht automatisch zur Freischaltung. Maßgeblich ist die persönliche Prüfung des eindeutig zugeordneten Zahlungseingangs.`,
        source: c,
        verifiedOn: `2026-07-29`
    }, {
        id: `ZA-10`,
        area: `Freischaltung`,
        title: `Vor Ablauf der Widerrufsfrist starten`,
        question: `Wie kann ich meinen Kurs vor Ablauf der 14 Tage starten?`,
        alternatives: [`früher starten`, `sofort freischalten`, `vorzeitiger Beginn`, `Widerrufsverzicht`, `Widerrufsrecht beenden`, `schnell Zugang bekommen`],
        answer: `Du widerrufst damit nicht. Wenn du einen bereits bestellten digitalen Kurs vor Ablauf der Widerrufsfrist nutzen möchtest, öffne im Verkaufsportal den Service für bestehende Vorgänge, bestätige dort ausdrücklich den vorzeitigen Beginn und sende die vorbereitete E-Mail tatsächlich ab. Die Freischaltung setzt außerdem den Vertragsschluss und den vollständigen Zahlungseingang voraus.`,
        href: `${l}service/rio-negro/`,
        linkLabel: `Erklärung zum früheren Start öffnen`,
        source: `Verkaufsportal und Zahlungsbedingungen vom 29.07.2026`,
        verifiedOn: `2026-07-29`
    }, {
        id: `DS-01`,
        area: `Datenschutz`,
        title: `Datenschutzerklärung`,
        question: `Wo finde ich die Datenschutzerklärung?`,
        alternatives: [`Datenschutz`, `DSGVO`, `Datenschutzhinweise`],
        answer: `Die Datenschutzerklärung ist im Fußbereich jeder Portalseite unter „Datenschutz“ verlinkt.`,
        href: `/datenschutz`,
        linkLabel: `Datenschutzerklärung öffnen`,
        source: c,
        verifiedOn: `2026-07-28`
    }, {
        id: `DS-02`,
        area: `Datenschutz`,
        title: `Gespeicherte Daten`,
        question: `Welche Daten speichert das Portal über mich?`,
        alternatives: [`meine Daten`, `Datenspeicherung`, `was wird gespeichert`],
        answer: `Für einen freigeschalteten Kurszugang werden Benutzername, das technisch gesicherte Passwort, gebuchter Kurs, Freischaltungs- und Enddatum, Rechnungsnummer sowie die Gerätezuordnung verarbeitet. Einzelheiten findest du in der Datenschutzerklärung.`,
        href: `/datenschutz`,
        linkLabel: `Datenschutzerklärung öffnen`,
        source: c,
        verifiedOn: `2026-07-28`
    }, {
        id: `DS-03`,
        area: `Datenschutz`,
        title: `Keine Zahlungsdaten`,
        question: `Nimmt das Portal Bestellungen oder Zahlungsdaten entgegen?`,
        alternatives: [`Zahlungsdaten`, `Anschrift`, `Bestelldaten`],
        answer: `Nein. Das Kursportal nimmt keine Bestellungen oder Zahlungen entgegen und enthält keine Eingabemaske für Bankdaten oder GiroCodes. Zahlungsangaben werden ausschließlich über die persönliche Rechnung und die getrennte Bestellabwicklung bereitgestellt.`,
        source: c,
        verifiedOn: `2026-07-28`
    }, {
        id: `DS-04`,
        area: `Datenschutz`,
        title: `Auskunft oder Löschung`,
        question: `Ich möchte Auskunft oder Löschung meiner Daten.`,
        alternatives: [`Löschung`, `Auskunft`, `Betroffenenrechte`, `Widerspruch`],
        answer: `Anliegen zu Auskunft, Berichtigung, Löschung, Einschränkung, Datenübertragbarkeit oder Widerspruch werden ausschließlich persönlich bearbeitet.`,
        href: `/datenschutz`,
        linkLabel: `Datenschutzerklärung öffnen`,
        support: !0,
        source: c,
        verifiedOn: `2026-07-28`
    }, {
        id: `DS-05`,
        area: `Datenschutz`,
        title: `Datenminimierung`,
        question: `Werden meine Daten anonym gespeichert?`,
        alternatives: [`anonym`, `pseudonym`, `maximale Anonymität`, `wenige Daten`, `Datensparsamkeit`],
        answer: `Die Verarbeitung ist nicht vollständig anonym. Das Portal arbeitet datensparsam und ordnet den Zugang soweit möglich über Vorname sowie Kunden- beziehungsweise Rechnungsnummer zu. Eine E-Mail-Adresse wird im Kundenkonto nicht gespeichert.`,
        href: `/datenschutz`,
        linkLabel: `Datenschutz im Detail`,
        source: `Datenschutzkonzept vom 29.07.2026`,
        verifiedOn: `2026-07-29`
    }, {
        id: `DS-06`,
        area: `Datenschutz`,
        title: `Automatische Kontolöschung`,
        question: `Was passiert mit meinem Konto nach Kursende?`,
        alternatives: [`Konto löschen`, `nach Ablauf`, `Kursende`, `Daten nach vier Monaten`, `Daten nach 30 Tagen`, `automatisch gelöscht`],
        answer: `Nach Ablauf der letzten Kursfreigabe wird das Portalkonto automatisch entfernt. Zugangsdaten, Gerätebindung, Sitzungen, Kurszuordnungen und offene Zugangsanfragen werden gelöscht. Deshalb kann das Konto später nicht verlängert oder reaktiviert werden.`,
        href: `/datenschutz`,
        linkLabel: `Löschkonzept ansehen`,
        source: `Datenschutzkonzept vom 29.07.2026`,
        verifiedOn: `2026-07-29`
    }, {
        id: `DS-07`,
        area: `Datenschutz`,
        title: `Rechnungen bleiben getrennt`,
        question: `Warum bleibt meine Rechnung gespeichert?`,
        alternatives: [`Rechnung löschen`, `Buchhaltung`, `Aufbewahrungsfrist`, `Steuerrecht`, `Buchungsbeleg`],
        answer: `Das Kurskonto und die Buchhaltung sind getrennt. Das Portalkonto wird nach Ablauf gelöscht. Rechnungen und steuerlich erforderliche Buchungsbelege müssen dagegen für die gesetzlich vorgeschriebene Dauer in der Buchhaltung aufbewahrt werden. Dadurch wird der Kurszugang nicht verlängert.`,
        href: `/datenschutz`,
        linkLabel: `Datenschutz im Detail`,
        source: `Datenschutzkonzept vom 29.07.2026`,
        verifiedOn: `2026-07-29`
    }, {
        id: `DS-08`,
        area: `Datenschutz`,
        title: `Daten im Kopierschutz`,
        question: `Welche Daten zeigt der Kopierschutz?`,
        alternatives: [`Wasserzeichen`, `Privatlizenz`, `Copy Hinweis`, `Kundennummer sichtbar`, `Rechnungsnummer sichtbar`],
        answer: `Geschützte Inhalte können mit Vorname und Kunden- beziehungsweise Rechnungsnummer als persönliche Privatlizenz gekennzeichnet werden. Anschrift, E-Mail-Adresse und Zahlungsdaten werden nicht angezeigt.`,
        href: `/kopierschutz`,
        linkLabel: `Kopierschutz ansehen`,
        source: `Datenschutzkonzept vom 29.07.2026`,
        verifiedOn: `2026-07-29`
    }, {
        id: `DS-09`,
        area: `Datenschutz`,
        title: `Lokale Portalhilfe`,
        question: `Werden meine Fragen an eine KI übertragen?`,
        alternatives: [`externe KI`, `Suchanfrage gespeichert`, `Bot Datenschutz`, `Fragen übertragen`, `Chatbot Daten`],
        answer: `Nein. Die Portalhilfe durchsucht ausschließlich fest hinterlegte Antworten in deinem Browser. Deine Suchanfrage wird nicht gespeichert, nicht an den Server gesendet und nicht an einen externen KI-Dienst übertragen.`,
        href: `/datenschutz`,
        linkLabel: `Datenschutzhinweise öffnen`,
        source: s,
        verifiedOn: `2026-07-29`
    }, {
        id: `GB-01`,
        area: `Gerät`,
        title: `Neues Gerät`,
        question: `Ich brauche ein neues Gerät für meinen Zugang.`,
        alternatives: [`Gerätewechsel`, `neues Handy`, `neuer Laptop`, `anderes Gerät`, `Gerät zurücksetzen`],
        answer: `Der Zugang ist an das beim ersten erfolgreichen Login verwendete Browserprofil gebunden. Wenn ein Gerätewechsel notwendig ist, wende dich an den persönlichen Support. Die Hilfe selbst kann keine Gerätebindung verändern.`,
        support: !0,
        source: c,
        verifiedOn: `2026-07-28`
    }, {
        id: `GB-02`,
        area: `Gerät`,
        title: `Kein Gerätereset`,
        question: `Kann die Hilfe mein Gerät zurücksetzen?`,
        alternatives: [`setz mein Gerät zurück`, `entsperre mich`, `Gerätebindung lösen`, `Gerätereset`],
        answer: `Nein. Diese Hilfe kann keine Geräte zurücksetzen und keine Zugänge verändern. Bitte wende dich an den persönlichen Support.`,
        support: !0,
        source: c,
        verifiedOn: `2026-07-28`
    }, {
        id: `GB-03`,
        area: `Gerät`,
        title: `Browserprofil und Browserdaten`,
        question: `Warum wird mein bisheriges Gerät plötzlich als neues Gerät erkannt?`,
        alternatives: [`Browserdaten gelöscht`, `Cookies gelöscht`, `Cache gelöscht`, `gleiches Gerät gesperrt`, `anderer Browser`, `Inkognito`, `neues Browserprofil`],
        answer: `Wichtig: Die Gerätebindung bezieht sich technisch auf das jeweilige Browserprofil. Werden Browserdaten gelöscht, wird dasselbe Gerät als neues Gerät erkannt und der Zugang gesperrt. Das gilt auch bei einem anderen Browser, einem neuen Browserprofil oder einem privaten beziehungsweise Inkognito-Fenster. Verwende deshalb für den Kurs immer dasselbe Browserprofil und lösche während der Zugangslaufzeit keine Browserdaten.`,
        support: !0,
        source: `Verbindlicher Hinweis zur Gerätebindung vom 29.07.2026`,
        verifiedOn: `2026-07-29`
    }, {
        id: `LO-01`,
        area: `Anmeldung`,
        title: `Anmelden`,
        question: `Wie melde ich mich an?`,
        alternatives: [`Login`, `einloggen`, `anmelden`, `Zugang öffnen`],
        answer: `Bereits freigeschaltete Kunden gelangen mit Benutzername und Passwort direkt in ihren gebuchten Kurs.`,
        href: `/login`,
        linkLabel: `Zum Kundenlogin`,
        source: c,
        verifiedOn: `2026-07-28`
    }, {
        id: `LO-02`,
        area: `Anmeldung`,
        title: `Passwort vergessen`,
        question: `Ich habe mein Passwort vergessen.`,
        alternatives: [`Passwort zurücksetzen`, `Zugangsdaten vergessen`, `Benutzername vergessen`, `neues Passwort`],
        answer: `Nutze die sichere Zugangsanfrage mit deiner Rechnungs- oder Kundennummer und dem gebuchten Kurs. Das Portal bestätigt nicht, ob ein Konto existiert. Neue Zugangsdaten werden erst nach dem internen Abgleich übermittelt; es wird kein automatischer Rücksetzlink versendet.`,
        href: `/passwort-vergessen`,
        linkLabel: `Zugangsdaten anfordern`,
        source: s,
        verifiedOn: `2026-07-28`
    }, {
        id: `LO-03`,
        area: `Anmeldung`,
        title: `Anmeldung abgewiesen`,
        question: `Meine Anmeldung wird abgewiesen.`,
        alternatives: [`Login funktioniert nicht`, `kann mich nicht anmelden`, `Anmeldefehler`, `Zugang gesperrt`],
        answer: `Prüfe Benutzername und Passwort sorgfältig. Nutze bei vergessenen Zugangsdaten die sichere Zugangsanfrage. Wenn du ein neues Gerät verwendest oder der Zugang weiterhin abgewiesen wird, wende dich an den persönlichen Support.`,
        href: `/passwort-vergessen`,
        linkLabel: `Zugangsdaten anfordern`,
        support: !0,
        source: s,
        verifiedOn: `2026-07-28`
    }, {
        id: `LO-04`,
        area: `Anmeldung`,
        title: `Registrierung`,
        question: `Kann ich mich selbst registrieren?`,
        alternatives: [`Registrierung`, `Konto anlegen`, `Neukunde`],
        answer: `Nein. Das Kundenkonto wird nach der Buchung und dem eindeutig zugeordneten Zahlungseingang freigeschaltet.`,
        href: l,
        linkLabel: `Zum Verkaufsportal`,
        source: c,
        verifiedOn: `2026-07-29`
    }, {
        id: `KN-01`,
        area: `Kursnutzung`,
        title: `Gebuchten Kurs finden`,
        question: `Wo finde ich meinen gebuchten Kurs?`,
        alternatives: [`meine Kurse`, `Kursbereich`, `wo ist mein Kurs`],
        answer: `Nach der Anmeldung gelangst du in den geschützten Kursbereich deines gebuchten Kurses.`,
        href: `/login`,
        linkLabel: `Zum Kundenlogin`,
        source: c,
        verifiedOn: `2026-07-28`
    }, {
        id: `KN-02`,
        area: `Kursnutzung`,
        title: `Fortschritt speichern`,
        question: `Wird mein Bearbeitungsstand gespeichert?`,
        alternatives: [`Fortschritt`, `Antworten speichern`, `Bearbeitungsstand`],
        answer: `Ja. Deine Eingaben und dein Bearbeitungsstand werden im geschützten Kursbereich auf dem verwendeten Gerät gespeichert. Verwende möglichst dasselbe Browserprofil und lösche während der Bearbeitung keine Browserdaten.`,
        source: s,
        verifiedOn: `2026-07-28`
    }, {
        id: `KN-03`,
        area: `Kursnutzung`,
        title: `Audio startet nicht`,
        question: `Ein Audio startet nicht.`,
        alternatives: [`Audio funktioniert nicht`, `MP3 startet nicht`, `kein Ton`, `Player kaputt`],
        answer: `Lade die Kursseite neu, prüfe Browser- und Gerätelautstärke und öffne den Kurs nur in einem Browserfenster. Bleibt der Fehler bestehen, nenne dem Support Kurs, Einheit und Browser – niemals dein Passwort.`,
        support: !0,
        source: s,
        verifiedOn: `2026-07-28`
    }, {
        id: `KN-04`,
        area: `Kursnutzung`,
        title: `Inhalte herunterladen`,
        question: `Kann ich Inhalte herunterladen?`,
        alternatives: [`Download`, `Audio speichern`, `PDF herunterladen`, `MP3 downloaden`],
        answer: `Audios und geschützte Arbeitsbuchseiten sind für die Nutzung im persönlichen Kursbereich vorgesehen. Ein separater Download wird dort nicht angeboten.`,
        source: s,
        verifiedOn: `2026-07-28`
    }, {
        id: `KN-05`,
        area: `Kursnutzung`,
        title: `Zugang weitergeben`,
        question: `Darf ich meinen Zugang weitergeben?`,
        alternatives: [`Zugang teilen`, `zu zweit nutzen`, `Kollege mitnutzen`],
        answer: `Nein. Der Kurszugang ist persönlich. Die Inhalte sind lizenziert und vor unberechtigter Weitergabe geschützt.`,
        support: !0,
        source: c,
        verifiedOn: `2026-07-28`
    }, {
        id: `KN-07`,
        area: `Kursnutzung`,
        title: `200 € Hinweisprämie`,
        question: `Was bedeutet die 200-Euro-Hinweisprämie?`,
        alternatives: [`illegale Nutzung melden`, `Urheberrechtsverletzung melden`, `Nutzungsrechte verletzt`, `Kurs weitergegeben`, `Belohnung`, `Prämie`, `200 Euro`],
        answer: `Für den ersten konkreten und nachprüfbaren Hinweis auf eine mir zuvor unbekannte unberechtigte Nutzung, wenn dieser wesentlich zu einer rechtskräftigen strafrechtlichen Verurteilung oder rechtskräftigen zivilgerichtlichen Feststellung gegen den Rechtsverletzer führt.

Danke, dass du meine Arbeit schützt. Bitte nur rechtmäßig erlangte Informationen übermitteln. Tatbeteiligte sind von der Prämie ausgeschlossen.`,
        additionalAnswer: `Für eine Strafanzeige oder einen polizeilichen Hinweis bitte ausschließlich das offizielle Portal der Polizeien der Bundesländer nutzen. Nicht für Notfälle – in dringenden Fällen 110 wählen.`,
        href: `mailto:dennis@besseler.de?subject=Hinweis%20auf%20unberechtigte%20Kursnutzung`,
        linkLabel: `Rechtsverletzung an Dennis melden`,
        secondaryHref: `https://portal.onlinewache.polizei.de/de/`,
        secondaryLinkLabel: `Offizielle Onlinewache der Polizei`,
        source: `Auslobung und Nutzungsregel vom 29.07.2026`,
        verifiedOn: `2026-07-29`
    }, {
        id: `KN-06`,
        area: `Kursnutzung`,
        title: `Fortschritt nach erneutem Kauf`,
        question: `Bleiben meine Eintragungen erhalten, wenn ich den Kurs erneut kaufe?`,
        alternatives: [`Fortschritt nach Neukauf`, `Eintragungen bleiben`, `Arbeitsbuch bleibt`, `von vorne anfangen`, `Daten nach Ablauf`, `Notizen wiederherstellen`],
        answer: `Eintragungen und Bearbeitungsstand werden nur lokal im verwendeten Browser gespeichert. Sie können dort erhalten bleiben, solange die Browserdaten nicht gelöscht werden; das wird aber nicht garantiert. Das Portal kann diese Daten nicht wiederherstellen oder auf ein anderes Gerät übertragen. Sichere wichtige Eintragungen deshalb vor Ablauf selbst.`,
        href: `/datenschutz`,
        linkLabel: `Hinweise zur lokalen Speicherung`,
        source: s,
        verifiedOn: `2026-07-29`
    }, {
        id: `GR-01`,
        area: `Grenzen`,
        title: `Über diese Hilfe`,
        question: `Bist du Dennis Besseler?`,
        alternatives: [`bist du ein Mensch`, `wer bist du`, `rede ich mit Dennis`, `bist du eine KI`],
        answer: `Nein. Dies ist eine lokale Portalhilfe mit fest hinterlegten Antworten. Sie ist weder Dennis Besseler noch ein Mensch und nutzt keinen externen KI-Dienst.`,
        support: !0,
        source: s,
        verifiedOn: `2026-07-28`
    }, {
        id: `GR-02`,
        area: `Grenzen`,
        title: `Zugang verändern`,
        question: `Kannst du meinen Zugang freischalten oder verlängern?`,
        alternatives: [`schalte mich frei`, `verlängere`, `entsperre mein Konto`],
        answer: `Diese Hilfe kann keine Konten einsehen oder verändern. Eine Verlängerung ist auch durch den Support nicht möglich: Nach Ablauf wird das Portalkonto automatisch gelöscht. Für einen neuen Zugang muss der Kurs erneut gekauft werden.`,
        href: l,
        linkLabel: `Kurs erneut buchen`,
        source: `Verbindliche Laufzeitregelung vom 29.07.2026`,
        verifiedOn: `2026-07-29`
    }, {
        id: `GR-04`,
        area: `Grenzen`,
        title: `Gesundheitliche Frage`,
        question: `Ich habe eine gesundheitliche Frage.`,
        alternatives: [`Beschwerden`, `Diagnose`, `Medikament`, `Therapie`, `hilft der Kurs`],
        answer: `Zu gesundheitlichen Fragen kann diese Portalhilfe nicht beraten. Bitte wende dich an eine ärztliche oder therapeutische Fachperson.`,
        source: c,
        verifiedOn: `2026-07-28`
    }, {
        id: `GR-05`,
        area: `Grenzen`,
        title: `Recht oder Steuern`,
        question: `Ich habe eine steuerliche oder rechtliche Frage.`,
        alternatives: [`absetzen`, `Betriebsausgabe`, `Widerruf`, `Vertrag`, `Anwalt`, `Steuer`],
        answer: `Zu rechtlichen, steuerlichen oder finanziellen Fragen im Einzelfall kann diese Portalhilfe nicht beraten.`,
        support: !0,
        source: c,
        verifiedOn: `2026-07-28`
    }, {
        id: `GR-07`,
        area: `Grenzen`,
        title: `Beschwerde`,
        question: `Ich möchte mich beschweren.`,
        alternatives: [`Beschwerde`, `Ärger`, `Anwalt`, `schlechter Service`],
        answer: `Das nehme ich ernst. Beschwerden bearbeitet ausschließlich der persönliche Support.`,
        support: !0,
        source: c,
        verifiedOn: `2026-07-28`
    }, {
        id: `GR-08`,
        area: `Grenzen`,
        title: `Mit einem Menschen sprechen`,
        question: `Ich möchte mit einem Menschen sprechen.`,
        alternatives: [`Mensch`, `Support`, `E-Mail`, `echter Mitarbeiter`],
        answer: `Über „Persönlichen Support kontaktieren“ erreichst du direkt den persönlichen Support.`,
        support: !0,
        source: c,
        verifiedOn: `2026-07-28`
    }],
    d = n();

function f(e) {
    return e.toLocaleLowerCase(`de-DE`).normalize(`NFD`).replace(/[\u0300-\u036f]/g, ``).replace(/ß/g, `ss`).replace(/[^a-z0-9]+/g, ` `).trim()
}

function p(e, t) {
    let n = Array.from({
        length: t.length + 1
    }, (e, t) => t);
    for (let r = 1; r <= e.length; r += 1) {
        let i = n[0];
        n[0] = r;
        for (let a = 1; a <= t.length; a += 1) {
            let o = n[a];
            n[a] = Math.min(n[a] + 1, n[a - 1] + 1, i + (e[r - 1] === t[a - 1] ? 0 : 1)), i = o
        }
    }
    return n[t.length]
}

function m(e, t) {
    if (t.includes(e) || e.includes(t)) return !0;
    if (e.length < 5 || t.length < 5) return !1;
    let n = Math.max(e.length, t.length) >= 9 ? 2 : 1;
    return p(e, t) <= n
}

function h({
    supportEmail: e,
    personalEmail: t
}) {
    let n = r(),
        [a, s] = (0, o.useState)(!1),
        [c, l] = (0, o.useState)(``),
        [p, h] = (0, o.useState)(null),
        g = (0, o.useRef)(null),
        _ = (0, o.useRef)(null),
        v = (0, o.useMemo)(() => n.startsWith(`/verwaltung`) ? [`KN-01`, `KN-02`, `KN-03`, `LO-01`, `GB-01`] : n.startsWith(`/service/`) ? [`ZA-07`, `ZA-08`, `ZA-03`, `ZA-02`, `ZA-04`] : n.startsWith(`/login`) || n.startsWith(`/kurse/`) ? [`LO-02`, `LO-01`, `GB-01`, `LO-03`, `KN-01`] : n.startsWith(`/kurs/`) ? [`KN-03`, `KN-02`, `KN-04`, `KN-05`, `KN-07`] : n.startsWith(`/zahlung`) ? [`ZA-07`, `ZA-08`, `ZA-03`, `ZA-02`, `ZA-04`] : n.startsWith(`/datenschutz`) ? [`DS-06`, `DS-07`, `DS-05`, `DS-08`, `DS-04`] : [`LO-01`, `KN-01`, `KP-03`, `KP-04`, `PO-01`], [n]),
        y = (0, o.useMemo)(() => {
            let e = e => {
                let t = v.indexOf(e);
                return t === -1 ? 99 : t
            };
            return [...u].sort((t, n) => e(t.id) - e(n.id))
        }, [v]),
        b = (0, o.useMemo)(() => {
            let e = f(c);
            if (e.length < 2) return [];
            let t = e.split(` `).filter(e => e.length > 1);
            return y.map(n => {
                let r = f([n.title, n.question, n.area, n.alternatives.join(` `), n.answer].join(` `)),
                    i = r.split(` `).filter(e => e.length > 1),
                    a = r.includes(e) ? 6 : 0;
                return {
                    entry: n,
                    score: t.reduce((e, t) => e + +!!i.some(e => m(t, e)), a)
                }
            }).sort((e, t) => t.score - e.score).slice(0, 3)
        }, [y, c]),
        x = f(c),
        S = /\b(nach 16|abends uberwiesen|wochenende|feiertag|echtzeituberweisung nach 16|zahlung spat)\b/.test(x) ? `ZA-08` : /\b(girocode|fotouberweisung|banking qr|qr code|qr-code)\b/.test(x) ? `ZA-07` : /\b(wann.*freigeschaltet|zahlungsprufung|zahlungseingang.*pruf)\b/.test(x) ? `ZA-03` : /\b(verlanger|verlaenger|reaktivier|weitere 30 tage|weitere vier monate|kurs abgelaufen)\b/.test(x) ? `KP-05` : void 0,
        C = S ? u.find(e => e.id === S) : void 0,
        w = C ? [{
            entry: C,
            score: 12
        }] : b,
        T = x.split(` `).some(e => e === `mensch` || e === `support` || e === `email` || e === `mail`),
        E = !!p ? .personalContactEnabled && (/\bdennis\b/.test(x) || /\bpersonlich\w*\b/.test(x) || /\bkursfrage\w*\b/.test(x)),
        D = /\bDE\d{20}\b/i.test(c.replace(/\s/g, ``)) || /\b(?:passwort|pin|kartennummer|kreditkarte)\s*[:=]\s*\S+/i.test(c) || /\b\d{12,19}\b/.test(c.replace(/\s/g, ``)),
        O = (0, o.useMemo)(() => {
            let t = [`Bitte beschreibe dein Anliegen. Sende keine Passwörter oder Zahlungsdaten:`, ``, ``, `---`, `Geöffnete Portalseite: ${n}`].join(`\r
`);
            return `mailto:${e}?subject=Supportanfrage%20Kursportal&body=${encodeURIComponent(t)}`
        }, [n, e]),
        k = (0, o.useMemo)(() => {
            if (!p ? .personalContactEnabled) return ``;
            let e = c.trim(),
                r = `Persönliche Kursfrage · ${p.courseTitle}`,
                i = [`Hallo Dennis,`, ``, e || `Hier meine besondere Frage zum Kurs:`, ``, `Kursangaben`, `Teilnehmer: ${p.customerFirstName||`nicht hinterlegt`}`, `Kunden-/Rechnungsnummer: ${p.customerNumber}`, `Kurs: ${p.courseTitle}`, `Portalseite: ${n}`, ``, `Mit freundlichen Grüßen`, p.customerFirstName || `Kursteilnehmer/in`].join(`\r
`);
            return `mailto:${t}?subject=${encodeURIComponent(r)}&body=${encodeURIComponent(i)}`
        }, [p, n, t, c]);
    (0, o.useEffect)(() => {
        a && window.setTimeout(() => g.current ? .focus(), 0)
    }, [a]), (0, o.useEffect)(() => {
        let e = window.requestAnimationFrame(() => {
            let e = document.querySelector(`[data-support-course='true']`);
            h(e ? {
                courseTitle: e.dataset.courseTitle || `Kurs`,
                customerFirstName: e.dataset.customerFirstName || ``,
                customerNumber: e.dataset.customerNumber || ``,
                personalContactEnabled: e.dataset.personalContactEnabled === `true`
            } : null)
        });
        return () => window.cancelAnimationFrame(e)
    }, [n]), (0, o.useEffect)(() => {
        function e(e) {
            e.key !== `Escape` || !a || (s(!1), window.setTimeout(() => _.current ? .focus(), 0))
        }
        return document.addEventListener(`keydown`, e), () => document.removeEventListener(`keydown`, e)
    }, [a]);

    function A(e) {
        e.preventDefault()
    }

    function j() {
        s(!1), window.setTimeout(() => _.current ? .focus(), 0)
    }
    return (0, d.jsxs)(`aside`, {
        className: `support-assistant${a?` is-open`:``}`,
        "aria-label": `Support`,
        children: [a && (0, d.jsxs)(`section`, {
            className: `support-assistant__panel`,
            id: `support-assistant-panel`,
            children: [(0, d.jsxs)(`header`, {
                children: [(0, d.jsxs)(`div`, {
                    children: [(0, d.jsx)(`span`, {
                        children: `Kursportal-Hilfe`
                    }), (0, d.jsx)(`h2`, {
                        children: `Wobei brauchst du Hilfe?`
                    })]
                }), (0, d.jsx)(`button`, {
                    type: `button`,
                    "aria-label": `Hilfe schließen`,
                    onClick: j,
                    children: `×`
                })]
            }), (0, d.jsx)(`p`, {
                className: `support-assistant__notice`,
                children: `Lokale Hilfe ohne externe KI. Ein gemeinsamer Einstieg für technische Hilfe und Kursfragen. Bitte gib keine Passwörter oder Zahlungsdaten ein.`
            }), p ? .personalContactEnabled && (0, d.jsxs)(`p`, {
                className: `support-assistant__course-note`,
                children: [p.customerFirstName ? `${p.customerFirstName}, du kannst ` : `Du kannst `, `hier zuerst nach einer Antwort suchen. Bleibt eine besondere Kursfrage offen, kannst du sie anschließend persönlich an Dennis senden.`]
            }), (0, d.jsx)(`div`, {
                className: `support-assistant__topics`,
                "aria-label": `Häufige Hilfethemen`,
                children: y.slice(0, 5).map(e => (0, d.jsx)(`button`, {
                    type: `button`,
                    onClick: () => l(e.question),
                    children: e.title
                }, e.id))
            }), (0, d.jsxs)(`form`, {
                className: `support-assistant__search`,
                onSubmit: A,
                onReset: () => {
                    l(``), window.setTimeout(() => g.current ? .focus(), 0)
                },
                children: [(0, d.jsx)(`label`, {
                    htmlFor: `support-query`,
                    children: `Frage eingeben`
                }), (0, d.jsxs)(`div`, {
                    children: [(0, d.jsx)(`textarea`, {
                        ref: g,
                        id: `support-query`,
                        value: c,
                        onChange: e => l(e.target.value),
                        maxLength: 1200,
                        rows: 3,
                        autoComplete: `off`,
                        placeholder: `Zum Beispiel: Audio startet nicht – oder: Wie übertrage ich diesen Kursinhalt auf meine Situation?`
                    }), (0, d.jsx)(`button`, {
                        type: `submit`,
                        children: `Suchen`
                    }), (0, d.jsx)(`button`, {
                        className: `support-assistant__clear`,
                        type: `reset`,
                        children: `Löschen`
                    })]
                })]
            }), (0, d.jsxs)(`div`, {
                className: `support-assistant__results`,
                "aria-live": `polite`,
                children: [D && (0, d.jsx)(`p`, {
                    className: `support-assistant__warning`,
                    children: `Bitte gib hier keine Passwörter oder Zahlungsdaten ein. Die Eingabe wird nicht gespeichert oder übertragen.`
                }), E && c.trim().length >= 2 ? (0, d.jsxs)(`article`, {
                    className: `support-assistant__personal`,
                    children: [(0, d.jsx)(`small`, {
                        children: `Persönliche Kursantwort`
                    }), (0, d.jsx)(`h3`, {
                        children: `Diese Frage kannst du Dennis direkt stellen.`
                    }), (0, d.jsx)(`p`, {
                        children: `Der Text aus dem Suchfeld wird zusammen mit Kurs und Kundenzuordnung in einer E-Mail vorbereitet. Dennis liest und beantwortet sie persönlich. Das ist kein technischer Support.`
                    }), (0, d.jsx)(`a`, {
                        className: `support-assistant__inline-mail`,
                        href: k,
                        children: `Persönliche Frage an Dennis vorbereiten`
                    })]
                }) : T && c.trim().length >= 2 ? (0, d.jsxs)(`article`, {
                    children: [(0, d.jsx)(`h3`, {
                        children: `Technischer Support`
                    }), (0, d.jsx)(`p`, {
                        children: `Bei Login, Audio, Bedienung oder einem Fehler kannst du eine Support-E-Mail vorbereiten.`
                    }), (0, d.jsx)(`a`, {
                        className: `support-assistant__inline-mail`,
                        href: O,
                        children: `Technische Support-E-Mail vorbereiten`
                    })]
                }) : c.trim().length >= 2 && w.map(({
                    entry: e,
                    score: t
                }) => (0, d.jsxs)(`article`, {
                    children: [(0, d.jsx)(`small`, {
                        children: e.area
                    }), (0, d.jsx)(`h3`, {
                        children: e.title
                    }), t === 0 && (0, d.jsx)(`small`, {
                        children: `Dieses freigegebene Thema könnte dir weiterhelfen.`
                    }), e.answer.split(`

`).map(e => (0, d.jsx)(`p`, {
                        children: e
                    }, e)), e.additionalAnswer && (0, d.jsx)(`p`, {
                        children: e.additionalAnswer
                    }), (0, d.jsxs)(`div`, {
                        className: `support-assistant__actions`,
                        children: [e.href && e.linkLabel && (e.href.startsWith(`http`) || e.href.startsWith(`mailto:`) ? (0, d.jsx)(`a`, {
                            href: e.href,
                            children: e.linkLabel
                        }) : (0, d.jsx)(i, {
                            href: e.href,
                            children: e.linkLabel
                        })), e.support && (0, d.jsx)(`a`, {
                            href: O,
                            children: `Technischen Support kontaktieren`
                        })]
                    }), e.secondaryHref && e.secondaryLinkLabel && (0, d.jsx)(`div`, {
                        className: `support-assistant__actions`,
                        children: (0, d.jsx)(`a`, {
                            href: e.secondaryHref,
                            children: e.secondaryLinkLabel
                        })
                    })]
                }, e.id)), p ? .personalContactEnabled && c.trim().length >= 2 && !E && (0, d.jsxs)(`article`, {
                    className: `support-assistant__personal`,
                    children: [(0, d.jsx)(`small`, {
                        children: `Antwort nicht passend?`
                    }), (0, d.jsx)(`h3`, {
                        children: `Besondere Kursfrage an Dennis`
                    }), (0, d.jsx)(`p`, {
                        children: `Wenn es um die persönliche Einordnung oder Umsetzung des Kursinhalts geht, kannst du deine eingegebene Frage direkt an Dennis senden.`
                    }), (0, d.jsx)(`a`, {
                        className: `support-assistant__inline-mail`,
                        href: k,
                        children: `Frage an Dennis vorbereiten`
                    })]
                })]
            }), (0, d.jsxs)(`footer`, {
                children: [(0, d.jsx)(`a`, {
                    className: `support-assistant__mail`,
                    href: O,
                    children: `Technisches Problem melden`
                }), (0, d.jsx)(i, {
                    href: `/datenschutz`,
                    children: `Datenschutzhinweise`
                })]
            })]
        }), (0, d.jsx)(`button`, {
            ref: _,
            type: `button`,
            className: `support-assistant__toggle`,
            "aria-expanded": a,
            "aria-controls": `support-assistant-panel`,
            onClick: () => s(e => !e),
            children: `Support`
        })]
    })
}
export {
    h as
    default
};