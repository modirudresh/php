<?php

$host = 'localhost';
$user = 'root';
$pass = 'admin123';
$dbname = 'PHP_CRUD';


$con = new mysqli($host, $user, $pass, $dbname);


if ($con->connect_error) {
    die('Error: Unable to establish a database connection. ' . $con->connect_error);
}

?>
