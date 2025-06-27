<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../Controllers/UserController.php';
use Controllers\UserController;

$controller = new UserController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id']) && isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    header('Content-Type: application/json');
    $deleteId = $_POST['delete_id'];
    $deleted = $controller->deleteUser($deleteId);

    if ($deleted) {
        echo json_encode(['status' => 'success', 'message' => 'User deleted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete user']);
    }
    exit();
}

$users = $controller->index();

include_once("../header.php");
include_once("../sidebar.php");
?>

<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0"></h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">User list</li>
            </ol>
        </div>
    </div>
</div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <h2 class="col-md-9 m-auto pl-4"></h2>
                    <a href="create.php" class="btn btn-primary px-4 col-md-3 m-auto">Add New User</a>
                </div>
            </div>
            <div class="card-body">
                <table id="userTable" class="table table-bordered table-striped table-hover">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Image</th>
                            <th>Gender</th>
                            <th>Contact No</th>
                            <th>Hobby</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-justify">
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $User): ?>
                                <tr id="user-row-<?= $User['id'] ?>">
                                    <td><?= htmlspecialchars($User['id']) ?></td>
                                    <td><?= htmlspecialchars($User['first_name']) ?></td>
                                    <td><?= htmlspecialchars($User['last_name'] ?? 'NA') ?></td>
                                    <td><?= htmlspecialchars($User['email']) ?></td>
                                    <td style="text-align: center;">
                                        <img src="<?= (!empty($User['image_path']) && file_exists('../../' . $User['image_path'])) ? '../../' . htmlspecialchars($User['image_path']) : '../../uploads/default.png' ?>"
                                             alt="Profile" class="img-thumbnail mt-1 shadow-lg"
                                             style="height: auto; width: 60px; display: inline-block;">
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $gender = $User['gender'];
                                        echo match ($gender) {
                                            'Male' => "<span class='badge badge-primary'>Male</span>",
                                            'Female' => "<span class='badge' style='background-color:pink;'>Female</span>",
                                            'other' => "<span class='badge badge-secondary'>Other</span>",
                                            default => "<span>N/A</span>",
                                        };
                                        ?>
                                    </td>
                                    <td><?= htmlspecialchars($User['phone_no']) ?></td>
                                    <td>
                                        <?php
                                        if (!empty($User['hobby'])) {
                                            foreach (explode(',', $User['hobby']) as $hobby) {
                                                echo "<span class='badge badge-info w-100'>" . htmlspecialchars(trim($hobby)) . "</span><br>";
                                            }
                                        } else {
                                            echo 'N/A';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                    <a href="view.php?id=<?= $User['id'] ?>" class="btn btn-sm btn-info">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="edit.php?id=<?= $User['id'] ?>" class="btn btn-sm btn-warning">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger ajaxDeleteBtn" data-id="<?= $User['id'] ?>">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="10" class="text-center">No users found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
</div>

<?php include_once("../footer.php"); ?>


<script>
    $(document).ready(function () {
        $(document).on('click', '.ajaxDeleteBtn', function () {
            let userId = $(this).data('id');
            if (!confirm('Are you sure you want to delete this user?')) return;

            $.ajax({
                url: 'index.php',
                type: 'POST',
                data: { delete_id: userId },
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function (res) {
                    if (res.status === 'success') {
                        toastr.success(res.message);
                        $('#user-row-' + userId).fadeOut(800, function () {
                            $(this).remove();
                        });
                    } else {
                        toastr.error(res.message);
                    }
                },
                error: function () {
                    toastr.error('An error occurred');
                }
            });
        });
    });
</script>
