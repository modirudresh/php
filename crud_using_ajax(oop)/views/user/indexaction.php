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


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id']) && isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    header('Content-Type: application/json');
    $deleted = $controller->deleteUser($_POST['delete_id']);
    echo json_encode([
        'status' => $deleted ? 'success' : 'error',
        'message' => $deleted ? 'User deleted successfully' : 'Failed to delete user'
    ]);
    exit();
}

$users = $controller->index();
