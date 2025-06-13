<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../config.php');

$message = '';
$status = ''; 

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $con->prepare("SELECT image_path FROM user WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($imagePath);
    $stmt->fetch();
    $stmt->close();

    $stmt = $con->prepare("DELETE FROM user WHERE id = ?");
    $stmt->bind_param("i", $id);
  
    if ($stmt->execute()) {
        if ($imagePath && file_exists($imagePath)) {
            unlink($imagePath);
        }

        $message = 'User Deleted successfully.';
        $status = 'success';
        } else {
            $message = 'User not Deleted: ' . $stmt->error;
            $status = 'error';    }

    $stmt->close();
} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header <?= ($status === 'success') ? 'bg-success text-white' : 'bg-danger text-white' ?>">
        <h5 class="modal-title" id="feedbackModalLabel"><?= ucfirst($status) ?></h5>
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
