<?php
require_once "includes/sessions.php";
if (isset($_SESSION["name"])) {
 $_SESSION["name"] = null;
}
session_destroy();
header("Location: index.php");
