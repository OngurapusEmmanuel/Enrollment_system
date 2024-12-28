<?php
// Database connection
require_once("includes/config.php");

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT name, program, status, start_date, end_date FROM your_table WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

echo json_encode($data);

$stmt->close();
$conn->close();
?>
