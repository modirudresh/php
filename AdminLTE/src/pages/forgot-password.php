<!DOCTYPE html>
<html lang="en">
<head>
  <?php include('./components/head.html'); ?>
  <title>Forgot Password</title>
  <link rel="stylesheet" href="./plugins/toastr/toastr.min.css">
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <h1><b class="h4">Admin</b>LTE</h1>
    </div>
    <div class="card-body">
      <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
      <form id="userForm" action="recover-password.html" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" id="email" name="email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Request new password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <p class="mt-3 mb-1 float-right">
        <a href="login.php">Back to Login</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>

<!-- /.login-box -->
<?php include('./components/scripts.html'); ?>
<script>
    $(function () {
  $.validator.addMethod('pattern', function (value, element, param) {
    return this.optional(element) || param.test(value);
  }, 'Invalid format.');

  $('#userForm').validate({
    rules: {
      email: { required: true, email: true }
    },
    messages: {
      email: { required: "Please enter your email", email: "Enter valid email" }
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
<script src="./plugins/toastr/toastr.min.js"></script>
<script>
  $(document).ready(function() {
    <?php if (isset($_SESSION['message'])): ?>
      toastr.<?php echo $_SESSION['status']; ?>("<?php echo $_SESSION['message']; ?>");
      <?php unset($_SESSION['message'], $_SESSION['status']); ?>
    <?php endif; ?>
  });
</script>
</div>
</body>
</html>
