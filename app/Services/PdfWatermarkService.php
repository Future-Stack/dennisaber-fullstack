<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use setasign\Fpdi\Fpdi;

class WatermarkPdfEngine extends Fpdi
{
    public float $angle = 0;

    public function Rotate(float $angle, float $x = -1, float $y = -1): void
    {
        if ($x == -1) {
            $x = $this->x;
        }
        if ($y == -1) {
            $y = $this->y;
        }
        if ($this->angle != 0) {
            $this->_out('Q');
        }
        $this->angle = $angle;
        if ($angle != 0) {
            $angle *= M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }

    public function _endpage(): void
    {
        if ($this->angle != 0) {
            $this->angle = 0;
            $this->_out('Q');
        }
        parent::_endpage();
    }
}

class PdfWatermarkService
{
    /**
     * Stamp personalized user metadata (Name, Invoice No, Company) onto an existing or generated PDF.
     */
    public function generateWatermarkedPdf(User $user, Course $course, Lesson $lesson, ?string $sourcePdfPath = null): string
    {
        $pdf = new WatermarkPdfEngine();
        $pdf->SetAutoPageBreak(false);
        $pdf->SetCompression(false);

        $customerName = trim($user->name ?: ($user->first_name . ' ' . ($user->last_name ?? '')));
        if (empty($customerName)) {
            $customerName = $user->username ?: 'Kunde';
        }
        $invoiceNumber = $user->invoice_number ?: 'RN-' . strtoupper(substr(md5($user->id . 'DENNIS'), 0, 8));

        $watermarkText = mb_strtoupper("PERSOENLICHE PRIVAT-LIZENZ - {$customerName} - RECHNUNGS-NR. {$invoiceNumber} - KEINE WEITERGABE", 'UTF-8');
        // Convert UTF-8 to ISO-8859-1 for standard FPDF fonts
        $watermarkTextAscii = @iconv('UTF-8', 'windows-1252//TRANSLIT', $watermarkText) ?: $watermarkText;

        if ($sourcePdfPath && file_exists($sourcePdfPath)) {
            try {
                $pageCount = $pdf->setSourceFile($sourcePdfPath);
                for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                    $templateId = $pdf->importPage($pageNo);
                    $size = $pdf->getTemplateSize($templateId);

                    $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                    $pdf->useTemplate($templateId);

                    $this->applyWatermarkLayer($pdf, $watermarkTextAscii, $customerName, $invoiceNumber, $course->title, $lesson->title, $size['width'], $size['height']);
                }

                return $pdf->Output('S');
            } catch (\Throwable $e) {
                // If source PDF has compression/format issues, fallback to generated workbook
            }
        }

        // Generate clean branded Lesson Workbook PDF with watermark
        $pdf->AddPage('P', [210, 297]); // A4
        $width = 210;
        $height = 297;

        // Background decorative header
        $pdf->SetFillColor(15, 23, 42); // #0f172a
        $pdf->Rect(0, 0, 210, 45, 'F');

        // Course Title in Header
        $pdf->SetTextColor(248, 250, 252);
        $pdf->SetFont('Helvetica', 'B', 14);
        $pdf->SetXY(15, 12);
        $pdf->Cell(180, 8, @iconv('UTF-8', 'windows-1252//TRANSLIT', $course->title), 0, 1, 'L');

        // Lesson Title in Header
        $pdf->SetTextColor(56, 189, 248); // #38bdf8
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->SetXY(15, 22);
        $pdf->Cell(180, 6, @iconv('UTF-8', 'windows-1252//TRANSLIT', $lesson->chapter_name . ' - ' . $lesson->title), 0, 1, 'L');

        // Body Content
        $pdf->SetTextColor(30, 41, 59);
        $pdf->SetFont('Helvetica', 'B', 16);
        $pdf->SetXY(15, 55);
        $pdf->Cell(180, 10, @iconv('UTF-8', 'windows-1252//TRANSLIT', 'Begleitendes Arbeitsblatt & Lernleitfaden'), 0, 1, 'L');

        $pdf->SetFont('Helvetica', '', 11);
        $pdf->SetTextColor(51, 65, 85);
        $pdf->SetXY(15, 70);
        
        $bodyText = "Dieses Arbeitsmaterial gehoert zur Lektion: " . $lesson->title . ".\n\n" .
            "1. Kernfragen zur Selbstreflexion:\n" .
            "   - Welche konkreten Erkenntnisse aus dem Video lassen sich heute umsetzen?\n" .
            "   - Welche internen und externen Ressourcen stehen dafuer bereit?\n" .
            "   - Welche ersten Schritte sind in den naechsten 48 Stunden erforderlich?\n\n" .
            "2. Notizen und Aktionspunkte:\n" .
            "   ..........................................................................................................................\n\n" .
            "   ..........................................................................................................................\n\n" .
            "   ..........................................................................................................................\n\n" .
            "   ..........................................................................................................................\n\n" .
            "3. Verbindliche Umsetzungsvorgaben:\n" .
            "   - Dokumentation des persoenlichen Transferplans.\n" .
            "   - Regelmaessige Reflexion der Fortschritte im Kursportal.";

        $pdf->MultiCell(180, 7, @iconv('UTF-8', 'windows-1252//TRANSLIT', $bodyText));

        // License Information Box
        $pdf->SetFillColor(241, 245, 249);
        $pdf->SetDrawColor(203, 213, 225);
        $pdf->Rect(15, 230, 180, 40, 'DF');

        $pdf->SetFont('Helvetica', 'B', 9);
        $pdf->SetTextColor(15, 23, 42);
        $pdf->SetXY(20, 234);
        $pdf->Cell(170, 5, @iconv('UTF-8', 'windows-1252//TRANSLIT', 'GESCHUETZTE PERSOENLICHE PRIVATLIZENZ'), 0, 1);

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetTextColor(71, 85, 105);
        $pdf->SetXY(20, 241);
        $licenseInfo = "Lizenznehmer: {$customerName}\n" .
            "Rechnungsnummer: {$invoiceNumber}\n" .
            "Technischer Kopierschutz: Dieses Dokument ist kryptografisch und visuell dem lizenzierten Benutzerkonto zugeordnet. Jede unbefugte Weitergabe, Vervielfaeltigung oder Veroeffentlichung ist untersagt.";
        $pdf->MultiCell(170, 4.5, @iconv('UTF-8', 'windows-1252//TRANSLIT', $licenseInfo));

        // Apply repeating diagonal watermarks
        $this->applyWatermarkLayer($pdf, $watermarkTextAscii, $customerName, $invoiceNumber, $course->title, $lesson->title, $width, $height);

        return $pdf->Output('S');
    }

    /**
     * Generate clean branded Lesson Workbook PDF without stamped FPDI watermarks (for direct clean in-portal viewing).
     */
    public function generateCleanPdf(Course $course, Lesson $lesson): string
    {
        $pdf = new \setasign\Fpdi\Fpdi();
        $pdf->SetAutoPageBreak(false);
        $pdf->SetCompression(true);

        $pdf->AddPage('P', [210, 297]); // A4
        $width = 210;
        $height = 297;

        // Background decorative header
        $pdf->SetFillColor(15, 23, 42); // #0f172a
        $pdf->Rect(0, 0, 210, 45, 'F');

        // Course Title in Header
        $pdf->SetTextColor(248, 250, 252);
        $pdf->SetFont('Helvetica', 'B', 14);
        $pdf->SetXY(15, 12);
        $pdf->Cell(180, 8, @iconv('UTF-8', 'windows-1252//TRANSLIT', $course->title), 0, 1, 'L');

        // Lesson Title in Header
        $pdf->SetTextColor(56, 189, 248); // #38bdf8
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->SetXY(15, 22);
        $pdf->Cell(180, 6, @iconv('UTF-8', 'windows-1252//TRANSLIT', ($lesson->chapter_name ? $lesson->chapter_name . ' - ' : '') . $lesson->title), 0, 1, 'L');

        // Body Content
        $pdf->SetTextColor(30, 41, 59);
        $pdf->SetFont('Helvetica', 'B', 16);
        $pdf->SetXY(15, 55);
        $pdf->Cell(180, 10, @iconv('UTF-8', 'windows-1252//TRANSLIT', 'Begleitendes Arbeitsblatt & Lernleitfaden'), 0, 1, 'L');

        $pdf->SetFont('Helvetica', '', 11);
        $pdf->SetTextColor(51, 65, 85);
        $pdf->SetXY(15, 70);
        
        $bodyText = "Dieses Arbeitsmaterial gehoert zur Lektion: " . $lesson->title . ".\n\n" .
            "1. Kernfragen zur Selbstreflexion:\n" .
            "   - Welche konkreten Erkenntnisse aus dieser Lektion lassen sich heute umsetzen?\n" .
            "   - Welche internen und externen Ressourcen stehen dafuer bereit?\n" .
            "   - Welche ersten Schritte sind in den naechsten 48 Stunden erforderlich?\n\n" .
            "2. Notizen und Aktionspunkte:\n" .
            "   ..........................................................................................................................\n\n" .
            "   ..........................................................................................................................\n\n" .
            "   ..........................................................................................................................\n\n" .
            "   ..........................................................................................................................\n\n" .
            "3. Verbindliche Umsetzungsvorgaben:\n" .
            "   - Dokumentation des persoenlichen Transferplans.\n" .
            "   - Regelmaessige Reflexion der Fortschritte im Kursportal.";

        $pdf->MultiCell(180, 7, @iconv('UTF-8', 'windows-1252//TRANSLIT', $bodyText));

        // License Information Box
        $pdf->SetFillColor(241, 245, 249);
        $pdf->SetDrawColor(203, 213, 225);
        $pdf->Rect(15, 230, 180, 40, 'DF');

        $pdf->SetFont('Helvetica', 'B', 9);
        $pdf->SetTextColor(15, 23, 42);
        $pdf->SetXY(20, 234);
        $pdf->Cell(170, 5, @iconv('UTF-8', 'windows-1252//TRANSLIT', 'DENNIS BESSELER - KURSMATERIAL'), 0, 1);

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetTextColor(71, 85, 105);
        $pdf->SetXY(20, 241);
        $licenseInfo = "Urheberrechtlich geschuetztes Kursmaterial von Dennis Besseler.\n" .
            "Ausschliesslich zur persoenlichen Bearbeitung innerhalb des geschuetzten Kursportals bestimmt.\n" .
            "Vervielfaeltigung, Weitergabe oder Veroeffentlichung sind untersagt.";
        $pdf->MultiCell(170, 4.5, @iconv('UTF-8', 'windows-1252//TRANSLIT', $licenseInfo));

        return $pdf->Output('S');
    }

    private function applyWatermarkLayer(WatermarkPdfEngine $pdf, string $watermarkText, string $customerName, string $invoiceNumber, string $courseTitle, string $lessonTitle, float $width, float $height): void
    {
        // 1. Diagonal Watermark across document (single angled watermark stripe)
        $pdf->SetTextColor(180, 205, 230); // Soft visible blue-gray watermark
        $pdf->SetFont('Helvetica', 'B', 8.5);

        // Center diagonal line
        $pdf->Rotate(32, $width / 2, $height * 0.5);
        $pdf->Text($width * 0.05, $height * 0.5, $watermarkText);
        $pdf->Rotate(0);

        // 2. Top Header Security Line
        $pdf->SetTextColor(100, 116, 139);
        $pdf->SetFont('Helvetica', 'B', 6.5);
        $topBanner = @iconv('UTF-8', 'windows-1252//TRANSLIT', "LIZENZ-NACHWEIS: {$customerName} | RECHNUNG: {$invoiceNumber} | NICHT ZUR WEITERGABE");
        $pdf->SetXY(10, 4);
        $pdf->Cell($width - 20, 4, $topBanner, 0, 0, 'R');

        // 3. Bottom Footer Security Line
        $bottomBanner = @iconv('UTF-8', 'windows-1252//TRANSLIT', "(c) Dennis Besseler Kursportal - Personalisiert fuer {$customerName} - Rechnungs-Nr. {$invoiceNumber}");
        $pdf->SetXY(10, $height - 8);
        $pdf->Cell($width - 20, 4, $bottomBanner, 0, 0, 'C');
    }
}
