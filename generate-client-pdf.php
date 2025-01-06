<?php
// Include the TCPDF library
require_once('TCPDF-main/tcpdf.php');

// Include the database connection configuration
include('config.php');

// Extend TCPDF to customize the header
class CustomPDF extends TCPDF {
    public function Header() {
        // Path to the logo
        $logo = 'images/user.png'; 
        
        // Add the logo
        $this->Image($logo, 10, 10, 30); // Adjust the position and size (x, y, width)

        // Set font for the header text
        $this->SetFont('helvetica', 'B', 12);

        // Add the organization details
        $this->Cell(0, 5, 'BETHEL MENTAL WELLBEING', 0, 1, 'C');
        $this->SetFont('helvetica', '', 10);
        $this->Cell(0, 5, 'P.O. Box 260-50135, Khwisero, Kakamega', 0, 1, 'C');
        $this->Cell(0, 5, 'Telephone: 0115280583', 0, 1, 'C');
        $this->Cell(0, 5, 'Email: info@bethelmentalwellbeing.org', 0, 1, 'C');
        $this->Cell(0, 5, 'Website: www.bethelmentalwellbeing.org', 0, 1, 'C');

        // Add a line below the header
        $this->Ln(5);
        $this->Cell(0, 0, '', 'T', 1, 'C');
    }
}

// Create a new PDF document
$pdf = new CustomPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Organization');
$pdf->SetTitle('Enrolled Clients Report');
$pdf->SetSubject('Client Enrollment Details');
$pdf->SetKeywords('Enrollment, Clients, Report');

// Set margins
$pdf->SetMargins(15, 27, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(10);

// Add a page
$pdf->AddPage();

// Set font for the content
$pdf->SetFont('helvetica', '', 10);

// Add a title
$pdf->Cell(0, 10, 'List of Enrolled Clients', 0, 1, 'C');
$pdf->Ln(5);

// Table headers
$html = '<table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="20%">Name</th>
                    <th width="20%">Parent Name</th>
                    <th width="5%">Age</th>
                    <th width="10%">Sex</th>
                    <th width="20%">Education</th>
                    <th width="20%">Category</th>
                </tr>
            </thead>
            <tbody>';

// Query to fetch all records from the enrollment_data table
$sql = "SELECT sl_no, name, parent_name, age, sex, education, category FROM enrollment_data";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Append data to the table
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>
                    <td>' . $row['sl_no'] . '</td>
                    <td>' . $row['name'] . '</td>
                    <td>' . $row['parent_name'] . '</td>
                    <td>' . $row['age'] . '</td>
                    <td>' . $row['sex'] . '</td>
                    <td>' . $row['education'] . '</td>
                    <td>' . $row['category'] . '</td>
                  </tr>';
    }
} else {
    $html .= '<tr><td colspan="7">No data available</td></tr>';
}

$html .= '</tbody></table>';

// Output the table to the PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output the PDF
$pdf->Output('enrolled_clients.pdf', 'D');

// Close the database connection
$stmt->close();
$conn->close();
?>
