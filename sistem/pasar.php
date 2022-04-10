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

$crudpasar = new crudpasar($db_con);

$atas = 'sistem/header.php';
if (file_exists($atas)) {
	include_once "$atas";
} else {
	header("Location: error.php");
	die;
}

$mytahun = date('Y');

if (isset($_GET["act"])) {
	$act = $_GET["act"];
} else {
	$act = "";
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

<script type="text/javascript" src="<?php echo $urlweb; ?>js/bootstrap-notify.min.js"></script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<i class="fa fa-folder-o"></i> Data Pasar
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

	<?php

	if (base64_decode($rowuser['type']) == "admin") {

		if ($act == "view") {

	?>
			<!-- Main content -->
			<section class="content">

				<?php

				if (isset($_POST['btn-update'])) {
					$id = base64_decode($_GET['id']);
					$nama = $_POST['nama'];

					if (trim($_POST['nama']) == '') {
						$error[] = "<i class=\"fa fa-times-circle\"></i> Nama Pasar Masih Kosong";
					}

					if (isset($error)) {
						$error = $error;
					} else {
						$error = "";
					}

					if ($error <> '') {
						echo "<div class=\"alert alert-warning alert-dismissible\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button><h4>Update Data Pasar Gagal Dilakukan...</h4>" . implode('<br />', $error) . "<br><br>Silakan Di Ulangi Lagi.</div>";
					} else {

						if ($crudpasar->update($id, $nama)) {
				?>
							<script type="text/javascript">
								$.notify({
									title: "Sukses... ",
									message: "Update Data Pasar Berhasil Dilakukan!",
									icon: 'fa fa-check'
								}, {
									type: "success"
								});
							</script>
				<?php
						} else {
							echo "<div class=\"alert alert-warning alert-dismissible\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button><h4>Update Data Pasar Gagal Dilakukan...</h4>Terjadi kegagalan penyimpanan data ke database<br><br>Silakan Di Ulangi Lagi.</div>";
						}
					}
				}


				if (isset($_GET['id'])) {
					$id = base64_decode($_GET['id']);
					extract($crudpasar->getID($id));
				}
				?>

				<!-- Default box -->
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">View Data Pasar</h3>
					</div>
					<form id="edit-form" method="post" class="form-horizontal">

						<div class="box-body">

							<div class="form-group">
								<label class="col-lg-3 control-label" for="nama">Nama Pasar</label>
								<div class="col-lg-7">
									<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $nama; ?>" disabled="">
								</div>
							</div>

						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<button class="btn btn-primary" data-toggle="modal" data-target="#edit-modal" data-id="<?php print(base64_encode($id_ps)); ?>" id="pasarEdit"><i class="fa fa-edit"></i> Edit Data Pasar</button>&nbsp;&nbsp;
							<a class="btn btn-default" href="<?php echo $urlweb; ?>sistem.php?sistem=pasar"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
						</div>
						<!-- /.box-footer-->

					</form>

				</div>
				<!-- /.box -->

			</section>
			<!-- /.content -->

			<div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true" style="display: none;">
				<div class="modal-dialog">
					<div class="modal-content">

						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h4 class="modal-title">
								<i class="fa fa-edit"></i> Edit Data Pasar
							</h4>
						</div>
						<div class="modal-body">

							<div id="modal-loader" style="display: none; text-align: center;">
								<img src="<?php echo $urlweb; ?>img/eloading.gif">
							</div>

							<!-- content will be load here -->
							<div id="dynamic-content"></div>

						</div>
						<div class="modal-footer">

						</div>

					</div>
				</div>
			</div><!-- /.modal -->

			<script>
				$(document).ready(function() {

					$(document).on('click', '#pasarEdit', function(e) {

						e.preventDefault();

						var uid = $(this).data('id'); // it will get id of clicked row

						$('#dynamic-content').html(''); // leave it blank before ajax call
						$('#modal-loader').show(); // load ajax loader

						$.ajax({
								url: 'sistem/pasarEdit.php',
								type: 'POST',
								data: 'id=' + uid,
								dataType: 'html'
							})
							.done(function(data) {
								console.log(data);
								$('#dynamic-content').html('');
								$('#dynamic-content').html(data); // load response
								$('#modal-loader').hide(); // hide ajax loader
							})
							.fail(function() {
								$('#dynamic-content').html('<i class="fa fa-warning"></i> Kesalahan sistem.. Silakan ulangi lagi...');
								$('#modal-loader').hide();
							});

					});

				});
			</script>


		<?php } else { ?>


			<!-- Main content -->
			<section class="content">

				<?php

				if (isset($_POST['btn-save'])) {
					$nama = $_POST['nama'];

					if (trim($_POST['nama']) == '') {
						$error[] = "<i class=\"fa fa-times-circle\"></i> Nama Pasar Masih Kosong";
					}

					if (isset($error)) {
						$error = $error;
					} else {
						$error = "";
					}

					if ($error <> '') {
						echo "<div class=\"alert alert-warning alert-dismissible\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button><h4>Entri Data Pasar Gagal Dilakukan...</h4>" . implode('<br />', $error) . "<br><br>Silakan Di Ulangi Lagi.</div>";
					} else {

						if ($crudpasar->create($nama)) {
				?>
							<script type="text/javascript">
								$.notify({
									title: "Sukses... ",
									message: "Entri Data Pasar Berhasil Dilakukan!",
									icon: 'fa fa-check'
								}, {
									type: "success"
								});
							</script>
				<?php
						} else {
							echo "<div class=\"alert alert-warning alert-dismissible\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button><h4>Entri Data Pasar Gagal Dilakukan...</h4>Terjadi kegagalan penyimpanan data ke database<br><br>Silakan Di Ulangi Lagi.</div>";
						}
					}
				}
				?>

				<!-- Default box -->
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Daftar Pasar</h3>
					</div>
					<div class="box-body">
						<form id="cari-form" method="post" class="form-horizontal">
							<div class="form-group">
								<div class="col-md-6">
									<button class="btn btn-large btn-primary" data-toggle="modal" data-target="#entri-modal" data-id="<?php print(base64_encode($_SESSION['user_session'])); ?>" id="pasarEntri"><i class="fa fa-plus"></i>&nbsp; Entri Pasar</button>
								</div>
								<div class="col-md-6">
									<div class="input-group">
										<input type="text" id="cari" name="cari" class="form-control" placeholder="Cari nama pasar...">
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
							$sqlcari = $db_con->prepare("SELECT * FROM pasartb WHERE nama LIKE :nama");
							$sqlcari->bindParam(':nama', $cari);
							$sqlcari->execute();
							$countcari = $sqlcari->rowCount();
						?>
							<p>Pencarian pasar dengan kata kunci <span class="badge"><?php echo $_POST['cari']; ?></span> ditemukan <span class="badge"><?php echo $countcari; ?></span> data :</p>
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Pasar</th>
											<th>&nbsp;</th>
										</tr>
									</thead>

									<tbody>

										<?php
										$no = 1;
										while ($rowcari = $sqlcari->fetch(PDO::FETCH_ASSOC)) {
										?>
											<tr>
												<td><?php print($no); ?></td>
												<td><?php print($rowcari['nama']); ?></td>
												<td align="center">
													<a href="<?php echo $urlweb; ?>sistem.php?sistem=pasar&act=view&id=<?php print(base64_encode($rowcari['id_ps'])); ?>"><i class="fa fa-search-plus"></i> view</a>
												</td>

											</tr>
										<?php
											$no++;
										}
										?>
									</tbody>
								</table>
							</div>
							<a class="btn btn-default" href="<?php echo $urlweb; ?>sistem.php?sistem=pasar"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
						<?php
						} else {
						?>
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Pasar</th>
											<th>&nbsp;</th>
										</tr>
									</thead>

									<tbody>

										<?php
										$query = "SELECT * FROM pasartb ORDER BY id_ps ASC";
										$records_per_page = 10;
										$newquery = $crudpasar->paging($query, $records_per_page);
										$crudpasar->dataview($newquery, $records_per_page);
										?>

									</tbody>
								</table>
							</div>

							<div class="pagination-wrap">
								<?php
								$self = "sistem.php?sistem=pasar";

								$stmt = $db_con->prepare($query);
								$stmt->execute();

								$total_no_of_records = $stmt->rowCount();

								$mypagination = 'inc/app.pagination.php';
								if (file_exists($mypagination)) {
									include_once "$mypagination";
								}
								?>
							</div>

						<?php
						}
						?>
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						*Lakukan perubahan data pasar atau penambahan pasar sesuai kebutuhan saja.
					</div>
					<!-- /.box-footer-->
				</div>
				<!-- /.box -->

			</section>
			<!-- /.content -->

			<div id="entri-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true" style="display: none;">
				<div class="modal-dialog">
					<div class="modal-content">

						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h4 class="modal-title">
								<i class="fa fa-plus"></i> Entri Pasar
							</h4>
						</div>
						<div class="modal-body">

							<div id="modal-loader" style="display: none; text-align: center;">
								<img src="<?php echo $urlweb; ?>img/eloading.gif">
							</div>

							<!-- content will be load here -->
							<div id="dynamic-content"></div>

						</div>
						<div class="modal-footer">

						</div>

					</div>
				</div>
			</div><!-- /.modal -->

			<script>
				$(document).ready(function() {

					$(document).on('click', '#pasarEntri', function(e) {

						e.preventDefault();

						var uid = $(this).data('id'); // it will get id of clicked row

						$('#dynamic-content').html(''); // leave it blank before ajax call
						$('#modal-loader').show(); // load ajax loader

						$.ajax({
								url: 'sistem/pasarEntri.php',
								type: 'POST',
								data: 'id=' + uid,
								dataType: 'html'
							})
							.done(function(data) {
								console.log(data);
								$('#dynamic-content').html('');
								$('#dynamic-content').html(data); // load response
								$('#modal-loader').hide(); // hide ajax loader
							})
							.fail(function() {
								$('#dynamic-content').html('<i class="fa fa-warning"></i> Kesalahan sistem.. Silakan ulangi lagi...');
								$('#modal-loader').hide();
							});

					});

				});
			</script>

		<?php }
	} else { ?>

		<!-- Main content -->
		<section class="content">

			<div class="error-page">
				<h2 class="headline text-red"><i class="fa fa-warning text-red"></i></h2>

				<div class="error-content">
					<h3>Uups! Terjadi Kesalahan Sistem.</h3>

					<p>Akun Anda tidak memiliki akses terhadap modul ini.</p>

					<p><a class="btn btn-primary" href="javascript:window.history.back();">Kembali</a></p>

				</div>
			</div>
			<!-- /.error-page -->

		</section>
		<!-- /.content -->

	<?php } ?>

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