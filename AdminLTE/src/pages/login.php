<?php
session_start();

if (isset($_SESSION['user_id'])) {

  header("Location: dashboard.php");
  exit();
}
if (isset($_SESSION['logout_message'])) {
    echo '<div class="alert alert-info alert-dismissible fade show" role="alert">'
       . htmlspecialchars($_SESSION['logout_message']) .
       '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    unset($_SESSION['logout_message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in (v2)</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <style>
    * {
      box-sizing: border-box;
      font-size: 14px;
    }

    body {
      font-family: 'Source Sans Pro', sans-serif;
      background-color: #f4f6f9;
    }
  </style>
</head>
<body class="hold-transition login-page"><div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
    <h1><b class="h4">Admin</b>LTE</h1>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form id="userForm" action="loginAction.php" method="post">
      <div class="input-group mb-3">
          <input type="email" class="form-control"
                id="email"
                name="email"
                placeholder="Enter email address"
                autocomplete="off"
                autocapitalize="off"
                spellcheck="false">
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" class="form-control password"
                id="password"
                name="password"
                placeholder="Enter password"
                autocomplete="new-password"
                autocapitalize="off"
                spellcheck="false">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fa fa-eye toggle icon" style="cursor: pointer;"></span>
            </div>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" name="remember">
              <label for="remember">Remember Me</label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </div>
      </form>

      <div class="text-right">
        <p>
          <b><a href="forgot-password.php">Forgot password?</a></b>
        </p>
        <p class="text-center mb-0">Don't have an account?
          <a href="register.php">Create account</a>
        </p>
      </div>
      
    </div>
  </div>
</div>

<?php include('../components/scripts.php'); ?>

<script>
$(function () {
  $.validator.addMethod('pattern', function (value, element, param) {
    return this.optional(element) || param.test(value);
  }, 'Invalid format.');

  $('#userForm').validate({
    rules: {
      email: { required: true, email: true },
      password: {
        required: true,
        minlength: 8,
        pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/
      },
      confirm_password: { required: true, equalTo: '#password' },
      terms: { required: true }
    },
    messages: {
      email: { required: "Email is required", email: "Enter valid email" },
      password: {
        required: "Password is required",
        minlength: "Minimum 8 characters",
        pattern: "Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character."
      },
      confirm_password: { required: "Please retype your password", equalTo: "Passwords do not match" },
      terms: { required: "Accept terms" }
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.input-group').append(error);
    },
    highlight: function (element) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element) {
      $(element).removeClass('is-invalid').addClass('is-valid');
    }
  });
});
</script>
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
  <?php if (isset($_SESSION['message'])): ?>
<script>
  toastr.options = {
    "closeButton": true,
    "progressBar": true
  };
  toastr["<?= $_SESSION['status'] ?>"]("<?= $_SESSION['message'] ?>");
</script>
<?php
unset($_SESSION['message']);
unset($_SESSION['status']);
endif;
?>

  <script src="../plugins/toastr/toastr.min.js"></script>
</body>
</html>