<?php 
// require_once("includes/sessions.php");

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
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>src="js/dashboard.js"></script>
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
                        $stmt = $con->prepare("SELECT COUNT(*) FROM approved_clients");
                        
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
                        <div class="card text-white bg-primary">
                            <div class="card-body">
                                <h5 class="card-title">Total Enrollments</h5>
                                <p class="card-text display-4"><?php if ($requestCount1 > 0 ||$num > 0): ?>
                            <?php
                                 echo $requestCount1; 
                                 ?>
                        <?php endif; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-success">
                        <?php
                    // Include database connection file
                    require_once("includes/config.php");
                    
                    $requestCount2 = 0;
                    $num=0;
                    if ($con) {
                        // Prepare an SQL statement to count rows
                        $stmt = $con->prepare("SELECT COUNT(*) FROM users");
                        
                        // Execute the statement
                        if ($stmt->execute()) {
                            // Bind the result to a variable
                            $stmt->bind_result($requestCount2);
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
                                <h5 class="card-title">Active Users</h5>
                                <p class="card-text display-4"><?php if ($requestCount2 > 0 ||$num > 0): ?>
                            <?php
                                 echo $requestCount2; 
                                 ?>
                        <?php endif; ?>
                        </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-warning">
                        <?php
                    // Include database connection file
                    require_once("includes/config.php");
                    
                    $requestCount3 = 0;
                    $num=0;
                    if ($con) {
                        // Prepare an SQL statement to count rows
                        $stmt = $con->prepare("SELECT COUNT(*) FROM clients");
                        
                        // Execute the statement
                        if ($stmt->execute()) {
                            // Bind the result to a variable
                            $stmt->bind_result($requestCount3);
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
                                <h5 class="card-title">Pending Approvals</h5>
                                <p class="card-text display-4"><?php if ($requestCount3 > 0 ||$num > 0): ?>
                            <?php
                                 echo $requestCount3; 
                                 ?>
                        <?php endif; ?></p>
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
                            <select class="form-select"  id="status">
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
            FROM approved_clients
        ");

        // Execute the statement
        $stmt->execute();

        // Bind the results to variables
        $stmt->bind_result($Id,$firstname, $lastname, $email, $phone, $age, $parent,$disability);

        // Fetch the data and display it in the table
        while ($stmt->fetch()) {
            echo "
            
                <td>{$Id}</td>
                <td>{$firstname}</td>
                <td>{$lastname}</td>
                <td>{$email}</td>
                <td>{$phone}</td>
                <td>{$age}</td>
                <td>{$parent}</td>
                <td>{$disability}</td>
                
            ";
            // $x++;
        }
    }
        ?>
                                    <td>
                                        <button class="btn btn-sm btn-primary view-btn">View</button>
                                    </td>
                                </tr>
                                
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
                    <p><strong>First Name:</strong> <span id="modalFirstName"></span></p>
                    <p><strong>Last Name:</strong> <span id="modalLastName"></span></p>
                    <p><strong>Email:</strong> <span id="modalEmail"></span></p>
                    <p><strong>Phone Number:</strong> <span id="modalPhone"></span></p>
                    <p><strong>Age:</strong> <span id="modalAge"></span></p>
                    <p><strong>Gender:</strong> <span id="modalGender"></span></p>

                    <p><strong>Parent Name:</strong> <span id="modalParentName"></span></p>
                    <p><strong>Parent Occupation:</strong> <span id="modalParent_occup"></span></p>
                    <p><strong>Highest Education Qualification:</strong> <span id="modalEducation"></span></p>
                    <p><strong>Category:</strong> <span id="modalCategory"></span></p>
                    <p><strong>Disabilities Type:</strong> <span id="modalDisabilities"></span></p>
                    <p><strong>Received Disability Certificate:</strong> <span id="modalDisability_cert"></span></p>

                    <p><strong>Government Support:</strong> <span id="modalSupport"></span></p>
                    <p><strong>Bpl:</strong> <span id="modalBpl"></span></p>
                    <p><strong>Guardian Name:</strong> <span id="modalGuardian_name"></span></p>
                    <p><strong>Guardian Relationship:</strong> <span id="modalGuardial_rel"></span></p>
                    <p><strong>Has Health Insurance:</strong> <span id="modalHealth_insu"></span></p>

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

                    <?php
// Database connection
require_once("includes/config.php");

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT *FROM your_table WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

echo json_encode($data);

$stmt->close();
$conn->close();
?>

                    // Fetch data from the server
                    fetch(`id=${id}`)
                        .then(response => response.json())
                        .then(data => {
                            // Populate modal fields
                            document.getElementById("modalFirstName").textContent = data.First_name;
                            document.getElementById("modalLatName").textContent = data.Last_name;
                            document.getElementById("modalEmail").textContent = data.Email;
                            document.getElementById("modalPhone").textContent = data.Phone_no;
                            document.getElementById("modalParentName").textContent = data.Parent_name;
                            document.getElementById("modalAge").textContent = data.Age;
                            document.getElementById("modalGender").textContent = data.Gender;
                            document.getElementById("modalEducation").textContent = data.Education;
                            document.getElementById("modalCategory").textContent = data.Category;
                            document.getElementById("modalDisabilities").textContent = data.Disabilities;
                            document.getElementById("modalDisability_cert").textContent = data.Disability_certificate;
                            document.getElementById("modalSupport").textContent = data.Support;
                            document.getElementById("modalBpl").textContent = data.Bpl;
                            document.getElementById("modalParent_occup").textContent = data.Parent_occupation;
                            document.getElementById("modalGuardian_name").textContent = data.Guardian_name;
                            document.getElementById("modalGurdian_rel").textContent = data.Guardian_relation;
                            document.getElementById("modalHealth_insu").textContent = data.Health_insurance;

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
