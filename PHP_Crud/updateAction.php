<?php
require_once('config.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);

$message = '';
$status = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id         = $_POST['id'] ?? null;
  $firstName  = trim($_POST['first_name'] ?? '');
  $lastName   = trim($_POST['last_name'] ?? '');
  $email      = trim($_POST['email'] ?? '');
  $address    = trim($_POST['address'] ?? '');
  $dob        = trim($_POST['DOB'] ?? '');
  $phone      = trim($_POST['phone_num'] ?? '');
  $gender     = $_POST['gender'] ?? '';
  $hobbies    = $_POST['hobby'] ?? [];
  $country    = $_POST['country'] ?? '';
  $imagePath  = $_POST['existing_image'] ?? '';

  $hobbyStr = implode(', ', $hobbies);

  // Handle image upload if a new file is provided
  if (isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = './uploads/';
    $fullUploadDir = __DIR__ . '/' . $uploadDir;

    if (!is_dir($fullUploadDir)) {
      mkdir($fullUploadDir, 0755, true);
    }

    $fileTmp = $_FILES['profile_img']['tmp_name'];
    $fileName = basename($_FILES['profile_img']['name']);
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($fileExt, $allowedExts)) {
      $newFileName = uniqid('img_', true) . '.' . $fileExt;
      $imagePath = $uploadDir . $newFileName;
      $absolutePath = $fullUploadDir . $newFileName;

      if (!move_uploaded_file($fileTmp, $absolutePath)) {
        $message = 'Image upload failed. Please try again or contact support.';
        $status = 'error';
      }
    } else {
      $message = 'Invalid image file type. Allowed formats: jpg, jpeg, png, gif.';
      $status = 'error';
    }
  }

  if ($status !== 'error') {
    $stmt = $con->prepare(
      "UPDATE users SET first_name=?, last_name=?, email=?, image_path=?, address=?, DOB=?, phone_no=?, gender=?, hobby=?, country=?, updated_at=NOW() WHERE id=?"
    );
    $stmt->bind_param(
      'ssssssssssi',
      $firstName,
      $lastName,
      $email,
      $imagePath,
      $address,
      $dob,
      $phone,
      $gender,
      $hobbyStr,
      $country,
      $id
    );

    if ($stmt->execute()) {
      $message = 'User information has been updated successfully. Thank you for keeping your profile up to date.';
      $status = 'success';
    } else {
      $message = 'Update failed due to a system error: ' . $stmt->error . '. Please try again later.';
      $status = 'error';
    }

    $stmt->close();
  }
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header <?= ($status === 'success') ? 'bg-success text-white' : 'bg-danger text-white' ?>">
        <h5 class="modal-title" id="feedbackModalLabel">
          <?= ($status === 'success') ? 'Update Successful' : 'Update Failed' ?>
        </h5>
      </div>
      <div class="modal-body">
        <?= htmlspecialchars($message) ?>
      </div>
    </div>
  </div>
</div>

<script>
<?php if (!empty($message)): ?>
  const modal = new bootstrap.Modal(document.getElementById('feedbackModal'));
  modal.show();

  // Automatically close the modal after 1.5 seconds and redirect if successful
  setTimeout(() => {
    modal.hide();
    <?php if ($status === 'success'): ?>
    window.location.href = 'index.php';
    <?php endif; ?>
  }, 1500);
<?php endif; ?>
</script>
