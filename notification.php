
<?php
  
   require_once("includes/config.php");
   
   if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Handle post notification
  $title = $_POST['title'];
  $content = $_POST['content'];

if ($con) {
    $stmt = $con->prepare("INSERT INTO notifications (`Title`, `Notification`) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $content);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Notification updated successfully!');</script>";
        // header('Location:admin-dashboard.php');
    } else {
        echo "<script>alert('Error updating user.');</script>";
    }
    $stmt->close();

}
$con->close();
}
?>
