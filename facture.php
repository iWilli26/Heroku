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
$count = count($res);
$pdf = new FPDF();

//Header
$pdf->AddPage();
$pdf->SetMargins(0, 0, 0);
$pdf->SetFont('Arial', 'B', 16);
$pdf->Image('./header.png', 0, 0, 210, 45);

//En tête de la facture
$pdf->SetXY(20, 55);
$pdf->MultiCell(55, 10, "Invoice to: \n", 0, 'L', false);
$pdf->SetFont('Arial', '', 12);
$pdf->SetXY(20, 63);
$pdf->Multicell(55, 10, $res[0]["nom"] . ' ' . $res[0]['prenom']);
$pdf->SetXY(20, 70);
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
$pdf->Multicell(170, 15, "Price (euro)", 0, 'L', false);
$pdf->setXY(145, 105);
$pdf->Multicell(170, 15, "Qty.", 0, 'L', false);
$pdf->setXY(170, 105);
$pdf->Multicell(170, 15, "Total", 0, 'L', false);

//Remplissage du tableau
for($i=0;$i<5;$i++){
    if($i==5){
        break;
    }
    $pdf->SetDrawColor(75, 75, 75);
    $pdf->SetLineWidth(0.3);
    $pdf->Line(20, 135+$i*15, 190, 135+$i*15);
    if($i<$count){
        $pdf->setXY(20, 120+$i*15);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Multicell(170, 15, $i+1 ."", 0, 'L', false);
        $pdf->setXY(50, 120+$i*15);
        $pdf->Multicell(170, 15, $res[$i]["description"], 0, 'L', false);
        $pdf->setXY(120, 120+$i*15);
        $pdf->Multicell(170, 15, $res[$i]["prix"], 0, 'L', false);
        $pdf->setXY(145, 120+$i*15);
        $pdf->Multicell(170, 15, $res[$i]["quantite"], 0, 'L', false);
        $pdf->setXY(170, 120+$i*15);
        $pdf->Multicell(170, 15, $res[$i]["prix"]*$res[$i]["quantite"], 0, 'L', false);
    }
}
$pdf->setXY(20, 200);
$pdf->MultiCell(170, 15, "Thank you for your business", 0, 'L', false);

//Recap paiement
$pdf->setXY(140, 200);
$pdf->MultiCell(70, 15, "Sub Total :");
$pdf->setXY(140, 210);
$tax=0;
$pdf->MultiCell(70, 15, "Tax(0%) :");
$pdf->setXY(165, 200);
$total=0;
for($i=0;$i<$count;$i++){
    $total+=$res[$i]["prix"]*$res[$i]["quantite"];
}
$pdf->MultiCell(35, 15, $total);
$pdf->setXY(165, 210);
$pdf->MultiCell(70, 15, $total*$tax, 0, 'L', false);
$pdf->SetLineWidth(0.5);
$pdf->Line(140, 225, 190, 225);
$pdf->setXY(140, 225);
$pdf->SetFont('Arial', 'B', 16);
$pdf->MultiCell(70, 15, "Total :");
$pdf->setXY(165, 225);
$pdf->MultiCell(25, 15, $total*$tax+$total,0,'L',false);
$pdf->Output();

//Payment Info
$pdf->setXY(20, 225);
$pdf->Cell(55, 10, "Payment Info :");
$pdf->SetFont('Arial', '', 12);
$pdf->setXY(20, 235);
$pdf->MultiCell(55, 10, "Account # : " . $res[0]["user_id"]);
$pdf->setXY(20, 240);
$pdf->MultiCell(55, 10, "A/C Name : " . $res[0]["banque"]);