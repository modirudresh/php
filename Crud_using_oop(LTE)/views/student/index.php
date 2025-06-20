<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../Controllers/StudentController.php';
use Controllers\StudentController;

$controller = new StudentController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];
    $deleted = $controller->deleteStudent($deleteId);
    if ($deleted) {
        $_SESSION['success'] = "Student deleted successfully";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error'] = "Failed to delete student.";
        header("Location: index.php");
        exit();
    }
}

$students = $controller->index();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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


    <h2>Student List</h2>
    <a href="create.php" class="btn btn-primary mb-3">Add New Student</a>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Contact No</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($students)): ?>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?= htmlspecialchars($student['id'] ?? '') ?></td>
                        <td><?= htmlspecialchars($student['firstname'] ?? '') ?></td>
                        <td><?= htmlspecialchars($student['lastname'] ?? '') ?></td>
                        <td><?= htmlspecialchars($student['email'] ?? '') ?></td>
                        <td><?= htmlspecialchars($student['contactno'] ?? '') ?></td>
                        <td><?= htmlspecialchars($student['address'] ?? '') ?></td>
                        <td>
                        <a href="view.php?id=<?= $student['id'] ?>" class="btn btn-sm btn-info">View</a>
                        <a href="edit.php?id=<?= $student['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <form method="post" action="index.php" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this student?');">
                                <input type="hidden" name="delete_id" value="<?= $student['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7" class="text-center">No students found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
