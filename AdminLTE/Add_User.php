<?php
session_start();
$formData = $_SESSION['form_data'] ?? [];
unset($_SESSION['form_data']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include('components/head.html'); ?>
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css"/>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <?php include('components/navbar.html'); ?>
  <?php include('components/sidebar.html'); ?>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6"><h1 class="m-0">Add New User</h1></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Add User</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="card card-primary">
          <div class="card-header"><h3 class="card-title">Add User</h3></div>

          <form id="userForm" action="insertAction.php" method="post" enctype="multipart/form-data">
            <div class="card-body">

              <div class="row">
                <div class="form-group col-md-6">
                  <label for="firstname">First Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="firstname" name="first_name"
                         value="<?= htmlspecialchars($formData['first_name'] ?? '') ?>" placeholder="Enter first name">
                </div>
                <div class="form-group col-md-6">
                  <label for="lastname">Last Name <small class="text-muted">(optional)</small></label>
                  <input type="text" class="form-control" id="lastname" name="last_name"
                         value="<?= htmlspecialchars($formData['last_name'] ?? '') ?>" placeholder="Enter last name">
                </div>
              </div>

              <div class="row">
  <div class="form-group col-md-6">
    <label for="email">Email <span class="text-danger">*</span></label>
    <input
      type="email"
      class="form-control"
      id="email"
      name="email"
      autocomplete="off"
      value="<?= htmlspecialchars($formData['email'] ?? '') ?>"
      placeholder="Enter email address"
    >
  </div>
  <div class="form-group col-md-6">
    <label for="phone_num">Phone Number <span class="text-danger">*</span></label>
    <input
      type="text"
      class="form-control"
      id="phone_num"
      name="phone_num"
      autocomplete="off"
      value="<?= htmlspecialchars($formData['phone_num'] ?? '') ?>"
      placeholder="Enter 10-digit number"
      maxlength="10"
    >
  </div>
</div>

              <div class="row">
                <div class="form-group col-md-6">
                  <label for="password">Password <span class="text-danger">*</span></label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" autocomplete="new-password">
                </div>
                <div class="form-group col-md-6">
                  <label for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
                  <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Re-enter password">
                </div>
              </div>

              <div class="row">
                <div class="form-group col-md-6">
                  <label for="DOB">Date of Birth <span class="text-danger">*</span></label>
                  <div class="input-group date" id="dobPicker" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" data-target="#dobPicker" id="DOB" name="DOB"
                           value="<?= htmlspecialchars($formData['DOB'] ?? '') ?>" placeholder="Select date of birth"/>
                    <div class="input-group-append" data-target="#dobPicker" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="profile_img">Profile Image <span class="text-danger">*</span></label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="profile_img" name="profile_img" accept="image/*">
                    <label class="custom-file-label" for="profile_img">Choose file</label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-md-6">
                  <label>Gender <span class="text-danger">*</span></label><br>
                  <?php
                  $genders = ['male' => 'Male', 'female' => 'Female', 'other' => 'Other'];
                  foreach ($genders as $key => $label) {
                      $checked = (isset($formData['gender']) && $formData['gender'] === $key) ? 'checked' : '';
                      echo "<div class='form-check form-check-inline'>
                              <input class='form-check-input' type='radio' name='gender' value='$key' $checked>
                              <label class='form-check-label'>$label</label>
                            </div>";
                  }
                  ?>
                </div>

                <div class="form-group col-md-6">
  <label>Hobbies <small class="text-muted">(Select at least one)</small></label><br>
  <?php
  $hobbies = ["Travelling", "Watch Movies", "Reading", "Cooking", "Photography", "Gaming", "Music"];
  $selectedHobbies = $formData['hobby'] ?? [];
  foreach ($hobbies as $hobby) {
      $checked = (is_array($selectedHobbies) && in_array($hobby, $selectedHobbies)) ? 'checked' : '';
      $label = $hobby === "Watch Movies" ? "Watching Movies" : $hobby;
      echo "<div class='form-check form-check-inline'>
              <input class='form-check-input' type='checkbox' name='hobby[]' value='" . htmlspecialchars($hobby) . "' $checked>
              <label class='form-check-label'>" . htmlspecialchars($label) . "</label>
            </div>";
  }
  ?>
</div>
</div>
<div class="row">
  <div class="form-group col-md-6">
    <label for="address">Address <span class="text-danger">*</span></label>
    <textarea
      class="form-control <?= isset($errors['address']) ? 'is-invalid' : '' ?>"
      id="address"
      name="address"
      rows="4"
      placeholder="Enter your address"
    ><?= htmlspecialchars($formData['address'] ?? '') ?></textarea>
    <?php if (!empty($errors['address'])): ?>
      <div class="invalid-feedback"><?= htmlspecialchars($errors['address']) ?></div>
    <?php endif; ?>
  </div>

  <div class="form-group col-md-6">
    <label for="country">Country <span class="text-danger">*</span></label>
    <select
      class="form-control <?= isset($errors['country']) ? 'is-invalid' : '' ?>"
      name="country"
      id="country"
      required
    >
      <option value="" disabled <?= empty($formData['country']) ? 'selected' : '' ?>>Select From Here</option>
      <option value="india" <?= (isset($formData['country']) && $formData['country'] === 'india') ? 'selected' : '' ?>>🇮🇳 India</option>
      <option value="UK" <?= (isset($formData['country']) && $formData['country'] === 'UK') ? 'selected' : '' ?>>🇬🇧 UK</option>
      <option value="russia" <?= (isset($formData['country']) && $formData['country'] === 'russia') ? 'selected' : '' ?>>🇷🇺 Russia</option>
      <option value="usa" <?= (isset($formData['country']) && $formData['country'] === 'usa') ? 'selected' : '' ?>>🇺🇸 USA</option>
    </select>
    <?php if (!empty($errors['country'])): ?>
      <div class="invalid-feedback"><?= htmlspecialchars($errors['country']) ?></div>
    <?php endif; ?>
  </div>
</div>

            </div>

            <div class="card-footer">
              <button type="button" class="btn btn-secondary" onclick="window.location.href='User_index.php'">Cancel</button>
              <button type="submit" name="submit" class="btn btn-primary float-right">Add User</button>
            </div>
          </form>
        </div>
      </div>
    </section>
  </div>

  <?php include('components/footer.php'); ?>
</div>

<?php include('components/scripts.html'); ?>

<!-- JS Scripts -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="plugins/jquery-validation/additional-methods.min.js"></script>
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

<script>
  $(function () {
    $.validator.addMethod('filesize', function (value, element, param) {
      if (element.files.length === 0) return true;
      return element.files[0].size <= param;
    }, 'File size must be less than {0} bytes.');

    $('#userForm').validate({
      rules: {
        first_name: { required: true, minlength: 3 },
        last_name: { minlength: 3 },
        email: { required: true, email: true },
        phone_num: {
          required: true,
          digits: true,
          minlength: 10,
          maxlength: 10
        },
        password: { required: true, minlength: 8 },
        confirm_password: {
          required: true,
          equalTo: "#password"
        },
        DOB: { required: true, date: true },
        gender: { required: true },
        'hobby[]': { required: true, minlength: 1 },
        address: { required: true, minlength: 10 },
        country: { required: true },
        profile_img: {
          required: true,
          extension: "jpg|jpeg|png|gif",
          filesize: 2097152 // 2MB
        }
      },
      messages: {
        first_name: {
          required: "Please enter your first name",
          minlength: "Minimum 3 characters"
        },
        last_name: {
          minlength: "Minimum 1 character"
        },
        email: "Please enter a valid email address",
        phone_num: {
          required: "Please enter your phone number",
          digits: "Only digits allowed",
          minlength: "Must be 10 digits",
          maxlength: "Must be 10 digits"
        },
        password: {
          required: "Please provide a password",
          minlength: "Minimum 8 characters"
        },
        confirm_password: {
          required: "Please confirm your password",
          equalTo: "Passwords do not match"
        },
        DOB: "Please select your date of birth",
        gender: "Please select a gender",
        'hobby[]': "Please select at least one hobby",
        address: {
          required: "Please enter your address",
          minlength: "At least 10 characters required"
        },
        country: "Please select your country",
        profile_img: {
          required: "Please upload a profile image",
          extension: "Only JPG, JPEG, PNG, or GIF allowed",
          filesize: "File must be under 2MB"
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
          element.closest('.form-group').append(error);
        } else if (element.hasClass('custom-file-input')) {
          element.closest('.custom-file').append(error);
        } else {
          element.closest('.form-group').append(error);
        }
      },
      highlight: function (element) {
        $(element).removeClass('is-valid').addClass('is-invalid');
      },
      unhighlight: function (element) {
        $(element).removeClass('is-invalid').addClass('is-valid');
      }
    });

    // Initialize date picker
    $('#dobPicker').datetimepicker({
      format: 'YYYY-MM-DD',
      useCurrent: false,
      maxDate: moment().subtract(18, 'years'),
      minDate: moment('1924-01-01')
    });

    // Bootstrap custom file input label update
    $('.custom-file-input').on('change', function () {
      var fileName = $(this).val().split('\\').pop();
      $(this).next('.custom-file-label').html(fileName);
    });
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const selectedCountry = "<?= htmlspecialchars($formData['country'] ?? '') ?>";
    const countrySelect = document.querySelector('select[name="country"]');
    if (countrySelect && selectedCountry) {
      countrySelect.value = selectedCountry;
    }
  });
</script>

<style>
  .is-valid { border: 2px solid #28a745; }
  .is-invalid { border: 2px solid #dc3545; }
</style>

</body>
</html>
