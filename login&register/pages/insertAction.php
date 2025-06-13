<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../config.php');
$message = '';
$status = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Sanitize inputs
  $firstName       = trim($_POST['first_name'] ?? '');
  $lastName        = trim($_POST['last_name'] ?? '');
  $email           = trim($_POST['email'] ?? '');
  $password        = $_POST['password'] ?? '';
  $confirmPassword = $_POST['confirm_password'] ?? '';
  $address         = trim($_POST['address'] ?? '');
  $dob             = $_POST['DOB'] ?? '';
  $phone           = trim($_POST['phone_num'] ?? '');
  $gender          = $_POST['gender'] ?? '';
  $hobbies         = $_POST['hobby'] ?? [];
  $country         = $_POST['country'] ?? '';

  // Server-side validation
  if (
    !$firstName || !$email || !$password || !$confirmPassword ||
    !$address || !$dob || !$phone || !$gender || !$country ||
    !preg_match('/^\d{10}$/', $phone) ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    $password !== $confirmPassword ||
    count($hobbies) === 0
  ) {
    $message = 'Please fill all required fields correctly.';
    $status = 'error';
  } else {
    // Check for duplicate email
    $checkStmt = $con->prepare("SELECT id FROM user WHERE email = ?");
    $checkStmt->bind_param('s', $email);
    $checkStmt->execute();
    $checkStmt->store_result();
    if ($checkStmt->num_rows > 0) {
      $message = 'Email already exists.';
      $status = 'error';
    }
    $checkStmt->close();
  }

  // If no error so far, proceed
  if ($status !== 'error') {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $imagePath = '';

    // Handle image upload if provided
    if (isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] === UPLOAD_ERR_OK) {
      $uploadDir = '../uploads/';
      $fullUploadDir = realpath(__DIR__ . '/../uploads');
      if (!$fullUploadDir) {
        mkdir(__DIR__ . '/../uploads', 0755, true);
        $fullUploadDir = realpath(__DIR__ . '/../uploads');
      }
      $fileTmp = $_FILES['profile_img']['tmp_name'];
      $fileName = basename($_FILES['profile_img']['name']);
      $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
      $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

      if (in_array($fileExt, $allowedExts)) {
        $newFileName = uniqid('img_', true) . '.' . $fileExt;
        $imagePath = $uploadDir . $newFileName;
        $absolutePath = $fullUploadDir . '/' . $newFileName;

        if (!move_uploaded_file($fileTmp, $absolutePath)) {
          $message = 'Image upload failed.';
          $status = 'error';
        }
      } else {
        $message = 'Invalid image file type. Allowed: jpg, jpeg, png, gif';
        $status = 'error';
      }
    }

    // Insert into database
    if ($status !== 'error') {
      $hobbyStr = implode(', ', $hobbies);
      $stmt = $con->prepare("
        INSERT INTO user 
        (first_name, last_name, email, password, image_path, address, DOB, phone_no, gender, hobby, country, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
      ");
      if (!$stmt) {
        $message = 'Database prepare failed: ' . $con->error;
        $status = 'error';
      } else {
        $stmt->bind_param(
          'sssssssssss',
          $firstName,
          $lastName,
          $email,
          $hashedPassword,
          $imagePath,
          $address,
          $dob,
          $phone,
          $gender,
          $hobbyStr,
          $country
        );
        if ($stmt->execute()) {
          $message = 'Data inserted successfully.';
          $status = 'success';
        } else {
          $message = 'Insert failed: ' . $stmt->error;
          $status = 'error';
        }
        $stmt->close();
      }
    }
  }
}
?>
<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php if (!empty($message)): ?>
<!-- Modal -->
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
  const modal = new bootstrap.Modal(document.getElementById('feedbackModal'));
  modal.show();

  setTimeout(() => {
  modal.hide();
  <?php if ($status === 'success'): ?>
    window.location.href = 'list.php';
  <?php else: ?>
    window.history.back();
  <?php endif; ?>
  }, 1500);
</script>
<?php endif; ?>
