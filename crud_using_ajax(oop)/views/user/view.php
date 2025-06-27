<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../Controllers/UserController.php';
use Controllers\UserController;

$controller = new UserController();

$user = null;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $viewID = $_GET['id'];
    $user = $controller->getUser($viewID);

    if (!$user) {
        $_SESSION['error'] = "User not found.";
        header("Location: index.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: index.php");
    exit();
}
?>
<?php include('../header.php'); ?>
<?php include('../sidebar.php'); ?>


    <div class="container-fluid mb-2">
      <div class="row">
        <div class="col-sm-6">
          <h1>User Details</h1>
        </div>
        <div class="col-sm-6 text-sm-right">
          <a href="index.php" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left mr-1"></i> Back to List
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Profile Info</h3>
        </div>
        <div class="card-body">
          <div class="row">
            <!-- Profile Image -->
            <div class="col-md-4 text-center m-auto">
            <img src="<?= (!empty($user['image_path']) && file_exists('../../' . $user['image_path'])) ? '../../' . htmlspecialchars($user['image_path']) : '../../uploads/default.png' ?>" 
                                alt="Profile" 
                                class="img-thumbnail mt-1 shadow-lg" 
                                style="height: 150px; width: auto; display: inline-block;">
            </div>

            <!-- User Info Table -->
            <div class="col-md-8">
              <table class="table table-sm">
                <tbody>
                  <tr>
                    <th>First Name</th>
                    <td>
                      <?= (!empty($user['first_name'])) 
                          ? htmlspecialchars(trim($user['first_name'])) 
                          : 'N/A' ?>
                    </td>
                  </tr>
                  <tr>
                    <th>Last Name</th>
                    <td>
                      <?= (!empty($user['last_name'])) 
                          ? htmlspecialchars(trim($user['last_name'])) 
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
                      <span class="badge 
                        <?= $user['gender'] === 'male' ? 'badge-primary' : 
                            ($user['gender'] === 'female' ? 'badge-info' : 'badge-secondary') ?>">
                        <?= !empty($user['gender']) ? htmlspecialchars(ucfirst($user['gender'])) : 'N/A' ?>
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
                      <?php foreach (!empty($user['hobby']) ? explode(',', $user['hobby']) : [] as $hobby): ?>
                        <span class="badge badge-dark mr-1"><?= htmlspecialchars(trim($hobby)) ?></span>
                      <?php endforeach; ?>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Card Footer -->
        <!-- Card Footer -->
<div class="card-footer d-flex justify-content-between align-items-center">
  <small class="text-muted float-right">
    <?php if (!empty($user['created_at'])): ?>
      Created on: <?= date('d M Y, h:i A', strtotime($user['created_at'])) ?>
    <?php endif; ?>
  </small>
</div>

      </div>
    </div>
  </section>
</div>
</div>
<?php include('../footer.php'); ?>
