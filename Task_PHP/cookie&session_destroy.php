<?php
session_start();
?>
<?php
setcookie( 'user', '', time() - 0*0*100, '/' );
?>

<!DOCTYPE html>
<html lang = 'en'>

<head>
<meta charset = 'UTF-8'>
<meta name = 'viewport' content = 'width=device-width, initial-scale=1.0'>
<title>Session destroy</title>
<link rel = 'shortcut icon' href = './php.png' type = 'image/x-icon'>
<link rel = 'stylesheet' href = 'style.css'>
</head>

<body>
<?php
session_unset();
?>
<?php
@include( './header.html' );
?>

<div class = 'page'>

</div>
</body>

</html>