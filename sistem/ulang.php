<?php
if (!defined('_VALID_ACCESS')) {
	header("location: index.php");
	die;
}

session_start();

isLogin();

isKasubag();


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

$mytahun = date('Y');
$mybulan = date('m');

if (isset($_POST['btn-cari'])) {
	$ntahun = $_POST['tahun'];
	$nbulan = $_POST['bulan'];
} else {
	$ntahun = $mytahun;
	$nbulan = $mybulan;
}

if ($nbulan <> "01") {
	$ntahunlalu = $ntahun;
	$nbulanx = ltrim($nbulan, '0');
	$nbulanlalu = $nbulanx - 1;
	$nbulanlalu = sprintf("%02d", $nbulanlalu);
} else {
	$ntahunlalu = $ntahun - 1;
	$nbulanlalu = 12;
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
			<i class="fa fa-file"></i> Data Tera Ulang Sah
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
				<h3 class="box-title">DATA TERA SAH UTTP</h3>
			</div>
			<div class="box-body">
				<form id="cari-form" method="post" class="form-horizontal">
					<div class="row">
						<div class="col-md-6">
							<p style="font-size:22px;" class="text-uppercase">Bulan <?php $tanggal->pilbulan($nbulan); ?> Tahun <?php echo $ntahun; ?></p>
						</div>
						<div class="col-md-3">
							<select id="bulan" name="bulan" class="form-control">
								<option value="01" <?php if ($mybulan == '01') {
														echo "selected=selected";
													} ?>>Januari</option>
								<option value="02" <?php if ($mybulan == '02') {
														echo "selected=selected";
													} ?>>Februari</option>
								<option value="03" <?php if ($mybulan == '03') {
														echo "selected=selected";
													} ?>>Maret</option>
								<option value="04" <?php if ($mybulan == '04') {
														echo "selected=selected";
													} ?>>April</option>
								<option value="05" <?php if ($mybulan == '05') {
														echo "selected=selected";
													} ?>>Mei</option>
								<option value="06" <?php if ($mybulan == '06') {
														echo "selected=selected";
													} ?>>Juni</option>
								<option value="07" <?php if ($mybulan == '07') {
														echo "selected=selected";
													} ?>>Juli</option>
								<option value="08" <?php if ($mybulan == '08') {
														echo "selected=selected";
													} ?>>Agustus</option>
								<option value="09" <?php if ($mybulan == '09') {
														echo "selected=selected";
													} ?>>September</option>
								<option value="10" <?php if ($mybulan == '10') {
														echo "selected=selected";
													} ?>>Oktober</option>
								<option value="11" <?php if ($mybulan == '11') {
														echo "selected=selected";
													} ?>>November</option>
								<option value="12" <?php if ($mybulan == '12') {
														echo "selected=selected";
													} ?>>Desember</option>
							</select>
						</div>
						<div class="col-md-2">
							<select id="tahun" name="tahun" class="form-control">
								<?php
								for ($tahunx = $mytahun - 20; $tahunx <= $mytahun; $tahunx++) {
									echo "<option value=\"" . $tahunx . "\"";
									if ($mytahun == $tahunx) {
										echo "selected=selected";
									}
									echo ">" . $tahunx . "</option>";
								}
								?>
							</select>
						</div>
						<div class="col-md-1">
							<button type="submit" class="btn btn-primary" name="btn-cari">Pilih</button>
						</div>
					</div>
				</form>
				<br>
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th scope="col" rowspan="2">No</th>
							<th scope="col" rowspan="2">Jenis UTTP</th>
							<th scope="col" rowspan="2">UTTP Selain Pasar</th>
							<th scope="col" colspan="10">UTTP Pasar</th>
							<th scope="col" colspan="2">Jumlah</th>
							<th scope="col" rowspan="2">Perubahan</th>
						</tr>
						<tr>
							<th scope="col">Pasar 1</th>
							<th scope="col">Pasar 2</th>
							<th scope="col">Pasar 3</th>
							<th scope="col">Pasar 4</th>
							<th scope="col">Pasar 5</th>
							<th scope="col">Pasar 6</th>
							<th scope="col">Pasar 7</th>
							<th scope="col">Pasar 8</th>
							<th scope="col">Pasar 9</th>
							<th scope="col">Jumlah UTTP Pasar</th>
							<th scope="col">UTTP selain Pasar & Pasar Bulan ini</th>
							<th scope="col">UTTP selain Pasar & Pasar Bulan lalu</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$sqljenis = $db_con->prepare("SELECT * FROM jenistb ORDER BY id_jn ASC");
						$sqljenis->execute();
						$countjenis = $sqljenis->rowCount();

						if ($countjenis >= 1) {

							$no = 1;
							while ($rowjenis = $sqljenis->fetch(PDO::FETCH_ASSOC)) {
						?>
								<tr>
									<td><?php print($no); ?></td>
									<td><?php print(strtoupper($rowjenis['nama'])); ?></td>

									<?php
									$sqlpasar = $db_con->prepare("SELECT * FROM pasartb ORDER BY id_ps ASC");
									$sqlpasar->execute();
									while ($rowpasar = $sqlpasar->fetch(PDO::FETCH_ASSOC)) {
										echo "<td align=\"right\">";
										$sqldata = $db_con->prepare("SELECT COUNT(*) AS tot FROM alattb WHERE id_jn='" . $rowjenis['id_jn'] . "' AND id_ps='" . $rowpasar['id_ps'] . "' AND YEAR(tgl)='" . $ntahun . "' AND MONTH(tgl)='" . $nbulan . "'");
										$sqldata->execute();
										$rowdata = $sqldata->fetch(PDO::FETCH_ASSOC);
										print(number_format($rowdata['tot'], 0, ',', '.'));
										echo "</td>";
									}

									echo "<td align=\"right\">";
									$sqldatax = $db_con->prepare("SELECT COUNT(*) AS tot FROM alattb WHERE id_jn='" . $rowjenis['id_jn'] . "' AND id_ps <> '1' AND YEAR(tgl)='" . $ntahun . "' AND MONTH(tgl)='" . $nbulan . "'");
									$sqldatax->execute();
									$rowdatax = $sqldatax->fetch(PDO::FETCH_ASSOC);
									print(number_format($rowdatax['tot'], 0, ',', '.'));
									echo "</td>";

									echo "<td align=\"right\">";
									$sqldataxx = $db_con->prepare("SELECT COUNT(*) AS tot FROM alattb WHERE id_jn='" . $rowjenis['id_jn'] . "' AND YEAR(tgl)='" . $ntahun . "' AND MONTH(tgl)='" . $nbulan . "'");
									$sqldataxx->execute();
									$rowdataxx = $sqldataxx->fetch(PDO::FETCH_ASSOC);
									print(number_format($rowdataxx['tot'], 0, ',', '.'));
									echo "</td>";

									echo "<td align=\"right\">";
									$sqldataxxx = $db_con->prepare("SELECT COUNT(*) AS tot FROM alattb WHERE id_jn='" . $rowjenis['id_jn'] . "' AND YEAR(tgl)='" . $ntahunlalu . "' AND MONTH(tgl)='" . $nbulanlalu . "'");
									$sqldataxxx->execute();
									$rowdataxxx = $sqldataxxx->fetch(PDO::FETCH_ASSOC);
									print(number_format($rowdataxxx['tot'], 0, ',', '.'));
									echo "</td>";

									echo "<td align=\"right\">";
									print(number_format($rowdataxx['tot'] - $rowdataxxx['tot'], 0, ',', '.'));
									echo "</td>";
									?>

								</tr>

								<?php
								$sqlsubjenis = $db_con->prepare("SELECT * FROM subjenistb WHERE id_jn='" . $rowjenis['id_jn'] . "' ORDER BY id_sj ASC");
								$sqlsubjenis->execute();
								$countsubjenis = $sqlsubjenis->rowCount();

								if ($countsubjenis >= 1) {

									$nos = 1;
									while ($rowsubjenis = $sqlsubjenis->fetch(PDO::FETCH_ASSOC)) {
								?>
										<tr>
											<td>&nbsp;</td>
											<td><?php print($nos); ?>. <?php print($rowsubjenis['nama']); ?></td>

											<?php
											$sqlpasarx = $db_con->prepare("SELECT * FROM pasartb ORDER BY id_ps ASC");
											$sqlpasarx->execute();
											while ($rowpasarx = $sqlpasarx->fetch(PDO::FETCH_ASSOC)) {
												echo "<td align=\"right\">";
												$sqldatas = $db_con->prepare("SELECT COUNT(*) AS tot FROM alattb WHERE id_sj='" . $rowsubjenis['id_sj'] . "' AND id_ps='" . $rowpasarx['id_ps'] . "' AND YEAR(tgl)='" . $ntahun . "' AND MONTH(tgl)='" . $nbulan . "'");
												$sqldatas->execute();
												$rowdatas = $sqldatas->fetch(PDO::FETCH_ASSOC);
												print(number_format($rowdatas['tot'], 0, ',', '.'));
												echo "</td>";
											}

											echo "<td align=\"right\">";
											$sqldatasx = $db_con->prepare("SELECT COUNT(*) AS tot FROM alattb WHERE id_sj='" . $rowsubjenis['id_sj'] . "' AND id_ps <> '1' AND YEAR(tgl)='" . $ntahun . "' AND MONTH(tgl)='" . $nbulan . "'");
											$sqldatasx->execute();
											$rowdatasx = $sqldatasx->fetch(PDO::FETCH_ASSOC);
											print(number_format($rowdatasx['tot'], 0, ',', '.'));
											echo "</td>";

											echo "<td align=\"right\">";
											$sqldatasxx = $db_con->prepare("SELECT COUNT(*) AS tot FROM alattb WHERE id_sj='" . $rowsubjenis['id_sj'] . "' AND YEAR(tgl)='" . $ntahun . "' AND MONTH(tgl)='" . $nbulan . "'");
											$sqldatasxx->execute();
											$rowdatasxx = $sqldatasxx->fetch(PDO::FETCH_ASSOC);
											print(number_format($rowdatasxx['tot'], 0, ',', '.'));
											echo "</td>";

											echo "<td align=\"right\">";
											$sqldatasxxx = $db_con->prepare("SELECT COUNT(*) AS tot FROM alattb WHERE id_sj='" . $rowsubjenis['id_sj'] . "' AND YEAR(tgl)='" . $ntahunlalu . "' AND MONTH(tgl)='" . $nbulanlalu . "'");
											$sqldatasxxx->execute();
											$rowdatasxxx = $sqldatasxxx->fetch(PDO::FETCH_ASSOC);
											print(number_format($rowdatasxxx['tot'], 0, ',', '.'));
											echo "</td>";

											echo "<td align=\"right\">";
											print(number_format($rowdatasxx['tot'] - $rowdatasxxx['tot'], 0, ',', '.'));
											echo "</td>";
											?>

										</tr>
								<?php
										$nos++;
									}
								}
								?>


						<?php
								$no++;
							}
						}

						?>
						<tr>
							<td>&nbsp;</td>
							<td><b>Jumlah UTTP</b></td>

							<?php
							$sqlpasartx = $db_con->prepare("SELECT * FROM pasartb ORDER BY id_ps ASC");
							$sqlpasartx->execute();
							while ($rowpasartx = $sqlpasartx->fetch(PDO::FETCH_ASSOC)) {
								echo "<td align=\"right\"><b>";
								$sqldatast = $db_con->prepare("SELECT COUNT(*) AS tot FROM alattb WHERE id_ps='" . $rowpasartx['id_ps'] . "' AND YEAR(tgl)='" . $ntahun . "' AND MONTH(tgl)='" . $nbulan . "'");
								$sqldatast->execute();
								$rowdatast = $sqldatast->fetch(PDO::FETCH_ASSOC);
								print(number_format($rowdatast['tot'], 0, ',', '.'));
								echo "</b></td>";
							}

							echo "<td align=\"right\"><b>";
							$sqldatastx = $db_con->prepare("SELECT COUNT(*) AS tot FROM alattb WHERE id_ps <> '1' AND YEAR(tgl)='" . $ntahun . "' AND MONTH(tgl)='" . $nbulan . "'");
							$sqldatastx->execute();
							$rowdatastx = $sqldatastx->fetch(PDO::FETCH_ASSOC);
							print(number_format($rowdatastx['tot'], 0, ',', '.'));
							echo "</b></td>";

							echo "<td align=\"right\"><b>";
							$sqldatastxx = $db_con->prepare("SELECT COUNT(*) AS tot FROM alattb WHERE YEAR(tgl)='" . $ntahun . "' AND MONTH(tgl)='" . $nbulan . "'");
							$sqldatastxx->execute();
							$rowdatastxx = $sqldatastxx->fetch(PDO::FETCH_ASSOC);
							print(number_format($rowdatastxx['tot'], 0, ',', '.'));
							echo "</b></td>";

							echo "<td align=\"right\"><b>";
							$sqldatastxxx = $db_con->prepare("SELECT COUNT(*) AS tot FROM alattb WHERE YEAR(tgl)='" . $ntahunlalu . "' AND MONTH(tgl)='" . $nbulanlalu . "'");
							$sqldatastxxx->execute();
							$rowdatastxxx = $sqldatastxxx->fetch(PDO::FETCH_ASSOC);
							print(number_format($rowdatastxxx['tot'], 0, ',', '.'));
							echo "</b></td>";

							echo "<td align=\"right\">";
							print(number_format($rowdatastxx['tot'] - $rowdatastxxx['tot'], 0, ',', '.'));
							echo "</td>";
							?>

						</tr>

					</tbody>
				</table>

			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<a class="btn btn-success" href="" onclick="return showDetailsx('mod/ulang.php?bulan=<?php echo $nbulan; ?>&tahun=<?php echo $ntahun; ?>')"><i class="fa fa-print"></i> Cetak</a>
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