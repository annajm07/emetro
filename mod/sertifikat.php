<?php
define('_VALID_ACCESS',  true);
session_start();

include_once "../inc/app.config.php";
include_once "../inc/app.core.php";

if (base64_decode($_SESSION['type_session']) !== "kasubag") {
  header("Location: $urlweb");
  die();
}

$tanggal = new tanggal;

$terbilang = new terbilang;

if (isset($_GET['id']) && isset($_GET['tum'])) {

  $pengukuran = base64_decode($_GET['id']);
  $tum = $_GET['tum'];

  $sql = $db_con->prepare("SELECT * FROM sertifikattb WHERE pengukuran=:pengukuran AND tum=:tum ORDER BY id_sr DESC LIMIT 0,1");
  $sql->bindParam(':pengukuran', $pengukuran);
  $sql->bindParam(':tum', $tum);
  $sql->execute();
  $countsql = $sql->rowCount();
  $row = $sql->fetch(PDO::FETCH_ASSOC);
  //  cek apakah sertifikat sudah disetujui oleh kepala uptd
  if ($row['status'] != 1) {
    header("Location: $urlweb");
    die();
  }

  if ($countsql >= 1) {

    $supj = $db_con->prepare("SELECT * FROM pejabattb WHERE id_pj=:pj ORDER BY id_pj DESC LIMIT 1");
    $supj->execute(array(":pj" => $row['id_pj']));
    $rowpj = $supj->fetch(PDO::FETCH_ASSOC);

    include_once "../inc/phpqrcode/qrlib.php";

    $tempdir = "../up/temp/";
    if (!file_exists($tempdir))
      mkdir($tempdir);

    $isiqr = $urlweb . $row['id_sr'];
    $namafile = "qrcode-" . $row['id_sr'] . "-inteknostudio.png";
    $quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
    $ukuran = 3; //batasan 1 paling kecil, 10 paling besar
    $padding = 1;

    QRCode::png($isiqr, $tempdir . $namafile, $quality, $ukuran, $padding);
?>
    <!doctype html>
    <html lang="id">

    <head>
      <meta charset="utf-8">
      <title>Sertifikat Nomor <?php echo $row['nomor']; ?></title>
      <style>
        @media print {
          @page {
            margin: 0;
          }

          body {
            margin: 1.6cm;
          }
        }

        table {
          border-collapse: collapse;
        }

        hr.header {
          display: block;
          height: 2px;
          border: 0;
          border-top: 1px solid #000;
          border-bottom: 4px solid #000;
          margin: 5px 0;
          padding: 0;
        }

        hr.footer {
          display: block;
          height: 1px;
          border: 0;
          border-top: 2px solid #919191;
          margin: 5px 0;
          padding: 0;
        }
      </style>
    </head>

    <body onload="window.print()">

      <table width="100%" border="0" style="font-size:11pt;">
        <tr>
          <td width="20%" align="center" valign="center"><img src="<?php echo $urlweb; ?>img/logo-header.jpg"></td>
          <td width="80%" align="center" style="line-height:0.2;">
            <p style="font-size:14pt;"><b>PEMERINTAH KOTA PADANG</b></p>
            <p style="font-size:14pt;"><b>DINAS PERDAGANGAN</b></p>
            <p style="font-size:18pt;"><b>UPTD METROLOGI LEGAL</b></p>
            <p>Jl. Bypass km. 14 Aia Pacah, Padang, Email : metrologipadang@gmail.com</p>
          </td>
        </tr>
      </table>

      <hr class="header">
      <br>
      <table width="100%" border="0" style="font-family:arial;">
        <tr>
          <td width="20%" align="center" valign="center"><img src="<?php echo $urlweb; ?>up/temp/qrcode-<?php echo $row['id_sr']; ?>-inteknostudio.png"></td>
          <td width="80%" align="center" style="line-height:0.2;">
            <h2><u>SURAT KETERANGAN HASIL PENGUJIAN</u></h2>
            <p>Calibration Certificate</p>
            <br>
            <p><b>Nomor : <?php echo $row['nomor']; ?></b></p>
          </td>
        </tr>
      </table>

      <br>

      <?php if ($tum == 1) {

        $sqldata = $db_con->prepare("SELECT * FROM tumtb WHERE id_tm=:pengukuran ORDER BY id_tm DESC LIMIT 1");
        $sqldata->execute(array(":pengukuran" => $pengukuran));
        $rowdata = $sqldata->fetch(PDO::FETCH_ASSOC);

        if ($rowdata['tera'] == 1) {
          $mytera = "Tera";
        } else {
          $mytera = "Tera Ulang";
        }

      ?>

        <table width="100%" border="0" style="font-family:arial; line-height:0.9; font-size:11pt;">
          <tr>
            <td width="10%"></td>
            <td width="20%" align="left" valign="top">UTTP</td>
            <td width="5%" align="center" valign="top">:</td>
            <td width="65%" align="left" valign="top"><b><?php echo strtoupper($rowdata['jenis']); ?></b></td>
          </tr>
          <tr>
            <td width="10%"></td>
            <td width="20%" align="left" valign="top">Untuk Cairan</td>
            <td width="5%" align="center" valign="top">:</td>
            <td width="65%" align="left" valign="top"><b><?php echo strtoupper($rowdata['untuk']); ?></b></td>
          </tr>
          <tr>
            <td width="10%"></td>
            <td width="20%" align="left" valign="top">P e m i l i k</td>
            <td width="5%" align="center" valign="top">:</td>
            <td width="65%" align="left" valign="top"><b><?php echo strtoupper($rowdata['pemilik']); ?> / <?php echo $rowdata['alamat']; ?></b></td>
          </tr>
          <tr>
            <td width="10%"></td>
            <td width="20%" align="left" valign="top">Merek / Buatan</td>
            <td width="5%" align="center" valign="top">:</td>
            <td width="65%" align="left" valign="top"><b><?php echo strtoupper($rowdata['merek']); ?> / <?php echo strtoupper($rowdata['buatan']); ?></b></td>
          </tr>
          <tr>
            <td width="10%"></td>
            <td width="20%" align="left" valign="top">Model / No.Plat</td>
            <td width="5%" align="center" valign="top">:</td>
            <td width="65%" align="left" valign="top"><b><?php echo strtoupper($rowdata['model']); ?> / <?php echo strtoupper($rowdata['plat']); ?></b></td>
          </tr>
          <tr>
            <td width="10%"></td>
            <td width="20%" align="left" valign="top">Volume Nominal</td>
            <td width="5%" align="center" valign="top">:</td>
            <td width="65%" align="left" valign="top"><b><?php echo $rowdata['volume']; ?></b></td>
          </tr>
          <tr>
            <td width="10%"></td>
            <td width="20%" align="left" valign="top">Merek Kendaraan</td>
            <td width="5%" align="center" valign="top">:</td>
            <td width="65%" align="left" valign="top"><b><?php echo strtoupper($rowdata['kendaraan']); ?></b></td>
          </tr>
          <tr>
            <td width="10%"></td>
            <td width="20%" align="left" valign="top">No.Pol/Chasis</td>
            <td width="5%" align="center" valign="top">:</td>
            <td width="65%" align="left" valign="top"><b><?php echo strtoupper($rowdata['nopol']); ?> / <?php echo strtoupper($rowdata['chasis']); ?></b></td>
          </tr>
          <tr>
            <td width="10%"></td>
            <td width="20%" align="left" valign="top">M e t o d e</td>
            <td width="5%" align="center" valign="top">:</td>
            <td width="65%" align="left" valign="top"><?php echo $rowdata['metode']; ?></td>
          </tr>
          <tr>
            <td width="10%"></td>
            <td width="20%" align="left" valign="top">Suhu Dasar</td>
            <td width="5%" align="center" valign="top">:</td>
            <td width="65%" align="left" valign="top"><?php echo $rowdata['suhu']; ?></td>
          </tr>
          <tr>
            <td width="10%"></td>
            <td width="20%" align="left" valign="top">Dilaksanakan Oleh</td>
            <td width="5%" align="center" valign="top">:</td>
            <td width="65%" align="left" valign="top"><b><?php echo $rowdata['penguji']; ?></b></td>
          </tr>
          <tr>
            <td width="10%"></td>
            <td width="20%" align="left" valign="top">T a n g g a l</td>
            <td width="5%" align="center" valign="top">:</td>
            <td width="65%" align="left" valign="top"><b><?php if ($rowdata['tgl'] <> "0000-00-00") {
                                                            $tanggal->contanggalx(substr($rowdata['tgl'], 8, 2), substr($rowdata['tgl'], 5, 2), substr($rowdata['tgl'], 0, 4));
                                                          } else {
                                                            echo "";
                                                          } ?></b></td>
          </tr>
          <tr>
            <td width="10%"></td>
            <td width="20%" align="left" valign="top">H a s i l</td>
            <td width="5%" align="center" valign="top">:</td>
            <td width="65%" align="left" valign="top"><b> Disahkan "<?php echo strtoupper($mytera); ?>" Tahun <?php echo $rowdata['tahun']; ?></td>
          </tr>
        </table>

        <br>

        <?php if (($rowdata['s'] <> 0 || $rowdata['sx'] <> 0) && $rowdata['sxx'] == 0 && $rowdata['sxxx'] == 0) { ?>

          <table width="100%" border="0" style="font-family:arial; line-height:0.7; font-size:8pt;">
            <tr>
              <td width="40%" align="center" valign="center"><img src="<?php echo $urlweb; ?>img/kompartemen.jpg"></td>
              <td width="30%" align="center" style="line-height:0.2;">
                <p><b>Kompartemen I</b></p>
                <br>
                <table width="100%" border="0" style="font-family:arial; line-height:14px;">
                  <tr>
                    <td width="20%" align="left" valign="top">t1</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['t1']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">t2</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['t2']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">t3</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['t3']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">t4</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['t4']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">T</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['t']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">d</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['d']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">p</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['p']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">q</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['q']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">s</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['s']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                </table>
              </td>

              <?php if ($rowdata['sx'] <> 0) { ?>

                <td width="30%" align="center" style="line-height:0.2;">
                  <p><b>Kompartemen II</b></p>
                  <br>
                  <table width="100%" border="0" style="font-family:arial; line-height:14px;">
                    <tr>
                      <td width="20%" align="left" valign="top">t1</td>
                      <td width="20%" align="center" valign="top">=</td>
                      <td width="40%" align="right" valign="top"><?php echo $rowdata['t1x']; ?></td>
                      <td width="20%" align="center" valign="top">mm</td>
                    </tr>
                    <tr>
                      <td width="20%" align="left" valign="top">t2</td>
                      <td width="20%" align="center" valign="top">=</td>
                      <td width="40%" align="right" valign="top"><?php echo $rowdata['t2x']; ?></td>
                      <td width="20%" align="center" valign="top">mm</td>
                    </tr>
                    <tr>
                      <td width="20%" align="left" valign="top">t3</td>
                      <td width="20%" align="center" valign="top">=</td>
                      <td width="40%" align="right" valign="top"><?php echo $rowdata['t3x']; ?></td>
                      <td width="20%" align="center" valign="top">mm</td>
                    </tr>
                    <tr>
                      <td width="20%" align="left" valign="top">t4</td>
                      <td width="20%" align="center" valign="top">=</td>
                      <td width="40%" align="right" valign="top"><?php echo $rowdata['t4x']; ?></td>
                      <td width="20%" align="center" valign="top">mm</td>
                    </tr>
                    <tr>
                      <td width="20%" align="left" valign="top">T</td>
                      <td width="20%" align="center" valign="top">=</td>
                      <td width="40%" align="right" valign="top"><?php echo $rowdata['tx']; ?></td>
                      <td width="20%" align="center" valign="top">mm</td>
                    </tr>
                    <tr>
                      <td width="20%" align="left" valign="top">d</td>
                      <td width="20%" align="center" valign="top">=</td>
                      <td width="40%" align="right" valign="top"><?php echo $rowdata['dx']; ?></td>
                      <td width="20%" align="center" valign="top">mm</td>
                    </tr>
                    <tr>
                      <td width="20%" align="left" valign="top">p</td>
                      <td width="20%" align="center" valign="top">=</td>
                      <td width="40%" align="right" valign="top"><?php echo $rowdata['px']; ?></td>
                      <td width="20%" align="center" valign="top">mm</td>
                    </tr>
                    <tr>
                      <td width="20%" align="left" valign="top">q</td>
                      <td width="20%" align="center" valign="top">=</td>
                      <td width="40%" align="right" valign="top"><?php echo $rowdata['qx']; ?></td>
                      <td width="20%" align="center" valign="top">mm</td>
                    </tr>
                    <tr>
                      <td width="20%" align="left" valign="top">s</td>
                      <td width="20%" align="center" valign="top">=</td>
                      <td width="40%" align="right" valign="top"><?php echo $rowdata['sx']; ?></td>
                      <td width="20%" align="center" valign="top">mm</td>
                    </tr>
                  </table>
                </td>

              <?php } else {
                echo "<td width=\"30%\" align=\"center\" style=\"line-height:0.2;\">&nbsp;</td>";
              } ?>

            </tr>
          </table>

          <br>

          <table width="100%" border="0" style="font-family:arial; line-height:1; font-size:11pt;">
            <tr>
              <td width="40%" align="center">
              </td>
              <td width="60%" align="center">
                <p><b>DISAHKAN BERDASARKAN UU RI NO 2 TAHUN 1981<br>TENTANG METROLOGI LEGAL DENGAN MEMBUBUHKAN<br>TANDA TERA SAH DAN JAMINAN</b></p>
                <p>Padang, <?php if ($row['tgl'] <> "0000-00-00") {
                              $tanggal->contanggalx(substr($row['tgl'], 8, 2), substr($row['tgl'], 5, 2), substr($row['tgl'], 0, 4));
                            } else {
                              echo "";
                            } ?><br>
                  <?php if ($rowpj['id_pj'] == 2) {
                    echo "a/n Kepala UPTD Metrologi Legal<br>" . $rowpj['jabatan'];
                  } else {
                    echo $rowpj['jabatan'];
                  } ?></p>
                <p>&nbsp;</p><br>
                <img src="../img/ttd.png" alt="">
                <p><b><u><?php echo $rowpj['nama']; ?></u><br>NIP. <?php echo $rowpj['nip']; ?></b></p>
              </td>
            </tr>
          </table>

        <?php } else {
          echo "";
        } ?>

        <?php if ($rowdata['s'] <> 0 && $rowdata['sx'] <> 0 && $rowdata['sxx'] <> 0) { ?>

          <table width="100%" border="0" style="font-family:arial; line-height:0.7; font-size:8pt;">
            <tr>
              <td width="25%" align="center" style="line-height:0.2;">
                <p><b>Kompartemen I</b></p>
                <br>
                <table width="100%" border="0" style="font-family:arial; line-height:14px;">
                  <tr>
                    <td width="20%" align="left" valign="top">t1</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['t1']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">t2</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['t2']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">t3</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['t3']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">t4</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['t4']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">T</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['t']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">d</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['d']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">p</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['p']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">q</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['q']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">s</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['s']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                </table>
              </td>

              <td width="25%" align="center" style="line-height:0.2;">
                <p><b>Kompartemen II</b></p>
                <br>
                <table width="100%" border="0" style="font-family:arial; line-height:14px;">
                  <tr>
                    <td width="20%" align="left" valign="top">t1</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['t1x']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">t2</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['t2x']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">t3</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['t3x']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">t4</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['t4x']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">T</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['tx']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">d</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['dx']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">p</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['px']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">q</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['qx']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">s</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['sx']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                </table>
              </td>

              <td width="25%" align="center" style="line-height:0.2;">
                <p><b>Kompartemen III</b></p>
                <br>
                <table width="100%" border="0" style="font-family:arial; line-height:14px;">
                  <tr>
                    <td width="20%" align="left" valign="top">t1</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['t1xx']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">t2</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['t2xx']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">t3</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['t3xx']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">t4</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['t4xx']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">T</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['txx']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">d</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['dxx']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">p</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['pxx']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">q</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['qxx']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                  <tr>
                    <td width="20%" align="left" valign="top">s</td>
                    <td width="20%" align="center" valign="top">=</td>
                    <td width="40%" align="right" valign="top"><?php echo $rowdata['sxx']; ?></td>
                    <td width="20%" align="center" valign="top">mm</td>
                  </tr>
                </table>
              </td>

              <?php if ($rowdata['sxxx'] <> 0) { ?>

                <td width="25%" align="center" style="line-height:0.2;">
                  <p><b>Kompartemen IV</b></p>
                  <br>
                  <table width="100%" border="0" style="font-family:arial; line-height:14px;">
                    <tr>
                      <td width="20%" align="left" valign="top">t1</td>
                      <td width="20%" align="center" valign="top">=</td>
                      <td width="40%" align="right" valign="top"><?php echo $rowdata['t1xxx']; ?></td>
                      <td width="20%" align="center" valign="top">mm</td>
                    </tr>
                    <tr>
                      <td width="20%" align="left" valign="top">t2</td>
                      <td width="20%" align="center" valign="top">=</td>
                      <td width="40%" align="right" valign="top"><?php echo $rowdata['t2xxx']; ?></td>
                      <td width="20%" align="center" valign="top">mm</td>
                    </tr>
                    <tr>
                      <td width="20%" align="left" valign="top">t3</td>
                      <td width="20%" align="center" valign="top">=</td>
                      <td width="40%" align="right" valign="top"><?php echo $rowdata['t3xxx']; ?></td>
                      <td width="20%" align="center" valign="top">mm</td>
                    </tr>
                    <tr>
                      <td width="20%" align="left" valign="top">t4</td>
                      <td width="20%" align="center" valign="top">=</td>
                      <td width="40%" align="right" valign="top"><?php echo $rowdata['t4xxx']; ?></td>
                      <td width="20%" align="center" valign="top">mm</td>
                    </tr>
                    <tr>
                      <td width="20%" align="left" valign="top">T</td>
                      <td width="20%" align="center" valign="top">=</td>
                      <td width="40%" align="right" valign="top"><?php echo $rowdata['txxx']; ?></td>
                      <td width="20%" align="center" valign="top">mm</td>
                    </tr>
                    <tr>
                      <td width="20%" align="left" valign="top">d</td>
                      <td width="20%" align="center" valign="top">=</td>
                      <td width="40%" align="right" valign="top"><?php echo $rowdata['dxxx']; ?></td>
                      <td width="20%" align="center" valign="top">mm</td>
                    </tr>
                    <tr>
                      <td width="20%" align="left" valign="top">p</td>
                      <td width="20%" align="center" valign="top">=</td>
                      <td width="40%" align="right" valign="top"><?php echo $rowdata['pxxx']; ?></td>
                      <td width="20%" align="center" valign="top">mm</td>
                    </tr>
                    <tr>
                      <td width="20%" align="left" valign="top">q</td>
                      <td width="20%" align="center" valign="top">=</td>
                      <td width="40%" align="right" valign="top"><?php echo $rowdata['qxxx']; ?></td>
                      <td width="20%" align="center" valign="top">mm</td>
                    </tr>
                    <tr>
                      <td width="20%" align="left" valign="top">s</td>
                      <td width="20%" align="center" valign="top">=</td>
                      <td width="40%" align="right" valign="top"><?php echo $rowdata['sxxx']; ?></td>
                      <td width="20%" align="center" valign="top">mm</td>
                    </tr>
                  </table>
                </td>
              <?php } else {
                echo "<td width=\"25%\" align=\"center\" style=\"line-height:0.2;\">&nbsp;</td>";
              } ?>

            </tr>
          </table>

          <br>

          <table width="100%" border="0" style="font-family:arial; line-height:1; font-size:11pt;">
            <tr>
              <td width="40%" align="center" valign="center"><img src="<?php echo $urlweb; ?>img/kompartemen.jpg"></td>
              <td width="60%" align="center">
                <p><b>DISAHKAN BERDASARKAN UU RI NO 2 TAHUN 1981<br>TENTANG METROLOGI LEGAL DENGAN MEMBUBUHKAN<br>TANDA TERA SAH DAN JAMINAN</b></p>
                <p>Padang, <?php if ($row['tgl'] <> "0000-00-00") {
                              $tanggal->contanggalx(substr($row['tgl'], 8, 2), substr($row['tgl'], 5, 2), substr($row['tgl'], 0, 4));
                            } else {
                              echo "";
                            } ?><br>
                  <?php if ($rowpj['id_pj'] == 2) {
                    echo "a/n Kepala UPTD Metrologi Legal<br>" . $rowpj['jabatan'];
                  } else {
                    echo $rowpj['jabatan'];
                  } ?></p>
                <p>&nbsp;</p><br>
                <p><b><u><?php echo $rowpj['nama']; ?></u><br>NIP. <?php echo $rowpj['nip']; ?></b></p>
              </td>
            </tr>
          </table>

        <?php } else {
          echo "";
        } ?>

        <?php
        if ($rowdata['sxxx'] <> 0) {
          $komp = 4;
          $kompa = "empat";
        } elseif ($rowdata['sxx'] <> 0) {
          $komp = 3;
          $kompa = "tiga";
        } elseif ($rowdata['sx'] <> 0) {
          $komp = 2;
          $kompa = "dua";
        } else {
          $komp = 1;
          $kompa = "satu";
        }
        ?>

        <br><br>
        <small style="font-family:arial; line-height:0.6; font-size:8pt;"><u>Catatan :</u></small><br>
        <small style="font-family:arial; line-height:0.6; font-size:8pt;">1. Tangki Ukur Mobil ini harus ditera ulang paling lambat tanggal : <b><?php if ($rowdata['berlaku'] <> "0000-00-00") {
                                                                                                                                                    $tanggal->contanggalx(substr($rowdata['berlaku'], 8, 2), substr($rowdata['berlaku'], 5, 2), substr($rowdata['berlaku'], 0, 4));
                                                                                                                                                  } else {
                                                                                                                                                    echo "";
                                                                                                                                                  } ?></b></small><br>
        <small style="font-family:arial; line-height:0.6; font-size:8pt;">2. Tangki Ukur Mobil terdiri dari : <b><u><?php echo $komp; ?> (<?php echo $kompa; ?>) kompartemen</u></b></small><br>
        <small style="font-family:arial; line-height:0.6; font-size:8pt;">3. <b>Surat Keterangan</b> ini <b>tidak berlaku</b> lagi apabila <b>Cap Tanda Tera Rusak / Segel putus</b>.</small><br>
        <small style="font-family:arial; line-height:0.6; font-size:8pt;">4. <b>Kepekaan di sekitar indeks penunjuk :</b></small><br>
        <small style="font-family:arial; line-height:0.6; font-size:8pt; padding-left:15px;">- Kompartemen I = <b><?php echo $rowdata['kp']; ?> mm/L</b><?php if ($rowdata['kpxx'] <> '0') { ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Kompartemen III = <b><?php echo $rowdata['kpxx']; ?> mm/L</b><?php } ?></small><?php if ($rowdata['kpx'] <> '0') { ?><br>
          <small style="font-family:arial; line-height:0.6; font-size:8pt; padding-left:15px;">- Kompartemen II = <b><?php echo $rowdata['kpx']; ?> mm/L</b><?php if ($rowdata['kpxxx'] <> '0') { ?>&nbsp;&nbsp;&nbsp;&nbsp;- Kompartemen IV = <b><?php echo $rowdata['kpxxx']; ?> mm/L</b><?php } ?></small><?php } ?><br>
        <small style="font-family:arial; line-height:0.6; font-size:8pt;">5. <b>Ruang Kosong TUM</b></small><br>
        <small style="font-family:arial; line-height:0.6; font-size:8pt; padding-left:15px;">- Kompartemen I = <b><?php echo $rowdata['ks']; ?> L</b><?php if ($rowdata['ksxx'] <> '0') { ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Kompartemen III = <b><?php echo $rowdata['ksxx']; ?> L</b><?php } ?></small><?php if ($rowdata['ksx'] <> '0') { ?><br>
          <small style="font-family:arial; line-height:0.6; font-size:8pt; padding-left:15px;">- Kompartemen II = <b><?php echo $rowdata['ksx']; ?> L</b><?php if ($rowdata['ksxxx'] <> '0') { ?>&nbsp;&nbsp;&nbsp;&nbsp;- Kompartemen IV = <b><?php echo $rowdata['ksxxx']; ?> L</b><?php } ?></small><?php } ?><br>
        <small style="font-family:arial; line-height:0.6; font-size:8pt;">6. Hasil pengujian sepenuhnya menjadi tanggung jawab penera</small>

      <?php } else {

        $sqldata = $db_con->prepare("SELECT * FROM alattb WHERE id_al=:pengukuran ORDER BY id_al DESC LIMIT 1");
        $sqldata->execute(array(":pengukuran" => $pengukuran));
        $rowdata = $sqldata->fetch(PDO::FETCH_ASSOC);

        if ($rowdata['tera'] == 1) {
          $mytera = "Tera";
        } else {
          $mytera = "Tera Ulang";
        }

        $susj = $db_con->prepare("SELECT * FROM subjenistb WHERE id_sj=:sj ORDER BY id_sj DESC LIMIT 1");
        $susj->execute(array(":sj" => $rowdata['id_sj']));
        $rowsj = $susj->fetch(PDO::FETCH_ASSOC);

        $lam = $db_con->prepare("SELECT COUNT(*) AS jum FROM lampirantb WHERE id_al=:al");
        $lam->execute(array(":al" => $rowdata['id_al']));
        $rowlam = $lam->fetch(PDO::FETCH_ASSOC);

        if ($rowlam['jum'] == 1) {
          $sulam = $db_con->prepare("SELECT * FROM lampirantb WHERE id_al=:al ORDER BY id_lp DESC LIMIT 1");
          $sulam->execute(array(":al" => $row['pengukuran']));
          $rowsulam = $sulam->fetch(PDO::FETCH_ASSOC);
          if ($rowdata['notaksi'] <> '') {
            $dmerek = $rowsulam['merek'] . " / " . $rowsulam['tipe'];
            $dseri = $rowsulam['seri'];
          } else {
            $dmerek = $rowsulam['merek'] . " / " . $rowsulam['buatan'];
            $dseri = $rowsulam['seri'] . " / " . $rowsulam['kapasitas'];
            $dmodel = $rowsulam['tipe'];
          }
        } else {
          $dmerek = "Terlampir";
          $dseri = "Terlampir";
          $dmodel = "Terlampir";
        }

      ?>

        <table width="100%" border="0" style="font-family:arial; line-height:0.9; font-size:11pt;">
          <tr>
            <td width="30%" align="left" valign="top"><b><u>NAMA ALAT</u></b><br><i><small>Measuring instrument</small></i><br><br></td>
            <td width="5%" align="center" valign="top">:</td>
            <td width="65%" align="left" valign="top"><b><?php echo $rowsj['nama']; ?>, <?php echo $rowlam['jum']; ?> (<?php echo $terbilang->terbilang($rowlam['jum']); ?>) unit</b></td>
          </tr>
          <?php if ($rowdata['notaksi'] <> '') { ?>
            <tr>
              <td width="30%" align="left" valign="top" style="padding-left:30px;"><u>Merek / Tipe</u><br><i><small>Trade Mark / Type</small></i><br><br></td>
              <td width="5%" align="center" valign="top">:</td>
              <td width="65%" align="left" valign="top"><?php echo $dmerek; ?></td>
            </tr>
            <tr>
              <td width="30%" align="left" valign="top" style="padding-left:30px;"><u>Nomor Seri</u><br><i><small>Serial Number</small></i><br><br></td>
              <td width="5%" align="center" valign="top">:</td>
              <td width="65%" align="left" valign="top"><?php echo $dseri; ?></td>
            </tr>
          <?php } else { ?>
            <tr>
              <td width="30%" align="left" valign="top" style="padding-left:30px;"><u>Merek / Buatan</u><br><i><small>Trade Mark / Manufactured by</small></i><br><br></td>
              <td width="5%" align="center" valign="top">:</td>
              <td width="65%" align="left" valign="top"><?php echo $dmerek; ?></td>
            </tr>
            <tr>
              <td width="30%" align="left" valign="top" style="padding-left:30px;"><u>Nomor Seri / Kapasitas</u><br><i><small>Serial Number / Capacity</small></i><br><br></td>
              <td width="5%" align="center" valign="top">:</td>
              <td width="65%" align="left" valign="top"><?php echo $dseri; ?></td>
            </tr>
            <tr>
              <td width="30%" align="left" valign="top" style="padding-left:30px;"><u>Model / Tipe</u><br><i><small>Model / Type</small></i><br><br></td>
              <td width="5%" align="center" valign="top">:</td>
              <td width="65%" align="left" valign="top"><?php echo $dmodel; ?></td>
            </tr>
          <?php } ?>
          <?php if ($rowdata['notaksi'] <> '') { ?>
            <tr>
              <td width="30%" align="left" valign="top"><b><u>MEREK KENDARAAN</u></b><br><i><small>Trade Mark</small></i><br><br></td>
              <td width="5%" align="center" valign="top">:</td>
              <td width="65%" align="left" valign="top"><?php echo $rowdata['merek']; ?></td>
            </tr>
            <tr>
              <td width="30%" align="left" valign="top"><b><u>NO. POL / NO. TAKSI</u></b><br><i><small>Police Number / Taxi Number</small></i><br><br></td>
              <td width="5%" align="center" valign="top">:</td>
              <td width="65%" align="left" valign="top"><b><?php echo strtoupper($rowdata['nopol']); ?> / <?php echo $rowdata['notaksi']; ?></b></td>
            </tr>
            <tr>
              <td width="30%" align="left" valign="top"><b><u>PEMILIK / ALAMAT</u></b><br><i><small>User / Address</small></i><br><br></td>
              <td width="5%" align="center" valign="top">:</td>
              <td width="65%" align="left" valign="top"><b><?php echo strtoupper($rowdata['pemilik']); ?></b><br><?php echo $rowdata['alamatx']; ?></td>
            </tr>
          <?php } else { ?>
            <tr>
              <td width="30%" align="left" valign="top"><b><u>PEMAKAI / ALAMAT</u></b><br><i><small>User / Address</small></i><br><br></td>
              <td width="5%" align="center" valign="top">:</td>
              <td width="65%" align="left" valign="top"><b><?php echo strtoupper($rowdata['pemakai']); ?></b><br><?php echo $rowdata['alamat']; ?></td>
            </tr>
            <?php if ($rowdata['spbu'] <> '') { ?>
              <tr>
                <td width="30%" align="left" valign="top"><b><u>NOMOR SPBU</u></b><br><br></td>
                <td width="5%" align="center" valign="top">:</td>
                <td width="65%" align="left" valign="top"><b><?php echo $rowdata['spbu']; ?></b></td>
              </tr>
            <?php } else {
              echo "";
            } ?>
            <tr>
              <td width="30%" align="left" valign="top"><b><u style="line-height:1.3;">STANDAR DAN KETERTELUSURAN</u></b><br><i><small>Standard and Traceability</small></i><br><br></td>
              <td width="5%" align="center" valign="top">:</td>
              <td width="65%" align="left" valign="top"><?php echo $rowdata['standar']; ?></td>
            </tr>
          <?php } ?>
          <tr>
            <td width="30%" align="left" valign="top"><b><u>TANGGAL PENGUJIAN</u></b><br><i><small>Date of Calibration</small></i><br><br></td>
            <td width="5%" align="center" valign="top">:</td>
            <td width="65%" align="left" valign="top"><b><?php if ($rowdata['tgl'] <> "0000-00-00") {
                                                            $tanggal->contanggalx(substr($rowdata['tgl'], 8, 2), substr($rowdata['tgl'], 5, 2), substr($rowdata['tgl'], 0, 4));
                                                          } else {
                                                            echo "";
                                                          } ?></b></td>
          </tr>
          <tr>
            <td width="30%" align="left" valign="top"><b><u>DIUJI OLEH</u></b><br><i><small>Calibrated by</small></i><br><br></td>
            <td width="5%" align="center" valign="top">:</td>
            <td width="65%" align="left" valign="top"><b><?php echo $rowdata['penguji']; ?></b></td>
          </tr>
          <tr>
            <td width="30%" align="left" valign="top"><b><u>METODE</u></b><br><i><small>Method</small></i><br><br></td>
            <td width="5%" align="center" valign="top">:</td>
            <td width="65%" align="left" valign="top"><?php echo $rowdata['metode']; ?></td>
          </tr>
          <tr>
            <td width="30%" align="left" valign="top"><b><u>HASIL PENGUJIAN</u></b><br><i><small>Result</small></i><br><br></td>
            <td width="5%" align="center" valign="top">:</td>
            <td width="65%" align="left" valign="top"><b>Disahkan "<?php echo strtoupper($mytera); ?>" Tahun <?php echo $rowdata['tahun']; ?></b></td>
          </tr>
          <tr>
            <td width="30%" align="left" valign="top"><b><u>BERLAKU s/d</u></b><br><i><small>Due to</small></i><br><br></td>
            <td width="5%" align="center" valign="top">:</td>
            <td width="65%" align="left" valign="top"><b><?php if ($rowdata['berlaku'] <> "0000-00-00") {
                                                            $tanggal->contanggalx(substr($rowdata['berlaku'], 8, 2), substr($rowdata['berlaku'], 5, 2), substr($rowdata['berlaku'], 0, 4));
                                                          } else {
                                                            echo "";
                                                          } ?></b>, kecuali <b>Tanda tera rusak</b> / <b>segel putus</b> atau penyerahannya menyimpang dari batas toleransi yang diizinkan</td>
          </tr>
        </table>

        <br>

        <table width="100%" border="0" style="font-family:arial; line-height:1; font-size:11pt;">
          <tr>
            <td width="40%" align="center">
            </td>
            <td width="60%" align="center">
              <p><b>DISAHKAN BERDASARKAN UU RI NO 2 TAHUN 1981<br>TENTANG METROLOGI LEGAL DENGAN MEMBUBUHKAN<br>TANDA TERA SAH DAN JAMINAN</b></p>
              <p>Padang, <?php if ($row['tgl'] <> "0000-00-00") {
                            $tanggal->contanggalx(substr($row['tgl'], 8, 2), substr($row['tgl'], 5, 2), substr($row['tgl'], 0, 4));
                          } else {
                            echo "";
                          } ?><br>
                <?php if ($rowpj['id_pj'] == 2) {
                  echo "a/n Kepala UPTD Metrologi Legal<br>" . $rowpj['jabatan'];
                } else {
                  echo $rowpj['jabatan'];
                } ?></p>
              <img src="../img/ttd.png" width="140px" alt="">
              <p><b><u><?php echo $rowpj['nama']; ?></u><br>NIP. <?php echo $rowpj['nip']; ?></b></p>
            </td>
          </tr>
        </table>
        <br><br><br><br><br>
        <small style="font-family:arial; line-height:0.9; font-size:11pt">NB : Hasil pengujian sepenuhnya menjadi tanggung jawab penera</small>
        <hr class="footer">
        <small style="font-family:arial; line-height:0.9; font-size:11pt">Dilarang menggandakan sebagian isi sertifikat ini tanpa seijin dari UPTD Metrologi Legal Kota Padang</small>

      <?php } ?>

    </body>

    </html>
<?php
  } else {
    echo "Tidak ada data yang dapat di tampilkan :(";
  }
} else {
  echo "Tidak ada data yang dapat di tampilkan :(";
}
?>