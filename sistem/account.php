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

$atas = 'sistem/header.php';
if (file_exists($atas)) {
    include_once "$atas";
  } else {
    header("Location: error.php");
    die;
}

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
<script>
$(document).ready(function (e) {
	$("#form-foto").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
        	url: "sistem/uploadfoto.php",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			beforeSend : function()
			{
				//$("#preview").fadeOut();
				$("#err").fadeOut();
			},
			success: function(data)
		    {
				if(data=='invalid')
				{
					// invalid file format.
					$.notify({
						title: "File Foto Tidak Diijinkan. ",
						message: "Ganti Dengan Yang Lain.",
						icon: 'fa fa-warning'
					},{
						type: "danger"
					});

				}
				else
				{
					$.notify({
						title: "Terima Kasih. ",
						message: "Foto Akun Berhasil Diperbaharui.",
						icon: 'fa fa-check'
					},{
						type: "success"
					});
					// view uploaded file.
					$("#preview").html(data).fadeIn();
					$("#form")[0].reset();
				}
		    },
		  	error: function(e)
	    	{
				$("#err").html(e).fadeIn();
	    	}
	   });
	}));
});
</script>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-user"></i> Akun Ku
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

		<!-- Main content -->
		<section class="content">
		<?php

		if(isset($_POST['btn-update'])) {

		$pass0=$_POST['pass0'];
		$pass1=$_POST['pass1'];
		$pass2=$_POST['pass2'];
		$nama=$_POST['nama'];
		$jabatan=$_POST['jabatan'];
		$telp=$_POST['telp'];
		$imel=$_POST['imel'];
		$simel=strtolower($imel);
		$cid_us=$_POST['cid_us'];

		$key = "syalim.com";
		$pass0 = md5($pass0 . $key . md5($pass0));
		$pass1 = md5($pass1 . $key . md5($pass1));

		$cekpass0 = $db_con->prepare("SELECT pword FROM usertb WHERE id_us=:uid ORDER BY id_us DESC LIMIT 1");
		$cekpass0->execute(array(":uid"=>$cid_us));
		$rowpass0=$cekpass0->fetch(PDO::FETCH_ASSOC);

		if (trim($_POST['imel']) == '') {
				$error[] = "<i class=\"fa fa-times-circle\"></i> Alamat Email Masih Kosong";
		}

		if (!preg_match('|^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$|i', $simel)) {
				$error[] = "<i class=\"fa fa-times-circle\"></i> Penulisan Alamat Email belum benar";
		}

		if (trim($_POST['nama']) == '') {
				$error[] = "<i class=\"fa fa-times-circle\"></i> Nama Lengkap Masih Kosong";
		}

		if (trim($_POST['jabatan']) == '') {
				$error[] = "<i class=\"fa fa-times-circle\"></i> Jabatan Masih Kosong";
		}

		if (trim($_POST['telp']) == '') {
				$error[] = "<i class=\"fa fa-times-circle\"></i> Nomor HP/Telpon Masih Kosong";
		}

		if (trim($_POST['pass0']) == '') {
				$error[] = "<i class=\"fa fa-times-circle\"></i> Password Lama Belum Diisi";
		}

		if ($pass0 <> $rowpass0['pword']) {
				$error[] = "<i class=\"fa fa-times-circle\"></i> Password Lama Salah";
		}

		if (trim($_POST['pass1']) == '') {
				$error[] = "<i class=\"fa fa-times-circle\"></i> Password Baru Belum Diisi";
		}

		if (trim($_POST['pass2']) == '') {
				$error[] = "<i class=\"fa fa-times-circle\"></i> Password Baru (Ulangi) Belum Diisi";
		}

		if ($_POST['pass1'] <> $_POST['pass2']) {
				$error[] = "<i class=\"fa fa-times-circle\"></i> Password Baru dan Ulangi Password Tidak Sama";
		}

		if (isset($error)) { $error = $error; } else { $error = ""; }

		if ($error <> '') {
				echo "<div class=\"alert alert-warning alert-dismissible\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button><h4>Update Data Akun Gagal Dilakukan ...</h4>".implode('<br />', $error)."<br></div>";
		} else {

			$sqlupdate = $db_con->prepare("UPDATE usertb SET imel=:imel, pword=:pword, nama=:nama, jabatan=:jabatan, telp=:telp WHERE id_us=:id");
			$sqlupdate->bindParam(":imel", $simel);
			$sqlupdate->bindParam(":pword", $pass1);
			$sqlupdate->bindParam(":nama", $nama);
			$sqlupdate->bindParam(":jabatan", $jabatan);
			$sqlupdate->bindParam(":telp", $telp);
			$sqlupdate->bindParam(":id", $cid_us);

		if($sqlupdate->execute())	{
				?>
				<script type="text/javascript">
		      	$.notify({
		      		title: "Oke... ",
		      		message: "Update Data Akun Anda Berhasil Dilakukan!",
		      		icon: 'fa fa-check'
		      	},{
		      		type: "success"
		      	});
		    </script>
				<?php
		}
		else {
				echo "<div class=\"alert alert-warning alert-dismissible\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button><h4>Update Data Gagal Dilakukan...</h4>Terjadi kegagalan penyimpanan data ke database<br></div>";
		}

		}

		}

		$sqlview = $db_con->prepare("SELECT * FROM usertb WHERE id_us=:uid ORDER BY id_us DESC LIMIT 1");
		$sqlview->execute(array(":uid"=>$_SESSION['user_session']));
		$rowview=$sqlview->fetch(PDO::FETCH_ASSOC);

		?>

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Informasi Akun</h3>
        </div>

				<form class="form-horizontal" id="form-foto" method="post" enctype="multipart/form-data">

        <div class="box-body">

									<div class="form-group">
										<label class="control-label col-md-3">Alamat Email</label>
										<div class="col-md-4">
											<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $rowview['imel']; ?>" disabled="">
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3">Nama Lengkap</label>
										<div class="col-md-6">
											<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $rowview['nama']; ?>" disabled="">
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3">Jabatan</label>
										<div class="col-md-4">
											<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $rowview['jabatan']; ?>" disabled="">
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3">Nomor HP/Telpon</label>
										<div class="col-md-4">
											<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $rowview['telp']; ?>" disabled="">
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3">Hak Akses</label>
										<div class="col-md-4">
											<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo strtoupper(base64_decode($rowview['type'])); ?>" disabled="">
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3">Terdaftar</label>
										<div class="col-md-4">
											<input type="text" id="disabled-input" name="disabled-input" class="form-control" value="<?php echo $tanggal->time_since(strtotime($rowview['logdate']));?>" disabled="">
										</div>
									</div>

									<br>

									<div class="form-group">
										<label class="control-label col-md-3">Foto Akun</label>
										<div class="col-md-8">
											<?php
											if($rowview['foto'] <> '') {
													echo "<div id=\"preview\"><img src=\"".$urlweb."up/user/".$rowview['cfoto']."\" alt=\"\"></div>";
											} else {
													echo "<div id=\"preview\"><img src=\"".$urlweb."img/no-image.jpg\" alt=\"\"></div>";
											}
											?>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3"></label>
										<div class="col-md-8">
											<div id="err"></div>
										</div>
									</div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
					<div class="fileContainer">
						<i class="fa fa-camera"></i> Ganti Foto Akun
						<input id="uploadImage" type="file" accept="image/*" name="image" />
					</div>
					&nbsp;&nbsp;
					<button class="btn btn-primary" data-toggle="modal" data-target="#edit-modal" data-id="<?php print(base64_encode($rowview['id_us'])); ?>" id="accountEdit"><i class="fa fa-edit"></i> Edit Informasi Akun</button>
        </div>
        <!-- /.box-footer-->

				<input type="hidden" name="cid_us" value="<?php echo $rowview['id_us']; ?>" />

				<script>
					$('#uploadImage').change(function() {
						$('#form-foto').submit();
					});
				</script>

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
                            	<i class="fa fa-edit"></i> Edit Informasi Akun
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

					$(document).on('click', '#accountEdit', function(e){

						e.preventDefault();

						var uid = $(this).data('id');   // it will get id of clicked row

						$('#dynamic-content').html(''); // leave it blank before ajax call
						$('#modal-loader').show();      // load ajax loader

						$.ajax({
							url: 'sistem/accountEdit.php',
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
