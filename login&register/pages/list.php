<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("../config.php");

// $result = mysqli_query($con, "SELECT * FROM user");
$results_per_page = 4;

$sql = "SELECT COUNT(*) AS total FROM user";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$total_results = $row['total'];

$total_pages = ceil($total_results / $results_per_page);

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$start_limit = ($page - 1) * $results_per_page;

$sql = "SELECT * FROM user LIMIT $start_limit, $results_per_page";
$result = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/list.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../images/brand.png" type="image/icon">
  </head>

  <body>
    <?php
include("../components/sidebar.html");
include("../components/navbar.html");?>
    <div class="card shadow mb-4">
      <div class="card-header">
        <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
        <div style="display: flex; justify-content: flex-end;">
          <a href="insert.php"
            style="background-color: green; color: white; padding: 8px 12px; border-radius: 4px; text-decoration: none;">
            Add New User
          </a>
        </div>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead style="text-align:center; justify-content:center;">
              <tr>
                <th>#</th>
                <th style="width:100px;">Full Name</th>
                <th style="width:fit-content;">Email</th>
                <th style="width:140px;">Profile Image</th>
                <th style="width:130px;">Address
                  <p>country-code</p>
                </th>
                <th style="width:120px;">Date of Birth</th>
                <th style="width:180px;">Phone No.</th>
                <th style="width:110px;">Gender</th>
                <th>Hobby</th>
                <th style="width:210px;"> Actions</the=>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php while ($res = mysqli_fetch_assoc($result)): ?>
              <tr>
                <td><?= htmlspecialchars($res['id']) ?></td>
                <td><?= htmlspecialchars($res['first_name'])." ".htmlspecialchars($res['last_name']) ?></td>
                <td  style="width:80px;"><?= htmlspecialchars($res['email']) ?></td>
                
                
                
                
                <td>
                  <?php if (!empty($res['image_path'])): "no image" ?>

                  <!-- <img src="./<?= htmlspecialchars($res['image_path']) ?>" alt="Profile" /> -->
                  <img id="myImg" src="./<?= htmlspecialchars($res['image_path']) ?>" alt="Profile" style="width:100%;max-width:300px">
                  <?php else: ?>
                  <span>No Image</span>
                  <?php endif; ?>
                </td>


              

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- The Close Button -->
  <span class="close">&times;</span>

  <!-- Modal Content (The Image) -->
  <img class="modal-content" id="img01">

  <!-- Modal Caption (Image Text) -->
  <div id="caption"></div>
</div>


                <td><p style="text-align:left;"><?= nl2br(htmlspecialchars($res['address'])) ?></p><br>
                  <p
                    style='display:inline-block; background-color:white; color:#333; padding:4px; margin:1px; border-radius:5px; border:2px solid black; font-size:10px; font-weight:bold;'>
                    <?= htmlspecialchars(strtoupper($res['country'])) ?></p>
                </td>

                <td><?= htmlspecialchars($res['DOB']) ?></td>
                <td>
                  <?php
    $rawPhone = htmlspecialchars($res['phone_no']);
    $formattedPhone = '+91 ' . substr($rawPhone, 0, 5) . ' ' . substr($rawPhone, 5);
    echo "<a href='tel:+91$rawPhone' style='text-decoration: none; color: #000;'>$formattedPhone</a>";
  ?>
                </td>
                <td style="width:80px;">
                  <?php
              $gender = strtolower($res['gender']);
              if ($gender === 'male') {
                echo "<span class='gender-badge gender-male'><i class='fa-solid fa-person'></i> Male</span>";
              } elseif ($gender === 'female') {
                echo "<span class='gender-badge gender-female'><i class='fa-solid fa-person-dress'></i> Female</span>";
              } else {
                echo "<span class='gender-badge gender-other'><i class='fa-solid fa-transgender'></i> Other</span>";
              }
            ?>
                </td>
                <td>
                  <?php
              $hobbies = explode(',', $res['hobby']);
              foreach ($hobbies as $hobby) {
                echo "<span style='display:inline-block; min-width:80px;background-color:#e0e0e0; font-weight:800; color:black; padding:3px 6px; margin:1px; border-radius:5px; border:1px solid black; font-size:10px;'>"
                     . htmlspecialchars(trim($hobby)) . "</span>";
              }
            ?>
                </td>
                <td  style="width:200px;">
                  <button class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#viewUserModal"
                    onclick="populateViewModal(this)"
                    data-name="<?= htmlspecialchars($res['first_name'] . ' ' . $res['last_name']) ?>"
                    data-email="<?= htmlspecialchars($res['email']) ?>"
                    data-phone="<?= htmlspecialchars($res['phone_no']) ?>"
                    data-dob="<?= htmlspecialchars($res['DOB']) ?>"
                    data-country="<?= htmlspecialchars($res['country']) ?>"
                    data-address="<?= htmlspecialchars($res['address']) ?>"
                    data-gender="<?= htmlspecialchars($res['gender']) ?>"
                    data-hobbies="<?= htmlspecialchars($res['hobby']) ?>"
                    data-image="<?= htmlspecialchars(!empty($res['image_path']) ? $res['image_path'] : 'https://via.placeholder.com/100') ?>">
                    <i class="fas fa-eye"></i>
                  </button>
                  <a href="update.php?id=<?= htmlspecialchars($res['id']) ?>" class="btn btn-sm btn-warning">
                  <i class="fa-solid fa-pencil"></i>
                  </a>
                  <a href="#" class="btn btn-sm btn-danger" onclick="openDeleteModal(<?= $res['id'] ?>)">
                  <i class="fa-solid fa-trash-can"></i>
                      </a>
                </td>
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
                        <a href="delete.php?id=<?= htmlspecialchars($res['id']) ?>" class="btn btn-danger">Delete</a>
                      </div>
                    </div>
                  </div>
                </div>
                </td>
              </tr>
              <?php endwhile; ?>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
<div class="pagination" style="display: flex; justify-content: flex-end;">
  <!-- First Page Link -->
  <?php if ($page > 1): ?>
    <a class="page-link" href="?page=1"><i class="fa-solid fa-angles-left"></i></a>
    <a class="page-link" href="?page=<?= $page - 1 ?>"><i class="fa-solid fa-angle-left"></i></a>
  <?php endif; ?>

  <!-- Page Number Links -->
  <?php for ($i = 1; $i <= $total_pages; $i++): ?>
    <a class="page-link <?= $i == $page ? 'active' : '' ?>" href="?page=<?= $i ?>"><?= $i ?></a>
  <?php endfor; ?>

  <!-- Next Page Link -->
  <?php if ($page < $total_pages): ?>
    <a class="page-link" href="?page=<?= $page + 1 ?>"><i class="fa-solid fa-angle-right"></i></a>
    <a class="page-link" href="?page=<?= $total_pages ?>"><i class="fa-solid fa-angles-right"></i></a>
  <?php endif; ?>
</div>

    </div>
    <!-- /.container-fluid -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      function openDeleteModal(id) {
        var modal = new bootstrap.Modal(document.getElementById('deleteModal' + id));
        modal.show();
      }
    </script>

    <div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="viewUserModalLabel">User Details</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body ">
            <div class="card mb-0">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 text-center border-end">
                    <img id="viewUserImage" src="" alt="Profile" class="rounded-circle mb-3"
                      style="height:120px; width:120px; object-fit:cover; border:2px solid #ccc;">
                    <h4 id="viewUserName" class="mb-2"></h4>
                    <p id="viewUserDOB" class="mb-0 text-muted"><i class="fas fa-calendar-alt me-1"></i> <span
                        id="dobText"></span></p>
                  </div>

                  <div class="col-md-6">
                    <div class="mb-2">
                      <p id="viewUserPhone" class="mb-1"><i class="fas fa-phone me-2"></i></p>
                      <p id="viewUserEmail" class="mb-1"><i class="fas fa-envelope me-2"></i></p>
                    </div>

                    <div class="mb-2">
                      <p id="viewUserAddress" class="mb-1"><i class="fas fa-map-marker-alt me-2"></i></p>
                      <p id="viewUserCountry" class="mb-1"><i class="fas fa-globe me-2"></i></p>
                    </div>

                    <div class="mb-2" id="viewUserGender"></div>

                    <div class="d-flex flex-wrap align-items-center" id="viewUserHobbies">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <!-- Script -->
          <script>
            function populateViewModal(btn) {
              const name = btn.dataset.name;
              const email = btn.dataset.email;
              const phone = '+91 ' + btn.dataset.phone.slice(0, 5) + ' ' + btn.dataset.phone.slice(5);
              const dob = btn.dataset.dob;
              const country = btn.dataset.country.toUpperCase();
              const address = btn.dataset.address;
              const gender = btn.dataset.gender.toLowerCase();
              const hobbies = btn.dataset.hobbies.split(',');
              const image = './' + btn.dataset.image;
              
              // consloe.log(btn.dataset.image);

              document.getElementById('viewUserName').textContent = name;
              document.getElementById('viewUserEmail').innerHTML = `<i class="fas fa-envelope"></i> ${email}`;
              document.getElementById('viewUserPhone').innerHTML = `<i class="fas fa-phone"></i> ${phone}`;
              document.getElementById('viewUserDOB').innerHTML = `<i class="fas fa-calendar-alt"></i> ${dob}`;
              document.getElementById('viewUserCountry').innerHTML = `<i class="fas fa-globe"></i> ${country}`;
              document.getElementById('viewUserAddress').innerHTML = `<i class="fas fa-map-marker-alt"></i> ${address}`;
              document.getElementById('viewUserImage').src = image;

              let genderIcon = '';
              if (gender === 'male') {
                genderIcon = `<span class="text-primary"><i class="fa-solid fa-person"></i> Male</span>`;
              } else if (gender === 'female') {
                genderIcon = `<span class="text-danger"><i class="fa-solid fa-person-dress"></i> Female</span>`;
              } else {
                genderIcon = `<span class="text-warning"><i class="fa-solid fa-transgender"></i> Other</span>`;
              }
              document.getElementById('viewUserGender').innerHTML = genderIcon;

              const hobbyContainer = document.getElementById('viewUserHobbies');
              hobbyContainer.innerHTML = '';
              hobbies.forEach(hobby => {
                if (hobby.trim()) {
                  const span = document.createElement('span');
                  span.className = 'badge bg-secondary mx-1 my-1';
                  span.textContent = hobby.trim();
                  hobbyContainer.appendChild(span);
                }
              });

            }
          </script>

<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById("myImg");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
  modal.style.display = "none";
}
</script>
          <?php 
            include("../components/footer.html");?>
  </body>

</html>