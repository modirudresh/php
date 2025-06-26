<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$formData = $_SESSION['formData'] ?? [];
$errors = $_SESSION['errors'] ?? [];
$status = $_SESSION['status'] ?? '';
$message = $_SESSION['message'] ?? '';
?>

<?php
include('./Dashboard_header.php');
include('./Dashboard_sidebar.php');
?>

      <div class="row mb-2">
        <div class="col-sm-6"><h1>Change Password</h1></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Change Password</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="card card-primary">
        <div class="card-header"><h3 class="card-title">Update Your Password</h3></div>
        <form id="changePasswordForm" action="change_password_action.php" method="post">
          <div class="card-body">

            <div class="form-group">
              <label for="current_password">Current Password <span class="text-danger">*</span></label>
              <input type="password" class="form-control <?= isset($errors['current_password']) ? 'is-invalid' : '' ?>" id="current_password" name="current_password" placeholder="Enter current password" required>
              <?php if (!empty($errors['current_password'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errors['current_password']) ?></div>
              <?php endif; ?>
            </div>

            <div class="form-group">
              <label for="new_password">New Password <span class="text-danger">*</span></label>
              <input type="password" class="form-control <?= isset($errors['new_password']) ? 'is-invalid' : '' ?>" id="new_password" name="new_password" placeholder="Enter new password" required>
              <?php if (!empty($errors['new_password'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errors['new_password']) ?></div>
              <?php endif; ?>
            </div>

            <div class="form-group">
              <label for="confirm_password">Confirm New Password <span class="text-danger">*</span></label>
              <input type="password" class="form-control <?= isset($errors['confirm_password']) ? 'is-invalid' : '' ?>" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
              <?php if (!empty($errors['confirm_password'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errors['confirm_password']) ?></div>
              <?php endif; ?>
            </div>

          </div>

          <div class="card-footer">
            <button type="submit" name="submit" class="btn btn-primary float-right">Change Password</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  
</div>
<?php include('./Dashboard_footer.php'); ?>

<!-- jQuery Validation -->
<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="../plugins/jquery-validation/additional-methods.min.js"></script>

<script>
$(function () {
  $('#changePasswordForm').validate({
    rules: {
      current_password: {
        required: true,
        minlength: 8
      },
      new_password: {
        required: true,
        minlength: 8,
        pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/
      },
      confirm_password: {
        required: true,
        equalTo: '#new_password'
      }
    },
    messages: {
      current_password: {
        required: "Please enter your current password",
        minlength: "At least 8 characters"
      },
      new_password: {
        required: "Please enter a new password",
        minlength: "At least 8 characters",
        pattern: "Must include uppercase, lowercase, number & special character"
      },
      confirm_password: {
        required: "Please confirm your new password",
        equalTo: "Passwords do not match"
      }
    },
    errorElement: 'span',
    errorPlacement: function(error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function(element) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function(element) {
      $(element).removeClass('is-invalid').addClass('is-valid');
    }
  });
});
</script>

<style>
  .is-valid { border: 2px solid #28a745; }
  .is-invalid { border: 2px solid #dc3545; }
</style>

<?php if (!empty($message)) : ?>
<script>
  $(function () {
    toastr.options = {
      closeButton: true,
      progressBar: true,
      timeOut: 3000,
      positionClass: "toast-top-right"
    };
    <?php if ($status === 'success'): ?>
      toastr.success("<?= addslashes($message) ?>");
    <?php else: ?>
      toastr.error("<?= addslashes($message) ?>");
      <?php foreach ($errors as $err): ?>
        toastr.error("<?= addslashes($err) ?>");
      <?php endforeach; ?>
    <?php endif; ?>
  });
</script>
<?php endif; ?>
