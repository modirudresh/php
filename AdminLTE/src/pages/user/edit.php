<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

require("../../../config/config.php");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int) $_GET['id'];

$stmt = $con->prepare("SELECT * FROM User_data WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    header("Location: index.php");
    exit();
}

$selectedHobbies = array_map('trim', explode(',', $user['hobby'] ?? ''));
$allHobbies = [
    'Reading', 'Traveling', 'Sports', 'Music',
    'Gaming', 'Watching Movies', 'Cooking', 'Photography'
];


$formData = [
    'id'         => $user['id'],
    'first_name' => $user['first_name'] ?? '',
    'last_name'  => $user['last_name'] ?? '',
    'email'      => $user['email'] ?? '',
    'phone_no'   => $user['phone_no'] ?? '',
    'DOB'        => $user['DOB'] ?? '',
    'gender'     => $user['gender'] ?? '',
    'address'    => $user['address'] ?? '',
    'country'    => $user['country'] ?? '',
    'image_path' => $user['image_path'] ?? 'uploads/default.png',
];
?>

<?php include('../header.php'); ?>
<?php include('../sidebar.php'); ?>
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6"><h1 class="m-0">Update User</h1></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Update User</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="card card-warning">
          <div class="card-header"><h3 class="card-title">Update User</h3></div>

          <?php
            if (isset($_SESSION['user_name'])) {
           ?>
          <form id="userForm" action="editAction.php" method="post" enctype="multipart/form-data">
            <div class="card-body">
              <input type="hidden" name="id" value="<?= $user['id'] ?>">
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="firstname">First Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="firstname" name="first_name"
                  value="<?= htmlspecialchars($formData['first_name']) ?>" placeholder="Enter first name">
                </div>
                <div class="form-group col-md-6">
                  <label for="lastname">Last Name <small class="text-muted">(optional)</small></label>
                  <input type="text" class="form-control" id="lastname" name="last_name"
                         value="<?= htmlspecialchars($formData['last_name'] ?? '') ?>" placeholder="Enter last name">
                </div>
              </div>

              <!-- Email, Phone -->
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="email">Email <span class="text-danger">*</span></label>
                  <input type="email" class="form-control" id="email" name="email"
                         value="<?= htmlspecialchars($formData['email'] ?? '') ?>" placeholder="Enter email address">
                </div>
                <div class="form-group col-md-6">
                  <label for="phone_no">Phone Number <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="phone_no" name="phone_no"
                         value="<?= htmlspecialchars($formData['phone_no'] ?? '') ?>" placeholder="Enter 10-digit number" maxlength="10">
                </div>
              </div>
              <!-- DOB, Profile Image -->
              <div class="row">
              <div class="form-group col-md-2">
                    <small class="form-text text-muted">Current Image:</small>
                    <img src="./<?= (!empty($user['image_path']) && file_exists($user['image_path']) ? $user['image_path'] : '../../assets/img/profile.png') ?>" alt="Profile" class="img-thumbnail mt-1 shadow-lg" style="height: 80px; width:auto;">
                </div>

                <div class="form-group col-md-5">
                    <label for="image_path">
                        Profile Image 
                        <small class="form-text text-muted d-inline-block ml-1">(Optional)</small>
                    </label>
                    <input type="hidden" name="existing_image" value="<?= htmlspecialchars($user['image_path'] ?? '') ?>">
                    <div class="custom-file">
                        <input type="file" 
                              class="custom-file-input" 
                              id="image_path" 
                              name="image_path" 
                              accept="image/*">
                        <label class="custom-file-label" for="image_path">Choose file</label>
                    </div>
                    <small class="form-text text-muted">
                        Allowed: JPG, JPEG, PNG, GIF. Max size: 2MB.
                    </small>
                </div>

                
                <div class="form-group col-md-5">
                <label for="DOB">Date of Birth <span class="text-danger">*</span></label>
                <div class="input-group date" id="dobPicker" data-target-input="nearest">
                  <input type="text" 
                        class="form-control datetimepicker-input" 
                        data-target="#dobPicker" 
                        id="DOB" 
                        name="DOB"
                        value="<?= !empty($formData['DOB']) ? date('Y-m-d', strtotime($formData['DOB'])) : '' ?>"

                        placeholder="Select date of birth" />
                        
                  <div class="input-group-append" data-target="#dobPicker" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>
            </div>

              <!-- Gender -->
              <div class="row">
                  <div class="form-group col-md-6">
                    <label class="d-block">Gender <span class="text-danger">*</span></label>
                      <div class="bg-light form-control rounded shadow-sm" style="height:max-content;">
                        <?php
                        $genders = ['male' => 'Male', 'female' => 'Female', 'other' => 'Other'];
                        foreach ($genders as $key => $label) {
                            $checked = ($formData['gender'] === $key) ? 'checked' : '';
                            echo "<div class='form-check form-check-inline'>
                                    <input class='form-control' type='radio' name='gender' id='gender_$key' value='$key' $checked>
                                    <label class='form-check-label ml-1' for='gender_$key'>$label</label>
                                  </div>";
                        }
                        ?>
                      </div>
                  </div>

                <!-- Hobbies -->
                <div class="form-group col-md-6">
                  <label>Hobbies<span class="text-danger">*</span> <small class="text-muted">(Select at least one)</small></label><br>
                  <div class="bg-light form-control rounded shadow-sm" style="height:max-content;">
                  <?php
                      foreach ($allHobbies as $hobby) {
                          $checked = in_array($hobby, $selectedHobbies) ? 'checked' : '';
                          echo "<div class='form-check form-check-inline'>
                                  <input type='checkbox' name='hobby[]' value='" . htmlspecialchars($hobby) . "' $checked>
                                  <label class='form-check-label ml-1'>" . htmlspecialchars($hobby) . "</label>
                                </div>";
                      }
                    ?>
                    </div>
                </div>
              </div>

              <!-- Address, Country -->
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="address">Address <span class="text-danger">*</span></label>
                  <textarea class="form-control" id="address" name="address" rows="4"
                            placeholder="Enter your address"><?= htmlspecialchars($formData['address'] ?? '') ?></textarea>
                </div>

                <div class="form-group col-md-6">
                  <label for="country">Country <span class="text-danger">*</span></label>
                  <select class="form-control" name="country" id="country">
                    <option value="" disabled <?= empty($formData['country']) ? 'selected' : '' ?>>Select From Here</option>
                    <option value="india" <?= ($formData['country'] ?? '') === 'india' ? 'selected' : '' ?>>🇮🇳 India</option>
                    <option value="UK" <?= ($formData['country'] ?? '') === 'UK' ? 'selected' : '' ?>>🇬🇧 UK</option>
                    <option value="russia" <?= ($formData['country'] ?? '') === 'russia' ? 'selected' : '' ?>>🇷🇺 Russia</option>
                    <option value="usa" <?= ($formData['country'] ?? '') === 'usa' ? 'selected' : '' ?>>🇺🇸 USA</option>
                  </select>
                </div>
              </div>

            </div>

            <div class="card-footer">
              <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">Cancel</button>
              <button type="submit" name="update" class="btn btn-warning float-right">Update User</button>
            </div>
          </form>

          <?php
            } else {
              echo "<div class='alert alert-warning' style='min-height: 100px; margin-top:10px;'>Please log in to view the user list.<br><a href='../login.php' class='btn btn-primary' style='text-decoration:none;'>Login</a></div>";
            }
?>
        </div>
      </div>
    </section>
  </div>

  <?php include('../footer.php'); ?>

</div>



<script src="../../plugins/jquery/jquery.min.js"></script>
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="../../plugins/jquery-validation/additional-methods.min.js"></script>
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

<script>
  $(function () {
        $.validator.addMethod('filesize', function (value, element, param) {
          if (element.files.length === 0) return true;
          return element.files[0].size <= param;
        }, function (param, element) {
          return `File must be under ${(param / 1048576).toFixed(1)} MB`;
        });

        $.validator.addMethod('pattern', function (value, element, pattern) {
          if (this.optional(element)) return true;
          return pattern.test(value);
        }, 'Invalid format.');

        // Form validation
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
              pattern: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/
            },
            phone_no: {
              required: true,
              digits: true,
              minlength: 10,
              maxlength: 10,
              pattern: /^[6-9]\d{9}$/
            },
            DOB: { required: true, date: true },
            gender: { required: true },
            'hobby[]': { required: true, minlength: 1 },
            address: {
              required: true,
              minlength: 10,
              pattern: /^[A-Za-z0-9\s,.'-]{10,}$/
            },
            country: { required: true },
            image_path: {
              extension: "jpg|jpeg|png|gif",
              filesize: 2 * 1024 * 1024 
            }
          },
          messages: {
            first_name: {
              required: "Please enter your first name",
              minlength: "Minimum 3 characters",
              pattern: "Only letters, spaces, apostrophes, and hyphens allowed"
            },
            last_name: {
              minlength: "Minimum 3 characters",
              pattern: "Only letters, spaces, apostrophes, and hyphens allowed"
            },
            email: {
              required: "Please enter your email address",
              email: "Invalid email format",
              pattern: "Please enter a valid email address"
            },
            phone_no: {
              required: "Please enter your phone number",
              digits: "Only digits allowed",
              minlength: "Must be 10 digits",
              maxlength: "Must be 10 digits",
              pattern: "Enter a valid phone number starting with digits 6 to 9"
            },
            DOB: "Please select your date of birth",
            gender: "Please select a gender",
            'hobby[]': "Please select at least one hobby",
            address: {
              required: "Please enter your address",
              minlength: "At least 10 characters required",
              pattern: "Only letters, numbers, and , . ' - characters allowed"
            },
            country: "Please select your country",
            image_path: {
              extension: "Only JPG, JPEG, PNG, or GIF allowed",
              filesize: "File must be under 2MB"
            },
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
        $(element).addClass('is-invalid');
        $(element).closest('.form-group').find('.bg-light').addClass('is-invalid');
      },
          unhighlight: function (element) {
            $(element).removeClass('is-invalid').addClass('is-valid');
          }
        });

        // Initialize datepicker
        $('#dobPicker').datetimepicker({
          format: 'YYYY-MM-DD',
          useCurrent: false,
          maxDate: moment().subtract(18, 'years'),
          minDate: moment().subtract(100, 'years'),
          defaultDate: "<?= !empty($formData['DOB']) ? date('Y-m-d', strtotime($formData['DOB'])) : '' ?>"
        });

        // Bootstrap file input label update
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
