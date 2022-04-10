<?php
if(!defined('_VALID_ACCESS')) { header ("location: index.php"); die; }

//konfigurasi global
$appname = "e-METRO";
$appnames = "E-Service Administrasi Pelayanan Kemetrologian Elektronik";
$adminname = "Administrasi";
$appvendor = "UNP";
$clientname = "Dinas Perdagangan Kota Padang";
$appcpr = "&copy; ".date('Y')." ".$clientname;
$urlweb = "http://localhost:8080/emetro/"; //Gunakan garis miring diakhir nama domain
$webtitle = $appname." ".$clientname;
$webkeyword = $appnames.", ".$appname.", ".$clientname;
$webdesc = $appname." merupakan ".$appnames." pada ".$clientname.".";

//konfigurasi database
$db_host = "localhost";
$db_name = "ta_emetrodb";
$db_user = "root";
$db_pass = "";
