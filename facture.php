<?php

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 25);
$pdf->Image('./logo.jpg', 10, 6, 30);
$pdf->Cell(80);
$pdf->Cell(80, 30, 'INVOICE', 1, 0, 'C');
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(60, 30, 'Brand name', 1);
$pdf->Output();
?>