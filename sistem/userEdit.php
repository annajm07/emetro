<?php

define('_VALID_ACCESS',	true);

include_once "../inc/app.config.php";
include_once "../inc/app.core.php";

$tanggal = new tanggal;

$cruduser = new cruduser($db_con);


if (isset($_REQUEST['id'])) {

	$id = intval(base64_decode($_REQUEST['id']));
	extract($cruduser->getID($id));

?>

	<form id="edit-form" method="post" class="form-horizontal" action="<?php echo $urlweb; ?>sistem.php?sistem=user&act=view&id=<?php print($_REQUEST['id']); ?>">

		<div class="box-body">

			<div class="form-group">
				<label class="col-lg-4 control-label" for="imel">Alamat Email</label>
				<div class="col-lg-6">
					<input type="text" id="imel" name="imel" class="form-control" value="<?php echo $imel; ?>" maxlength="100" required="required">
					<span id="check-e"></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-4 control-label" for="nama">Nama Lengkap</label>
				<div class="col-lg-8">
					<input type="text" id="nama" name="nama" class="form-control" value="<?php echo $nama; ?>" maxlength="60" required="required">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-4 control-label" for="jabatan">Jabatan</label>
				<div class="col-lg-6">
					<input type="text" id="jabatan" name="jabatan" class="form-control" value="<?php echo $jabatan; ?>" maxlength="90" required="required">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-4 control-label" for="telp">Nomor Telpon</label>
				<div class="col-lg-6">
					<input type="text" id="telp" name="telp" class="form-control" value="<?php echo $telp; ?>" maxlength="16" required="required">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-4 control-label" for="pass">Password</label>
				<div class="col-lg-6">
					<input type="password" id="pass" maxlength="60" name="pass" class="form-control" required="required">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-4 control-label">Hak Akses</label>
				<div class="col-lg-6">
					<select id="role" name="role" class="form-control" required="required">
						<option value="kasubag" <?php if (base64_decode($type) == "kasubag") {
													echo "selected=selected";
												} ?>>Kasubag</option>
						<option value="kepala_uptd" <?php if (base64_decode($type) == "kepala_uptd") {
														echo "selected=selected";
													} ?>>Kepala UPTD</option>
						<option value="admin" <?php if (base64_decode($type) == "admin") {
													echo "selected=selected";
												} ?>>Admin</option>
					</select>
				</div>
			</div>

		</div>
		<!-- /.box-body -->
		<div class="box-footer text-center">
			<button type="submit" class="btn btn-primary" name="btn-update"><i class="fa fa-check-square-o"></i> Update</button>&nbsp;&nbsp;
			<button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>
		</div>
		<!-- /.box-footer-->

	</form>

<?php
}
?>