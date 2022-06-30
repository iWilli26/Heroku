<?php

$host = "localhost";
$username = "root";
$password = "";
$dbname = "heroku";
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
echo 'fuck';
}
switch ($_SERVER["REQUEST_METHOD"]) {
    case 'GET':
$sql = "SELECT * FROM achats, products,facture WHERE facture.facture_id= 1 AND facture.user_id=achats.user_id AND
facture.date=achats.date AND achats.products_id=products.products_id";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
while ($row = mysqli_fetch_assoc($result)) {
$array_values[] = $row;
}
}
echo json_encode($array_values);
$conn->close();}