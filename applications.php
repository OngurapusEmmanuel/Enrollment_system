<?php
// Include the database connection configuration
include('includes/config.php');

// Prepare the SQL statement to fetch all applicants
$sql = "SELECT * FROM vacancy_application";
$stmt = $con->prepare($sql);

// Execute the statement
$stmt->execute();
$result = $stmt->get_result(); // Get the result set
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - View Applicants</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        header {
            background-color: #0044cc;
            color: white;
            padding: 15px;
            text-align: center;
        }

        h1, h2 {
            color: #333;
            text-align: center;
        }

        .container {
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: #fff;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #0044cc;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .actions a {
            text-decoration: none;
            padding: 5px 10px;
            margin: 2px;
            border-radius: 3px;
            color: white;
        }

        .delete {
            background-color: #dc3545;
        }

        .delete:hover {
            opacity: 0.9;
        }

        .download {
            background-color: #28a745;
        }

        .download:hover {
            opacity: 0.9;
        }

        .no-data {
            text-align: center;
            color: #777;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
    </header>
    <div class="container">
        <h2>List of Applicants</h2>

        <?php if ($result->num_rows > 0): ?>
            <table>
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
                            <td>
                                <a href="<?php echo htmlspecialchars($row['resume']); ?>" class="download" target="_blank">Download</a>
                            </td>
                            <td class="actions">
                                <a href="delete_applicant.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="delete">Delete</a>
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
        $stmt->close();
        $conn->close();
        ?>
    </div>
</body>
</html>
