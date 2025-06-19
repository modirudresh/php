<?php 
session_start(); 
include('../../config/config.php');
include('./Dashboard_header.php'); 
include('./Dashboard_sidebar.php'); 
?>

<div class="container-fluid">
  <div class="row mb-2">
  <div class="col-sm-6">
  <h1 class="m-0">Dashboard</h1>
  <p>Welcome to the admin dashboard.</p>
  <?php if (isset($_SESSION['user_name'])): ?>
    <p class="text-muted">Hello, <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong>! Glad to see you back.</p>
  <?php else: ?>
    <p class="text-muted">Please <a href="login.php">log in</a> to access your dashboard.</p>
  <?php endif; ?>
</div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->
</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
  <?php if (isset($_SESSION['user_name'])){ ?>

    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>
              <?php 
              if (isset($con)) {
                $result = $con->query("SELECT COUNT(*) AS total_users FROM User");
                echo htmlspecialchars($result ? $result->fetch_assoc()['total_users'] : 0);
                if ($result) $result->free();
              } else {
                echo 'N/A'; 
              }
              ?>
            </h3>
            <p> Users</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="user/index.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>
    <!-- /.row -->
    <?php
} else {
  echo '<div class="alert alert-warning">You must be logged in to view this page.</div>';
}
?>
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->



<?php include('./Dashboard_footer.php'); ?>
