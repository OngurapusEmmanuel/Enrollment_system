<?php
require_once("includes/sessions.php");

if (!isset($_SESSION["name"])) {
    header("Location: login.php");
    exit();
}

// Include the database connection configuration
include('includes/config.php');

// Fetch notifications from the database
$sql = "SELECT * FROM notifications ORDER BY created_at DESC";
$stmt = $con->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Prepare an array to hold the notifications
$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[] = [
        'content' => htmlspecialchars($row['message']),
        // 'created_at' => $row['created_at']
    ] ;
}

// Return the notifications as JSON
echo json_encode($notifications);

// Close the database connection
$stmt->close();
$con->close();
?>
