<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../Controllers/UserController.php';
use Controllers\UserController;

$controller = new UserController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];
    $deleted = $controller->deleteUser($deleteId);

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

$users = $controller->index();

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
</div><!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['success']) ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php elseif (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
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
                                <tr>
                                    <td><?= htmlspecialchars($User['id'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($User['first_name'] ?? 'NA') ?></td>
                                    <td><?= !empty($User['last_name']) ? htmlspecialchars($User['last_name']) : 'NA' ?></td>
                                    <td><?= htmlspecialchars($User['email'] ?? '') ?></td>
                                    <td style="text-align: center;">
                                        <img src="<?= (!empty($User['image_path']) && file_exists('../../' . $User['image_path'])) ? '../../' . htmlspecialchars($User['image_path']) : '../../uploads/default.png' ?>"
                                             alt="Profile"
                                             class="img-thumbnail mt-1 shadow-lg"
                                             style="height: auto; width: 60px; display: inline-block;">
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $gender = ($User['gender'] ?? '');
                                        echo match ($gender) {
                                            'male' => "<span class='badge badge-primary'>Male</span>",
                                            'female' => "<span class='badge' style='background-color:pink;'>Female</span>",
                                            'other' => "<span class='badge badge-secondary'>Other</span>",
                                            default => "<span>N/A</span>",
                                        };
                                        ?>
                                    </td>
                                    <td><?= htmlspecialchars($User['phone_no'] ?? '') ?></td>
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
                                        <a href="view.php?id=<?= htmlspecialchars($User['id']) ?>" class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="edit.php?id=<?= htmlspecialchars($User['id']) ?>" class="btn btn-sm btn-warning">
                                            <i class="fa fa-pen"></i>
                                        </a>

                                        <!-- Delete Trigger -->
                                        <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal<?= $User['id'] ?>">
                                        <i class="fa fa-trash"></i>
                                        </a>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal<?= $User['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel<?= $User['id'] ?>" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel<?= $User['id'] ?>">Confirm Delete</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true" style="font-size:28px;">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">Are you sure you want to delete this record?</div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <form method="post" action="index.php" style="display:inline;">
                                                <input type="hidden" name="delete_id" value="<?= $User['id'] ?>">
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
                                <td colspan="10" class="text-center">No users found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <!-- Optional footer -->
            </div>
        </div>

    </div><!-- /.container-fluid -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php
include_once("../footer.php");
?>
