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
include_once("../header.php");
include_once("../sidebar.php");
?>
<div class="container-fluid">
  <div class="row mb-2">
  <div class="col-sm-6">
  <h1 class="m-0">Add New Student</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Add Student</li>
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
<div class="card card-primary">
          <div class="card-header"><h3 class="card-title">Add User</h3></div>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <form action="create.php" method="post">
    <div class="card-body">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label>First Name</label>
            <input type="text" name="firstname" class="form-control" 
                value="<?= htmlspecialchars($_POST['firstname'] ?? '') ?>" required>
        </div>

        <div class="col-md-6 mb-3">
            <label>Last Name</label>
            <input type="text" name="lastname" class="form-control"
                value="<?= htmlspecialchars($_POST['lastname'] ?? '') ?>" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control"
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
        </div>

        <div class="col-md-6 mb-3">
            <label>Contact No</label>
            <input type="text" name="contactno" class="form-control"
                value="<?= htmlspecialchars($_POST['contactno'] ?? '') ?>" required>
        </div>
    </div>
        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control" required><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
        </div>
    </div>

<div class="card-footer">
    <div class="float-end">
        <a href="index.php" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Create</button>
    </div>
    </div>
    </form>
    </div>
    
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php
include_once("../footer.php");?>
