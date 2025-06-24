<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../Controllers/UserController.php';
use Controllers\UserController;

$controller = new UserController();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone_no = trim($_POST['phone_no'] ?? '');
    $password = $_POST['password'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $DOB = $_POST['DOB'] ?? '';
    $hobby = $_POST['hobby'] ?? [];
    $address = $_POST['address'] ?? '';
    $country = $_POST['country'] ?? '';
    $image_path = '';

    $_SESSION['formData'] = $_POST;

    if ($controller->checkEmailExists($email)) {
        $_SESSION['error'] = "Email already exists.";
        header("Location: create.php");
        exit;
    }

    $phone_no = substr($phone_no, 0, 15);

    if (isset($_FILES['image_path']) && $_FILES['image_path']['error'] === 0) {
        $uploadDir = __DIR__ . '/../../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $ext = pathinfo($_FILES['image_path']['name'], PATHINFO_EXTENSION);
        $newFileName = uniqid('usr_') . '.' . $ext;
        $uploadPath = $uploadDir . $newFileName;

        if (move_uploaded_file($_FILES['image_path']['tmp_name'], $uploadPath)) {
            $image_path = 'uploads/' . $newFileName;
        } else {
            $_SESSION['error'] = "Failed to upload image.";
            header("Location: create.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "Image is required.";
        header("Location: create.php");
        exit;
    }

    $result = $controller->adduser(
        $first_name,
        $last_name,
        $email,
        $phone_no,
        $address,
        $password,
        $gender,
        $DOB,
        $hobby,
        $country,
        $image_path
    );

    if ($result) {
        unset($_SESSION['formData']);
        $_SESSION['success'] = "User added successfully!";
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['error'] = "Failed to add User.";
        header("Location: create.php");
        exit;
    }
}

include_once("../header.php");
include_once("../sidebar.php");

$formData = $_SESSION['formData'] ?? [];
?>

<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Add New User</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Add User</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
</div><!-- /.content-header -->

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
            <div class="card-header">
                <h3 class="card-title">Add User</h3>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form id="userForm" action="create.php" method="post" enctype="multipart/form-data">
                <div class="card-body">

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="first_name">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="first_name" name="first_name"
                                   value="<?= htmlspecialchars($formData['first_name'] ?? '') ?>"
                                   placeholder="Enter first name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="last_name">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="last_name" name="last_name"
                                   value="<?= htmlspecialchars($formData['last_name'] ?? '') ?>"
                                   placeholder="Enter last name">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email"
                                   value="<?= htmlspecialchars($formData['email'] ?? '') ?>"
                                   placeholder="Enter email" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone_no">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="phone_no" name="phone_no"
                                   value="<?= htmlspecialchars($formData['phone_no'] ?? '') ?>"
                                   placeholder="Enter 10-digit number" autocomplete="off" maxlength="10">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control password" id="password" name="password" placeholder="Enter password" autocomplete="new-password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                    <span class="fa fa-eye toggle" style="cursor: pointer;"></span>
                                    </div>
                                </div>
                                </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                                   placeholder="Re-enter password">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="DOB">Date of Birth <span class="text-danger">*</span></label>
                            <div class="input-group date" id="dateofbirth" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input"
                                       data-target="#dateofbirth" id="DOB" name="DOB"
                                       value="<?= htmlspecialchars($formData['DOB'] ?? '') ?>"
                                       placeholder="Select Date of Birth" autocomplete="off">
                                <div class="input-group-append" data-target="#dateofbirth" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="image_path">Profile Image <span class="text-danger">*</span></label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image_path" name="image_path"
                                       accept="image/*">
                                <label class="custom-file-label" for="image_path">Choose file</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Gender <span class="text-danger">*</span></label><br>
                            <div class="bg-light p-3 rounded shadow-sm">
                            <?php
                            $genders = ['male' => 'Male', 'female' => 'Female', 'other' => 'Other'];
                            foreach ($genders as $key => $label) {
                                $checked = (isset($formData['gender']) && $formData['gender'] === $key) ? 'checked' : '';
                                echo "<div class='form-check form-check-inline'>
                                        <input class='form-check-input' type='radio' name='gender' value='$key' $checked>
                                        <label class='form-check-label'>$label</label>
                                      </div>";
                            }
                            ?>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Hobbies <small class="text-muted">(Select at least one)</small></label><br>
                            <div class="bg-light p-3 rounded shadow-sm">
                            <?php
                            $hobbies = ["Travelling", "Watch Movies", "Reading", "Cooking", "Photography", "Gaming", "Music"];
                            $selectedHobbies = $formData['hobby'] ?? [];
                            foreach ($hobbies as $hobby) {
                                $checked = (is_array($selectedHobbies) && in_array($hobby, $selectedHobbies)) ? 'checked' : '';
                                $label = $hobby === "Watch Movies" ? "Watching Movies" : $hobby;
                                echo "<div class='form-check form-check-inline'>
                                        <input class='form-check-input' type='checkbox' name='hobby[]' value='" . htmlspecialchars($hobby) . "' $checked>
                                        <label class='form-check-label'>" . htmlspecialchars($label) . "</label>
                                      </div>";
                            }
                            ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="address">Address <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="address" name="address" rows="4"
                                      placeholder="Enter your address"><?= htmlspecialchars($formData['address'] ?? '') ?></textarea>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="country">Country <span class="text-danger">*</span></label>
                            <select class="form-control" name="country" id="country">
                                <option value="" disabled <?= empty($_SESSION['formData']['country']) ? 'selected' : '' ?>>Select Country</option>
                                <option value="india" <?= ($_SESSION['formData']['country'] ?? '') === 'india' ? 'selected' : '' ?>>🇮🇳 India</option>
                                <option value="UK" <?= ($_SESSION['formData']['country'] ?? '') === 'UK' ? 'selected' : '' ?>>🇬🇧 UK</option>
                                <option value="russia" <?= ($_SESSION['formData']['country'] ?? '') === 'russia' ? 'selected' : '' ?>>🇷🇺 Russia</option>
                                <option value="usa" <?= ($_SESSION['formData']['country'] ?? '') === 'usa' ? 'selected' : '' ?>>🇺🇸 USA</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-primary float-right">Add User</button>
                </div>
            </form>
        </div>
    </div><!-- /.container-fluid -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php
include_once("../footer.php");
?>
