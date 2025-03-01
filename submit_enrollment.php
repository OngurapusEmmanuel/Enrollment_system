<?php
require_once('includes/config.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
 // Get form data
 $firstname = $_POST['firstname'];
 $lastname = $_POST['lastname'];
 $email = $_POST['email'];
 $phone = $_POST['phone'];
 $parent_name = $_POST['parent_name'];
 $age = $_POST['age'];
 $gender = $_POST['gender'];
 $education = $_POST['education'];
 $category = $_POST['category'];
 $disabilities = isset($_POST['disabilities']) ? implode(", ", $_POST['disabilities']) : '';
 $disability_certificate = $_POST['disability_certificate'];
 $support = isset($_POST['support']) ? implode(", ", $_POST['support']) : '';
 $bpl = $_POST['bpl'];
 $parent_occupation = $_POST['parent_occupation'];
 $guardian_name = $_POST['guardian_name'];
 $guardian_relation = $_POST['guardian_relation'];
 $health_insurance = $_POST['health_insurance'];
 $status = "pending";
 $enroller_id=$_POST[$_SESSION['id']];

 if ($con) {
    $stmt = $con->prepare("INSERT INTO clients (`First_name`, `Last_name`, `Email`, `Phone_no`,`Parent_name`, `Age`, `Gender`, `Education`, `Category`, `Disabilities`, `Disability_certificate`, `Support`, `Bpl`, `Parent_occupation`, `Guardian_name`, `Guardian_relation`, `Health_insurance`,`Enroller_id`, `Status`)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)");

// Bind parameters
$stmt->bind_param("sssssisssssssssssis", $firstname, $lastname, $email, $phone, $parent_name, $age, $gender, $education, $category, $disabilities, $disability_certificate, $support, $bpl, $parent_occupation, $guardian_name, $guardian_relation, $health_insurance,$enroller_id, $status);

// Execute the statement
if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Client created successfully!"

    ]);
       // Redirect to user dashboard after success
       header("Location: enroll.php");
       exit;  // Make sure to call exit to stop further script execution
} else {
    echo json_encode([
        "success" => false,
        "message" => "Error creating client: " . $con->error
    ]);
}
$stmt->close();
$con->close();
 } else {
    echo json_encode([
        "success" => false,
        "message" => "Database connection error."
    ]);

}
}
?>