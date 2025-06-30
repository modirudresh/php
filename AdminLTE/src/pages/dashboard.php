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
  <?php if (isset($_SESSION['user_name'])): ?>
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
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
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
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
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
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
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

<?php
$sql = "SELECT * FROM User_data ORDER BY created_at ASC";
$result = mysqli_query($con, $sql);
?>
<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
         <h3>User Details</h3>
      </div>
      <div class="card-body">
   
      <table id="example1" class="table table-bordered table-striped">
      <?php
            if (isset($_SESSION['user_name'])) {
           ?>  
      <thead class="text-center">
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
            </tr>
          </thead>
          <tbody>
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
              <?php while ($res = mysqli_fetch_assoc($result)): ?>
                <tr>
                  <td><?= htmlspecialchars($res['id'] ?? 'N/A') ?></td>
                  <td>
                    <?= (!empty($res['first_name']) || !empty($res['last_name']))
                        ? htmlspecialchars(trim($res['first_name'] . ' ' . $res['last_name']))
                        : 'N/A' ?>
                  </td>
                  <td><?= !empty($res['email']) ? htmlspecialchars($res['email']) : 'N/A' ?></td>
                  <td>
                    <?php if (!empty($res['image_path']) && file_exists($res['image_path'])): ?>
                      <img src="<?= htmlspecialchars($res['image_path']) ?>" alt="Profile" style="width:60px; height:auto;">
                    <?php else: ?>
                      <img src="../assets/img/default.png" alt="Default Profile" style="width:60px; height:auto; object-fit:contain;">
                    <?php endif; ?>
                  </td>
                  <td>
                    <?= !empty($res['address']) ? nl2br(htmlspecialchars($res['address'])) : 'N/A' ?><br>
                    <?php if (!empty($res['country'])): ?>
                      <small class="badge badge-dark"><?= strtoupper($res['country']) ?></small>
                    <?php endif; ?>
                  </td>
                  <td style="min-width: max-content;"><?= !empty($res['DOB']) ? date('d-m-Y', strtotime($res['DOB'])) : 'N/A' ?></td>
                  <td class="text-center">
                    <?php
                      if (!empty($res['phone_no'])) {
                        $phone = preg_replace('/\D/', '', $res['phone_no']);
                        echo "<a href='tel:+91$phone'>" . substr($phone, 0, 5) . ' ' . substr($phone, 5) . "</a>";
                      } else {
                        echo 'N/A';
                      }
                    ?>
                  </td>
                  <td class="text-center">
                    <?php
                      $gender = ($res['gender'] ?? '');
                      echo match($gender) {
                        'male'   => "<span class='badge badge-primary'>Male</span>",
                        'female' => "<span class='badge' style='background-color:pink;'>Female</span>",
                        'other'  => "<span class='badge badge-secondary'>Other</span>",
                        default  => "<span>N/A</span>"
                      };
                    ?>
                  </td>
                  <td>
                    <?php
                      if (!empty($res['hobby'])) {
                        foreach (explode(',', $res['hobby']) as $hobby) {
                          echo "<span class='badge badge-info w-100'>" . htmlspecialchars(trim($hobby)) . "</span><br>";
                        }
                      } else {
                        echo 'N/A';
                      }
                    ?>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr><td colspan="10" class="text-center">No records found.</td></tr>
            <?php endif; ?>
          </tbody>
          <?php
            } else {
              echo "<div class='alert alert-warning' style='min-height: 100px;'>Please log in to view the user list.<br><a href='../login.php' class='btn btn-primary' style='text-decoration:none;'>Login</a></div>";
            }
          ?>
             
          </table>
        </div>
        <div class="card-footer">
                    <a href="user/index.php" class="btn btn-primary btn-sm float-right">See More</a>
                </div> 
    </div>
    </div>



</div>

  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->



<?php include('./Dashboard_footer.php'); ?>
