<?php
if (!defined('_VALID_ACCESS')) {
    header("location: index.php");
    die;
}

session_start();

if (!isset($_SESSION['user_session'])) {
    header("location:sistem.php?sistem=login&x=");
    die;
}

$sertifikat = new sertifikat($db_con);
// $statement = $db_con->prepare("SELECT * FROM sertifikattb WHERE status=:status ORDER BY id_us DESC");
// $statement->execute(array(":status" => 0));
// $data = $statement->fetchAll(PDO::FETCH_ASSOC);

// data file header
$stmt = $db_con->prepare("SELECT * FROM usertb WHERE id_us=:uid ORDER BY id_us DESC LIMIT 1");
$stmt->execute(array(":uid" => $_SESSION['user_session']));
$rowuser = $stmt->fetch(PDO::FETCH_ASSOC);

$tanggal = new tanggal;

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
                <h3 class="box-title">Konfirmasi Sertifikat</h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Pengukuran</th>
                                <th>Nomor SKHP</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $query = "SELECT * FROM sertifikattb WHERE status= 0";
                            $records_per_page = 10;
                            $newquery = $sertifikat->paging($query, $records_per_page);
                            $sertifikat->dataview($newquery, $records_per_page);
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="pagination-wrap">
                    <?php
                    $self = "sistem.php?sistem=kepala";

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
                *Konfirmasi untuk mendapatkan akses cetak sertifikat pada hak akses kasubag
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



<?php
if (isset($_SESSION['sKr'])) : ?>
    <script type="text/javascript">
        $.notify({
            title: "",
            message: "Sertifikat Berhasil Dikonfrimasi",
            icon: 'fa fa-check'
        }, {
            type: "success"
        });
    </script>

<?php unset($_SESSION['sKr']);
endif; ?>