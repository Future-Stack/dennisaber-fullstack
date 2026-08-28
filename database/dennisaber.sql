-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2026 at 11:25 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dennisaber`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_requests`
--

CREATE TABLE `access_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `invoice_number` varchar(255) DEFAULT NULL,
  `course_slug` varchar(255) DEFAULT NULL,
  `course_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'open',
  `resolved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `access_requests`
--

INSERT INTO `access_requests` (`id`, `first_name`, `username`, `invoice_number`, `course_slug`, `course_name`, `email`, `note`, `status`, `resolved_at`, `created_at`, `updated_at`) VALUES
(1, 'Thomas', 'thomas.k', 'RE-2026-089', 'dnl-kompakt', '5-Tage-Kompaktlehrgang', 'thomas@example.de', 'Passwort verlegt nach Gerätewechsel. Bitte um Zusendung eines neuen Kennworts.', 'resolved', '2026-08-26 02:32:17', '2026-08-26 02:15:43', '2026-08-26 02:32:17');

-- --------------------------------------------------------

--
-- Table structure for table `admin_notes`
--

CREATE TABLE `admin_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(120) NOT NULL,
  `body` text NOT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_notes`
--

INSERT INTO `admin_notes` (`id`, `user_id`, `title`, `body`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Papierkram Rechnungsabgleich', 'Kontoauszüge für August abgleichen und Rechnungsnummern für Neuanmeldungen prüfen.', '2026-09-04 02:15:43', '2026-08-26 02:15:43', '2026-08-26 02:15:43'),
(2, 1, 'Testphase mit Auftraggeber abstimmen', 'Phase 1 Funktionen (Login, Testkurs, Fortschrittsspeicherung, Adminverwaltung) vollständig verifiziert.', '2026-09-05 02:15:43', '2026-08-26 02:15:43', '2026-08-26 02:15:43');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `duration_days` int(11) NOT NULL DEFAULT 90,
  `total_hours` varchar(255) DEFAULT NULL,
  `public_url` varchar(255) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `slug`, `category`, `subtitle`, `description`, `thumbnail`, `duration_days`, `total_hours`, `public_url`, `order`, `is_published`, `created_at`, `updated_at`) VALUES
(1, '5-Tage-Kompaktlehrgang', 'dnl-kompakt', 'Akademie / Bildungsurlaub', 'DNL Kompakt — Kompakte Qualifikation & praxisnahe Methodik', 'Der 5-Tage-Kompaktlehrgang vermittelt in komprimierter Form die zentralen Werkzeuge für gelingende Kommunikation, systemische Analyse und persönliche Wirksamkeit.', '/frontend/assets/kompakt-thumb.jpg', 90, '40 Unterrichtsstunden', 'https://besseler-kursvorschau.dennis-bes.chatgpt.site/akademie/bildungsurlaub/', 1, 1, '2026-08-26 02:15:43', '2026-08-26 02:15:43'),
(2, 'Vertiefungsausbildung', 'dnl-vertiefung', 'Akademie', 'Fortgeschrittene Techniken und Vertiefung', 'Aufbauend auf dem Kompaktlehrgang vertieft diese Ausbildung die methodischen Kompetenzen in Beratung und Gesprächsführung.', '/frontend/assets/vertiefung-thumb.jpg', 120, '60 Unterrichtsstunden', 'https://besseler-kursvorschau.dennis-bes.chatgpt.site/akademie/vertiefung/', 2, 1, '2026-08-26 02:15:43', '2026-08-26 02:15:43'),
(3, 'Premium-Seminar', 'dnl-premium', 'Akademie', 'Exklusives Intensivseminar mit individuellem Mentoring', 'Das Premium-Seminar für Führungskräfte und Entscheidungsträger mit maximalem Praxisbezug.', '/frontend/assets/premium-thumb.jpg', 180, '80 Unterrichtsstunden', 'https://besseler-kursvorschau.dennis-bes.chatgpt.site/akademie/premium/', 3, 1, '2026-08-26 02:15:43', '2026-08-26 02:15:43'),
(4, 'Stress und Ressourcen', 'stress-und-ressourcen', 'Prävention', 'Widerstandskraft stärken und Stress nachhaltig abbauen', 'Wissenschaftlich fundierte Strategien zur Stressbewältigung und Aktivierung persönlicher Ressourcen.', '/frontend/assets/stress-thumb.jpg', 60, '20 Unterrichtsstunden', 'https://besseler-kursvorschau.dennis-bes.chatgpt.site/praevention/stress/', 4, 1, '2026-08-26 02:15:43', '2026-08-26 02:15:43'),
(5, 'Rauchfrei', 'rauchfrei', 'Prävention', 'Schritt für Schritt rauchfrei leben', 'Verhaltenstherapeutisch orientiertes Programm für dauerhafte Tabak- und Nikotinfreiheit.', '/frontend/assets/rauchfrei-thumb.jpg', 60, '15 Unterrichtsstunden', 'https://besseler-kursvorschau.dennis-bes.chatgpt.site/praevention/rauchfrei/', 5, 1, '2026-08-26 02:15:43', '2026-08-26 02:15:43'),
(6, 'Ernährung', 'ernaehrung', 'Prävention', 'Gesunde Ernährung im Alltag etablieren', 'Praktischer Leitfaden für alltagstaugliche und typgerechte Ernährungsoptimierung.', '/frontend/assets/ernaehrung-thumb.jpg', 60, '15 Unterrichtsstunden', 'https://besseler-kursvorschau.dennis-bes.chatgpt.site/praevention/ernaehrung/', 6, 1, '2026-08-26 02:15:43', '2026-08-26 02:15:43'),
(7, 'Klar entscheiden', 'klar-entscheiden', 'Prävention & Führung', 'Entscheidungskompetenz in komplexen Lagen', 'Systematische Entscheidungsfindung unter Zeitdruck und Unsicherheit.', '/frontend/assets/entscheiden-thumb.jpg', 45, '12 Unterrichtsstunden', 'https://besseler-kursvorschau.dennis-bes.chatgpt.site/praevention/klar-entscheiden/', 7, 1, '2026-08-26 02:15:43', '2026-08-26 02:15:43'),
(8, 'Erfolgreich gründen', 'erfolgreich-gruenden', 'Business', 'Vom Konzept zum tragfähigen Geschäftsmodell', 'Praxiswissen für Solopreneure und Gründer: Positionierung, Vertrieb und Struktur.', '/frontend/assets/gruenden-thumb.jpg', 90, '30 Unterrichtsstunden', 'https://besseler-kursvorschau.dennis-bes.chatgpt.site/gruenden/', 8, 1, '2026-08-26 02:15:43', '2026-08-26 02:15:43'),
(9, 'Presse & Öffentlichkeit', 'presse-oeffentlichkeit', 'Kommunikation', 'Gezielte Medienarbeit und professionelle Außenwirkung', 'Pressemitteilungen schreiben, Journalistenkontakte aufbauen und Krisenkommunikation meistern.', '/frontend/assets/presse-thumb.jpg', 60, '20 Unterrichtsstunden', 'https://besseler-kursvorschau.dennis-bes.chatgpt.site/presse/', 9, 1, '2026-08-26 02:15:43', '2026-08-26 02:15:43'),
(10, 'Rhetorik unter Druck', 'rhetorik-unter-druck', 'Kommunikation', 'Souverän argumentieren in schwierigen Verhandlungssituationen', 'Schlagfertigkeit, Körpersprache und Deeskalationstechniken in anspruchsvollen Gesprächen.', '/frontend/assets/rhetorik-thumb.jpg', 45, '15 Unterrichtsstunden', 'https://besseler-kursvorschau.dennis-bes.chatgpt.site/rhetorik/', 10, 1, '2026-08-26 02:15:43', '2026-08-26 02:15:43'),
(11, 'Rio Negro 2002', 'rio-negro-2002', 'Spezial / Audio', 'Das interaktive Audio-Entscheidungs-Erlebnis', 'Ein didaktisch einzigartiges Audio-Erlebnis zum Trainieren intuitiver und strategischer Entscheidungen.', '/frontend/assets/rionegro-thumb.jpg', 30, '10 Unterrichtsstunden', 'https://besseler-kursvorschau.dennis-bes.chatgpt.site/service/rio-negro/', 11, 1, '2026-08-26 02:15:43', '2026-08-26 02:15:43');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(255) DEFAULT NULL,
  `started_at` date NOT NULL,
  `expires_at` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `early_start_agreed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `invoice_number`, `started_at`, `expires_at`, `is_active`, `early_start_agreed`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'RE-2026-001', '2026-08-21', '2026-11-19', 1, 1, '2026-08-26 02:15:43', '2026-08-26 02:15:43'),
(2, 4, 2, 'RE-2016-02', '2026-08-26', '2026-12-24', 1, 1, '2026-08-26 02:33:09', '2026-08-26 02:33:09'),
(3, 5, 4, 'RE-2016-03', '2026-08-26', '2026-10-25', 1, 1, '2026-08-26 03:09:57', '2026-08-26 03:09:57'),
(4, 7, 1, 'RE-2016-03', '2026-08-26', '2026-11-24', 1, 1, '2026-08-26 03:22:02', '2026-08-26 03:22:02'),
(5, 8, 4, 'RE-2016-04', '2026-08-26', '2026-10-25', 1, 1, '2026-08-26 03:25:57', '2026-08-26 03:25:57');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `chapter_name` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `lesson_number` int(11) NOT NULL DEFAULT 1,
  `duration_minutes` int(11) NOT NULL DEFAULT 15,
  `video_url` varchar(255) DEFAULT NULL,
  `video_path` varchar(255) DEFAULT NULL,
  `audio_path` varchar(255) DEFAULT NULL,
  `pdf_attachment_path` varchar(255) DEFAULT NULL,
  `pdf_attachment_name` varchar(255) DEFAULT NULL,
  `content_html` longtext DEFAULT NULL,
  `is_preview` tinyint(1) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `course_id`, `chapter_name`, `title`, `slug`, `lesson_number`, `duration_minutes`, `video_url`, `video_path`, `audio_path`, `pdf_attachment_path`, `pdf_attachment_name`, `content_html`, `is_preview`, `order`, `created_at`, `updated_at`) VALUES
(1, 1, 'Modul 1: Grundlagen & Einführung', '1. Einführung in den 5-Tage-Kompaktlehrgang', 'einfuehrung-und-orientierung', 1, 18, 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4', 'videos/dnl-kompakt-lektion-1.mp4', NULL, 'materials/01_Uebersicht_und_Lernleitfaden.pdf', '01_Uebersicht_und_Lernleitfaden.pdf', '<h3>Willkommen zum 5-Tage-Kompaktlehrgang</h3>\n<p>In dieser ersten Lektion verschaffen wir uns einen vollständigen Überblick über den Ablauf, die didaktische Struktur sowie die angestrebten Lernziele des Lehrgangs.</p>\n<h4>Kerninhalte der Lektion:</h4>\n<ul>\n    <li>Struktur des Lehrgangs und empfohlener Lernrhythmus</li>\n    <li>Die Grundannahmen der systemischen Gesprächsführung</li>\n    <li>Einrichtung Ihres persönlichen Studienarbeitsplatzes</li>\n    <li>Nutzung der begleitenden Arbeitsblätter und Reflexionsbögen</li>\n</ul>\n<div class=\"note-box\">\n    <strong>Wichtiger Hinweis:</strong> Bitte laden Sie vor dem Start das begleitende Arbeitsblatt herunter und legen Sie es für die praktischen Übungen bereit.\n</div>', 1, 1, '2026-08-26 02:15:43', '2026-08-26 02:15:43'),
(2, 1, 'Modul 1: Grundlagen & Einführung', '2. Wahrnehmung, Rapport und Kommunikationsmuster', 'wahrnehmung-und-rapport', 2, 25, 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4', 'videos/dnl-kompakt-lektion-2.mp4', NULL, 'materials/02_Arbeitsblatt_Rapport_und_Wahrnehmung.pdf', '02_Arbeitsblatt_Rapport_und_Wahrnehmung.pdf', '<h3>Wahrnehmung und Rapport in der Praxis</h3>\n<p>Erfolgreiche Kommunikation beginnt mit präziser Beobachtung. In diesem Modul trainieren wir die Fähigkeit, nonverbale Signale sensibel wahrzunehmen und einen tragfähigen Rapport aufzubauen.</p>\n<h4>Schwerpunkte:</h4>\n<ul>\n    <li>Kalibrieren: Feinheiten in Mimik, Gestik und Stimmlage deuten</li>\n    <li>Pacing & Leading: Den Gesprächspartner abholen und zielgerichtet leiten</li>\n    <li>Vermeidung typischer Kommunikationsfallen und unbewusster Blockaden</li>\n</ul>', 0, 2, '2026-08-26 02:15:43', '2026-08-26 02:15:43'),
(3, 1, 'Modul 2: Werkzeuge & Interventionen', '3. Stressregulation und Ressourcen-Aktivierung', 'stressregulation-und-ressourcen', 3, 22, 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4', 'videos/dnl-kompakt-lektion-3.mp4', 'audio/ressourcen-meditation.mp3', 'materials/03_Uebungsblatt_Ressourcen_Anker.pdf', '03_Uebungsblatt_Ressourcen_Anker.pdf', '<h3>Stressregulation & mentale Ressourcen</h3>\n<p>Wie bleiben wir auch in herausfordernden Momenten handlungsfähig? Diese Lektion widmet sich der gezielten Aktivierung mentaler Ressourcen und dem Setzen stabiler Anker.</p>\n<h4>Praxisübungen:</h4>\n<ul>\n    <li>Die 4-7-8 Atemtechnik zur schnellen Beruhigung des vegetativen Nervensystems</li>\n    <li>Erstellen einer persönlichen Ressourcen-Landkarte</li>\n    <li>Anker-Technik: Positive emotionale Zustände gezielt abrufbar machen</li>\n</ul>', 0, 3, '2026-08-26 02:15:43', '2026-08-26 02:15:43'),
(4, 1, 'Modul 2: Werkzeuge & Interventionen', '4. Fragetechniken und systemisches Reframing', 'fragetechniken-und-reframing', 4, 28, 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4', 'videos/dnl-kompakt-lektion-4.mp4', NULL, 'materials/04_Checkliste_Systemische_Fragen.pdf', '04_Checkliste_Systemische_Fragen.pdf', '<h3>Systemische Fragetechniken & Umdeutung</h3>\n<p>Wer fragt, der führt. Lernen Sie zirkuläre Fragen, Skalierungsfragen und das gezielte Reframing kennen, um festgefahrene Denkmuster aufzubrechen.</p>\n<h4>Methodenübersicht:</h4>\n<ul>\n    <li>Zirkuläres Fragen: Perspektivwechsel gezielt anregen</li>\n    <li>Kontext- und Bedeutungs-Reframing in Konfliktsituationen</li>\n    <li>Die Wunderfrage nach Steve de Shazer</li>\n</ul>', 0, 4, '2026-08-26 02:15:43', '2026-08-26 02:15:43'),
(5, 1, 'Modul 3: Praxistransfer & Abschluss', '5. Nachhaltiger Praxistransfer und Zertifikatsnachweis', 'praxistransfer-und-abschluss', 5, 20, 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerFun.mp4', 'videos/dnl-kompakt-lektion-5.mp4', NULL, 'materials/05_Leitfaden_Praxistransfer.pdf', '05_Leitfaden_Praxistransfer.pdf', '<h3>Abschluss und Umsetzung in den Berufsalltag</h3>\n<p>Herzlichen Glückwunsch zum Erreichen des letzten Moduls! In dieser Lektion bündeln wir die erarbeiteten Erkenntnisse und entwickeln Ihren individuellen Umsetzungsplan für die kommenden 30 Tage.</p>\n<h4>Abschlussschritte:</h4>\n<ul>\n    <li>Erstellung des persönlichen 30-Tage-Aktionsplans</li>\n    <li>Kriterien für den Erhalt Ihrer Teilnahmebescheinigung</li>\n    <li>Feedbackbogen und fortführende Lernempfehlungen</li>\n</ul>', 0, 5, '2026-08-26 02:15:43', '2026-08-26 02:15:43'),
(6, 4, 'Modul 1: Stress verstehen', '1. Die Neurobiologie von akutem und chronischem Stress', 'neurobiologie-des-stresses', 1, 20, 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4', 'videos/stress-lektion-1.mp4', NULL, 'materials/Stress_Selbstanalyse_Bogen.pdf', 'Stress_Selbstanalyse_Bogen.pdf', '<p>Wie wirkt Stress auf Körper und Geist? Erfahren Sie die biochemischen Abläufe der Stressachse.</p>', 1, 1, '2026-08-26 02:15:43', '2026-08-26 02:15:43'),
(7, 4, 'Modul 1: Stress verstehen', '2. Individuelle Stressoren und Antreiber identifizieren', 'stressoren-identifizieren', 2, 24, 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4', 'videos/stress-lektion-2.mp4', NULL, 'materials/Innere_Antreiber_Test.pdf', 'Innere_Antreiber_Test.pdf', '<p>Die 5 inneren Antreiber: Sei perfekt, sei schnell, streng dich an, mach es allen recht, sei stark.</p>', 0, 2, '2026-08-26 02:15:43', '2026-08-26 02:15:43'),
(8, 4, 'Modul 2: Sofortinterventionen', '3. Die SOS-Entspannungsübung für den Arbeitsalltag', 'sos-entspannung', 3, 15, 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4', 'videos/stress-lektion-3.mp4', 'audio/sos-atemfuehrung.mp3', 'materials/Atemtechniken_Uebersicht.pdf', 'Atemtechniken_Uebersicht.pdf', '<p>Gezielte Atem- und Körperübungen zur schnellen Senkung des Herzschlags und Cortisolspiegels.</p>', 0, 3, '2026-08-26 02:15:43', '2026-08-26 02:15:43');

-- --------------------------------------------------------

--
-- Table structure for table `lesson_progress`
--

CREATE TABLE `lesson_progress` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `lesson_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `is_completed` tinyint(1) NOT NULL DEFAULT 0,
  `completed_at` timestamp NULL DEFAULT NULL,
  `last_position_seconds` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lesson_progress`
--

INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `course_id`, `is_completed`, `completed_at`, `last_position_seconds`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1, 1, '2026-08-23 02:15:43', 1080, '2026-08-26 02:15:43', '2026-08-26 02:15:43'),
(2, 2, 2, 1, 1, '2026-08-25 02:15:43', 1500, '2026-08-26 02:15:43', '2026-08-26 02:15:43'),
(3, 2, 4, 1, 1, '2026-08-26 02:27:57', 0, '2026-08-26 02:27:57', '2026-08-26 02:27:57'),
(4, 2, 5, 1, 1, '2026-08-26 02:28:02', 0, '2026-08-26 02:28:02', '2026-08-26 02:28:02'),
(5, 2, 3, 1, 1, '2026-08-26 02:28:13', 0, '2026-08-26 02:28:13', '2026-08-26 02:28:13'),
(6, 1, 1, 1, 1, '2026-08-26 02:37:40', 0, '2026-08-26 02:37:40', '2026-08-26 02:37:40'),
(7, 1, 2, 1, 1, '2026-08-26 02:37:43', 0, '2026-08-26 02:37:43', '2026-08-26 02:37:43'),
(8, 1, 3, 1, 1, '2026-08-26 02:37:45', 0, '2026-08-26 02:37:45', '2026-08-26 02:37:45'),
(9, 1, 4, 1, 1, '2026-08-26 02:37:47', 0, '2026-08-26 02:37:47', '2026-08-26 02:37:47'),
(10, 1, 5, 1, 1, '2026-08-26 02:37:50', 0, '2026-08-26 02:37:50', '2026-08-26 02:37:50'),
(11, 8, 6, 4, 1, '2026-08-26 03:27:05', 0, '2026-08-26 03:27:05', '2026-08-26 03:27:05'),
(12, 8, 7, 4, 1, '2026-08-26 03:27:09', 0, '2026-08-26 03:27:09', '2026-08-26 03:27:09'),
(13, 8, 8, 4, 1, '2026-08-26 03:27:13', 0, '2026-08-26 03:27:13', '2026-08-26 03:27:13');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_08_26_000001_create_courses_and_lessons_tables', 1),
(5, '2026_08_26_000002_create_admin_workspace_tables', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('du3jLue9Nu74kn0oVS9TZBrEtRy3YVQ079oB8wWU', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNlVGdURMNkVUSVBOTUluT1ZDOUczSE9tVnAzdXc1VGp0QjRtVlk4YyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1787806445);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'member',
  `invoice_number` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `occupation` varchar(255) DEFAULT NULL,
  `access_from` date DEFAULT NULL,
  `access_until` date DEFAULT NULL,
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permissions`)),
  `security_code_hash` varchar(255) DEFAULT NULL,
  `security_code_expires_at` timestamp NULL DEFAULT NULL,
  `device_id` varchar(255) DEFAULT NULL,
  `device_name` varchar(255) DEFAULT NULL,
  `device_bound_at` timestamp NULL DEFAULT NULL,
  `last_device_activity_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `first_name`, `username`, `email`, `email_verified_at`, `password`, `role`, `invoice_number`, `is_active`, `occupation`, `access_from`, `access_until`, `permissions`, `security_code_hash`, `security_code_expires_at`, `device_id`, `device_name`, `device_bound_at`, `last_device_activity_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Dennis Besseler', 'Dennis', 'dennis.besseler', 'dennis@besseler.de', NULL, '$2y$12$auG9wDHAdBpuCQLzQN.scef6NPg3VITS0tl3xVVBb6foXTdwj/ks6', 'admin', NULL, 1, NULL, NULL, NULL, NULL, '$2y$12$m2jBRz6Dtyv1FpdC0alYr.WgRyWo9ozjqgZkuU0.YUwI2QBEz34ee', NULL, 'bceb0689f76f0d641edde76cfd05a84d3d8cff36a50a5931eabfbbc1091650fc', 'Win32 | Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-26 02:30:41', '2026-08-26 22:47:52', 'EfakRgIJ0Y0HEm8cWX0xRwKBZn4MWLQlA486xO6s1kkvUVxfKURRCjdQT5Ee', '2026-08-26 02:15:43', '2026-08-26 22:47:52'),
(2, 'Max Mustermann', 'Max', 'testkunde', 'kunde@besseler.de', NULL, '$2y$12$3QWGMIqdv5K9ELNN/1WaLuHnUfbgtbl/7azhoBmneTs9dPM9NZvGC', 'member', 'RE-2026-001', 1, NULL, NULL, NULL, NULL, NULL, NULL, 'bceb0689f76f0d641edde76cfd05a84d3d8cff36a50a5931eabfbbc1091650fc', 'Win32 | Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-26 02:26:48', '2026-08-26 02:26:48', 'wgwUWkhOnisKBXSC16AzDaqBgWKmcwye3177yRRuDXhOgnGIe1kcgeXSum83', '2026-08-26 02:15:43', '2026-08-26 02:36:44'),
(3, 'Sarah Schmidt', 'Sarah', 'sarah.service', 'sarah@besseler.de', NULL, '$2y$12$vNl5087MyFbP5KWFW7OZ1uNGLKxVtCBO1.1NUb6eXIN9OtsxhoPSm', 'staff', NULL, 1, 'Kundenservice & Freigaben', '2026-08-21', '2026-09-25', '{\"view_customers\":true,\"create_customers\":true,\"manage_enrollments\":true,\"reset_passwords\":true}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-26 02:15:43', '2026-08-26 02:15:43'),
(4, 'Mahbub', 'Mahbub', 'mahbub', 'mahbub@besseler-kunden.de', NULL, '$2y$12$vNl5087MyFbP5KWFW7OZ1uNGLKxVtCBO1.1NUb6eXIN9OtsxhoPSm', 'member', 'RE-2016-02', 1, NULL, NULL, NULL, NULL, NULL, NULL, 'bceb0689f76f0d641edde76cfd05a84d3d8cff36a50a5931eabfbbc1091650fc', 'Win32 | Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-26 02:45:04', '2026-08-26 02:57:29', '8CIUHcPPep4MYbrjzHmupVe5BSECL6nyqAHCi2hWWfkqZQsCV07jxX1WPUs4', '2026-08-26 02:33:09', '2026-08-26 02:57:29'),
(5, 'Sabbir', 'Sabbir', 'sabbir', 'sabbir@besseler-kunden.de', NULL, '$2y$12$KEz.1YWpAeq.F3kIw/rXTOPTk.9WJhUyBqmq2TMy5UwdEgUW9/TT.', 'member', 'RE-2016-03', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-26 03:09:57', '2026-08-26 03:09:57'),
(6, 'Mim', 'Mim', 'mim', 'mim@besseler-intern.de', NULL, '$2y$12$z3IE4Ixtes.PwbJbg3LcZeXVKGdB/J0tWkR9tyUTGfSW1m0CCNsqS', 'staff', NULL, 1, 'Test Task', '2026-08-26', '2026-09-25', '{\"view_customers\":\"1\",\"create_customers\":\"1\",\"manage_enrollments\":\"1\",\"reset_passwords\":\"1\",\"toggle_active\":\"1\"}', NULL, NULL, 'bceb0689f76f0d641edde76cfd05a84d3d8cff36a50a5931eabfbbc1091650fc', 'Win32 | Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-26 03:18:28', '2026-08-26 03:18:28', 'E3L6EwUz7mghokcS2KHUW10Fsei9msuWBa5KY0li3tUyrVAsiqXHyMxkO1ur', '2026-08-26 03:18:04', '2026-08-26 03:18:28'),
(7, 'Rehana', 'Rehana', 'kabir', 'kabir@besseler-kunden.de', NULL, '$2y$12$Fm53ZTrJNwCwrNVTQyL.9eMc0XOdUCINAseeVqE/7xxsaPGRo9f96', 'member', 'RE-2016-03', 1, NULL, NULL, NULL, NULL, NULL, NULL, 'bceb0689f76f0d641edde76cfd05a84d3d8cff36a50a5931eabfbbc1091650fc', 'Win32 | Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-26 03:22:28', '2026-08-26 03:22:28', 'CiYXn6xGW47MeqEm69Sp7eacMXHkAD5yjwE561bjB9o1DjRcXJ9lTjZMZopz', '2026-08-26 03:22:02', '2026-08-26 03:22:28'),
(8, 'Sourov', 'Sourov', 'sourov', 'sourov@besseler-kunden.de', NULL, '$2y$12$sTLLz2kIDw1eFCd8V0LNVuxTO3JV8JcvM3aqpoSq.J7zwdOADtpky', 'member', 'RE-2016-04', 1, NULL, NULL, NULL, NULL, NULL, NULL, 'bceb0689f76f0d641edde76cfd05a84d3d8cff36a50a5931eabfbbc1091650fc', 'Win32 | Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-26 03:26:38', '2026-08-26 03:26:38', 'kBr63LNg5CUo7nSPZ16eg71JpLQJzKCwvOU8Pc1deKTCqZqXsXBVja9rzc1v', '2026-08-26 03:25:57', '2026-08-26 03:26:38');

-- --------------------------------------------------------

--
-- Table structure for table `version_notes`
--

CREATE TABLE `version_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(120) NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `version_notes`
--

INSERT INTO `version_notes` (`id`, `user_id`, `title`, `body`, `created_at`, `updated_at`) VALUES
(1, 1, 'Zertifikats-PDF Download für Kunden', 'Nach 100% Kursabschluss automatische Generierung eines personalisierten Teilnahme-Zertifikats (Phase 2).', '2026-08-26 02:15:43', '2026-08-26 02:15:43'),
(2, 1, 'Mitarbeiter-Portal Erweiterung', 'Mitarbeiterbereich mit direkter CRM-Anbindung für Kundensupport und Telefonnotizen einbinden.', '2026-08-26 02:15:43', '2026-08-26 02:15:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_requests`
--
ALTER TABLE `access_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_notes`
--
ALTER TABLE `admin_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_notes_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `courses_slug_unique` (`slug`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `enrollments_user_id_course_id_unique` (`user_id`,`course_id`),
  ADD KEY `enrollments_course_id_foreign` (`course_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lessons_course_id_slug_unique` (`course_id`,`slug`);

--
-- Indexes for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lesson_progress_user_id_lesson_id_unique` (`user_id`,`lesson_id`),
  ADD KEY `lesson_progress_lesson_id_foreign` (`lesson_id`),
  ADD KEY `lesson_progress_course_id_foreign` (`course_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `version_notes`
--
ALTER TABLE `version_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `version_notes_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_requests`
--
ALTER TABLE `access_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_notes`
--
ALTER TABLE `admin_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `version_notes`
--
ALTER TABLE `version_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_notes`
--
ALTER TABLE `admin_notes`
  ADD CONSTRAINT `admin_notes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  ADD CONSTRAINT `lesson_progress_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lesson_progress_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lesson_progress_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `version_notes`
--
ALTER TABLE `version_notes`
  ADD CONSTRAINT `version_notes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
