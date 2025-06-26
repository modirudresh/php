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
include('../../header.php');
include('../../sidebar.php');
?>

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
          <?php
            if (isset($_SESSION['user_name'])) {
           ?>
          <form id="userForm" action="createAction.php" method="post" enctype="multipart/form-data">
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
                  <label for="phone_no">Phone Number <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="phone_no" name="phone_no" autocomplete="new-phone" value="<?= htmlspecialchars($formData['phone_no'] ?? '') ?>" oninput="this.value = this.value.replace(/\D/g, '')" placeholder="Enter 10-digit number" maxlength="10">
                </div>
              </div>

              <div class="row">
                <div class="form-group col-md-6">
                  <label for="password">Password <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input type="password" class="form-control password" id="password" name="password" placeholder="Enter password" autocomplete="new-password">
                    <div class="input-group-append">
                      <div class="input-group-text">
                      <span class="fa fa-eye toggle icon" style="cursor: pointer;"></span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group col-md-6">
                  <label for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
                  <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Re-enter password">
                </div>
              </div>

              <div class="row">
              <div class="form-group col-md-6">
                <label for="dateofbirth">Date of Birth <span class="text-danger">*</span></label>
                <div class="input-group date" id="dateofbirth" data-target-input="nearest">
                  <input
                    type="text"
                    class="form-control datetimepicker-input"
                    data-target="#dateofbirth"
                    id="DOB"
                    name="DOB"
                    value="<?= htmlspecialchars($formData['DOB'] ?? '') ?>"
                    placeholder="Select Date of Birth"
                    autocomplete="off"
                  />
                  <div class="input-group-append" data-target="#dateofbirth" data-toggle="datetimepicker" style="cursor:pointer;">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>
              <div class="form-group col-md-6">
                  <label for="image_path">Profile Image <span class="text-danger">*</span></label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="image_path" name="image_path" accept="image/*">
                    <label class="custom-file-label" for="image_path">Choose file</label>
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
                    id="country">
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
              <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">Cancel</button>
              <button type="submit" name="submit" class="btn btn-primary float-right">Add User</button>
            </div>
          </form>

          <?php
            } else {
              echo "<div class='alert alert-warning' style='min-height: 100px; margin-top:10px;'>Please log in to view the user list.<br><a href='../login.php' class='btn btn-primary' style='text-decoration:none;'>Login</a></div>";
            }
?>
        </div>
      </div>


      <?php
unset($_SESSION['formData'], $_SESSION['errors'], $_SESSION['status'], $_SESSION['message']);
?>

<?php include('../../footer.php'); ?>


<script src="../../plugins/jquery/jquery.min.js"></script>
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="../../plugins/jquery-validation/additional-methods.min.js"></script>
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

<script>
    $(function () {
      $.validator.addMethod('pattern', function(value, element, param) {
        return this.optional(element) || param.test(value);
      }, 'Invalid format.');

      $('#userForm').validate({
        rules: {
          first_name: { 
            required: true, 
            minlength: 3, 
            pattern: /^[A-Za-z\s'-]+$/ 
          },
          last_name: { 
            minlength: 3,
            pattern: /^[A-Za-z\s'-]+$/
          },
          email: { 
            required: true, 
            email: true,
          },
          phone_no: { 
            required: true, 
            digits: true, 
            minlength: 10, 
            maxlength: 10,
            pattern: /^[6-9]\d{9}$/
          },
          password: {
            required: true,
            minlength: 8,
            pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/
          },
          confirm_password: { 
            required: true, 
            equalTo: '#password' 
          },
          DOB: { 
            required: true, 
            date: true 
          },
          gender: { 
            required: true 
          },
          'hobby[]': { 
            required: true, 
            minlength: 1 
          },
          address: { 
            required: true, 
            minlength: 10,
            pattern: /^[A-Za-z0-9\s,.'-]{10,}$/
          },
          country: { 
            required: true 
          },
          image_path: {
            required: true,
            extension: "jpg|jpeg|png|gif",
            filesize: 2097152 
          }
        },
        messages: {
          first_name: {
            required: "Please enter your first name",
            minlength: "Minimum 3 characters",
            pattern: "First name can contain letters, spaces, apostrophes, and hyphens only."
          },
          last_name: {
            minlength: "Minimum 3 characters",
            pattern: "Last name can contain letters, spaces, apostrophes, and hyphens only."
          },
          email: "Please enter a valid email address",
          phone_no: {
            required: "Please enter your phone number",
            digits: "Only digits allowed",
            minlength: "Must be 10 digits",
            maxlength: "Must be 10 digits",
            pattern: "Please enter a valid 10-digit mobile number starting with 6, 7, 8, or 9."
          },
          password: {
            required: "Please provide a password",
            minlength: "Minimum 8 characters",
            pattern: "Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character."
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
            minlength: "At least 10 characters required",
            pattern: "Address contains invalid characters."
          },
          country: "Please select your country",
          image_path: {
            required: "Please upload a profile image",
            extension: "Only JPG, JPEG, PNG, or GIF allowed",
            filesize: "File must be under 2MB"
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
      $('#dateofbirth').datetimepicker({
    format: 'YYYY-MM-DD',
    useCurrent: false,
    maxDate: moment().subtract(18, 'years'),
    minDate: moment().subtract(100, 'years'),
    icons: {
      time: 'far fa-clock',
      date: 'far fa-calendar',
      up: 'fas fa-chevron-up',
      down: 'fas fa-chevron-down',
      previous: 'fas fa-chevron-left',
      next: 'fas fa-chevron-right',
      today: 'far fa-calendar-check',
      clear: 'far fa-trash-alt',
      close: 'fas fa-times'
    }
});

      $('.custom-file-input').on('change', function () {
          var fileName = $(this).val().split('\\').pop();
          $(this).next('.custom-file-label').html(fileName);
      });
    });

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
<?php if (!empty($message)) : ?>
<script>
    $(function () {
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "timeOut": "3000",
            "positionClass": "toast-top-right"
        };

        <?php if ($status === 'success') : ?>
            toastr.success("<?= addslashes($message) ?>");
        <?php else : ?>
            toastr.error("<?= addslashes($message) ?>");
            <?php foreach ($errors as $err) : ?>
                toastr.error("<?= addslashes($err) ?>");
            <?php endforeach; ?>
        <?php endif; ?>
    });
</script>
<?php endif; ?>


