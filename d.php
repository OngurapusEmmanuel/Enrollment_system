<?php


require('includes/config.php');
// require('includes/sessions.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
//   echo "Form submitted.<br>";
    $email = $_POST["email"];
    $password = $_POST["password"];
    // echo "Email: $email<br>";

    if ($con) {
        $sql = "SELECT `Firstname`, `Password`, `Role`, `First_login` FROM users WHERE `Email` = ? ";
// echo "SQL Query: " . $sql;

$stmt = $con->prepare($sql);
if (!$stmt) {
    die("SQL Error: " . $con->error);
}
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
         $stmt->bind_result($Firstname, $Password, $Role, $First_login);
        $stmt->fetch();

        if ($stmt->num_rows === 0) {
            $_SESSION['error'] = "Email not found!";
            header("Location: login.php");
            exit();
        }


        if (!password_verify($password, $Password)) {
            $_SESSION['error'] = "Invalid password!";
            header("Location: login.php");
            exit();
        }else{

        $_SESSION["name"] = $Firstname;
        $_SESSION["role"] = $Role;
        $_SESSION["email"] = $email;

        if ($Role === "admin" || $Role === "moderator") {
            header("Location: admin-dashboard.php");
            exit();
        } elseif ($Role === "user") {
            $_SESSION["first_login"] = $First_login;

            if ($First_login == 1) {
                header("Location: update_password.php");
                exit();
            } else {
                header("Location: user-dashboard.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Invalid role!";
            header("Location: login.php");
            exit();
        }
        }
    } else {
        die("Database connection failed: " . $con->connect_error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" href="images/statue.jpg" type="image/x-icon">
</head>

<body>

    <!-- client login form -->
    <div class="container">
        <form  method="post">
           
            <div class="imgcontainer">
                <img src="images/user.png" alt="Avatar" class="avatar">
            </div>

            <div class="container">
                <label for="email"><b>Email</b></label>
                <input type="email" placeholder="Enter Email" id="email" name="email" required>

                <label for="password"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" id="password" required>

                <button type="submit" name="submit">Login</button>
                <label>
                    <input type="checkbox" checked="checked" name="remember"> Remember me
                </label>&nbsp;
                <u class="custom-switch btn">
                    <input type="checkbox" class="custom-control-input" onclick="showPass()" id="customSwitches">
                    <label class="custom-control-label" for="customSwitches">Show Password</label>
                </u>
            </div>

            <div class="container" style="background-color:#fff">
                <button type="button" class="cancelbtn" onclick="window.location.href='index.php'">
                    Cancel
                </button>
                <span class="psw"><a href="#">Forgot password?</a></span>
            </div>
        </form>
    </div>

    <script>
    function showPass() {
        var x = document.getElementById("pass");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    </script>

</body>

</html>