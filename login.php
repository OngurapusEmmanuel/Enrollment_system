<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Client-Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" href="images/statue.jpg" type="image/x-icon">
</head>

<body>

    <?php
if ($_SERVER["REQUEST_METHOD"]==="POST") {
	$email = ($_POST["email"]);
	$password = ($_POST["password"]);
	require_once "includes/config.php";
	$con;
	if ($con) {
		$stmt = $con->prepare("SELECT id,Firstname, Password FROM user WHERE Email = ?");
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($id,$Firstname, $Password);
		while ($stmt->fetch()) {
			$pw = $Password;
			$name = $Firstname;
            $Login_id=$id;
		}
		$numRows = $stmt->num_rows;
		if ($numRows === 0) {
			$error="email not found";
		} else {
			// if (password_verify($P assword, $pw) == false) {
            if($password!=$pw){
				echo "invalid password! Try again";
			} else {
				require_once "includes/sessions.php";
				$_SESSION["id"] = $login_id;
				$_SESSION["name"] = $name;
				header("Location:index.php?id=" . $login_id);
			}
		}
	} else {
		echo "server prob";
	}
}
?>

    <!-- client login form -->
    <div class="container">
        <form action="" method="post">
                <!-- <div class="error"><?php 
                //echo $error;
                 ?> </div> -->

            <div class="imgcontainer">
                <img src="images/user.png" alt="Avatar" class="avatar">
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
                <!-- <button type="button" class="cancelbtn" onclick="window.location.href='index.php'">
                    Cancel
                </button> -->
                <!-- <span class="psw">Forgot <a href="#">password?</a></span> -->
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