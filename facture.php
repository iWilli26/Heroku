<?php
$host         = "localhost";
$username     = "root";
$password     = "";
$dbname       = "heroku";
$conn = mysqli_connect($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection to database failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM achats, products,facture WHERE facture.facture_id= 1 AND facture.user_id=achats.user_id AND facture.date=achats.date AND achats.products_id=products.products_id";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $array_values[] = $row;
    }
}
echo json_encode($array_values);
$conn->close();
// require('fpdf.php');
// $pdf = new FPDF();
// $pdf->AddPage();
// $pdf->SetMargins(0, 0, 0);
// $pdf->SetFont('Arial', 'B', 25);
// $pdf->Image('./header.png', 0, 0, 210, 40);
// $pdf->Cell(80);
// $pdf->Cell(80, 30, 'INVOICE', 1, 0, 'C');
// $pdf->SetFont('Arial', 'B', 16);
// $pdf->Cell(60, 30, $res, 1);
// $pdf->Output();