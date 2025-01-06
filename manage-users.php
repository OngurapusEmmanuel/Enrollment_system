<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .filter-section {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include 'admin_nav.php' ?>

            <!-- Main Content -->
            <main class="col-md-9 col-lg-10 ms-sm-auto px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
                    <h1 class="h2">Manage Users</h1>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add New User</button>
                </div>

                <!-- Filter Section -->
                <div class="filter-section">
                    <h5>Filter Users</h5>
                    <form class="row g-3">
                        <div class="col-md-6">
                            <label for="roleFilter" class="form-label">Role</label>
                            <select class="form-select" id="roleFilter">
                                <option value="">All</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                                <option value="moderator">Moderator</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="statusFilter" class="form-label">Status</label>
                            <select class="form-select" id="statusFilter">
                                <option value="">All</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-primary">Apply Filters</button>
                        </div>
                    </form>
                </div>

                <!-- Users Table -->
                <div class="card">
                    <div class="card-header">
                        Users
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
    require_once("includes/config.php");

    // Check if the connection is established
    if ($con) {
        $x = 1;

        // Prepare the statement to select data from the 'exhibits' table
        $stmt = $con->prepare("
            SELECT Id,Firstname,Lastname,Email,`Phone Number`,Role,Status 
            FROM users
        ");

        // Execute the statement
        $stmt->execute();

        // Bind the results to variables
        $stmt->bind_result($Id,$firstname, $lastname, $email, $phone, $role, $status);

        // Fetch the data and display it in the table
        while ($stmt->fetch()) {
            echo "
            <tr>
                <td data-Id='" . htmlspecialchars($Id) . "'>{$Id}</td>
                <td data-firstname='" . htmlspecialchars($firstname) . "'>{$firstname}</td>
                <td data-lastname='" . htmlspecialchars($lastname) . "'>{$lastname}</td>
                <td data-email='" . htmlspecialchars($email) . "'>{$email}</td>
                <td data-phone='" . htmlspecialchars($phone) . "'>{$phone}</td>
                <td data-role='" . htmlspecialchars($role) . "'>{$role}</td>
                <td data-status='" . htmlspecialchars($status) . "'>{$status}</td>
                <td>
                <td>
</td>
            </tr>
            ";
           
        }
    }
        ?>
       <td>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal">Edit</button>
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td>2</td>
                                    <td>Jane Smith</td>
                                    <td>jane.smith@example.com</td>
                                    <td>User</td>
                                    <td><span class="badge bg-danger">Inactive</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal">Edit</button>
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </td>
                                </tr> -->
                                <!-- Add more rows as needed -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                  
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
<?php
    if ($_SERVER["REQUEST_METHOD"]==="POST") {
    $firstname= htmlspecialchars($_POST["firstName"]);
    $lastname= htmlspecialchars($_POST["lastName"]);
    $phone= htmlspecialchars($_POST["phoneNumber"]);
    $role= htmlspecialchars($_POST["userRole"]);
    $status= htmlspecialchars($_POST["userStatus"]);
	$email = htmlspecialchars($_POST["userEmail"]);
	$password = htmlspecialchars($_POST["password"]);
 $hashedpwd = password_hash($password, PASSWORD_BCRYPT);
	require_once "includes/config.php";
	if ($con) {
	
    // Insert data into database
    $stmt = $con->prepare("INSERT INTO users(`Firstname`,`Lastname`,`Email`,`Phone Number`,`Role`,`Status`,`Password`)VALUES(?,?,?,?,?,?,?)");

    $stmt->bind_param('sssssss', $firstname, $lastname, $email,$phone,$role,$status,$hashedpwd);
    
    $stmt->execute();
    if ($stmt->affected_rows === -1) {
        echo "Error";
    } else {
     echo "<script>
        alert('User created successfully!');
        
    </script>";
        $stmt->close();
        // alert("User created successfully");
       
        // header("Location: manage-users.php");
    }


}
$con->close();
}
?>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" name="firstName" class="form-control" id="firstName" required>
                        </div>
                        <div class="mb-3">
                            <label for="lastName" class="form-label"> Last Name</label>
                            <input type="text" name="lastName" class="form-control" id="lastName" required>
                        </div>
                        <div class="mb-3">
                            <label for="userEmail" class="form-label">Email</label>
                            <input type="email" name="userEmail" class="form-control" id="userEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="phoneNumber" class="form-label">phone number</label>
                            <input type="number" name="phoneNumber" class="form-control" id="phoneNumber" required>
                        </div>
                        <div class="mb-3">
                            <label for="userRole" class="form-label">Role</label>
                            <select class="form-select" name="userRole" id="userRole">
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                                <option value="moderator">Moderator</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="userStatus" class="form-label">Status</label>
                            <select class="form-select" name="userStatus" id="userStatus">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="pasword" class="form-control" id="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <?php

if ($_SERVER["REQUEST_METHOD"]==="POST") {
    $firstname=($_POST["firstName"]);
    $lastname=($_POST["lastName"]);
    $phone=($_POST["phoneNumber"]);
    $role=($_POST["userRole"]);
    $status=($_POST["userStatus"]);
	$email = ($_POST["userEmail"]);
	$password = ($_POST["password"]);
	require_once "includes/config.php";
	$con;
	
    // Insert data into database
$stmt = $con->prepare( "UPDATE users SET `Email`= ? , `Phone Number` = ? `Role`=? `Status`=? WHERE `Firstname`= ?" );

$stmt->bind_param('sssss',$email, $phone, $role, $status,$firstname);

$stmt->execute();
if ($stmt->affected_rows === -1) {
    echo "Error";
} else {
    echo "<script>
    alert('Infor updated successfully!');
    
</script>";
    $stmt->close();
    // alert("User created successfully");
   
    header("Location: manage-users.php");
}
// $stmt->execute();
// if ( $stmt->execute()) {
//     echo "<script>
//     alert('Infor updated successfully!');
    
// </script>";
// $stmt->close();
// // window.location.href = 'admin-dashboard.php';
// } else {
//     echo "Error: " . $sql . "<br>" . $conn->error;
// }

$con->close();
}
?>

                <div class="modal-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" name="firstName"  value="<?php echo $firstname; ?>" class="form-control" id="firstName">
                        </div>
                        <div class="mb-3">
                            <label for="lastName" class="form-label"> Last Name</label>
                            <input type="text" name="lastName"  value="<?php echo $lastname; ?>" class="form-control" id="lastName">
                        </div>
                        <div class="mb-3">
                            <label for="userEmail" class="form-label">Email</label>
                            <input type="email" name="userEmail"  value="<?php echo $email; ?>" class="form-control" id="userEmail">
                        </div>
                        <div class="mb-3">
                            <label for="phoneNumber" class="form-label">phone number</label>
                            <input type="number" name="phoneNumber"  value="<?php echo $phone; ?>" class="form-control" id="phoneNumber">
                        </div>
                        </div>
                        <div class="mb-3">
                            <label for="editUserRole" class="form-label">Role</label>
                            <select class="form-select" name="userRole" id="editUserRole">
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                                <option value="moderator">Moderator</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editUserStatus" class="form-label">Status</label>
                            <select class="form-select" name="userStatus" id="editUserStatus">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
