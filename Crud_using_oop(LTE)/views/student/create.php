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

    $_SESSION['formData'] = compact('first_name', 'last_name', 'email', 'phone_no', 'address');

    if ($controller->emailExists($email)) {
        $_SESSION['error'] = "Email already exists.";
        header("Location: create.php");
        exit();
    }

    $result = $controller->addStudent($first_name, $last_name, $email, $phone_no, $address);

    if ($result) {
        $_SESSION['success'] = "Student added successfully";
        unset($_SESSION['formData']);
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error'] = "Failed to add student.";
        header("Location: create.php");
        exit();
    }
}


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
                        <li class="breadcrumb-item active">Add Student</li>
                    </ol>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">

                    <?php if ($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($error) ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true" style="font-size: 24px; background-color: #ff4d4d; color: #fff; border-radius: 4px; padding: 0 8px;">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

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

                <div class="card card-primary">
                    <div class="card-header"><h3 class="card-title">Add Student</h3></div>

                    <form id="userForm" action="create.php" method="post">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="first_name">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        value="<?= htmlspecialchars($_SESSION['formData']['first_name'] ?? '') ?>" placeholder="Enter first name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="last_name">Last Name <span class="text-danger">*</span></label>
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

            </div>
        </section>
    </div>
</div>

<?php include_once("../footer.php"); ?>
