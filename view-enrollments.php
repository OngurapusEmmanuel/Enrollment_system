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
    <title>View Enrollments</title>
    <!-- Bootstrap CSS -->
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
                      <a href="files/sample.xlsx" download="sample.xlsx">Download Excel</a>
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
                <button class='btn btn-sm btn-primary view-btn'>View</button>
            </td>
        </tr>
    ";
}
?>

                                    <td>
                                        <button class="btn btn-sm btn-primary view-btn">View</button>
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
            </main>
        </div>
    </div>
   

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
