<?php
include_once("indexaction.php");
include_once("../header.php");
include_once("../sidebar.php");
?>

<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6"><h1 class="m-0"></h1></div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">User List</li>
            </ol>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
        <div class="card-header">
                <div class="row">
                    <h2 class="col-md-9 m-auto pl-4"></h2>
                    <a href="create.php" class="btn btn-primary px-4">Add User</a>
                </div>
            </div>
            <div class="card-body">
                <table id="userTable" class="table table-bordered table-striped table-hover text-center">
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
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $User): ?>
                                <tr id="user-row-<?= htmlspecialchars($User['id']) ?>">
                                    <td><?= !empty($User['id']) ? htmlspecialchars($User['id']) : 'NA' ?></td>
                                    <td><?= !empty($User['first_name']) ? htmlspecialchars($User['first_name']) : 'NA' ?></td>
                                    <td><?= !empty($User['last_name']) ? htmlspecialchars($User['last_name']) : 'NA' ?></td>
                                    <td><?= !empty($User['email']) ? htmlspecialchars($User['email']) : 'NA' ?></td>
                                    <td>
                                        <img src="<?= (!empty($User['image_path']) && file_exists('../../' . $User['image_path'])) ? '../../' . htmlspecialchars($User['image_path']) : '../../uploads/default.png' ?>" class="img-thumbnail mt-1 shadow-lg" style="width: 60px;">
                                    </td>
                                    <td>
                                        <?php
                                        echo match ($User['gender'] ?? '') {
                                            'Male' => "<span class='badge badge-primary'>Male</span>",
                                            'Female' => "<span class='badge' style='background-color:pink;'>Female</span>",
                                            'Other' => "<span class='badge badge-secondary'>Other</span>",
                                            default => "<span>NA</span>",
                                        };
                                        ?>
                                    </td>
                                    <td><?= !empty($User['phone_no']) ? htmlspecialchars($User['phone_no']) : 'NA' ?></td>
                                    <td>
                                        <?php
                                        if (!empty($User['hobby'])) {
                                            foreach (explode(',', $User['hobby']) as $hobby) {
                                                echo "<span class='badge badge-info w-100'>" . htmlspecialchars(trim($hobby)) . "</span><br>";
                                            }
                                        } else {
                                            echo 'NA';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info viewUserBtn" data-id="<?= htmlspecialchars($User['id']) ?>"><i class="fa fa-eye"></i></button>
                                        <button class="btn btn-sm btn-warning editUserBtn" data-id="<?= htmlspecialchars($User['id']) ?>"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-danger ajaxDeleteBtn" data-id="<?= htmlspecialchars($User['id']) ?>"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="9" class="text-center">No users found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewUserModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="userModalLabel"><i class="fas fa-user mr-2"></i> User Details</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span style="font-size:22px;">&times;</span></button>
                </div>
                <div class="modal-body p-3" id="userDetailContent">
                    <div class="text-center text-muted">Loading...</div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="edituserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white"><i class="fas fa-edit mr-2"></i> Edit User</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span style="font-size:22px;">&times;</span></button>
                </div>
                <div class="modal-body p-3" id="editUserContent">
                    <div class="text-center text-muted">Loading...</div>
                </div>
            </div>
        </div>
    </div>

</section>

<?php include_once("../footer.php"); ?>

<script>
$(document).on('click', '.viewUserBtn', function () {
    const userId = $(this).data('id');
    $('#userDetailContent').html('<div class="text-center text-muted py-5">Loading...</div>');
    $('#viewUserModal').modal('show');
    $.ajax({
        url: 'view.php',
        type: 'GET',
        data: { id: userId },
        success: function (html) {
            $('#userDetailContent').html(html);
        },
        error: function () {
            $('#userDetailContent').html('<div class="alert alert-danger">Failed to load user details.</div>');
        }
    });
});

$(document).on('click', '.editUserBtn', function () {
    const userId = $(this).data('id');
    $('#editUserModal').modal('show');
    $('#editUserContent').html('<div class="text-center text-muted">Loading...</div>');

    $.ajax({
        url: 'edit.php',
        type: 'GET',
        data: { id: userId },
        success: function (data) {
            $('#editUserContent').html(data);
        },
        error: function () {
            $('#editUserContent').html('<div class="text-danger text-center">Failed to load content.</div>');
        }
    });
});

$(document).on('click', '.ajaxDeleteBtn', function () {
    const userId = $(this).data('id');
    if (!confirm('Are you sure you want to delete this user?')) return;
    $.ajax({
        url: 'index.php',
        type: 'POST',
        data: { delete_id: userId },
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        success: function (res) {
            if (res.status === 'success') {
                toastr.success(res.message);
                $('#user-row-' + userId).fadeOut(800, function () { $(this).remove(); });
            } else {
                toastr.error(res.message);
            }
        },
        error: function () {
            toastr.error('An error occurred');
        }
    });
});
</script>
