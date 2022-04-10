<?php
define('_VALID_ACCESS',	true);

include_once"../inc/app.config.php"; include_once"../inc/app.core.php";

$tanggal = new tanggal;

if(isset($_GET['bulan']) && isset($_GET['tahun'])) {

$ntahun = $_GET['tahun'];
$nbulan = $_GET['bulan'];

if($nbulan <> "01") {
	$ntahunlalu = $ntahun;
	$nbulanx = ltrim($nbulan, '0');
	$nbulanlalu = $nbulanx-1;
	$nbulanlalu = sprintf("%02d", $nbulanlalu);
} else {
	$ntahunlalu = $ntahun-1;
	$nbulanlalu = 12;
}

?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Data Tera Ulang Sah Bulan <?php $tanggal->pilbulan($nbulan);?> Tahun <?php echo $ntahun;?></title>
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

<center><p style="font-size:16px; font-family: Arial, Tahoma;"><b>DATA TERA SAH UTTP<br>Bulan <?php $tanggal->pilbulan($nbulan);?> Tahun <?php echo $ntahun;?></b></p></center>
<br>
<p style="font-size:14px; font-family: Arial, Tahoma;"><b>UNIT METROLOGI LEGAL : PADANG</b></p>
<br>
<table width="100%" border="1" style="font-size:12px; font-family: Arial, Tahoma;">
  <thead>
    <tr>
      <th scope="col" rowspan="2">No</th>
      <th scope="col" rowspan="2">Jenis UTTP</th>
      <th scope="col" rowspan="2">UTTP Selain Pasar</th>
      <th scope="col" colspan="10">UTTP Pasar</th>
      <th scope="col" colspan="2">Jumlah</th>
      <th scope="col" rowspan="2">Perubahan</th>
    </tr>
    <tr>
      <th scope="col">Pasar 1</th>
      <th scope="col">Pasar 2</th>
      <th scope="col">Pasar 3</th>
      <th scope="col">Pasar 4</th>
      <th scope="col">Pasar 5</th>
      <th scope="col">Pasar 6</th>
      <th scope="col">Pasar 7</th>
      <th scope="col">Pasar 8</th>
      <th scope="col">Pasar 9</th>
      <th scope="col">Jumlah UTTP Pasar</th>
      <th scope="col">UTTP selain Pasar & Pasar Bulan ini</th>
      <th scope="col">UTTP selain Pasar & Pasar Bulan lalu</th>
    </tr>
  </thead>
  <tbody>
<?php
$sqljenis = $db_con->prepare("SELECT * FROM jenistb ORDER BY id_jn ASC");
$sqljenis->execute();
$countjenis = $sqljenis->rowCount();

    if($countjenis >= 1) {

     $no = 1;
     while($rowjenis=$sqljenis->fetch(PDO::FETCH_ASSOC))
     {
       ?>
       <tr>
         <td align="center"><?php print($no); ?></td>
         <td><?php print(strtoupper($rowjenis['nama'])); ?></td>

          <?php
          $sqlpasar = $db_con->prepare("SELECT * FROM pasartb ORDER BY id_ps ASC");
          $sqlpasar->execute();
          while($rowpasar=$sqlpasar->fetch(PDO::FETCH_ASSOC)) {
          echo "<td align=\"right\">";
          $sqldata = $db_con->prepare("SELECT COUNT(*) AS tot FROM alattb WHERE id_jn='".$rowjenis['id_jn']."' AND id_ps='".$rowpasar['id_ps']."' AND YEAR(tgl)='".$ntahun."' AND MONTH(tgl)='".$nbulan."'");
          $sqldata->execute();
          $rowdata=$sqldata->fetch(PDO::FETCH_ASSOC);
          print(number_format($rowdata['tot'],0,',','.'));
          echo "</td>";
          }

          echo "<td align=\"right\">";
          $sqldatax = $db_con->prepare("SELECT COUNT(*) AS tot FROM alattb WHERE id_jn='".$rowjenis['id_jn']."' AND id_ps <> '1' AND YEAR(tgl)='".$ntahun."' AND MONTH(tgl)='".$nbulan."'");
          $sqldatax->execute();
          $rowdatax=$sqldatax->fetch(PDO::FETCH_ASSOC);
          print(number_format($rowdatax['tot'],0,',','.'));
          echo "</td>";

          echo "<td align=\"right\">";
          $sqldataxx = $db_con->prepare("SELECT COUNT(*) AS tot FROM alattb WHERE id_jn='".$rowjenis['id_jn']."' AND YEAR(tgl)='".$ntahun."' AND MONTH(tgl)='".$nbulan."'");
          $sqldataxx->execute();
          $rowdataxx=$sqldataxx->fetch(PDO::FETCH_ASSOC);
          print(number_format($rowdataxx['tot'],0,',','.'));
          echo "</td>";

          echo "<td align=\"right\">";
          $sqldataxxx = $db_con->prepare("SELECT COUNT(*) AS tot FROM alattb WHERE id_jn='".$rowjenis['id_jn']."' AND YEAR(tgl)='".$ntahunlalu."' AND MONTH(tgl)='".$nbulanlalu."'");
          $sqldataxxx->execute();
          $rowdataxxx=$sqldataxxx->fetch(PDO::FETCH_ASSOC);
          print(number_format($rowdataxxx['tot'],0,',','.'));
          echo "</td>";

          echo "<td align=\"right\">";
          print(number_format($rowdataxx['tot']-$rowdataxxx['tot'],0,',','.'));
          echo "</td>";
          ?>

       </tr>

        <?php
        $sqlsubjenis = $db_con->prepare("SELECT * FROM subjenistb WHERE id_jn='".$rowjenis['id_jn']."' ORDER BY id_sj ASC");
        $sqlsubjenis->execute();
        $countsubjenis = $sqlsubjenis->rowCount();

            if($countsubjenis >= 1) {

             $nos = 1;
             while($rowsubjenis=$sqlsubjenis->fetch(PDO::FETCH_ASSOC))
             {
               ?>
               <tr>
                 <td>&nbsp;</td>
                 <td><?php print($nos); ?>. <?php print($rowsubjenis['nama']); ?></td>

                  <?php
                  $sqlpasarx = $db_con->prepare("SELECT * FROM pasartb ORDER BY id_ps ASC");
                  $sqlpasarx->execute();
                  while($rowpasarx=$sqlpasarx->fetch(PDO::FETCH_ASSOC)) {
                  echo "<td align=\"right\">";
                  $sqldatas = $db_con->prepare("SELECT COUNT(*) AS tot FROM alattb WHERE id_sj='".$rowsubjenis['id_sj']."' AND id_ps='".$rowpasarx['id_ps']."' AND YEAR(tgl)='".$ntahun."' AND MONTH(tgl)='".$nbulan."'");
                  $sqldatas->execute();
                  $rowdatas=$sqldatas->fetch(PDO::FETCH_ASSOC);
                  print(number_format($rowdatas['tot'],0,',','.'));
                  echo "</td>";
                  }

                  echo "<td align=\"right\">";
                  $sqldatasx = $db_con->prepare("SELECT COUNT(*) AS tot FROM alattb WHERE id_sj='".$rowsubjenis['id_sj']."' AND id_ps <> '1' AND YEAR(tgl)='".$ntahun."' AND MONTH(tgl)='".$nbulan."'");
                  $sqldatasx->execute();
                  $rowdatasx=$sqldatasx->fetch(PDO::FETCH_ASSOC);
                  print(number_format($rowdatasx['tot'],0,',','.'));
                  echo "</td>";

                  echo "<td align=\"right\">";
                  $sqldatasxx = $db_con->prepare("SELECT COUNT(*) AS tot FROM alattb WHERE id_sj='".$rowsubjenis['id_sj']."' AND YEAR(tgl)='".$ntahun."' AND MONTH(tgl)='".$nbulan."'");
                  $sqldatasxx->execute();
                  $rowdatasxx=$sqldatasxx->fetch(PDO::FETCH_ASSOC);
                  print(number_format($rowdatasxx['tot'],0,',','.'));
                  echo "</td>";

                  echo "<td align=\"right\">";
                  $sqldatasxxx = $db_con->prepare("SELECT COUNT(*) AS tot FROM alattb WHERE id_sj='".$rowsubjenis['id_sj']."' AND YEAR(tgl)='".$ntahunlalu."' AND MONTH(tgl)='".$nbulanlalu."'");
                  $sqldatasxxx->execute();
                  $rowdatasxxx=$sqldatasxxx->fetch(PDO::FETCH_ASSOC);
                  print(number_format($rowdatasxxx['tot'],0,',','.'));
                  echo "</td>";

                  echo "<td align=\"right\">";
                  print(number_format($rowdatasxx['tot']-$rowdatasxxx['tot'],0,',','.'));
                  echo "</td>";
                  ?>

               </tr>
               <?php
               $nos++;
            }
          }
         ?>


       <?php
       $no++;
    }
  }

 ?>
 <tr>
         <td>&nbsp;</td>
         <td><b>Jumlah UTTP</b></td>

          <?php
          $sqlpasartx = $db_con->prepare("SELECT * FROM pasartb ORDER BY id_ps ASC");
          $sqlpasartx->execute();
          while($rowpasartx=$sqlpasartx->fetch(PDO::FETCH_ASSOC)) {
          echo "<td align=\"right\"><b>";
          $sqldatast = $db_con->prepare("SELECT COUNT(*) AS tot FROM alattb WHERE id_ps='".$rowpasartx['id_ps']."' AND YEAR(tgl)='".$ntahun."' AND MONTH(tgl)='".$nbulan."'");
          $sqldatast->execute();
          $rowdatast=$sqldatast->fetch(PDO::FETCH_ASSOC);
          print(number_format($rowdatast['tot'],0,',','.'));
          echo "</b></td>";
          }

          echo "<td align=\"right\"><b>";
          $sqldatastx = $db_con->prepare("SELECT COUNT(*) AS tot FROM alattb WHERE id_ps <> '1' AND YEAR(tgl)='".$ntahun."' AND MONTH(tgl)='".$nbulan."'");
          $sqldatastx->execute();
          $rowdatastx=$sqldatastx->fetch(PDO::FETCH_ASSOC);
          print(number_format($rowdatastx['tot'],0,',','.'));
          echo "</b></td>";

          echo "<td align=\"right\"><b>";
          $sqldatastxx = $db_con->prepare("SELECT COUNT(*) AS tot FROM alattb WHERE YEAR(tgl)='".$ntahun."' AND MONTH(tgl)='".$nbulan."'");
          $sqldatastxx->execute();
          $rowdatastxx=$sqldatastxx->fetch(PDO::FETCH_ASSOC);
          print(number_format($rowdatastxx['tot'],0,',','.'));
          echo "</b></td>";

          echo "<td align=\"right\"><b>";
          $sqldatastxxx = $db_con->prepare("SELECT COUNT(*) AS tot FROM alattb WHERE YEAR(tgl)='".$ntahunlalu."' AND MONTH(tgl)='".$nbulanlalu."'");
          $sqldatastxxx->execute();
          $rowdatastxxx=$sqldatastxxx->fetch(PDO::FETCH_ASSOC);
          print(number_format($rowdatastxxx['tot'],0,',','.'));
          echo "</b></td>";

          echo "<td align=\"right\">";
          print(number_format($rowdatastxx['tot']-$rowdatastxxx['tot'],0,',','.'));
          echo "</td>";
          ?>

       </tr>

  </tbody>
</table>

</body>
</html>
<?php
} else { echo "Tidak ada data yang dapat di tampilkan :("; }
?>
