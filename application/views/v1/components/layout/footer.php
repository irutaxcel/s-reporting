<style>
.main-footer {
    border-top: 3px solid #74c476;
    background: #ffffff;
    color: #495057;
    font-size: 14px;
}

.main-footer strong {
    color: #173b35;
}

.main-footer .float-right {
    color: #6c757d;
}
</style>
<footer class="main-footer">

    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
    </div>

    <strong>
        © <?= date('Y') ?>
        SATRACO Construction -
        Construction Management System (CMS)
    </strong>

    <span class="ml-2 text-muted">
        Tous droits réservés.
    </span>

</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?= base_url('assets/v1/plugins/') ?>jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url('assets/v1/plugins/') ?>jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('assets/v1/plugins/') ?>bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?= base_url('assets/v1/plugins/') ?>chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?= base_url('assets/v1/plugins/') ?>sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?= base_url('assets/v1/plugins/') ?>jqvmap/jquery.vmap.min.js"></script>
<script src="<?= base_url('assets/v1/plugins/') ?>jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?= base_url('assets/v1/plugins/') ?>jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?= base_url('assets/v1/plugins/') ?>moment/moment.min.js"></script>
<script src="<?= base_url('assets/v1/plugins/') ?>daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?= base_url('assets/v1/plugins/') ?>tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js">
</script>
<!-- Summernote -->
<script src="<?= base_url('assets/v1/plugins/') ?>summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?= base_url('assets/v1/plugins/') ?>overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/v1/dist/') ?>js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url('assets/v1/dist/') ?>js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?= base_url('assets/v1/dist/') ?>js/pages/dashboard.js"></script>


<?php if ($this->session->flashdata('success')): ?>

<script>
Swal.fire({

    icon: 'success',

    title: 'Succès',

    text: '<?= $this->session->flashdata('success'); ?>',

    timer: 1800,

    showConfirmButton: false

});
</script>

<?php endif; ?>
</body>

</html>