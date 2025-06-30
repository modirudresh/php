<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../Controllers/StudentController.php';
use Controllers\StudentController;

$controller = new StudentController();

$student = null;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $viewID = $_GET['id'];
    $student = $controller->getStudent($viewID);

    if (!$student) {
        $_SESSION['error'] = "Student not found.";
        header("Location: index.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: index.php");
    exit();
}
?>
<div class="container-fluid py-3">
  <div class="row">
  <!-- Right Column: User Info -->
    <div class="col-md-12">
      <table class="table table-striped table-bordered table-sm">
        <tbody>
          <tr>
            <th style="width: 30%;">First Name</th>
            <td><?= htmlspecialchars($student['first_name'] ?? 'N/A') ?></td>
          </tr>
          <tr>
            <th>Last Name</th>
            <td><?= htmlspecialchars($student['last_name'] ?? 'N/A') ?></td>
          </tr>
          <tr>
            <th>Email</th>
            <td><?= htmlspecialchars($student['email'] ?? 'N/A') ?></td>
          </tr>
          <tr>
            <th>Phone</th>
            <td><?= htmlspecialchars($student['phone_no'] ?? 'N/A') ?></td>
          </tr>
          <tr>
            <th>Address</th>
            <td><?= nl2br(htmlspecialchars($student['address'] ?? 'N/A')) ?></td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
</div>
