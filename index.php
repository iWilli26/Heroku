<?php
$cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$cleardb_server = $cleardb_url["host"];
$cleardb_username = $cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb_db = substr($cleardb_url["path"], 1);
$active_group = 'default';
$query_builder = TRUE;
$conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);

if ($conn->connect_error) {
    die("Connection to database failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM `facture` WHERE 1";
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="/index.js" defer></script>

    <title>HAHAHAHAHAHAHAHAHAHAA</title>
</head>

<body>
    <?php

    for ($i; $i < count($res); $i++) {
        echo '
            <a href="https://hdm-fpdf.herokuapp.com/facture.php?id=".$res[0]["facture_id"]>Facture' . $res[0]["facture_id"] . '</a>
            ';
    }

    ?>
</body>

</html>