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
            <nav class="col-md-3 col-lg-2 d-md-block sidebar bg-dark text-white p-3">
                <h4 class="text-center mb-4">Admin Dashboard</h4>
                <ul class="nav flex-column">
                    <li class="nav-item mb-3">
                        <a href="admin-dashboard.php" class="nav-link">Dashboard Home</a>
                    </li>
                    <li class="nav-item mb-3">
                        <a href="view-enrollments.php" class="nav-link">View Enrollments</a>
                    </li>
                    <li class="nav-item mb-3">
                        <a href="manage-users.php" class="nav-link">Manage Users</a>
                    </li>
                    
                    <!-- <?php
                    // Include database connection file
                    require_once("includes/config.php");
                    
                    $requestCount = 0;
                    $num=0;
                    if ($con) {
                        // Prepare an SQL statement to count rows
                        $stmt = $con->prepare("SELECT COUNT(*) FROM notifications");
                        
                        // Execute the statement
                        if ($stmt->execute()) {
                            // Bind the result to a variable
                            $stmt->bind_result($requestCount);
                            $stmt->fetch();
                        }
                        // if($stmt1->execute()){
                        //     $stmt1->bind_result($num);
                        //     $stmt1->fetch();
                        // }
                    
                        // Close the statement and connection
                        $stmt->close();
                        // $stmt1->close();
                    
                    } else {
                        echo "Database connection failed.";
                    }
                    ?> -->
                    <li class="nav-item mb-3">
                        <a href="notifications.php" class="nav-link">Notifications 
                            <!-- <?php if ($requestCount > 0 ||$num > 0): ?>
                            <span class="badge"><?php
                                 echo $requestCount; 
                                 ?></span>
                        <?php endif; ?> -->
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link text-danger">Logout</a>
                    </li>
                </ul>
            </nav>

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
                <td>{$Id}</td>
                <td>{$firstname}</td>
                <td>{$lastname}</td>
                <td>{$email}</td>
                <td>{$phone}</td>
                <td>{$role}</td>
                <td>{$status}</td>
                <td>
                   
                </td>
            </tr>
            ";
            $x++;
        }
    }
        ?>
       
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
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" name="firstName" class="form-control" id="firstName">
                        </div>
                        <div class="mb-3">
                            <label for="lastName" class="form-label"> Last Name</label>
                            <input type="text" name="lastName" class="form-control" id="lastName">
                        </div>
                        <div class="mb-3">
                            <label for="userEmail" class="form-label">Email</label>
                            <input type="email" name="userEmail" class="form-control" id="userEmail">
                        </div>
                        <div class="mb-3">
                            <label for="phoneNumber" class="form-label">phone number</label>
                            <input type="number" name="phoneNumber" class="form-control" id="phoneNumber">
                        </div>
                        <div class="mb-3">
                            <label for="userRole" class="form-label">Role</label>
                            <select class="form-select" id="userRole">
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                                <option value="moderator">Moderator</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="userStatus" class="form-label">Status</label>
                            <select class="form-select" id="userStatus">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password">
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
                    <form action="manageusers.php?id=<?php echo $_GET['id']; ?>" method="post">
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
                            <select class="form-select" id="editUserRole">
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                                <option value="moderator">Moderator</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editUserStatus" class="form-label">Status</label>
                            <select class="form-select" id="editUserStatus">
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
