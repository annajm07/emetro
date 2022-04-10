<?php
if(!defined('_VALID_ACCESS')) { header ("location: index.php"); die; }

session_start();

if(!isset($_SESSION['user_session']))
{
	header("location:sistem.php?sistem=login&x=");
	die;
}

$stmt = $db_con->prepare("SELECT * FROM usertb WHERE id_us=:uid ORDER BY id_us DESC LIMIT 1");
$stmt->execute(array(":uid"=>$_SESSION['user_session']));
$rowuser=$stmt->fetch(PDO::FETCH_ASSOC);

$tanggal = new tanggal;

$atas = 'sistem/header.php';
  if (file_exists($atas)) {
      include_once "$atas";
    } else {
      header("Location: error.php");
      die;
  }

$mytahun = date('Y');

?>

<?php
	$side = 'sistem/side.php';
	  if (file_exists($side)) {
      include_once "$side";
    } else {
      header("Location: error.php");
      die;
	  }
?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

		<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-warning"></i> Error
				<small><?php echo $appnames;?></small>
      </h1>
			<?php
				$bmenu = 'sistem/bmenu.php';
				if (file_exists($bmenu)) {
					include_once "$bmenu";
				} else {
					echo "";
				}
				?>

    </section>

		<br><br>

    <!-- Main content -->
    <section class="content">

      <div class="error-page">
        <h2 class="headline text-red"><i class="fa fa-warning text-red"></i></h2>

        <div class="error-content">
          <h3>Uups! Terjadi Kesalahan Sistem.</h3>

          <p>
            Modul <b><?php echo strtoupper($sistem); ?></b> <?php echo $appname;?> tidak dapat diakses. Mungkin modul tersebut sedang bermasalah atau telah dihapus.
          </p>

          <p><a class="btn btn-primary" href="javascript:window.history.back();">Kembali</a></p>

        </div>
      </div>
      <!-- /.error-page -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
  $bawah = 'sistem/footer.php';
  if (file_exists($bawah)) {
     include_once "$bawah";
  } else {
	    header("Location: error.php");
	    die;
  }
?>
