<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../Controllers/UserController.php';
use Controllers\UserController;

$controller = new UserController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {

    header('Content-Type: application/json');

    $id = $_POST['id'] ?? '';
    if (empty($id) || !is_numeric($id)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid user ID.']);
        exit;
    }

    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone_no = substr(trim($_POST['phone_no'] ?? ''), 0, 15);
    $password = $_POST['password'] ?? '';
    $DOB = $_POST['DOB'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $hobby = isset($_POST['hobby']) ? implode(',', $_POST['hobby']) : '';
    $address = $_POST['address'] ?? '';
    $country = $_POST['country'] ?? '';
    $existing_image = $_POST['existing_image'] ?? '';
    $image_path = $existing_image;

    if (isset($_FILES['image_path']) && $_FILES['image_path']['error'] === 0) {
        $uploadDir = __DIR__ . '/../../uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $ext = strtolower(pathinfo($_FILES['image_path']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($ext, $allowed)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid image type.']);
            exit;
        }

        if ($_FILES['image_path']['size'] > 2 * 1024 * 1024) {
            echo json_encode(['status' => 'error', 'message' => 'Image exceeds 2MB limit.']);
            exit;
        }

        $fileName = uniqid('usr_') . '.' . $ext;
        $uploadPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['image_path']['tmp_name'], $uploadPath)) {
            $image_path = 'uploads/' . $fileName;
            if ($existing_image && file_exists(__DIR__ . '/../../' . $existing_image) && strpos($existing_image, 'default.png') === false) {
                unlink(__DIR__ . '/../../' . $existing_image);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Image upload failed.']);
            exit;
        }
    }

    $result = $controller->edituser($id, $first_name, $last_name, $email, $phone_no, $address, $DOB, $gender, $hobby, $country, $image_path, $password);

    if (is_array($result) && !$result['success']) {
        echo json_encode(['status' => 'error', 'message' => $result['message']]);
    } else {
        echo json_encode(['status' => 'success', 'message' => 'User updated successfully.']);
    }
    exit;
}

$id = $_GET['id'] ?? '';
if (!$id || !is_numeric($id)) {
    header('Location: index.php');
    exit;
}

$user = $controller->getuser($id);
if (!$user) {
    header('Location: index.php');
    exit;
}

include_once("../header.php");
include_once("../sidebar.php");

$allHobbies = ["Reading","Singing","Yoga","Dancing","Swimming","Writing","Drawing","Painting","Blogging","Traveling","Cricket","Photography","Cooking","Coding","Gaming","Cycling","Skiing"]; 
$selectedHobbies = explode(',', $user['hobby']);
?>



<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6"><h1 class="m-0">Edit User</h1></div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Edit User</li>
            </ol>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-warning">
            <div class="card-header"><h3 class="card-title">Edit User</h3></div>
            <form id="userForm" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                <input type="hidden" name="existing_image" value="<?= $user['image_path'] ?>">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($user['email']) ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Phone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="phone_no" value="<?= htmlspecialchars($user['phone_no']) ?>" maxlength="10">
                        </div>
                    </div>
                    <div class="row">
                    <div class="form-group col-md-2">
              <small class="form-text text-muted"><b>Current Image:</b></small>
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
                            <label>Profile Image <span class="text-danger">*</span></label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="image_path" accept="image/*">
                                <label class="custom-file-label">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group col-md-5">
                            <label>Date of Birth <span class="text-danger">*</span></label>
                            <input type="text" class="form-control datetimepicker-input" name="DOB" value="<?= $user['DOB'] ?>" autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Gender <span class="text-danger">*</span></label>
                            <div class="form-control bg-light" style="height:max-content;">
                                <?php foreach (['Male', 'Female', 'Other'] as $g): ?>
                                    <div class="form-check form-check-inline">
                                        <input class="form-control" type="radio" name="gender" value="<?= $g ?>" <?= $user['gender'] === $g ? 'checked' : '' ?>>
                                        <label class="form-check-label">&nbsp;<?= ucfirst($g) ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Hobbies <span class="text-danger">*</span></label>
                            <div class="form-control bg-light" style="height:max-content;">
                                <?php foreach ($allHobbies as $h): ?>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" name="hobby[]" value="<?= $h ?>" <?= in_array($h, $selectedHobbies) ? 'checked' : '' ?>>
                                        <label class="form-check-label">&nbsp; <?= $h ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Address <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="address"><?= htmlspecialchars($user['address']) ?></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Country <span class="text-danger">*</span></label>
                            <select class="form-control" name="country">
                                <option value="">Select</option>
                                <option value="india" <?= $user['country'] === 'india' ? 'selected' : '' ?>>India</option>
                                <option value="UK" <?= $user['country'] === 'UK' ? 'selected' : '' ?>>UK</option>
                                <option value="usa" <?= $user['country'] === 'usa' ? 'selected' : '' ?>>USA</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-warning float-right">Update User</button>
                </div>
            </form>
        </div>
    </div>
</section>
</div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
$(document).ready(function () {
  $('#userForm').submit(function (e) {
      e.preventDefault();

      var form = this;

      if (!$(form).valid()) return;

      var formData = new FormData(form);
      var submitBtn = $(form).find('button[type="submit"]');

      submitBtn.prop('disabled', true).text('Updating...');

      $.ajax({
        url: 'edit.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        success: function (res) {
          if (res.status === 'success') {
            toastr.success(res.message);
            setTimeout(function () {
              window.location.href = 'index.php';
            }, 1500);
          } else {
            toastr.error(res.message);
          }
        },
        error: function () {
          toastr.error('Something went wrong.');
        },
        complete: function () {
          submitBtn.prop('disabled', false).text('Update User');
        }
      });
    });
  });
</script>


<?php include_once("../footer.php"); ?>
