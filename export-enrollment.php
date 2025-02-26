<?php
// Manually include PhpSpreadsheet files
require 'Phpspreadsheet/src/PhpSpreadsheet/Spreadsheet.php';
require 'Phpspreadsheet/src/PhpSpreadsheet/Writer/Xlsx.php';
require 'Phpspreadsheet/src/PhpSpreadsheet/IOFactory.php';

// Use PhpSpreadsheet classes
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Include the database connection configuration
include('includes/config.php');

// Clear any previous output
ob_clean();
flush();

// Create a new spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set the column headers (removed 'id' and 'Serial No')
$headers = [
    'A1' => 'Name',
    'B1' => 'Parent Name',
    'C1' => 'Age',
    'D1' => 'Sex',
    'E1' => 'Education',
    'F1' => 'Category',
    'G1' => 'Disabilities',
    'H1' => 'Disability Certificate',
    'I1' => 'Support',
    'J1' => 'BPL',
    'K1' => 'Parent Occupation',
    'L1' => 'Guardian Name',
    'M1' => 'Guardian Relation',
    'N1' => 'Health Insurance',
    'O1' => 'Other Facilities'
];

foreach ($headers as $cell => $header) {
    $sheet->setCellValue($cell, $header);
}

// Query to fetch all records from the enrollment_data table (excluding 'id' or any other specific field)

$stmt = $con->prepare("SELECT `name`, parent_name, age, sex, education, category, disabilities, disability_certificate, support, bpl, parent_occupation, guardian_name, guardian_relation, health_insurance, other_facilities FROM enrollment_data");
$stmt->execute();
$result = $stmt->get_result();

// Write data to the spreadsheet
if ($result->num_rows > 0) {
    $rowIndex = 2; // Start writing from the second row
    while ($row = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowIndex, $row['name']);
        $sheet->setCellValue('B' . $rowIndex, $row['parent_name']);
        $sheet->setCellValue('C' . $rowIndex, $row['age']);
        $sheet->setCellValue('D' . $rowIndex, $row['sex']);
        $sheet->setCellValue('E' . $rowIndex, $row['education']);
        $sheet->setCellValue('F' . $rowIndex, $row['category']);
        $sheet->setCellValue('G' . $rowIndex, $row['disabilities']);
        $sheet->setCellValue('H' . $rowIndex, $row['disability_certificate']);
        $sheet->setCellValue('I' . $rowIndex, $row['support']);
        $sheet->setCellValue('J' . $rowIndex, $row['bpl']);
        $sheet->setCellValue('K' . $rowIndex, $row['parent_occupation']);
        $sheet->setCellValue('L' . $rowIndex, $row['guardian_name']);
        $sheet->setCellValue('M' . $rowIndex, $row['guardian_relation']);
        $sheet->setCellValue('N' . $rowIndex, $row['health_insurance']);
        $sheet->setCellValue('O' . $rowIndex, $row['other_facilities']);
        $rowIndex++;
    }
}

// Set headers to download the file as Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="enrollment_data.xlsx"');
header('Cache-Control: max-age=0');

// Write the file to output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

// Close the database connection
$stmt->close();
$con->close();
?>
