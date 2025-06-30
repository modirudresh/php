<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../Controllers/UserController.php';
use Controllers\UserController;

$controller = new UserController();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user = $controller->getUser($_GET['id']);
    if (!$user) {
        echo '<div class="alert alert-danger">User not found.</div>';
        exit;
    }
} else {
    echo '<div class="alert alert-danger">Invalid request.</div>';
    exit;
}
?>
