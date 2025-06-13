<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Add a new user | Admin Panel</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="shortcut icon" href="Logo.png" type="image/icon">
        
        </head>

<body>
<?php
include("../components/sidebar.html");
include("../components/navbar.html");
?>
<div class="card shadow mb-4" style="border-radius:12px;">

  <form action="insertAction.php" method="post" name="Insert" enctype="multipart/form-data">

    <div class="form-row">
      <div>
        <label for="firstname">First Name <span style="color:red;">*</span></label>
        <input type="text" id="firstname" name="first_name" placeholder="John" required />
      </div>
      <div>
        <label for="lastname">Last Name</label>
        <input type="text" id="lastname" name="last_name" placeholder="Doe" />
      </div>
      <div>
        <label for="phone_num">Phone No. <span style="color:red;">*</span></label>
        <input type="text" name="phone_num" pattern="^\d{10}$" maxlength="10" placeholder="0123456789" required />
      </div>
    </div>
    <div class="form-row">
    <div>
    <label for="email">Email <span style="color:red;">*</span></label>
<input type="email" id="email" name="email" autocomplete="off" placeholder="john@gmail.com" required />
</div>
  <div>
<label for="profile_img">Profile Image</label>
<input type="file" name="profile_img" id="profile_img" accept="image/*" />
</div>
</div>
<div class="form-row">
<div class="input-container" style="position: relative;">
  <label for="password">Password <span style="color:red;">*</span></label>
  <input class="input-field password" type="password" placeholder="Password" autocomplete="new-password" name="password" required>
  <i class="fa fa-eye toggle icon" style="position: absolute; right: 20px; top: 75%; transform: translateY(-50%); cursor: pointer;"></i>
</div>

<div class="input-container" style="position: relative;">
<label for="confirm_password">Confirm Password <span style="color:red;">*</span></label>
<input class="input-field password" type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password"  required>
  <i class="fa fa-eye toggle icon" style="position: absolute; right: 20px; top: 75%; transform: translateY(-50%); cursor: pointer;"></i>
</div>
    
    </div>

    <div class="form-row">
      <div>
      <label for="DOB">Date of Birth <span style="color:red;">*</span></label>
<input type="date" id="DOB" name="DOB" required 
       min="1924-01-01" 
       max="2005-12-31" />
      </div>
      <div>
<label for="country">Country <span style="color:red;">*</span></label>
<?php
include("../components/dropdown.html");
?>
</div>
    </div>

    
    <div class="form-row">
    <div class="box">
  <label>Gender <span style="color:red;">*</span></label>
  <div class="gender">
    <label><input type="radio" name="gender" value="male" required /> <i class="fas fa-mars"></i> Male</label>
    <label><input type="radio" name="gender" value="female" /> <i class="fas fa-venus"></i> Female</label>
    <label><input type="radio" name="gender" value="other" /> <i class="fas fa-genderless"></i> Other</label>
  </div>
</div>


  <div class="box">
    <label>Hobby <span style="font-size:10px;color:gray; font:normal;">(select atleast one Hobby)</span></label>
    <div class="hobby">
      <label><input type="checkbox" name="hobby[]" value="Travelling" /> Travelling</label>
      <label><input type="checkbox" name="hobby[]" value="Watch Movies" /> Watch Movies</label>
      <label><input type="checkbox" name="hobby[]" value="Reading" /> Reading</label>
      <label><input type="checkbox" name="hobby[]" value="Cooking" /> Cooking</label>
      <label><input type="checkbox" name="hobby[]" value="Photography" /> Photography</label>
      <label><input type="checkbox" name="hobby[]" value="Gaming" /> Gaming</label>
      <label><input type="checkbox" name="hobby[]" value="Music" /> Music</label>
    </div>
  </div>
</div>
<div class="form-row">
<div>
<label for="address">Address <span style="color:red;">*</span></label>
<textarea name="address" id="address" rows="4" placeholder="Enter your address here..." required></textarea>
</div>
<div style="padding:30px; margin:auto; display:flex; gap:20px;">
  <input type="button" value="Cancel" onclick="window.location.href='list.php'" />
  <input type="submit" name="submit" value="Add User" />
</div>
</div>


  </form>
</div>
  <?php 
            include("../components/footer.html");?>
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

</body>
</html>
