<?php
session_start();

$_SESSION = [];
session_unset();
session_destroy();

// Set flash message
session_start(); // Restart session to set flash message
$_SESSION['logout_message'] = "You have been logged out successfully.";

header("Location: login.php");
exit;
