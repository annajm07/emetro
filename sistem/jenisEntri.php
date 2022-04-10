<?php

define('_VALID_ACCESS',	true);

include_once"../inc/app.config.php"; include_once"../inc/app.core.php";

if (isset($_REQUEST['id'])) {

$id = intval(base64_decode($_REQUEST['id']));

?>

		<form id="entri-form" method="post" class="form-horizontal" action="<?php echo $urlweb;?>sistem.php?sistem=jenis">

		<div class="box-body">

			<div class="form-group">
					<label class="col-lg-4 control-label" for="nama">Nama Jenis</label>
					<div class="col-lg-7">
							<input type="text" id="nama" name="nama" class="form-control" maxlength="100" required="required">
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
