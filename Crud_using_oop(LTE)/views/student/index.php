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
    } else {
        $_SESSION['error'] = "Failed to delete student.";
    }
    header("Location: index.php");
    exit();
}

$students = $controller->index();
include_once("../header.php");
include_once("../sidebar.php");
?>

<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Add New Student</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Student list</li>
            </ol>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
   
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['success']) ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" style="font-size: 24px; background-color: #28a745; color: #fff; border-radius: 4px; padding: 0 8px;">&times;</span>
                </button>
            </div>
        <?php unset($_SESSION['success']); ?>
        <?php elseif (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" style="font-size: 24px; background-color: #dc3545; color: #fff; border-radius: 4px; padding: 0 8px;">&times;</span>
                </button>
            </div>
        <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <h2 class="col-md-9 m-auto pl-4"></h2>
                    <a href="create.php" class="btn btn-primary px-4 col-md-3 m-auto">Add New Student</a>
                </div>
            </div>
            <div class="card-body">
                <table id="studentTable" class="table table-bordered table-striped table-hover">
                    <thead class="table-dark text-center">
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
                    <tbody class="text-justify">
                        <?php if (!empty($students)): ?>
                            <?php foreach ($students as $student): ?>
                                <tr>
                                    <td><?= htmlspecialchars($student['id'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($student['first_name'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($student['last_name'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($student['email'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($student['phone_no'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($student['address'] ?? '') ?></td>
                                    <td>
                                        <a href="view.php?id=<?= $student['id'] ?>" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                                        <a href="edit.php?id=<?= $student['id'] ?>" class="btn btn-sm btn-warning"><i class="fa fa-pen"></i></a>
                                        <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal<?= $student['id'] ?>">
                                            <i class="fa fa-trash"></i>
                                        </a>

                                        <div class="modal fade" id="deleteModal<?= $student['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel<?= $student['id'] ?>" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel<?= $student['id'] ?>">Confirm Delete</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true" style="font-size:28px;">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this record?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        <form method="post" action="index.php" style="display:inline;">
                                                            <input type="hidden" name="delete_id" value="<?= $student['id'] ?>">
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">No students found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
</section>

<?php include_once("../footer.php"); ?>
