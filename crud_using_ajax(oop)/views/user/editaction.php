<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../Controllers/UserController.php';
use Controllers\UserController;

$controller = new UserController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {

    header('Content-Type: application/json');

    $id = $_POST['id'] ?? '';
    if (!is_numeric($id)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid user ID.']);
        exit;
    }

    $first_name = trim($_POST['first_name'] ?? '');
    $last_name  = trim($_POST['last_name'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $phone_no   = substr(trim($_POST['phone_no'] ?? ''), 0, 10);
    $DOB        = trim($_POST['DOB'] ?? '');
    $gender     = trim($_POST['gender'] ?? '');
    $hobby      = isset($_POST['hobby']) ? implode(',', $_POST['hobby']) : '';
    $address    = trim($_POST['address'] ?? '');
    $country    = trim($_POST['country'] ?? '');
    $existing_image = $_POST['existing_image'] ?? '';
    $image_path = $existing_image;

    if (!empty($_FILES['image_path']['name']) && $_FILES['image_path']['error'] === UPLOAD_ERR_OK) {
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $fileExt = strtolower(pathinfo($_FILES['image_path']['name'], PATHINFO_EXTENSION));

        if (in_array($fileExt, $allowedExts)) {
            if ($_FILES['image_path']['size'] <= 2 * 1024 * 1024) {
                $uploadDir = __DIR__ . '/../../uploads/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

                $fileName = uniqid('usr_') . '.' . $fileExt;
                $uploadPath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['image_path']['tmp_name'], $uploadPath)) {
                    $image_path = 'uploads/' . $fileName;

                    $oldPath = __DIR__ . '/../../' . $existing_image;
                    if ($existing_image && file_exists($oldPath) && !str_contains($existing_image, 'profile.png')) {
                        unlink($oldPath);
                    }
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Image upload failed.']);
                    exit;
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Image must be under 2MB.']);
                exit;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid image type.']);
            exit;
        }
    }

    $result = $controller->edituser(
        $id, $first_name, $last_name, $email, $phone_no, $address, $DOB,
        $gender, $hobby, $country, $image_path
    );

    if (is_array($result) && !$result['success']) {
        echo json_encode(['status' => 'error', 'message' => $result['message']]);
    } else {
        echo json_encode(['status' => 'success', 'message' => 'User updated successfully.']);
    }
    exit;
}

$id = $_GET['id'] ?? '';
if (!is_numeric($id)) {
    header('Location: index.php');
    exit;
}

$user = $controller->getuser($id);
if (!$user) {
    header('Location: index.php');
    exit;
}
