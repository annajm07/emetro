<?php

define('_VALID_ACCESS',	true);

include_once "../inc/app.config.php";
include_once "../inc/app.core.php";

$tanggal = new tanggal;

$jum = $db_con->prepare("SELECT COUNT(*) AS jum FROM sertifikattb");
$jum->execute();
$rowjum = $jum->fetch(PDO::FETCH_ASSOC);

if ($rowjum['jum'] >= 1) {

	$susr = $db_con->prepare("SELECT id_sr, urut, YEAR(tgl) AS tahun FROM sertifikattb ORDER BY id_sr DESC LIMIT 1");
	$susr->execute();
	$rowsr = $susr->fetch(PDO::FETCH_ASSOC);

	if (date("Y") > $rowsr['tahun']) {
		$nomorx = 1;
	} else {
		$nomorx = $rowsr['urut'] + 1;
	}
} else {

	$nomorx = 1;
}
$mynomor = sprintf("%04d", $nomorx);

if (isset($_REQUEST['id'])) {

	$id = intval(base64_decode($_REQUEST['id']));

?>

	<form id="entri-form" method="post" class="form-horizontal" action="sistem.php?sistem=home&act=view&id=<?php print(base64_encode($id)); ?>">

		<div class="box-body">

			<div class="form-group">
				<label class="col-lg-4 control-label" for="tgl">Tanggal</label>
				<div class="col-lg-6">
					<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php $tanggal->tanggalkinis(); ?>" disabled="">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-4 control-label" for="nomor">Nomor SKHP</label>
				<div class="col-lg-8">
					<input type="text" id="nomor" name="nomor" class="form-control" value="510.3/<?php echo $mynomor; ?>/UPTD-ML/SKHP/<?php $tanggal->pilbulanx(date("m")); ?>/<?php echo date("Y"); ?>" maxlength="100" required="required">
				</div>
			</div>
			<div class="form-group hidden">
				<label class="col-lg-4 control-label" for="pejabat">Pejabat Mengetahui</label>
				<div class="col-lg-6">
					<select class="form-control" id="id_pj" name="id_pj" required="required">
						<option value="">== Pilih Jabatan ==</option>
						<?php
						$sqlpj = $db_con->prepare("SELECT id_pj,jabatan FROM pejabattb ORDER BY nama ASC");
						$sqlpj->execute();
						while ($rowpj = $sqlpj->fetch(PDO::FETCH_ASSOC)) {
						?>
							<?php if ($rowpj['id_pj'] == 1) : ?>
								<option value="<?php echo $rowpj['id_pj']; ?>" selected><?php echo $rowpj['jabatan']; ?></option>
							<?php else : ?>
								<option value="<?php echo $rowpj['id_pj']; ?>"><?php echo $rowpj['jabatan']; ?></option>
							<?php endif; ?>
						<?php
						}
						?>
					</select>
				</div>
			</div>

		</div>
		<!-- /.box-body -->
		<div class="box-footer text-center">
			<button type="submit" class="btn btn-primary" name="btn-savex"><i class="fa fa-check-square-o"></i> Submit</button>&nbsp;&nbsp;
			<button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>
		</div>
		<!-- /.box-footer-->

		<input type="hidden" name="urut" value="<?php echo $nomorx; ?>">

	</form>

<?php
}
?>