<?php
require('fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetMargins(0,0,0);
$pdf->SetFont('Arial', 'B', 25);
$pdf->Image('./header.png',0,0,210,297);
$pdf->Cell(80);
$pdf->Cell(80, 30, 'INVOICE', 1, 0, 'C');
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(60, 30, 'Brand name', 1);
$pdf->Output();