<?php
// Get Heroku ClearDB connection information
$cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$cleardb_server = $cleardb_url["host"];
$cleardb_username = $cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb_db = substr($cleardb_url["path"], 1);
$active_group = 'default';
$query_builder = TRUE;
// Connect to DB
$conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);
if ($conn->connect_error) {
    die("Connection to database failed: " . $conn->connect_error);
}

$id = $_GET['id'];
$sql = "SELECT * FROM achats, products,facture,user WHERE facture.facture_id = " . $_GET['id'] . " AND facture.user_id=achats.user_id AND facture.date=achats.date AND achats.products_id=products.products_id AND facture.user_id=user.user_id";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $array_values[] = $row;
    }
} else {
    echo "0 results";
}

$res = $array_values;
// echo $res[0]['nom'];
$conn->close();

require('fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetMargins(0, 0, 0);
$pdf->SetFont('Arial', 'B', 16);
$pdf->Image('./header.png', 0, 0, 210, 45);
$pdf->SetXY(0, 45);
$pdf->MultiCell(55, 10, "Invoice to: \n", 1, 'L', false);
$pdf->SetFont('Arial', '', 12);
$pdf->Multicell(55, 10, $res[0]["nom"] . ' ' . $res[0]['prenom'] . "\n" . $res[0]["adresse"] . "\n" . $res[0]['ville'], 1, 'L', false);
$pdf->setXY(140, 55);
$pdf->Multicell(30, 10, "Invoice \nDate : ", 1, 'L', false);
$pdf->setXY(175, 55);
$pdf->Multicell(30, 10, "#".$res[0]["facture_id"] . "\n" . $res[0]["date"], 1, 'R', false);
$pdf->setXY(210, 65);
$pdf->Multicell(150, 5, "test1", 1, 'L', false);
$pdf->setXY(210, 70);
$pdf->Multicell(150, 5, "test2", 1, 'L', false);
$pdf->Output();


$conn->close();