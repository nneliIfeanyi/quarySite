<?php
session_start();
require_once 'includes/db_connect.php';
require_once 'includes/config.php';
require_once 'includes/flash.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['surname'])) {
    // Server-side validation and sanitization for new registration
    $title = htmlspecialchars(trim($_POST['title'] ?? ''));
    $surname = htmlspecialchars(trim($_POST['surname'] ?? ''));
    $othernames = htmlspecialchars(trim($_POST['othernames'] ?? ''));
    $gender = htmlspecialchars(trim($_POST['gender'] ?? ''));
    $email_raw = trim($_POST['email'] ?? '');
    $email = filter_var($email_raw, FILTER_VALIDATE_EMAIL);
    $phone_raw = trim($_POST['phone'] ?? '');
    // Normalize phone to digits only for server-side checks and DB storage
    $phone = preg_replace('/\D/', '', $phone_raw);
    $age = htmlspecialchars(trim($_POST['age'] ?? ''));
    $m_status = htmlspecialchars(trim($_POST['m_status'] ?? ''));
    $residence = htmlspecialchars(trim($_POST['residence'] ?? ''));
    $lga = htmlspecialchars(trim($_POST['lga'] ?? ''));
    $r_state = htmlspecialchars(trim($_POST['r_state'] ?? ''));
    $work = htmlspecialchars(trim($_POST['work'] ?? ''));
    $trainedAs = htmlspecialchars(trim($_POST['trainedAs'] ?? ''));
    $l_assembly = htmlspecialchars(trim($_POST['l_assembly'] ?? ''));

    $errors = [];

    // Required field checks
    if (empty($surname)) {
        $errors[] = 'Surname is required.';
    }
    if (empty($othernames)) {
        $errors[] = 'Other Names is required.';
    }
    if (empty($gender)) {
        $errors[] = 'Gender is required.';
    }
    if (empty($email_raw)) {
        $errors[] = 'Email is required.';
    } elseif (!$email) {
        $errors[] = 'Invalid email format.';
    }
    if (empty($phone_raw)) {
        $errors[] = 'Phone Number is required.';
    } elseif (!preg_match('/^\d{11}$/', $phone)) {
        $errors[] = 'Phone number must be 11 digits.';
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

    // Check if phone already exists
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM registrants WHERE phone = ?");
        $stmt->execute([$phone]);
        if ($stmt->fetchColumn() > 0) {
            $errors[] = 'This phone number is already registered.';
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
        // Redirect to index to trigger modal with registration tag
        header('Location: index.php?status=success&reg_tag=' . $registration_tag);

        exit();
    } else {
        // Set flash messages for validation errors
        setFlash('error', $errors);
        header('Location: index.php');
        exit();
    }
} else if (isset($_POST['reg_id_download']) || isset($_GET['reg_id_download'])) {
    // Handle existing registration tag download
    $reg_id_to_download = htmlspecialchars(trim($_POST['reg_id_download'] ?? $_GET['reg_id_download']));

    if (empty($reg_id_to_download)) {
        // No registration ID provided
        setFlash('error', 'Please provide a Registration ID to download the tag.');
        header('Location: index.php');
        exit();
    }

    // Search for the registrant in the database
    $stmt = $pdo->prepare("SELECT * FROM registrants WHERE registration_tag = ?");
    $stmt->execute([$reg_id_to_download]);
    $registrant = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($registrant) {
        // Registrant found, generate and download new PDF
        header('Location: pdf_download.php?id=' . $reg_id_to_download);
        exit();
    } else {
        // Registrant not found
        setFlash('error', 'No registrant found with the provided Registration ID.');
        header('Location: index.php');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
