<?php
require_once 'config/db_connect.php';

$students = $pdo->query("SELECT student_id, first_name, last_name FROM students")->fetchAll(PDO::FETCH_ASSOC);
$courses = $pdo->query("SELECT course_id, course_name FROM courses")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];
    $date = $_POST['date'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("INSERT INTO attendance (student_id, course_id, date, status) VALUES (?, ?, ?, ?)");
    try {
        $stmt->execute([$student_id, $course_id, $date, $status]);
        echo "<p>Attendance recorded successfully!</p>";
    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Attendance</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Add Attendance</h2>
        <form method="POST">
            <label>Student:</label>
            <select name="student_id" required>
                <?php foreach ($students as $student): ?>
                    <option value="<?php echo $student['student_id']; ?>">
                        <?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select><br>
            <label>Course:</label>
            <select name="course_id" required>
                <?php foreach ($courses as $course): ?>
                    <option value="<?php echo $course['course_id']; ?>">
                        <?php echo htmlspecialchars($course['course_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select><br>
            <label>Date:</label>
            <input type="date" name="date" required><br>
            <label>Status:</label>
            <select name="status" required>
                <option value="Present">Present</option>
                <option value="Absent">Absent</option>
            </select><br>
            <button type="submit">Record Attendance</button>
        </form>
        <a href="index.php">Back to Home</a>
    </div>
</body>
</html>