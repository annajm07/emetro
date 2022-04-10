<?php
if (!defined('_VALID_ACCESS')) {
	header("location: index.php");
	die;
}

session_start();

if (!isset($_SESSION['user_session'])) {
	header("location:sistem.php?sistem=login&x=");
	die;
}

$stmt = $db_con->prepare("SELECT * FROM usertb WHERE id_us=:uid ORDER BY id_us DESC LIMIT 1");
$stmt->execute(array(":uid" => $_SESSION['user_session']));
$rowuser = $stmt->fetch(PDO::FETCH_ASSOC);

$tanggal = new tanggal;

$atas = 'sistem/header.php';
if (file_exists($atas)) {
	include_once "$atas";
} else {
	header("Location: error.php");
	die;
}

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
			<i class="fa fa-search"></i> Cari SKHP
			<small><?php echo $appnames; ?></small>
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

	<!-- Main content -->
	<section class="content">

		<!-- Default box -->
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Hasil Pencarian SKHP</h3>
			</div>
			<div class="box-body">
				<form id="cari-form" method="post" class="form-horizontal">
					<div class="form-group">
						<div class="col-md-12">
							<div class="input-group">
								<input type="text" id="cari" name="cari" class="form-control" placeholder="Cari SKHP...">
								<span class="input-group-btn">
									<button type="submit" class="btn btn-primary" name="btn-cari"><i class="fa fa-search"></i> Cari</button>
								</span>
							</div>
						</div>
					</div>
				</form>
				<?php
				if (isset($_POST['btn-cari']) && $_POST['cari'] <> '') {
					$cari = '%' . $_POST['cari'] . '%';
					$sqlcari = $db_con->prepare("SELECT * FROM sertifikattb WHERE nomor LIKE :nomor");
					$sqlcari->bindParam(':nomor', $cari);
					$sqlcari->execute();
					$countcari = $sqlcari->rowCount();
				?>
					<p>Pencarian SKHP dengan kata kunci <span class="badge"><?php echo $_POST['cari']; ?></span> ditemukan <span class="badge"><?php echo $countcari; ?></span> data :</p>
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>No.</th>
									<th>Nomor SKHP</th>
									<th>Tanggal</th>
									<th>Admin</th>
									<th>&nbsp;</th>
								</tr>
							</thead>

							<tbody>

								<?php
								if ($countcari >= 1) {

									$no = 1;
									while ($rowcari = $sqlcari->fetch(PDO::FETCH_ASSOC)) {

										$suser = $db_con->prepare("SELECT nama FROM usertb WHERE id_us=:uid ORDER BY id_us DESC LIMIT 1");
										$suser->execute(array(":uid" => $rowcari['id_us']));
										$rowmuser = $suser->fetch(PDO::FETCH_ASSOC);

										if ($rowcari['tum'] == 1) {
											$terusan = "tum";
										} else {
											$terusan = "home";
										}

								?>
										<tr>
											<td><?php print($no); ?></td>
											<td><?php print($rowcari['nomor']); ?></td>
											<td><?php if ($rowcari['tgl'] <> "0000-00-00") {
													$tanggal->contanggal(substr($rowcari['tgl'], 8, 2), substr($rowcari['tgl'], 5, 2), substr($rowcari['tgl'], 0, 4));
												} else {
													echo "-";
												} ?></td>
											<td><?php print($rowmuser['nama']); ?></td>
											<?php if (base64_decode($_SESSION['type_session']) == "kasubag") : ?>
												<td align="center">
													<a href="<?php echo $urlweb; ?>sistem.php?sistem=<?php echo $terusan; ?>&act=view&id=<?php print(base64_encode($rowcari['pengukuran'])); ?>"><i class="fa fa-search-plus"></i> view</a>
												</td>
											<?php endif; ?>

										</tr>
									<?php
										$no++;
									}
								} else {
									?>
									<tr>
										<td colspan="5" align="center" style="font-size:24px; color: #bababa;">Tidak ada data SKHP ditemukan...</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				<?php
				}
				?>
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				*Inputkan nomor SKHP dan submit untuk pencarian SKHP.
			</div>
			<!-- /.box-footer-->
		</div>
		<!-- /.box -->

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