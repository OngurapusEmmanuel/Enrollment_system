<?php
$servername = " localhost:3306"; // Or your hosted server address
$username = "bethelme_Emmanueltech"; // Your database username
$password = "Emmerhnuel@4"; // Your database password
$dbname = "bethelme_Bethel"; // Your database name

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";
?>

<?php

// $host = 'localhost';
// $user = 'root';
// $pwd = '';
// $db = 'enrollment';

// $con = new mysqli($host, $user, $pwd, $db);

// if ($con->connect_errno) {
//     die("Connection failed: " . $con->connect_error);
// }

?>
