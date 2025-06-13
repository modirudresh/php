<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("config.php");

$result = mysqli_query($con, "SELECT * FROM user");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Management</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
 <link rel="stylesheet" href="index.css">
 <link rel="shortcut icon" href="Logo.png" type="image/icon">
</head>
<body>
  <div style="display: flex; justify-content: flex-end; margin-bottom: 15px;">
    <a href="insert.php" style="background-color: green; color: white; padding: 8px 12px; border-radius: 4px; text-decoration: none;">
      Add New User
    </a>
  </div>
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Full Name
			<p style="font-size:10px; font:normal;">(First + Last) Name</p>
		</th>
        <th>Email</th>
        <th>Profile Image</th>
        <th>Address</th>
		<th>Country</th>
        <th>Date of Birth</th>
        <th>Phone No.</th>
        <th>Gender</th>
        <th>Hobby</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($res = mysqli_fetch_assoc($result)): ?>
        <tr>
          <td><?= htmlspecialchars($res['id']) ?></td>
          <td style="max-width:100px;"><?= htmlspecialchars($res['first_name'])." ".htmlspecialchars($res['last_name']) ?></td>
          <td style="width:100px;"><?= htmlspecialchars($res['email']) ?></td>
          <td>
            <?php if (!empty($res['image_path'])): ?>
              <img src="<?= htmlspecialchars($res['image_path']) ?>" alt="Profile" />
            <?php else: ?>
              <span>No Image</span>
            <?php endif; ?>
          </td>
          <td style="max-width:140px;"><?= nl2br(htmlspecialchars($res['address'])) ?></td>
<td style="width:80px;"><?= htmlspecialchars(strtoupper($res['country'])) ?></td>

          <td style="width:180px;"><?= htmlspecialchars($res['DOB']) ?></td>
		  <td style="width:180px;">
  <?php
    $rawPhone = htmlspecialchars($res['phone_no']);
    $formattedPhone = '+91 ' . substr($rawPhone, 0, 5) . ' ' . substr($rawPhone, 5);
    echo "<a href='tel:+91$rawPhone' style='text-decoration: none; color: #000;'>$formattedPhone</a>";
  ?>
</td>
          <td style="width:100px;">
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
          <td style="width:100px;">
            <?php
              $hobbies = explode(',', $res['hobby']);
              foreach ($hobbies as $hobby) {
                echo "<span style='display:inline-block; background-color:#e0e0e0; color:#333; padding:3px 6px; margin:1px; border-radius:5px; border:1px solid black; font-size:10px;'>"
                     . htmlspecialchars(trim($hobby)) . "</span>";
              }
            ?>
          </td>
		  <td style="width:160px;">
  <button
    class="btn btn-sm btn-info text-white"
    data-bs-toggle="modal"
    data-bs-target="#viewUserModal"
    onclick="populateViewModal(this)"
    data-name="<?= htmlspecialchars($res['first_name'] . ' ' . $res['last_name']) ?>"
    data-email="<?= htmlspecialchars($res['email']) ?>"
    data-phone="<?= htmlspecialchars($res['phone_no']) ?>"
    data-dob="<?= htmlspecialchars($res['DOB']) ?>"
    data-country="<?= htmlspecialchars($res['country']) ?>"
    data-address="<?= htmlspecialchars($res['address']) ?>"
    data-gender="<?= htmlspecialchars($res['gender']) ?>"
    data-hobbies="<?= htmlspecialchars($res['hobby']) ?>"
    data-image="<?= htmlspecialchars(!empty($res['image_path']) ? $res['image_path'] : 'https://via.placeholder.com/100') ?>"
  >
    <i class="fas fa-eye"></i>
  </button>
  <a href="update.php?id=<?= htmlspecialchars($res['id']) ?>" class="btn btn-sm btn-warning">
    <i class="fas fa-edit"></i>
            </a>
  <a href="#" class="btn btn-sm btn-danger" onclick="openDeleteModal(<?= $res['id'] ?>)">
    <i class="fas fa-trash-alt"></i>
  </a>
</td>
<div class="modal fade" id="deleteModal<?= $res['id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $res['id'] ?>" aria-hidden="true">
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
    </tbody>
  </table>
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
          <img id="viewUserImage" src="" alt="Profile" class="rounded-circle mb-3" style="height:120px; width:120px; object-fit:cover; border:2px solid #ccc;">
          <h4 id="viewUserName" class="mb-2"></h4>
          <p id="viewUserDOB" class="mb-0 text-muted"><i class="fas fa-calendar-alt me-1"></i> <span id="dobText"></span></p>
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
    const image = btn.dataset.image;

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

</body>
</html>
