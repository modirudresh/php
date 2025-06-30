<?php

include_once("../user/indexaction.php");
include_once("../student/indexaction.php");
include_once("../header.php");
include_once("../sidebar.php");
?>


<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
          <h3><?= isset($totalUsers) && is_numeric($totalUsers) ? htmlspecialchars($totalUsers) : 'N/A' ?></h3>
          <p> Users</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="../user/index.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
 
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
          <h3><?= isset($totalStudents) && is_numeric($totalStudents) ? htmlspecialchars($totalStudents) : 'N/A' ?></h3>
          <p> Students</p>
          </div>
          <div class="icon">
          <i class="ion ion-university"></i>
          </div>
          <a href="../student/index.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
          <h3>N/A
            <!-- <?= isset($totalUsers) && is_numeric($totalUsers) ? htmlspecialchars($totalUsers) : 'N/A' ?> -->
        </h3>
          <p> Users</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="../student/index.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
          <h3>N/A
            <!-- <?= htmlspecialchars($totalUsers) ?> -->
        </h3>
            <p> Users</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="../student/index.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>
    <!-- /.row -->
    <!-- user details -->
  <?php  include_once("user_dashboard.php");?>

<!-- student details -->
<?php  include_once("student_dashboard.php");?>
       
    </div>
</section>
</div>
</div>
