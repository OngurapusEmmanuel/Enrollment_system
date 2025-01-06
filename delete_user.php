<?php
require_once("includes/config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['id'])) {
        $userId = $_POST['id'];

        // Check if the user ID is valid and exists in the database
        if ($con) {
            // Prepare the SQL query to delete the user
            $stmt = $con->prepare("DELETE FROM users WHERE Id = ?");
            $stmt->bind_param("i", $userId); // 'i' for integer type

            // Execute the query and check if the user was deleted
            if ($stmt->execute()) {
                echo "<script>
                alert('User deleted successfully!');
                </script>";
            } else {
                echo "Error deleting user: " . $con->error;
            }
            $stmt->close();
        }
    }
    $con->close();
} else {
    echo "Invalid request.";
}
?>
