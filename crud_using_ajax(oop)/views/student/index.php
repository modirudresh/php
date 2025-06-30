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
                <li class="breadcrumb-item active">Student List</li>
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
                    <a href="create.php" class="btn btn-primary px-4">Add New Student</a>
                </div>
            </div>
            <div class="card-body">
                <table id="studentTable" class="table table-bordered table-striped table-hover text-center">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-justify">
                        <?php if (!empty($students)): ?>
                            <?php foreach ($students as $student): ?>
                                <tr id="student-row-<?= $student['id'] ?>">
                                    <td><?= !empty($student['id']) ? htmlspecialchars($student['id']) : 'NA' ?></td>
                                    <td><?= !empty($student['first_name']) ? htmlspecialchars($student['first_name']) : 'NA' ?></td>
                                    <td><?= !empty($student['last_name']) ? htmlspecialchars($student['last_name']) : 'NA' ?></td>
                                    <td><?= !empty($student['email']) ? htmlspecialchars($student['email']) : 'NA' ?></td>
                                    <td>
                                        <a href="javascript:void(0);" class="btn btn-sm btn-info viewStudentBtn" data-id="<?= $student['id'] ?>"><i class="fa fa-eye"></i></a>
                                        <a href="edit.php?id=<?= $student['id'] ?>" class="btn btn-sm btn-warning"><i class="fa fa-pen"></i></a>
                                        <button class="btn btn-sm btn-danger ajaxDeleteBtn" data-id="<?= $student['id'] ?>"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="7" class="text-center">No students found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewStudentModal" tabindex="-1" role="dialog" aria-labelledby="studentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xs modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="studentModalLabel"><i class="fas fa-user mr-2"></i> Student Details</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span style="font-size:22px;">&times;</span></button>
                </div>
                <div class="modal-body p-3" id="studentDetailContent">
                    <div class="text-center text-muted">Loading...</div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
</div>

<?php include_once("../footer.php"); ?>

<script>
$(document).on('click', '.viewStudentBtn', function () {
    const studentId = $(this).data('id');
    $('#studentDetailContent').html('<div class="text-center text-muted py-5">Loading...</div>');
    $('#viewStudentModal').modal('show');
    $.ajax({
        url: 'view.php',
        type: 'GET',
        data: { id: studentId },
        success: function (html) {
            $('#studentDetailContent').html(html);
        },
        error: function () {
            $('#studentDetailContent').html('<div class="alert alert-danger">Failed to load student details.</div>');
        }
    });
});

$(document).on('click', '.ajaxDeleteBtn', function () {
    let studentId = $(this).data('id');
    if (!confirm('Are you sure you want to delete this student?')) return;
    $.ajax({
        url: 'index.php',
        type: 'POST',
        data: { delete_id: studentId },
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        success: function (res) {
            if (res.status === 'success') {
                toastr.success(res.message);
                $('#student-row-' + studentId).fadeOut(800, function () { $(this).remove(); });
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
