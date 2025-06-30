<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../Controllers/UserController.php';
use Controllers\UserController;

$controller = new UserController();
$users = $controller->index(5); 
$totalUsers = $controller->totalCount();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];
    $deleted = $controller->deleteUser($deleteId);

    if ($deleted) {
        $_SESSION['success'] = "User deleted successfully";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error'] = "Failed to delete User.";
        header("Location: index.php");
        exit();
    }
}

$users = $controller->index();