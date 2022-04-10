<?php if (!defined('_VALID_ACCESS')) {
  header("location: index.php");
  die;
} ?>

<div class="modal fade" id="logoutmodal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-exclamation-circle"></i> Konfirmasi Logout</h4>
      </div>
      <div class="modal-body">
        <p>Anda yakin ingin logout dari <?php echo $appname; ?>?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Batalkan</button>
        <a class="btn btn-primary" href="<?php echo $urlweb; ?>sistem/logout.php"><i class="fa fa-sign-out"></i> Iya Logout</a>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>Versi</b> 0.0.9
  </div>
  <strong><?php echo $appcpr; ?></strong>
</footer>

</div>
<!-- ./wrapper -->

<!-- SlimScroll -->
<script type="text/javascript" src="<?php echo $urlweb; ?>js/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script type="text/javascript" src="<?php echo $urlweb; ?>js/fastclick.js"></script>
<!-- AdminLTE App -->
<script type="text/javascript" src="<?php echo $urlweb; ?>js/adminlte.min.js"></script>
<script type="text/javascript" src="<?php echo $urlweb; ?>js/bootstrap-notify.min.js"></script>

</body>

</html>