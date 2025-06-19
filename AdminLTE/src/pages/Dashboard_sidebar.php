<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../../config/config.php');
?>

<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link">
      <img src="../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <?php if (!empty($res['image_path']) && file_exists(__DIR__ . '/user/' . $res['image_path'])): ?>
          <img src="./user/<?= htmlspecialchars($res['image_path']) ?>" alt="Profile" style="width:25px; height:auto; border-radius:50%;">
        <?php else: ?>
          <img src="../assets/img/profile.png" alt="Profile" style="width:25px; height:auto; border-radius:50%;">
        <?php endif; ?>
        </div>
        <?php
            if (isset($_SESSION['user_name'])) {?>
                <div class="info">
              <a href="#" class="d-block">             <P>Hello, <strong><?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?></strong></p>              </a>              </div>
              <?php            }else{}            ?>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                </li>
                <?php
            if (isset($_SESSION['user_name'])) {
           ?>  
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>
                            User Administration
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="user/index.php" class="nav-link">
                                <i class="fas fa-list-alt nav-icon"></i>
                                <p> Manage Users </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="create.php" class="nav-link">
                                <i class="fas fa-user-plus nav-icon"></i>
                                <p>Create New User</p>
                            </a>
                        </li>
                    </ul>
                  </li>
                  <?php
            } else {}
              ?>
            </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <div class="content-wrapper">
    <div class="content-header">