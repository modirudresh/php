<?php
require_once 'config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$_SESSION['form_data'] = $_POST;

$status  = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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
    $imagePath       = '';

    if ($password !== $confirmPassword) {
        $status = 'error';
        $message = 'Passwords do not match. Please try again.';
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if (isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            $fullUploadDir = __DIR__ . '/' . $uploadDir;

            if (!is_dir($fullUploadDir)) {
                mkdir($fullUploadDir, 0755, true);
            }

            $fileTmp  = $_FILES['profile_img']['tmp_name'];
            $fileName = basename($_FILES['profile_img']['name']);
            $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($fileExt, $allowedExts)) {
                $newFileName = uniqid('img_', true) . '.' . $fileExt;
                $imagePath   = $uploadDir . $newFileName;
                $absolutePath = $fullUploadDir . $newFileName;

                if (!move_uploaded_file($fileTmp, $absolutePath)) {
                    $status = 'error';
                    $message = 'Failed to upload profile image.';
                }
            } else {
                $status = 'error';
                $message = 'Invalid image type. Only jpg, jpeg, png, gif are allowed.';
            }
        }

        if (empty($message)) {
            $hobbyStr = implode(', ', $hobbies);

            $stmt = $con->prepare("
                INSERT INTO users 
                (first_name, last_name, email, password, image_path, address, DOB, phone_no, gender, hobby, country, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
            ");

            if ($stmt) {
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
                    $status = 'success';
                    $message = 'Registration successful. Thank you!';
                    unset($_SESSION['form_data']);
                } else {
                    $status = 'error';
                    $message = 'Database insertion failed: ' . $stmt->error;
                }

                $stmt->close();
            } else {
                $status = 'error';
                $message = 'Database preparation error: ' . $con->error;
            }
        }
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php if (!empty($message)): ?>
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header <?= $status === 'success' ? 'bg-success' : 'bg-danger' ?> text-white">
        <h5 class="modal-title" id="feedbackModalLabel">
          <?= $status === 'success' ? 'Success' : 'Error' ?>
        </h5>
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
    window.location.href = '<?= $status === "success" ? "index.php" : "insert.php" ?>';
  }, 2000);
</script>
<?php endif; ?>
