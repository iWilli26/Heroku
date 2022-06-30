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
switch ($_SERVER["REQUEST_METHOD"]) {
    case 'GET':
        $sql = "SELECT * FROM user";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $array_values[] = $row;
            }
        } else {
            echo "0 results";
        }

        echo json_encode($array_values);
        $conn->close();
        break;
    }
?>