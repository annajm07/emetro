<?php
//file utama sistem.php
define('_VALID_ACCESS',	true);
require_once "inc/app.config.php";
require_once "inc/app.core.php";
ini_set('display_errors', '1');

if ($_SERVER['QUERY_STRING']) {
	$sistem = "login";
	if (isset($_GET['sistem'])) {
		$sistem = $_GET['sistem'];
		if (file_exists("sistem/$sistem.php")) {
			include("sistem/$sistem.php");
		} else {
			include_once("sistem/404.php");
		}
	}
} else {
	if (file_exists("sistem/login.php")) {
		include_once("sistem/login.php");
	} else {
		include_once("error.php");
	}
}
