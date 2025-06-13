<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (isset($_SESSION['id'])) {
    header("Location: home.php");
    exit;
}

include "config.php";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = mysqli_prepare($con, $sql);

    mysqli_stmt_bind_param($stmt, "s", $email);  

    mysqli_stmt_execute($stmt);

    $res = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);

        $password = $row['password'];
        $decrypt = password_verify($pass, $password);

        if ($decrypt) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("location: home.php");
            exit;
        } else {
            $message = "Wrong Password";
        }
    } else {
        $message = "Wrong Email or Password";
    }
} else {
    $message = "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="css/style1.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
  <div class="container">
    <div class="form-box box">
      <?php if ($message) : ?>
        <div class="message">
            <p><?php echo $message; ?></p>
        </div><br>
        <a href="login.php"><button class="btn">Go Back</button></a>
      <?php endif; ?>
      <header>Login</header>
      <hr>
      <form action="#" method="POST" class="form-container">
        <div class="form-box">
            <div class="input-container">
                <i class="fa fa-envelope icon"></i>
                <input class="input-field" type="email" placeholder="Email Address" autocomplete="new-email" name="email" required>
            </div>
            <div class="input-container">
                <i class="fa fa-lock icon"></i>
                <input class="input-field password" type="password" placeholder="Password" autocomplete="new-password" name="password" required>
                <i class="fa fa-eye toggle icon" style="cursor: pointer;"></i>
            </div>

            <div class="remember">
                <input type="checkbox" class="check" name="remember_me" id="remember">
                <label for="remember">Remember me</label>
                <span><a href="forgot.php">Forgot password</a></span>
            </div>
        </div>
        <div class="button-container">
        <input type="submit" name="login" id="submit" value="Login" class="button">
    </div>
        <div class="links">
            Don't have an account? <a href="register.php">Signup Now</a>
        </div>
      </form>
    </div>
  </div>
  <script>
    const toggle = document.querySelector(".toggle"),
        input = document.querySelector(".password");

    toggle.addEventListener("click", () => {
        if (input.type === "password") {
            input.type = "text";
            toggle.classList.replace("fa-eye-slash", "fa-eye");
        } else {
            input.type = "password";
            toggle.classList.replace("fa-eye", "fa-eye-slash");
        }
    });
  </script>
</body>
</html>
