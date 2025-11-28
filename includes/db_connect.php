<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Database connection using PDO
$host = 'localhost';
$db   = 'revivall_quarrySite';
$user = 'revivall_quarrySite'; // Replace with your MySQL username
$pass = 'Avalanche@25';     // Replace with your MySQL password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}
