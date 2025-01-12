<?php
require_once("includes/config.php");
if ($con) {
  
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $con->prepare("SELECT * FROM clients WHERE Id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode($data=$result->fetch_assoc());
    } else {
        echo "$id";
        echo json_encode(["error" => "Client not found"]);
    }

    $stmt->close();
    $con->close();
} else {
    echo json_encode(["error" => "Invalid request"]);
}
}
else {
    echo "server problem";
}
?>
