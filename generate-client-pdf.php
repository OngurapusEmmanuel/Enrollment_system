<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
ob_start(); // Start output buffering

require_once('TCPDF-main/tcpdf.php');
include('includes/config.php');

class CustomPDF extends TCPDF {
    public function Header() {
        $logo = 'images/user.png'; 
        $this->Image($logo, 10, 10, 30);
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 5, 'BETHEL MENTAL WELLBEING', 0, 1, 'C');
        $this->SetFont('helvetica', '', 10);
        $this->Cell(0, 5, 'P.O. Box 260-50135, Khwisero, Kakamega', 0, 1, 'C');
        $this->Cell(0, 5, 'Telephone: 0115280583', 0, 1, 'C');
        $this->Cell(0, 5, 'Email: info@bethelmentalwellbeing.org', 0, 1, 'C');
        $this->Cell(0, 5, 'Website: www.bethelmentalwellbeing.org', 0, 1, 'C');
        $this->Ln(5);
        $this->Cell(0, 0, '', 'T', 1, 'C');
    }
}

// Check database connection
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

$pdf = new CustomPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Enrolled Clients Report');
$pdf->SetMargins(15, 27, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(10);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 10, 'List of Enrolled Clients', 0, 1, 'C');
$pdf->Ln(5);

$html = '<table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="20%">First Name</th>
                    <th width="20%">Last Name</th>
                    <th width="20%">Email</th>
                    <th width="10%">Phone Number</th>
                    <th width="15%">Role</th>
                    <th width="10%">Status</th>
                </tr>
            </thead>
            <tbody>';

// $sql = "SELECT Id, Firstname, Lastname, Email, `Phone Number`, `Role`, `Status` FROM users";
$stmt = $con->prepare( "SELECT Id, Firstname, Lastname, Email, `Phone Number`, `Role`, `Status` FROM users");

if ($stmt) {
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $html .= '<tr>
                        <td>' . htmlspecialchars($row['Id']) . '</td>
                        <td>' . htmlspecialchars($row['Firstname']) . '</td>
                        <td>' . htmlspecialchars($row['Lastname']) . '</td>
                        <td>' . htmlspecialchars($row['Email']) . '</td>
                        <td>' . htmlspecialchars($row['Phone Number']) . '</td>
                        <td>' . htmlspecialchars($row['Role']) . '</td>
                        <td>' . htmlspecialchars($row['Status']) . '</td>
                      </tr>';
        }
    } else {
        $html .= '<tr><td colspan="7">No data available</td></tr>';
    }
    $stmt->close();
} else {
    die('Query preparation failed: ' . $con->error);
}

$html .= '</tbody></table>';
$pdf->writeHTML($html, true, false, true, false, '');

ob_end_clean(); // Ensure no output before PDF
$pdf->Output('enrolled_clients.pdf', 'I');

$con->close();
?>
