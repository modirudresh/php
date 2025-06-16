<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('./config/config.php');

$message = '';
$status = '';
$formData = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $address = trim($_POST['address'] ?? '');
    $dob = $_POST['DOB'] ?? '';
    $phone = trim($_POST['phone_num'] ?? '');
    $gender = $_POST['gender'] ?? '';
    $hobbies = $_POST['hobby'] ?? [];
    $country = $_POST['country'] ?? '';

    $formData = compact('firstName', 'lastName', 'email', 'address', 'dob', 'phone', 'gender', 'hobbies', 'country');

    // Validation
    if (!$firstName) $errors['first_name'] = 'First name is required.';
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Valid email is required.';
    if (!$password) $errors['password'] = 'Password is required.';
    if ($password !== $confirmPassword) $errors['confirm_password'] = 'Passwords do not match.';
    if (!$address) $errors['address'] = 'Address is required.';
    if (!$dob) $errors['DOB'] = 'Date of birth is required.';
    if (!$phone || !preg_match('/^\d{10}$/', $phone)) $errors['phone_num'] = 'Phone number must be 10 digits.';
    if (!$gender) $errors['gender'] = 'Gender is required.';
    if (!$country) $errors['country'] = 'Country is required.';
    if (empty($hobbies)) $errors['hobby'] = 'Select at least one hobby.';
    if (!isset($_FILES['profile_img']) || $_FILES['profile_img']['error'] === UPLOAD_ERR_NO_FILE) {
        $errors['profile_img'] = 'Profile image is required.';
    }

    // Check if errors exist
    if (empty($errors)) {
        // Check for duplicate email
        $checkStmt = $con->prepare("SELECT id FROM user WHERE email = ?");
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkStmt->store_result();
        if ($checkStmt->num_rows > 0) {
            $errors['email'] = 'Email already exists.';
        }
        $checkStmt->close();
    }

    $imagePath = '';
    if (empty($errors) && isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $tmpName = $_FILES['profile_img']['tmp_name'];
        $originalName = basename($_FILES['profile_img']['name']);
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($ext, $allowed)) {
            $errors['profile_img'] = 'Allowed types: jpg, jpeg, png, gif.';
        } elseif ($_FILES['profile_img']['size'] > 2 * 1024 * 1024) {
            $errors['profile_img'] = 'Max file size is 2MB.';
        } else {
            $newFileName = uniqid('img_', true) . '.' . $ext;
            $imagePath = 'uploads/' . $newFileName;
            $fullPath = $uploadDir . $newFileName;

            if (!move_uploaded_file($tmpName, $fullPath)) {
                $errors['profile_img'] = 'Image upload failed.';
            }
        }
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $hobbyStr = implode(', ', $hobbies);

        $stmt = $con->prepare("
            INSERT INTO user 
            (first_name, last_name, email, password, image_path, address, DOB, phone_no, gender, hobby, country, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");

        if (!$stmt) {
            $message = 'DB error: ' . $con->error;
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
                $formData = [];
            } else {
                $message = 'Insert failed: ' . $stmt->error;
                $status = 'error';
            }
            $stmt->close();
        }
    } else {
        $message = 'Please correct the errors below.';
        $status = 'error';
    }
}
?>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php if (!empty($message)) : ?>
<!-- Modal -->
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header <?= ($status === 'success') ? 'bg-success text-white' : 'bg-danger text-white' ?>">
                <h5 class="modal-title" id="feedbackModalLabel"><?= ucfirst(htmlspecialchars($status)) ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <?= htmlspecialchars($message) ?>
                <?php if (!empty($errors)) : ?>
                    <ul class="mt-2">
                        <?php foreach ($errors as $err) : ?>
                            <li><?= htmlspecialchars($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    const modal = new bootstrap.Modal(document.getElementById('feedbackModal'));
    modal.show();

    setTimeout(() => {
        modal.hide();
        <?php if ($status === 'success') : ?>
            window.location.href = 'index.php';
        <?php else : ?>
            window.history.back();
        <?php endif; ?>
    }, 2000);
</script>
<?php endif; ?>
