<?php
// require_once "includes/sessions.php";
// if (isset($_SESSION["name"])) {
//  $_SESSION["name"] = null;
// }
session_start();
session_unset();
session_destroy();
header("Location: login.php");
exit;

?>
