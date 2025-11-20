<?php
require_once 'includes/db_connect.php';
require_once 'includes/config.php';
require_once 'tcpdf/tcpdf.php'; // Ensure TCPDF is loaded before MYPDF class definition

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Extend TCPDF to include custom Header and Footer
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // Set font
        $this->SetFont('helvetica', 'B', 16);
        // Title
        $this->Cell(0, 10, 'Revival Labourers', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
        // Set font for subtitle
        $this->SetFont('helvetica', '', 10);
        $this->Cell(0, 7, 'Online registration tag for Quary Site 2026', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        $this->SetY(-15); // Position at 15 mm from bottom
        $this->SetFont('helvetica', 'I', 8); // Set font
        // Get current date for download date
        $download_date = date('Y-m-d H:i:s');
        // Cell for registration date and download date (registrant data will be passed here)
        $this->Cell(0, 10, 'Registration Date: ' . $this->registration_date . ' | Download Date: ' . $download_date, 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['surname'])) {
    // Server-side validation and sanitization for new registration
    $title = htmlspecialchars(trim($_POST['title']));
    $surname = htmlspecialchars(trim($_POST['surname']));
    $othernames = htmlspecialchars(trim($_POST['othernames']));
    $gender = htmlspecialchars(trim($_POST['gender']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']));
    $age = htmlspecialchars(trim($_POST['age']));
    $m_status = htmlspecialchars(trim($_POST['m_status']));
    $residence = htmlspecialchars(trim($_POST['residence']));
    $lga = htmlspecialchars(trim($_POST['lga']));
    $r_state = htmlspecialchars(trim($_POST['r_state']));
    $work = htmlspecialchars(trim($_POST['work']));
    $trainedAs = htmlspecialchars(trim($_POST['trainedAs']));
    $l_assembly = htmlspecialchars(trim($_POST['l_assembly']));

    $errors = [];

    if (empty($surname)) {
        $errors[] = 'Surname is required.';
    }
    if (empty($othernames)) {
        $errors[] = 'Other Names is required.';
    }
    if (empty($gender)) {
        $errors[] = 'Gender is required.';
    }
    if (empty($email)) {
        $errors[] = 'Email is required.';
    } elseif (!$email) {
        $errors[] = 'Invalid email format.';
    }
    if (empty($phone)) {
        $errors[] = 'Phone Number is required.';
    }
    if (empty($age)) {
        $errors[] = 'Age Bracket is required.';
    }
    if (empty($m_status)) {
        $errors[] = 'Marital Status is required.';
    }
    if (empty($residence)) {
        $errors[] = 'Residential Address is required.';
    }
    if (empty($lga)) {
        $errors[] = 'L.G.A of Residence is required.';
    }
    if (empty($r_state)) {
        $errors[] = 'State of Residence is required.';
    }
    if (empty($l_assembly)) {
        $errors[] = 'Church Name and Address is required.';
    }

    // Check if email already exists
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM registrants WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            $errors[] = 'This email is already registered.';
        }
    }

    if (empty($errors)) {
        // Insert registration data into database
        $stmt = $pdo->prepare("INSERT INTO registrants (title, surname, othernames, gender, email, phone, age, marital_status, residence, lga, state_of_residence, occupation, trained_as, church_assembly) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $surname, $othernames, $gender, $email, $phone, $age, $m_status, $residence, $lga, $r_state, $work, $trainedAs, $l_assembly]);

        $registration_id = $pdo->lastInsertId();

        // Generate customized registration tag
        $state_prefix = strtoupper(substr($r_state, 0, 2));
        $formatted_id = str_pad($registration_id, 4, '0', STR_PAD_LEFT);
        $registration_tag = "RL-" . $state_prefix . $formatted_id;

        // Update the registrant with the generated registration tag
        $update_stmt = $pdo->prepare("UPDATE registrants SET registration_tag = ? WHERE id = ?");
        $update_stmt->execute([$registration_tag, $registration_id]);

        // TCPDF integration for generating and prompting download of the registration tag PDF

        // Create new PDF document with MYPDF class
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(100, 100), true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Event Registration Portal');
        $pdf->SetTitle('Registration Tag');
        $pdf->SetSubject('Event Registration Tag');

        // Set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // Set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // Set registrant data for footer (needs to be set before AddPage)
        $pdf->registration_date = date('Y-m-d H:i:s'); // For new registration

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('helvetica', '', 12);

        // Determine avatar image based on gender
        $avatar_path = ($gender == 'Male') ? 'assets/img/male_avatar.png' : 'assets/img/female_avatar.png';

        // Content
        $full_name_for_pdf = $title . ' ' . $surname . ' ' . $othernames;

        $html = "
        <div style='text-align: center;'>
            <table border='0' cellspacing='0' cellpadding='5'>
                <tr>
                    <td width='30%'><img src='.{$avatar_path}' width='50' /></td>
                    <td width='70%'><strong>{$full_name_for_pdf}</strong></td>
                </tr>
                <tr>
                    <td colspan='2'><strong>Registration Tag:</strong> {$registration_tag}</td>
                </tr>
            </table>
        </div>
        ";
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        // Close and output PDF document
        $pdf_file_path = "tags/registration_" . $registration_tag . ".pdf";
        $pdf->Output(__DIR__ . '/' . $pdf_file_path, 'F'); // Save to server

        // Redirect to index.php with a success message and the registration tag
        header("Location: index.php?status=success&reg_tag={$registration_tag}");
        exit();

    } else {
        // Display errors
        error_log("Registration errors: " . implode(", ", $errors));
        echo "<div class='alert alert-danger'>";
        foreach ($errors as $error) {
            echo "<p>{$error}</p>";
        }
        echo "<p><a href='index.php' class='btn btn-secondary'>Go Back</a></p>";
        echo "</div>";
        exit();
    }
} else if (isset($_POST['reg_id_download']) || isset($_GET['reg_id_download'])) {
    // Handle existing registration tag download
    $reg_id_to_download = htmlspecialchars(trim($_POST['reg_id_download'] ?? $_GET['reg_id_download']));

    if (empty($reg_id_to_download)) {
        echo "<div class='alert alert-danger'>Please enter a Registration ID.</div>";
        echo "<p><a href='index.php' class='btn btn-secondary'>Go Back</a></p>";
        exit();
    }

    // Search for the registrant in the database
    $stmt = $pdo->prepare("SELECT * FROM registrants WHERE registration_tag = ?");
    $stmt->execute([$reg_id_to_download]);
    $registrant = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($registrant) {
        // Registrant found, generate and download new PDF

        // Create new PDF document with MYPDF class
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(100, 100), true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Event Registration Portal');
        $pdf->SetTitle('Registration Tag');
        $pdf->SetSubject('Event Registration Tag');

        // Set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // Set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // Set registrant data for footer (needs to be set before AddPage)
        $pdf->registration_date = $registrant['registration_date'];
        
        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('helvetica', '', 12);

        // Determine avatar image based on gender
        $avatar_path = ($registrant['gender'] == 'Male') ? 'assets/img/male_avatar.png' : 'assets/img/female_avatar.png';

        // Content
        $full_name_for_pdf = $registrant['title'] . ' ' . $registrant['surname'] . ' ' . $registrant['othernames'];

        $html = "
        <div style='text-align: center;'>
            <table border='0' cellspacing='0' cellpadding='5'>
                <tr>
                    <td width='30%'><img src='.{$avatar_path}' width='50' /></td>
                    <td width='70%'><strong>{$full_name_for_pdf}</strong></td>
                </tr>
                <tr>
                    <td colspan='2'><strong>Registration Tag:</strong> {$registrant['registration_tag']}</td>
                </tr>
            </table>
        </div>
        ";
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        // Close and output PDF document
        $pdf_file_path = "tags/registration_" . $registrant['registration_tag'] . ".pdf";
        $pdf->Output(__DIR__ . '/' . $pdf_file_path, 'F'); // Save to server

        // Prompt user to download the PDF
        header('Content-Type: application/pdf');
        header("Content-Disposition: attachment; filename=registration_{$registrant['registration_tag']}.pdf");
        readfile(__DIR__ . '/' . $pdf_file_path);
        exit();

    } else {
        error_log("Download error: Registration tag not found for ID: {$reg_id_to_download}");
        echo "<div class='alert alert-danger'>No registration found with the provided ID.</div>";
        echo "<p><a href='index.php' class='btn btn-secondary'>Go Back</a></p>";
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
?>
