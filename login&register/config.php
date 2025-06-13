<?php
$host = 'localhost';
$user = 'root';
$pass = 'admin123';
$dbname = 'PHP_CRUD';


$con = new mysqli($host, $user, $pass, $dbname);

if ($con->connect_error) {
    die('Database connection failed: ' . $con->connect_error);
}
?>
