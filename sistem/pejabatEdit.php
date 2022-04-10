<?php

define('_VALID_ACCESS',	true);

include_once"../inc/app.config.php"; include_once"../inc/app.core.php";

$tanggal = new tanggal;

$crudpejabat = new crudpejabat($db_con);


	if (isset($_REQUEST['id'])) {

		$id = intval(base64_decode($_REQUEST['id']));
		extract($crudpejabat->getID($id));

		?>

		<form id="edit-form" method="post" class="form-horizontal" action="<?php echo $urlweb;?>sistem.php?sistem=pejabat&act=view&id=<?php print($_REQUEST['id']); ?>">

			<div class="box-body">

				<div class="form-group">
						<label class="col-lg-4 control-label" for="jabatan">Jabatan</label>
						<div class="col-lg-7">
							<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $jabatan;?>" disabled="">
						</div>
				</div>
				<div class="form-group">
						<label class="col-lg-4 control-label" for="nama">Nama Pejabat</label>
						<div class="col-lg-7">
								<input type="text" id="nama" name="nama" class="form-control" value="<?php echo $nama;?>" maxlength="100" required="required">
						</div>
				</div>
				<div class="form-group">
						<label class="col-lg-4 control-label" for="nip">NIP</label>
						<div class="col-lg-5">
							<input type="text" id="nip" maxlength="30" name="nip" class="form-control" value="<?php echo $nip;?>" required="required">
						</div>
				</div>

			</div>
		<!-- /.box-body -->
		<div class="box-footer text-center">
			<button type="submit" class="btn btn-primary" name="btn-update"><i class="fa fa-check-square-o"></i> Update</button>&nbsp;&nbsp;
			<button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>
		</div>
		<!-- /.box-footer-->

		<input type="hidden" name="jabatan" value="<?php echo $jabatan;?>">

		</form>

		<?php
	}
?>
