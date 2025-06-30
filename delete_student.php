<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
require_once 'config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    if ($id) {
        try {
            error_log("Debug: Attempting to delete ID = $id");
            $stmt = $pdo->prepare("DELETE FROM students WHERE student_id = ? OR email = ? LIMIT 1");
            $stmt->execute([$id, $id]);
            error_log("Debug: Deletion successful for ID = $id");
            header("Location: view_students.php");
            exit;
        } catch (PDOException $e) {
            error_log("Debug: Error in delete_student.php: " . $e->getMessage());
            die('Error: ' . htmlspecialchars($e->getMessage()));
        }
    }
}
header("Location: view_students.php");
exit;
?>