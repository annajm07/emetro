<?php
define('_VALID_ACCESS',	true);

include_once"../inc/app.config.php"; include_once"../inc/app.core.php";

if(isset($_GET['id']) && isset($_GET['tum'])) {

$pengukuran = base64_decode($_GET['id']);
$tum = $_GET['tum'];

$sql = $db_con->prepare("SELECT * FROM sertifikattb WHERE pengukuran=:pengukuran AND tum=:tum ORDER BY id_sr DESC LIMIT 0,1");
$sql->bindParam(':pengukuran', $pengukuran);
$sql->bindParam(':tum', $tum);
$sql->execute();
$countsql = $sql->rowCount();
$row = $sql->fetch(PDO::FETCH_ASSOC);

if($countsql >= 1) {

?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Lampiran Sertifikat Nomor <?php echo $row['nomor'];?></title>
    <style>
    @media print {
    @page { margin: 0; }
    body { margin: 1.6cm; }
    }
    table {
    border-collapse: collapse;
    }
    </style>
</head>
<body onload="window.print()">

  <p style="font-family: Arial, Tahoma;" align="right">Lampiran Sertifikat No.	: <?php echo $row['nomor'];?></p>

  <br>

  <?php
  $sqldata = $db_con->prepare("SELECT * FROM alattb WHERE id_al=:pengukuran ORDER BY id_al DESC LIMIT 1");
  $sqldata->execute(array(":pengukuran"=>$pengukuran));
  $rowdata=$sqldata->fetch(PDO::FETCH_ASSOC);

  $sqlspe = $db_con->prepare("SELECT * FROM lampirantb WHERE id_al = :al");
  $sqlspe->bindParam(':al', $pengukuran);
  $sqlspe->execute();
  $countspe = $sqlspe->rowCount();
  ?>
  <table width="100%" border="1" style="font-family: Arial, Tahoma;">
    <tr>
      <th scope="col">NO.</th>
      <th scope="col">MEREK</th>
      <th scope="col">NO. SERI</th>
      <th scope="col">TIPE</th>
      <?php if($rowdata['spbu'] <> '') { ?>
      <th scope="col">JENIS BBM</th>
      <?php } else { ?>
      <th scope="col">KAPASITAS</th>
      <?php } ?>
    </tr>
    <?php
     $no = 1;
     while($rowspe=$sqlspe->fetch(PDO::FETCH_ASSOC))
     {
        ?>
          <tr>
            <td align="center"><?php print($no); ?></td>
            <td align="center"><?php print($rowspe['merek']); ?></td>
            <td align="center"><?php print($rowspe['seri']); ?></td>
            <td align="center"><?php print($rowspe['tipe']); ?></td>
            <?php if($rowdata['spbu'] <> '') { ?>
            <td align="center"><?php print($rowspe['jenis']); ?></td>
            <?php } else { ?>
            <td align="center"><?php print($rowspe['kapasitas']); ?></td>
            <?php } ?>

          </tr>
          <?php
        $no++;
     }
     ?>

</table>

  <br>

  <table width="100%" border="0" style="font-family: Arial, Tahoma;">
  <tr>
  <td width="65%" align="center">

  </td>
  <td width="35%" align="left">
    <p><b>Penguji,</b></p>
    <p>&nbsp;</p><br>
    <p><u><b><?php echo $rowdata['penguji'];?></b></u><br>NIP <?php echo $rowdata['nip'];?></p>
  </td>
  </tr>
  </table>

</body>
</html>
<?php
} else { echo "Tidak ada data yang dapat di tampilkan :("; }
} else { echo "Tidak ada data yang dapat di tampilkan :("; }
?>
