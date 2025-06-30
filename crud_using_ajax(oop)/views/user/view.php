<?php

include_once("viewaction.php");
?>
<div class="container-fluid py-3">
  <div class="row">
    
   <!-- Left Column: Image -->
    <div class="col-md-4 d-flex justify-content-center align-items-center mb-4" style="min-height: 200px;">
      <img src="<?= (!empty($user['image_path']) && file_exists('../../' . $user['image_path']))
          ? '../../' . htmlspecialchars($user['image_path'])
          : '../../uploads/default.png' ?>"
        alt="Profile Image"
        class="img-fluid img-thumbnail shadow-sm"
        style="height: 150px; width: auto;">
    </div>


    <!-- Right Column: User Info -->
    <div class="col-md-8">
      <table class="table table-striped table-bordered table-sm">
        <tbody>
          <tr>
            <th style="width: 30%;">First Name</th>
            <td><?= htmlspecialchars($user['first_name'] ?? 'N/A') ?></td>
          </tr>
          <tr>
            <th>Last Name</th>
            <td><?= htmlspecialchars($user['last_name'] ?? 'N/A') ?></td>
          </tr>
          <tr>
            <th>Email</th>
            <td><?= htmlspecialchars($user['email'] ?? 'N/A') ?></td>
          </tr>
          <tr>
            <th>Phone</th>
            <td><?= htmlspecialchars($user['phone_no'] ?? 'N/A') ?></td>
          </tr>
          <tr>
            <th>DOB</th>
            <td><?= !empty($user['DOB']) ? date('d-M-Y', strtotime($user['DOB'])) : 'N/A' ?></td>
          </tr>
          <tr>
            <th>Gender</th>
            <td>
              <span class="badge <?= $user['gender'] === 'Male' ? 'badge-primary' : ($user['gender'] === 'Female' ? 'badge-info' : 'badge-secondary') ?>">
                <?= !empty($user['gender']) ? htmlspecialchars(ucfirst($user['gender'])) : 'N/A' ?>
              </span>
            </td>
          </tr>
          <tr>
            <th>Address</th>
            <td><?= nl2br(htmlspecialchars($user['address'] ?? 'N/A')) ?></td>
          </tr>
          <tr>
            <th>Country</th>
            <td><?= strtoupper(htmlspecialchars($user['country'] ?? 'N/A')) ?></td>
          </tr>
          <tr>
            <th>Hobbies</th>
            <td>
              <?php
              if (!empty($user['hobby'])) {
                  foreach (explode(',', $user['hobby']) as $hobby) {
                      echo '<span class="badge badge-dark mr-1">' . htmlspecialchars(trim($hobby)) . '</span>';
                  }
              } else {
                  echo 'N/A';
              }
              ?>
            </td>
            </tr>
        </tbody>
      </table>
    </div>

  </div>
</div>
