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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .profile-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">View Student Details</h2>

        <?php if ($student): ?>
            <div class="card shadow">
                <div class="card-body align-items-center">
                    <h4 class="card-title mb-2"><?= htmlspecialchars($student['firstname']) ?> <?= htmlspecialchars($student['lastname']) ?></h4>
                    <p class="card-text"><strong>Email:</strong> <?= htmlspecialchars($student['email']) ?></p>
                    <p class="card-text"><strong>Contact Number:</strong> <?= htmlspecialchars($student['contactno']) ?></p>
                    <p class="card-text"><strong>Address:</strong> <?= htmlspecialchars($student['address']) ?></p>
                </div>
            </div>
        <?php endif; ?>

        <a href="index.php" class="btn btn-secondary mt-3">Back</a>
    </div>
</body>
</html>
