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
    <link rel="icon" href="images/bethel.png" type="image/x-icon">
</head>

<body>
<?php
include_once('includes/sessions.php');
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    include_once ('includes/config.php');

    if ($con) {
        $stmt = $con->prepare("SELECT `Id`,Firstname, `Password`, `Role`, `First_login` FROM users WHERE Email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 0) {
            $_SESSION['error'] = "Email not found!";
            header("Location: login.php");
            exit();
        }

        $stmt->bind_result($Id,$Firstname, $Password, $Role, $First_login);
        $stmt->fetch();

        // if (!password_verify($password, $Password))
        if (!password_verify($password, $Password))
         {
            $_SESSION['error'] = "Invalid password!";
            header("Location: login.php");
            exit();
        }

        if ($Role === "admin" || $Role === "moderator") {
            $_SESSION["name"] = $Firstname;
            $_SESSION["role"] = $Role;
            header("Location: admin-dashboard.php");
            exit();
        } elseif ($Role === "user") {
            $_SESSION["id"]=$Id;
            $_SESSION["name"] = $Firstname;
            $_SESSION["role"] = $Role;
            $_SESSION["first_login"] = $First_login;
            $_SESSION["email"]=$email;
            
            // Check if it's the first login
            if ($First_login == 1) {
                header("Location: update_password.php");  // Redirect to password update page
                exit();
            } else {
                header("Location: user-dashboard.php");  // Regular user dashboard
                exit();
            }
        } else {
            $_SESSION['error'] = "Invalid role!";
            header("Location: login.php");
            exit();
        }
    } else {
        die("Database connection failed: " . mysqli_connect_error());
    }
}
?>



    <!-- client login form -->
    <div class="container">
        <form action="" method="post">
           
            <div class="imgcontainer">
                <img src="images/bethel.png" alt="Avatar" class="avatar">
            </div>

            <div class="container">
                <label for="email"><b>Email</b></label>
                <input type="email" placeholder="Enter Email" name="email" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" id="pass" required>

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