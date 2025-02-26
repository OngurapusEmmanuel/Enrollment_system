
<?php 
require_once("includes/sessions.php");

if (!isset($_SESSION["name"])) {

  header("Location:login.php");
 exit();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>    
    <link rel="icon" href="images/bethel.png" type="image/x-icon">
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
        html {
    scroll-behavior: smooth;
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
                    <form class="row g-3" method="GET" action="manage-users.php">
    <div class="col-md-6">
        <label for="roleFilter" class="form-label">Role</label>
        <select class="form-select" id="roleFilter" name="roleFilter">
            <option value="">All</option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
            <option value="moderator">Moderator</option>
        </select>
    </div>
    <div class="col-md-6">
        <label for="statusFilter" class="form-label">Status</label>
        <select class="form-select" id="statusFilter" name="statusFilter">
            <option value="">All</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-primary">Apply Filters</button>
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
                            <?php
require_once("includes/config.php");

// Get filter values from the GET request
$roleFilter = isset($_GET['roleFilter']) ? $_GET['roleFilter'] : '';
$statusFilter = isset($_GET['statusFilter']) ? $_GET['statusFilter'] : '';

// Build the SQL query with filters
$query = "SELECT Id, Firstname, Lastname, Email, `Phone Number`, Role, Status FROM users WHERE 1=1";

if ($roleFilter) {
    $query .= " AND Role = ?";
}
if ($statusFilter) {
    $query .= " AND Status = ?";
}

$stmt = $con->prepare($query);

// Bind parameters if filters are set
if ($roleFilter && $statusFilter) {
    $stmt->bind_param('ss', $roleFilter, $statusFilter);
} elseif ($roleFilter) {
    $stmt->bind_param('s', $roleFilter);
} elseif ($statusFilter) {
    $stmt->bind_param('s', $statusFilter);
}

$stmt->execute();
$stmt->bind_result($Id, $firstname, $lastname, $email, $phone, $role, $status);

// Fetch and display the filtered users
while ($stmt->fetch()) {
    echo "
    <tr>
        <td>{$Id}</td>
        <td>{$firstname}</td>
        <td>{$lastname}</td>
        <td>{$email}</td>
        <td>{$phone}</td>
        <td>{$role}</td>
        <td>{$status}</td>
        <td>
            <button class='btn btn-sm btn-warning' data-bs-toggle='modal' data-bs-target='#editUserModal' data-id='{$Id}' data-firstname='{$firstname}' data-lastname='{$lastname}' data-email='{$email}' data-phone='{$phone}' data-role='{$role}' data-status='{$status}'>Edit</button>
            <button class='btn btn-sm btn-danger' onclick='deleteUser({$Id})'>Delete</button>
        </td>
    </tr>
    ";
}
$stmt->close();
?>


                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
<script>
function deleteUser(userId) {
    if (confirm("Are you sure you want to delete this user?")) {
        // You can make an AJAX call to delete the user from the database
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_user.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Optionally, refresh the page or remove the row from the table
                alert("User deleted successfully!");
                location.reload();  // Reload the page to reflect changes
            }
        };
        xhr.send("id=" + userId);
    }
}

    </script>
   <?php
require_once("includes/config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST['action'];

    if ($action == 'add') {
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
    } elseif ($action == 'update') {
        // Update user logic
        $id = $_POST['id'];
        $firstname = htmlspecialchars($_POST["firstName"]);
        $lastname = htmlspecialchars($_POST["lastName"]);
        $phone = htmlspecialchars($_POST["phoneNumber"]);
        $role = htmlspecialchars($_POST["userRole"]);
        $status = htmlspecialchars($_POST["userStatus"]);
        $email = htmlspecialchars($_POST["userEmail"]);
        $first_login=0;

        if ($con) {
            $stmt = $con->prepare("UPDATE users SET Firstname = ?, Lastname = ?, Email = ?, `Phone Number` = ?, Role = ?, Status = ?,First_login=? WHERE Id = ?");
            $stmt->bind_param('ssssssii', $firstname, $lastname, $email, $phone, $role, $status,$first_login, $id);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                echo "<script>alert('User updated successfully!');</script>";
            } else {
                echo "<script>alert('Error updating user.');</script>";
            }
            $stmt->close();
        }
    }
    $con->close();
}
?>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="manage-users.php" method="post">
                    <input type="hidden" name="action" value="add"> <!-- Add this line -->
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" name="firstName" class="form-control" id="firstName" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" name="lastName" class="form-control" id="lastName" required>
                    </div>
                    <div class="mb-3">
                        <label for="userEmail" class="form-label">Email</label>
                        <input type="email" name="userEmail" class="form-control" id="userEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="phoneNumber" class="form-label">Phone Number</label>
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
                        <input type="password" name="password" class="form-control" id="password" required>
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
            <div class="modal-body">
                <form action="manage-users.php" method="post">
                    <input type="hidden" name="action" value="update"> <!-- Add this line -->
                    <input type="hidden" name="id" id="editId">
                    <div class="mb-3">
                        <label for="editFirstName" class="form-label">First Name</label>
                        <input type="text" name="firstName" class="form-control" id="editFirstName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editLastName" class="form-label">Last Name</label>
                        <input type="text" name="lastName" class="form-control" id="editLastName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" name="userEmail" class="form-control" id="editEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPhoneNumber" class="form-label">Phone Number</label>
                        <input type="number" name="phoneNumber" class="form-control" id="editPhoneNumber" required>
                    </div>
                    <div class="mb-3">
                        <label for="editRole" class="form-label">Role</label>
                        <select class="form-select" name="userRole" id="editRole">
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                            <option value="moderator">Moderator</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editStatus" class="form-label">Status</label>
                        <select class="form-select" name="userStatus" id="editStatus">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>


    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Populate the edit modal with the user data
        var editUserModal = document.getElementById('editUserModal');
        editUserModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var userId = button.getAttribute('data-id');
            var firstName = button.getAttribute('data-firstname');
            var lastName = button.getAttribute('data-lastname');
            var email = button.getAttribute('data-email');
            var phone = button.getAttribute('data-phone');
            var role = button.getAttribute('data-role');
            var status = button.getAttribute('data-status');

            document.getElementById('editId').value = userId;
            document.getElementById('editFirstName').value = firstName;
            document.getElementById('editLastName').value = lastName;
            document.getElementById('editEmail').value = email;
            document.getElementById('editPhoneNumber').value = phone;
            document.getElementById('editRole').value = role;
            document.getElementById('editStatus').value = status;
        });
    </script>
</body>
</html>
