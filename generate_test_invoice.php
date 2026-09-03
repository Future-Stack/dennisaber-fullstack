<?php

require __DIR__ . '/vendor/autoload.php';

use FPDF;

class InvoicePDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 16);
        $this->SetTextColor(15, 23, 42);
        $this->Cell(120, 10, 'DENNIS BESSELER', 0, 0, 'L');
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(100, 116, 139);
        $this->Cell(70, 10, 'RECHNUNG', 0, 1, 'R');
        $this->SetDrawColor(226, 232, 240);
        $this->Line(10, 22, 200, 22);
        $this->Ln(8);
    }
}

$pdf = new InvoicePDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(71, 85, 105);

// Sender & Receiver
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(100, 4, 'Dennis Besseler - Aachener Str. 1193 - 50858 Koeln', 0, 1);
$pdf->Ln(2);

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTextColor(15, 23, 42);
$pdf->Cell(100, 5, 'Max Mustermann', 0, 1);
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(51, 65, 85);
$pdf->Cell(100, 5, 'Musterstrasse 12', 0, 1);
$pdf->Cell(100, 5, '50667 Koeln', 0, 1);
$pdf->Cell(100, 5, 'Deutschland', 0, 1);
$pdf->Ln(8);

// Meta Details Table
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(45, 6, 'Rechnungsnummer:', 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(50, 6, 'RN-7X4K-2026', 0, 0);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(45, 6, 'Rechnungsdatum:', 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(50, 6, date('d.m.Y'), 0, 1);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(45, 6, 'Kundennummer:', 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(50, 6, 'KD-2026-8891', 0, 0);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(45, 6, 'Faelligkeit:', 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(50, 6, 'Sofort nach Erhalt', 0, 1);
$pdf->Ln(6);

// Item Table Header
$pdf->SetFillColor(241, 245, 249);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(15, 8, 'Pos.', 1, 0, 'C', true);
$pdf->Cell(115, 8, 'Bezeichnung / Kursleistung', 1, 0, 'L', true);
$pdf->Cell(30, 8, 'USt.', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'Gesamtbetrag', 1, 1, 'R', true);

// Item 1
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(15, 8, '1', 1, 0, 'C');
$pdf->Cell(115, 8, '5-Tage-DNL-Kompaktlehrgang (4 Monate Kurszugang)', 1, 0, 'L');
$pdf->Cell(30, 8, '19 %', 1, 0, 'C');
$pdf->Cell(30, 8, '149,00 EUR', 1, 1, 'R');

// Totals
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(160, 7, 'Nettobetrag:', 0, 0, 'R');
$pdf->Cell(30, 7, '125,21 EUR', 0, 1, 'R');
$pdf->Cell(160, 7, 'Zzgl. 19% MwSt.:', 0, 0, 'R');
$pdf->Cell(30, 7, '23,79 EUR', 0, 1, 'R');

$pdf->SetFont('Arial', 'B', 11);
$pdf->SetTextColor(15, 23, 42);
$pdf->Cell(160, 8, 'Gesamtbetrag (Zahlbetrag):', 0, 0, 'R');
$pdf->Cell(30, 8, '149,00 EUR', 0, 1, 'R');
$pdf->Ln(8);

// Banking Info Block
$pdf->SetDrawColor(56, 189, 248);
$pdf->SetFillColor(248, 250, 252);
$pdf->Rect(10, $pdf->GetY(), 190, 48, 'DF');

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTextColor(2, 132, 199);
$pdf->Cell(190, 7, ' Bankverbindung fuer Ihre Ueberweisung:', 0, 1, 'L');

$pdf->SetFont('Arial', '', 9);
$pdf->SetTextColor(30, 41, 59);
$pdf->Cell(45, 5, ' Kontoinhaber:', 0, 0);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(145, 5, 'Dennis Besseler', 0, 1);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(45, 5, ' IBAN:', 0, 0);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(145, 5, 'DE89 3704 0044 0532 0130 00', 0, 1);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(45, 5, ' BIC:', 0, 0);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(145, 5, 'COBADEFFXXX', 0, 1);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(45, 5, ' Bank:', 0, 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(145, 5, 'Commerzbank AG', 0, 1);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(45, 5, ' Verwendungszweck:', 0, 0);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor(180, 20, 20);
$pdf->Cell(145, 5, 'RN-7X4K-2026 Max Mustermann', 0, 1);

$pdf->SetFont('Arial', 'I', 8);
$pdf->SetTextColor(100, 116, 139);
$pdf->Cell(190, 6, ' Hinweis: Bitte geben Sie den Verwendungszweck exakt so an, um eine sofortige Freischaltung zu gewaehrleisten.', 0, 1);

$pdf->Output('F', __DIR__ . '/public/sample_invoice_dennis_besseler.pdf');
$pdf->Output('F', __DIR__ . '/sample_invoice_dennis_besseler.pdf');

echo "SUCCESS: sample_invoice_dennis_besseler.pdf created!\n";
