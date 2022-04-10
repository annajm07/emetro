<?php
if (!defined('_VALID_ACCESS')) {
    header("location: index.php");
    die;
}

// if (isset($_GET['act']) == 'delete') {
//     $sql = $db_con->prepare("DELETE FROM keluhantb WHERE id=:id");
//     $sql->bindParam(':id', $_GET['id']);
//     $sql->execute();
//     die();
// }

session_start();

isLogin();
isKepala_uptd();


$stmt = $db_con->prepare("SELECT * FROM usertb WHERE id_us=:uid ORDER BY id_us DESC LIMIT 1");
$stmt->execute(array(":uid" => $_SESSION['user_session']));
$rowuser = $stmt->fetch(PDO::FETCH_ASSOC);

$tanggal = new tanggal;
$keluhan = new Keluhan($db_con);

$atas = 'sistem/header.php';
if (file_exists($atas)) {
    include_once "$atas";
} else {
    header("Location: error.php");
    die;
}

// cek permintaan tampil
if (isset($_GET['act'])) {
    $act = $_GET['act'];
} else {
    $act = null;
}

if (isset($_GET['id'])) {
    $sql = $db_con->prepare("SELECT * FROM keluhantb WHERE id=:id");
    $sql->bindParam(':id', $_GET['id']);
    $sql->execute();
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $iid = $_GET['id'];
    } else {
        $iid = null;
    }
} else {
    $iid = null;
}

// cek permintaaan hapus
if ($act == 'delete' && $iid != null) {
    $sql = $db_con->prepare("DELETE FROM keluhantb WHERE id=:id");
    $sql->bindParam(':id', $iid);
    if ($sql->execute()) {
        $_SESSION['flash'] = true;
    }
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
    <?php if ($act == 'view' && $iid != null) : ?>
        <section class="content">

            <!-- Default box -->
            <div class="box" style="min-height: 510px;">
                <div class="box-header with-border">
                    <h3 class="box-title">Detail Pengaduan Masuk</h3>
                </div>
                <div class="box-body" style="margin: auto;">
                    <div class="col-md-7" style="margin-top: 5px; margin-left: 20%;">
                        <div class="form-group has-feedback">
                            <label class="control-label">JUDUL</label>
                            <input type="text" class="form-control" name="judul" id="judul" disabled value="<?= $row['judul']; ?>">
                            <span id="check-e"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <label class="control-label">ISI</label>
                            <textarea class="form-control" rows="7" name="isi" id="isi" disabled><?= $row['isi']; ?></textarea>
                        </div>
                        <div class="form-group has-feedback">
                            <label class="control-label">WAKTU</label>
                            <input type="text" class="form-control" name="judul" id="judul" disabled value="<?= $row['logtime']; ?>">
                            <span id="check-e"></span>
                        </div>
                        <div class="box-footer">
                            <a class="btn btn-default" href="<?php echo $urlweb; ?>sistem.php?sistem=pengaduanMs"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php else : ?>
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Daftar Pengaduan Masuk</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Judul</th>
                                    <th>Isi Keluhan</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $query = "SELECT * FROM keluhantb";
                                $records_per_page = 10;
                                $newquery = $keluhan->paging($query, $records_per_page);
                                $keluhan->dataview($newquery, $records_per_page);
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination-wrap">
                        <?php
                        $self = "sistem.php?sistem=pengaduanMs";

                        $stmt = $db_con->prepare($query);
                        $stmt->execute();

                        $total_no_of_records = $stmt->rowCount();

                        $mypagination = 'inc/app.pagination.php';
                        if (file_exists($mypagination)) {
                            include_once "$mypagination";
                        }
                        ?>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">

                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->

        </section>
    <?php endif; ?>
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
if (isset($_SESSION['flash'])) : ?>
    <script type="text/javascript">
        $.notify({
            title: "",
            message: "Data Pengaduan Berhasil Dihapus",
            icon: 'fa fa-check'
        }, {
            type: "success"
        });
    </script>

<?php unset($_SESSION['flash']);
endif; ?>