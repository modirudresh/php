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
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone_no = $_POST['phone_no'] ?? '';
    $address = $_POST['address'] ?? '';

    
    $result = $controller->addStudent($first_name, $last_name, $email, $phone_no, $address);

    
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
    
    <form id="userForm" action="create.php" method="post">
    <div class="card-body">
    <div class="row">
        <div class="form-group col-md-6">
            <label for="first_name">First Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="first_name" name="first_name"
                value="<?= htmlspecialchars($_SESSION['formData']['first_name'] ?? '') ?>" placeholder="Enter first name">
        </div>
        <div class="form-group col-md-6">
            <label for="last_name">Last Name <small class="text-muted">(optional)</small></label>
            <input type="text" class="form-control" id="last_name" name="last_name"
                value="<?= htmlspecialchars($_SESSION['formData']['last_name'] ?? '') ?>" placeholder="Enter last name">
        </div>
        </div>
        <div class="row">
        <div class="form-group col-md-6">
            <label for="email">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="email" name="email"
                value="<?= htmlspecialchars($_SESSION['formData']['email'] ?? '') ?>" placeholder="Enter email" autocomplete="off">
        </div>
        <div class="form-group col-md-6">
            <label for="phone_no">Phone Number <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="phone_no" name="phone_no"
                value="<?= htmlspecialchars($_SESSION['formData']['phone_no'] ?? '') ?>"
                placeholder="Enter 10-digit number" autocomplete="off" maxlength="10">
        </div>
        </div>
        <div class="form-group">
            <label for="address">Address <span class="text-danger">*</span></label>
            <textarea class="form-control" id="address" name="address" rows="4"
                    placeholder="Enter your address"><?= htmlspecialchars($_SESSION['formData']['address'] ?? '') ?></textarea>
        </div>
    </div>

<div class="card-footer">
    <div class="float-end">
        <a href="index.php" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary float-right">Create</button>
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
