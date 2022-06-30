<?php
// echo $_GET['id'];	
$host         = "localhost";
$username     = "root";
$password     = "";
$dbname       = "heroku";
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    echo 'fuck';
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


require('fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetMargins(0, 0, 0);
$pdf->SetFont('Arial', 'B', 25);
$pdf->Image('./header.png', 0, 0, 210, 40);
$pdf->Output();