<?php

include_once("editaction.php");
include_once("../header.php");
include_once("../sidebar.php");

$allHobbies = ["Reading","Singing","Yoga","Dancing","Swimming","Writing","Drawing","Painting","Blogging","Travelling","Cricket","Photography","Cooking","Coding","Gaming","Cycling","Skiing"]; 
$selectedHobbies = array_map('trim', explode(',', $user['hobby']));
$selectedHobbiesMap = array_map('strtolower', $selectedHobbies);

?>

<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6"><h1 class="m-0">Edit User</h1></div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Edit User</li>
            </ol>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-warning">
            <div class="card-header"><h3 class="card-title">Edit User</h3></div>
            <form id="userForm" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                <input type="hidden" name="existing_image" value="<?= $user['image_path'] ?>">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($user['email']) ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Phone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="phone_no" 
                            value="<?= !empty($user['phone_no']) ? htmlspecialchars($user['phone_no']) : '' ?>"                  
                            maxlength="10">
                        </div>
                    </div>
                    <div class="row">
                        <!-- Current Image -->
                        <div class="form-group col-md-2">
                            <label class="form-text text-muted d-block"><b>Current Image:</b></label>
                            <img 
                            src="<?= !empty($user['image_path']) && file_exists(__DIR__ . '/../../' . $user['image_path']) 
                                    ? '../../' . htmlspecialchars($user['image_path']) 
                                    : '../../uploads/default.png' ?>" 
                            alt="Profile" 
                            class="img-thumbnail mt-1 shadow" 
                            style="height: 80px; width: auto;">
                        </div>

                        <!-- Upload New Image -->
                        <div class="form-group col-md-4">
                            <label>Profile Image <span class="text-danger">*</span></label>
                            <div class="custom-file">
                            <input type="file" class="custom-file-input" name="image_path" id="imageInput" accept="image/*">
                            <label class="custom-file-label" for="imageInput">Choose file</label>
                            </div>
                        </div>

                        <!-- Preview + File Name -->
                        <div class="form-group col-md-2">
                        <label class="text-muted d-block">Preview :</label>
                        <div class="d-flex flex-column align-items-center">
                                <img id="imagePreview" 
                                    src="../../uploads/preview.png" 
                                    alt="Preview" 
                                    class="img-thumbnail shadow mb-1" 
                                    style="max-width: 100px; max-height: 80px;">
                                <span id="imageName" class="text-muted small" style="display: none;"></span>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="DOB">Date of Birth <span class="text-danger">*</span></label>
                            <div class="input-group date" id="dobPicker" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#dobPicker" value="<?= htmlspecialchars($user['DOB']) ?>" name="DOB" placeholder="YYYY-MM-DD" autocomplete="off" />
                                <div class="input-group-append" data-target="#dobPicker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>                       
                    <div class="row">
                    <div class="form-group col-md-6">
                        <label>Gender <span class="text-danger">*</span></label>
                        <div class="form-control bg-light" style="height:max-content;">
                            <?php foreach (['Male', 'Female', 'Other'] as $g): ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-control" type="radio" name="gender" value="<?= $g ?>" <?= $user['gender'] === $g ? 'checked' : '' ?>>
                                    <label class="form-check-label">&nbsp;<?= strtoupper($g) ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                        <div class="form-group col-md-6">
                            <label>Hobbies <span class="text-danger">*</span></label>
                            <div class="form-control bg-light" style="height:max-content;">
                                <?php foreach ($allHobbies as $h): ?>
                                    <div class="form-check form-check-inline">
                                    <input type="checkbox" name="hobby[]" value="<?= $h ?>" <?= in_array(strtolower($h), array_map('strtolower', $selectedHobbies)) ? 'checked' : '' ?>>
                                    <label class="form-check-label">&nbsp; <?= $h ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Address <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="address"><?= !empty($user['address']) ? htmlspecialchars($user['address']) : '' ?></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Country <span class="text-danger">*</span></label>
                            <select class="form-control" name="country">
                                <option value="">Select</option>
                                <option value="india" <?= $user['country'] === 'india' ? 'selected' : '' ?>>India</option>
                                <option value="UK" <?= $user['country'] === 'UK' ? 'selected' : '' ?>>UK</option>
                                <option value="usa" <?= $user['country'] === 'usa' ? 'selected' : '' ?>>USA</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-warning float-right">Update User</button>
                </div>
            </form>
        </div>
    </div>
</section>
</div>
</div>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>

<script>
  $(function () {
    $('#userForm').validate({
      rules: {
        first_name: { required: true },
        last_name: { required: true },
        email: { required: true, email: true },
        phone_no: { required: true, digits: true, minlength: 10, maxlength: 10 },
        address: { required: true },
        DOB: { required: true, dateISO: true },
        gender: { required: true },
        'hobby[]': { required: true },
        country: { required: true }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        if (element.attr("type") === "radio" || element.attr("type") === "checkbox") {
          element.closest('.form-control').append(error);
        } else {
          element.closest('.form-group').append(error);
        }
      },
      highlight: function (element) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element) {
        $(element).removeClass('is-invalid');
      }
    });

    $('#userForm').submit(function (e) {
      e.preventDefault();

      if (!$(this).valid()) return;

      var form = this;
      var formData = new FormData(form);
      var submitBtn = $(form).find('button[type="submit"]');

      submitBtn.prop('disabled', true).text('Updating...');

      $.ajax({
        url: 'edit.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        success: function (res) {
          if (res.status === 'success') {
            toastr.success(res.message);
            setTimeout(() => window.location.href = 'index.php', 1500);
          } else {
            toastr.error(res.message);
          }
        },
        error: function () {
          toastr.error('Something went wrong.');
        },
        complete: function () {
          submitBtn.prop('disabled', false).text('Update User');
        }
      });
    });
  });
</script>

<script>
  $(document).ready(function () {
    // Initialize custom file input (AdminLTE support)
    if (typeof bsCustomFileInput !== 'undefined') {
      bsCustomFileInput.init();
    }

    $('#imageInput').on('change', function () {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
          $('#imagePreview')
            .attr('src', e.target.result)
            .show();

          $('#imageName')
            .text(file.name)
            .show();
        };

        reader.readAsDataURL(file);

        // Update custom label manually (for extra safety)
        $(this).next('.custom-file-label').text(file.name);
      }
    });
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>


<?php include_once("../footer.php"); ?>