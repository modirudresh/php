<?php
session_start();
$formData = $_SESSION['form_data'] ?? [];
unset($_SESSION['form_data']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add New User</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Add your CSS links here -->
</head>
<body>
  <h2>Add New User</h2>
  <form action="insertAction.php" method="post" name="Insert" enctype="multipart/form-data">
    <div class="form-row">
      <div>
        <label for="firstname">First Name <span style="color:red;">*</span></label>
        <input type="text" id="firstname" name="first_name" placeholder="Enter first name" required
          value="<?= htmlspecialchars($formData['first_name'] ?? '') ?>" />
      </div>
      <div>
        <label for="lastname">Last Name</label>
        <input type="text" id="lastname" name="last_name" placeholder="Enter last name"
          value="<?= htmlspecialchars($formData['last_name'] ?? '') ?>" />
      </div>
    </div>
    <div class="form-row">
      <div>
        <label for="email">Email <span style="color:red;">*</span></label>
        <input type="email" id="email" name="email" autocomplete="off" placeholder="Enter email address" required
          value="<?= htmlspecialchars($formData['email'] ?? '') ?>" />
      </div>
      <div>
        <label for="profile_img">Profile Image</label>
        <input type="file" name="profile_img" id="profile_img" accept="image/*" />
      </div>
    </div>
    <div class="form-row">
      <div>
        <label for="password">Password <span style="color:red;">*</span></label>
        <input type="password" id="password" name="password" autocomplete="new-password" minlength="8" placeholder="Enter password" required />
      </div>
      <div>
        <label for="confirm_password">Confirm Password <span style="color:red;">*</span></label>
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Re-enter password" required />
      </div>
    </div>
    <div class="form-row">
      <div>
        <label for="DOB">Date of Birth <span style="color:red;">*</span></label>
        <input type="date" id="DOB" name="DOB" required min="1924-01-01" max="2005-12-31"
          value="<?= htmlspecialchars($formData['DOB'] ?? '') ?>" />
      </div>
      <div>
        <label for="phone_num">Phone Number <span style="color:red;">*</span></label>
        <input type="text" id="phone_num" name="phone_num" pattern="^\d{10}$" maxlength="10" placeholder="Enter 10-digit phone number" required
          value="<?= htmlspecialchars($formData['phone_num'] ?? '') ?>" />
      </div>
    </div>
    <div class="form-row">
      <div class="box">
        <label>Gender <span style="color:red;">*</span></label>
        <div class="gender">
          <label>
            <input type="radio" name="gender" value="male" required
              <?= (isset($formData['gender']) && $formData['gender'] === 'male') ? 'checked' : '' ?> /> Male
          </label>
          <label>
            <input type="radio" name="gender" value="female"
              <?= (isset($formData['gender']) && $formData['gender'] === 'female') ? 'checked' : '' ?> /> Female
          </label>
          <label>
            <input type="radio" name="gender" value="other"
              <?= (isset($formData['gender']) && $formData['gender'] === 'other') ? 'checked' : '' ?> /> Other
          </label>
        </div>
      </div>
      <div class="box">
        <label>Hobbies<span style="color:red;">*</span> <span style="font-size:10px;color:gray; font:normal;">(Select at least one)</span></label>
        <div class="hobby">
          <?php
          $hobbies = [
            "Travelling", "Watch Movies", "Reading", "Cooking", "Photography", "Gaming", "Music"
          ];
          $selectedHobbies = $formData['hobby'] ?? [];
          foreach ($hobbies as $hobby) {
            $checked = (is_array($selectedHobbies) && in_array($hobby, $selectedHobbies)) ? 'checked' : '';
            $label = $hobby === "Watch Movies" ? "Watching Movies" : $hobby;
            echo '<label><input type="checkbox" name="hobby[]" value="' . htmlspecialchars($hobby) . '" ' . $checked . ' /> ' . htmlspecialchars($label) . '</label>';
          }
          ?>
        </div>
      </div>
    </div>
    <div class="form-row">
      <div>
        <label for="address">Address <span style="color:red;">*</span></label>
        <textarea name="address" id="address" rows="4" placeholder="Enter your complete address" required><?= htmlspecialchars($formData['address'] ?? '') ?></textarea>
      </div>
      <div>
        <label for="country">Country <span style="color:red;">*</span></label>
        <select name="country" id="country" required>
          <option value="" disabled <?= empty($formData['country']) ? 'selected' : '' ?>>Select your country</option>
          <option value="india" <?= (isset($formData['country']) && $formData['country'] === 'india') ? 'selected' : '' ?>>🇮🇳 India</option>
          <option value="UK" <?= (isset($formData['country']) && $formData['country'] === 'UK') ? 'selected' : '' ?>>🇬🇧 United Kingdom</option>
          <option value="russia" <?= (isset($formData['country']) && $formData['country'] === 'russia') ? 'selected' : '' ?>>🇷🇺 Russia</option>
          <option value="usa" <?= (isset($formData['country']) && $formData['country'] === 'usa') ? 'selected' : '' ?>>🇺🇸 United States</option>
        </select>
      </div>
    </div>
    <div class="form-row" style="display: flex; justify-content: flex-end; gap: 10px;">
      <input type="button" value="Cancel" onclick="window.location.href='index.php'" />
      <input type="submit" name="submit" value="Add User" />
    </div>
  </form>
</body>
</html>
