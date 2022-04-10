<?php if (!defined('_VALID_ACCESS')) {
    header("location: index.php");
    die;
}

session_start();

if (isset($_SESSION['user_session']) != "") {
    header("Location: sistem.php?sistem=home");
}

$tanggal = new tanggal;

$keluhan = new Keluhan($db_con);

if (isset($_POST['kirim'])) {
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $logtime = date('Y-m-d H:i:s');

    if ($keluhan->create($judul, $isi, $logtime)) {
        $pesan = '<div class="alert alert-success alert-dismissible text-center" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Data Keluhan Berhasil Ditambahkan!</strong></div>';
    }
}


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
    <div class="login-box" style="width: 70% !important;">
        <div class="login-logo">
            <a href="<?php echo $urlweb; ?>"><b><?php echo $appname; ?></b></a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body" style="padding: 50px !important;">
            <?php if (isset($pesan)) {
                echo $pesan;
            } ?>
            <p class="login-box-msg" style="font-size: 25px;"><i class="fa fa-paper-plane"></i> Form Keluhan</p>

            <form class="login-form" method="post" id="login-form" action="<?= $urlweb; ?>sistem.php?sistem=keluhan">
                <div class="form-group has-feedback">
                    <label class="control-label">JUDUL</label>
                    <input type="text" class="form-control" placeholder="judul keluhan" name="judul" id="judul" autofocus required>
                    <span id="check-e"></span>
                </div>
                <div class="form-group has-feedback">
                    <label class="control-label">ISI</label>
                    <textarea class="form-control" rows="5" name="isi" id="isi" required placeholder="isi keluhan"></textarea>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="kirim"><i class="fa fa-check-square-o"></i> Kirim</button>&nbsp;&nbsp;
                    <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>&nbsp;&nbsp;
                    <a class="btn btn-default" href="<?php echo $urlweb; ?>"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
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

</html>