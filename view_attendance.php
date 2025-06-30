<?php
require_once 'config/db_connect.php';

$department = $_GET['department'] ?? '';
$year = $_GET['year'] ?? '';

$query = "SELECT s.roll_number, s.first_name, s.last_name, c.course_name, a.date, a.status 
          FROM attendance a 
          JOIN students s ON a.student_id = s.student_id 
          JOIN courses c ON a.course_id = c.course_id";
$conditions = [];
$params = [];

if ($department) {
    $conditions[] = "s.department = ?";
    $params[] = $department;
}
if ($year) {
    $conditions[] = "s.year = ?";
    $params[] = $year;
}

if ($conditions) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$attendance_records = $stmt->fetchAll(PDO::FETCH_ASSOC);

$departments = $pdo->query("SELECT DISTINCT department FROM students")->fetchAll(PDO::FETCH_COLUMN);
$years = $pdo->query("SELECT DISTINCT year FROM students")->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Attendance</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Attendance Records</h2>
        <form method="GET">
            <label>Filter by Department:</label>
            <select name="department">
                <option value="">All</option>
                <?php foreach ($departments as $dept): ?>
                    <option value="<?php echo $dept; ?>" <?php echo $department == $dept ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($dept); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label>Filter by Year:</label>
            <select name="year">
                <option value="">All</option>
                <?php foreach ($years as $yr): ?>
                    <option value="<?php echo $yr; ?>" <?php echo $year == $yr ? 'selected' : ''; ?>>
                        <?php echo $yr; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Filter</button>
        </form>
        <table>
            <tr>
                <th>Roll Number</th>
                <th>Name</th>
                <th>Course</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
            <?php foreach ($attendance_records as $record): ?>
            <tr>
                <td><?php echo htmlspecialchars($record['roll_number']); ?></td>
                <td><?php echo htmlspecialchars($record['first_name'] . ' ' . $record['last_name']); ?></td>
                <td><?php echo htmlspecialchars($record['course_name']); ?></td>
                <td><?php echo htmlspecialchars($record['date']); ?></td>
                <td><?php echo htmlspecialchars($record['status']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <a href="index.php">Back to Home</a>
    </div>
</body>
</html>