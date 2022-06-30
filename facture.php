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

$conn->close();
require('fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetMargins(0, 0, 0);
$pdf->SetFont('Arial', 'B', 16);
$pdf->Image('./header.png', 0, 0, 210, 45);
$pdf->SetXY(20, 55);
$pdf->MultiCell(55, 10, "Invoice to: \n", 0, 'L', false);
$pdf->SetFont('Arial', '', 12);
$pdf->SetXY(20, 63);
$pdf->Multicell(55, 10, $res[0]["nom"] . ' ' . $res[0]['prenom']);
$pdf->SetXY(20, 70);
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(55,10,$res[0]["adresse"]);
$pdf->SetXY(20, 75);
$pdf->Multicell(55,10,$res[0]['ville'], 0, 'L', false);
$pdf->setXY(140, 65);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Multicell(30, 10, "Invoice :\nDate : ", 0, 'L', false);
$pdf->setXY(170, 65);
$pdf->Multicell(30, 10, "#" . $res[0]["facture_id"] . "\n" . $res[0]["date"], 0, 'R', false);
$pdf->setXY(20, 105);
$pdf->SetDrawColor(0, 150, 150);
$pdf->SetLineWidth(0.7);
$pdf->Rect(20, 105, 170, 15);

//En tête du tableau
$pdf->setXY(20, 105);
$pdf->SetFont('Arial', '', 12);
$pdf->Multicell(170, 15, "SL.", 0, 'L', false);
$pdf->setXY(50, 105);
$pdf->Multicell(170, 15, "Item Description", 0, 'L', false);
$pdf->setXY(120, 105);
$pdf->Multicell(170, 15, "Price", 0, 'L', false);
$pdf->setXY(145, 105);
$pdf->Multicell(170, 15, "Qty.", 0, 'L', false);
$pdf->setXY(170, 105);
$pdf->Multicell(170, 15, "Total", 0, 'L', false);

//Remplissage du tableau
for($i=0;$i<count($res);$i++){
    $pdf->setXY(20, 120+$i*15);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Multicell(170, 15, $i."", 0, 'L', false);
    
//     $this->setXY(50, 120+$i*15);
//     $this->Multicell(170, 15, $data[$i]["description"], 0, 'L', false);
//     $this->setXY(120, 120+$i*15);
//     $this->Multicell(170, 15, $data[$i]["prix"]."€", 0, 'L', false);
//     $this->setXY(145, 120+$i*15);
//     $this->Multicell(170, 15, $data[$i]["quantite"]."", 0, 'L', false);
//     $this->setXY(170, 120+$i*15);
//     $this->Multicell(170, 15, $data[$i]["prix"]*$data[$i]["quantite"]."€", 0, 'L', false);
//     $this->SetDrawColor(75, 75, 75);
//     $this->SetLineWidth(0.5);
//     $this->Line(20, 135+$i*15, 190, 135+$i*15);
}



$pdf->Output();