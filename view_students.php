<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
require_once 'config/db_connect.php';

// Handle CSV download
if (isset($_GET['download'])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="students_data.csv"');
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');

    $output = fopen('php://output', 'w');
    try {
        $stmt = $pdo->query("SELECT * FROM students LIMIT 1");
        $headers = array_keys($stmt->fetch(PDO::FETCH_ASSOC));
        fputcsv($output, $headers);
        $stmt = $pdo->query("SELECT * FROM students");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            fputcsv($output, $row);
        }
    } catch (PDOException $e) {
        die('Error generating CSV: ' . htmlspecialchars($e->getMessage()));
    }
    fclose($output);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Students</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('images/floating_lanterns.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            font-family: Arial, sans-serif;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            max-width: 1200px;
            margin: 50px auto;
            text-align: center;
        }
        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .buttons {
            margin-top: 20px;
        }
        .buttons a {
            display: inline-block;
            margin: 0 5px;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }
        .edit-btn {
            background-color: #ffc107;
            color: white;
        }
        .edit-btn:hover {
            background-color: #ffca28;
        }
        .delete-btn {
            background-color: #dc3545;
            color: white;
        }
        .delete-btn:hover {
            background-color: #c82333;
        }
        .back-btn {
            background-color: #007BFF;
            color: white;
        }
        .back-btn:hover {
            background-color: #0056b3;
        }
        .download-btn {
            background-color: #28a745;
            color: white;
        }
        .download-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>View Students</h2>
        <?php
        try {
            $stmt = $pdo->query("SELECT * FROM students");
            if ($stmt->rowCount() > 0) {
                echo '<table>';
                $stmt->execute();
                $firstRow = $stmt->fetch(PDO::FETCH_ASSOC);
                $headers = array_keys($firstRow);
                echo '<tr>';
                foreach ($headers as $header) {
                    echo '<th>' . htmlspecialchars($header) . '</th>';
                }
                echo '<th>Actions</th>'; // New column for buttons
                echo '</tr>';
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    foreach ($headers as $header) {
                        echo '<td>' . htmlspecialchars($row[$header] ?? '') . '</td>';
                    }
                    // Assume 'id' or 'email' as the unique identifier
                    $id = $row['id'] ?? $row['email'] ?? ''; // Adjust based on your primary key
                    echo '<td>';
                    echo '<a href="edit_student.php?id=' . urlencode($id) . '" class="edit-btn">Edit</a>';
                    echo ' <form action="delete_student.php" method="post" style="display:inline;" onsubmit="return confirm(\'Are you sure?\');">';
                    echo '<input type="hidden" name="id" value="' . htmlspecialchars($id) . '">';
                    echo '<button type="submit" class="delete-btn">Delete</button>';
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo '<p>No students found. Add students to see data.</p>';
            }
        } catch (PDOException $e) {
            echo '<p>Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
        }
        ?>
        <div class="buttons">
            <a href="index.php" class="back-btn">Back to Home</a>
            <a href="?download=1" class="download-btn">Download as Sheet</a>
        </div>
    </div>
</body>
</html>