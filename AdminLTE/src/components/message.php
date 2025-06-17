<?php
session_start();
$message = $_SESSION['message'] ?? '';
$status = $_SESSION['status'] ?? '';
// Clear message after reading
unset($_SESSION['message'], $_SESSION['status']);
?>

<!-- Include Toastr CSS -->
<link rel="stylesheet" href="./plugins/toastr/toastr.min.css">

<!-- Include jQuery and Toastr JS -->
<script src="./plugins/jquery/jquery.min.js"></script>
<script src="./plugins/toastr/toastr.min.js"></script>

<?php if (!empty($message)): ?>
<script>
  $(function () {
    toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": true,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "preventDuplicates": true,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "2000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    };

    toastr["<?= $status === 'success' ? 'success' : 'error' ?>"]("<?= addslashes($message) ?>", "<?= ucfirst($status) ?>");
  });
</script>
<?php endif; ?>
