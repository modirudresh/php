<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../Controllers/StudentController.php';
use Controllers\StudentController;

$controller = new StudentController();

$student = null;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $viewID = $_GET['id'];
    $student = $controller->getStudent($viewID);

    if (!$student) {
        $_SESSION['error'] = "Student not found.";
        header("Location: index.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Student</title>
    <!-- Add Bootstrap/AdminLTE CSS as needed -->
</head>
<body>
    <div class="container mt-4">
        <h2>View Student Details</h2>

        <?php if ($student): ?>
            <ul>
                <li><strong>ID:</strong> <?= htmlspecialchars($student['id']) ?></li>
                <li><strong>Name:</strong> <?= htmlspecialchars($student['firstname']) ?> <?= htmlspecialchars($student['lastname']) ?></li>
                <li><strong>Email:</strong> <?= htmlspecialchars($student['email']) ?></li>
                <!-- Add more fields as needed -->
            </ul>
        <?php endif; ?>

        <a href="index.php" class="btn btn-secondary">Back</a>
    </div>
</body>
</html>
