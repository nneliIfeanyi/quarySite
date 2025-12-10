<?php
require_once 'includes/db_connect.php';
require_once 'includes/config.php';
require_once 'tcpdf/tcpdf.php'; // Ensure TCPDF is loaded before MYPDF class definition

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Extend TCPDF to include custom Header and Footer
class MYPDF extends TCPDF
{
    // Explicit property to avoid undefined property notices
    public $registration_date = '';
    //Page header
    public function Header()
    {
        // Move header a bit down from the top edge
        $this->SetY(12); // position header 12 mm from top; adjust this value as needed
        // Set font
        $this->SetFont('helvetica', 'B', 16);
        // Title
        $this->Cell(0, 10, 'Revival Labourers', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
        // Set font for subtitle
        $this->SetFont('helvetica', '', 10);
        $this->Cell(0, 7, 'Online Registration Tag: Quarry Site 2026', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer()
    {
        $this->SetY(-15); // Position at 15 mm from bottom
        $this->SetFont('helvetica', 'I', 8); // Set font
        // Get current date for download date
        $download_date = date('Y-m-d'); // only date, exclude time
        // Cell for registration date and download date (registrant data will be passed here)
        $this->Cell(0, 10, 'Registration Date: ' . $this->registration_date . ' | Download Date: ' . $download_date, 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// TCPDF integration for generating and prompting download of the registration tag PDF
if (isset($_GET['id'])) {
    $reg_id = $_GET['id'];
    // Search for the registrant in the database
    $stmt = $pdo->prepare("SELECT * FROM registrants WHERE registration_tag = ?");
    $stmt->execute([$reg_id]);
    $registrant = $stmt->fetch(PDO::FETCH_ASSOC);
    $gender = $registrant['gender'];
    $registration_tag = $registrant['registration_tag'];
    $surname = $registrant['title'] . ' ' . $registrant['surname'];
    $othernames = $registrant['othernames'];
    // Create new PDF document with MYPDF class
    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(100, 100), true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Quarry Site Registration Portal');
    $pdf->SetTitle('Registration Tag');
    $pdf->SetSubject('Quarry Site Registration Tag');

    // Set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // Set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // Ensure header space does not overlap content
    $pdf->SetHeaderMargin(12); // space for header
    $pdf->SetMargins(PDF_MARGIN_LEFT, 30, PDF_MARGIN_RIGHT); // left, top, right margins

    // Set registrant data for footer (needs to be set before AddPage)
    $pdf->registration_date = date('Y-m-d H:i:s'); // For new registration

    // Add a page
    $pdf->AddPage();
    // Position below header so content won't overlap
    $pdf->SetY(12 + 15); // header margin + header height

    // Set font
    $pdf->SetFont('helvetica', '', 12);
    // output a title and some text
    $pdf->Cell(0, 10, 'THEME: BURNING FOR GOD', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
    // Determine avatar image based on gender and build absolute path
    $avatar_path = ($gender == 'Male') ? 'assets/img/male.png' : 'assets/img/female.png';
    $avatar_file = __DIR__ . '/' . $avatar_path;
    // Normalize to forward slashes for TCPDF on Windows
    $avatar_file = str_replace('\\', '/', $avatar_file);
    // If file doesn't exist, unset to avoid broken image
    if (!file_exists(str_replace('/', DIRECTORY_SEPARATOR, $avatar_file))) {
        $avatar_file = '';
    }
    // 
    // HTML layout
    $html = '
<table cellpadding="6" cellspacing="0" border="0">
    <tr>
        <td width="80">
            <img src="' . $avatar_file . '" width="100" height="100" style="border-radius:50%;">
        </td>

        <td width="300" style="font-size:16px; line-height:22px;">
            <strong>' . $surname . '<br>
            ' . $othernames . '</strong><br>
            (Participant)
        </td>
    </tr>
</table>
';

    $pdf->writeHTML($html, true, false, true, false, '');

    // Print registration tag bigger, bolder and centered
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 8, 'RL-CODE: ' . $registration_tag, 0, 1, 'C', 0, '', 0);

    // Close and output PDF document
    $pdf_file_path = "tags/registration_" . $registration_tag . ".pdf";
    $pdf->Output(__DIR__ . '/' . $pdf_file_path, 'I'); // Save to server

    // Stream the PDF file for download
    header('Content-Type: application/pdf');
    header("Content-Disposition: attachment; filename=registration_{$registration_tag}.pdf");
    readfile(__DIR__ . '/' . $pdf_file_path);
    exit();
}
