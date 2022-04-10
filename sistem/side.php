<?php if (!defined('_VALID_ACCESS')) {
  header("location: index.php");
  die;
}

$stmt = $db_con->prepare("SELECT * FROM usertb WHERE id_us=:uid ORDER BY id_us DESC LIMIT 1");
$stmt->execute(array(":uid" => $_SESSION['user_session']));
$rowuser = $stmt->fetch(PDO::FETCH_ASSOC);

$mytahun = date('Y');
?>

<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <?php
        if ($rowuser['cfoto'] <> '') {
          echo "<img src=\"" . $urlweb . "up/user/" . $rowuser['cfoto'] . "\" class=\"img-circle\" alt=\"\">";
        } else {
          echo "<img src=\"" . $urlweb . "img/user.png\" class=\"img-circle\" alt=\"\">";
        }
        ?>
      </div>
      <div class="pull-left info">
        <p><?php echo $rowuser['nama']; ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form -->
    <form action="<?php echo $urlweb; ?>sistem.php?sistem=skhp" method="post" class="sidebar-form">
      <div class="input-group">
        <input type="text" id="cari" name="cari" class="form-control" placeholder="Cari SKHP...">
        <span class="input-group-btn">
          <button type="submit" name="btn-cari" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
          </button>
        </span>
      </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">

      <?php if (base64_decode($rowuser['type']) == "kasubag") : ?>
        <li class="header">PENGUJIAN</li>
        <li <?php if ($sistem == "home") {
              echo "class=active";
            } ?>>
          <a href="<?php echo $urlweb; ?>sistem.php?sistem=home">
            <i class="fa fa-dashboard"></i> <span>Alat Ukur</span>
          </a>
        </li>

        <li class="header">LAPORAN</li>
        <li <?php if ($sistem == "ulang") {
              echo "class=active";
            } ?>>
          <a href="<?php echo $urlweb; ?>sistem.php?sistem=ulang">
            <i class="fa fa-file"></i> <span>Data Tera Ulang Sah</span>
          </a>
        </li>

        <li class="header">PENGAJUAN SKHP</li>
        <li <?php if ($sistem == "pengajuan") {
              echo "class=active";
            } ?>>
          <a href="<?php echo $urlweb; ?>sistem.php?sistem=pengajuan">
            <i class="fa fa-envelope"></i> <span>Daftar Pengajuan Masuk</span>
          </a>
        </li>

      <?php endif; ?>

      <?php if (base64_decode($rowuser['type']) == "admin") { ?>
        <li class="header">PENGATURAN</li>

        <li <?php if ($sistem == "user") {
              echo "class=active";
            } ?>>
          <a href="<?php echo $urlweb; ?>sistem.php?sistem=user">
            <i class="fa fa-users"></i> <span>User</span>
          </a>
        </li>

        <li class="treeview <?php if ($sistem == "jenis" || $sistem == "subjenis" || $sistem == "pejabat") {
                              echo "active";
                            } ?>">
          <a href="#">
            <i class="fa fa-folder-o"></i>
            <span>Data Master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo $urlweb; ?>sistem.php?sistem=jenis"><i class="fa fa-circle-o"></i> Data Jenis</a></li>
            <li><a href="<?php echo $urlweb; ?>sistem.php?sistem=subjenis"><i class="fa fa-circle-o"></i> Data Sub Jenis</a></li>
            <li><a href="<?php echo $urlweb; ?>sistem.php?sistem=pasar"><i class="fa fa-circle-o"></i> Data Pasar</a></li>
            <li><a href="<?php echo $urlweb; ?>sistem.php?sistem=pejabat"><i class="fa fa-circle-o"></i> Data Pejabat</a></li>
          </ul>
        </li>


      <?php } ?>

      <?php if (base64_decode($rowuser['type']) == "kepala_uptd") : ?>
        <li class="header">KONFIRMASI</li>
        <li <?php if ($sistem == "kepala") {
              echo "class=active";
            } ?>>
          <a href="<?php echo $urlweb; ?>sistem.php?sistem=kepala">
            <i class="fa fa-check"></i> <span>Konfirmasi Sertifikat</span>
          </a>
        </li>

        <li class="header">LAPORAN</li>
        <li <?php if ($sistem == "pengaduanMs") {
              echo "class=active";
            } ?>>
          <a href="<?php echo $urlweb; ?>sistem.php?sistem=pengaduanMs">
            <i class="fa fa-envelope"></i> <span>Daftar Pengaduan Masuk</span>
          </a>
        </li>

      <?php endif; ?>

      <?php if (base64_decode($rowuser['type']) == "Umum") : ?>

        <li class="header">PENGAJUAN</li>

        <li <?php if ($sistem == "ajukanSKHP") {
              echo "class=active";
            } ?>>
          <a href="<?php echo $urlweb; ?>sistem.php?sistem=ajukanSKHP">
            <i class="fa fa-file"></i> <span>Ajukan SKHP</span>
          </a>
        </li>

        <!--  -->

      <?php endif; ?>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>

<!-- =============================================== -->