<?php
require_once("includes/config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST['action'] ?? null;

    if ($action === "delete") {
        // Handle delete notification
        $notificationId = intval($_POST['id'] ?? 0);

        if ($notificationId > 0) {
            if ($con) {
                $stmt = $con->prepare("DELETE FROM notifications WHERE id = ?");
                $stmt->bind_param("i", $notificationId);

                if ($stmt->execute()) {
                    echo json_encode([
                        "success" => true,
                        "message" => "Notification deleted successfully!"
                    ]);
                } else {
                    echo json_encode([
                        "success" => false,
                        "message" => "Error deleting notification: " . $con->error
                    ]);
                }
                $stmt->close();
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Database connection error."
                ]);
            }
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Invalid notification ID."
            ]);
        }
    } elseif ($action === "post") {
        // Handle post notification
        $title = $_POST['title'];
        $content = $_POST['content'];

        if (!empty($title) && !empty($content)) {
            if ($con) {
                $stmt = $con->prepare("INSERT INTO notifications `Title`, `Notification`) VALUES (?, ?)");
                $stmt->bind_param("ss", $title, $content);

                if ($stmt->execute()) {
                //    header('location:admin-dashboard.php');

                    echo json_encode([
                        "success" => true,
                        "message" => "Notification posted successfully!"
                    ]);
                } else {
                    echo json_encode([
                        "success" => false,
                        "message" => "Error posting notification: " . $con->error
                       
                    ]);
                }
                $stmt->close();
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Database connection error."
                ]);
            }
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Title and content are required."
            ]);
        }
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Invalid action."
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method."
    ]);
}
?>
