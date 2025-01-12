<?php
require_once("includes/config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

   
        // Add user logic
        $firstname = htmlspecialchars($_POST["firstName"]);
        $lastname = htmlspecialchars($_POST["lastName"]);
        $phone = htmlspecialchars($_POST["phoneNumber"]);
        $role = htmlspecialchars($_POST["userRole"]);
        $status = htmlspecialchars($_POST["userStatus"]);
        $email = htmlspecialchars($_POST["userEmail"]);
        $password = htmlspecialchars($_POST["password"]);
        $hashedpwd = password_hash($password, PASSWORD_BCRYPT);
        $first_login=1;

        if ($con) {
            $stmt = $con->prepare("INSERT INTO users(`Firstname`, `Lastname`, `Email`, `Phone Number`, `Role`, `Status`, `Password`,`First_login`) VALUES(?,?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('sssssssi', $firstname, $lastname, $email, $phone, $role, $status, $hashedpwd,$first_login);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                echo "<script>alert('User created successfully!');</script>";
            } else {
                echo "<script>alert('Error creating user.');</script>";
            }
            $stmt->close();
        }
    }
    ?>