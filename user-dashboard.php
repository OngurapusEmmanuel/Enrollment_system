
<?php
 require_once("includes/sessions.php");

// if (!isset($_SESSION["name"])) {

//   header("Location:login.php");
//  exit();
// }
 ?>
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Management Dashboard</title>
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
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include 'user_nav.php' ?>

            <!-- Main Content -->
            <main class="col-md-9 col-lg-10 ms-sm-auto px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
                    <h1 class="h2">Welcome,<?php echo $_SESSION["name"]; ?></h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button class="btn btn-sm btn-outline-secondary">Edit Profile</button>
                    </div>
                </div>

                <!-- Overview Section -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card text-white bg-primary mb-3">
                            <?php
                            // Include database connection file
                            require_once("includes/config.php");

                            $requestCount1 = 0;
                            $num=0;
                            if ($con) {
                                // Prepare an SQL statement to count rows
                                $stmt = $con->prepare("SELECT COUNT(*) FROM clients");
                                
                                // Execute the statement
                                if ($stmt->execute()) {
                                    // Bind the result to a variable
                                    $stmt->bind_result($requestCount1);
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
                            ?>
                            <div class="card-body">
                                <h5 class="card-title">Total Clients</h5>
                                <p class="card-text display-4"><?php if ($requestCount1 > 0 ||$num > 0): ?>
                            <?php
                                 echo $requestCount1; 
                                 ?>
                        <?php endif; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-body">
                            <?php
                            // Include database connection file
                            require_once("includes/config.php");

                            
                            $requestCount11 = 0;
                            $num=0;
                            if ($con) {
                                // Prepare an SQL statement to count rows
                                $stmt = $con->prepare("SELECT COUNT(*) FROM clients");
                                
                                // Execute the statement
                                if ($stmt->execute()) {
                                    // Bind the result to a variable
                                    $stmt->bind_result($requestCount11);
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
                            ?>
                                <h5 class="card-title">Clients Enrolled</h5>
                                <p class="card-text display-4"><?php if ($requestCount1 > 0 ||$num > 0): ?>
                            <?php
                                 echo $requestCount11; 
                                 ?>
                        <?php endif; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Pending Approvals</h5>
                                <p class="card-text display-4">15</p>
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
                                <!-- <tr>
                                    <td>2</td>
                                    <td>Jane Smith</td>
                                    <td>Graphic Design Workshop</td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                    <td>2024-02-10</td>
                                    <td>2024-03-01</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary view-btn" data-id="2">View</button>
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
                </div>

                <!-- Notifications Section -->
                <div class="card">
                    <div class="card-header">
                        Notifications
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">A new client "Michael Johnson" has been successfully enrolled in "Data Analysis Basics".</li>
                            <li class="list-group-item">Your request to enroll "Jane Smith" in the "Web Development Training" has been approved.</li>
                            <li class="list-group-item">Reminder: Pending enrollments need to be confirmed before the start date.</li>
                        </ul>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>