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

$cruduser = new cruduser($db_con);

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
			<i class="fa fa-users"></i> User
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
					$imel = $_POST['imel'];
					$simel = strtolower($imel);
					$pass = $_POST['pass'];
					$nama = $_POST['nama'];
					$jabatan = $_POST['jabatan'];
					$telp = $_POST['telp'];
					$type = base64_encode($_POST['role']);

					$key = "syalim.com";
					$pword = md5($pass . $key . md5($pass));

					if (trim($_POST['imel']) == '') {
						$error[] = "<i class=\"fa fa-times-circle\"></i> Alamat Email Masih Kosong";
					}

					if (!filter_var($simel, FILTER_VALIDATE_EMAIL)) {
						$error[] = "<i class=\"fa fa-times-circle\"></i> Penulisan Alamat Email belum benar";
					}

					if (trim($_POST['nama']) == '') {
						$error[] = "<i class=\"fa fa-times-circle\"></i> Nama Lengkap Masih Kosong";
					}

					if (trim($_POST['jabatan']) == '') {
						$error[] = "<i class=\"fa fa-times-circle\"></i> Jabatan Masih Kosong";
					}

					if (trim($_POST['telp']) == '') {
						$error[] = "<i class=\"fa fa-times-circle\"></i> Nomor Telpon Masih Kosong";
					}

					if (!preg_match("/^[0-9]*$/", $telp)) {
						$error[] = "<i class=\"fa fa-times-circle\"></i> Penulisan Nomor Telpon Hanya Angka Saja";
					}

					if (trim($_POST['pass']) == '') {
						$error[] = "<i class=\"fa fa-times-circle\"></i> Password User Belum Diisi";
					}

					if (trim($_POST['role']) == '') {
						$error[] = "<i class=\"fa fa-times-circle\"></i> Hak Akses Belum Dipilih";
					}

					if (isset($error)) {
						$error = $error;
					} else {
						$error = "";
					}

					if ($error <> '') {
						echo "<div class=\"alert alert-warning alert-dismissible\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button><h4>Update Data User Gagal Dilakukan...</h4>" . implode('<br />', $error) . "<br><br>Silakan Di Ulangi Lagi.</div>";
					} else {

						if ($cruduser->update($id, $simel, $pword, $nama, $jabatan, $telp, $type)) {
				?>
							<script type="text/javascript">
								$.notify({
									title: "Sukses... ",
									message: "Update Data User Berhasil Dilakukan!",
									icon: 'fa fa-check'
								}, {
									type: "success"
								});
							</script>
				<?php
						} else {
							echo "<div class=\"alert alert-warning alert-dismissible\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button><h4>Update Data User Gagal Dilakukan...</h4>Terjadi kegagalan penyimpanan data ke database<br><br>Silakan Di Ulangi Lagi.</div>";
						}
					}
				}


				if (isset($_GET['id'])) {
					$id = base64_decode($_GET['id']);
					extract($cruduser->getID($id));
				}
				?>

				<!-- Default box -->
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">View Data User</h3>
					</div>
					<form id="edit-form" method="post" class="form-horizontal">

						<div class="box-body">

							<div class="form-group">
								<label class="col-lg-2 control-label" for="imel">Alamat Email</label>
								<div class="col-lg-6">
									<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $imel; ?>" disabled="">
									<span id="check-e"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label" for="nama">Nama Lengkap</label>
								<div class="col-lg-6">
									<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $nama; ?>" disabled="">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label" for="jabatan">Jabatan</label>
								<div class="col-lg-6">
									<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $jabatan; ?>" disabled="">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label" for="telp">Nomor Telpon</label>
								<div class="col-lg-6">
									<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $telp; ?>" disabled="">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label" for="pass">Hak Akses</label>
								<div class="col-lg-6">
									<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo strtoupper(base64_decode($type)); ?>" disabled="">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Terdaftar</label>
								<div class="col-lg-6">
									<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $tanggal->time_since(strtotime($logdate)); ?>" disabled="">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Status Akun</label>
								<div class="col-lg-6">
									<?php if ($status == 1) {
										echo "<input type=\"text\" id=\"disabled-input\" name=\"disabled-input\" class=\"form-control\" value=\"User Aktif\" disabled=\"\">";
									} else {
										echo "<input type=\"text\" id=\"disabled-input\" name=\"disabled-input\" class=\"form-control\" value=\"User Non Aktif\" disabled=\"\">";
									} ?>
								</div>
							</div>

							<br>

							<div class="form-group">
								<label class="col-lg-2 control-label">Foto Akun</label>
								<div class="col-lg-6">
									<?php
									if ($cfoto <> '') {
										echo "<div id=\"preview\"><img src=\"" . $urlweb . "up/user/" . $cfoto . "\" alt=\"\"></div>";
									} else {
										echo "<div id=\"preview\"><img src=\"" . $urlweb . "img/no-image.jpg\" alt=\"\"></div>";
									}
									?>
								</div>
							</div>

						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<button class="btn btn-primary" data-toggle="modal" data-target="#edit-modal" data-id="<?php print(base64_encode($id_us)); ?>" id="userEdit"><i class="fa fa-edit"></i> Edit Akun User <?php echo $nama; ?></button>&nbsp;&nbsp;
							<?php if ($status == 1) { ?>
								<div class="btn-group">
									<button type="button" class="btn btn-success"><i class="fa fa-check-square-o"></i> Status Aktif</button>
									<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
										<span class="caret"></span>
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li><a href="<?php echo $urlweb; ?>sistem.php?sistem=aksi&mod=user&act=nonaktif&id=<?php echo base64_encode($id_us); ?>">Non Aktifkan User <b><?php echo $nama; ?></b></a></li>
									</ul>
								</div>&nbsp;&nbsp;
							<?php } else { ?>
								<div class="btn-group">
									<button type="button" class="btn btn-danger"><i class="fa fa-close"></i> Status Non Aktif</button>
									<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
										<span class="caret"></span>
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li><a href="<?php echo $urlweb; ?>sistem.php?sistem=aksi&mod=user&act=aktif&id=<?php echo base64_encode($id_us); ?>">Aktifkan User <b><?php echo $nama; ?></b></a></li>
									</ul>
								</div>&nbsp;&nbsp;
							<?php } ?>
							<a class="btn btn-default" href="<?php echo $urlweb; ?>sistem.php?sistem=user"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
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
								<i class="fa fa-edit"></i> Edit Data User
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

					$(document).on('click', '#userEdit', function(e) {

						e.preventDefault();

						var uid = $(this).data('id'); // it will get id of clicked row

						$('#dynamic-content').html(''); // leave it blank before ajax call
						$('#modal-loader').show(); // load ajax loader

						$.ajax({
								url: 'sistem/userEdit.php',
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
					$imel = $_POST['imel'];
					$simel = strtolower($imel);
					$pass = $_POST['pass'];
					$nama = $_POST['nama'];
					$jabatan = $_POST['jabatan'];
					$telp = $_POST['telp'];
					$type = base64_encode($_POST['role']);
					$logdate = date('Y-m-d H:i:s');
					$status = 1;

					$key = "syalim.com";
					$pword = md5($pass . $key . md5($pass));

					if (trim($_POST['imel']) == '') {
						$error[] = "<i class=\"fa fa-times-circle\"></i> Alamat Email Masih Kosong";
					}

					if (!filter_var($simel, FILTER_VALIDATE_EMAIL)) {
						$error[] = "<i class=\"fa fa-times-circle\"></i> Penulisan Alamat Email belum benar";
					}

					if (trim($_POST['nama']) == '') {
						$error[] = "<i class=\"fa fa-times-circle\"></i> Nama Lengkap Masih Kosong";
					}

					if (trim($_POST['jabatan']) == '') {
						$error[] = "<i class=\"fa fa-times-circle\"></i> Jabatan Masih Kosong";
					}

					if (trim($_POST['telp']) == '') {
						$error[] = "<i class=\"fa fa-times-circle\"></i> Nomor Telpon Masih Kosong";
					}

					if (!preg_match("/^[0-9]*$/", $telp)) {
						$error[] = "<i class=\"fa fa-times-circle\"></i> Penulisan Nomor Telpon Hanya Angka Saja";
					}

					if (trim($_POST['pass']) == '') {
						$error[] = "<i class=\"fa fa-times-circle\"></i> Password User Belum Diisi";
					}

					if (trim($_POST['role']) == '') {
						$error[] = "<i class=\"fa fa-times-circle\"></i> Hak Akses Belum Dipilih";
					}

					if (isset($error)) {
						$error = $error;
					} else {
						$error = "";
					}

					if ($error <> '') {
						echo "<div class=\"alert alert-warning alert-dismissible\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button><h4>Entri Data User Gagal Dilakukan...</h4>" . implode('<br />', $error) . "<br><br>Silakan Di Ulangi Lagi.</div>";
					} else {

						if ($cruduser->create($simel, $pword, $nama, $jabatan, $telp, $type, $status, $logdate)) {
				?>
							<script type="text/javascript">
								$.notify({
									title: "Sukses... ",
									message: "Entri Data User Berhasil Dilakukan!",
									icon: 'fa fa-check'
								}, {
									type: "success"
								});
							</script>
				<?php
						} else {
							echo "<div class=\"alert alert-warning alert-dismissible\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button><h4>Entri Data User Gagal Dilakukan...</h4>Terjadi kegagalan penyimpanan data ke database<br><br>Silakan Di Ulangi Lagi.</div>";
						}
					}
				}
				?>

				<!-- Default box -->
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Daftar User</h3>
					</div>
					<div class="box-body">
						<form id="cari-form" method="post" class="form-horizontal">
							<div class="form-group">
								<div class="col-md-6">
									<button class="btn btn-large btn-primary" data-toggle="modal" data-target="#entri-modal" data-id="<?php print(base64_encode($_SESSION['user_session'])); ?>" id="userEntri"><i class="fa fa-plus"></i>&nbsp; Entri User</button>
								</div>
								<div class="col-md-6">
									<div class="input-group">
										<input type="text" id="cari" name="cari" class="form-control" placeholder="Cari alamat email, nama lengkap atau jabatan...">
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
							$sqlcari = $db_con->prepare("SELECT * FROM usertb WHERE imel LIKE :imel OR nama LIKE :nama OR jabatan LIKE :jabatan");
							$sqlcari->bindParam(':imel', $cari);
							$sqlcari->bindParam(':nama', $cari);
							$sqlcari->bindParam(':jabatan', $cari);
							$sqlcari->execute();
							$countcari = $sqlcari->rowCount();
						?>
							<p>Pencarian user dengan kata kunci <span class="badge"><?php echo $_POST['cari']; ?></span> ditemukan <span class="badge"><?php echo $countcari; ?></span> data :</p>
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Alamat Email</th>
											<th>Nama Lengkap</th>
											<th>Jabatan</th>
											<th>Hak Akses</th>
											<th>Status</th>
											<th>Terdaftar</th>
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
												<td><?php print($rowcari['imel']); ?></td>
												<td><?php print($rowcari['nama']); ?></td>
												<td><?php print($rowcari['jabatan']); ?></td>
												<td><?php print(strtoupper(base64_decode($rowcari['type']))); ?></td>
												<td>
													<?php if ($rowcari['status'] == 1) {
														echo "<span class=\"label bg-green\"><i class=\"fa fa-check\"></i> Aktif</span>";
													} else {
														echo "<span class=\"label bg-red\"><i class=\"fa fa-close\"></i> Non Aktif</span>";
													} ?>
												</td>
												<td><?php echo $tanggal->time_since(strtotime($rowcari['logdate'])); ?></td>
												<td align="center">
													<a href="<?php echo $urlweb; ?>sistem.php?sistem=user&act=view&id=<?php print(base64_encode($rowcari['id_us'])); ?>"><i class="fa fa-search-plus"></i> view</a>
												</td>

											</tr>
										<?php
											$no++;
										}
										?>
									</tbody>
								</table>
							</div>
							<a class="btn btn-default" href="<?php echo $urlweb; ?>sistem.php?sistem=user"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
						<?php
						} else {
						?>
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Alamat Email</th>
											<th>Nama Lengkap</th>
											<th>Jabatan</th>
											<th>Hak Akses</th>
											<th>Status</th>
											<th>Terdaftar</th>
											<th>&nbsp;</th>
										</tr>
									</thead>

									<tbody>

										<?php
										$query = "SELECT * FROM usertb ORDER BY nama ASC";
										$records_per_page = 10;
										$newquery = $cruduser->paging($query, $records_per_page);
										$cruduser->dataview($newquery, $records_per_page);
										?>

									</tbody>
								</table>
							</div>

							<div class="pagination-wrap">
								<?php
								$self = "sistem.php?sistem=user";

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
						*Lakukan perubahan data user atau penambahan user sesuai kebutuhan saja.
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
								<i class="fa fa-plus"></i> Entri User
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

					$(document).on('click', '#userEntri', function(e) {

						e.preventDefault();

						var uid = $(this).data('id'); // it will get id of clicked row

						$('#dynamic-content').html(''); // leave it blank before ajax call
						$('#modal-loader').show(); // load ajax loader

						$.ajax({
								url: 'sistem/userEntri.php',
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