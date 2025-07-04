<!-- Closing tags for content and wrappers -->
</div> <!-- /.content -->
  </section>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <strong>&copy; 2014-<?= date('Y') ?> <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
</div> <!-- /.wrapper -->

<!-- Scripts: Include each only once and in proper order -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>

<!-- jQuery UI -->
<script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>

<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Moment.js -->
<script src="../plugins/moment/moment.min.js"></script>

<!-- Tempus Dominus Bootstrap 4 (datepicker) -->
<script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

<!-- Toastr -->
<script src="../plugins/toastr/toastr.min.js"></script>

<!-- bs-custom-file-input -->
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<!-- jQuery Validation -->
<script src="../plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="../plugins/jquery-validation/additional-methods.min.js"></script>

<!-- AdminLTE App -->
<script src="../dist/js/adminlte.js"></script>

<!-- Optional AdminLTE demos -->
<!-- <script src="../dist/js/demo.js"></script> -->
<!-- <script src="../dist/js/pages/dashboard.js"></script> -->

<script>
  $(function () {
    bsCustomFileInput.init();
  });
</script>

</body>
</html>
