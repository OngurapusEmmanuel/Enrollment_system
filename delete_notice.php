<?php
require_once("includes/config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Check if the user ID is valid and exists in the database
        if ($con) {
            // Prepare the SQL query to delete the user
            $stmt = $con->prepare("DELETE FROM notifications WHERE id = ?");
            $stmt->bind_param("i", $id); // 'i' for integer type

            // Execute the query and check if the user was deleted
            if ($stmt->execute()) {
                echo "<script>
                alert('Notice deleted successfully!');
                </script>";
            } else {
                echo "Error deleting notice: " . $con->error;
            }
            $stmt->close();
        }
    }
    $con->close();
} else {
    echo "Invalid request.";
}
?>