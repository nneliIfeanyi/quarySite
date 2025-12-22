<?php
session_start();

// Check if admin is logged in, otherwise redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

require_once '../includes/db_connect.php';
require_once '../includes/config.php';

// Accept POST (preferred) or GET for id
$registrant_id = $_POST['id'] ?? $_GET['id'] ?? null;

if (!$registrant_id || !is_numeric($registrant_id)) {
    $_SESSION['error_message'] = 'Invalid registrant ID.';
    header('Location: view_registrations.php');
    exit();
}

// Verify the registrant exists
$stmt = $pdo->prepare("SELECT id FROM registrants WHERE id = ?");
$stmt->execute([$registrant_id]);
$registrant = $stmt->fetch();

if (!$registrant) {
    $_SESSION['error_message'] = 'Registrant not found.';
    header('Location: view_registrations.php');
    exit();
}

// Delete the registrant
try {
    $stmt = $pdo->prepare("DELETE FROM registrants WHERE id = ?");
    $stmt->execute([$registrant_id]);

    $_SESSION['success_message'] = 'Registrant deleted successfully.';
    header('Location: view_registrations.php');
    exit();
} catch (PDOException $e) {
    $_SESSION['error_message'] = 'An error occurred while deleting the registrant. Please try again.';
    header('Location: view_registrations.php');
    exit();
}
