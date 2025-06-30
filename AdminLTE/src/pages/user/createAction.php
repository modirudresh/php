<?php
if (!empty($message)) {
    $_SESSION['message'] = $message;
    $_SESSION['status'] = $status;
    $_SESSION['errors'] = $errors;
    $_SESSION['formData'] = $formData;

    if ($status === 'success') {
        header("Location: index.php");
    } else {
        header("Location: create.php"); 
    }
    exit;
}
?>

<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../../../config/config.php');

$message = '';
$status = '';
$formData = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $address = trim($_POST['address'] ?? '');
    $dob = $_POST['DOB'] ?? '';
    $phone = trim($_POST['phone_no'] ?? '');
    $gender = $_POST['gender'] ?? '';
    $hobbies = $_POST['hobby'] ?? [];
    $country = $_POST['country'] ?? '';

    $formData = compact('firstName', 'lastName', 'email', 'address', 'dob', 'phone', 'gender', 'hobbies', 'country');

    if (empty($errors)) {
        $checkStmt = $con->prepare("SELECT id FROM User_data WHERE email = ?");
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkStmt->store_result();
        if ($checkStmt->num_rows > 0) {
            $errors['email'] = 'Email already exists.';
        }
        $checkStmt->close();
    }

    $imagePath = '';
    if (empty($errors) && isset($_FILES['image_path']) && $_FILES['image_path']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/uploads/';
        $uploadDirRelative = 'uploads/';  

        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                $errors['image_path'] = 'Failed to create upload directory.';
            }
        }

        if (!isset($errors['image_path']) && !is_writable($uploadDir)) {
            $errors['image_path'] = 'Upload directory is not writable.';
        }

        if (empty($errors)) {
            $tmpName = $_FILES['image_path']['tmp_name'];
            $originalName = basename($_FILES['image_path']['name']);
            $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($ext, $allowed)) {
                $errors['image_path'] = 'Allowed image types: jpg, jpeg, png, gif.';
            } elseif ($_FILES['image_path']['size'] > 2 * 1024 * 1024) {
                $errors['image_path'] = 'Max file size is 2MB.';
            } else {
                $newFileName = uniqid('img_', true) . '.' . $ext;
                $absolutePath = $uploadDir . $newFileName;
                $imagePath = $uploadDirRelative . $newFileName;

                if (!move_uploaded_file($tmpName, $absolutePath)) {
                    $errors['image_path'] = 'Failed to move uploaded file.';
                }
            }
        }
    }
   if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $hobbyStr = implode(', ', $hobbies);

        $stmt = $con->prepare("
            INSERT INTO User_data 
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
                header("Location: index.php");
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
<?php if (!empty($message)) : ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-- jQuery + Toastr JS -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(function () {
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "timeOut": "3000",
            "positionClass": "toast-top-right"
        };

        <?php if ($status === 'success') : ?>
            toastr.success("<?= addslashes($message) ?>");
            setTimeout(() => {
                window.location.href = 'User_index.php';
            }, 3000);
        <?php else : ?>
            toastr.error("<?= addslashes($message) ?>");

            <?php if (!empty($errors)) : ?>
                <?php foreach ($errors as $err) : ?>
                    toastr.error("<?= addslashes($err) ?>");
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endif; ?>
    });
</script>
<?php endif; ?>

