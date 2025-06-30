<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../../../config/config.php');

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int)$_GET['id'];
$stmt = $con->prepare("SELECT * FROM User_data WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user) {
    header('Location: index.php');
    exit;
}
?>
<?php include('../header.php'); ?>
<?php include('../sidebar.php'); ?>
      <div class="container-fluid mb-2">
        <div class="row">
          <div class="col-sm-6"><h1>User Details</h1></div>
          <div class="col-sm-6 text-sm-right">
            <a href="index.php" class="btn btn-secondary btn-sm">
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
            <img src="./<?= (!empty($user['image_path']) && file_exists($user['image_path']) ? $user['image_path'] : '../../assets/img/default.png') ?>" alt="Profile" class="img-thumbnail mt-1 shadow-lg" style="height: 80px; width:auto;">
            </div>
              <div class="col-md-9">
                <table class="table table-sm">
                  <tbody>
                    <tr>
                      <th>Full Name</th>
                      <td>
                      <?= (!empty($user['first_name']) && !empty($user['last_name']))
                          ? htmlspecialchars(trim($user['first_name'] . ' ' . $user['last_name']))
                          : 'N/A' ?>
                      </td>
                    </tr>
                    <tr>
                      <th>Email</th>
                      <td><?= !empty($user['email']) ? htmlspecialchars($user['email']) : 'N/A' ?></td>
                    </tr>
                    <tr>
                      <th>Phone</th>
                      <td><?= !empty($user['phone_no']) ? htmlspecialchars($user['phone_no']) : 'N/A' ?></td>
                    </tr>
                    <tr>
                      <th>DOB</th>
                      <td><?= !empty($user['DOB']) ? date('d-M-Y', strtotime($user['DOB'])) : 'N/A' ?></td>
                    </tr>
                    <tr>
                      <th>Gender</th>
                      <td>
                        <span class="badge <?= $user['gender'] === 'male' ? 'badge-primary' : ($user['gender'] === 'female' ? 'badge-warning' : 'badge-secondary') ?>">
                          <?= !empty($user['gender']) ? htmlspecialchars(ucfirst($user['gender'])) : 'N/A'?>
                        </span>
                      </td>
                    </tr>
                    <tr>
                      <th>Address</th>
                      <td><?= !empty($user['address']) ? nl2br(htmlspecialchars($user['address'])) : 'N/A' ?></td>
                    </tr>
                    <tr>
                      <th>Country</th>
                      <td><?= !empty($user['country']) ? strtoupper(htmlspecialchars($user['country'])) : 'N/A' ?></td>
                    </tr>
                    <tr>
                      <th>Hobbies</th>
                      <td>
                        <?php foreach (!empty($user['hobby']) ? explode(',', $user['hobby']) : [] as $hobby):  ?>
                          <span class="badge badge-info mr-1"><?= !empty(trim($hobby)) ? htmlspecialchars(trim($hobby)) : 'N/A' ?></span>
                        <?php endforeach; ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <a href="edit.php?id=<?= $user['id'] ?>" class="btn btn-warning btn-sm">
              <i class="fas fa-edit mr-1"></i> Edit
            </a>
          </div>
        </div>
      </div>
    </section>
  </div>

  <?php include('../footer.php'); ?>

