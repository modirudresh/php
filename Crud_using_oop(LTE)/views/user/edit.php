<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../Controllers/UserController.php';
use Controllers\UserController;

$controller = new UserController();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "Invalid user ID.";
    header("Location: index.php");
    exit;
}

$id = (int)($_GET['id'] ?? 0);
$user = $controller->getuser($id);

if (!$user) {
    $_SESSION['error'] = "User not found.";
    header("Location: index.php");
    exit;
}

$selectedHobbies = array_map('trim', explode(',', $user['hobby'] ?? ''));
$allHobbies = ['Reading', 'Traveling', 'Sports', 'Music', 'Gaming', 'Watching Movies', 'Cooking', 'Photography'];

$formData = [
    'first_name' => $user['first_name'],
    'last_name'  => $user['last_name'],
    'email'      => $user['email'],
    'phone_no'   => $user['phone_no'],
    'address'    => $user['address'],
    'DOB'        => $user['DOB'],
    'gender'     => strtolower($user['gender']),
    'country'    => $user['country'],
    'image_path' => $user['image_path'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id          = (int)($_POST['id'] ?? 0);
    $first_name  = trim($_POST['first_name'] ?? '');
    $last_name   = trim($_POST['last_name'] ?? '');
    $email       = trim($_POST['email'] ?? '');
    $phone_no    = substr(trim($_POST['phone_no'] ?? ''), 0, 15);
    $address     = trim($_POST['address'] ?? '');
    $DOB         = trim($_POST['DOB'] ?? '');
    $gender      = $_POST['gender'] ?? '';
    $hobby       = $_POST['hobby'] ?? [];
    $country     = $_POST['country'] ?? '';
    $existing_image = $_POST['existing_image'] ?? null;

    $image_path = $existing_image;

    // Handle image upload
    if (isset($_FILES['image_path']) && $_FILES['image_path']['error'] === 0) {
        $uploadDir = __DIR__ . '/../../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $ext = strtolower(pathinfo($_FILES['image_path']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($ext, $allowed)) {
            if ($_FILES['image_path']['size'] <= 2 * 1024 * 1024) {
                $newFileName = uniqid('usr_') . '.' . $ext;
                $uploadPath = $uploadDir . $newFileName;

                if (move_uploaded_file($_FILES['image_path']['tmp_name'], $uploadPath)) {
                    $image_path = 'uploads/' . $newFileName;

                    // Delete old image if exists and not default
                    if ($existing_image && file_exists(__DIR__ . '/../../' . $existing_image) && strpos($existing_image, 'profile.png') === false) {
                        unlink(__DIR__ . '/../../' . $existing_image);
                    }
                } else {
                    $_SESSION['error'] = "Failed to upload the image.";
                    header("Location: edit.php?id=" . $id);
                    exit;
                }
            } else {
                $_SESSION['error'] = "Image exceeds 2MB limit.";
                header("Location: edit.php?id=" . $id);
                exit;
            }
        } else {
            $_SESSION['error'] = "Invalid image type. Allowed: JPG, JPEG, PNG, GIF.";
            header("Location: edit.php?id=" . $id);
            exit;
        }
    }

    // Update user
    $result = $controller->edituser($id, $first_name, $last_name, $email, $phone_no, $address, $DOB, $gender, $hobby, $country, $image_path);

    if (is_array($result) && !$result['success']) {
        $_SESSION['error'] = $result['message'];

        // Re-populate form data on error
        $formData = [
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'email'      => $email,
            'phone_no'   => $phone_no,
            'address'    => $address,
            'DOB'        => $DOB,
            'gender'     => $gender,
            'country'    => $country,
            'image_path' => $image_path,
        ];
        $selectedHobbies = $hobby;  
    } else {
        $_SESSION['success'] = "User updated successfully!";
        header("Location: index.php");
        exit;
    }
}

include_once("../header.php");
include_once("../sidebar.php");
?>

<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">Edit User</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Edit User</li>
      </ol>
    </div>
  </div>
</div>
</div>

<section class="content">
  <div class="container-fluid">

    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?= htmlspecialchars($_SESSION['success']) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['success']); ?>
    <?php elseif (isset($_SESSION['error'])): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?= htmlspecialchars($_SESSION['error']) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="card card-primary">
      <div class="card-header"><h3 class="card-title">Edit User</h3></div>

      <form id="userForm" action="edit.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">
        <div class="card-body">
          <input type="hidden" name="id" value="<?= $user['id'] ?>">

          <div class="row">
            <div class="form-group col-md-6">
              <label for="firstname">First Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="firstname" name="first_name"
                     value="<?= htmlspecialchars($formData['first_name']) ?>" placeholder="Enter first name">
            </div>
            <div class="form-group col-md-6">
              <label for="lastname">Last Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="lastname" name="last_name"
                     value="<?= htmlspecialchars($formData['last_name'] ?? '') ?>" placeholder="Enter last name">
            </div>
          </div>

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

          <div class="row">
            <div class="form-group col-md-2">
              <small class="form-text text-muted">Current Image:</small>
              <img 
                src="<?= !empty($user['image_path']) && file_exists(__DIR__ . '/../../' . $user['image_path']) 
                      ? '../../' . htmlspecialchars($user['image_path']) 
                      : '../../uploads/default.png' ?>" 
                alt="Profile" 
                class="img-thumbnail mt-1 shadow-lg" 
                style="height: 80px; width: auto;"
              >
            </div>

            <div class="form-group col-md-5">
              <label for="image_path">Profile Image <small class="text-danger">*</small></label>
              <input type="hidden" name="existing_image" value="<?= htmlspecialchars($user['image_path'] ?? '') ?>">
              <div class="custom-file">
                <input type="file" 
                       class="custom-file-input" 
                       id="image_path" 
                       name="image_path" 
                       accept="image/*">
                <label class="custom-file-label" for="image_path">Choose file</label>
              </div>
              <small class="form-text text-muted">Allowed: JPG, JPEG, PNG, GIF. Max size: 2MB.</small>
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
                       placeholder="Select date of birth" autocomplete="off" />
                <div class="input-group-append" data-target="#dobPicker" data-toggle="datetimepicker">
                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="form-group col-md-6">
              <label class="d-block">Gender <span class="text-danger">*</span></label>
              <div class="bg-light p-3 rounded shadow-sm">
                <?php
                $genders = ['male' => 'Male', 'female' => 'Female', 'other' => 'Other'];
                foreach ($genders as $key => $label) {
                    $checked = ($formData['gender'] === $key) ? 'checked' : '';
                    echo "<div class='form-check form-check-inline mr-3'>
                            <input class='form-check-input' type='radio' name='gender' id='gender_$key' value='$key' $checked>
                            <label class='form-check-label' for='gender_$key'>$label</label>
                          </div>";
                }
                ?>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label>Hobbies <small class="text-muted">(Select at least one)</small></label><br>
              <div class="bg-light p-3 rounded shadow-sm">
                <?php
                foreach ($allHobbies as $hobby) {
                    $checked = in_array($hobby, $selectedHobbies) ? 'checked' : '';
                    echo "<div class='form-check form-check-inline'>
                            <input class='form-check-input' type='checkbox' name='hobby[]' value='" . htmlspecialchars($hobby) . "' $checked>
                            <label class='form-check-label'>" . htmlspecialchars($hobby) . "</label>
                          </div>";
                }
                ?>
              </div>
            </div>
          </div>

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
    </div>
  </div>
</section>
</div>

<?php
include_once("../footer.php");
?>
