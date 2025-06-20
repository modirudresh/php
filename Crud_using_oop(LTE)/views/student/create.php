<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../Controllers/StudentController.php';
use Controllers\StudentController;

$controller = new StudentController();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $email = $_POST['email'] ?? '';
    $contactno = $_POST['contactno'] ?? '';
    $address = $_POST['address'] ?? '';

    
    $result = $controller->addStudent($firstname, $lastname, $email, $contactno, $address);

    if ($result) {
        $_SESSION['success'] = "Student Added successfully";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error'] = "Failed to ADD student.";
        header("Location: create.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Add Student</title>
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
    
<h2>Add Student</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="create.php" method="post">

        <div class="mb-3">
            <label>First Name</label>
            <input type="text" name="firstname" class="form-control" 
                value="<?= htmlspecialchars($_POST['firstname'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label>Last Name</label>
            <input type="text" name="lastname" class="form-control"
                value="<?= htmlspecialchars($_POST['lastname'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control"
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label>Contact No</label>
            <input type="text" name="contactno" class="form-control"
                value="<?= htmlspecialchars($_POST['contactno'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control" required><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Create</button>

    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
