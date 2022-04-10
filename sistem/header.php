<?php if(!defined('_VALID_ACCESS')) { header ("location: index.php"); die; }

$tanggal = new tanggal;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="<?php echo $webdesc;?>">
	<meta name="author" content="<?php echo $appvendor;?>">
	<meta name="keyword" content="<?php echo $webkeyword;?>">
	<link rel="icon" type="image/x-icon" href="<?php echo $urlweb;?>img/favicon.ico" />
  <title><?php echo $adminname;?> <?php echo $webtitle;?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo $urlweb;?>css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $urlweb;?>css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo $urlweb;?>css/ionicons.min.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?php echo $urlweb;?>css/bootstrap-datepicker.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $urlweb;?>css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the <?php echo $urlweb;?>css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo $urlweb;?>css/_all-skins.min.css">
  <!-- plusplus -->
  <link rel="stylesheet" href="<?php echo $urlweb;?>css/plusplus.css">

  <!-- jQuery 3 -->
  <script type="text/javascript" src="<?php echo $urlweb;?>js/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script type="text/javascript" src="<?php echo $urlweb;?>js/bootstrap.min.js"></script>
  <!-- bootstrap datepicker -->
  <script type="text/javascript" src="<?php echo $urlweb;?>js/bootstrap-datepicker.min.js"></script>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <script type="text/javascript">
			$(document).ready(function () {

				$('#tgl').datepicker({
					format: "dd/mm/yyyy"
				});

        $('#berlaku').datepicker({
					format: "dd/mm/yyyy"
				});

			});
	</script>

  <script type="text/javascript">
			function tandaPemisahTitik(b){
			var _minus = false;
			if (b<0) _minus = true;
			b = b.toString();
			b=b.replace(".","");

			c = "";
			panjang = b.length;
			j = 0;
			for (i = panjang; i > 0; i--){
				 j = j + 1;
				 if (((j % 3) == 1) && (j != 1)){
				   c = b.substr(i-1,1) + "." + c;
				 } else {
				   c = b.substr(i-1,1) + c;
				 }
				}
				if (_minus) c = "-" + c ;
				return c;
			}

			function numbersonly(ini, e){
				if (e.keyCode>=49){
					if(e.keyCode<=57){
					a = ini.value.toString().replace(".","");
					b = a.replace(/[^\d]/g,"");
					b = (b=="0")?String.fromCharCode(e.keyCode):b + String.fromCharCode(e.keyCode);
					ini.value = tandaPemisahTitik(b);
					return false;
					}
					else if(e.keyCode<=105){
						if(e.keyCode>=96){
							//e.keycode = e.keycode - 47;
							a = ini.value.toString().replace(".","");
							b = a.replace(/[^\d]/g,"");
							b = (b=="0")?String.fromCharCode(e.keyCode-48):b + String.fromCharCode(e.keyCode-48);
							ini.value = tandaPemisahTitik(b);
							//alert(e.keycode);
							return false;
							}
						else {return false;}
					}
					else {
						return false; }
					} else if (e.keyCode==48){
						a = ini.value.replace(".","") + String.fromCharCode(e.keyCode);
						b = a.replace(/[^\d]/g,"");
						if (parseFloat(b)!=0){
							ini.value = tandaPemisahTitik(b);
							return false;
						} else {
							return false;
						}
					} else if (e.keyCode==95){
						a = ini.value.replace(".","") + String.fromCharCode(e.keyCode-48);
						b = a.replace(/[^\d]/g,"");
						if (parseFloat(b)!=0){
							ini.value = tandaPemisahTitik(b);
							return false;
						} else {
							return false;
						}
					} else if (e.keyCode==8 || e.keycode==46){
						a = ini.value.replace(".","");
						b = a.replace(/[^\d]/g,"");
						b = b.substr(0,b.length -1);
						if (tandaPemisahTitik(b)!=""){
							ini.value = tandaPemisahTitik(b);
						} else {
							ini.value = "";
						}

						return false;
					} else if (e.keyCode==9){
						return true;
					} else if (e.keyCode==17){
						return true;
					} else {
						//alert (e.keyCode);
						return false;
					}

			}
			</script>

      <script type="text/javascript">

        function showDetails(cetakURL){
           window.open(cetakURL,"cetakDetails","width=1000, height=800, menubar=yes, location=yes, scrollbars=yes, resizeable=yes, status=yes, copyhistory=no, toolbar=no");
        }

        function showDetailsx(cetakURLx){
           window.open(cetakURLx,"cetakDetailsx","width=1400, height=800, menubar=yes, location=yes, scrollbars=yes, resizeable=yes, status=yes, copyhistory=no, toolbar=no");
        }

        function showDetailsxx(cetakURLxx){
           window.open(cetakURLxx,"cetakDetailsxx","width=4000, height=800, menubar=yes, location=yes, scrollbars=yes, resizeable=yes, status=yes, copyhistory=no, toolbar=no");
        }

      </script>

</head>
<body class="hold-transition skin-black sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo $urlweb;?>sistem.php?sistem=home" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>M</b>S</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b><?php echo $appname;?></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <?php
                if($rowuser['cfoto'] <> '') {
                  echo "<img src=\"".$urlweb."up/user/".$rowuser['cfoto']."\" class=\"user-image\" alt=\"\">";
                } else {
                  echo "<img src=\"".$urlweb."img/user.png\" class=\"user-image\" alt=\"\">";
                }
              ?>
              <span class="hidden-xs"><?php echo $rowuser['nama']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <?php
                  if($rowuser['cfoto'] <> '') {
                    echo "<img src=\"".$urlweb."up/user/".$rowuser['cfoto']."\" class=\"img-circle\" alt=\"\">";
                  } else {
                    echo "<img src=\"".$urlweb."img/user.png\" class=\"img-circle\" alt=\"\">";
                  }
                ?>

                <p>
                  <?php echo $rowuser['nama']; ?>
                  <small><?php echo $rowuser['jabatan']; ?></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo $urlweb;?>sistem.php?sistem=account" class="btn btn-default btn-flat"><i class="fa fa-user fa-lg"></i> Akun Ku</a>
                </div>
                <div class="pull-right">
                  <a href="#" data-toggle="modal" data-target="#logoutmodal" class="btn btn-default btn-flat"><i class="fa fa-power-off fa-lg"></i> Logout</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->

        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->
