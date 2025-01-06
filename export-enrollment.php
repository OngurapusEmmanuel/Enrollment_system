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
$headers = [
    'A1' => 'Serial No',
    'B1' => 'Name',
    'C1' => 'Parent Name',
    'D1' => 'Age',
    'E1' => 'Sex',
    'F1' => 'Education',
    'G1' => 'Category',
    'H1' => 'Disabilities',
    'I1' => 'Disability Certificate',
    'J1' => 'Support',
    'K1' => 'BPL',
    'L1' => 'Parent Occupation',
    'M1' => 'Guardian Name',
    'N1' => 'Guardian Relation',
    'O1' => 'Health Insurance',
    'P1' => 'Other Facilities'
];

foreach ($headers as $cell => $header) {
    $sheet->setCellValue($cell, $header);
}

// Query to fetch all records from the enrollment_data table
$sql = "SELECT sl_no, name, parent_name, age, sex, education, category, disabilities, disability_certificate, support, bpl, parent_occupation, guardian_name, guardian_relation, health_insurance, other_facilities FROM enrollment_data";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Write data to the spreadsheet
if ($result->num_rows > 0) {
    $rowIndex = 2; // Start writing from the second row
    while ($row = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowIndex, $row['sl_no']);
        $sheet->setCellValue('B' . $rowIndex, $row['name']);
        $sheet->setCellValue('C' . $rowIndex, $row['parent_name']);
        $sheet->setCellValue('D' . $rowIndex, $row['age']);
        $sheet->setCellValue('E' . $rowIndex, $row['sex']);
        $sheet->setCellValue('F' . $rowIndex, $row['education']);
        $sheet->setCellValue('G' . $rowIndex, $row['category']);
        $sheet->setCellValue('H' . $rowIndex, $row['disabilities']);
        $sheet->setCellValue('I' . $rowIndex, $row['disability_certificate']);
        $sheet->setCellValue('J' . $rowIndex, $row['support']);
        $sheet->setCellValue('K' . $rowIndex, $row['bpl']);
        $sheet->setCellValue('L' . $rowIndex, $row['parent_occupation']);
        $sheet->setCellValue('M' . $rowIndex, $row['guardian_name']);
        $sheet->setCellValue('N' . $rowIndex, $row['guardian_relation']);
        $sheet->setCellValue('O' . $rowIndex, $row['health_insurance']);
        $sheet->setCellValue('P' . $rowIndex, $row['other_facilities']);
        $rowIndex++;
    }
}

// Set headers to download the file as Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="enrollment_data.xlsx"');

// Write the file to output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

// Close the database connection
$stmt->close();
$conn->close();
?>
