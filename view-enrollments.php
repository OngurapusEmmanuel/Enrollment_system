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
    <title>View Enrollments</title>
    <link rel="icon" href="images/bethel.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        html {
    scroll-behavior: smooth;
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
        .download-container {
      position: relative;
      display: inline-block;
      cursor: pointer;
    }

    .download-icon {
      font-size: 30px;
    }

    .dropdown {
      display: none;
      position: absolute;
      top: 40px;
      right: 0;
      background-color: white;
      border: 1px solid #ccc;
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
      z-index: 1;
    }

    .dropdown a {
      display: block;
      padding: 10px 20px;
      text-decoration: none;
      color: black;
      font-size: 16px;
    }

    .dropdown a:hover {
      background-color: #f1f1f1;
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
                    <h1 class="h2">View Enrollments</h1>
                  <!-- <a href="enroll.php"> <button class="btn btn-sm btn-primary">Add New Enrollment</button></a>  -->
                  <div class="download-container">
                    <span class="download-icon">⬇</span>
                    <div class="dropdown">
                      <a href="generate-client-pdf.php" download="enrolled_clients.pdf">Download PDF</a>
                      <a href="export-enrollment.php" download="Enrollment-data.xlsx">Download Excel</a>
                    </div>
                  </div>
                
                  <script>
                    const downloadContainer = document.querySelector('.download-container');
                    const dropdown = document.querySelector('.dropdown');
                
                    downloadContainer.addEventListener('click', () => {
                      dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
                    });
                
                    document.addEventListener('click', (event) => {
                      if (!downloadContainer.contains(event.target)) {
                        dropdown.style.display = 'none';
                      }
                    });
                  </script>
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


                <!-- Enrollments Table -->
                <div class="card">
                    <div class="card-header">
                        Recent enrollments
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
<button class='btn btn-sm btn-warning view-btn' data-bs-toggle='modal' data-bs-target='#viewClientModal' data-id='{$Id}'
 data-firstname='{$firstname}'
  data-lastname='{$lastname}'
 data-phone='{$phone}' 
 data-age='{$age}' 
 data-parent='{$parent}' 
 data-disability='{$disability}'>View</button>

   
            </td>
        </tr>
    ";
}
?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
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
                <p><strong>BPL:</strong> <span id="modalBpl"></span></p>
                <p><strong>Guardian Name:</strong> <span id="modalGuardian_name"></span></p>
                <p><strong>Guardian Relationship:</strong> <span id="modalGuardian_rel"></span></p>
                <p><strong>Has Health Insurance:</strong> <span id="modalHealth_insu"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- <script>

document.addEventListener("DOMContentLoaded", function () {
        const viewButtons = document.querySelectorAll(".view-btn");

        viewButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const clientId = this.getAttribute("data-id");

 // Populate the edit modal with the user data
 var editUserModal = document.getElementById('viewClientModal');
                editUserModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var userId = button.getAttribute('data-id');
            var firstName = button.getAttribute('data-firstname');
            var lastName = button.getAttribute('data-lastname');
            var disability = button.getAttribute('data-disability');
            var phone = button.getAttribute('data-phone');
            var age = button.getAttribute('data-age');
            var parent = button.getAttribute('data-prent');

            <?php
// require_once('includes/config.php');

// if ($con) {
//     $stmt = $con->prepare("SELECT `Email`,
//     `Gender`,`Education`,`Category`,
//     `Disability_certificate`,`Support`,
//     `Bpl`,`Parent_occupation`,`Guardian_name`,
//     `Guardian_relation`,`Health_insurance` FROM clients WHERE id = ?");
//     $stmt->bind_param("i", userId);
//     $stmt->execute();
//     $stmt->bind_result($email,$gender,$education,$category,$disability_cert,$support,$bpl,$parenr_occu,$guardian_name,$guardil_relation,$health_insu);

//     $stmt->fetch();

// }

            ?>
            document.getElementById("modalFirstName").value =firstname;
                        document.getElementById("modalLastName").value =lastname ;
                        document.getElementById("modalEmail").value =$email;
                        document.getElementById("modalPhone").value =phone;
                        document.getElementById("modalAge").value =age;
                        document.getElementById("modalGender").value =$gender;
                        document.getElementById("modalParentName").value =parent;
                        document.getElementById("modalParent_occup").value =$parenr_occu;
                        document.getElementById("modalEducation").value =$education;
                        document.getElementById("modalCategory").value =$category;
                        document.getElementById("modalDisabilities").value =disability;
                        document.getElementById("modalDisability_cert").value =$disability_cert;
                        document.getElementById("modalSupport").value =$support;
                        document.getElementById("modalBpl").value =$bpl;
                        document.getElementById("modalGuardian_name").value =$guardian_name;
                        document.getElementById("modalGuardian_rel").value =$guardil_relation;
                        document.getElementById("modalHealth_insu").value =$health_insu;

        // Show the modal
        const viewModal = new bootstrap.Modal(document.getElementById("viewClientModal"));
                        viewModal.show();
                    
                    .catch((error) => console.error("Error fetching data:", error));

            });
        });
    });

    </script> -->
<!-- //         // Populate the edit modal with the user data
//         var editUserModal = document.getElementById('viewClientModal');
//         editUserModal.addEventListener('show.bs.modal', function (event) {
//             var button = event.relatedTarget;
//             var userId = button.getAttribute('data-id');
//             var firstName = button.getAttribute('data-firstname');
//             var lastName = button.getAttribute('data-lastname');
//             var disability = button.getAttribute('data-disability');
//             var phone = button.getAttribute('data-phone');
//             var age = button.getAttribute('data-age');
//             var parent = button.getAttribute('data-prent');

//             <?php
// require_once('includes/config.php');

// if ($con) {
//     $stmt = $con->prepare("SELECT `Email`,
//     `Gender`,`Education`,`Category`,
//     `Disability_certificate`,`Support`,
//     `Bpl`,`Parent_occupation`,`Guardian_name`,
//     `Guardian_relation`,`Health_insurance` FROM clients WHERE id = ?");
//     $stmt->bind_param("i", userId);
//     $stmt->execute();
//     $stmt->bind_result($email,$gender,$education,$category,$disability_cert,$support,$bpl,$parenr_occu,$guardian_name,$guardil_relation,$health_insu);

//     $stmt->fetch();

// }

//             ?>
//             document.getElementById("modalFirstName").value =firstname;
//                         document.getElementById("modalLastName").value =lastname ;
//                         document.getElementById("modalEmail").value =$email;
//                         document.getElementById("modalPhone").value =phone;
//                         document.getElementById("modalAge").value =age;
//                         document.getElementById("modalGender").value =$gender;
//                         document.getElementById("modalParentName").value =parent;
//                         document.getElementById("modalParent_occup").value =$parenr_occu;
//                         document.getElementById("modalEducation").value =$education;
//                         document.getElementById("modalCategory").value =$category;
//                         document.getElementById("modalDisabilities").value =disability;
//                         document.getElementById("modalDisability_cert").value =$disability_cert;
//                         document.getElementById("modalSupport").value =$support;
//                         document.getElementById("modalBpl").value =$bpl;
//                         document.getElementById("modalGuardian_name").value =$guardian_name;
//                         document.getElementById("modalGuardian_rel").value =$guardil_relation;
//                         document.getElementById("modalHealth_insu").value =$health_insu;

//         // Show the modal
//         const viewModal = new bootstrap.Modal(document.getElementById("viewClientModal"));
//                         viewModal.show();
                    
//                     .catch((error) => console.error("Error fetching data:", error));
//         });
//     </script> -->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const viewButtons = document.querySelectorAll(".view-btn");

        viewButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const clientId = this.getAttribute("data-id");
                console.log("Client ID:", clientId); // Debugging: Check if the ID is correct

                <?php
// // Database connection
// require_once("includes/config.php");

// $id = $_GET['id'];
// $stmt = $con->prepare("SELECT *FROM clients WHERE Id = ?");
// $stmt->bind_param("i", $id);
// $stmt->execute();
// $result = $stmt->get_result();
// $data = $result->fetch_assoc();

// echo json_encode($data);

// $stmt->close();
// $con->close();
?>
                // Fetch data from the server
                fetch(`get-details.php?id='clientId'`)
                    .then((response) => response.json())
                    .then((data) => {

                        // console.log("Response data:", data); // Debugging: Check the server response

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
                    .catch((error) => console.error("Error fetching data:", error));
            
                });
        });
    });
</script>

   

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
