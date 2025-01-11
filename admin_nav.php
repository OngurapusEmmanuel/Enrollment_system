<nav class="col-md-3 col-lg-2 d-md-block sidebar bg-dark text-white p-3">
<h1 class="h2">Welcome,
    <?php
     echo $_SESSION["name"]; 
     ?>
     </h1>
     
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
                    <li class="nav-item mb-3">
                        <a href="applications.php" class="nav-link">Vacancy applications</a>
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
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    if ($currentPage == "admin-dashboard.php"): ?>
        <!-- Link directly to the section on the same page -->
        <a href="#notification-list" class="nav-link">Notifications
            <?php if ($requestCount > 0): ?>
            <span class="badge bg-danger"><?php echo $requestCount; ?></span>
            <?php endif; ?>
        </a>
    <?php else: ?>
        <!-- Redirect to admin-dashboard.php and scroll to the section -->
        <a href="admin-dashboard.php#notification-list" class="nav-link">Notifications
            <?php if ($requestCount > 0): ?>
            <span class="badge bg-danger"><?php echo $requestCount; ?></span>
            <?php endif; ?>
        </a>
    <?php endif; ?>
</li>

                    <li class="nav-item">
                        <a href="logout.php" class="nav-link text-danger">Logout</a>
                    </li>
                </ul>
            </nav>