<?php 
// require_once("includes/sessions.php");

// if (isset($_SESSION["name"])) {

//   header("Location:index.php");
 
// }
// else {
//     header("Location:login.php");
// }


// if (isset($_GET["logout"])) {
//    session_destroy();
//    header("Location:login.php");
//    exit;
// }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        <?php
        //  echo $_SESSION["name"];
         ?>
    </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/dashboard.css">
    <link rel="icon" href="favicon.ico">
    <script src="https://kit.fontawesome.com/2f7569df82.js" crossorigin="anonymous"></script>
    <link rel = "icon"
    href = "public/images/statue.jpg"
    type = "image/x-icon">
     <!-- Bootstrap CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            color: white;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
        }
        .sidebar a:hover {
            text-decoration: underline;
        }
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
    <script>
        // JavaScript to handle menu clicks and animation
        document.addEventListener('DOMContentLoaded',()=>{
        Function showSection(sectionId) {
            Const sections = document.querySelectorAll('.content-section');
            Sections.forEach(section => {
                Section.classList.remove('active');
            });
            Const activeSection = document.getElementById(sectionId);
            if (activeSection) {
                activeSection.classList.add('active');
            }
            
        }
    });
    </script>

</head>
<body>
<?php include 'user_nav.php' ?>
<!-- Sidebar -->
 

<!-- Main Content  -->
    <div class=”content”>
        <!-- Home Section -->
        <div id="section1" class="content-section active">
            <h1>Welcome,  <?php
            //  echo $_SESSION["name"];
              ?>!</h1>
            <p>This is the home section of your dashboard.</p>
        </div>

        <!-- Profile Section -->
        <div id="section2" class="content-section">
            <h1>My Profile</h1>
            <div class="col-sm-10" style="font-weight: bold; padding-bottom: 30px;">
            <?php
                require_once("includes/config.php");
                $con;
                if ($con) {
                    $stmt = $con->prepare("
                    SELECT Firstname, Lastname,
                    Email, PhoneNumber,Role
                    FROM users WHERE Firstname= ?");
                    $stmt->bind_param('s', $_SESSION['name']);
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($cfn, $cln, $ce, $cph,$role);
                    while ($stmt->fetch()) {
                        $first_name = $cfn;
                        $last_name = $cln;
                        $email = $ce;
                        $phone_no = $cph;
                        $role=$role;
                      
                    }
                    if(!$phone_no){
                        $phone_no = "<span class='text-muted'>Not given</span>";
                    }
                    echo
                    "
                        <h1>Your Profile</h1>
                        <p>First Name: {$first_name}</p>
                        <p>Last Name: {$last_name}</p>
                        <p>Email: {$email}</p>
                        <p>Phone number: {$phone_no}</p>
                        <p>Role: {$role}</p>
                        <button onclick='window.location.href=`client_dashboard.php?q=updateinfo`'
                        class='btn btn-primary btn-lg'>Update info</button>
                    ";
                }
            ?>

<div class="col-sm-10" style="font-weight: bold; padding-bottom: 30px;">
            <?php
                require_once("includes/config.php");
                $con;
                if ($con) {
                    $stmt = $con->prepare("
                    SELECT Firstname, Lastname,
                    Email, PhoneNumber,Role
                    FROM user WHERE Firstname= ?");
                    $stmt->bind_param('s', $_SESSION['name']);
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($cfn, $cln, $ce, $cph,$role);
                    while ($stmt->fetch()) {
                        $first_name = $cfn;
                        $last_name = $cln;
                        $email = $ce;
                        $phone_no = $cph;
                        $role=$role;
                    }
                    echo
                    "
                        <h1>Update Profile</h1><br>
                        <form action='' method='post'>
                            <label for='fname'>
                                First Name:
                            </label>
                            <input type='text' class='form-control' value='{$first_name}'
                            placeholder='First name' name='fname' required><br>

                            <label for='lname'>
                                Last Name:
                            </label>
                            <input type='text' class='form-control' value='{$last_name}'
                            placeholder='Last name' name='lname' required><br>

                            <label for='lname'>
                                Email:
                            </label>
                            <input type='text' class='form-control' value='{$email}'
                            placeholder='email' name='email' required><br>

                            <label for='phone'>
                                Phone no:
                            </label>
                            <input type='number' class='form-control' value='{$phone_no}'
                            placeholder='Phone no' name='phone_no'><br>

                            <label for='add'>
                                Address:
                            </label>
                            <input type='text' class='form-control' value='{$role}'
                            placeholder='Address' name='address'><br>

                            <button class='btn btn-primary btn-lg btn-block' type='submit' name='update-info'>
                                Update info
                            </button>
                        </form>
                    ";
                }
            ?>

        </div>

        <!-- Settings Section -->
        <div id="section3" class="content-section">
            <h1>Settings</h1>
            <p>Configure your account settings here.</p>
        </div>

        <div>
        <h1>Settings</h1>
        <div class="features-slider-wrap" data-aos="fade-up" data-aos-delay="100">
				<div class="features-slider" id="features-slider">

					<div class="item">

						<div class="feature bg-color-1">
							<img src="images/#" class="img-fluid w-50 rounded-circle mb-4">

							<h3 class="mb-0">Community Projects</h3>
							<span class="text-black-50 mb-3 d-block"> Director</span>
						</div>

					</div>

					<div class="item">

						<div class="feature bg-color-2">
							<!-- <img src="images/#" class="img-fluid w-50 rounded-circle mb-4"> -->

							<h3 class="mb-0">Community Empowerment</h3>
							<!-- <span class="text-black-50 mb-3 d-block">Programs manager</span> -->
							

						</div>

					</div>

					<div class="item">

						<div class="feature bg-color-3">
							<!-- <img src="images/#" class="img-fluid w-50 rounded-circle mb-4"> -->

							<h3 class="mb-0">Community Advocacy</h3>
							<!-- <span class="text-black-50 mb-3 d-block">Programs officer</span>
							 -->

						</div>

					</div>

					<div class="item">

						<div class="feature bg-color-4">
							<!-- <img src="images/#" class="img-fluid w-50 rounded-circle mb-4"> -->

							<h3 class="mb-0">Health Care</h3>
							<!-- <span class="text-black-50 mb-3 d-block">Finance Manager</span> -->
							
						</div>

					</div>

					<div class="item">

						<div class="feature bg-color-5">
							<!-- <img src="images/#" class="img-fluid w-50 rounded-circle mb-4"> -->

							<h3 class="mb-0">Skills Development</h3>
							<!-- <span class="text-black-50 mb-3 d-block">Field officer</span> -->
							
						</div>

					</div>
					<div class="item">

						<div class="feature bg-color-5">
							<!-- <img src="images/#" class="img-fluid w-50 rounded-circle mb-4"> -->

							<h3 class="mb-0">Youth Empowerment</h3>
							<!-- <span class="text-black-50 mb-3 d-block">Finance officer</span> -->
							
						</div>

					</div>

				</div>
			</div>
            </div>
    </div>


</body>


</html>
