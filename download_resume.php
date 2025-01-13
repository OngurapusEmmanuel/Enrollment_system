<?php
// download_resume.php

// include('/includes/config.php');

if (isset($_GET['code'])) {
    $resumeCode = $_GET['code'];

    // Check if the file exists in the uploads directory
    $filePath = 'uploads/resumes/' . $resumeCode;

    if (file_exists($filePath)) {
        // Set headers to prompt the file download
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    } else {
        echo "File not found.";
    }
} else {
    echo "No resume code provided.";
}

// $conn->close();
?>
