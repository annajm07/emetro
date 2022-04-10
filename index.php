<?php
session_start();

if (isset($_SESSION['type_session'])) {
  if (base64_decode($_SESSION['type_session']) == "admin") {
    header("Location: sistem.php?sistem=user");
    die();
  }
  header("Location: sistem.php?sistem=home");
  die();
}

//file utama index.php
define('_VALID_ACCESS',  true);
require_once "inc/app.config.php";
require_once "inc/app.core.php";
ini_set('display_errors', '1');

$tanggal = new tanggal;

$terbilang = new terbilang;

?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="<?php echo $webdesc; ?>">
  <meta name="author" content="<?php echo $appvendor; ?>">
  <meta name="keyword" content="<?php echo $webkeyword; ?>">
  <link rel="icon" type="image/x-icon" href="<?php echo $urlweb; ?>img/favicon.ico" />
  <title><?php echo $webtitle; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo $urlweb; ?>css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $urlweb; ?>css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo $urlweb; ?>css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $urlweb; ?>css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo $urlweb; ?>css/_all-skins.min.css">
  <!-- plusplus -->
  <link rel="stylesheet" href="<?php echo $urlweb; ?>css/plusplus.css">

</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->

<body class="hold-transition skin-black layout-top-nav">
  <div class="wrapper">

    <header class="main-header">
      <nav class="navbar navbar-static-top">
        <div class="container">
          <div class="navbar-header">
            <a href="#" class="navbar-brand"><?php echo $appname; ?></a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
              <i class="fa fa-bars"></i>
            </button>
          </div>

          <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="<?php echo $urlweb; ?>sistem.php"><i class="fa fa-user"></i> Masuk</a></li>
            </ul>
          </div>

          <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="<?php echo $urlweb; ?>sistem.php?sistem=daftar"><i class="fa fa-user-plus"></i> Daftar</a></li>
            </ul>
          </div>


          <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="<?php echo $urlweb; ?>sistem.php?sistem=keluhan"><i class="fa fa-paper-plane"></i> Keluhan</a></li>
            </ul>
          </div>

          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

              <li>
                <!-- Menu Toggle Button -->
                <a href="#">
                  <span class="hidden-xs"><?php echo $appnames; ?></span>
                </a>

              </li>
            </ul>
          </div>
          <!-- /.navbar-custom-menu -->
        </div>
        <!-- /.container-fluid -->
      </nav>
    </header>
    <!-- Full Width Column -->
    <div class="content-wrapper" style="background: url(img/background.jpg) no-repeat center center fixed; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;">
      <div class="container">
        <!-- Content Header (Page header) -->
        <div class="content-header" style="padding: 60px 0px 50px 0px;">
          <center><a href="<?php echo $urlweb; ?>index.php"><img src="<?php echo $urlweb; ?>img/logo.png" class="img-responsive" alt=""></a></center>
        </div>

        <!-- Main content -->
        <section class="content">

          <form id="cari-form" method="post">

            <div class="box box-widget">
              <div class="input-group input-group-lg">
                <input type="text" id="cari" name="cari" class="form-control" placeholder="Nomor SKHP ...">
                <span class="input-group-btn">
                  <button type="submit" class="btn btn-default btn-flat" name="btn-cari"><i class="fa fa-search"></i></button>
                </span>
              </div>
            </div>
          </form>

          <?php
          if (isset($_POST['cari']) || isset($_GET['cari'])) {
            if (isset($_POST['cari'])) {
              $cari = $_POST['cari'];
            } else {
              $sqlx = $db_con->prepare("SELECT nomor FROM sertifikattb WHERE id_sr=:idsr ORDER BY id_sr DESC LIMIT 0,1");
              $sqlx->execute(array(":idsr" => $_GET['cari']));
              $rowx = $sqlx->fetch(PDO::FETCH_ASSOC);
              $cari = $rowx['nomor'];
            }
            $sql = $db_con->prepare("SELECT * FROM sertifikattb WHERE nomor=:nomor ORDER BY id_sr DESC LIMIT 0,1");
            $sql->execute(array(":nomor" => $cari));
            $countsql = $sql->rowCount();
            $row = $sql->fetch(PDO::FETCH_ASSOC);

          ?>

            <div class="box box-danger">
              <div class="box-body">
                <?php
                if ($countsql >= 1) {
                  echo "<p>Data sertifikat dengan nomor <b>" . $cari . "</b> tersedia. Berikut informasinya :</p>";
                ?>
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <tbody>

                        <?php

                        $sqld = $db_con->prepare("SELECT * FROM alattb WHERE id_al=:al ORDER BY id_al DESC LIMIT 0,1");
                        $sqld->execute(array(":al" => $row['pengukuran']));
                        $countsqld = $sqld->rowCount();
                        $rowdata = $sqld->fetch(PDO::FETCH_ASSOC);

                        if ($rowdata['tera'] == 1) {
                          $mytera = "Tera";
                        } else {
                          $mytera = "Tera Ulang";
                        }

                        $supj = $db_con->prepare("SELECT * FROM pejabattb WHERE id_pj=:pj ORDER BY id_pj DESC LIMIT 1");
                        $supj->execute(array(":pj" => $row['id_pj']));
                        $rowpj = $supj->fetch(PDO::FETCH_ASSOC);

                        $susj = $db_con->prepare("SELECT * FROM subjenistb WHERE id_sj=:sj ORDER BY id_sj DESC LIMIT 1");
                        $susj->execute(array(":sj" => $rowdata['id_sj']));
                        $rowsj = $susj->fetch(PDO::FETCH_ASSOC);

                        $lam = $db_con->prepare("SELECT COUNT(*) AS jum FROM lampirantb WHERE id_al=:al");
                        $lam->execute(array(":al" => $rowdata['id_al']));
                        $rowlam = $lam->fetch(PDO::FETCH_ASSOC);

                        if ($rowlam['jum'] == 1) {
                          $sulam = $db_con->prepare("SELECT * FROM lampirantb WHERE id_al=:al ORDER BY id_lp DESC LIMIT 1");
                          $sulam->execute(array(":al" => $row['pengukuran']));
                          $rowsulam = $sulam->fetch(PDO::FETCH_ASSOC);
                          if ($rowdata['notaksi'] <> '') {
                            $dmerek = $rowsulam['merek'] . " / " . $rowsulam['tipe'];
                            $dseri = $rowsulam['seri'];
                          } else {
                            $dmerek = $rowsulam['merek'] . " / " . $rowsulam['buatan'];
                            $dseri = $rowsulam['seri'] . " / " . $rowsulam['kapasitas'];
                            $dmodel = $rowsulam['tipe'];
                          }
                        } else {
                          $dmerek = "Terlampir";
                          $dseri = "Terlampir";
                          $dmodel = "Terlampir";
                        }

                        ?>

                        <table width="100%" border="0" style="font-family:arial; line-height:1.0; font-size:11pt;">
                          <tr>
                            <td width="30%" align="left" valign="top"><b><u>NAMA ALAT</u></b><br><i><small>Measuring instrument</small></i><br><br></td>
                            <td width="5%" align="center" valign="top">:</td>
                            <td width="65%" align="left" valign="top"><b><?php echo $rowsj['nama']; ?>, <?php echo $rowlam['jum']; ?> (<?php echo $terbilang->terbilang($rowlam['jum']); ?>) unit</b></td>
                          </tr>
                          <?php if ($rowdata['notaksi'] <> '') { ?>
                            <tr>
                              <td width="30%" align="left" valign="top" style="padding-left:30px;"><u>Merek / Tipe</u><br><i><small>Trade Mark / Type</small></i><br><br></td>
                              <td width="5%" align="center" valign="top">:</td>
                              <td width="65%" align="left" valign="top"><?php echo $dmerek; ?></td>
                            </tr>
                            <tr>
                              <td width="30%" align="left" valign="top" style="padding-left:30px;"><u>Nomor Seri</u><br><i><small>Serial Number</small></i><br><br></td>
                              <td width="5%" align="center" valign="top">:</td>
                              <td width="65%" align="left" valign="top"><?php echo $dseri; ?></td>
                            </tr>
                          <?php } else { ?>
                            <tr>
                              <td width="30%" align="left" valign="top" style="padding-left:30px;"><u>Merek / Buatan</u><br><i><small>Trade Mark / Manufactured by</small></i><br><br></td>
                              <td width="5%" align="center" valign="top">:</td>
                              <td width="65%" align="left" valign="top"><?php echo $dmerek; ?></td>
                            </tr>
                            <tr>
                              <td width="30%" align="left" valign="top" style="padding-left:30px;"><u>Nomor Seri / Kapasitas</u><br><i><small>Serial Number / Capacity</small></i><br><br></td>
                              <td width="5%" align="center" valign="top">:</td>
                              <td width="65%" align="left" valign="top"><?php echo $dseri; ?></td>
                            </tr>
                            <tr>
                              <td width="30%" align="left" valign="top" style="padding-left:30px;"><u>Model / Tipe</u><br><i><small>Model / Type</small></i><br><br></td>
                              <td width="5%" align="center" valign="top">:</td>
                              <td width="65%" align="left" valign="top"><?php echo $dmodel; ?></td>
                            </tr>
                          <?php } ?>
                          <?php if ($rowdata['notaksi'] <> '') { ?>
                            <tr>
                              <td width="30%" align="left" valign="top"><b><u>MEREK KENDARAAN</u></b><br><i><small>Trade Mark</small></i><br><br></td>
                              <td width="5%" align="center" valign="top">:</td>
                              <td width="65%" align="left" valign="top"><?php echo $rowdata['merek']; ?></td>
                            </tr>
                            <tr>
                              <td width="30%" align="left" valign="top"><b><u>NO. POL / NO. TAKSI</u></b><br><i><small>Police Number / Taxi Number</small></i><br><br></td>
                              <td width="5%" align="center" valign="top">:</td>
                              <td width="65%" align="left" valign="top"><b><?php echo strtoupper($rowdata['nopol']); ?> / <?php echo $rowdata['notaksi']; ?></b></td>
                            </tr>
                            <tr>
                              <td width="30%" align="left" valign="top"><b><u>PEMILIK / ALAMAT</u></b><br><i><small>User / Address</small></i><br><br></td>
                              <td width="5%" align="center" valign="top">:</td>
                              <td width="65%" align="left" valign="top"><b><?php echo strtoupper($rowdata['pemilik']); ?></b><br><?php echo $rowdata['alamatx']; ?></td>
                            </tr>
                          <?php } else { ?>
                            <tr>
                              <td width="30%" align="left" valign="top"><b><u>PEMAKAI / ALAMAT</u></b><br><i><small>User / Address</small></i><br><br></td>
                              <td width="5%" align="center" valign="top">:</td>
                              <td width="65%" align="left" valign="top"><b><?php echo strtoupper($rowdata['pemakai']); ?></b><br><?php echo $rowdata['alamat']; ?></td>
                            </tr>
                            <?php if ($rowdata['spbu'] <> '') { ?>
                              <tr>
                                <td width="30%" align="left" valign="top"><b><u>NOMOR SPBU</u></b><br><br></td>
                                <td width="5%" align="center" valign="top">:</td>
                                <td width="65%" align="left" valign="top"><b><?php echo $rowdata['spbu']; ?></b></td>
                              </tr>
                            <?php } else {
                              echo "";
                            } ?>
                            <tr>
                              <td width="30%" align="left" valign="top"><b><u style="line-height:1.3;">STANDAR DAN KETERTELUSURAN</u></b><br><i><small>Standard and Traceability</small></i><br><br></td>
                              <td width="5%" align="center" valign="top">:</td>
                              <td width="65%" align="left" valign="top"><?php echo $rowdata['standar']; ?></td>
                            </tr>
                          <?php } ?>
                          <tr>
                            <td width="30%" align="left" valign="top"><b><u>TANGGAL PENGUJIAN</u></b><br><i><small>Date of Calibration</small></i><br><br></td>
                            <td width="5%" align="center" valign="top">:</td>
                            <td width="65%" align="left" valign="top"><b><?php if ($rowdata['tgl'] <> "0000-00-00") {
                                                                            $tanggal->contanggalx(substr($rowdata['tgl'], 8, 2), substr($rowdata['tgl'], 5, 2), substr($rowdata['tgl'], 0, 4));
                                                                          } else {
                                                                            echo "";
                                                                          } ?></b></td>
                          </tr>
                          <tr>
                            <td width="30%" align="left" valign="top"><b><u>DIUJI OLEH</u></b><br><i><small>Calibrated by</small></i><br><br></td>
                            <td width="5%" align="center" valign="top">:</td>
                            <td width="65%" align="left" valign="top"><b><?php echo $rowdata['penguji']; ?></b></td>
                          </tr>
                          <tr>
                            <td width="30%" align="left" valign="top"><b><u>METODE</u></b><br><i><small>Method</small></i><br><br></td>
                            <td width="5%" align="center" valign="top">:</td>
                            <td width="65%" align="left" valign="top"><?php echo $rowdata['metode']; ?></td>
                          </tr>
                          <tr>
                            <td width="30%" align="left" valign="top"><b><u>HASIL PENGUJIAN</u></b><br><i><small>Result</small></i><br><br></td>
                            <td width="5%" align="center" valign="top">:</td>
                            <td width="65%" align="left" valign="top"><b>Disahkan "<?php echo strtoupper($mytera); ?>" Tahun <?php echo $rowdata['tahun']; ?></b></td>
                          </tr>
                          <tr>
                            <td width="30%" align="left" valign="top"><b><u>BERLAKU s/d</u></b><br><i><small>Due to</small></i><br><br></td>
                            <td width="5%" align="center" valign="top">:</td>
                            <td width="65%" align="left" valign="top"><b><?php if ($rowdata['berlaku'] <> "0000-00-00") {
                                                                            $tanggal->contanggalx(substr($rowdata['berlaku'], 8, 2), substr($rowdata['berlaku'], 5, 2), substr($rowdata['berlaku'], 0, 4));
                                                                          } else {
                                                                            echo "";
                                                                          } ?></b>, kecuali <b>Tanda tera rusak</b> / <b>segel putus</b> atau penyerahannya menyimpang dari batas toleransi yang diizinkan</td>
                          </tr>
                        </table>

                        <br>

                        <table width="100%" border="0" style="font-family:arial; line-height:1; font-size:11pt;">
                          <tr>
                            <td width="40%" align="center">
                            </td>
                            <td width="60%" align="center">
                              <p><b>DISAHKAN BERDASARKAN UU RI NO 2 TAHUN 1981<br>TENTANG METROLOGI LEGAL DENGAN MEMBUBUHKAN<br>TANDA TERA SAH DAN JAMINAN</b></p>
                              <p>Padang, <?php if ($row['tgl'] <> "0000-00-00") {
                                            $tanggal->contanggalx(substr($row['tgl'], 8, 2), substr($row['tgl'], 5, 2), substr($row['tgl'], 0, 4));
                                          } else {
                                            echo "";
                                          } ?><br>
                                <?php if ($rowpj['id_pj'] == 2) {
                                  echo "a/n Kepala UPTD Metrologi Legal<br>" . $rowpj['jabatan'];
                                } else {
                                  echo $rowpj['jabatan'];
                                } ?></p>
                              <p>&nbsp;</p>
                              <p><b><u><?php echo $rowpj['nama']; ?></u><br>NIP. <?php echo $rowpj['nip']; ?></b></p>
                            </td>
                          </tr>
                        </table>
                        <br><br>

                        <?php
                        $sqlspe = $db_con->prepare("SELECT * FROM lampirantb WHERE id_al = :al");
                        $sqlspe->bindParam(':al', $row['pengukuran']);
                        $sqlspe->execute();
                        $countspe = $sqlspe->rowCount();
                        if ($countspe >= 2) {
                        ?>
                          <p style="font-weight:bold;">LAMPIRAN</p>
                          <table class="table table-bordered table-striped" style="font-family: Arial, Tahoma;">
                            <tr style="font-weight:bold;">
                              <td scope="col" align="center">NO.</td>
                              <td scope="col" align="center">MEREK</td>
                              <td scope="col" align="center">NO. SERI</td>
                              <td scope="col" align="center">TIPE</td>
                              <?php if ($rowdata['notaksi'] <> '') {
                                echo "";
                              } else { ?>
                                <?php if ($rowdata['spbu'] <> '') { ?>
                                  <td scope="col" align="center">JENIS BBM</td>
                                <?php } else { ?>
                                  <td scope="col" align="center">KAPASITAS</td>
                                <?php } ?>
                              <?php } ?>
                            </tr>
                            <?php
                            $no = 1;
                            while ($rowspe = $sqlspe->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                              <tr>
                                <td align="center"><?php print($no); ?></td>
                                <td align="center"><?php print($rowspe['merek']); ?></td>
                                <td align="center"><?php print($rowspe['seri']); ?></td>
                                <td align="center"><?php print($rowspe['tipe']); ?></td>
                                <?php if ($rowdata['notaksi'] <> '') {
                                  echo "";
                                } else { ?>
                                  <?php if ($rowdata['spbu'] <> '') { ?>
                                    <td align="center"><?php print($rowspe['jenis']); ?></td>
                                  <?php } else { ?>
                                    <td align="center"><?php print($rowspe['kapasitas']); ?></td>
                                  <?php } ?>
                                <?php } ?>

                              </tr>
                            <?php
                              $no++;
                            }
                            ?>

                          </table>

                        <?php
                        }

                        ?>

                      </tbody>
                    </table>
                  </div>
                <?php
                } else {
                ?>

                  <div class="error-page">
                    <h2 class="headline text-red"><i class="fa fa-qrcode text-red"></i></h2>

                    <div class="error-content">
                      <h3>Maaf !!! Sertifikat Tidak Valid.</h3>

                      <p>QR Code atau Nomor Sertifikat yang Anda gunakan tidak ter-registrasi.</p>

                      <p><small>Silakan coba lagi dengan menggunakan QR Code atau Nomor Sertifikat yang lainnya.</small></p>

                      <br>

                    </div>
                  </div>
                  <!-- /.error-page -->

                <?php
                }
                ?>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->

          <?php
          }
          ?>

        </section>
        <!-- /.content -->
      </div>
      <!-- /.container -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <div class="container">
        <div class="pull-right hidden-xs">
          <b>Versi</b> 0.0.9
        </div>
        <strong><?php echo $appcpr; ?></strong>
      </div>
      <!-- /.container -->
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- jQuery 3 -->
  <script src="<?php echo $urlweb; ?>js/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="<?php echo $urlweb; ?>js/bootstrap.min.js"></script>
  <!-- SlimScroll -->
  <script src="<?php echo $urlweb; ?>js/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="<?php echo $urlweb; ?>js/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo $urlweb; ?>js/adminlte.min.js"></script>

  <script src="<?php echo $urlweb; ?>js/bootstrap-notify.min.js"></script>

  <?php if (isset($_SESSION['notif'])) : ?>
    <script type="text/javascript">
      $.notify({
        title: "Terima Kasih. ",
        message: "Data Pengajuan anda telah dikirim",
        icon: 'fa fa-check'
      }, {
        type: "success"
      });
    </script>

  <?php unset($_SESSION['notif']);
  endif; ?>

  <?php if (isset($_SESSION['daftar'])) : ?>
    <script type="text/javascript">
      $.notify({
        title: "Berhasil Mendaftar ",
        message: "Silahkan Hubungi Admin Untuk Aktivasi Akun",
        icon: 'fa fa-check'
      }, {
        type: "success"
      });
    </script>

  <?php unset($_SESSION['daftar']);
  endif; ?>

</body>

</html>