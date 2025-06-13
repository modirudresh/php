<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Cookies</title>
    <link rel="shortcut icon" href="./php.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
  @include('./header.html');
?>
  <div class="page">
<?php
$cookie_name = "user";
$cookie_value = "John Doe";
setcookie($cookie_name, $cookie_value, time() + (300), "/"); // 86400 = 1 day

if(isset($_COOKIE[$cookie_name])) {
    echo "Cookie '" . $cookie_name . "' is set!<br>";
    echo "Value is: " . $_COOKIE[$cookie_name] . "<br/>";
} else {
  echo "Cookie named '" . $cookie_name . "' is not set!<br/>";
}
?>

<?php
if(count($_COOKIE) > 0) {
  echo "Cookies are enabled.";
} else {
  echo "Cookies are disabled.";
}
?>
</div>
</body>
</html>