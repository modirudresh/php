<?php

session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../Controllers/UserController.php';
use Controllers\UserController;

$controller = new UserController();

// Handle AJAX POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {

    header('Content-Type: application/json');

    // Collect and sanitize form data
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name  = trim($_POST['last_name'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $phone_no   = substr(trim($_POST['phone_no'] ?? ''), 0, 10);
    $password   = trim($_POST['password'] ?? '');
    $gender     = trim($_POST['gender'] ?? '');
    $DOB        = trim($_POST['DOB'] ?? '');
    $hobby      = $_POST['hobby'] ?? [];
    $address    = trim($_POST['address'] ?? '');
    $country    = trim($_POST['country'] ?? '');
    $image_path = '';

    // Check for duplicate email
    if ($controller->checkEmailExists($email)) {
        echo json_encode(['status' => 'error', 'message' => 'Email already exists.']);
        exit;
    }

    // Image upload
    if (isset($_FILES['image_path']) && $_FILES['image_path']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $fileTmp  = $_FILES['image_path']['tmp_name'];
        $fileExt  = strtolower(pathinfo($_FILES['image_path']['name'], PATHINFO_EXTENSION));
        $fileName = uniqid('usr_') . '.' . $fileExt;
        $uploadPath = $uploadDir . $fileName;

        if (!move_uploaded_file($fileTmp, $uploadPath)) {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload image.']);
            exit;
        }

        $image_path = 'uploads/' . $fileName;
    }

    // Call controller to add user
    $result = $controller->adduser(
        $first_name, $last_name, $email, $phone_no, $address,
        $password, $gender, $DOB, $hobby, $country, $image_path
    );

    echo json_encode([
        'status' => $result ? 'success' : 'error',
        'message' => $result ? 'User added successfully!' : 'Failed to add user.'
    ]);
    exit;
}
