<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
                        <a href="#" class="nav-link">Dashboard Home</a>
                    </li>
                    <li class="nav-item mb-3">
                        <a href="view-enrollments.php" class="nav-link">View Enrollments</a>
                    </li>
                    <li class="nav-item mb-3">
                        <a href="manage-users.php" class="nav-link">Manage Users</a>
                    </li>
                    <?php
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
                    ?>
                    <li class="nav-item mb-3">
                        <a href="notifications.php" class="nav-link">Notifications 
                            <?php if ($requestCount > 0 ||$num > 0): ?>
                            <span class="badge"><?php
                                 echo $requestCount; 
                                 ?></span>
                        <?php endif; ?>
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
                    <h1 class="h2">Reports</h1>
                    <button class="btn btn-sm btn-primary">Export Reports</button>
                </div>

                <!-- Summary Cards -->
                <div class="row mb-4">
                    <div class="col-md-4">
                    <?php
                    // Include database connection file
                    require_once("includes/config.php");
                    
                    $requestCount1 = 0;
                    $num=0;
                    if ($con) {
                        // Prepare an SQL statement to count rows
                        $stmt = $con->prepare("SELECT COUNT(*) FROM cleints");
                        
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
                    ?>
                        <div class="card text-white bg-primary">
                            <div class="card-body">
                                <h5 class="card-title">Total Enrollments</h5>
                                <p class="card-text display-4"><?php if ($requestCount1 > 0 ||$num > 0): ?>
                            <?php
                                 echo $requestCount; 
                                 ?>
                        <?php endif; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-success">
                            <div class="card-body">
                                <h5 class="card-title">Completed Trainings</h5>
                                <p class="card-text display-4">800</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-warning">
                            <div class="card-body">
                                <h5 class="card-title">Pending Approvals</h5>
                                <p class="card-text display-4">32</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="filter-section">
                    <h5>Filter Reports</h5>
                    <form class="row g-3">
                        <div class="col-md-4">
                            <label for="startDate" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="startDate">
                        </div>
                        <div class="col-md-4">
                            <label for="endDate" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="endDate">
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status">
                                <option value="">All</option>
                                <option value="completed">Completed</option>
                                <option value="pending">Pending</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-primary">Apply Filters</button>
                        </div>
                    </form>
                </div>

                <!-- Reports Table -->
                <div class="card">
                    <div class="card-header">
                        Reports
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
            FROM cleints
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

      <!-- Modal for Viewing Details -->
      <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Name:</strong> <span id="modalName"></span></p>
                    <p><strong>Program:</strong> <span id="modalProgram"></span></p>
                    <p><strong>Status:</strong> <span id="modalStatus"></span></p>
                    <p><strong>Start Date:</strong> <span id="modalStartDate"></span></p>
                    <p><strong>End Date:</strong> <span id="modalEndDate"></span></p>
                    <!-- Add more fields as needed -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const viewButtons = document.querySelectorAll(".view-btn");

            viewButtons.forEach((button,index) => {
                button.addEventListener("click", function() {
                    const id = this.getAttribute("data-id");

                    // Fetch data from the server
                    fetch(`get-details.php?id=${id}`)
                        .then(response => response.json())
                        .then(data => {
                            // Populate modal fields
                            document.getElementById("modalName").textContent = data.name;
                            document.getElementById("modalProgram").textContent = data.program;
                            document.getElementById("modalStatus").textContent = data.status;
                            document.getElementById("modalStartDate").textContent = data.start_date;
                            document.getElementById("modalEndDate").textContent = data.end_date;

                            // Show the modal
                            const viewModal = new bootstrap.Modal(document.getElementById("viewModal"));
                            viewModal.show();
                        })
                        .catch(error => console.error("Error fetching data:", error));
                });
            });
        });
    </script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
