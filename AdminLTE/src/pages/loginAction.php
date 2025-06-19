<?php
session_start();
require_once('../../config/config.php');

ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $_SESSION['message'] = 'Email and password cannot be empty.';
        $_SESSION['status'] = 'error';
        header("Location: login.php?error=empty");
        exit();
    }

    $stmt = $con->prepare("SELECT id, first_name, last_name, email, password FROM User WHERE email = ?");
    if (!$stmt) {
        error_log("Prepare failed: " . $con->error);
        $_SESSION['message'] = 'Server error, please try again later.';
        $_SESSION['status'] = 'error';
        header("Location: login.php?error=server");
        exit();
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['message'] = 'Login successful!';
            $_SESSION['status'] = 'success';

            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['message'] = 'Invalid email or password.';
            $_SESSION['status'] = 'error';
            header("Location: login.php?error=invalid");
            exit();
        }
    } else {
        $_SESSION['message'] = 'Email not found.';
        $_SESSION['status'] = 'error';
        header("Location: login.php?error=notfound");
        exit();
    }

    $stmt->close();
    $con->close();
} else {
    $_SESSION['message'] = 'Invalid access method.';
    $_SESSION['status'] = 'error';
    header("Location: ../login.php");
    exit();
}
