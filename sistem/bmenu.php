<?php if(!defined('_VALID_ACCESS')) { header ("location: index.php"); die; }

$stmt = $db_con->prepare("SELECT * FROM usertb WHERE id_us=:uid ORDER BY id_us DESC LIMIT 1");
$stmt->execute(array(":uid"=>$_SESSION['user_session']));
$rowuser=$stmt->fetch(PDO::FETCH_ASSOC);

$welcome_string="Selamat Datang!";
$numeric_date=date("G");

if($numeric_date>=0&&$numeric_date<=11)
$welcome_string="Selamat Pagi";
else if($numeric_date>=12&&$numeric_date<=17)
$welcome_string="Selamat Sore";
else if($numeric_date>=18&&$numeric_date<=23)
$welcome_string="Selamat Malam";
?>

<ol class="breadcrumb">
  <li><a href="#"><i class="fa fa-smile-o"></i> <?php echo $welcome_string;?> <?php echo $rowuser['nama']; ?>.. Hari ini <?php $tanggal->tanggalkini(); ?></a></li>
</ol>
