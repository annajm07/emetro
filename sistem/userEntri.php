<?php

define('_VALID_ACCESS',	true);

include_once "../inc/app.config.php";
include_once "../inc/app.core.php";

$tanggal = new tanggal;

if (isset($_REQUEST['id'])) {

	$id = intval(base64_decode($_REQUEST['id']));

?>

	<form id="entri-form" method="post" class="form-horizontal" action="<?php echo $urlweb; ?>sistem.php?sistem=user">

		<div class="box-body">

			<div class="form-group">
				<label class="col-lg-4 control-label" for="imel">Alamat Email</label>
				<div class="col-lg-6">
					<input type="text" id="imel" name="imel" class="form-control" maxlength="100" required="required">
					<span id="check-e"></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-4 control-label" for="nama">Nama Lengkap</label>
				<div class="col-lg-6">
					<input type="text" id="nama" name="nama" class="form-control" maxlength="60" required="required">
				</div>
			</div>
			<!-- <div class="form-group">
				<label class="col-lg-4 control-label" for="jabatan">Jabatan</label>
				<div class="col-lg-6">
					<input type="text" id="jabatan" name="jabatan" class="form-control" maxlength="90" required="required">
				</div>
			</div> -->
			<div class="form-group">
				<label class="col-lg-4 control-label">Jabatan</label>
				<div class="col-lg-6">
					<select id="jabatan" name="jabatan" class="form-control" required="required">
						<option value="">= Pilih Jabatan =</option>
						<option value="Kasubag">Kasubag</option>
						<option value="Kepala UPTD">Kepala UPTD</option>
						<option value="admin">Admin</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-4 control-label" for="telp">Nomor Telpon</label>
				<div class="col-lg-6">
					<input type="text" id="telp" name="telp" class="form-control" maxlength="16" required="required">
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
						<option value="">= Pilih Hak Akses =</option>
						<option value="kasubag">Kasubag</option>
						<option value="kepala_uptd">Kepala UPTD</option>
						<option value="admin">Admin</option>
					</select>
				</div>
			</div>

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