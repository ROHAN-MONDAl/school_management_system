<?php
include '../server_database.php';
require_once('TCPDF-main/tcpdf.php');  // Include the TCPDF library

// Check if the 'id' parameter exists in the GET request
$id = $_GET['id'] ?? null;
if (!$id) {
    exit("<p class='text-danger'>Invalid student ID.</p>");
}

// Prepare the query to fetch student details and payment info
$query = $conn->prepare("
    SELECT 
        students.img_path,
        students.name, 
        students.class, 
        students.gender, 
        students.roll_no, 
        students.phone_no, 
        students.whatsapp, 
        students.branch, 
        students.city, 
        students.dob, 
        students.admission_date,
        students.admission_package,
        payments.invo_no, 
        payments.amount, 
        payments.summary 
    FROM students
    LEFT JOIN payments ON students.id = payments.student_id
    WHERE students.id = ?");

$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();

$totalAmount = 0;

if ($result->num_rows == 0) {
    exit("<p class='text-danger'>No payments found for this student.</p>");
}

// Fetch the student details
$student = $result->fetch_assoc();

// Generate a unique invoice number (format: DLS<last invoice number> / <year>)
$lastRow = null;
$result->data_seek(0); // Reset the result pointer
while ($row = $result->fetch_assoc()) {
    $totalAmount += $row['amount'];  // Calculate the total amount
    $lastRow = $row;  // Get the last payment row for the invoice number
}
$invoiceNumber = "DLS {$lastRow['invo_no']} / " . date("Y");

// Start output buffering to avoid "already output" error
ob_start();

// Create new PDF document
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Student Invoice');
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->AddPage();

// Add logo and school details

// Get the total page width
$pageWidth = $pdf->getPageWidth();

// Calculate X position for 30% right alignment
$xPosition = $pageWidth * 0.35;


// Place the image
$pdf->Image('assets/logo.jpeg', $xPosition,  15, 15, 12, '', '', 'T', false, 300);
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell( 20, 12, 'Daffodils School', 0, 1, '');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 10, 'Address: Kuchkuchia Rd, Bankura, West Bengal 722101, Phone number: 094348 60435', 0, 1, 'C');

// Add Invoice title
$pdf->Ln(10);
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Invoice', 0, 1, 'C');

// Add invoice number and date
date_default_timezone_set("Asia/kolkata");
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(40, 10, 'Date:', 0, 0, 'L');
$pdf->Cell(0, 10, date('d-m-Y'), 0, 1, 'L');
$pdf->Cell(40, 10, 'Invoice No:', 0, 0, 'L');
$pdf->Cell(0, 10, $invoiceNumber, 0, 1, 'L');

// Add student details table
$pdf->Ln(5);
$html = <<<EOD
<table cellpadding="8" border="1" cellspacing="0" style="width: 100%; border-collapse: collapse;">
    <tr>
        <td style="width: 25%; font-weight: bold;">Student Name:</td>
        <td style="width: 50%;">{$student['name']}</td>
        <td style="width: 25%;" rowspan="6" align="center">
            <img src="{$student['img_path']}" alt="Student Image" style="width: 100px; height: 130px; object-fit: cover;" />
        </td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Gender:</td>
        <td>{$student['gender']}</td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Class:</td>
        <td>{$student['class']}</td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Roll no:</td>
        <td>{$student['roll_no']}</td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Phone no:</td>
        <td>{$student['phone_no']}</td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Whatsapp no:</td>
        <td>{$student['whatsapp']}</td>
    </tr>
    <tr>
        <td style="font-weight: bold;">City:</td>
        <td colspan="2">{$student['city']}</td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Date of Birth:</td>
        <td colspan="2">{$student['dob']}</td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Admission Date:</td>
        <td colspan="2">{$student['admission_date']}</td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Admission Package:</td>
        <td colspan="2">Rs {$student['admission_package']}</td>
    </tr>
</table>
EOD;
$pdf->writeHTML($html, true, false, false, false, '');

// Add payment details table
$pdf->Ln(0);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Payment Details', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 10);

$html = '<table border="1" cellpadding="5" cellspacing="0"><thead><tr align= "center" ><th  style="font-weight: bold;">SLNO</th><th style="font-weight: bold;">Summary</th><th style="font-weight: bold;">Amount</th></tr></thead><tbody>';
$i = 1;
$result->data_seek(0); // Reset pointer to include all rows
while ($row = $result->fetch_assoc()) {
    $html .= '<tr align= "center"><td>' . $i++ . '</td><td>' . $row['summary'] . '</td><td> Rs ' . number_format($row['amount'], 2) . '</td></tr>';
}
$html .= '<tr><td colspan="2" align="right"><b>Total:</b></td><td><b>Rs ' . number_format($totalAmount, 2) . '</b></td></tr>';
$html .= '</tbody></table>';
$pdf->writeHTML($html, true, false, false, false, '');

// Add total amount as today's paid amount
$pdf->Ln(5);
$pdf->SetFont('helvetica', 'B', 12);
if ($lastRow) {
    $todayPaidAmount = $lastRow['amount'];
    $pdf->Cell(0, 10, "Today's Paid Amount: Rs " . number_format($todayPaidAmount, 2), 0, 1, 'C');
}

// Add footer note
$pdf->Ln(18);
$pdf->SetFont('helvetica', 'I', 10);
$pdf->Cell(0, 10, "This invoice is computer generated.", 0, 1, 'C');

// Output PDF to browser
$pdf->Output('invoice_' . $student['name'] . '.pdf', 'D');  // 'D' means download
exit();
