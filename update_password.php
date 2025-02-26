<?php

include_once('includes/sessions.php');
require_once 'includes/config.php';

// Redirect if the user is not logged in
if (!isset($_SESSION["name"])) {
    header("Location: login.php");
    exit();
}

// Handle form submission to update password
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        $_SESSION['error'] = "Passwords do not match!";
        header("Location: update-password.php");
        exit();
    }

    // Hash the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update the password in the database
    $email = $_SESSION['email']; // Assuming email is stored in session after login
    $stmt = $con->prepare("UPDATE users SET Password = ?, First_login = 0 WHERE Email = ?");
    $stmt->bind_param('ss', $hashedPassword, $email);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Password updated successfully!";
        header("Location: user-dashboard.php"); // Redirect to user dashboard after successful password update
        exit();
    } else {
        $_SESSION['error'] = "Error updating password!";
        header("Location: update-password.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" href="images/bethel.png" type="image/x-icon">
</head>
<body>

<div class="container">
    <h2>Update Your Password</h2>

    <?php
    if (isset($_SESSION['error'])) {
        echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
        unset($_SESSION['success']);
    }
    ?>

    <form method="POST">
        <div class="form-group">
            <label for="new_password"><b>New Password</b></label>
            <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter new password" required>
        </div>

        <div class="form-group">
            <label for="confirm_password"><b>Confirm Password</b></label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Password</button>
    </form>
</div>

</body>
</html>
