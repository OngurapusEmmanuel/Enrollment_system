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
            <nav class="col-md-3 col-lg-2 d-md-block sidebar bg-dark text-white p-3">
                <h4 class="text-center mb-4">Admin Dashboard</h4>
                <ul class="nav flex-column">
                    <li class="nav-item mb-3">
                        <a href="Admin-dashboard.php" class="nav-link">Dashboard Home</a>
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
                    
                    $requestCount12 = 0;
                    $num=0;
                    if ($con) {
                        // Prepare an SQL statement to count rows
                        $stmt = $con->prepare("SELECT COUNT(*) FROM notifications");
                        
                        // Execute the statement
                        if ($stmt->execute()) {
                            // Bind the result to a variable
                            $stmt->bind_result($requestCount12);
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
                            <!-- <?php if ($requestCount12 > 0 ||$num > 0): ?>
                            <span class="badge"><?php
                                 echo $requestCount12; 
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
                    <h1 class="h2">View Enrollments</h1>
                  <a href="enroll.php"> <button class="btn btn-sm btn-primary">Add New Enrollment</button></a> 
                  <div class="download-container">
                    <span class="download-icon">⬇</span>
                    <div class="dropdown">
                      <a href="files/sample.pdf" download="sample.pdf">Download PDF</a>
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
                    <form class="row g-3">
                        <div class="col-md-4">
                            <label for="programFilter" class="form-label">Program</label>
                            <select class="form-select" id="programFilter">
                                <option value="">All</option>
                                <option value="web-dev">Web Development</option>
                                <option value="graphic-design">Graphic Design</option>
                                <option value="data-analysis">Data Analysis</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="statusFilter" class="form-label">Status</label>
                            <select class="form-select" id="statusFilter">
                                <option value="">All</option>
                                <option value="completed">Completed</option>
                                <option value="pending">Pending</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="dateFilter" class="form-label">Enrollment Date</label>
                            <input type="date" class="form-control" id="dateFilter">
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-primary">Apply Filters</button>
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

    // Check if the connection is established
    if ($con) {
        $x = 5;

        // Prepare the statement to select data from the 'exhibits' table
        $stmt = $con->prepare("
            SELECT Id,First_name,Last_name,Phone_no,Age,Parent_name,Disabilities 
            FROM cleints
        ");

        // Execute the statement
        $stmt->execute();

        // Bind the results to variables
        $stmt->bind_result($Id,$firstname, $lastname, $phone, $age, $parent,$disability);

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
            </main>
        </div>
    </div>
   

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
