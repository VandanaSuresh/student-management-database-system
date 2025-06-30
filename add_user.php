<?php
require_once 'config/db_connect.php';

$username = 'vandana'; // Choose your username
$password = password_hash('vand123', PASSWORD_BCRYPT); // Choose your password

$checkStmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
$checkStmt->execute([$username]);
$count = $checkStmt->fetchColumn();

if ($count == 0) {
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $password]);
    echo "User '$username' added with hashed password!";
} else {
    echo "User '$username' already exists! No action taken.";
}
?>