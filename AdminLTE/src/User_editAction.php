<?php
session_start();
require_once('../config/config.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);

$message = '';
$status = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id         = $_POST['id'] ?? null;
    $firstName  = trim($_POST['first_name'] ?? '');
    $lastName   = trim($_POST['last_name'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $address    = trim($_POST['address'] ?? '');
    $dob        = $_POST['DOB'] ?? '';
    $phone      = trim($_POST['phone_no'] ?? '');
    $gender     = $_POST['gender'] ?? '';
    $hobbies    = $_POST['hobby'] ?? [];
    $country    = $_POST['country'] ?? '';
    $imagePath  = $_POST['existing_image'] ?? '';

    $hobbyStr = implode(', ', $hobbies);

    // Handle image upload if a new file is provided
    if (isset($_FILES['image_path']) && $_FILES['image_path']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $fullUploadDir = __DIR__ . '/' . $uploadDir;

        if (!is_dir($fullUploadDir)) {
            mkdir($fullUploadDir, 0755, true);
        }

        $tmpName = $_FILES['image_path']['tmp_name'];
        $originalName = basename($_FILES['image_path']['name']);
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($ext, $allowed)) {
            $errors['image_path'] = 'Allowed file types: jpg, jpeg, png, gif.';
        } elseif ($_FILES['image_path']['size'] > 2 * 1024 * 1024) {
            $errors['image_path'] = 'File size must be less than 2MB.';
        } else {
            $newFileName = uniqid('img_', true) . '.' . $ext;
            $imagePath = $uploadDir . $newFileName;
            $absolutePath = $fullUploadDir . $newFileName;

            if (!move_uploaded_file($tmpName, $absolutePath)) {
                $errors['image_path'] = 'Image upload failed.';
            }
        }
    }

    // Fallback to existing image if no new upload
    if (empty($imagePath) && isset($_POST['existing_image'])) {
        $imagePath = $_POST['existing_image'];
    }

    // Proceed if no errors
    if (empty($errors)) {
        $stmt = $con->prepare("
            UPDATE User 
            SET 
                first_name = ?, 
                last_name = ?, 
                email = ?, 
                image_path = ?, 
                address = ?, 
                DOB = ?, 
                phone_no = ?, 
                gender = ?, 
                hobby = ?, 
                country = ?, 
                updated_at = NOW()
            WHERE id = ?
        ");

        if (!$stmt) {
            $_SESSION['message'] = 'Database prepare error: ' . $con->error;
            $_SESSION['status'] = 'error';
        } else {
            $stmt->bind_param(
                'ssssssssssi',
                $firstName,
                $lastName,
                $email,
                $imagePath,
                $address,
                $dob,
                $phone,
                $gender,
                $hobbyStr,
                $country,
                $id
            );

            if ($stmt->execute()) {
                $_SESSION['message'] = 'User updated successfully.';
                $_SESSION['status'] = 'success';
            } else {
                $_SESSION['message'] = 'Execute error: ' . $stmt->error;
                $_SESSION['status'] = 'error';
            }

            $stmt->close();
        }
    } else {
        $_SESSION['message'] = 'Please correct the errors below.';
        $_SESSION['status'] = 'error';
    }

    // Redirect immediately to index page
    header('Location: ./User_index.php');
    exit();
}
?>
