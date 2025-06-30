<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../Controllers/StudentController.php';
use Controllers\StudentController;

$controller = new StudentController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {

    header('Content-Type: application/json');

    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone_no = trim($_POST['phone_no'] ?? '');
    $address = trim($_POST['address'] ?? '');

    if ($controller->emailExists($email)) {
        echo json_encode(['status' => 'error', 'message' => 'Email already exists.']);
        exit;
    }

    $phone_no = substr(trim($phone_no), 0, 10);

    $result = $controller->addStudent($first_name,$last_name,$email,$phone_no,$address);

    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Student added successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add Student.']);
    }

    exit;
}