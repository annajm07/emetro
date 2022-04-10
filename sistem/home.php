<?php

if (!defined('_VALID_ACCESS')) {
	header("location: index.php");
	die;
}
session_start();

isLogin();

if (base64_decode($_SESSION['type_session']) == "admin") {
	header("Location: sistem.php?sistem=user");
	die();
}
if (base64_decode($_SESSION['type_session']) == "kepala_uptd") {
	header("Location: sistem.php?sistem=kepala");
	die();
}

if (base64_decode($_SESSION['type_session']) == "Umum") {
	header("Location: sistem.php?sistem=ajukanSKHP");
	die();
}


$stmt = $db_con->prepare("SELECT * FROM usertb WHERE id_us=:uid ORDER BY id_us DESC LIMIT 1");
$stmt->execute(array(":uid" => $_SESSION['user_session']));
$rowuser = $stmt->fetch(PDO::FETCH_ASSOC);

$tanggal = new tanggal;

$crudalat = new crudalat($db_con);
$ajukan = new Ajukan($db_con);
// kelola jika ada request konversi data pengajuan
$dP = false;
$mInf = false;
if (isset($_GET['gn'])) {
	$gn = $_GET['gn'];
	$dP = $ajukan->getById($gn);
	$mInf = "<mark>konversi data pengajuan dengan kode <strong>" . $dP['kode_pengaju'] . "</strong></mark>";
}
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
			<i class="fa fa-dashboard"></i> Pengujian Alat Ukur
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

	if ($act == "entri") {

	?>
		<!-- Main content -->
		<section class="content">

			<?php

			?>

			<!-- Default box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Entri Pengujian</h3>
				</div>
				<?php if ($dP != false) {
					echo $mInf;
				} ?>


				<form id="entri-form" method="post" class="form-horizontal" action="<?php echo $urlweb; ?>sistem.php?sistem=home">

					<div class="box-body">
						<?php if ($dP !== false) : ?>
							<input type="hidden" name="kode" id="kode" value="<?= $dP['kode_pengaju']; ?>">
							<input type="hidden" name="kUmum" id="kUmum" value="<?= $dP['id_user']; ?>">
						<?php endif; ?>

						<div class="form-group">
							<label class="col-lg-3 control-label" for="jenis">Jenis UTTP</label>
							<div class="col-lg-5">
								<select class="form-control" id="id_sj" name="id_sj" required="required">
									<option value="">== Pilih Jenis UTTP ==</option>
									<?php
									$sqlsj = $db_con->prepare("SELECT * FROM subjenistb ORDER BY nama ASC");
									$sqlsj->execute();
									while ($rowsj = $sqlsj->fetch(PDO::FETCH_ASSOC)) {

									?>
										<?php if ($rowsj['id_sj'] == $dP['jenis']) { ?>
											<option value="<?php echo $rowsj['id_sj']; ?>" selected><?php echo $rowsj['nama']; ?></option>
										<?php } else { ?>
											<option value="<?php echo $rowsj['id_sj']; ?>"><?php echo $rowsj['nama']; ?></option>
										<?php } ?>
									<?php

									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="pasar">Pasar</label>
							<div class="col-lg-5">
								<select class="form-control" id="id_ps" name="id_ps" required="required">
									<option value="">== Pilih Pasar ==</option>
									<?php
									$sqlps = $db_con->prepare("SELECT * FROM pasartb ORDER BY id_ps ASC");
									$sqlps->execute();
									while ($rowps = $sqlps->fetch(PDO::FETCH_ASSOC)) {
									?>
										<?php if ($rowps['id_ps'] == $dP['pasar']) { ?>
											<option value="<?php echo $rowps['id_ps']; ?>" selected><?php echo $rowps['nama']; ?></option>
										<?php } else { ?>
											<option value="<?php echo $rowps['id_ps']; ?>"><?php echo $rowps['nama']; ?></option>
										<?php } ?>
									<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="pemakai">Pemakai</label>
							<div class="col-lg-8">
								<input type="text" id="pemakai" name="pemakai" class="form-control" maxlength="100" required="required" value="<?php echo $dP !== false ? $dP['pemakai'] : ''; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="alamat">Alamat</label>
							<div class="col-lg-8">
								<input type="text" id="alamat" name="alamat" class="form-control" maxlength="200" required="required" value="<?php echo $dP !== false ? $dP['alamat'] : ''; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="spbu">Nomor SPBU</label>
							<div class="col-lg-8">
								<input type="text" id="spbu" name="spbu" class="form-control" maxlength="100" value="<?php echo $dP !== false ? $dP['no_spbu'] : ''; ?>">
								<span class="help-block">*Kalau bukan SPBU, harap kosongkan saja.</span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="standar">Standar &amp; Ketelusuran</label>
							<div class="col-lg-8">
								<input type="text" id="standar" name="standar" class="form-control" value="AT Kelas M2 hasil kalibrasi yang dilaporkan tertelusur ke satuan pengukuran SI melalui direktorat Metrologi Bandung" maxlength="200" required="required">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="tgl">Tanggal Pengujian</label>
							<div class="col-lg-3">
								<input type="text" id="tgl" name="tgl" class="form-control" value="<?php echo date("d/m/Y"); ?>" maxlength="12" required="required">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="penguji">Di Uji Oleh</label>
							<div class="col-lg-6">
								<input type="text" id="penguji" name="penguji" class="form-control" maxlength="100" required="required">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="nip">NIK</label>
							<div class="col-lg-4">
								<input type="text" id="nip" name="nip" class="form-control" maxlength="30" required="required" value="<?php echo $dP !== false ? $dP['nip'] : ''; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="metode">Metode</label>
							<div class="col-lg-6">
								<textarea class="form-control" id="metode" name="metode" rows="3" required="required">SK Direktur Jenderal Standarisasi dan Perlindungan Konsumen No. 131/SPK/KEP/10/2015, Tanggal 19 Oktober 2015 tentang Syarat Teknis Timbangan Bukan Otomatis</textarea>
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-3 control-label" for="tera">Pengujian</label>
							<div class="col-lg-3">
								<select id="tera" name="tera" class="form-control" required="required">
									<option value="">= Status Pengujian =</option>
									<option value="0">Tera Ulang</option>
									<option value="1">Tera</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-3 control-label" for="tahun">Tahun Hasil Pengujian</label>
							<div class="col-lg-2">
								<select id="tahun" name="tahun" class="form-control">
									<?php
									for ($tahunx = $mytahun; $tahunx <= $mytahun + 20; $tahunx++) {
										echo "<option value=\"" . $tahunx . "\"";
										if ($mytahun == $tahunx) {
											echo "selected=selected";
										}
										echo ">" . $tahunx . "</option>";
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="berlaku">Berlaku s/d</label>
							<div class="col-lg-3">
								<input type="text" id="berlaku" name="berlaku" class="form-control" value="<?php echo date("d/m/Y"); ?>" maxlength="12" required="required">
							</div>
						</div>
						<hr>
						<h4>Meter Taksi</h4>
						<p>Tambahan formulir isian untuk meter taksi (*isi jika pengukuran meter taksi saja)</p>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="merek">Merek Kendaraan</label>
							<div class="col-lg-5">
								<input type="text" id="merek" name="merek" class="form-control" maxlength="100" value="<?php echo $dP !== false ? $dP['mrk_kdr'] : ''; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="nopol">No. Pol</label>
							<div class="col-lg-3">
								<input type="text" id="nopol" name="nopol" class="form-control" maxlength="10" value="<?php echo $dP !== false ? $dP['no_pol'] : ''; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="notaksi">No. Taksi</label>
							<div class="col-lg-3">
								<input type="text" id="notaksi" name="notaksi" class="form-control" maxlength="10" value="<?php echo $dP !== false ? $dP['no_taksi'] : ''; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="pemilik">Pemilik</label>
							<div class="col-lg-8">
								<input type="text" id="pemilik" name="pemilik" class="form-control" maxlength="100" value="<?php echo $dP !== false ? $dP['pemilik'] : ''; ?>">
							</div>
						</div>
						<!-- <div class="form-group">
							<label class="col-lg-3 control-label" for="alamatx">Alamat</label>
							<div class="col-lg-8">
								<input type="text" id="alamatx" name="alamatx" class="form-control" maxlength="200" value="<?php echo $dP !== false ? $dP['almt'] : ''; ?>">
							</div>
						</div> -->

					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<button type="submit" class="btn btn-primary" name="btn-save"><i class="fa fa-check-square-o"></i> <?php echo $dP !== false ? "Generate" : "Submit"; ?></button>&nbsp;&nbsp;
						<button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>&nbsp;&nbsp;
						<a class="btn btn-default" href="<?php echo $urlweb; ?>sistem.php?sistem=home"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
					</div>
					<!-- /.box-footer-->

				</form>

			</div>
			<!-- /.box -->

		</section>
		<!-- /.content -->

	<?php

	} elseif ($act == "view") {

	?>
		<!-- Main content -->
		<section class="content">

			<?php

			if (isset($_GET['id'])) {
				$id = base64_decode($_GET['id']);
				extract($crudalat->getID($id));
			}

			if (isset($_POST['btn-savex'])) {
				$nomor = $_POST['nomor'];
				$urut = $_POST['urut'];
				$id_pj = $_POST['id_pj'];
				$tgl = date('Y-m-d');
				$tum = 0;
				$id_us = $rowuser['id_us'];

				if ($crudalat->createxx($id_us, $id_al, $tum, $nomor, $urut, $tgl, $id_pj)) {
			?>
					<script type="text/javascript">
						$.notify({
							title: "Sukses... ",
							message: "Buat Sertifikat Berhasil Dilakukan!",
							icon: 'fa fa-check'
						}, {
							type: "success"
						});
					</script>
				<?php
				} else {
					echo "<div class=\"alert alert-warning alert-dismissible\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button><h4>Buat Sertifikat Gagal Dilakukan...</h4>Terjadi kegagalan penyimpanan data ke database<br><br>Silakan Di Ulangi Lagi.</div>";
				}
			}

			if (isset($_POST['btn-updatex'])) {
				$id_sr = $_POST['cid_sr'];
				$id_pj = $_POST['id_pj'];

				if ($crudalat->updatexx($id_sr, $id_pj)) {
				?>
					<script type="text/javascript">
						$.notify({
							title: "Sukses... ",
							message: "Koreksi Pejabat Berhasil Dilakukan!",
							icon: 'fa fa-check'
						}, {
							type: "success"
						});
					</script>
			<?php
				} else {
					echo "<div class=\"alert alert-warning alert-dismissible\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button><h4>Koreksi Pejabat Gagal Dilakukan...</h4>Terjadi kegagalan penyimpanan data ke database<br><br>Silakan Di Ulangi Lagi.</div>";
				}
			}

			$susj = $db_con->prepare("SELECT * FROM subjenistb WHERE id_sj=:sj ORDER BY id_sj DESC LIMIT 1");
			$susj->execute(array(":sj" => $id_sj));
			$rowsj = $susj->fetch(PDO::FETCH_ASSOC);

			$lam = $db_con->prepare("SELECT COUNT(*) AS jum FROM lampirantb WHERE id_al=:al");
			$lam->execute(array(":al" => $id_al));
			$rowlam = $lam->fetch(PDO::FETCH_ASSOC);

			$jum = $db_con->prepare("SELECT COUNT(*) AS jum FROM sertifikattb WHERE pengukuran=:pengukuran AND tum='0'");
			$jum->execute(array(":pengukuran" => $id_al));
			$rowjum = $jum->fetch(PDO::FETCH_ASSOC);

			$sups = $db_con->prepare("SELECT * FROM pasartb WHERE id_ps=:ps ORDER BY id_ps DESC LIMIT 1");
			$sups->execute(array(":ps" => $id_ps));
			$rowps = $sups->fetch(PDO::FETCH_ASSOC);

			$suser = $db_con->prepare("SELECT nama FROM usertb WHERE id_us=:uid ORDER BY id_us DESC LIMIT 1");
			$suser->execute(array(":uid" => $id_us));
			$rowmuser = $suser->fetch(PDO::FETCH_ASSOC);

			if ($tera == 1) {
				$mytera = "Tera";
			} else {
				$mytera = "Tera Ulang";
			}
			?>

			<!-- Default box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">View Data Pengujian Alat Ukur</h3>
				</div>
				<form id="edit-form" method="post" class="form-horizontal">

					<div class="box-body">

						<div class="form-group">
							<label class="col-lg-3 control-label" for="admin">Admin</label>
							<div class="col-lg-5">
								<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $rowmuser['nama']; ?>" disabled="">
							</div>
						</div>
						<hr>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="jenis">Jenis UTTP</label>
							<div class="col-lg-5">
								<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $rowsj['nama']; ?>" disabled="">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="pasar">Pasar</label>
							<div class="col-lg-5">
								<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $rowps['nama']; ?>" disabled="">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="pemakai">Pemakai</label>
							<div class="col-lg-8">
								<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $pemakai; ?>" disabled="">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="alamat">Alamat</label>
							<div class="col-lg-8">
								<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $alamat; ?>" disabled="">
							</div>
						</div>
						<?php if ($spbu <> '') { ?>
							<div class="form-group">
								<label class="col-lg-3 control-label" for="spbu">Nomor SPBU</label>
								<div class="col-lg-8">
									<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $spbu; ?>" disabled="">
								</div>
							</div>
						<?php } else {
							echo "";
						} ?>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="standar">Standar &amp; Ketelusuran</label>
							<div class="col-lg-8">
								<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $standar; ?>" disabled="">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="tgl">Tanggal Pengujian</label>
							<div class="col-lg-3">
								<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php if ($tgl <> "0000-00-00") {
																																$tanggal->contanggalx(substr($tgl, 8, 2), substr($tgl, 5, 2), substr($tgl, 0, 4));
																															} else {
																																echo "";
																															} ?>" disabled="">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="penguji">Di Uji Oleh</label>
							<div class="col-lg-6">
								<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $penguji; ?>" disabled="">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="nip">NIK</label>
							<div class="col-lg-4">
								<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $nip; ?>" disabled="">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="metode">Metode</label>
							<div class="col-lg-6">
								<textarea class="form-control" id="metode" name="metode" rows="3" disabled><?php echo $metode; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="tera">Pengujian</label>
							<div class="col-lg-3">
								<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $mytera; ?>" disabled="">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="tahun">Tahun Hasil Pengujian</label>
							<div class="col-lg-2">
								<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $tahun; ?>" disabled="">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="berlaku">Berlaku s/d</label>
							<div class="col-lg-3">
								<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php if ($berlaku <> "0000-00-00") {
																																$tanggal->contanggalx(substr($berlaku, 8, 2), substr($berlaku, 5, 2), substr($berlaku, 0, 4));
																															} else {
																																echo "";
																															} ?>" disabled="">
							</div>
						</div>
						<?php if ($notaksi <> '') { ?>
							<hr>
							<h4>Meter Taksi</h4>
							<p>Tambahan formulir isian untuk meter taksi (*isi jika pengukuran meter taksi saja)</p>
							<div class="form-group">
								<label class="col-lg-3 control-label" for="merek">Merek Kendaraan</label>
								<div class="col-lg-5">
									<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $merek; ?>" disabled="">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 control-label" for="nopol">No. Pol</label>
								<div class="col-lg-3">
									<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $nopol; ?>" disabled="">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 control-label" for="notaksi">No. Taksi</label>
								<div class="col-lg-3">
									<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $notaksi; ?>" disabled="">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 control-label" for="pemilik">Pemilik</label>
								<div class="col-lg-8">
									<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $pemilik; ?>" disabled="">
								</div>
							</div>
							<!-- <div class="form-group">
								<label class="col-lg-3 control-label" for="alamatx">Alamat</label>
								<div class="col-lg-8">
									<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $alamatx; ?>" disabled="">
								</div>
							</div> -->
						<?php } else {
							echo "";
						} ?>

					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<a class="btn btn-primary" href="<?php echo $urlweb; ?>sistem.php?sistem=home&act=edit&id=<?php print(base64_encode($id_al)); ?>"><i class="fa fa-edit"></i> Edit Data Pengujian Alat Ukur</a>&nbsp;&nbsp;
						<button class="btn btn-large btn-warning" data-toggle="modal" data-target="#entri-modal" data-id="<?php echo $_GET['id']; ?>" id="speEntri"><i class="fa fa-plus"></i>&nbsp; Entri Spesifikasi Alat Ukur</button>&nbsp;&nbsp;
						<?php
						if ($rowlam['jum'] >= 1) {
							if ($rowjum['jum'] >= 1) {
								// ambil data sertifikat untuk cek apakah tombol cetak sertifikat sudah bisa diakses
								$sqll = $db_con->prepare("SELECT * FROM sertifikattb WHERE pengukuran=:pengukuran");
								$sqll->bindParam(':pengukuran', $id_al);
								$sqll->execute();
								$roww = $sqll->fetch(PDO::FETCH_ASSOC);
								// tutup ambil data sertifikat
						?>
								<!-- <button class="btn btn-large btn-info" data-toggle="modal" data-target="#edit-modal" data-id="" id="serEdit"><i class="fa fa-user"></i>&nbsp; Koreksi Pejabat</button>&nbsp;&nbsp; -->
								<?php if ($roww['status'] == 1) : ?>
									<a class="btn btn-large btn-success" href="" onclick="return showDetails('mod/sertifikat.php?id=<?php print(base64_encode($id_al)); ?>&tum=0')"><i class="fa fa-print"></i>&nbsp; Cetak Sertifikat</a>&nbsp;&nbsp;
								<?php else : ?>
									<button class="btn btn-large btn-success" disabled><i class="fa fa-print"></i>&nbsp; Cetak Sertifikat</button>&nbsp;&nbsp;
								<?php endif; ?>
								<?php if ($rowlam['jum'] >= 2) { ?>
									<a class="btn btn-large btn-danger" href="" onclick="return showDetails('mod/lampiran.php?id=<?php print(base64_encode($id_al)); ?>&tum=0')"><i class="fa fa-print"></i>&nbsp; Cetak Lampiran</a>&nbsp;&nbsp;
								<?php }
							} else { ?>
								<button class="btn btn-large btn-success" data-toggle="modal" data-target="#sertifikat-modal" data-id="<?php echo $_GET['id']; ?>" id="serEntri"><i class="fa fa-qrcode"></i>&nbsp; Buat Sertifikat</button>&nbsp;&nbsp;
						<?php }
						} ?>
						<a class="btn btn-default" href="<?php echo $urlweb; ?>sistem.php?sistem=home"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
					</div>
					<!-- /.box-footer-->

				</form>

			</div>
			<!-- /.box -->

			<?php

			if (isset($_POST['btn-save'])) {
				$merek = $_POST['merek'];
				$buatan = $_POST['buatan'];
				$seri = $_POST['seri'];
				$tipe = $_POST['tipe'];
				$kapasitas = $_POST['kapasitas'];
				$jenis = $_POST['jenis'];
				$id_us = $rowuser['id_us'];

				if ($crudalat->createx($id_us, $id_al, $merek, $buatan, $seri, $tipe, $kapasitas, $jenis)) {
			?>
					<script type="text/javascript">
						$.notify({
							title: "Sukses... ",
							message: "Entri Data Spesifikasi Alat Ukur Berhasil Dilakukan!",
							icon: 'fa fa-check'
						}, {
							type: "success"
						});
					</script>
				<?php
				} else {
					echo "<div class=\"alert alert-warning alert-dismissible\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button><h4>Entri Data Spesifikasi Alat Ukur Gagal Dilakukan...</h4>Terjadi kegagalan penyimpanan data ke database<br><br>Silakan Di Ulangi Lagi.</div>";
				}
			}

			if (isset($_POST['btn-savexx'])) {
				$merek = $_POST['merek'];
				$buatan = $_POST['buatan'];
				$seri = $_POST['seri'];
				$tipe = $_POST['tipe'];
				$kapasitas = $_POST['kapasitas'];
				$jenis = $_POST['jenis'];
				$id_lp = $_POST['cid_lp'];

				if ($crudalat->updatex($id_lp, $merek, $buatan, $seri, $tipe, $kapasitas, $jenis)) {
				?>
					<script type="text/javascript">
						$.notify({
							title: "Sukses... ",
							message: "Update Data Spesifikasi Alat Ukur Berhasil Dilakukan!",
							icon: 'fa fa-check'
						}, {
							type: "success"
						});
					</script>
			<?php
				} else {
					echo "<div class=\"alert alert-warning alert-dismissible\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button><h4>Update Data Spesifikasi Alat Ukur Gagal Dilakukan...</h4>Terjadi kegagalan penyimpanan data ke database<br><br>Silakan Di Ulangi Lagi.</div>";
				}
			}

			?>

			<!-- Default box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Spesifikasi Alat Ukur</h3>
				</div>
				<div class="box-body">
					<?php
					$sqlspe = $db_con->prepare("SELECT * FROM lampirantb WHERE id_al = :al");
					$sqlspe->bindParam(':al', $id_al);
					$sqlspe->execute();
					$countspe = $sqlspe->rowCount();
					?>
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>No.</th>
									<th>Merk/Buatan</th>
									<th>No. Seri</th>
									<th>Type</th>
									<?php if ($notaksi <> '') {
										echo "";
									} else { ?>
										<?php if ($spbu <> '') { ?>
											<th>Jenis BBM</th>
										<?php } else { ?>
											<th>Kapasitas</th>
										<?php } ?>
									<?php } ?>
									<th>&nbsp;</th>
								</tr>
							</thead>

							<tbody>

								<?php
								$no = 1;
								while ($rowspe = $sqlspe->fetch(PDO::FETCH_ASSOC)) {
								?>
									<tr>
										<td><?php print($no); ?></td>
										<td><?php print($rowspe['merek']); ?> / <?php print($rowspe['buatan']); ?></td>
										<td><?php print($rowspe['seri']); ?></td>
										<td><?php print($rowspe['tipe']); ?></td>
										<?php if ($notaksi <> '') {
											echo "";
										} else { ?>
											<?php if ($spbu <> '') { ?>
												<td><?php print($rowspe['jenis']); ?></td>
											<?php } else { ?>
												<td><?php print($rowspe['kapasitas']); ?></td>
											<?php } ?>
										<?php } ?>
										<td align="center">
											<button class="btn btn-default btn-xs" data-toggle="modal" data-target="#editx-modal" data-id="<?php print(base64_encode($rowspe['id_lp'])); ?>" id="speEdit"><i class="fa fa-edit"></i> Edit</button>&nbsp;
											<a class="btn btn-default btn-xs" href="<?php echo $urlweb; ?>sistem.php?sistem=aksi&mod=alat&act=delete&id=<?php echo base64_encode($rowspe['id_lp']); ?>&idx=<?php echo $_GET['id']; ?>"><i class="fa fa-trash"></i> Hapus</a>
										</td>

									</tr>
								<?php
									$no++;
								}
								?>
							</tbody>
						</table>
					</div>

				</div>
				<!-- /.box-body -->
				<div class="box-footer">

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
							<i class="fa fa-plus"></i> Entri Spesifikasi Alat Ukur
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

				$(document).on('click', '#speEntri', function(e) {

					e.preventDefault();

					var uid = $(this).data('id'); // it will get id of clicked row

					$('#dynamic-content').html(''); // leave it blank before ajax call
					$('#modal-loader').show(); // load ajax loader

					$.ajax({
							url: 'sistem/speEntri.php',
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

		<div id="sertifikat-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title">
							<i class="fa fa-qrcode"></i> Buat Sertifikat
						</h4>
					</div>
					<div class="modal-body">

						<div id="modal-loaderx" style="display: none; text-align: center;">
							<img src="<?php echo $urlweb; ?>img/eloading.gif">
						</div>

						<!-- content will be load here -->
						<div id="dynamic-contentx"></div>

					</div>
					<div class="modal-footer">

					</div>

				</div>
			</div>
		</div><!-- /.modal -->

		<script>
			$(document).ready(function() {

				$(document).on('click', '#serEntri', function(e) {

					e.preventDefault();

					var uid = $(this).data('id'); // it will get id of clicked row

					$('#dynamic-contentx').html(''); // leave it blank before ajax call
					$('#modal-loaderx').show(); // load ajax loader

					$.ajax({
							url: 'sistem/serEntri.php',
							type: 'POST',
							data: 'id=' + uid,
							dataType: 'html'
						})
						.done(function(data) {
							console.log(data);
							$('#dynamic-contentx').html('');
							$('#dynamic-contentx').html(data); // load response
							$('#modal-loaderx').hide(); // hide ajax loader
						})
						.fail(function() {
							$('#dynamic-contentx').html('<i class="fa fa-warning"></i> Kesalahan sistem.. Silakan ulangi lagi...');
							$('#modal-loaderx').hide();
						});

				});

			});
		</script>

		<div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title">
							<i class="fa fa-user"></i> Koreksi Pejabat
						</h4>
					</div>
					<div class="modal-body">

						<div id="modal-loaderxx" style="display: none; text-align: center;">
							<img src="<?php echo $urlweb; ?>img/eloading.gif">
						</div>

						<!-- content will be load here -->
						<div id="dynamic-contentxx"></div>

					</div>
					<div class="modal-footer">

					</div>

				</div>
			</div>
		</div><!-- /.modal -->

		<script>
			$(document).ready(function() {

				$(document).on('click', '#serEdit', function(e) {

					e.preventDefault();

					var uid = $(this).data('id'); // it will get id of clicked row

					$('#dynamic-contentxx').html(''); // leave it blank before ajax call
					$('#modal-loaderxx').show(); // load ajax loader

					$.ajax({
							url: 'sistem/serEdit.php',
							type: 'POST',
							data: 'id=' + uid,
							dataType: 'html'
						})
						.done(function(data) {
							console.log(data);
							$('#dynamic-contentxx').html('');
							$('#dynamic-contentxx').html(data); // load response
							$('#modal-loaderxx').hide(); // hide ajax loader
						})
						.fail(function() {
							$('#dynamic-contentxx').html('<i class="fa fa-warning"></i> Kesalahan sistem.. Silakan ulangi lagi...');
							$('#modal-loaderxx').hide();
						});

				});

			});
		</script>

		<div id="editx-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title">
							<i class="fa fa-edit"></i> Edit Spesifikasi Alat Ukur
						</h4>
					</div>
					<div class="modal-body">

						<div id="modal-loaderxxx" style="display: none; text-align: center;">
							<img src="<?php echo $urlweb; ?>img/eloading.gif">
						</div>

						<!-- content will be load here -->
						<div id="dynamic-contentxxx"></div>

					</div>
					<div class="modal-footer">

					</div>

				</div>
			</div>
		</div><!-- /.modal -->

		<script>
			$(document).ready(function() {

				$(document).on('click', '#speEdit', function(e) {

					e.preventDefault();

					var uid = $(this).data('id'); // it will get id of clicked row

					$('#dynamic-contentxxx').html(''); // leave it blank before ajax call
					$('#modal-loaderxxx').show(); // load ajax loader

					$.ajax({
							url: 'sistem/speEdit.php',
							type: 'POST',
							data: 'id=' + uid,
							dataType: 'html'
						})
						.done(function(data) {
							console.log(data);
							$('#dynamic-contentxxx').html('');
							$('#dynamic-contentxxx').html(data); // load response
							$('#modal-loaderxxx').hide(); // hide ajax loader
						})
						.fail(function() {
							$('#dynamic-contentxxx').html('<i class="fa fa-warning"></i> Kesalahan sistem.. Silakan ulangi lagi...');
							$('#modal-loaderxxx').hide();
						});

				});

			});
		</script>

	<?php

	} elseif ($act == "edit") {

	?>
		<!-- Main content -->
		<section class="content">
			<?php

			if (isset($_POST['btn-update'])) {
				$id = base64_decode($_GET['id']);
				$id_sj = $_POST['id_sj'];
				$id_ps = $_POST['id_ps'];
				$pemakai = $_POST['pemakai'];
				$alamat = $_POST['alamat'];
				$spbu = $_POST['spbu'];
				$standar = $_POST['standar'];
				$tgl = $_POST['tgl'];
				$penguji = $_POST['penguji'];
				$nip = $_POST['nip'];
				$metode = $_POST['metode'];
				$tera = $_POST['tera'];
				$tahun = $_POST['tahun'];
				$berlaku = $_POST['berlaku'];
				$merek = $_POST['merek'];
				$nopol = $_POST['nopol'];
				$notaksi = $_POST['notaksi'];
				$pemilik = $_POST['pemilik'];
				$alamatx = $_POST['alamat'];

				if ($tgl <> '') {
					$tgl = substr($tgl, 6, 4) . "-" . substr($tgl, 3, 2) . "-" . substr($tgl, 0, 2);
				} else {
					$tgl = "0000-00-00";
				}

				if ($berlaku <> '') {
					$berlaku = substr($berlaku, 6, 4) . "-" . substr($berlaku, 3, 2) . "-" . substr($berlaku, 0, 2);
				} else {
					$berlaku = "0000-00-00";
				}

				if ($crudalat->update($id, $id_sj, $id_ps, $pemakai, $alamat, $spbu, $standar, $tgl, $penguji, $nip, $metode, $tera, $tahun, $berlaku, $merek, $nopol, $notaksi, $pemilik, $alamatx)) {
			?>
					<script type="text/javascript">
						$.notify({
							title: "Sukses... ",
							message: "Update Data Pengujian Alat Ukur Berhasil Dilakukan!",
							icon: 'fa fa-check'
						}, {
							type: "success"
						});
					</script>
			<?php
				} else {
					echo "<div class=\"alert alert-warning alert-dismissible\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button><h4>Update Data Pengujian Alat Ukur Gagal Dilakukan...</h4>Terjadi kegagalan penyimpanan data ke database<br><br>Silakan Di Ulangi Lagi.</div>";
				}
			}

			if (isset($_GET['id'])) {
				$id = base64_decode($_GET['id']);
				extract($crudalat->getID($id));
			}

			if ($tgl <> "0000-00-00") {

				$ttgl = substr($tgl, 8, 2) . "/" . substr($tgl, 5, 2) . "/" . substr($tgl, 0, 4);
			} else {
				$ttgl = "";
			}

			if ($berlaku <> "0000-00-00") {

				$tberlaku = substr($berlaku, 8, 2) . "/" . substr($berlaku, 5, 2) . "/" . substr($berlaku, 0, 4);
			} else {
				$tberlaku = "";
			}

			?>

			<!-- Default box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Edit Data Pengujian Alat Ukur</h3>
				</div>
				<form id="edit-form" method="post" class="form-horizontal">

					<div class="box-body">

						<div class="form-group">
							<label class="col-lg-3 control-label" for="jenis">Jenis UTTP</label>
							<div class="col-lg-5">
								<select class="form-control" id="id_sj" name="id_sj" required="required">
									<?php
									$sqlsj = $db_con->prepare("SELECT * FROM subjenistb ORDER BY nama ASC");
									$sqlsj->execute();
									while ($rowsj = $sqlsj->fetch(PDO::FETCH_ASSOC)) {
									?>
										<option value="<?php echo $rowsj['id_sj']; ?>" <?php if ($rowsj['id_sj'] == $id_sj) {
																							echo "selected=selected";
																						} ?>><?php echo $rowsj['nama']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="pasar">Pasar</label>
							<div class="col-lg-5">
								<select class="form-control" id="id_ps" name="id_ps" required="required">
									<?php
									$sqlps = $db_con->prepare("SELECT * FROM pasartb ORDER BY id_ps ASC");
									$sqlps->execute();
									while ($rowps = $sqlps->fetch(PDO::FETCH_ASSOC)) {
									?>
										<option value="<?php echo $rowps['id_ps']; ?>" <?php if ($rowps['id_ps'] == $id_ps) {
																							echo "selected=selected";
																						} ?>><?php echo $rowps['nama']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="pemakai">Pemakai</label>
							<div class="col-lg-8">
								<input type="text" id="pemakai" name="pemakai" class="form-control" value="<?php echo $pemakai; ?>" maxlength="100" required="required">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="alamat">Alamat</label>
							<div class="col-lg-8">
								<input type="text" id="alamat" name="alamat" class="form-control" value="<?php echo $alamat; ?>" maxlength="200" required="required">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="spbu">Nomor SPBU</label>
							<div class="col-lg-8">
								<input type="text" id="spbu" name="spbu" class="form-control" value="<?php echo $spbu; ?>" maxlength="100">
								<span class="help-block">*Kalau bukan SPBU, harap kosongkan saja.</span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="standar">Standar &amp; Ketelusuran</label>
							<div class="col-lg-8">
								<input type="text" id="standar" name="standar" class="form-control" value="<?php echo $standar; ?>" maxlength="200" required="required">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="tgl">Tanggal Pengujian</label>
							<div class="col-lg-3">
								<input type="text" id="tgl" name="tgl" class="form-control" value="<?php echo $ttgl; ?>" maxlength="12" required="required">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="penguji">Di Uji Oleh</label>
							<div class="col-lg-6">
								<input type="text" id="penguji" name="penguji" class="form-control" value="<?php echo $penguji; ?>" maxlength="100" required="required">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="nip">NIK</label>
							<div class="col-lg-4">
								<input type="text" id="nip" name="nip" class="form-control" value="<?php echo $nip; ?>" maxlength="30" required="required">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="metode">Metode</label>
							<div class="col-lg-6">
								<textarea class="form-control" id="metode" name="metode" rows="3" required="required"><?php echo $metode; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="tera">Pengujian</label>
							<div class="col-lg-3">
								<select id="tera" name="tera" class="form-control" required="required">
									<option value="0" <?php if ($tera == 0) {
															echo "selected=selected";
														} ?>>Tera Ulang</option>
									<option value="1" <?php if ($tera == 1) {
															echo "selected=selected";
														} ?>>Tera</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="tahun">Tahun Hasil Pengujian</label>
							<div class="col-lg-2">
								<select id="tahun" name="tahun" class="form-control">
									<?php
									for ($tahunx = $mytahun; $tahunx <= $mytahun + 20; $tahunx++) {
										echo "<option value=\"" . $tahunx . "\"";
										if ($tahun == $tahunx) {
											echo "selected=selected";
										}
										echo ">" . $tahunx . "</option>";
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="berlaku">Berlaku s/d</label>
							<div class="col-lg-3">
								<input type="text" id="berlaku" name="berlaku" class="form-control" value="<?php echo $tberlaku; ?>" maxlength="12" required="required">
							</div>
						</div>
						<hr>
						<h4>Meter Taksi</h4>
						<p>Tambahan formulir isian untuk meter taksi (*isi jika pengukuran meter taksi saja)</p>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="merek">Merek Kendaraan</label>
							<div class="col-lg-5">
								<input type="text" id="merek" name="merek" class="form-control" value="<?php echo $merek; ?>" maxlength="100">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="nopol">No. Pol</label>
							<div class="col-lg-3">
								<input type="text" id="nopol" name="nopol" class="form-control" value="<?php echo $nopol; ?>" maxlength="10">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="notaksi">No. Taksi</label>
							<div class="col-lg-3">
								<input type="text" id="notaksi" name="notaksi" class="form-control" value="<?php echo $notaksi; ?>" maxlength="10">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="pemilik">Pemilik</label>
							<div class="col-lg-8">
								<input type="text" id="pemilik" name="pemilik" class="form-control" value="<?php echo $pemilik; ?>" maxlength="100">
							</div>
						</div>
						<!-- <div class="form-group">
							<label class="col-lg-3 control-label" for="alamatx">Alamat</label>
							<div class="col-lg-8">
								<input type="text" id="alamatx" name="alamatx" class="form-control" value="<?php echo $alamatx; ?>" maxlength="200">
							</div>
						</div> -->

					</div>
					<!-- /.box-body -->

					<div class="box-footer">
						<button type="submit" class="btn btn-primary" name="btn-update"><i class="fa fa-check-square-o"></i> Update</button>&nbsp;&nbsp;
						<button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>&nbsp;&nbsp;
						<a class="btn btn-default" href="<?php echo $urlweb; ?>sistem.php?sistem=home&act=view&id=<?php print(base64_encode($id_al)); ?>"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
					</div>
					<!-- /.box-footer-->

				</form>

			</div>
			<!-- /.box -->

		</section>
		<!-- /.content -->

	<?php } else { ?>


		<!-- Main content -->
		<section class="content">

			<?php

			if (isset($_POST['btn-save'])) {
				$susj = $db_con->prepare("SELECT id_jn FROM subjenistb WHERE id_sj=:sj ORDER BY id_sj DESC LIMIT 1");
				$susj->execute(array(":sj" => $_POST['id_sj']));
				$rowsj = $susj->fetch(PDO::FETCH_ASSOC);

				$id_jn = $rowsj['id_jn'];
				$id_sj = $_POST['id_sj'];
				$id_ps = $_POST['id_ps'];
				$id_ps = $_POST['id_ps'];
				$pemakai = $_POST['pemakai'];
				$alamat = $_POST['alamat'];
				$spbu = $_POST['spbu'];
				$standar = $_POST['standar'];
				$tgl = $_POST['tgl'];
				$penguji = $_POST['penguji'];
				$nip = $_POST['nip'];
				$metode = $_POST['metode'];
				$tera = $_POST['tera'];
				$tahun = $_POST['tahun'];
				$berlaku = $_POST['berlaku'];
				$merek = $_POST['merek'];
				$nopol = $_POST['nopol'];
				$notaksi = $_POST['notaksi'];
				$pemilik = $_POST['pemilik'];
				$alamatx = $_POST['alamat'];
				$id_us = $rowuser['id_us'];
				$id_umum = "";

				// cek jika ada kode yg dikirim
				if (isset($_POST['kode'])) {
					$kode = $_POST['kode'];
					$id_umum = $_POST['kUmum'];
				}

				if ($tgl <> '') {
					$tgl = substr($tgl, 6, 4) . "-" . substr($tgl, 3, 2) . "-" . substr($tgl, 0, 2);
				} else {
					$tgl = "0000-00-00";
				}

				if ($berlaku <> '') {
					$berlaku = substr($berlaku, 6, 4) . "-" . substr($berlaku, 3, 2) . "-" . substr($berlaku, 0, 2);
				} else {
					$berlaku = "0000-00-00";
				}

				if ($crudalat->create($id_us, $id_jn, $id_sj, $id_ps, $id_umum, $pemakai, $alamat, $spbu, $standar, $tgl, $penguji, $nip, $metode, $tera, $tahun, $berlaku, $merek, $nopol, $notaksi, $pemilik, $alamatx)) {
					if (isset($kode)) {
						$ajukan->delete($kode);
					}
			?>
					<script type="text/javascript">
						$.notify({
							title: "Sukses... ",
							message: "Entri Data Pengujian Alat Ukur Berhasil Dilakukan!",
							icon: 'fa fa-check'
						}, {
							type: "success"
						});
					</script>
			<?php
				} else {
					echo "<div class=\"alert alert-warning alert-dismissible\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button><h4>Entri Data Pengujian Alat Ukur Gagal Dilakukan...</h4>Terjadi kegagalan penyimpanan data ke database<br><br>Silakan Di Ulangi Lagi.</div>";
				}
			}
			?>

			<!-- Default box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Daftar Pengujian Alat Ukur</h3>
				</div>
				<div class="box-body">
					<form id="cari-form" method="post" class="form-horizontal">
						<div class="form-group">
							<div class="col-md-6">
								<a href="<?php echo $urlweb; ?>sistem.php?sistem=home&act=entri" class="btn btn-large btn-primary"><i class="fa fa-plus"></i>&nbsp; Entri Pengujian</a>
							</div>
							<div class="col-md-6">
								<div class="input-group">
									<input type="text" id="cari" name="cari" class="form-control" placeholder="Cari pemakai alat ukur...">
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
						$sqlcari = $db_con->prepare("SELECT * FROM alattb WHERE pemakai LIKE :pemakai");
						$sqlcari->bindParam(':pemakai', $cari);
						$sqlcari->execute();
						$countcari = $sqlcari->rowCount();
					?>
						<p>Pencarian pemakai alat ukur dengan kata kunci <span class="badge"><?php echo $_POST['cari']; ?></span> ditemukan <span class="badge"><?php echo $countcari; ?></span> data :</p>
						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>No.</th>
										<th>Jenis UTTP</th>
										<th>Pemakai</th>
										<th>Tanggal Pengujian</th>
										<th>No. SKHP</th>
										<th>Admin</th>
										<th>&nbsp;</th>
									</tr>
								</thead>

								<tbody>

									<?php
									$no = 1;
									while ($rowcari = $sqlcari->fetch(PDO::FETCH_ASSOC)) {
										$susj = $db_con->prepare("SELECT nama FROM subjenistb WHERE id_sj=:sj ORDER BY id_sj DESC LIMIT 1");
										$susj->execute(array(":sj" => $rowcari['id_sj']));
										$rowsj = $susj->fetch(PDO::FETCH_ASSOC);

										$suno = $db_con->prepare("SELECT nomor FROM sertifikattb WHERE pengukuran=:al AND tum='0' ORDER BY id_sr DESC LIMIT 1");
										$suno->execute(array(":al" => $rowcari['id_al']));
										$rowno = $suno->fetch(PDO::FETCH_ASSOC);

										$suser = $db_con->prepare("SELECT nama FROM usertb WHERE id_us=:uid ORDER BY id_us DESC LIMIT 1");
										$suser->execute(array(":uid" => $rowcari['id_us']));
										$rowmuser = $suser->fetch(PDO::FETCH_ASSOC);
									?>
										<tr>
											<td><?php print($no); ?></td>
											<td><?php print($rowsj['nama']); ?></td>
											<td><?php print($rowcari['pemakai']); ?></td>
											<td><?php if ($rowcari['tgl'] <> "0000-00-00") {
													$tanggal->contanggalx(substr($rowcari['tgl'], 8, 2), substr($rowcari['tgl'], 5, 2), substr($rowcari['tgl'], 0, 4));
												} else {
													echo "";
												} ?></td>
											<td><?php print($rowno['nomor']); ?></td>
											<td><?php print($rowmuser['nama']); ?></td>
											<?php if (base64_decode($_SESSION['type_session']) == "kasubag") : ?>
												<td align="center">
													<a href="<?php echo $urlweb; ?>sistem.php?sistem=home&act=view&id=<?php print(base64_encode($rowcari['id_al'])); ?>"><i class="fa fa-search-plus"></i> view</a>
												</td>
											<?php endif; ?>

										</tr>
									<?php
										$no++;
									}
									?>
								</tbody>
							</table>
						</div>
						<a class="btn btn-default" href="<?php echo $urlweb; ?>sistem.php?sistem=home"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
					<?php
					} else {
					?>
						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>No.</th>
										<th>Jenis UTTP</th>
										<th>Pemakai</th>
										<th>Tanggal Pengujian</th>
										<th>No. SKHP</th>
										<th>Admin</th>
										<th>&nbsp;</th>
									</tr>
								</thead>

								<tbody>

									<?php
									$query = "SELECT * FROM alattb ORDER BY id_al DESC";
									$records_per_page = 10;
									$newquery = $crudalat->paging($query, $records_per_page);
									$crudalat->dataview($newquery, $records_per_page);
									?>

								</tbody>
							</table>
						</div>

						<div class="pagination-wrap">
							<?php
							$self = "sistem.php?sistem=home";

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
					*Klik entri pengujian untuk penambahan data pengujian.
				</div>
				<!-- /.box-footer-->
			</div>
			<!-- /.box -->

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