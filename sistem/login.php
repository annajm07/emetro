<?php if (!defined('_VALID_ACCESS')) {
	header("location: index.php");
	die;
}

session_start();

if (isset($_SESSION['user_session']) != "") {
	header("Location: sistem.php?sistem=home");
}

$tanggal = new tanggal;

// create captcha
$a = rand(0, 9);
$b = rand(0, 9);
$c = $a + $b;
// end capctha
?>
<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="<?php echo $webdesc; ?>">
	<meta name="author" content="<?php echo $appvendor; ?>">
	<meta name="keyword" content="<?php echo $webkeyword; ?>">
	<link rel="icon" type="image/x-icon" href="<?php echo $urlweb; ?>img/favicon.ico" />

	<title>Login <?php echo $appname; ?></title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="<?php echo $urlweb; ?>css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo $urlweb; ?>css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="<?php echo $urlweb; ?>css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo $urlweb; ?>css/AdminLTE.min.css">
	<!-- plusplus -->
	<link rel="stylesheet" href="<?php echo $urlweb; ?>css/plusplus.css">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>

<body class="hold-transition login-page" style="background: url(img/background.jpg) no-repeat center center fixed; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;">
	<div class="login-box">
		<div class="login-logo">
			<a href="<?php echo $urlweb; ?>"><b><?php echo $appname; ?></b></a>
		</div>
		<!-- /.login-logo -->
		<div class="login-box-body">
			<p class="login-box-msg"><i class="fa fa-lock"></i> Login <?php echo $adminname; ?></p>

			<form class="login-form" method="post" id="login-form">
				<div class="form-group has-feedback">
					<label class="control-label">EMAIL</label>
					<input type="email" class="form-control" placeholder="Email Anda" name="user_email" id="user_email" autofocus>
					<span id="check-e"></span>
				</div>
				<div class="form-group has-feedback">
					<label class="control-label">PASSWORD</label>
					<input type="password" class="form-control" placeholder="Password Anda" name="password" id="password" />
				</div>
				<div class="form-group has-feedback">
					<label class="control-label" style="font-size: 16px;"><?= $a; ?> + <?= $b; ?></label>
					<input type="text" class="form-control" placeholder="Total" name="captcha" id="captcha" autocomplete="">
					<!-- kirim hasil -->
					<input type="hidden" name="hasil" id="hasil" value="<?= $c; ?>">
					<!-- end hasil -->
				</div>
				<div class="row">
					<div class="col-xs-4">
						<div class="checkbox">
							<a href="<?php echo $urlweb; ?>index.php"><i class="fa fa-search"></i> Cari</a>
						</div>
					</div>
					<div class="col-xs-8">
						<button type="submit" class="btn btn-primary btn-block" name="btn-login" id="btn-login">
							<i class="fa fa-sign-in"></i> &nbsp;Login
						</button>
					</div>
					<!-- /.col -->
				</div>
			</form>

		</div>
		<!-- /.login-box-body -->
	</div>
	<!-- /.login-box -->

	<!-- jQuery 3 -->
	<script type="text/javascript" src="<?php echo $urlweb; ?>js/jquery.min.js"></script>
	<!-- Bootstrap 3.3.7 -->
	<script type="text/javascript" src="<?php echo $urlweb; ?>js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo $urlweb; ?>js/validation.min.js"></script>
	<script type="text/javascript" src="<?php echo $urlweb; ?>js/bootstrap-notify.min.js"></script>
	<script>
		$('document').ready(function() {
			/* validation */
			$("#login-form").validate({
				rules: {
					password: {
						required: true,
					},
					user_email: {
						required: true,
						email: true
					},
					captcha: {
						required: true
					}
				},
				messages: {
					password: {
						required: "inputkan password anda."
					},
					user_email: {
						required: "inputkan akun email anda.",
						email: "format penulisan email tidak benar."
					},
					captcha: {
						required: "inputkan total"
					}
				},
				submitHandler: submitForm
			});
			/* validation */

			/* login submit */
			function submitForm() {
				var data = $("#login-form").serialize();
				console.log(data);

				$.ajax({

					type: 'POST',
					url: 'sistem.php?sistem=periksa',
					data: data,
					beforeSend: function() {
						$("#error").fadeOut();
						$("#btn-login").html('<i class="fa fa-exchange"></i> &nbsp; Di Periksa...');
					},
					success: function(response) {
						console.log(response);
						if (response == "ok") {
							$("#btn-login").html('<img src="img/waiting.gif" /> &nbsp; Di Proses...');
							setTimeout(' window.location.href = "sistem.php?sistem=home"; ', 200);

						} else if (response == "false") {

							$("#captcha").val('');
							$("#btn-login").html('<i class="fa fa-sign-in"></i> &nbsp; Login');
						} else {

							$.notify({
								title: "Gagal Login. ",
								message: "Email atau Password Tidak Terdaftar.",
								icon: 'fa fa-remove'
							}, {
								type: "danger"
							});
							$("#btn-login").html('<i class="fa fa-sign-in"></i> &nbsp; Login');

						}
					}
				});
				return false;
			}
			/* login submit */
		});
	</script>
	<?php
	if (isset($_GET['x'])) {
		//pesan kesalahan
		$x = base64_decode($_GET['x']);
		if ($x == 84) {
	?>
			<script type="text/javascript">
				$.notify({
					title: "Terima Kasih. ",
					message: "Anda Telah Berhasil Logout.",
					icon: 'fa fa-check'
				}, {
					type: "success"
				});
			</script>
		<?php
		} else {
		?>
			<script type="text/javascript">
				$.notify({
					title: "Session Telah Expired. ",
					message: "Silakan Login Kembali.",
					icon: 'fa fa-warning'
				}, {
					type: "warning"
				});
			</script>
	<?php
		}
	}
	?>
</body>

</html>