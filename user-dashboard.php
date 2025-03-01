
<?php
// Include necessary files
include('includes/config.php');
include('includes/sessions.php');

// Check if user is logged in
if (!isset($_SESSION['name'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Get user data securely using prepared statements
$username = $_SESSION['name'];
$sql = "SELECT * FROM users WHERE `Firstname` = ?";
$stmt = $con->prepare($sql);

if ($stmt) {
    // Bind parameters and execute the statement
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();
        
        // Check if it's the first login
        $isFirstLogin = $user['First_login'] == 1;
    } else {
        // If user not found, handle the error
        echo "User not found.";
        exit();
    }

    $stmt->close();
} else {
    // If the statement preparation fails
    echo "Failed to prepare the SQL statement.";
    exit();
}
?>

<?php
// require_once("includes/sessions.php");

// if (!isset($_SESSION["name"])) {
//     header("Location: login.php");
//     exit();
// }

// Include the database connection configuration
include('includes/config.php');

// Fetch notifications from the database (initially, when the page loads)
$sql = "SELECT *FROM notifications";
$stmt = $con->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

function getRecordCount($table) {
    global $con;
    $stmt = $con->prepare("SELECT COUNT(*) FROM $table");
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return $count;
}

function getEnrollerRecordCount($table,$id) {
    global $con;
    $stmt = $con->prepare("SELECT COUNT(*) FROM $table WHERE enroller_id=?");
    $stmt->bind_param(i,$id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return $count;
}
?>
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="icon" href="images/bethel.png" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

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
</head>
<body>
<script>
    // Show the modal if it's the first login
    document.addEventListener('DOMContentLoaded', function () {
        <?php if ($isFirstLogin): ?>
        var myModal = new bootstrap.Modal(document.getElementById('updatePasswordModal'));
        myModal.show();
        <?php endif; ?>
    });
</script>

<!-- Modal -->
<div class="modal fade" id="updatePasswordModal" tabindex="-1" aria-labelledby="updatePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updatePasswordModalLabel">Update Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updatePasswordForm" method="post" action="update-password.php">
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>


    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include 'user_nav.php' ?>

            <!-- Main Content -->
            <main class="col-md-9 col-lg-10 ms-sm-auto px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
                    <h1 class="h2">Welcome,<?php echo $_SESSION["name"]; ?></h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="index.php" class="nav-link">  <button class="btn btn-sm btn-outline-secondary">Edit Profile</button>
                    </a>
                    </div>
                </div>

                <!-- Overview Section -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Total Clients</h5>
                                <p class="card-text display-4"><?php echo getRecordCount('clients'); ?></p>
                           
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Clients Enrolled</h5>
                                <p class="card-text display-4"><?php echo getEnrollerRecordCount('clients',$_SESSION['id']); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Pending Approvals</h5>
                                <p class="card-text display-4"><?php echo getRecordCount('clients'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Client Enrollments Section -->
                
                <div class="card mb-4">
                    <div class="card-header">
                        Recent Client Enrollments
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Phone Number</th>
                                    <th>Age</th>
                                    <th>Parent Name</th>
                                    <th>Disabilty</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <?php
    require_once("includes/config.php");

    // Check if the connection is established
    if ($con) {
        $x = 5;

        // Prepare the statement to select data from the 'exhibits' table
        $stmt = $con->prepare("
            SELECT Id,First_name,Last_name,Email,Phone_no,Age,Parent_name,Disabilities 
            FROM clients
        ");

        // Execute the statement
        $stmt->execute();

        // Bind the results to variables
        $stmt->bind_result($Id,$firstname, $lastname, $email, $phone, $age, $parent,$disability);

        // Fetch the data and display it in the table
        while ($stmt->fetch()) {
            echo "
            <tr>
                <td>{$Id}</td>
                <td>{$firstname}</td>
                <td>{$lastname}</td>
                <td>{$email}</td>
                <td>{$phone}</td>
                <td>{$age}</td>
                <td>{$parent}</td>
                <td>{$disability}</td>
                <td>
                   
                </td>
            </tr>
            ";
            // $x++;
        }
    }
        ?>
                                    <td>
                                        <button class="btn btn-sm btn-primary">View</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
                </div>

                <!-- <h5>Filter Enrollments</h5> -->
    <!—Notification List Section -->
<section id="notification-list">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h2>Posted Notifications</h2>
    </div>

    <div class="card">
        <div class="card-header">
            Reports
        </div>
        <div class="card-body">
        <table class="table table-striped" id="notificationTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Content</th>
                </tr>
            </thead>
            <tbody>
                <?php
             require_once("includes/config.php");
             
                    
                    if($con){
                        $stmt = $con->prepare("SELECT `id`,`title`,`content`FROM notifications");
                        
                        if ($stmt->execute()) {
                         // Bind the result to a variable
                         $stmt->bind_result($Id,$Title,$Notification);
                       
                while ($stmt->fetch()) {
                    echo "
                    <tr>
                    <td>$Id</td>
                    <td>$Title</td>
                    <td>$Notification</td>
                     </tr>
                     ";
                }
            }}
                ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
            </main>
        </div>
    </div>
  


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
   
    <script>
        // Function to fetch notifications using AJAX
        function fetchNotifications() {
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "fetch_notifications.php", true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    const notifications = JSON.parse(xhr.responseText);
                    const notificationList = document.getElementById("notification-list");
                    notificationList.innerHTML = ""; // Clear the existing notifications

                    // Add new notifications to the list
                    notifications.forEach(notification => {
                        const listItem = document.createElement("li");
                        listItem.classList.add("list-group-item");
                        listItem.innerHTML = `${notification.message}`;
                        notificationList.appendChild(listItem);
                    });
                }
            };
            xhr.send();
        }

        // Fetch notifications every 30 seconds
        setInterval(fetchNotifications, 30000);

        // Initial fetch when the page loads
        fetchNotifications();
    </script>
</body>
</html>