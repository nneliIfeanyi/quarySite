<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

if (isset($_GET['id'])) {
    // Raw tag from URL
    $registration_tag = $_GET['id'];

    // Validate registration tag to avoid directory traversal and unexpected chars
    if (!preg_match('/^[A-Za-z0-9_\-]+$/', $registration_tag)) {
        die("Error: Invalid registration tag.");
    }

    // Resolve tags directory and construct a safe file path
    $tagsDir = realpath(__DIR__ . '/../tags');
    if ($tagsDir === false) {
        die("Error: Tags directory not found.");
    }

    $pdf_file_path = $tagsDir . DIRECTORY_SEPARATOR . "registration_" . $registration_tag . ".pdf";

    // Ensure the resolved path is inside the tags directory
    $realPath = realpath($pdf_file_path);
    if ($realPath === false || strpos($realPath, $tagsDir) !== 0) {
        die("Error: Registration tag PDF not found.");
    }

    // Serve the file
    header('Content-Type: application/pdf');
    header("Content-Disposition: attachment; filename=registration_{$registration_tag}.pdf");
    header('Content-Length: ' . filesize($realPath));
    readfile($realPath);
    exit();
} else {
    die("Error: No registration tag specified.");
}
