<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

if (isset($_GET['tag'])) {
    $registration_tag = htmlspecialchars($_GET['tag']);
    $pdf_file_path = "../tags/registration_" . $registration_tag . ".pdf";

    // Ensure the file exists and is within the tags directory
    if (file_exists($pdf_file_path)) {
        header('Content-Type: application/pdf');
        header("Content-Disposition: attachment; filename=registration_{$registration_tag}.pdf");
        readfile($pdf_file_path);
        exit();
    } else {
        die("Error: Registration tag PDF not found.");
    }
} else {
    die("Error: No registration tag specified.");
}
?>
