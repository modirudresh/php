<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('./config/config.php');

// Fetch users from database
$users = [];
$sql = "SELECT * FROM User ORDER BY created_at DESC";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php include('components/head.html'); ?>
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css"/>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <?php include('components/navbar.html'); ?>
  <?php include('components/sidebar.html'); ?>

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
            <h3 class="card-title">User Records</h3>
            <div class="card-tools">
              <a href="Add_User.php" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> Add User
              </a>
          </div>
            </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Full Name</th>
                  <th>Email</th>
                  <th>Profile Image</th>
                  <th>Address<br><small>Country</small></th>
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
                        <?php if (!empty($res['image_path'])): ?>
                          <img src="<?= htmlspecialchars($res['image_path']) ?>" alt="Profile" style="width:80px; height:auto;">
                        <?php else: ?>
                          <span>No Image</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?= nl2br(htmlspecialchars($res['address'])) ?><br>
                        <small class="badge badge-dark"><?= htmlspecialchars(strtoupper($res['country'])) ?></small>
                      </td>
                      <td><?= htmlspecialchars($res['DOB']) ?></td>
                      <td>
                        <?php
                          $phone = htmlspecialchars($res['phone_no']);
                          echo "<a href='tel:+91$phone'>+91 " . substr($phone, 0, 5) . ' ' . substr($phone, 5) . "</a>";
                        ?>
                      </td>
                      <td>
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
                          <span class="badge badge-info"><?= htmlspecialchars(trim($hobby)) ?></span>
                        <?php endforeach; ?>
                      </td>
                      <td>
                        <a href="update.php?id=<?= $res['id'] ?>" class="btn btn-warning btn-sm">
                          <i class="fa fa-edit"></i>
                        </a>
                        <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $res['id'] ?>">
                          <i class="fa fa-trash"></i>
                        </a>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal<?= $res['id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $res['id'] ?>" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel<?= $res['id'] ?>">Confirm Delete</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                              </div>
                              <div class="modal-body">
                                Are you sure you want to delete <strong><?= htmlspecialchars($res['first_name']) ?></strong>?
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <a href="delete.php?id=<?= $res['id'] ?>" class="btn btn-danger">Delete</a>
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
<script>
  $(function () {
    $("#example1").DataTable({
      responsive: true,
      lengthChange: false,
      autoWidth: false,
      buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>
</body>
</html>
