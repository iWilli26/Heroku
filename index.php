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
$sql = "SELECT * FROM facture, user WHERE facture.user_id=user.user_id";
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
?>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>HAHAHAHAHAHAHAHAHAHAA</title>
</head>

<body>
    <?php
    // $element = ;
    for ($i; $i < 5; $i++) {
        echo '<a href="https://hdm-fpdf.herokuapp.com/facture.php?id=".$res[0]["facture_id"]>Facture de' . $res[0]["prenom"] . " " . $res[0]["nom"] . '</a></br>';
    }


    ?>
</body>

</html>