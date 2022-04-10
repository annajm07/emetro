<?php
if (!defined('_VALID_ACCESS')) {
    header("location: index.php");
    die;
}

session_start();

isLogin();
isKasubag();

if (base64_decode($_SESSION['type_session']) == "admin") {
    header("Location: sistem.php?sistem=user");
    die();
}

$stmt = $db_con->prepare("SELECT * FROM usertb WHERE id_us=:uid ORDER BY id_us DESC LIMIT 1");
$stmt->execute(array(":uid" => $_SESSION['user_session']));
$rowuser = $stmt->fetch(PDO::FETCH_ASSOC);

$tanggal = new tanggal;

$pengajuan = new Ajukan($db_con);

$atas = 'sistem/header.php';
if (file_exists($atas)) {
    include_once "$atas";
} else {
    header("Location: error.php");
    die;
}

$mytahun = date('Y');
if (isset($_GET["act"])) {
    $act = $_GET["act"];
} else {
    $act = "";
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

<script type="text/javascript" src="<?php echo $urlweb; ?>js/bootstrap-notify.min.js"></script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-envelope"></i> Pengajuan Masuk
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

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Daftar Pengajuan Masuk</h3>
            </div>
            <div class="box-body">
                <form id="cari-form" method="post" class="form-horizontal">
                    <div class="form-group">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" id="cari" name="cari" class="form-control" placeholder="Cari daftar pengajuan...">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary" name="btn-cari"><i class="fa fa-search"></i> Cari</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                if (isset($_POST['btn-cari']) && $_POST['cari'] <> '') {
                    $cari = '%' . $_POST['cari'] . '%';
                    $sqlcari = $db_con->prepare("SELECT * FROM pengajuantb WHERE kode_pengaju LIKE :kode");
                    $sqlcari->bindParam(':kode', $cari);
                    $sqlcari->execute();
                    $countcari = $sqlcari->rowCount();
                ?>
                    <p>Hasil Pencarian data pengajuan dengan kode <span class="badge"><?php echo $_POST['cari']; ?></p>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Pengaju</th>
                                    <th>Kode</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Jenis</th>
                                    <th>Pemakai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                $no = 1;
                                while ($rowcari = $sqlcari->fetch(PDO::FETCH_ASSOC)) {
                                    $susj = $db_con->prepare("SELECT nama FROM subjenistb WHERE id_sj=:sj ORDER BY id_sj DESC LIMIT 1");
                                    $susj->execute(array(":sj" => $rowcari['id_png']));
                                    $rowsj = $susj->fetch(PDO::FETCH_ASSOC);
                                ?>
                                    <tr>
                                        <td><?php print($no); ?></td>
                                        <td><?php print($rowcari['nama_pnj']); ?></td>
                                        <td><?php print($rowcari['kode_pengaju']); ?></td>
                                        <td><?php print($rowcari['tanggal']); ?></td>
                                        <td><?php print($rowsj['nama']); ?></td>
                                        <td><?php print($rowcari['pemakai']); ?></td>
                                        <td align="center">
                                            <a href="sistem.php?sistem=home&act=entri&gn=<?php echo $rowcari['id_png']; ?>"><i class="fa fa-share-square"></i> Generate</a>
                                        </td>

                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <a class="btn btn-default" href="<?php echo $urlweb; ?>sistem.php?sistem=home"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                <?php
                } else {
                ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Pengaju</th>
                                    <th>Kode</th>
                                    <th>Pekerjaan</th>
                                    <th>Email</th>
                                    <th>No Hp</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                $query = "SELECT * FROM pengajuantb ORDER BY id_png DESC";
                                $records_per_page = 10;
                                $newquery = $pengajuan->paging($query, $records_per_page);
                                $pengajuan->dataview($newquery, $records_per_page);
                                ?>

                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-wrap">
                        <?php
                        $self = "sistem.php?sistem=pengajuan";

                        $stmt = $db_con->prepare($query);
                        $stmt->execute();

                        $total_no_of_records = $stmt->rowCount();

                        $mypagination = 'inc/app.pagination.php';
                        if (file_exists($mypagination)) {
                            include_once "$mypagination";
                        }
                        ?>
                    </div>

                <?php
                }
                ?>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                *Klik tombol generate untuk mengkonversi data pengajuan
            </div>
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