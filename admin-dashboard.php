<?php
session_start();  // Ensure session is started
if (!isset($_SESSION["name"])) {
    header("Location: login.php");
    exit();
}

require_once('includes/config.php');  // Corrected include statement

if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

function getRecordCount($table) {
    global $con;
    $stmt = $con->prepare("SELECT COUNT(*) FROM $table");
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
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>src="js/dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" href="images/bethel.png" type="image/x-icon">
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

        #notification-list table {
    Width: 100%;
    Border-collapse: collapse;
}

#notification-list th, #notification-list td {
    Padding: 10px;
    Border: 1px solid #ddd;
    Text-align: left;
}

#notification-list th {
    Background-color: #f2f2f2;
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
                        <div class="card text-white bg-primary">
                            <div class="card-body">
                                <h5 class="card-title">Approved Enrollments</h5>
                                <p class="card-text display-4"><?php echo getRecordCount('approved_clients'); ?></p>
                            
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-success">
                      
                            <div class="card-body">
                                <h5 class="card-title">Active Users</h5>
                                <p class="card-text display-4"><?php echo getRecordCount('users'); ?></p>
                           
                        </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-warning">
                       
                            <div class="card-body">
                                <h5 class="card-title">Pending Approvals</h5>
                                <p class="card-text display-4"><?php echo getRecordCount('clients'); ?></p>
                            
                            </div>
                        </div>
                    </div>
                </div>

               
                    <!-- Filter Section -->
<div class="filter-section">
    <h5>Filter Enrollments</h5>
    <form class="row g-3" method="GET">
        <div class="col-md-4">
            <label for="disabilityFilter" class="form-label">Disability</label>
            <select class="form-select" id="disabilityFilter" name="disability">
                <option value="">All</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="ageFilter" class="form-label">Age Range</label>
            <select class="form-select" id="ageFilter" name="age">
                <option value="">All</option>
                <option value="under-18">Under 18</option>
                <option value="18-25">18-25</option>
                <option value="26-35">26-35</option>
                <option value="36-45">36-45</option>
                <option value="46-60">46-60</option>
                <option value="60+">60+</option>
            </select>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Apply Filters</button>
        </div>
    </form>
</div>

                </div>

                <!-- Reports Table -->
                <div class="card">
                    <div class="card-header">
                        Approved Enrollments
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
require_once('includes/config.php');

// Initialize filter variables
$disabilityFilter = isset($_GET['disability']) ? $_GET['disability'] : '';
$ageFilter = isset($_GET['age']) ? $_GET['age'] : '';

// Build the query dynamically based on the filters
$query = "SELECT Id, First_name, Last_name, Phone_no, Age, Parent_name, Disabilities FROM clients WHERE 1";

// Apply disability filter if selected
if ($disabilityFilter !== '') {
    $query .= " AND Disabilities = ?";
}

// Apply age filter if provided
if ($ageFilter !== '') {
    switch ($ageFilter) {
        case 'under-18':
            $query .= " AND Age < 18";
            break;
        case '18-25':
            $query .= " AND Age BETWEEN 18 AND 25";
            break;
        case '26-35':
            $query .= " AND Age BETWEEN 26 AND 35";
            break;
        case '36-45':
            $query .= " AND Age BETWEEN 36 AND 45";
            break;
        case '46-60':
            $query .= " AND Age BETWEEN 46 AND 60";
            break;
        case '60+':
            $query .= " AND Age > 60";
            break;
    }
}

// Add LIMIT to the query to restrict the number of rows to 5
$query .= " LIMIT 5";

// Prepare the statement
$stmt = $con->prepare($query);

// Bind parameters for the prepared statement
if ($disabilityFilter !== '' && $ageFilter !== '') {
    $stmt->bind_param("s", $disabilityFilter);
} elseif ($disabilityFilter !== '') {
    $stmt->bind_param("s", $disabilityFilter);
}

// Execute the statement
$stmt->execute();

// Bind the results to variables
$stmt->bind_result($Id, $firstname, $lastname, $phone, $age, $parent, $disability);

// Fetch the data and display it in the table
while ($stmt->fetch()) {
    echo "
        <tr>
            <td>{$Id}</td>
            <td>{$firstname}</td>
            <td>{$lastname}</td>
            <td>{$phone}</td>
            <td>{$age}</td>
            <td>{$parent}</td>
            <td>{$disability}</td>
              <td>
            <button class='btn btn-sm btn-primary view-btn' data-bs-toggle='modal' data-bs-target='#viewclientModal'>View</button>
        </td>
        </tr>
    ";
}
?>

                                
                               
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="filter-section">
    <!-- <h5>Filter Enrollments</h5> -->
    <!--Notification List Section -->
<section id="notification-list">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h2>Posted Notifications</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#postNotificationModal">Post notification</button>
    </div>

    <div class="card">
        <div class="card-body">
        <table class="table table-striped" id="notificationTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
require_once('includes/config.php');
             
                    
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
                    <td>
                         <button class='btn btn-danger btn-sm' onclick='deleteNotification({$Id})' >Delete</button>
                        </td>
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


<!-- Post Notification Modal -->
<div class="modal fade" id="postNotificationModal" tabindex="-1" aria-labelledby="postNotificationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="postNotificationModalLabel">Post New Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="notification.php" method="post">
                    <div class="mb-3">
                        <label for="notificationTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="notificationContent" class="form-label">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Post Notification</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
        function postNotification() {
            const title = document.getElementById("notificationTitle").value;
            const content = document.getElementById("notificationContent").value;

            if (title && content) {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "post-notification.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        alert(response.message);
                        if (response.success) {
                            location.reload();
                        }
                    }
                };
                xhr.send(`action=post&title=${encodeURIComponent(title)}&content=${encodeURIComponent(content)}`);
            } else {
                alert("Both title and content are required.");
            }
        }

        function deleteNotification(notificationId) {
            if (confirm("Are you sure you want to delete this notification?")) {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "post-notification.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        alert(response.message);
                        if (response.success) {
                            location.reload();
                        }
                    }
                };
                xhr.send(`action=delete&id=${notificationId}`);
            }
        }
    </script>
</div>

        
            </main>
        </div>
    </div>

      <!-- Modal for Viewing Details -->
      <div class="modal fade" id="viewClientModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
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
require_once('includes/config.php');

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT *FROM approved_clients WHERE id = ?");
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
                            const viewModal = new bootstrap.Modal(document.getElementById("viewClientModal"));
                            viewModal.show();
                        })
                        .catch(error => console.error("Error fetching data:", error));
                });
            });
        });
    </script>
    <!-- Bootstrap JS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> -->
</body>
</html>
