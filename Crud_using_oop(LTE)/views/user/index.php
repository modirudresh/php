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
        $_SESSION['success'] = "User deleted successfully";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error'] = "Failed to delete User.";
        header("Location: index.php");
        exit();
    }
}

$students = $controller->index();
include_once("../header.php");
include_once("../sidebar.php");
?>
<div class="container-fluid">
  <div class="row mb-2">
  <div class="col-sm-6">
  <h1 class="m-0">Add New User</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">User list</li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->
</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
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

<div class="card">
    <div class="card-header">
        <div class="row">
            <h2 class="col-md-9 m-auto pl-4" ></h2>
            <a href="create.php" class="btn btn-primary px-4 col-md-3 m-auto">Add New User</a>
        </div>
    </div>
<div class="card-body">
    <table class="table table-bordred table-striped">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Image</th>
                <th>Contact No</th>
                <th>Address</th>
                <!-- <th></th> -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody class="text-justify">
            <?php if (!empty($students)): ?>
                <?php foreach ($students as $User): ?>
                    <tr>
                        <td><?= htmlspecialchars($User['id'] ?? '') ?></td>
                        <td><?= htmlspecialchars($User['firstname'] ?? '') ?></td>
                        <td><?= htmlspecialchars($User['lastname'] ?? '') ?></td>
                        <td><?= htmlspecialchars($User['email'] ?? '') ?></td>
                        <td><img src="<?= !empty($User['image_path']) ? htmlspecialchars($User['image_path']) : '../../uploads/default.png' ?>" style="width:50px; height:auto;" alt="profile"></td>
                        <td><?= htmlspecialchars($User['contactno'] ?? '') ?></td>
                        <td><?= htmlspecialchars($User['address'] ?? '') ?></td>
                        <!-- <td><a href="attendance.php?id=<?= $User['id'] ?>" class="btn btn-sm btn-success">Add attendance</a></td> -->
                        <td>
                        <a href="view.php?id=<?= $User['id'] ?>" class="btn btn-sm btn-info">View</a>
                        <a href="edit.php?id=<?= $User['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <form method="post" action="index.php" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this User?');">
                                <input type="hidden" name="delete_id" value="<?= $User['id'] ?>">
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
   </div>
   <div class="card-footer">
   </div>
</div>

     
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php
include_once("../footer.php");?>

