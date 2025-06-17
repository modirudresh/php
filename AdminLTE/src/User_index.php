<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../config/config.php');

$users = [];
$sql = "SELECT * FROM User ORDER BY created_at ASC";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
  <?php include('./components/head.html'); ?>
<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">
<?php include('./components/message.php'); ?>
  <?php include('./components/navbar.html'); ?>
  <?php include('./components/sidebar.html'); ?>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6"><h1 class="m-0">User List</h1></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">User List</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
            <!-- <h3 class="card-title">User Records</h3> -->
            <div class="card-tools">
              <a href="User_add.php" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> Add User
              </a>
          </div>
            </div>
            <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead style="text-align: center;">
                <tr>
                  <th>#</th>
                  <th>Full Name</th>
                  <th>Email</th>
                  <th>Image</th>
                  <th>Address</th>
                  <th>DOB</th>
                  <th>Phone</th>
                  <th>Gender</th>
                  <th>Hobbies</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                  <?php while ($res = mysqli_fetch_assoc($result)): ?>
                    <tr>
                      <td><?= htmlspecialchars($res['id']) ?></td>
                      <td><?= htmlspecialchars($res['first_name'] . ' ' . $res['last_name']) ?></td>
                      <td><?= htmlspecialchars($res['email']) ?></td>
                      <td>
                        <?php if (!empty($res['image_path']) && file_exists($res['image_path'])): ?>
                          <img src="<?= htmlspecialchars($res['image_path']) ?>" alt="Profile" style="width:60px; height:auto;">
                        <?php else: ?>
                          <img src="uploads/default.png" alt="Default Profile" style="width:60px; height:auto; object-fit: contain;">
                          <?php endif; ?>
                      </td>
                      <td>
                        <?= nl2br(htmlspecialchars($res['address'])) ?><br>
                        <small class="badge badge-dark"><?= htmlspecialchars(strtoupper($res['country'])) ?></small>
                      </td>
                      <td><?= htmlspecialchars($res['DOB']) ?></td>
                      <td style="text-align: center; margin:auto; font-size: 12px;">
                        <?php
                          $phone = htmlspecialchars($res['phone_no']);
                          echo "<a href='tel:+91$phone'> " . substr($phone, 0, 5) . ' ' . substr($phone, 5) . "</a>";
                        ?>
                      </td>
                      <td style="text-align: center; margin:auto;">
                        <?php
                          $gender = strtolower($res['gender']);
                          echo match($gender) {
                            'male' => "<span class='badge badge-primary'>Male</span>",
                            'female' => "<span class='badge badge-pink'>Female</span>",
                            default => "<span class='badge badge-secondary'>Other</span>",
                          };
                        ?>
                      </td>
                      <td>
                        <?php foreach (explode(',', $res['hobby']) as $hobby): ?>
                          <span class="badge badge-info w-100"><?= htmlspecialchars(trim($hobby)) ?></span><br>
                        <?php endforeach; ?>
                      </td>
                      <td class="text-center">
                        <a href="User_view.php?id=<?= $res['id'] ?>" class="text-info me-6" title="View User" aria-label="View User" style="font-size:2rem;">
                          <i class="fa fa-eye"></i>
                        </a>
                        <a href="User_edit.php?id=<?= urlencode($res['id']) ?>" class="text-warning me-6" title="Edit User" aria-label="Edit User" style="font-size:2rem;">
                          <i class="fa fa-edit"></i>
                        </a>
                        <a href="#" class="text-danger me-6" onclick="openDeleteModal(<?= $res['id'] ?>)">
                          <i class="fa fa-trash"></i>
                        </a>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal<?= $res['id'] ?>" tabindex="-1"
                  aria-labelledby="deleteModalLabel<?= $res['id'] ?>" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="deleteModalLabel<?= $res['id'] ?>">Confirm Delete</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        Are you sure you want to delete this record?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <a href="User_delete.php?id=<?= htmlspecialchars($res['id']) ?>" class="btn btn-danger">Delete</a>
                      </div>
                    </div>
                  </div>
                </div>
                        </td>
                    </tr>
                  <?php endwhile; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
  </div>

  <?php include('./components/footer.php'); ?>

</div>

<?php include('./components/scripts.html'); ?>

<!-- jQuery -->
<script src="./plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="./dist/js/adminlte.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="./plugins/datatables/jquery.dataTables.min.js"></script>
<script src="./plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="./plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="./plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="./plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="./plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="./plugins/jszip/jszip.min.js"></script>
<script src="./plugins/pdfmake/pdfmake.min.js"></script>
<script src="./plugins/pdfmake/vfs_fonts.js"></script>
<script src="./plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="./plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="./plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis", 
            {
                text: 'Reset',
                action: function () {
                    location.reload();
                }
            }
          ]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      function openDeleteModal(id) {
        var modal = new bootstrap.Modal(document.getElementById('deleteModal' + id));
        modal.show();
      }
    </script>
</body>
</html>
