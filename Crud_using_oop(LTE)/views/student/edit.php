<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../Controllers/StudentController.php';
use Controllers\StudentController;

$controller = new StudentController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $firstname = $_POST['firstname'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $email = $_POST['email'] ?? '';
    $contactno = $_POST['contactno'] ?? '';
    $address = $_POST['address'] ?? '';

    if (!empty($id)) {
        $result = $controller->editStudent($id, $firstname, $lastname, $email, $contactno, $address);
        if ($result) {
            echo json_encode(['success'=> true]);
            $_SESSION['success'] = "Student Updated successfully";
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['error'] = "Failed to update student.";
            header("Location: edit.php");
        }
    } else {
        $error = "Invalid student ID.";
    }
} else {
    $id = $_GET['id'] ?? null;
    if (!$id) {
        $_SESSION['error'] = "Invalid ID";
        header("Location: index.php");
        exit();
    }

    $student = $controller->getStudent($id);
    if (!$student) {
        $_SESSION['error'] = "Student Not Found";
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Update Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="container mt-4">

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
    <h2>Update Student</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="edit.php" method="post">
        <input type="hidden" name="id" value="<?= htmlspecialchars($student['id'] ?? '') ?>" />

        <div class="mb-3">
            <label>First Name</label>
            <input type="text" name="firstname" class="form-control"
                   value="<?= htmlspecialchars($_POST['firstname'] ?? $student['firstname'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label>Last Name</label>
            <input type="text" name="lastname" class="form-control"
                   value="<?= htmlspecialchars($_POST['lastname'] ?? $student['lastname'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control"
                   value="<?= htmlspecialchars($_POST['email'] ?? $student['email'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label>Contact No</label>
            <input type="text" name="contactno" class="form-control"
                   value="<?= htmlspecialchars($_POST['contactno'] ?? $student['contactno'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control" required><?= htmlspecialchars($_POST['address'] ?? $student['address'] ?? '') ?></textarea>
        </div>

        <button type="submit" class="btn btn-warning">Update</button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
