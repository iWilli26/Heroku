<?php
class pdf extends FPDF
{
    // Get Heroku ClearDB connection information
    // $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
    // $cleardb_server = $cleardb_url["host"];
    // $cleardb_username = $cleardb_url["user"];
    // $cleardb_password = $cleardb_url["pass"];
    // $cleardb_db = substr($cleardb_url["path"], 1);
    // $active_group = 'default';
    // $query_builder = TRUE;
    // // Connect to DB
    // $conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);
    // if ($conn->connect_error) {
    //     die("Connection to database failed: " . $conn->connect_error);
    // }
    // switch ($_SERVER["REQUEST_METHOD"]) {
    //     case 'GET':
    //         $sql = "SELECT * FROM user";
    //         $result = mysqli_query($conn, $sql);
    //         if (mysqli_num_rows($result) > 0) {
    //             while ($row = mysqli_fetch_assoc($result)) {
    //                 $array_values[] = $row;
    //             }
    //         } else {
    //             echo "0 results";
    //         }
    //         $test = json_encode($array_values);
    //         $conn->close();
    //         break;
    //     }
    function Header()
    {
        // Logo
        $this->Image('logo.jpg', 10, 6, 30);
        // Police Arial gras 15
        $this->SetFont('Arial', 'B', 15);
        // Décalage à droite
        $this->Cell(80);
        // Titre
        $this->Cell(30, 10, 'Titre', 1, 0, 'C');
        // Saut de ligne
        $this->Ln(20);
    }
}
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 25);
$pdf->Cell(80, 30, 'INVOICE', 1, 0, 'C');
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(60, 30, 'Brand name', 1);
$pdf->Output();