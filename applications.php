<?php
require_once("includes/sessions.php");

if (!isset($_SESSION["name"])) {
    header("Location: login.php");
    exit();
}

// Include the database connection configuration
include('includes/config.php');

// Get the selected position from the form (if any)
$selectedPosition = isset($_GET['position']) ? $_GET['position'] : '';

// Prepare the SQL statement to fetch applicants, filtered by position if selected
$sql = "SELECT * FROM vacancy_applications";
if ($selectedPosition) {
    $sql .= " WHERE position = ?";
}

$stmt = $con->prepare($sql);

// Bind the position parameter if filtering by position
if ($selectedPosition) {
    $stmt->bind_param("s", $selectedPosition);
}

// Execute the statement
$stmt->execute();
$result = $stmt->get_result(); // Get the result set
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin- View Applicants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
        </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include 'admin_nav.php'; ?>

        <main class="col-md-9 col-lg-10 ms-sm-auto px-md-4">
            <div class="container">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
                <h2>List of Applicants</h2>
                </div>

                <!-- Filter Section -->
<div class="filter-section">
    <h5>Filter Applicants</h5>
    <form method="GET" class="row g-3">
                    
                        <div class="col-md-6">
                            <select name="position" class="form-select" onchange="this.form.submit()">
                                <option value="">Select Position</option>
                                <option value="Physiotherapist Intern" <?php echo ($selectedPosition == 'Physiotherapist Intern') ? 'selected' : ''; ?>>Physiotherapist Intern</option>
                                <option value="Counsellor Intern" <?php echo ($selectedPosition == 'Counsellor Intern') ? 'selected' : ''; ?>>Counsellor Intern</option>
                                <option value="Speech Development Specialist Intern" <?php echo ($selectedPosition == 'Speech Development Specialist Intern') ? 'selected' : ''; ?>>Speech Development Specialist Intern</option>
                                <option value="Occupational Therapist Intern" <?php echo ($selectedPosition == 'Occupational Therapist Intern') ? 'selected' : ''; ?>>Occupational Therapist Intern</option>

                            </select>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Apply Filters</button>
                        </div>
                    </div>
                </form>
</div>
              

                <?php if ($result->num_rows > 0): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Education</th>
                                <th>Position</th>
                                <th>Cover Letter</th>
                                <th>Resume</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                    <td><?php echo htmlspecialchars($row['education']); ?></td>
                                    <td><?php echo htmlspecialchars($row['position']); ?></td>
                                    <td><?php echo nl2br(htmlspecialchars($row['cover_letter'])); ?></td>
                                    <?php

$resumeCode = isset($row['resume']) ? htmlspecialchars($row['resume']) : '';
?>
<td>
    <?php if (!empty($resumeCode)): ?>
        <a href="download_resume.php?code=<?= $resumeCode ?>" 
           class="btn btn-success" 
           target="_blank">Download Resume</a>
    <?php else: ?>
        <span class="text-muted">No Resume</span>
    <?php endif; ?>
</td>


                                    <?php
// Assign variables for easier readability
$name = htmlspecialchars($row['name']);
$email = htmlspecialchars($row['email']);
$phone = htmlspecialchars($row['phone']);
$education = htmlspecialchars($row['education']);
$position = htmlspecialchars($row['position']);
$coverLetter = htmlspecialchars($row['cover_letter']);
$resumeCode = htmlspecialchars($row['resume']);
?>

<td class="actions">
    <button 
        class="btn view-btn btn-info" 
        data-name="<?= $name ?>" 
        data-email="<?= $email ?>" 
        data-phone="<?= $phone ?>" 
        data-education="<?= $education ?>" 
        data-position="<?= $position ?>" 
        data-cover-letter="<?= $coverLetter ?>" 
        data-resume-code="<?= $resumeCode ?>"
    >
        View
    </button>
</td>


                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="no-data">No applicants found.</p>
                <?php endif; ?>

                <?php
                // Close the statement and connection
                // $stmt->close();
                $con->close();
                ?>

                <!-- Modal for viewing application details -->
                <div class="modal fade" id="applicantModal" tabindex="-1" aria-labelledby="applicantModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="applicantModalLabel">Applicant Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> <span id="applicantName"></span></p>
                <p><strong>Email:</strong> <span id="applicantEmail"></span></p>
                <p><strong>Phone:</strong> <span id="applicantPhone"></span></p>
                <p><strong>Education:</strong> <span id="applicantEducation"></span></p>
                <p><strong>Position:</strong> <span id="applicantPosition"></span></p>
                <p><strong>Cover Letter:</strong> <span id="applicantCoverLetter"></span></p>
                <p><strong>Resume:</strong> 
                    <a href="#" class="btn btn-success" target="_blank">Download Resume</a>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


            </div>
        </main>
    </div>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<script>
    // Function to open the modal and populate it with the applicant's details
    function openModal(name, email, phone, education, position, coverLetter, resumeCode) {
        document.getElementById('applicantName').textContent = name;
        document.getElementById('applicantEmail').textContent = email;
        document.getElementById('applicantPhone').textContent = phone;
        document.getElementById('applicantEducation').textContent = education;
        document.getElementById('applicantPosition').textContent = position;
        document.getElementById('applicantCoverLetter').innerHTML = coverLetter;
        document.querySelector('#applicantModal a').href = `download_resume.php?code=${resumeCode}`;

        // Show the modal
        var myModal = new bootstrap.Modal(document.getElementById('applicantModal'));
        myModal.show();
    }

    // Add event listeners to all "View" buttons
    document.addEventListener("DOMContentLoaded", function () {
        const viewButtons = document.querySelectorAll(".view-btn");

        viewButtons.forEach(button => {
            button.addEventListener("click", function () {
                const name = this.getAttribute("data-name");
                const email = this.getAttribute("data-email");
                const phone = this.getAttribute("data-phone");
                const education = this.getAttribute("data-education");
                const position = this.getAttribute("data-position");
                const coverLetter = this.getAttribute("data-cover-letter");
                const resumeCode = this.getAttribute("data-resume-code");

                openModal(name, email, phone, education, position, coverLetter, resumeCode);
            });
        });
    });
</script>


</body>
</html>
