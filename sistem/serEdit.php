<?php

define('_VALID_ACCESS',	true);

include_once"../inc/app.config.php"; include_once"../inc/app.core.php";

$tanggal = new tanggal;

if (isset($_REQUEST['id'])) {

$id = intval(base64_decode($_REQUEST['id']));
$sqledit = $db_con->prepare("SELECT * FROM sertifikattb WHERE pengukuran=:pid AND tum='0' ORDER BY id_sr DESC LIMIT 1");
$sqledit->execute(array(":pid"=>$id));
$rowedit=$sqledit->fetch(PDO::FETCH_ASSOC);

?>

		<form id="edit-form" method="post" class="form-horizontal" action="sistem.php?sistem=home&act=view&id=<?php print(base64_encode($id)); ?>">

		<div class="box-body">

			<div class="form-group">
					<label class="col-lg-4 control-label" for="tgl">Tanggal</label>
					<div class="col-lg-6">
							<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php if($rowedit['tgl'] <> "0000-00-00") { $tanggal->contanggalx(substr($rowedit['tgl'],8,2),substr($rowedit['tgl'],5,2),substr($rowedit['tgl'],0,4)); } else { echo ""; } ?>" disabled="">
					</div>
			</div>
			<div class="form-group">
					<label class="col-lg-4 control-label" for="nomor">Nomor SKHP</label>
					<div class="col-lg-8">
							<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $rowedit['nomor']; ?>" disabled="">
					</div>
			</div>
			<div class="form-group">
					<label class="col-lg-4 control-label" for="pejabat">Pejabat Mengetahui</label>
					<div class="col-lg-6">
						<select class="form-control" id="id_pj" name="id_pj" required="required">
								<?php
								$sqlpj = $db_con->prepare("SELECT id_pj,jabatan FROM pejabattb ORDER BY nama ASC");
								$sqlpj->execute();
								while($rowpj=$sqlpj->fetch(PDO::FETCH_ASSOC))
								{
								?>
								<option value="<?php echo $rowpj['id_pj']; ?>" <?php if($rowpj['id_pj'] == $rowedit['id_pj']) { echo"selected=selected"; } ?>><?php echo $rowpj['jabatan']; ?></option>
								<?php
								}
								?>
						</select>
					</div>
			</div>

		</div>
		<!-- /.box-body -->
		<div class="box-footer text-center">
			<button type="submit" class="btn btn-primary" name="btn-updatex"><i class="fa fa-check-square-o"></i> Update</button>&nbsp;&nbsp;
			<button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>
		</div>
		<!-- /.box-footer-->

		<input type="hidden" name="cid_sr" value="<?php echo $rowedit['id_sr']; ?>">

		</form>

<?php
	}
?>
