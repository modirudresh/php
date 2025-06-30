<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php');

$message = '';
$status = '';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $id = (int)$_GET['id'];

  $stmt = $con->prepare("SELECT image_path FROM users WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $stmt->bind_result($imagePath);
  $stmt->fetch();
  $stmt->close();

  $stmt = $con->prepare("DELETE FROM users WHERE id = ?");
  $stmt->bind_param("i", $id);

  if ($stmt->execute()) {
    if (!empty($imagePath) && file_exists($imagePath)) {
      unlink($imagePath);
    }
    $message = 'User has been deleted successfully along with their associated data.';
    $status = 'success';
  } else {
    $message = 'Failed to delete the user. Please contact the administrator.';
    $status = 'error';
  }

  $stmt->close();
} else {
  echo "<script>alert('Invalid request. Please try again.'); window.location.href = 'index.php';</script>";
  exit;
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow">
      <div class="modal-header <?= $status === 'success' ? 'bg-success text-white' : 'bg-danger text-white' ?>">
        <h5 class="modal-title" id="feedbackModalLabel">
          <?= $status === 'success' ? 'Success' : 'Error' ?>
        </h5>
      </div>
      <div class="modal-body">
        <?= htmlspecialchars($message) ?>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const modal = new bootstrap.Modal(document.getElementById('feedbackModal'));
  modal.show();

  setTimeout(() => {
    modal.hide();
    <?php if ($status === 'success'): ?>
      window.location.href = 'index.php';
    <?php endif; ?>
  }, 3000);
});
</script>
