<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../Controllers/StudentController.php';
use Controllers\StudentController;

$controller = new StudentController();
$students = $controller->index(5); 
$totalStudents = $controller->totalCount();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];
    $deleted = $controller->deleteStudent($deleteId);
    if ($deleted) {
        $_SESSION['success'] = "Student deleted successfully";
    } else {
        $_SESSION['error'] = "Failed to delete student.";
    }
    header("Location: index.php");
    exit();
}

$students = $controller->index();