<?php
if(!defined('_VALID_ACCESS')) { header ("location: index.php"); die; }

session_start();

if(!isset($_SESSION['user_session']))
{
	header("location:sistem.php?sistem=login&x=");
	die;
}

$stmt = $db_con->prepare("SELECT * FROM usertb WHERE id_us=:uid ORDER BY id_us DESC LIMIT 1");
$stmt->execute(array(":uid"=>$_SESSION['user_session']));
$rowuser=$stmt->fetch(PDO::FETCH_ASSOC);

$tanggal = new tanggal;

$crudpejabat = new crudpejabat($db_con);

$atas = 'sistem/header.php';
  if (file_exists($atas)) {
      include_once "$atas";
    } else {
      header("Location: error.php");
      die;
  }

$mytahun = date('Y');

if (isset($_GET["act"])) {
	      $act = $_GET["act"];
	} else {
	      $act = "";
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

<script type="text/javascript" src="<?php echo $urlweb;?>js/bootstrap-notify.min.js"></script>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-folder-o"></i> Data Pejabat
        <small><?php echo $appnames;?></small>
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

		<?php

		if(base64_decode($rowuser['type']) == "admin") {

	if($act == "view") {

	?>
	<!-- Main content -->
	<section class="content">

		<?php

		if(isset($_POST['btn-update']))
		{
			$id = base64_decode($_GET['id']);
			$nama = $_POST['nama'];
			$nip = $_POST['nip'];
			$jabatan = $_POST['jabatan'];

			if (trim($_POST['jabatan']) == '') {
				$error[] = "<i class=\"fa fa-times-circle\"></i> Jabatan Masih Kosong";
			}

			if (trim($_POST['nama']) == '') {
				$error[] = "<i class=\"fa fa-times-circle\"></i> Nama Pejabat Masih Kosong";
			}

			if (trim($_POST['nip']) == '') {
				$error[] = "<i class=\"fa fa-times-circle\"></i> NIP Masih Kosong";
			}

			if (isset($error)) { $error = $error; } else { $error = ""; }

			if ($error <> '') {
				echo "<div class=\"alert alert-warning alert-dismissible\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button><h4>Update Data Pejabat Gagal Dilakukan...</h4>".implode('<br />', $error)."<br><br>Silakan Di Ulangi Lagi.</div>";
			} else {

				if($crudpejabat->update($id,$nama,$jabatan,$nip))	{
					?>
					<script type="text/javascript">
			      	$.notify({
			      		title: "Sukses... ",
			      		message: "Update Data Pejabat Berhasil Dilakukan!",
			      		icon: 'fa fa-check'
			      	},{
			      		type: "success"
			      	});
			    </script>
					<?php
				}	else {
					echo "<div class=\"alert alert-warning alert-dismissible\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button><h4>Update Data Pejabat Gagal Dilakukan...</h4>Terjadi kegagalan penyimpanan data ke database<br><br>Silakan Di Ulangi Lagi.</div>";
				}
			}
		}


		if(isset($_GET['id']))
		{
			$id = base64_decode($_GET['id']);
			extract($crudpejabat->getID($id));
		}
	?>

		<!-- Default box -->
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">View Data Pejabat</h3>
			</div>
			<form id="edit-form" method="post" class="form-horizontal">

			<div class="box-body">

				<div class="form-group">
						<label class="col-lg-3 control-label" for="jabatan">Jabatan</label>
						<div class="col-lg-7">
								<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $jabatan;?>" disabled="">
						</div>
				</div>
				<div class="form-group">
						<label class="col-lg-3 control-label" for="nama">Nama Pejabat</label>
						<div class="col-lg-7">
								<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $nama;?>" disabled="">
						</div>
				</div>
				<div class="form-group">
						<label class="col-lg-3 control-label" for="nip">NIP</label>
						<div class="col-lg-3">
							<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $nip;?>" disabled="">
						</div>
				</div>

			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<button class="btn btn-primary" data-toggle="modal" data-target="#edit-modal" data-id="<?php print(base64_encode($id_pj)); ?>" id="pejabatEdit"><i class="fa fa-edit"></i> Edit Data Pejabat</button>&nbsp;&nbsp;
				<a class="btn btn-default" href="<?php echo $urlweb;?>sistem.php?sistem=pejabat"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
			</div>
			<!-- /.box-footer-->

			</form>

		</div>
		<!-- /.box -->

	</section>
	<!-- /.content -->

	<div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true" style="display: none;">
					 <div class="modal-dialog">
								<div class="modal-content">

										 <div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
													<h4 class="modal-title">
														<i class="fa fa-edit"></i> Edit Data Pejabat
													</h4>
										 </div>
										 <div class="modal-body">

												 <div id="modal-loader" style="display: none; text-align: center;">
													<img src="<?php echo $urlweb;?>img/eloading.gif">
												 </div>

												 <!-- content will be load here -->
												 <div id="dynamic-content"></div>

											</div>
											<div class="modal-footer">

											</div>

							 </div>
						</div>
		 </div><!-- /.modal -->

		 <script>
			$(document).ready(function(){

				$(document).on('click', '#pejabatEdit', function(e){

					e.preventDefault();

					var uid = $(this).data('id');   // it will get id of clicked row

					$('#dynamic-content').html(''); // leave it blank before ajax call
					$('#modal-loader').show();      // load ajax loader

					$.ajax({
						url: 'sistem/pejabatEdit.php',
						type: 'POST',
						data: 'id='+uid,
						dataType: 'html'
					})
					.done(function(data){
						console.log(data);
						$('#dynamic-content').html('');
						$('#dynamic-content').html(data); // load response
						$('#modal-loader').hide();		  // hide ajax loader
					})
					.fail(function(){
						$('#dynamic-content').html('<i class="fa fa-warning"></i> Kesalahan sistem.. Silakan ulangi lagi...');
						$('#modal-loader').hide();
					});

				});

			});

		</script>


					<?php } else { ?>


						<!-- Main content -->
				    <section class="content">

				      <!-- Default box -->
				      <div class="box">
				        <div class="box-header with-border">
				          <h3 class="box-title">Daftar Pejabat</h3>
				        </div>
				        <div class="box-body">

								<div class="table-responsive">
								<table class="table table-hover">
									<thead>
											<tr>
												<th>No.</th>
												<th>Jabatan</th>
												<th>Nama Pejabat</th>
												<th>NIP</th>
												<th>&nbsp;</th>
											</tr>
									</thead>

									<tbody>

									<?php
										$query = "SELECT * FROM pejabattb ORDER BY id_pj ASC";
										$records_per_page=10;
										$newquery = $crudpejabat->paging($query,$records_per_page);
										$crudpejabat->dataview($newquery,$records_per_page);
									?>

									</tbody>
								</table>
								</div>

								<div class="pagination-wrap">
								<?php
								$self = "sistem.php?sistem=pejabat";

								$stmt = $db_con->prepare($query);
								$stmt->execute();

								$total_no_of_records = $stmt->rowCount();

								$mypagination = 'inc/app.pagination.php';
								if (file_exists($mypagination)) {
									 include_once "$mypagination";
								}
								?>
								</div>

				        </div>
				        <!-- /.box-body -->
				        <div class="box-footer">
				          *Lakukan perubahan data pejabat sesuai kebutuhan saja.
				        </div>
				        <!-- /.box-footer-->
				      </div>
				      <!-- /.box -->

				    </section>
				    <!-- /.content -->

					<?php } } else { ?>

						<!-- Main content -->
						<section class="content">

							<div class="error-page">
								<h2 class="headline text-red"><i class="fa fa-warning text-red"></i></h2>

								<div class="error-content">
									<h3>Uups! Terjadi Kesalahan Sistem.</h3>

									<p>Akun Anda tidak memiliki akses terhadap modul ini.</p>

									<p><a class="btn btn-primary" href="javascript:window.history.back();">Kembali</a></p>

								</div>
							</div>
							<!-- /.error-page -->

						</section>
						<!-- /.content -->

				<?php } ?>

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
