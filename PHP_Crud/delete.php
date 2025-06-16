<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php');

$message = '';
$status = '';

if (isset($_GET['id'])) {
  $id = intval($_GET['id']);

  // Retrieve the image path associated with the user
  $stmt = $con->prepare("SELECT image_path FROM users WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $stmt->bind_result($imagePath);
  $stmt->fetch();
  $stmt->close();

  // Proceed to delete the user record
  $stmt = $con->prepare("DELETE FROM users WHERE id = ?");
  $stmt->bind_param("i", $id);

  if ($stmt->execute()) {
    // Remove the associated image file if it exists
    if (!empty($imagePath) && file_exists($imagePath)) {
      unlink($imagePath);
    }

    $message = 'The user record has been deleted successfully. All associated data has been removed from the system.';
    $status = 'success';
  } else {
    $message = 'User deletion failed. Please contact the system administrator. Error: ' . $stmt->error;
    $status = 'error';
  }

  $stmt->close();
} else {
  echo "<script>alert('Invalid request. Please try again.'); window.history.back();</script>";
  exit;
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header <?= ($status === 'success') ? 'bg-success text-white' : 'bg-danger text-white' ?>">
    <h5 class="modal-title" id="feedbackModalLabel">
      <?= ($status === 'success') ? 'Operation Successful' : 'Operation Failed' ?>
    </h5>
    </div>
    <div class="modal-body">
    <?= htmlspecialchars($message) ?>
    </div>
  </div>
  </div>
</div>

<script>
<?php if (!empty($message)): ?>
  const modal = new bootstrap.Modal(document.getElementById('feedbackModal'));
  modal.show();
  setTimeout(() => {
  modal.hide();
  <?php if ($status === 'success'): ?>
    window.location.href = 'index.php';
  <?php endif; ?>
  }, 3000);
<?php endif; ?>
</script>
