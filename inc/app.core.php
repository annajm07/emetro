<?php
if (!defined('_VALID_ACCESS')) {
	header("location: index.php");
	die;
}

try {
	$db_con = new PDO("mysql:host={$db_host};dbname={$db_name}", $db_user, $db_pass);
	$db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo $e->getMessage();
}

//class tanggal
class tanggal
{
	function tanggalkini()
	{
		$y = date("Y");
		$d = date("d");
		$D = date("D");
		$m = date("m");

		switch ($m) {
			case "01":
				$b = "Januari";
				break;
			case "02":
				$b = "Februari";
				break;
			case "03":
				$b = "Maret";
				break;
			case "04":
				$b = "April";
				break;
			case "05":
				$b = "Mei";
				break;
			case "06":
				$b = "Juni";
				break;
			case "07":
				$b = "Juli";
				break;
			case "08":
				$b = "Agustus";
				break;
			case "09":
				$b = "September";
				break;
			case "10":
				$b = "Oktober";
				break;
			case "11":
				$b = "November";
				break;
			default:
				$b = "Desember";
		}

		switch ($D) {
			case "Mon":
				$h = "Senin";
				break;
			case "Tue":
				$h = "Selasa";
				break;
			case "Wed":
				$h = "Rabu";
				break;
			case "Thu":
				$h = "Kamis";
				break;
			case "Fri":
				$h = "Jum'at";
				break;
			case "Sat":
				$h = "Sabtu";
				break;
			default:
				$h = "Minggu";
		}

		echo $h . ", " . $d . " " . $b . " " . $y;
	}

	function tanggalkinis()
	{
		$y = date("Y");
		$d = date("d");
		$m = date("m");

		switch ($m) {
			case "01":
				$b = "Januari";
				break;
			case "02":
				$b = "Februari";
				break;
			case "03":
				$b = "Maret";
				break;
			case "04":
				$b = "April";
				break;
			case "05":
				$b = "Mei";
				break;
			case "06":
				$b = "Juni";
				break;
			case "07":
				$b = "Juli";
				break;
			case "08":
				$b = "Agustus";
				break;
			case "09":
				$b = "September";
				break;
			case "10":
				$b = "Oktober";
				break;
			case "11":
				$b = "November";
				break;
			default:
				$b = "Desember";
		}

		echo $d . " " . $b . " " . $y;
	}

	function pilbulan($bulan)
	{
		switch ($bulan) {
			case "01":
				$b = "Januari";
				break;
			case "02":
				$b = "Februari";
				break;
			case "03":
				$b = "Maret";
				break;
			case "04":
				$b = "April";
				break;
			case "05":
				$b = "Mei";
				break;
			case "06":
				$b = "Juni";
				break;
			case "07":
				$b = "Juli";
				break;
			case "08":
				$b = "Agustus";
				break;
			case "09":
				$b = "September";
				break;
			case "10":
				$b = "Oktober";
				break;
			case "11":
				$b = "November";
				break;
			default:
				$b = "Desember";
		}

		echo $b;
	}

	function pilbulanx($bulanx)
	{
		switch ($bulanx) {
			case "01":
				$bx = "I";
				break;
			case "02":
				$bx = "II";
				break;
			case "03":
				$bx = "III";
				break;
			case "04":
				$bx = "IV";
				break;
			case "05":
				$bx = "V";
				break;
			case "06":
				$bx = "VI";
				break;
			case "07":
				$bx = "VII";
				break;
			case "08":
				$bx = "VIII";
				break;
			case "09":
				$bx = "IX";
				break;
			case "10":
				$bx = "X";
				break;
			case "11":
				$bx = "XI";
				break;
			default:
				$bx = "XII";
		}

		echo $bx;
	}

	function contanggal($dc, $mc, $yc)
	{
		$datec = strtotime($mc . "/" . $dc . "/" . $yc);
		$hd = date("D", $datec);
		switch ($hd) {
			case "Mon":
				$hc = "Senin";
				break;
			case "Tue":
				$hc = "Selasa";
				break;
			case "Wed":
				$hc = "Rabu";
				break;
			case "Thu":
				$hc = "Kamis";
				break;
			case "Fri":
				$hc = "Jum'at";
				break;
			case "Sat":
				$hc = "Sabtu";
				break;
			default:
				$hc = "Minggu";
		}
		switch ($mc) {
			case "01":
				$bc = "Januari";
				break;
			case "02":
				$bc = "Februari";
				break;
			case "03":
				$bc = "Maret";
				break;
			case "04":
				$bc = "April";
				break;
			case "05":
				$bc = "Mei";
				break;
			case "06":
				$bc = "Juni";
				break;
			case "07":
				$bc = "Juli";
				break;
			case "08":
				$bc = "Agustus";
				break;
			case "09":
				$bc = "September";
				break;
			case "10":
				$bc = "Oktober";
				break;
			case "11":
				$bc = "November";
				break;
			default:
				$bc = "Desember";
		}

		echo $hc . ", " . $dc . " " . $bc . " " . $yc;
	}

	function contanggalx($dc, $mc, $yc)
	{
		switch ($mc) {
			case "01":
				$bc = "Januari";
				break;
			case "02":
				$bc = "Februari";
				break;
			case "03":
				$bc = "Maret";
				break;
			case "04":
				$bc = "April";
				break;
			case "05":
				$bc = "Mei";
				break;
			case "06":
				$bc = "Juni";
				break;
			case "07":
				$bc = "Juli";
				break;
			case "08":
				$bc = "Agustus";
				break;
			case "09":
				$bc = "September";
				break;
			case "10":
				$bc = "Oktober";
				break;
			case "11":
				$bc = "November";
				break;
			default:
				$bc = "Desember";
		}

		echo $dc . " " . $bc . " " . $yc;
	}

	function time_since($original)
	{
		date_default_timezone_set('Asia/Jakarta');
		$chunks = array(
			array(60 * 60 * 24 * 365, 'tahun'),
			array(60 * 60 * 24 * 30, 'bulan'),
			array(60 * 60 * 24 * 7, 'minggu'),
			array(60 * 60 * 24, 'hari'),
			array(60 * 60, 'jam'),
			array(60, 'menit'),
		);

		$today = time();
		$since = $today - $original;

		for ($i = 0, $j = count($chunks); $i < $j; $i++) {
			$seconds = $chunks[$i][0];
			$name = $chunks[$i][1];

			if (($count = floor($since / $seconds)) != 0)
				break;
		}

		$print = ($count == 1) ? '1 ' . $name : "$count {$name}";
		return $print . ' yang lalu';
	}
	function umur($tgllahir)
	{
		list($tahun, $bulan, $tanggal) = explode("-", $tgllahir);
		$th = date("Y") - $tahun;
		$bln = date("m") - $bulan;
		$hr = date("d") - $tanggal;


		if ($bln < 0)
			$th--;
		elseif (($bln == 0) and ($hr < 0))
			$th--;


		echo $th . " Tahun";
	}
}

class terbilang
{
	private $bil;

	public function __construct()
	{
		$this->bil = 0;
	}

	public function terbilang($n)
	{
		$this->bil = $n;
		$bilangan = array("nol", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");

		if ($this->bil < 12) {
			return $bilangan[$this->bil];
		} else if ($this->bil < 20) {
			$b = $this->bil % 10;
			return $this->terbilang($b) . " belas ";
		} else if ($this->bil < 100) {
			$b = $this->bil % 10;
			$c = $this->bil / 10;

			if ($b == 0) {
				return $this->terbilang($c) . " puluh ";
			} else {
				return $this->terbilang($c) . " puluh " . $bilangan[$b];
			}
		} else if ($this->bil < 200) {
			$b = $this->bil % 100;
			$str = "";
			if ($b == 0) {
				return "seratus ";
			} else {
				return "seratus " . $this->terbilang($b);
			}
		} else if ($this->bil < 1000) {
			$b = $this->bil % 100;
			$c = $this->bil / 100;

			if ($b == 0) {
				return $bilangan[$c] . " ratus ";
			} else {
				return $bilangan[$c] . " ratus " . $this->terbilang($b);
			}
		} else if ($this->bil < 2000) {
			$b = $this->bil % 1000;
			$str = "";
			if ($b == 0) {
				return "seribu ";
			} else {
				return "seribu " . $this->terbilang($b);
			}
		} else if ($this->bil < 1000000) {
			$b = $this->bil % 1000;
			$c = $this->bil / 1000;

			if ($b == 0) {
				return $this->terbilang($c) . " ribu ";
			} else {
				return $this->terbilang($c) . " ribu " . $this->terbilang($b);
			}
		} else if ($this->bil < 1000000000) {
			$b = $this->bil % 1000000;
			$c = $this->bil / 1000000;

			if ($b == 0) {
				return $this->terbilang($c) . " juta ";
			} else {
				return $this->terbilang($c) . " juta " . $this->terbilang($b);
			}
		} else if ($this->bil == 1000000000) {
			return $this->terbilang($this->bil / 1000000000) . " milyar ";
		} else {
			return "Maksimal bilangan 1 milyar";
		}
	}
}

//class manipulasi gambar
class mangambar
{
	function cropImage($nw, $nh, $source, $stype, $dest)
	{

		$size = getimagesize($source); // ukuran gambar
		$w = $size[0];
		$h = $size[1];
		switch ($stype) { // format gambar

			case 'gif':
				$simg = imagecreatefromgif($source);
				break;

			case 'jpg':
				$simg = imagecreatefromjpeg($source);
				break;

			case 'png':
				$simg = imagecreatefrompng($source);
				break;
		}

		$dimg = imagecreatetruecolor($nw, $nh); // menciptakan image baru
		$wm = $w / $nw;
		$hm = $h / $nh;

		$h_height = $nh / 2;
		$w_height = $nw / 2;

		if ($w > $h) {

			$adjusted_width = $w / $hm;
			$half_width = $adjusted_width / 2;
			$int_width = $half_width - $w_height;
			imagecopyresampled($dimg, $simg, -$int_width, 0, 0, 0, $adjusted_width, $nh, $w, $h);
		} elseif (($w < $h) || ($w == $h)) {
			$adjusted_height = $h / $wm;
			$half_height = $adjusted_height / 2;
			$int_height = $half_height - $h_height;
			imagecopyresampled($dimg, $simg, 0, -$int_height, 0, 0, $nw, $adjusted_height, $w, $h);
		} else {
			imagecopyresampled($dimg, $simg, 0, 0, 0, 0, $nw, $nh, $w, $h);
		}

		imagejpeg($dimg, $dest, 100);
	}
}

//crud user
class cruduser
{
	private $db;

	function __construct($db_con)
	{
		$this->db = $db_con;
	}

	public function create($imel, $pword, $nama, $jabatan, $telp, $type, $status, $logdate)
	{
		try {
			$stmt = $this->db->prepare("INSERT INTO usertb(imel,pword,nama,jabatan,telp,type,status,logdate) VALUES(:imel, :pword, :nama, :jabatan, :telp, :type, :status, :logdate)");
			$stmt->bindparam(":imel", $imel);
			$stmt->bindparam(":pword", $pword);
			$stmt->bindparam(":nama", $nama);
			$stmt->bindparam(":jabatan", $jabatan);
			$stmt->bindparam(":telp", $telp);
			$stmt->bindparam(":type", $type);
			$stmt->bindparam(":status", $status);
			$stmt->bindparam(":logdate", $logdate);
			$stmt->execute();
			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function getID($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM usertb WHERE id_us=:id");
		$stmt->execute(array(":id" => $id));
		$editRow = $stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}

	public function update($id, $imel, $pword, $nama, $jabatan, $telp, $type)
	{
		try {
			$stmt = $this->db->prepare("UPDATE usertb SET imel=:imel,pword=:pword,nama=:nama,jabatan=:jabatan,telp=:telp,type=:type	WHERE id_us=:id ");
			$stmt->bindparam(":imel", $imel);
			$stmt->bindparam(":pword", $pword);
			$stmt->bindparam(":nama", $nama);
			$stmt->bindparam(":jabatan", $jabatan);
			$stmt->bindparam(":telp", $telp);
			$stmt->bindparam(":type", $type);
			$stmt->bindparam(":id", $id);
			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function delete($id)
	{
		$stmt = $this->db->prepare("DELETE FROM usertb WHERE id_us=:id");
		$stmt->bindparam(":id", $id);
		$stmt->execute();
		return true;
	}

	public function status($id, $status)
	{
		try {
			$stmt = $this->db->prepare("UPDATE usertb SET status=:status WHERE id_us=:id ");
			$stmt->bindparam(":status", $status);
			$stmt->bindparam(":id", $id);
			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	/* data user */

	public function dataview($query, $records_per_page)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute();

		$countstmt = $stmt->rowCount();

		$tanggal = new tanggal;

		if (isset($_GET["page"]))
			$page = $_GET["page"];
		else
			$page = "";

		if ($page)
			$start = ($page - 1) * $records_per_page;
		else
			$start = 0;

		if ($stmt->rowCount() > 0) {
			$no = $start + 1;
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
?>
				<tr>
					<td><?php print($no); ?></td>
					<td><?php print($row['imel']); ?></td>
					<td><?php print($row['nama']); ?></td>
					<td><?php print($row['jabatan']); ?></td>
					<td><?php print(strtoupper(base64_decode($row['type']))); ?></td>
					<td>
						<?php if ($row['status'] == 1) {
							echo "<span class=\"label bg-green\"><i class=\"fa fa-check\"></i> Aktif</span>";
						} else {
							echo "<span class=\"label bg-red\"><i class=\"fa fa-close\"></i> Non Aktif</span>";
						} ?>
					</td>
					<td><?php echo $tanggal->time_since(strtotime($row['logdate'])); ?></td>
					<td align="center">
						<a href="sistem.php?sistem=user&act=view&id=<?php print(base64_encode($row['id_us'])); ?>"><i class="fa fa-search-plus"></i> view</a>
					</td>

				</tr>
			<?php
				$no++;
			}
		} else {
			?>
			<tr>
				<td colspan="8" align="center">Tidak ada data user ditemukan ...</td>
			</tr>
			<?php
		}
	}

	public function paging($query, $records_per_page)
	{
		$starting_position = 0;
		if (isset($_GET["page"])) {
			$starting_position = ($_GET["page"] - 1) * $records_per_page;
		}
		$query2 = $query . " limit $starting_position,$records_per_page";
		return $query2;
	}

	/* data user */
}

// crud keluhan
class Keluhan
{
	private $db;

	function __construct($db_con)
	{
		$this->db = $db_con;
	}

	public function create($judul, $isi, $logtime)
	{
		try {
			$stmt = $this->db->prepare("INSERT INTO keluhantb(judul,isi,logtime) VALUES(:judul, :isi, :logtime)");
			$stmt->bindparam(":judul", $judul);
			$stmt->bindparam(":isi", $isi);
			$stmt->bindparam(":logtime", $logtime);
			$stmt->execute();
			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function dataview($query, $records_per_page)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute();

		$countstmt = $stmt->rowCount();

		if (isset($_GET["page"]))
			$page = $_GET["page"];
		else
			$page = "";

		if ($page)
			$start = ($page - 1) * $records_per_page;
		else
			$start = 0;

		if ($stmt->rowCount() > 0) {
			$no = $start + 1;
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			?>
				<tr>
					<td><?php print($no); ?></td>
					<td><?php print($row['judul']); ?></td>
					<td><?php print($row['isi']); ?></td>
					<td><?php print($row['logtime']); ?></td>
					<td>
						<a href="sistem.php?sistem=pengaduanMs&act=view&id=<?php print($row['id']); ?>" class="mr-2" style="margin-right: 10px;"><i class="fa fa-search-plus"></i> View</a>
						<a href="sistem.php?sistem=pengaduanMs&act=delete&id=<?php print($row['id']); ?>" onclick="return confirm('Apakah anda yakin ingin menghapus ?')"><i class="fa fa-trash"></i> Delete</a>
					</td>

				</tr>
			<?php
				$no++;
			}
		} else {
			?>
			<tr>
				<td colspan="3" align="center">Tidak ada data pasar ditemukan ...</td>
			</tr>
			<?php
		}
	}

	public function paging($query, $records_per_page)
	{
		$starting_position = 0;
		if (isset($_GET["page"])) {
			$starting_position = ($_GET["page"] - 1) * $records_per_page;
		}
		$query2 = $query . " limit $starting_position,$records_per_page";
		return $query2;
	}
}

// crud keluhan
class Ajukan
{
	private $db;

	function __construct($db_con)
	{
		$this->db = $db_con;
	}

	public function create($id_user, $nama, $pekerjaan, $email, $no_hp, $kode, $tanggal, $jenis, $pasar, $pemakai, $alamat, $spbu, $nip, $merk, $nopol, $notaksi, $pemilik, $almt)
	{
		try {
			$stmt = $this->db->prepare("INSERT INTO pengajuantb(id_user,nama_pnj,pekerjaan,email,no_hp,kode_pengaju,tanggal,jenis,pasar,pemakai,alamat,no_spbu,nip,mrk_kdr,no_pol,no_taksi,pemilik,almt) VALUES(:id_user,:nama,:pekerjaan,:email,:no_hp,:kode,:tanggal,:jenis, :pasar, :pemakai, :alamat, :no_spbu, :nip, :mrk_kdr, :no_pol, :no_taksi, :pemilik, :almt)");
			$stmt->bindparam(":id_user", $id_user);
			$stmt->bindparam(":nama", $nama);
			$stmt->bindparam(":pekerjaan", $pekerjaan);
			$stmt->bindparam(":email", $email);
			$stmt->bindparam(":no_hp", $no_hp);
			$stmt->bindparam(":kode", $kode);
			$stmt->bindparam(":tanggal", $tanggal);
			$stmt->bindparam(":jenis", $jenis);
			$stmt->bindparam(":pasar", $pasar);
			$stmt->bindparam(":pemakai", $pemakai);
			$stmt->bindparam(":alamat", $alamat);
			$stmt->bindparam(":no_spbu", $spbu);
			$stmt->bindparam(":nip", $nip);
			$stmt->bindparam(":mrk_kdr", $merk);
			$stmt->bindparam(":no_pol", $nopol);
			$stmt->bindparam(":no_taksi", $notaksi);
			$stmt->bindparam(":pemilik", $pemilik);
			$stmt->bindparam(":almt", $almt);
			$stmt->execute();
			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function getById($id)
	{

		$stmt = $this->db->prepare("SELECT * FROM pengajuantb WHERE id_png=:id");
		$stmt->execute(array(":id" => $id));
		$data = $stmt->fetch(PDO::FETCH_ASSOC);
		return $data;
	}

	public function delete($kode)
	{

		$stmt = $this->db->prepare("DELETE FROM pengajuantb WHERE kode_pengaju=:kode");
		$stmt->execute(array(":kode" => $kode));
	}

	public function dataview($query, $records_per_page)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute();

		// $countstmt = $stmt->rowCount();

		// $tanggal = new tanggal;

		if (isset($_GET["page"]))
			$page = $_GET["page"];
		else
			$page = "";

		if ($page)
			$start = ($page - 1) * $records_per_page;
		else
			$start = 0;

		if ($stmt->rowCount() > 0) {
			$no = $start + 1;
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				// $susj = $this->db->prepare("SELECT nama FROM subjenistb WHERE id_sj=:sj ORDER BY id_sj DESC LIMIT 1");
				// $susj->execute(array(":sj" => $row['jenis']));
				// $rowsj = $susj->fetch(PDO::FETCH_ASSOC);
			?>
				<tr>
					<td><?php print($no); ?></td>
					<td><?php print($row['nama_pnj']); ?></td>
					<td><?php print($row['kode_pengaju']); ?></td>
					<td><?php print($row['pekerjaan']); ?></td>
					<td><?php print($row['email']); ?></td>
					<td><?php print($row['no_hp']); ?></td>
					<td><?php print($row['tanggal']); ?></td>
					<td align="center">
						<a href="sistem.php?sistem=home&act=entri&gn=<?php echo $row['id_png']; ?>"><i class="fa fa-share-square"></i> Generate</a>
					</td>

				</tr>
			<?php
				$no++;
			}
		} else {
			?>
			<tr>
				<td colspan="7" align="center">Tidak ada data pengajuan...</td>
			</tr>
			<?php
		}
	}

	public function paging($query, $records_per_page)
	{
		$starting_position = 0;
		if (isset($_GET["page"])) {
			$starting_position = ($_GET["page"] - 1) * $records_per_page;
		}
		$query2 = $query . " limit $starting_position,$records_per_page";
		return $query2;
	}
}

//crud pejabat
class crudpejabat
{
	private $db;

	function __construct($db_con)
	{
		$this->db = $db_con;
	}

	public function getID($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM pejabattb WHERE id_pj=:id");
		$stmt->execute(array(":id" => $id));
		$editRow = $stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}

	public function update($id, $nama, $jabatan, $nip)
	{
		try {
			$stmt = $this->db->prepare("UPDATE pejabattb SET nama=:nama, jabatan=:jabatan, nip=:nip	WHERE id_pj=:id ");
			$stmt->bindparam(":nama", $nama);
			$stmt->bindparam(":jabatan", $jabatan);
			$stmt->bindparam(":nip", $nip);
			$stmt->bindparam(":id", $id);
			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	/* data pejabat */

	public function dataview($query, $records_per_page)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute();

		$countstmt = $stmt->rowCount();

		if (isset($_GET["page"]))
			$page = $_GET["page"];
		else
			$page = "";

		if ($page)
			$start = ($page - 1) * $records_per_page;
		else
			$start = 0;

		if ($stmt->rowCount() > 0) {
			$no = $start + 1;
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			?>
				<tr>
					<td><?php print($no); ?></td>
					<td><?php print($row['jabatan']); ?></td>
					<td><?php print($row['nama']); ?></td>
					<td><?php print($row['nip']); ?></td>
					<td align="center">
						<a href="sistem.php?sistem=pejabat&act=view&id=<?php print(base64_encode($row['id_pj'])); ?>"><i class="fa fa-search-plus"></i> generate</a>
					</td>

				</tr>
			<?php
				$no++;
			}
		} else {
			?>
			<tr>
				<td colspan="5" align="center">Tidak ada data pejabat ditemukan ...</td>
			</tr>
			<?php
		}
	}

	public function paging($query, $records_per_page)
	{
		$starting_position = 0;
		if (isset($_GET["page"])) {
			$starting_position = ($_GET["page"] - 1) * $records_per_page;
		}
		$query2 = $query . " limit $starting_position,$records_per_page";
		return $query2;
	}

	/* data pejabat */
}

//crud jenis
class crudjenis
{
	private $db;

	function __construct($db_con)
	{
		$this->db = $db_con;
	}

	public function create($nama)
	{
		try {
			$stmt = $this->db->prepare("INSERT INTO jenistb(nama) VALUES(:nama)");
			$stmt->bindparam(":nama", $nama);
			$stmt->execute();
			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function getID($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM jenistb WHERE id_jn=:id");
		$stmt->execute(array(":id" => $id));
		$editRow = $stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}

	public function update($id, $nama)
	{
		try {
			$stmt = $this->db->prepare("UPDATE jenistb SET nama=:nama	WHERE id_jn=:id ");
			$stmt->bindparam(":nama", $nama);
			$stmt->bindparam(":id", $id);
			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	/* data jenis */

	public function dataview($query, $records_per_page)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute();

		$countstmt = $stmt->rowCount();

		if (isset($_GET["page"]))
			$page = $_GET["page"];
		else
			$page = "";

		if ($page)
			$start = ($page - 1) * $records_per_page;
		else
			$start = 0;

		if ($stmt->rowCount() > 0) {
			$no = $start + 1;
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			?>
				<tr>
					<td><?php print($no); ?></td>
					<td><?php print($row['nama']); ?></td>
					<td align="center">
						<a href="sistem.php?sistem=jenis&act=view&id=<?php print(base64_encode($row['id_jn'])); ?>"><i class="fa fa-search-plus"></i> view</a>
					</td>

				</tr>
			<?php
				$no++;
			}
		} else {
			?>
			<tr>
				<td colspan="3" align="center">Tidak ada data jenis ditemukan ...</td>
			</tr>
			<?php
		}
	}

	public function paging($query, $records_per_page)
	{
		$starting_position = 0;
		if (isset($_GET["page"])) {
			$starting_position = ($_GET["page"] - 1) * $records_per_page;
		}
		$query2 = $query . " limit $starting_position,$records_per_page";
		return $query2;
	}

	/* data jenis */
}

//crud subjenis
class crudsubjenis
{
	private $db;

	function __construct($db_con)
	{
		$this->db = $db_con;
	}

	public function create($id_jn, $nama)
	{
		try {
			$stmt = $this->db->prepare("INSERT INTO subjenistb(id_jn,nama) VALUES(:id_jn, :nama)");
			$stmt->bindparam(":id_jn", $id_jn);
			$stmt->bindparam(":nama", $nama);
			$stmt->execute();
			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function getID($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM subjenistb WHERE id_sj=:id");
		$stmt->execute(array(":id" => $id));
		$editRow = $stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}

	public function update($id, $id_jn, $nama)
	{
		try {
			$stmt = $this->db->prepare("UPDATE subjenistb SET id_jn=:id_jn, nama=:nama WHERE id_sj=:id ");
			$stmt->bindparam(":id_jn", $id_jn);
			$stmt->bindparam(":nama", $nama);
			$stmt->bindparam(":id", $id);
			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	/* data subjenis */

	public function dataview($query, $records_per_page)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute();

		$countstmt = $stmt->rowCount();

		if (isset($_GET["page"]))
			$page = $_GET["page"];
		else
			$page = "";

		if ($page)
			$start = ($page - 1) * $records_per_page;
		else
			$start = 0;

		if ($stmt->rowCount() > 0) {
			$no = $start + 1;
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$sujn = $this->db->prepare("SELECT nama FROM jenistb WHERE id_jn=:jn ORDER BY id_jn DESC LIMIT 1");
				$sujn->execute(array(":jn" => $row['id_jn']));
				$rowjn = $sujn->fetch(PDO::FETCH_ASSOC);
			?>
				<tr>
					<td><?php print($no); ?></td>
					<td><?php print($rowjn['nama']); ?></td>
					<td><?php print($row['nama']); ?></td>
					<td align="center">
						<a href="sistem.php?sistem=subjenis&act=view&id=<?php print(base64_encode($row['id_sj'])); ?>"><i class="fa fa-search-plus"></i> view</a>
					</td>

				</tr>
			<?php
				$no++;
			}
		} else {
			?>
			<tr>
				<td colspan="4" align="center">Tidak ada data sub jenis ditemukan ...</td>
			</tr>
			<?php
		}
	}

	public function paging($query, $records_per_page)
	{
		$starting_position = 0;
		if (isset($_GET["page"])) {
			$starting_position = ($_GET["page"] - 1) * $records_per_page;
		}
		$query2 = $query . " limit $starting_position,$records_per_page";
		return $query2;
	}

	/* data subjenis */
}

//crud pasar
class crudpasar
{
	private $db;

	function __construct($db_con)
	{
		$this->db = $db_con;
	}

	public function create($nama)
	{
		try {
			$stmt = $this->db->prepare("INSERT INTO pasartb(nama) VALUES(:nama)");
			$stmt->bindparam(":nama", $nama);
			$stmt->execute();
			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function getID($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM pasartb WHERE id_ps=:id");
		$stmt->execute(array(":id" => $id));
		$editRow = $stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}

	public function update($id, $nama)
	{
		try {
			$stmt = $this->db->prepare("UPDATE pasartb SET nama=:nama	WHERE id_ps=:id ");
			$stmt->bindparam(":nama", $nama);
			$stmt->bindparam(":id", $id);
			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	/* data pasar */

	public function dataview($query, $records_per_page)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute();

		$countstmt = $stmt->rowCount();

		if (isset($_GET["page"]))
			$page = $_GET["page"];
		else
			$page = "";

		if ($page)
			$start = ($page - 1) * $records_per_page;
		else
			$start = 0;

		if ($stmt->rowCount() > 0) {
			$no = $start + 1;
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			?>
				<tr>
					<td><?php print($no); ?></td>
					<td><?php print($row['nama']); ?></td>
					<td align="center">
						<a href="sistem.php?sistem=pasar&act=view&id=<?php print(base64_encode($row['id_ps'])); ?>"><i class="fa fa-search-plus"></i> view</a>
					</td>

				</tr>
			<?php
				$no++;
			}
		} else {
			?>
			<tr>
				<td colspan="3" align="center">Tidak ada data pasar ditemukan ...</td>
			</tr>
			<?php
		}
	}

	public function paging($query, $records_per_page)
	{
		$starting_position = 0;
		if (isset($_GET["page"])) {
			$starting_position = ($_GET["page"] - 1) * $records_per_page;
		}
		$query2 = $query . " limit $starting_position,$records_per_page";
		return $query2;
	}

	/* data pasar */
}

// crud sertifikat
class sertifikat
{
	private $db;

	function __construct($db_con)
	{
		$this->db = $db_con;
	}

	public function dataview($query, $records_per_page)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute();

		$countstmt = $stmt->rowCount();

		if (isset($_GET["page"]))
			$page = $_GET["page"];
		else
			$page = "";

		if ($page)
			$start = ($page - 1) * $records_per_page;
		else
			$start = 0;

		if ($stmt->rowCount() > 0) {
			$no = $start + 1;
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			?>
				<tr>
					<td><?php print($no); ?></td>
					<td><?php print($row['pengukuran']); ?></td>
					<td><?php print($row['nomor']); ?></td>
					<td><?php print($row['tgl']); ?></td>
					<td>
						<a href="sistem.php?sistem=cSr&id=<?php print($row['id_sr']); ?>" class=""><i class="fa fa-check"></i> Confirm</a>
					</td>

				</tr>
			<?php
				$no++;
			}
		} else {
			?>
			<tr>
				<td colspan="3" align="center">Tidak ada data konfirmasi ditemukan ...</td>
			</tr>
			<?php
		}
	}

	public function paging($query, $records_per_page)
	{
		$starting_position = 0;
		if (isset($_GET["page"])) {
			$starting_position = ($_GET["page"] - 1) * $records_per_page;
		}
		$query2 = $query . " limit $starting_position,$records_per_page";
		return $query2;
	}
}
// akhir crud sertifikat

// crud daftar

class Daftar
{
	private $db;

	function __construct($db_con)
	{
		$this->db = $db_con;
	}

	public function create($email, $password, $nama, $jabatan, $telepon, $type, $foto, $cfoto, $status, $logdate)
	{
		try {
			$stmt = $this->db->prepare("INSERT INTO usertb(imel,pword,nama,jabatan,telp,type,foto,cfoto,status,logdate) VALUES(:imel,:pword,:nama,:jabatan,:telp,:type,:foto, :cfoto, :status, :logdate)");
			$stmt->bindparam(":imel", $email);
			$stmt->bindparam(":pword", $password);
			$stmt->bindparam(":nama", $nama);
			$stmt->bindparam(":jabatan", $jabatan);
			$stmt->bindparam(":telp", $telepon);
			$stmt->bindparam(":type", $type);
			$stmt->bindparam(":foto", $foto);
			$stmt->bindparam(":cfoto", $cfoto);
			$stmt->bindparam(":status", $status);
			$stmt->bindparam(":logdate", $logdate);
			$stmt->execute();
			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
}
// akhir crud daftar

//crud alat
class crudalat
{
	private $db;

	function __construct($db_con)
	{
		$this->db = $db_con;
	}

	public function create($id_us, $id_jn, $id_sj, $id_ps, $id_umum, $pemakai, $alamat, $spbu, $standar, $tgl, $penguji, $nip, $metode, $tera, $tahun, $berlaku, $merek, $nopol, $notaksi, $pemilik, $alamatx)
	{
		try {
			$stmt = $this->db->prepare("INSERT INTO alattb(id_us, id_jn, id_sj, id_ps,id_umum, pemakai, alamat, spbu, standar, tgl, penguji, nip, metode, tera, tahun, berlaku, merek, nopol, notaksi, pemilik, alamatx) VALUES(:id_us, :id_jn, :id_sj, :id_ps,:id_umum, :pemakai, :alamat, :spbu, :standar, :tgl, :penguji, :nip, :metode, :tera, :tahun, :berlaku, :merek, :nopol, :notaksi, :pemilik, :alamatx)");
			$stmt->bindparam(":id_us", $id_us);
			$stmt->bindparam(":id_jn", $id_jn);
			$stmt->bindparam(":id_sj", $id_sj);
			$stmt->bindparam(":id_ps", $id_ps);
			$stmt->bindparam(":id_umum", $id_umum);
			$stmt->bindparam(":pemakai", $pemakai);
			$stmt->bindparam(":alamat", $alamat);
			$stmt->bindparam(":spbu", $spbu);
			$stmt->bindparam(":standar", $standar);
			$stmt->bindparam(":tgl", $tgl);
			$stmt->bindparam(":penguji", $penguji);
			$stmt->bindparam(":nip", $nip);
			$stmt->bindparam(":metode", $metode);
			$stmt->bindparam(":tera", $tera);
			$stmt->bindparam(":tahun", $tahun);
			$stmt->bindparam(":berlaku", $berlaku);
			$stmt->bindparam(":merek", $merek);
			$stmt->bindparam(":nopol", $nopol);
			$stmt->bindparam(":notaksi", $notaksi);
			$stmt->bindparam(":pemilik", $pemilik);
			$stmt->bindparam(":alamatx", $alamatx);
			$stmt->execute();
			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function createx($id_us, $id_al, $merek, $buatan, $seri, $tipe, $kapasitas, $jenis)
	{
		try {
			$stmt = $this->db->prepare("INSERT INTO lampirantb(id_us, id_al, merek, buatan, seri, tipe, kapasitas, jenis) VALUES(:id_us, :id_al, :merek, :buatan, :seri, :tipe, :kapasitas, :jenis)");
			$stmt->bindparam(":id_us", $id_us);
			$stmt->bindparam(":id_al", $id_al);
			$stmt->bindparam(":merek", $merek);
			$stmt->bindparam(":buatan", $buatan);
			$stmt->bindparam(":seri", $seri);
			$stmt->bindparam(":tipe", $tipe);
			$stmt->bindparam(":kapasitas", $kapasitas);
			$stmt->bindparam(":jenis", $jenis);
			$stmt->execute();
			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function createxx($id_us, $pengukuran, $tum, $nomor, $urut, $tgl, $id_pj)
	{
		try {
			$stmt = $this->db->prepare("INSERT INTO sertifikattb(id_us, pengukuran, tum, nomor, urut, tgl, id_pj) VALUES(:id_us, :pengukuran, :tum, :nomor, :urut, :tgl, :id_pj)");
			$stmt->bindparam(":id_us", $id_us);
			$stmt->bindparam(":pengukuran", $pengukuran);
			$stmt->bindparam(":tum", $tum);
			$stmt->bindparam(":nomor", $nomor);
			$stmt->bindparam(":urut", $urut);
			$stmt->bindparam(":tgl", $tgl);
			$stmt->bindparam(":id_pj", $id_pj);
			$stmt->execute();
			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function getID($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM alattb WHERE id_al=:id");
		$stmt->execute(array(":id" => $id));
		$editRow = $stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}

	public function update($id, $id_sj, $id_ps, $pemakai, $alamat, $spbu, $standar, $tgl, $penguji, $nip, $metode, $tera, $tahun, $berlaku, $merek, $nopol, $notaksi, $pemilik, $alamatx)
	{
		try {
			$stmt = $this->db->prepare("UPDATE alattb SET id_sj=:id_sj, id_ps=:id_ps, pemakai=:pemakai, alamat=:alamat, spbu=:spbu, standar=:standar, tgl=:tgl, penguji=:penguji, nip=:nip, metode=:metode, tera=:tera, tahun=:tahun, berlaku=:berlaku, merek=:merek, nopol=:nopol, notaksi=:notaksi, pemilik=:pemilik, alamatx=:alamatx	WHERE id_al=:id ");
			$stmt->bindparam(":id_sj", $id_sj);
			$stmt->bindparam(":id_ps", $id_ps);
			$stmt->bindparam(":pemakai", $pemakai);
			$stmt->bindparam(":alamat", $alamat);
			$stmt->bindparam(":spbu", $spbu);
			$stmt->bindparam(":standar", $standar);
			$stmt->bindparam(":tgl", $tgl);
			$stmt->bindparam(":penguji", $penguji);
			$stmt->bindparam(":nip", $nip);
			$stmt->bindparam(":metode", $metode);
			$stmt->bindparam(":tera", $tera);
			$stmt->bindparam(":tahun", $tahun);
			$stmt->bindparam(":berlaku", $berlaku);
			$stmt->bindparam(":merek", $merek);
			$stmt->bindparam(":nopol", $nopol);
			$stmt->bindparam(":notaksi", $notaksi);
			$stmt->bindparam(":pemilik", $pemilik);
			$stmt->bindparam(":alamatx", $alamatx);
			$stmt->bindparam(":id", $id);
			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function updatex($id, $merek, $buatan, $seri, $tipe, $kapasitas, $jenis)
	{
		try {
			$stmt = $this->db->prepare("UPDATE lampirantb SET merek=:merek, buatan=:buatan, seri=:seri, tipe=:tipe, kapasitas=:kapasitas, jenis=:jenis	WHERE id_lp=:id ");
			$stmt->bindparam(":merek", $merek);
			$stmt->bindparam(":buatan", $buatan);
			$stmt->bindparam(":seri", $seri);
			$stmt->bindparam(":tipe", $tipe);
			$stmt->bindparam(":kapasitas", $kapasitas);
			$stmt->bindparam(":jenis", $jenis);
			$stmt->bindparam(":id", $id);
			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function updatexx($id_sr, $id_pj)
	{
		try {
			$stmt = $this->db->prepare("UPDATE sertifikattb SET id_pj=:id_pj	WHERE id_sr=:id ");
			$stmt->bindparam(":id_pj", $id_pj);
			$stmt->bindparam(":id", $id_sr);
			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function delete($id)
	{
		$stmt = $this->db->prepare("DELETE FROM lampirantb WHERE id_lp=:id");
		$stmt->bindparam(":id", $id);
		$stmt->execute();
		return true;
	}

	/* data alat */

	public function dataview($query, $records_per_page)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute();

		$countstmt = $stmt->rowCount();

		$tanggal = new tanggal;

		if (isset($_GET["page"]))
			$page = $_GET["page"];
		else
			$page = "";

		if ($page)
			$start = ($page - 1) * $records_per_page;
		else
			$start = 0;

		if ($stmt->rowCount() > 0) {
			$no = $start + 1;
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$susj = $this->db->prepare("SELECT nama FROM subjenistb WHERE id_sj=:sj ORDER BY id_sj DESC LIMIT 1");
				$susj->execute(array(":sj" => $row['id_sj']));
				$rowsj = $susj->fetch(PDO::FETCH_ASSOC);

				$suno = $this->db->prepare("SELECT nomor FROM sertifikattb WHERE pengukuran=:al AND tum='0' ORDER BY id_sr DESC LIMIT 1");
				$suno->execute(array(":al" => $row['id_al']));
				$rowno = $suno->fetch(PDO::FETCH_ASSOC);

				$suser = $this->db->prepare("SELECT nama FROM usertb WHERE id_us=:uid ORDER BY id_us DESC LIMIT 1");
				$suser->execute(array(":uid" => $row['id_us']));
				$rowuser = $suser->fetch(PDO::FETCH_ASSOC);
			?>
				<tr>
					<td><?php print($no); ?></td>
					<td><?php print($rowsj['nama']); ?></td>
					<td><?php print($row['pemakai']); ?></td>
					<td><?php if ($row['tgl'] <> "0000-00-00") {
							$tanggal->contanggalx(substr($row['tgl'], 8, 2), substr($row['tgl'], 5, 2), substr($row['tgl'], 0, 4));
						} else {
							echo "";
						} ?></td>
					<td><?php print($rowno['nomor']); ?></td>
					<td><?php print($rowuser['nama']); ?></td>
					<td align="center">
						<a href="sistem.php?sistem=home&act=view&id=<?php print(base64_encode($row['id_al'])); ?>"><i class="fa fa-search-plus"></i> view</a>
					</td>

				</tr>
			<?php
				$no++;
			}
		} else {
			?>
			<tr>
				<td colspan="7" align="center">Tidak ada data alat ukur ditemukan ...</td>
			</tr>
			<?php
		}
	}

	public function vieww($query, $records_per_page)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute();

		$countstmt = $stmt->rowCount();

		$tanggal = new tanggal;

		if (isset($_GET["page"]))
			$page = $_GET["page"];
		else
			$page = "";

		if ($page)
			$start = ($page - 1) * $records_per_page;
		else
			$start = 0;

		if ($stmt->rowCount() > 0) {
			$no = $start + 1;
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$susj = $this->db->prepare("SELECT nama FROM subjenistb WHERE id_sj=:sj ORDER BY id_sj DESC LIMIT 1");
				$susj->execute(array(":sj" => $row['id_sj']));
				$rowsj = $susj->fetch(PDO::FETCH_ASSOC);

				$jenis = $this->db->prepare("SELECT nama FROM jenistb WHERE id_jn=:jn ORDER BY id_jn DESC LIMIT 1");
				$jenis->execute(array(":jn" => $row['id_jn']));
				$rowjn = $jenis->fetch(PDO::FETCH_ASSOC);

				$suno = $this->db->prepare("SELECT nomor FROM sertifikattb WHERE pengukuran=:al AND tum='0' ORDER BY id_sr DESC LIMIT 1");
				$suno->execute(array(":al" => $row['id_al']));
				$rowno = $suno->fetch(PDO::FETCH_ASSOC);

				$suser = $this->db->prepare("SELECT nama FROM usertb WHERE id_us=:uid ORDER BY id_us DESC LIMIT 1");
				$suser->execute(array(":uid" => $row['id_us']));
				$rowuser = $suser->fetch(PDO::FETCH_ASSOC);
			?>
				<tr>
					<td><?php print($no); ?></td>
					<td><?php print($rowjn['nama']); ?></td>
					<td><?php print($rowsj['nama']); ?></td>
					<td><?php if ($row['tgl'] <> "0000-00-00") {
							$tanggal->contanggalx(substr($row['tgl'], 8, 2), substr($row['tgl'], 5, 2), substr($row['tgl'], 0, 4));
						} else {
							echo "";
						} ?></td>

					<td><?php if ($rowno['nomor']) : ?>menunggu persetujuan <?php else : ?> <a href="http://localhost:8080/emetro/cetak/<?= $row['id_al']; ?>">cetak</a> <?php endif; ?></td>

				</tr>
			<?php
				$no++;
			}
		} else {
			?>
			<tr>
				<td colspan="7" align="center">Tidak ada data alat ukur ditemukan ...</td>
			</tr>
<?php
		}
	}

	public function paging($query, $records_per_page)
	{
		$starting_position = 0;
		if (isset($_GET["page"])) {
			$starting_position = ($_GET["page"] - 1) * $records_per_page;
		}
		$query2 = $query . " limit $starting_position,$records_per_page";
		return $query2;
	}

	/* data alat */
}

function isLogin()
{
	if (!isset($_SESSION['user_session'])) {
		header("location:sistem.php?sistem=login&x=");
		return;
		die;
	}
}

function isAdmin()
{
	if (base64_decode($_SESSION['type_session']) !== "admin") {
		header("Location: sistem.php?sistem=home");
		return;
		die();
	}
}

function isKepala_uptd()
{
	if (base64_decode($_SESSION['type_session']) !== "kepala_uptd") {
		header("Location: sistem.php?sistem=home");
		return;
		die();
	}
}
function isUmum()
{
	if (base64_decode($_SESSION['type_session']) !== "Umum") {
		header("Location: sistem.php?sistem=home");
		return;
		die();
	}
}

function isKasubag()
{
	if (base64_decode($_SESSION['type_session']) !== "kasubag") {
		header("Location: sistem.php?sistem=home");
		return;
		die();
	}
}

?>