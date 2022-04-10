<?php

define('_VALID_ACCESS',	true);

include_once"../inc/app.config.php"; include_once"../inc/app.core.php";

$tanggal = new tanggal;


	if (isset($_REQUEST['id'])) {

		$id = intval(base64_decode($_REQUEST['id']));
		$sqledit = $db_con->prepare("SELECT * FROM usertb WHERE id_us=:uid ORDER BY id_us DESC LIMIT 1");
		$sqledit->execute(array(":uid"=>$id));
		$rowedit=$sqledit->fetch(PDO::FETCH_ASSOC);

		?>

		<form class="form-horizontal" id="edit-form" method="post" action="<?php echo $urlweb;?>sistem.php?sistem=account">

			<div class="form-group">
				<label class="control-label col-md-4">Alamat Email</label>
				<div class="col-md-6">
					<input type="text" id="imel" name="imel" class="form-control" maxlength="100" value="<?php echo $rowedit['imel']; ?>" required="required">
					<span id="check-e"></span>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-4">Nama Lengkap</label>
				<div class="col-md-8">
					<input type="text" id="nama" name="nama" class="form-control" maxlength="60" value="<?php echo $rowedit['nama']; ?>" required="required">
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-4">Jabatan</label>
				<div class="col-md-6">
					<input type="text" id="jabatan" name="jabatan" class="form-control" maxlength="90" value="<?php echo $rowedit['jabatan']; ?>" required="required">
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-4">Nomor HP/Telpon</label>
				<div class="col-md-6">
					<input type="text" id="telp" name="telp" class="form-control" maxlength="16" value="<?php echo $rowedit['telp']; ?>" required="required">
				</div>
			</div>

			<br>

			<div class="form-group">
				<label class="control-label col-md-4">Password Lama</label>
				<div class="col-md-6">
					<input type="password" id="pass0" maxlength="60" name="pass0" class="form-control" required="required">
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-4">Password Baru</label>
				<div class="col-md-6">
					<input type="password" id="pass1" maxlength="60" name="pass1" class="form-control" required="required">
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-4">Password Baru (Ulangi)</label>
				<div class="col-md-6">
					<input type="password" id="pass2" maxlength="60" name="pass2" class="form-control" required="required">
				</div>
			</div>

			<div class="box-footer text-center">
				<button type="submit" class="btn btn-primary" name="btn-update"><i class="fa fa-check-square-o"></i> Update</button>&nbsp;&nbsp;
				<button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>
			</div>

			<input type="hidden" name="cid_us" value="<?php echo $rowedit['id_us']; ?>" />

		</form>

		<?php
	}
?>
