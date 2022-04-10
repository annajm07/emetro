<?php
define('_VALID_ACCESS',	true);

include_once"../inc/app.config.php"; include_once"../inc/app.core.php";

$mangambar = new mangambar;

$beda = date('dmYHis');

$nama_file	=$_FILES['image']['name'];
$tipe_file	=$_FILES['image']['type'];
$ukuran_file=$_FILES['image']['size'];
$kbfile=$_FILES['image']['size']/1024;

$error ='';

if($ukuran_file<=2000000){
	if(	$tipe_file != "image/jpg" AND
		$tipe_file != "image/png" AND
		$tipe_file != "image/jpeg") :
		echo 'invalid';
		exit();
		endif;
} else { echo 'invalid'; exit(); }

$PhotoFileName = trim($_FILES['image']['name']); // dapatkan informasi nama file
// membaca file
$TmpFileName = $_FILES['image']['tmp_name']; // menempatkan file upload ditmp server sementara
// membuat file bisa dibuka dan dibaca
$TempFile = fopen($TmpFileName, "r");
$BinaryPhoto = fread($TempFile, fileSize($TmpFileName));
$ErrorReporting = error_reporting(E_ALL & ~(E_WARNING)); // lupakan warning yang akan muncul
$SrcImage = imagecreatefromstring($BinaryPhoto); // untuk membuat image
error_reporting($ErrorReporting); // sistem pelaporan jika ada sistem yang error
if (!$SrcImage){
	die;
}
// mendapatkan informasi tinggi dan lebar foto
$nWidth = imagesx($SrcImage);
$nHeight = imagesy($SrcImage);
// membuat rasio foto thumbnail secara otomatis dengan lebar 100px atau tinggi 100pixel dilihat dari foto asli bagian mana yang ukurannya lebih besar
$ratio = max($nWidth, $nHeight) / 300;
$ratio = max($ratio, 2.0);
// tentukan tujuan foto tersebut dari lebar dan tinggi yang telah ditemukan
$destWidth = (int)($nWidth / $ratio);
$destHeight = (int)($nHeight / $ratio);
// tentukan dimana file tersebut akan diupload
$dir = "../up/user/";
$uploadfile = $dir . $beda . str_replace(" ","-",$PhotoFileName);
// membuat Thumbnail File
$DestImage = imagecreatetruecolor($destWidth, $destHeight);
$DestTrueImage = imagecreatetruecolor($nWidth, $nHeight);
@imagecopyresampled($DestTrueImage, $SrcImage,0, 0, 0, 0, $nWidth, $nHeight, $nWidth, $nHeight); // resize the image
@imagecopyresampled($DestImage, $SrcImage,0, 0, 0, 0, $destWidth, $destHeight, $nWidth, $nHeight); // resize the image

$BinaryThumbnail = "thumb_$beda".str_replace(" ","-",$PhotoFileName)."";
$ThumbDir = $dir.$BinaryThumbnail;
ob_start(); // Memulai capturing file asli
// jika ingin membuat file JPG
@imagejpeg($DestImage,$dir.$BinaryThumbnail,"100");
$BinaryThumbnail = ob_get_contents(); // the raw jpeg image data.
ob_end_clean(); // Dump the stdout so it does not screw other output.*/

if (!$uploadfile) {
	die;
} else if (!move_uploaded_file($TmpFileName, $uploadfile)) {
	die;
} else {

	$dest_file = $beda . str_replace(" ","-",$PhotoFileName);

	$cname = "crop_".$dest_file;

	$cfoto = $dir . $cname;

	$mangambar->cropImage(200, 200, "$ThumbDir", 'jpg', "$cfoto");

	$sqlupdate = $db_con->prepare("UPDATE usertb SET foto=:foto, cfoto=:cfoto WHERE id_us=:id");
	$sqlupdate->bindParam(":foto", $dest_file);
	$sqlupdate->bindParam(":cfoto", $cname);
	$sqlupdate->bindParam(":id", $_POST['cid_us']);

	if($sqlupdate->execute()) {
		echo '<img src="'.$urlweb.'up/user/'.$cname.'" alt="">';
	}
	else {
		echo 'invalid';
	}
}

?>
