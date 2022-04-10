<?php if (!defined('_VALID_ACCESS')) {
    header("location: index.php");
    die;
}

session_start();

if (isset($_SESSION['user_session']) != "") {
    header("Location: sistem.php?sistem=home");
}

$tanggal = new tanggal;
$daftar = new Daftar($db_con);

if (isset($_POST['daftar'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];
    $password = md5($_POST['password'] . "syalim.com" . md5($_POST['password']));
    $jabatan = "Umum";
    $type = base64_encode($jabatan);
    $foto = "";
    $cfoto = "";
    $status = 0;
    $logdate = date('Y-m-d H:i:s');



    if ($daftar->create($email, $password, $nama, $jabatan, $telepon, $type, $foto, $cfoto, $status, $logdate)) {
        $_SESSION['daftar'] = true;
        header("location:$urlweb");
        die();
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

    <title>Daftar <?php echo $appname; ?></title>
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

<body class="hold-transition login-page" style="background: url(img/background.jpg) no-repeat center center fixed; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; min-height: 700px; ">
    <div class="login-box" style="width: 35% !important;">
        <div class="login-logo">
            <a href="<?php echo $urlweb; ?>"><b><?php echo $appname; ?></b></a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body" style="padding: 50px !important;">

            <p class="login-box-msg" style="font-size: 25px;"><i class="fa fa-user-plus"></i> DAFTAR</p>

            <form id="entri-form" method="post" class="form-horizontal" action="<?= $urlweb; ?>sistem.php?sistem=daftar">

                <div class="box-body">

                    <div class="form-group">
                        <label class=" control-label" for="nama">Nama</label>
                        <div class="">
                            <input type="text" id="nama" name="nama" class="form-control" maxlength="30" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class=" control-label" for="email">Email</label>
                        <div class="">
                            <input type="email" id="email" name="email" class="form-control" maxlength="30" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class=" control-label" for="nama">Telepon</label>
                        <div class="">
                            <input type="number" id="telepon" name="telepon" class="form-control" maxlength="30" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class=" control-label" for="password1">Password</label>
                        <div class="">
                            <input type="password" id="password" name="password" class="form-control" maxlength="30" required>
                        </div>
                    </div>


                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="daftar"><i class="fa fa-check-square-o"></i> Daftar</button>&nbsp;&nbsp;
                    <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>&nbsp;&nbsp;
                    <a class="btn btn-default" href="<?php echo $urlweb; ?>"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                </div>
                <!-- /.box-footer-->

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