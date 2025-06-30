<?php
session_start();
require_once('../../config/config.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);

$message = '';
$status = '';
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $terms = $_POST['terms'] ?? '';

    if (
        empty($first_name) || strlen($first_name) < 3 ||
        empty($last_name) || strlen($last_name) < 3 ||
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        strlen($password) < 8 || $password !== $confirm_password ||
        $terms !== 'agree'
    ) {
        die("Validation failed.");
        $_SESSION['message'] = 'Validation failed.';
        $_SESSION['status'] = 'error';
    }

    // Check if email already exists
    $stmt = $con->prepare("SELECT id FROM User_data WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        die("Email already exists.");
        $_SESSION['message'] = 'Email already exists.';
        $_SESSION['status'] = 'error';
    }
    $stmt->close();

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $stmt = $con->prepare("INSERT INTO User_data (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $first_name, $last_name, $email, $hashed_password);

    if ($stmt->execute()) {
        header("Location: login.php?success=1");
        $_SESSION['message'] = 'Registration successful! You can now log in.';
        $_SESSION['status'] = 'success';
        exit();
    } else {
        error_log("Error executing statement: " . $stmt->error);
        $stmt->close();
        $con->close();
        header("Location: ../register.php?error=1");
        $_SESSION['message'] = 'Registration failed. Please try again later.';
        $_SESSION['status'] = 'error';
        exit();
    }
} else {
    die("Invalid access.");
    $_SESSION['message'] = 'Invalid access method.';
    $_SESSION['status'] = 'error';
    header("Location: ../register.php");
    exit();
}
?>