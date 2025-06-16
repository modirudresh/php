<?php
$errors = [];
$old = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (empty($_POST['first_name'])) {
    $errors['first_name'] = 'First name is required.';
  } elseif (strlen($_POST['first_name']) < 3) {
    $errors['first_name'] = 'First name must be at least 3 characters.';
  } else {
    $old['first_name'] = htmlspecialchars($_POST['first_name']);
  }

  if (!empty($_POST['last_name'])) {
    $old['last_name'] = htmlspecialchars($_POST['last_name']);
  }

  if (empty($_POST['phone_num'])) {
    $errors['phone_num'] = 'Phone number is required.';
  } elseif (!preg_match('/^\d{10}$/', $_POST['phone_num'])) {
    $errors['phone_num'] = 'Phone number must be exactly 10 digits.';
  } else {
    $old['phone_num'] = htmlspecialchars($_POST['phone_num']);
  }

  if (empty($_POST['email'])) {
    $errors['email'] = 'Email is required.';
  } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Invalid email.';
  } else {
    $old['email'] = htmlspecialchars($_POST['email']);
  }

  if (isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] !== UPLOAD_ERR_NO_FILE) {
    $allowed_exts = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
    $file_name = $_FILES['profile_img']['name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    if (!in_array($file_ext, $allowed_exts)) {
      $errors['profile_img'] = 'Please select a valid image file (jpg, jpeg, png, gif, bmp, webp).';
    }
  }
  
  if (empty($_POST['password'])) {
    $errors['password'] = 'Password is required.';
  } elseif (strlen($_POST['password']) < 6) {
    $errors['password'] = 'Password must be at least 6 characters.';
  }

  if (empty($_POST['confirm_password'])) {
    $errors['confirm_password'] = 'Confirm password is required.';
  } elseif ($_POST['password'] !== $_POST['confirm_password']) {
    $errors['confirm_password'] = 'Passwords do not match.';
  }

  if (empty($_POST['DOB'])) {
    $errors['DOB'] = 'Date of birth is required.';
  } else {
    $old['DOB'] = htmlspecialchars($_POST['DOB']);
  }

  if (empty($_POST['country'])) {
    $errors['country'] = 'Country is required.';
  } else {
    $old['country'] = htmlspecialchars($_POST['country']);
  }

  if (empty($_POST['gender'])) {
    $errors['gender'] = 'Gender is required.';
  } else {
    $old['gender'] = $_POST['gender'];
  }

  if (empty($_POST['hobby']) || !is_array($_POST['hobby'])) {
    $errors['hobby'] = 'At least one hobby is required.';
  } else {
    $old['hobby'] = $_POST['hobby'];
  }

  if (empty($_POST['address'])) {
    $errors['address'] = 'Address is required.';
  } else {
    $old['address'] = htmlspecialchars($_POST['address']);
  }
}

function showError($field, $errors)
{
  return isset($errors[$field]) ? '<div style="color:red;font-size:13px;" class="server-error">' . $errors[$field] . '</div>' : '';
}
function isChecked($name, $value, $old)
{
  if (!isset($old[$name])) return '';
  if (is_array($old[$name]) && in_array($value, $old[$name])) return 'checked';
  if ($old[$name] == $value) return 'checked';
  return '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add a new user</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="shortcut icon" href="Logo.png" type="image/icon">
</head>

<body>
  <?php
  include("../components/sidebar.html");
  include("../components/navbar.html");
  include("../components/breadcrumb.html");
  ?>
  <div class="shadow mb-4" style="border-radius:12px;">

    <form action="" method="post" name="Insert" enctype="multipart/form-data">

      <div class="form-row">
        <div>
          <label for="firstname">First Name <span style="color:red;">*</span></label>
          <input type="text" id="firstname" name="first_name" placeholder="John" value="<?php echo isset($old['first_name']) ? $old['first_name'] : ''; ?>" pattern=".{3,}" autocomplete="off"
            oninput="this.nextElementSibling.textContent=(this.value===''?'First name is required.':(this.value.length<3?'First name must be at least 3 characters.':''));"
            onblur="this.nextElementSibling.textContent=(this.value===''?'First name is required.':(this.value.length<3?'First name must be at least 3 characters.':''));"
          />
          <?php echo showError('first_name', $errors); ?>
        </div>
        <div>
          <label for="lastname">Last Name</label>
          <input type="text" id="lastname" name="last_name" placeholder="Doe" value="<?php echo isset($old['last_name']) ? $old['last_name'] : ''; ?>" pattern=".{3,}" autocomplete="off"
            oninput="this.nextElementSibling.textContent=(this.value===''?'Last name is required.':(this.value.length<3?'Last name must be at least 3 characters.':''));"
            onblur="this.nextElementSibling.textContent=(this.value===''?'Last name is required.':(this.value.length<3?'Last name must be at least 3 characters.':''));"
          />
           
          <?php echo showError('last_name', $errors); ?>
        </div>
        <div>
          <label for="phone_num">Phone No. <span style="color:red;">*</span></label>
          <input type="text" id="phone_num" name="phone_num" pattern="\d{10}" maxlength="10" placeholder="0123456789" value="<?php echo isset($old['phone_num']) ? $old['phone_num'] : ''; ?>" autocomplete="off"
            oninput="this.value=this.value.replace(/\D/g,'').slice(0,10);this.nextElementSibling.textContent=(this.value===''?'Phone number is required.':(this.value.length<10?'Phone number must be exactly 10 digits.':''));"
            onblur="this.nextElementSibling.textContent=(this.value===''?'Phone number is required.':(this.value.length<10?'Phone number must be exactly 10 digits.':''));"
            onkeypress="return event.charCode>=48&&event.charCode<=57"
          />
           
          <?php echo showError('phone_num', $errors); ?>
        </div>
      </div>
      <div class="form-row">
        <div>
          <label for="email">Email <span style="color:red;">*</span></label>
          <input type="email" id="email" name="email" autocomplete="off" placeholder="john@gmail.com" value="<?php echo isset($old['email']) ? $old['email'] : ''; ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
            oninput="this.parentNode.querySelector('div[style]').textContent=(this.value===''?'Email is required.':(!this.checkValidity()?'Please enter a valid email address.':''));"
            onblur="this.parentNode.querySelector('div[style]').textContent=(this.value===''?'Email is required.':(!this.checkValidity()?'Please enter a valid email address.':''));"
          />
           
          <?php echo showError('email', $errors); ?>
        </div>
        <div>
          <label for="profile_img">Profile Image</label>
          <input type="file" name="profile_img" id="profile_img" accept="image/*" pattern=".*\.(jpg|jpeg|png|gif|bmp|webp)$"
            oninput="this.nextElementSibling.textContent=(this.value && !/\.(jpg|jpeg|png|gif|bmp|webp)$/i.test(this.value))?'Please select a valid image file (jpg, jpeg, png, gif, bmp, webp).':'';"
            onblur="this.nextElementSibling.textContent=(this.value && !/\.(jpg|jpeg|png|gif|bmp|webp)$/i.test(this.value))?'Please select a valid image file (jpg, jpeg, png, gif, bmp, webp).':'';"
          />
           
        </div>
      </div>
      <div class="form-row">
        <div class="input-container" style="position: relative; display: flex; flex-direction: column;">
          <label for="password">Password <span style="color:red;">*</span></label>
          <div style="position: relative;">
            <input class="input-field password" type="password" id="password" placeholder="Password" autocomplete="new-password" name="password" style="padding-right: 38px; width: 100%;"
              value="<?php echo isset($old['password']) ? $old['password'] : ''; ?>"
              oninput="this.parentNode.querySelector('.password-error').textContent=(this.value===''?'Password is required.':(this.value.length<6?'Password must be at least 6 characters.':''));"
              onblur="this.parentNode.querySelector('.password-error').textContent=(this.value===''?'Password is required.':(this.value.length<6?'Password must be at least 6 characters.':''));"
            />
            <span class="fa fa-eye toggle icon" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #888; font-size: 18px; z-index: 10;"></span>
            <div class="password-error" style="color:red;font-size:13px;"></div>
          </div>
          <?php echo showError('password', $errors); ?>
        </div>
        <div class="input-container" style="position: relative; display: flex; flex-direction: column;">
          <label for="confirm_password">Confirm Password <span style="color:red;">*</span></label>
          <div style="position: relative;">
            <input class="input-field password" type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" autocomplete="new-password" style="padding-right: 38px; width: 100%;"
              value="<?php echo isset($old['confirm_password']) ? $old['confirm_password'] : ''; ?>"
              oninput="this.parentNode.querySelector('.confirm-password-error').textContent=(this.value===''?'Confirm password is required.':(this.value!==document.getElementById('password').value?'Passwords do not match.':''));"
              onblur="this.parentNode.querySelector('.confirm-password-error').textContent=(this.value===''?'Confirm password is required.':(this.value!==document.getElementById('password').value?'Passwords do not match.':''));"
            />
            <span class="fa fa-eye toggle icon" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #888; font-size: 18px; z-index: 10;"></span>
            <div class="confirm-password-error" style="color:red;font-size:13px;"></div>
          </div>
          <?php echo showError('confirm_password', $errors); ?>
        </div>
      </div>
      <div class="form-row">
        <div>
          <label for="DOB">Date of Birth <span style="color:red;">*</span></label>
          <input type="text" id="datepicker" name="DOB" placeholder="YYYY-MM-DD"
            value="<?php echo $old['DOB'] ?? ''; ?>" autocomplete="off" readonly
            oninput="this.nextElementSibling.textContent=this.value?'':'Date of birth is required.';">
          <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
          <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js"></script>
          <script>
            $(function () {
              $('#datepicker').datepicker({
          uiLibrary: 'bootstrap5',
          format: 'yyyy-mm-dd',
          minDate: '1924-01-01',
          maxDate: '2005-12-31'
              });
            });
          </script>
          <?php echo showError('DOB', $errors); ?>
        </div>
        <div>
           
          <label for="country">Country <span style="color:red;">*</span></label>
          <?php include("../components/dropdown.html"); ?>
          <?php echo showError('country', $errors); ?>
          <script>
            document.addEventListener('DOMContentLoaded', function () {
              var oldCountry = "<?php echo isset($old['country']) ? $old['country'] : ''; ?>";
              if (oldCountry) {
                var select = document.querySelector('select[name="country"]');
                if (select) select.value = oldCountry;
              }
              var countrySelect = document.querySelector('select[name="country"]');
              if (countrySelect) {
                countrySelect.setAttribute('pattern', '.+');
                countrySelect.oninput = function () {
                  this.parentNode.querySelector('div[style]').textContent = (this.value === '') ? 'Country is required.' : '';
                };
                countrySelect.onblur = function () {
                  this.parentNode.querySelector('div[style]').textContent = (this.value === '') ? 'Country is required.' : '';
                };
              }
            });
          </script>
           
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label class="form-label mb-1">Gender <span class="text-danger">*</span></label>
          <div class="gender box radios" style="padding: 8px 15px;">
            <?php
            $genders = ['Male', 'Female', 'Other'];
            foreach ($genders as $gender) {
              $id = 'gender' . $gender;
              echo '<div class="form-check form-check-inline" style="margin-right: 18px; margin-bottom: 6px;">
                <input class="form-check-input" type="radio" name="gender" id="' . $id . '" value="' . $gender . '" ' . isChecked('gender', $gender, $old) . ' onclick="document.getElementById(\'genderError\').textContent=\'\';" />
                <label class="form-check-label" for="' . $id . '">' . $gender . '</label>
              </div>';
            }
            ?>
          </div>
          <div id="genderError" style="color:red;font-size:13px;"></div>
          <?php echo showError('gender', $errors); ?>
          <script>
            document.addEventListener('DOMContentLoaded', function () {
              var genderInputs = document.querySelectorAll('input[name="gender"]');
              genderInputs.forEach(function (input) {
                input.onblur = function () {
                  var checked = Array.from(genderInputs).some(function (i) { return i.checked; });
                  document.getElementById('genderError').textContent = checked ? '' : 'Gender is required.';
                };
              });
            });
          </script>
        </div>
        <div class="form-group col-md-6">
          <label class="form-label mb-1">Hobby <span class="text-muted" style="font-size:10px;">(select at least one Hobby) <span class="text-danger">*</span></span></label>
          <div class="hobby box checkboxes" style="padding: 8px 15px;">
            <?php
            $hobbies = ['Travelling', 'Watch Movies', 'Reading', 'Cooking', 'Photography', 'Gaming', 'Music'];
            foreach ($hobbies as $hobby) {
              $id = 'hobby' . str_replace(' ', '', $hobby);
              echo '<div class="form-check form-check-inline" style="margin-right: 12px; margin-bottom: 6px;">
                <input class="form-check-input" type="checkbox" name="hobby[]" id="' . $id . '" value="' . $hobby . '" ' . isChecked('hobby', $hobby, $old) . ' onclick="document.getElementById(\'hobbyError\').textContent=\'\';" />
                <label class="form-check-label" for="' . $id . '">' . $hobby . '</label>
              </div>';
            }
            ?>
          </div>
          <div id="hobbyError" style="color:red;font-size:13px;"></div>
          <?php echo showError('hobby', $errors); ?>
          <script>
            document.addEventListener('DOMContentLoaded', function () {
              var hobbyInputs = document.querySelectorAll('input[name="hobby[]"]');
              hobbyInputs.forEach(function (input) {
                input.onblur = function () {
                  var checked = Array.from(hobbyInputs).some(function (i) { return i.checked; });
                  document.getElementById('hobbyError').textContent = checked ? '' : 'At least one hobby is required.';
                };
              });
            });
          </script>
        </div>
      </div>
      <div class="form-row">
        <div style="width:100%;">
          <label for="address"><b>Address <span style="color:red;">*</span></b></label>
          <textarea name="address" id="address" rows="3" placeholder="Enter your address..." style="width:100%;border-radius:8px;border:1px solid #ccc;padding:10px;font-size:15px;resize:vertical;min-height:70px;background:#fafbfc;"
            oninput="this.nextElementSibling.innerHTML = this.value.trim() ? '' : 'Address is required.';"
            onblur="this.nextElementSibling.innerHTML = this.value.trim() ? '' : 'Address is required.';"
          ><?php echo $old['address'] ?? ''; ?></textarea>
          <div style="color:red;font-size:13px;"><?php echo showError('address', $errors); ?></div>
        </div>
      </div>
      <div class="form-row" style="padding:30px; margin:auto; display:flex; gap:20px; justify-content: flex-end;">
        <input type="button" value="Cancel" onclick="window.location.href='list.php'" />
        <input type="submit" id="submitBtn" name="submit" value="Add User<?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($errors)) echo ' - please fix errors'; ?>" style="font-size:14px;<?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($errors)) echo ' background:#ccc; color:#888; cursor:not-allowed;'; ?>" <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($errors)) echo 'disabled'; ?> />
      </div>
    </form>

  </div>
  <?php
  include("../components/footer.html");
  ?>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('.toggle.icon').forEach(function (toggle) {
        toggle.onclick = function () {
          const input = this.parentNode.querySelector('input[type="password"],input[type="text"]') || this.previousElementSibling;
          if (!input) return;
          input.type = input.type === "password" ? "text" : "password";
          this.classList.toggle('fa-eye');
          this.classList.toggle('fa-eye-slash');
        };
      });
    });
  </script>

</body>
</html>
