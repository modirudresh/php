<?php
session_start();
?>
<!DOCTYPE html>
<html lang = 'en'>
<head>
<meta charset = 'UTF-8'>
<meta name = 'viewport' content = 'width=device-width, initial-scale=1.0'>
<title>PHP Cookies</title>
<link rel = 'shortcut icon' href = './php.png' type = 'image/x-icon'>
<link rel = 'stylesheet' href = 'style.css'>
</head>
<body>
<?php
@include( './header.html' );
?>
<div class = 'page'>
<?php
session_start();
if ( session_start() === true ) {
    echo'Session start<br>';
}

$_SESSION[ 'favcolor' ] = 'green';
$_SESSION[ 'favanimal' ] = 'cat';
echo 'Session variables are set.<br>';
echo 'Favorite color is ' . $_SESSION[ 'favcolor' ];
echo '<br> Favorite animal is ' . $_SESSION[ 'favanimal' ] . '.<br>';

print_r( $_SESSION );

?>
</div>
</body>
</html>