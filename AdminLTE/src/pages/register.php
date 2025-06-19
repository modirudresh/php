<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="card card-outline card-primary w-screen">
    <div class="card-header text-center">
    <h1><b class="h4">Admin</b>LTE</h1>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form id="userForm" action="registerAction.php" method="post">
        <div class="row">
          <div class="col-md-6 mb-3">
            <div class="input-group">
              <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First name">
              <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-user"></span></div>
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="input-group">
              <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last name">
              <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-user"></span></div>
              </div>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address">
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" class="form-control password" id="password" name="password" placeholder="Enter password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fa fa-eye toggle icon" style="cursor: pointer;"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Retype password">
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-8">
            <div class="icheck-primary input-group ">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
                I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
        </div>
      </form>
      <div class="text-right">
        <p class="text-center mb-0">Already have an account?
          <a href="login.php">Login</a>
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
      first_name: { required: true, minlength: 3, pattern: /^[A-Za-z\s'-]+$/ },
      last_name: { required: true, minlength: 3, pattern: /^[A-Za-z\s'-]+$/ },
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
      first_name: { required: "First name is required", minlength: "Minimum 3 characters" },
      last_name: { required: "Last name is required", minlength: "Minimum 3 characters" },
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
