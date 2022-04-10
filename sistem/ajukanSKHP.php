<?php
if (!defined('_VALID_ACCESS')) {
    header("location: index.php");
    die;
}

session_start();

isLogin();
isUmum();

$sertifikat = new sertifikat($db_con);
// $statement = $db_con->prepare("SELECT * FROM sertifikattb WHERE status=:status ORDER BY id_us DESC");
// $statement->execute(array(":status" => 0));
// $data = $statement->fetchAll(PDO::FETCH_ASSOC);

// data file header
$stmt = $db_con->prepare("SELECT * FROM usertb WHERE id_us=:uid ORDER BY id_us DESC LIMIT 1");
$stmt->execute(array(":uid" => $_SESSION['user_session']));
$rowuser = $stmt->fetch(PDO::FETCH_ASSOC);

$tanggal = new tanggal;

// simpan

$ajukan = new Ajukan($db_con);


if (isset($_POST['kirim'])) {
    // var_dump($_SESSION['user_session']);
    // die();
    $nama = $_POST['nama'];
    $idUser = $_SESSION['user_session'];
    $email = $_POST['email'];
    $pekerjaan = $_POST['pekerjaan'];
    $no_hp = $_POST['no_hp'];
    $kode = base64_encode(random_bytes(6));
    $time = date('Y-m-d');
    $jenis = $_POST['j_uttp'];
    $pasar = $_POST['pasar'];
    $pemakai = $_POST['pemakai'];
    $alamat = $_POST['alamat'];
    $spbu = $_POST['spbu'];
    $nip = $_POST['nip'];
    $merk = $_POST['merek'];
    $nopol = $_POST['nopol'];
    $notaksi = $_POST['notaksi'];
    $pemilik = $_POST['pemilik'];
    $almt = $_POST['alamat'];


    if ($ajukan->create($idUser, $nama, $pekerjaan, $email, $no_hp, $kode, $time, $jenis, $pasar, $pemakai, $alamat, $spbu, $nip, $merk, $nopol, $notaksi, $pemilik, $almt)) {
        $_SESSION['notif'] = true;
        header("location:http://localhost:8080/emetro/sistem.php?sistem=ajukanSKHP");
        die();
    }
}
// akhir simpan

$atas = 'sistem/header.php';
if (file_exists($atas)) {
    include_once "$atas";
} else {
    header("Location: error.php");
    die;
}

?>

<?php
$side = 'sistem/side.php';
if (file_exists($side)) {
    include_once "$side";
} else {
    header("Location: error.php");
    die;
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-search"></i> Cari SKHP
            <small><?php echo $appnames; ?></small>
        </h1>
        <?php
        $bmenu = 'sistem/bmenu.php';
        if (file_exists($bmenu)) {
            include_once "$bmenu";
        } else {
            echo "";
        }
        ?>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Ajukan SKHP</h3>
            </div>
            <form id="entri-form" method="post" class="form-horizontal" action="<?= $urlweb; ?>sistem.php?sistem=ajukanSKHP">

                <div class="box-body">

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="nama">Nama Pengaju</label>
                        <div class="col-lg-4">
                            <input type="text" id="nama" name="nama" class="form-control" maxlength="30" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="nama">NIK</label>
                        <div class="col-lg-4">
                            <input type="text" id="nip" name="nip" class="form-control" maxlength="30" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="nama">Pekerjaan</label>
                        <div class="col-lg-4">
                            <input type="text" id="pekerjaan" name="pekerjaan" class="form-control" maxlength="30" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="nama">Email</label>
                        <div class="col-lg-4">
                            <input type="email" id="email" name="email" id="email" class="form-control" maxlength="30" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="nama">No Hp</label>
                        <div class="col-lg-4">
                            <input type="text" id="no_hp" name="no_hp" class="form-control" maxlength="30" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="jenis">Jenis UTTP</label>
                        <div class="col-lg-5">
                            <select class="form-control" id="j_uttp" name="j_uttp" onchange="showMeterTaksi();">
                                <option value="">== Pilih Jenis UTTP ==</option>
                                <?php
                                $sqlsj = $db_con->prepare("SELECT * FROM subjenistb ORDER BY nama ASC");
                                $sqlsj->execute();
                                while ($rowsj = $sqlsj->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <option value="<?php echo $rowsj['id_sj']; ?>"><?php echo $rowsj['nama']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="pasar">Pasar</label>
                        <div class="col-lg-5">
                            <select class="form-control" id="pasar" name="pasar">
                                <option value="">== Pilih Pasar ==</option>
                                <?php
                                $sqlps = $db_con->prepare("SELECT * FROM pasartb ORDER BY id_ps ASC");
                                $sqlps->execute();
                                while ($rowps = $sqlps->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <option value="<?php echo $rowps['id_ps']; ?>"><?php echo $rowps['nama']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="pemakai">Pemakai</label>
                        <div class="col-lg-8">
                            <input type="text" id="pemakai" name="pemakai" class="form-control" maxlength="100" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="alamat">Alamat</label>
                        <div class="col-lg-8">
                            <input type="text" id="alamat" name="alamat" class="form-control" maxlength="200" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="spbu">Nomor SPBU</label>
                        <div class="col-lg-8">
                            <input type="text" id="spbu" name="spbu" class="form-control" maxlength="100">
                            <span class="help-block">*Kalau bukan SPBU, harap kosongkan saja.</span>
                        </div>
                    </div>



                    <!-- <div class="form-group">
        <label class="col-lg-3 control-label" for="nip">NIP</label>
        <div class="col-lg-4">
            <input type="text" id="nip" name="nip" class="form-control" maxlength="30" >
        </div>
    </div> -->
                    <div id="showMeter" style="display: none;">
                        <hr>
                        <h4>Meter Taksi</h4>
                        <p>Tambahan formulir isian untuk meter taksi (*isi jika pengukuran meter taksi saja)</p>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="merek">Merek Kendaraan</label>
                            <div class="col-lg-5">
                                <input type="text" id="merek" name="merek" class="form-control" maxlength="100">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="nopol">No. Pol</label>
                            <div class="col-lg-3">
                                <input type="text" id="nopol" name="nopol" class="form-control" maxlength="10">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="notaksi">No. Taksi</label>
                            <div class="col-lg-3">
                                <input type="text" id="notaksi" name="notaksi" class="form-control" maxlength="10">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="pemilik">Pemilik</label>
                            <div class="col-lg-8">
                                <input type="text" id="pemilik" name="pemilik" class="form-control" maxlength="100">
                            </div>
                        </div>
                    </div>
                    <!-- <div class="form-group">
        <label class="col-lg-3 control-label" for="alamatx">Alamat</label>
        <div class="col-lg-8">
            <input type="text" id="alamatx" name="alamatx" class="form-control" maxlength="200">
        </div>
    </div> -->

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="kirim"><i class="fa fa-check-square-o"></i> Submit</button>&nbsp;&nbsp;
                    <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>&nbsp;&nbsp;
                    <a class="btn btn-default" href="<?php echo $urlweb; ?>"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                </div>
                <!-- /.box-footer-->

            </form>
            <!-- /.box-body -->
            <!-- <div class="box-footer">
                *Konfirmasi untuk mendapatkan akses cetak sertifikat pada hak akses kasubag
            </div> -->
            <!-- /.box-footer-->
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->


</div>
<!-- /.content-wrapper -->

<?php
$bawah = 'sistem/footer.php';
if (file_exists($bawah)) {
    include_once "$bawah";
} else {
    header("Location: error.php");
    die;
}
?>



<?php
if (isset($_SESSION['notif'])) : ?>
    <script type="text/javascript">
        $.notify({
            title: "",
            message: "Data Pengajuan Berhasil Ditambahkan",
            icon: 'fa fa-check'
        }, {
            type: "success"
        });
    </script>

<?php unset($_SESSION['notif']);
endif; ?>

<script>
    function showMeterTaksi() {

        const formMeter = document.getElementById("showMeter");
        const meter = document.getElementById("j_uttp");
        console.log(meter.value);
        if (meter.value == 7) {
            formMeter.style.display = "block";
        } else {
            formMeter.style.display = "none";
        }

    }
</script>