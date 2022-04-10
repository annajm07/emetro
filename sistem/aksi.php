<?php
if(!defined('_VALID_ACCESS')) { header ("location: index.php"); die; }

session_start();

if(!isset($_SESSION['user_session']))
{
	header("location:sistem.php?sistem=login&x=");
	die;
}

$id = base64_decode($_GET['id']);

//user
if($_GET['mod'] == 'user')
{
	if($_GET['act'] == 'aktif') {

		$status = 1;
		$cruduser = new cruduser($db_con);
		if($cruduser->status($id,$status) == true) {
			header("location: sistem.php?sistem=user&act=view&id=".$_GET['id']."");
			die;
		}
	}
	elseif($_GET['act'] == 'nonaktif') {

		$status = 0;
		$cruduser = new cruduser($db_con);
		if($cruduser->status($id,$status) == true) {
			header("location: sistem.php?sistem=user&act=view&id=".$_GET['id']."");
			die;
		}
	}
}
//alat
elseif($_GET['mod'] == 'alat')
{
	if($_GET['act'] == 'delete') {

		$crudalat = new crudalat($db_con);
		if($crudalat->delete($id) == true) {
			header("location: sistem.php?sistem=home&act=view&id=".$_GET['idx']."");
			die;
		}
	}
}

else {
header("location: sistem.php?sistem=home");
die;
}
?>
