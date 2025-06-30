<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Update User | Admin Panel</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// include("sidebar.html");
require("config.php");

if (!isset($con) || !($con instanceof mysqli)) {
    die("<p>Database connection not established. Please verify your configuration in <strong>config.php</strong>.</p>");
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int) $_GET['id'];

$stmt = $con->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "<p>User not found. Please ensure the user exists in the database.</p>";
    exit();
}

$hobbies = array_map('trim', explode(',', $user['hobby'] ?? ''));
?>
<form action="updateAction.php" method="post" name="Update" enctype="multipart/form-data" class="update-form">
  <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
  <input type="hidden" name="existing_image" value="<?= htmlspecialchars($user['image_path']) ?>">

  <div class="form-row">
    <div>
      <label for="firstname">First Name <span style="color:red;">*</span></label>
      <input type="text" id="firstname" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required />
    </div>
    <div>
      <label for="lastname">Last Name</label>
      <input type="text" id="lastname" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" />
    </div>
  </div>
  <div class="form-row">
    <div>
      <label for="profile_img">Profile Image</label>
      <input type="file" name="profile_img" id="profile_img" accept="image/*" />
      <?php if (!empty($user['image_path'])): ?>
        <div class="current-image">
          <span>Current Image:</span>
          <img src="<?= htmlspecialchars($user['image_path']) ?>" alt="Current Profile Image" width="60" />
        </div>
      <?php endif; ?>
    </div>
    <div>
      <label for="email">Email <span style="color:red;">*</span></label>
      <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required />
    </div>
  </div>
  <div class="form-row">
    <div>
      <label for="DOB">Date of Birth <span style="color:red;">*</span></label>
      <input type="date" id="DOB" name="DOB" value="<?= htmlspecialchars($user['DOB']) ?>" min="1924-01-01" max="2005-12-31" required />
    </div>
    <div>
      <label for="phone_num">Phone Number <span style="color:red;">*</span></label>
      <input type="text" id="phone_num" name="phone_num" value="<?= htmlspecialchars($user['phone_no']) ?>" pattern="^\d{10}$" maxlength="10" required />
    </div>
  </div>
  <div class="form-row">
    <div class="box">
      <label>Gender <span style="color:red;">*</span></label>
      <div class="gender">
        <label>
          <input type="radio" name="gender" value="male" <?= $user['gender'] == 'male' ? 'checked' : '' ?> />
          <i class="fas fa-mars"></i> Male
        </label>
        <label>
          <input type="radio" name="gender" value="female" <?= $user['gender'] == 'female' ? 'checked' : '' ?> />
          <i class="fas fa-venus"></i> Female
        </label>
        <label>
          <input type="radio" name="gender" value="other" <?= $user['gender'] == 'other' ? 'checked' : '' ?> />
          <i class="fas fa-genderless"></i> Other
        </label>
      </div>
    </div>
    <div class="box">
      <label>Hobbies <span style="font-size:10px;color:gray;">(Select at least one)</span></label>
      <div class="hobby">
        <?php
        $allHobbies = ["Travelling", "Watch Movies", "Reading", "Cooking", "Photography", "Gaming", "Music"];
        foreach ($allHobbies as $hobby) {
            $checked = in_array($hobby, $hobbies) ? 'checked' : '';
            echo "<label><input type='checkbox' name='hobby[]' value=\"$hobby\" $checked> $hobby</label> ";
        }
        ?>
      </div>
    </div>
  </div>
  <div class="form-row">
    <div>
      <label for="address">Address <span style="color:red;">*</span></label>
      <textarea name="address" id="address" rows="4" required><?= htmlspecialchars($user['address']) ?></textarea>
    </div>
    <div>
      <label for="country">Country <span style="color:red;">*</span></label>
      <select name="country" id="country" required>
        <option value="" disabled>Select Your Country</option>
        <option value="india" <?= $user['country'] == 'india' ? 'selected' : '' ?>>🇮🇳 India</option>
        <option value="UK" <?= $user['country'] == 'UK' ? 'selected' : '' ?>>🇬🇧 United Kingdom</option>
        <option value="russia" <?= $user['country'] == 'russia' ? 'selected' : '' ?>>🇷🇺 Russia</option>
        <option value="usa" <?= $user['country'] == 'usa' ? 'selected' : '' ?>>🇺🇸 United States</option>
      </select>
    </div>
  </div>
  <div class="form-row" style="display: flex; justify-content: flex-end; gap: 10px;">
    <input type="button" value="Cancel" onclick="window.location.href='index.php'" />
    <input type="submit" name="submit" value="Update" />
  </div>
</form>
</body>
</html>
