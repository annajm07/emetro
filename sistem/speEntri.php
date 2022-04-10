<?php

define('_VALID_ACCESS',	true);

include_once "../inc/app.config.php";
include_once "../inc/app.core.php";

if (isset($_REQUEST['id'])) {

	$id = intval(base64_decode($_REQUEST['id']));

	$qspbu = $db_con->prepare("SELECT spbu,notaksi FROM alattb WHERE id_al=:al");
	$qspbu->execute(array(":al" => $id));
	$rowq = $qspbu->fetch(PDO::FETCH_ASSOC);

?>

	<form id="entri-form" method="post" class="form-horizontal" action="sistem.php?sistem=home&act=view&id=<?php print(base64_encode($id)); ?>">

		<div class="box-body">

			<div class="form-group">
				<label class="col-lg-4 control-label" for="merek">Merk</label>
				<div class="col-lg-6">
					<input type="text" id="merek" name="merek" class="form-control" maxlength="100" required="required">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-4 control-label" for="buatan">Buatan</label>
				<div class="col-lg-6">
					<input type="text" id="buatan" name="buatan" class="form-control" maxlength="100" required="required">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-4 control-label" for="seri">No. Seri</label>
				<div class="col-lg-6">
					<input type="text" id="seri" name="seri" class="form-control" maxlength="100" required="required">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-4 control-label" for="tipe">Type</label>
				<div class="col-lg-6">
					<input type="text" id="tipe" name="tipe" class="form-control" maxlength="100" required="required">
				</div>
			</div>
			<?php if ($rowq['notaksi'] <> '') {
				echo "<input type=\"hidden\" name=\"kapasitas\" value=\"\"><input type=\"hidden\" name=\"jenis\" value=\"\">";
			} else { ?>
				<?php if ($rowq['spbu'] <> '') { ?>
					<div class="form-group">
						<label class="col-lg-4 control-label" for="jenis">Jenis BBM</label>
						<div class="col-lg-6">
							<input type="text" id="jenis" name="jenis" class="form-control" maxlength="100" required="required">
						</div>
					</div>
					<input type="hidden" name="kapasitas" value="">
				<?php } else { ?>
					<div class="form-group">
						<label class="col-lg-4 control-label" for="kapasitas">Kapasitas</label>
						<div class="col-lg-6">
							<input type="text" id="kapasitas" name="kapasitas" class="form-control" maxlength="100" required="required">
						</div>
					</div>
					<input type="hidden" name="jenis" value="">
				<?php } ?>
			<?php } ?>

		</div>
		<!-- /.box-body -->
		<div class="box-footer text-center">
			<button type="submit" class="btn btn-primary" name="btn-save"><i class="fa fa-check-square-o"></i> Submit</button>&nbsp;&nbsp;
			<button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>
		</div>
		<!-- /.box-footer-->

	</form>

<?php
}
?>