<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../config/config.php');

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int)$_GET['id'];
$stmt = $con->prepare("SELECT * FROM User WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include('./components/head.html'); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <?php include('./components/navbar.html'); ?>
  <?php include('./components/sidebar.html'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid mb-2">
        <div class="row">
          <div class="col-sm-6"><h1>User Details</h1></div>
          <div class="col-sm-6 text-sm-right">
            <a href="User_index.php" class="btn btn-secondary btn-sm">
              <i class="fas fa-arrow-left mr-1"></i> Back to List
            </a>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="card card-primary">
          <div class="card-header"><h3 class="card-title">Profile Info</h3></div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3 text-center justify-content-center m-auto">
                <img src="<?= htmlspecialchars(!empty($user['image_path']) && file_exists($user['image_path']) ? $user['image_path'] : 'uploads/default.png') ?>"
                     class="img-fluid img-thumbnail mb-3" alt="Profile Image">
              </div>
              <div class="col-md-9">
                <table class="table table-sm">
                  <tbody>
                    <tr><th>Full Name</th><td><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></td></tr>
                    <tr><th>Email</th><td><?= htmlspecialchars($user['email']) ?></td></tr>
                    <tr><th>Phone</th><td><?= htmlspecialchars($user['phone_no']) ?></td></tr>
                    <tr><th>DOB</th><td><?= htmlspecialchars($user['DOB']) ?></td></tr>
                    <tr><th>Gender</th><td>
                      <span class="badge <?= $user['gender'] === 'male' ? 'badge-primary' : ($user['gender'] === 'female' ? 'badge-warning' : 'badge-secondary') ?>">
                        <?= htmlspecialchars(ucfirst($user['gender'])) ?>
                      </span>
                    </td></tr>
                    <tr><th>Address</th><td><?= nl2br(htmlspecialchars($user['address'])) ?></td></tr>
                    <tr><th>Country</th><td><?= strtoupper(htmlspecialchars($user['country'])) ?></td></tr>
                    <tr><th>Hobbies</th><td>
                      <?php foreach (explode(',', $user['hobby']) as $h): ?>
                        <span class="badge badge-info mr-1"><?= htmlspecialchars(trim($h)) ?></span>
                      <?php endforeach; ?>
                    </td></tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <a href="User_edit.php?id=<?= $user['id'] ?>" class="btn btn-warning btn-sm">
              <i class="fas fa-edit mr-1"></i> Edit
            </a>
          </div>
        </div>
      </div>
    </section>
  </div>

  <?php include('./components/footer.php'); ?>
</div>
<?php include('./components/scripts.html'); ?>
</body>
</html>
