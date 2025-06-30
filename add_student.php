<?php
require_once 'config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $roll_number = $_POST['roll_number'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $department = $_POST['department'];
    $year = $_POST['year'];
    $email = $_POST['email'];

    $stmt = $pdo->prepare("INSERT INTO students (roll_number, first_name, last_name, department, year, email) VALUES (?, ?, ?, ?, ?, ?)");
    try {
        $stmt->execute([$roll_number, $first_name, $last_name, $department, $year, $email]);
        echo "<p>Student added successfully!</p>";
    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Student</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Add New Student</h2>
        <form method="POST">
            <label>Roll Number:</label>
            <input type="text" name="roll_number" required><br>
            <label>First Name:</label>
            <input type="text" name="first_name" required><br>
            <label>Last Name:</label>
            <input type="text" name="last_name" required><br>
            <label>Department:</label>
            <input type="text" name="department" required><br>
            <label>Year:</label>
            <input type="number" name="year" required><br>
            <label>Email:</label>
            <input type="email" name="email" required><br>
            <button type="submit">Add Student</button>
        </form>
        <a href="index.php">Back to Home</a>
    </div>
</body>
</html>