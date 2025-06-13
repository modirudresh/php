<?php
require_once('../config.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);

$message = '';
$status = ''; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id              = $_POST['id'] ?? null;
    $firstName       = $_POST['first_name'] ?? '';
    $lastName        = $_POST['last_name'] ?? '';
    $email           = $_POST['email'] ?? '';
    $password        = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $address         = $_POST['address'] ?? '';
    $dob             = $_POST['DOB'] ?? '';
    $phone           = $_POST['phone_num'] ?? '';
    $gender          = $_POST['gender'] ?? '';
    $hobbies         = $_POST['hobby'] ?? [];
    $country         = $_POST['country'] ?? '';
    $imagePath       = $_POST['existing_image'] ?? ''; 

    if (!empty($password) && $password !== $confirmPassword) {
        $message = 'Passwords do not match.';
        $status = 'error';
    } else {
        $hashedPassword = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : null;
        $hobbyStr = implode(', ', $hobbies);

        // Image handling
        if (isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/';
            $fileTmp = $_FILES['profile_img']['tmp_name'];
            $fileName = basename($_FILES['profile_img']['name']);
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($fileExt, $allowed)) {
                $newName = uniqid('img_', true) . '.' . $fileExt;
                $imagePath = $uploadDir . $newName;
                move_uploaded_file($fileTmp, __DIR__ . '/' . $imagePath);
            } else {
                $message = 'Invalid image type.';
                $status = 'error';
            }
        }

        if ($status !== 'error') {
            if ($hashedPassword !== null) {
                $stmt = $con->prepare("UPDATE user SET first_name=?, last_name=?, email=?, password=?, image_path=?, address=?, DOB=?, phone_no=?, gender=?, hobby=?, country=?, updated_at=NOW() WHERE id=?");
                $stmt->bind_param('sssssssssssi', $firstName, $lastName, $email, $hashedPassword, $imagePath, $address, $dob, $phone, $gender, $hobbyStr, $country, $id);
            } else {
                $stmt = $con->prepare("UPDATE user SET first_name=?, last_name=?, email=?, image_path=?, address=?, DOB=?, phone_no=?, gender=?, hobby=?, country=?, updated_at=NOW() WHERE id=?");
                $stmt->bind_param('ssssssssssi', $firstName, $lastName, $email, $imagePath, $address, $dob, $phone, $gender, $hobbyStr, $country, $id);
            }

            if ($stmt->execute()) {
                $message = 'User updated successfully.';
                $status = 'success';
            } else {
                $message = 'Update failed: ' . $stmt->error;
                $status = 'error';
            }

            $stmt->close();
        }
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header <?= ($status === 'success') ? 'bg-success text-white' : 'bg-danger text-white' ?>">
        <h5 class="modal-title" id="feedbackModalLabel"><?= ucfirst($status) ?></h5>
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

    // Auto-close after 4 seconds
    setTimeout(() => {
      modal.hide();
      <?php if ($status === 'success'): ?>
        window.location.href = 'list.php';
      <?php endif; ?>
    }, 1500);
  <?php endif; ?>
</script>
