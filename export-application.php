<?php
// Manually include PhpSpreadsheet files
require 'Phpspreadsheet/src/PhpSpreadsheet/Spreadsheet.php';
require 'Phpspreadsheet/src/PhpSpreadsheet/Writer/Xlsx.php';
require 'Phpspreadsheet/src/PhpSpreadsheet/IOFactory.php';

// Use PhpSpreadsheet classes
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Include the database connection configuration
include('config.php');

// Create a new spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set the column headers
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Full Name');
$sheet->setCellValue('C1', 'Email');
$sheet->setCellValue('D1', 'Phone');
$sheet->setCellValue('E1', 'Education');
$sheet->setCellValue('F1', 'Position');
$sheet->setCellValue('G1', 'Cover Letter');
$sheet->setCellValue('H1', 'Resume');

// Query to fetch all applicants with concatenated full name using prepared statements
$sql ="SELECT *FROM vacancy_applications";
// $sql = "SELECT id, CONCAT(first_name, ' ', last_name) AS full_name, email, phone, education, position, cover_letter, resume FROM vacancy_application";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Write data to the spreadsheet
if ($result->num_rows > 0) {
    $rowIndex = 2; // Start writing from the second row
    while ($row = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowIndex, $row['id']);
        $sheet->setCellValue('B' . $rowIndex, $row['full_name']);
        $sheet->setCellValue('C' . $rowIndex, $row['email']);
        $sheet->setCellValue('D' . $rowIndex, $row['phone']);
        $sheet->setCellValue('E' . $rowIndex, $row['education']);
        $sheet->setCellValue('F' . $rowIndex, $row['position']);
        $sheet->setCellValue('G' . $rowIndex, $row['cover_letter']);
        $sheet->setCellValue('H' . $rowIndex, $row['resume']);
        $rowIndex++;
    }
}

// Set headers to download the file as Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="applicants.xlsx"');

// Write the file to output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

// Close the database connection
$stmt->close();
$conn->close();
?>
