<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Management System</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('images/school_going_child.jpg'); /* Adjust path if image is in a different folder */
            background-size: cover; /* Covers the entire background */
            background-position: center; /* Centers the image */
            background-repeat: no-repeat; /* Prevents tiling */
            height: 100vh; /* Full viewport height */
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white to make text readable */
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            margin: 50px auto; /* Centers the container */
            text-align: center;
        }
        nav ul {
            list-style-type: none;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin: 0 15px;
        }
        nav ul li a {
            text-decoration: none;
            color: #333;
            font-size: 18px;
        }
        nav ul li a:hover {
            color: #007BFF;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Student Management System</h1>
        <nav>
            <ul>
                <li><a href="add_student.php">Add Student</a></li>
                <li><a href="view_students.php">View Students</a></li>
                <li><a href="add_attendance.php">Add Attendance</a></li>
                <li><a href="view_attendance.php">View Attendance</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
</body>
</html>