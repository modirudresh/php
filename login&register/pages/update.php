<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Update User | Admin Panel</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php
include("../components/sidebar.html");
include("../components/navbar.html");
require("../config.php");
if (!isset($_GET['id'])) {
  header("Location: index.php");
  exit();
}
$id = (int) $_GET['id'];
$result = mysqli_query($con, "SELECT * FROM user WHERE id = $id");
$user = mysqli_fetch_assoc($result);
$hobbies = explode(',', $user['hobby']);
?>
    <div class="card shadow mb-4">

<form action="updateAction.php" method="post" name="Update" enctype="multipart/form-data">
  <input type="hidden" name="id" value="<?= $user['id'] ?>">
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
    <img src="../<?= htmlspecialchars($user['image_path']) ?>" alt="Current Image" width="60" />
  <?php endif; ?>

  </div>
  <div>
   <label for="email">Email <span style="color:red;">*</span></label>
  <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required />
</div>
  </div>

<div class="form-row">

<div>
      <label for="password">Password (leave blank to keep unchanged)</label>
  <input type="password" id="password" name="password" />
  </div>
  <div>
  <label for="confirm_password">Confirm Password</label>
  <input type="password" id="confirm_password" name="confirm_password" />
  </div>
  </div>


  
  <div class="form-row">
    <div>
      <label for="DOB">Date of Birth <span style="color:red;">*</span></label>
      <input type="date" id="DOB" name="DOB" value="<?= htmlspecialchars($user['DOB']) ?>" min="1924-01-01" max="2005-12-31" required />
    </div>
    <div>
      <label for="phone_num">Phone No. <span style="color:red;">*</span></label>
      <input type="text" name="phone_num" value="<?= htmlspecialchars($user['phone_no']) ?>" pattern="^\d{10}$" maxlength="10" required />
    </div>
  </div>

  <!-- Gender -->
  <div class="form-row">
    <div class="box">
      <label>Gender <span style="color:red;">*</span></label>
      <div class="gender">
        <label><input type="radio" name="gender" value="male" <?= $user['gender'] == 'male' ? 'checked' : '' ?> /> <i class="fas fa-mars"></i> Male</label>
        <label><input type="radio" name="gender" value="female" <?= $user['gender'] == 'female' ? 'checked' : '' ?> /> <i class="fas fa-venus"></i> Female</label>
        <label><input type="radio" name="gender" value="other" <?= $user['gender'] == 'other' ? 'checked' : '' ?> /> <i class="fas fa-genderless"></i> Other</label>
      </div>
    </div>

    <div class="box">
      <label>Hobby <span style="font-size:10px;color:gray;">(select at least one)</span></label>
      <div class="hobby">
        <?php
        $allHobbies = ["Travelling", "Watch Movies", "Reading", "Cooking", "Photography", "Gaming", "Music"];
        $hobbies = array_map('trim', explode(',', $user['hobby'] ?? ''));

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
  <!-- <select name="country" id="country" required>
    <option value="" disabled>Select From Here</option>
    <option value="india" <?= $user['country'] == 'india' ? 'selected' : '' ?>>🇮🇳 India</option>
    <option value="UK" <?= $user['country'] == 'UK' ? 'selected' : '' ?>>🇬🇧 UK</option>
    <option value="russia" <?= $user['country'] == 'russia' ? 'selected' : '' ?>>🇷🇺 Russia</option>
    <option value="usa" <?= $user['country'] == 'usa' ? 'selected' : '' ?>>🇺🇸 USA</option>
  </select> -->

  <?php
include("../components/dropdown_update.php");
?>
    </div>
    </div>

  <div class="form-row" style="display: flex; justify-content: flex-end; gap: 10px;">
    <input type="button" value="Cancel" onclick="window.location.href='list.php'" />
    <input type="submit" name="submit" value="Update" />
  </div>
</form>
      </div>
<?php 
            include("../components/footer.html");?>
</body>
</html>
