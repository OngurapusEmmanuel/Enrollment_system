<nav class="col-md-3 col-lg-2 d-md-block sidebar p-3">
                <h4 class="text-center mb-4">Client Management Dashboard</h4>
                 <!-- Toggle button for small devices -->

                <ul class="nav flex-column">
                    <li class="nav-item mb-3">
                        <a href="user-dashboard.php" class="nav-link">Dashboard Home</a>
                    </li>
                   
                    <li class="nav-item mb-3">
                        <a href="enroll.php" class="nav-link">Enroll Clients</a>
                    </li>
                    <li class="nav-item mb-3">
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    if ($currentPage == "user-dashboard.php"): ?>
        <!-- Link directly to the section on the same page -->
        <a href="#userNotifications" class="nav-link">Notifications</a>
    <?php else: ?>
        <!-- Redirect to admin-dashboard.php and scroll to the section -->
        <a href="user-dashboard.php#userNotifications" class="nav-link">Notifications</a>
    <?php endif; ?>
</li>
                    <li class="nav-item mb-3">
                        <a href="#" class="nav-link">Support</a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link text-danger">Logout</a>
                    </li>
                </ul>
            </nav>