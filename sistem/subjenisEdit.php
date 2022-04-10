<?php

define('_VALID_ACCESS',	true);

include_once"../inc/app.config.php"; include_once"../inc/app.core.php";

$tanggal = new tanggal;

$crudsubjenis = new crudsubjenis($db_con);


	if (isset($_REQUEST['id'])) {

		$id = intval(base64_decode($_REQUEST['id']));
		extract($crudsubjenis->getID($id));

		?>

		<form id="edit-form" method="post" class="form-horizontal" action="<?php echo $urlweb;?>sistem.php?sistem=subjenis&act=view&id=<?php print($_REQUEST['id']); ?>">

			<div class="box-body">

				<div class="form-group">
						<label class="col-lg-4 control-label" for="jenis">Jenis</label>
						<div class="col-lg-7">
							<select class="form-control" id="id_jn" name="id_jn" required="required">
									<?php
									$sqljn = $db_con->prepare("SELECT id_jn,nama FROM jenistb ORDER BY nama ASC");
									$sqljn->execute();
									while($rowjn=$sqljn->fetch(PDO::FETCH_ASSOC))
									{
									?>
									<option value="<?php echo $rowjn['id_jn']; ?>" <?php if($rowjn['id_jn'] == $id_jn) { echo"selected=selected"; } ?>><?php echo $rowjn['nama']; ?></option>
									<?php
									}
									?>
							</select>
						</div>
				</div>
				<div class="form-group">
						<label class="col-lg-4 control-label" for="nama">Nama Sub Jenis</label>
						<div class="col-lg-7">
								<input type="text" id="nama" name="nama" class="form-control" value="<?php echo $nama;?>" maxlength="100" required="required">
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
