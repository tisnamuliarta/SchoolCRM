<?php 
include '../connection.php';
include 'function.php';
/**
 * Check the post variable
 */

if (isset($_POST['table']))
	getGuruDatatable($connect);

if (isset($_POST['galeri']))
	getGaleriDatatable($connect);

if (isset($_POST['pekerjaan']))
	getPekerjaanDatatable($connect);

if (isset($_POST['tahunajaran']))
	getTahunAjaranDatatable($connect);

if (isset($_POST['biayaDaftar']))
	getBiayaDaftarDatatable($connect);

if (isset($_POST['diskon']))
	getDiskonDatatable($connect);

if (isset($_POST['faq']))
	getFAQDatatable($connect);

if (isset($_POST['siswaBaru']))
	getSiswaBaruDatatable($connect);

if (isset($_POST['datasiswa']))
	getDataSiswaDatatable($connect);

if (isset($_POST['kegiatan']))
	getKegiatanDatatable($connect);

if (isset($_POST['pengaturanakun']))
	getPengaturanAkunDatatable($connect);

if (isset($_POST['pengaturanakunguru']))
	getPengaturanAkunGuruDatatable($connect);

if (isset($_POST['pengaturanakunadmin']))
	getPengaturanAkunAdminDatatable($connect);

if (isset($_POST['kelas']))
	getKelasDatatable($connect);

if (isset($_POST['daftarsiswa']))
	getDaftarSiswaDatatable($connect);

if (isset($_GET['hasilBelajar']))
	getHasilBelajarSiswaDatatable($connect);

if (isset($_GET['manageUser']))
	getPengaturanAkunOrtuDatatable($connect);
if (isset($_GET['manageGuru']))
	getPengaturanAkunGuruAdminDatatable($connect);


function getHasilBelajarSiswaDatatable($connect) {
	$query = '';
	$id_ortu = $_GET['id_ortu'];
	$tahunAjaran = $_GET['tahun_ajaran'];
	$nis = $_GET['nis'];

	$output = [];
	$query .= " 
		SELECT tb_siswa.nama, tb_raport.*, 
			(SELECT tb_kelas.kelas FROM tb_kelas WHERE tb_kelas.id=tb_detail_siswa.id_kelas) as kelas,
			(SELECT tb_tahun_ajaran.tahun FROM tb_tahun_ajaran WHERE tb_tahun_ajaran.id = tb_detail_siswa.id_tahun_ajaran) as tahun_ajaran,
			(SELECT tb_tahun_ajaran.semester FROM tb_tahun_ajaran WHERE tb_tahun_ajaran.id = tb_detail_siswa.id_tahun_ajaran) as semester
		from tb_raport
		LEFT JOIN tb_siswa ON tb_siswa.nis = tb_raport.nis
		LEFT JOIN tb_detail_siswa ON tb_siswa.id = tb_detail_siswa.id_siswa
		WHERE tb_siswa.nis IS NOT NULL AND tb_siswa.id_ortu = $id_ortu
	";
	if ($_GET['isSearch'] == 'yes') {
		$query .= " AND tb_detail_siswa.id_tahun_ajaran = $tahunAjaran AND tb_siswa.nis = $nis ";
	}

	if (isset($_GET["search"]["value"])) {
		$query .= 'AND concat(tb_siswa.nama,"",tb_raport.nis)  LIKE "%'.$_GET["search"]["value"].'%" ';
	}
	if (isset($_GET["order"])) {
		$query .= 'ORDER BY '.$_GET['order']['0']['column'].' '.$_GET['order']['0']['dir'].' ';
	}else {
		$query .= 'ORDER BY tb_raport.id ASC ';
	}
	if ($_GET["length"] != -1) {
		$query .= 'LIMIT ' . $_GET['start'] . ', ' . $_GET['length'];
	}

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = [];
	$filtered_rows = $statement->rowCount();
	$start = $_REQUEST['start'];
	$idx = 0;
	foreach ($result as $row) {
		$idx++;
		$sub_array = [];
		$sub_array[] = $row['nama'];
		$sub_array[] = $row['total_nilai'];
		$data[] = $sub_array;
	}

	$output = [
		"draw" => intval($_GET["draw"]),
		"recordsTotal" => $filtered_rows,
		"recordsFiltered"  => get_total_hasil_belajar_siswa($connect,$id_ortu,$tahunAjaran,$nis,$_GET['isSearch']),
		"data" => $data
	];

	echo json_encode($output);
}

function get_total_hasil_belajar_siswa($connect,$id_ortu,$tahunAjaran,$nis,$isSearch){
	$query = "SELECT tb_raport.* FROM tb_raport 
		LEFT JOIN  tb_siswa ON tb_siswa.nis = tb_raport.nis 
		LEFT JOIN tb_detail_siswa ON tb_siswa.id = tb_detail_siswa.id_siswa
		WHERE tb_siswa.nis IS NOT NULL AND tb_siswa.id_ortu = $id_ortu";
	if ($isSearch == 'yes') {
		$query .= " AND tb_detail_siswa.id_tahun_ajaran = $tahunAjaran AND tb_siswa.nis = $nis ";
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}


function getDaftarSiswaDatatable($connect) {
	$query = '';
	$output = [];
	$query .= " 
		SELECT tb_siswa.*, DATE_FORMAT(tb_siswa.tgl_lahir,'%d %M %Y') as tanggal_lahir ,tb_pendaftaran.id as id_pendaftaran,tb_pendaftaran.jumlah_bayar,tb_pendaftaran.cara_bayar,tb_pendaftaran.status as status_pembayaran, 
			(SELECT tb_kelas.kelas FROM tb_kelas WHERE tb_kelas.id=tb_detail_siswa.id_kelas) as kelas,
			(SELECT tb_tahun_ajaran.tahun FROM tb_tahun_ajaran WHERE tb_tahun_ajaran.id = tb_detail_siswa.id_tahun_ajaran) as tahun_ajaran,
			(SELECT tb_tahun_ajaran.semester FROM tb_tahun_ajaran WHERE tb_tahun_ajaran.id = tb_detail_siswa.id_tahun_ajaran) as semester
		from tb_siswa
		LEFT JOIN tb_pendaftaran on tb_pendaftaran.id_siswa = tb_siswa.id
		LEFT JOIN tb_detail_siswa ON tb_siswa.id = tb_detail_siswa.id_siswa
		WHERE tb_siswa.nis IS NOT NULL
	";
	if (isset($_POST["search"]["value"])) {
		$query .= 'AND concat(tb_siswa.nama,"",tb_siswa.nama,"",tb_siswa.alamat)  LIKE "%'.$_POST["search"]["value"].'%" ';
	}
	if (isset($_POST["order"])) {
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}else {
		$query .= 'ORDER BY tb_siswa.id ASC ';
	}
	if ($_POST["length"] != -1) {
		$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	}

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = [];
	$filtered_rows = $statement->rowCount();
	$start = $_REQUEST['start'];
	$idx = 0;
	foreach ($result as $row) {
		$idx++;
		$status = '';
		$jk = '';
		$update = '';
		$button = '<div class="btn-group-vertical">
					<button type="button" name="update-siswa" id="'.$row["id"].'" class="btn btn-warning btn-xs update-siswa">Ubah</button>
				</div>';
		if ($row['status'] == 'active') {
			$status = '<span class="label label-success">Active</span>';
		}else {
			$status = '<span class="label label-danger">Non Active</span>';
		}
		if ($row['jenis_kelamin'] == '1') {
			$jk = 'Laki-laki';
		}else {
			$jk = 'Perempuan';
		}
		$sub_array = [];
		$sub_array[] = $idx;
		$sub_array[] = $row['nis'];
		$sub_array[] = $row['nama'];
		$sub_array[] = $jk;
		$sub_array[] = $row['kelas'];
		$sub_array[] = $row['tahun_ajaran'];
		$sub_array[] = $row['semester'];
		$sub_array[] = $status;
		$sub_array[] = $button;
		$data[] = $sub_array;
	}

	$output = [
		"draw" => intval($_POST["draw"]),
		"recordsTotal" => $filtered_rows,
		"recordsFiltered"  => get_total_all_notNull_siswa_records($connect,"tb_siswa"),
		"data" => $data
	];

	echo json_encode($output);
}

////////////////////////////
// Get data for datatable //
////////////////////////////
function getPengaturanAkunOrtuDatatable($connect) {
	// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$query = '';
	$output = [];
	$query .= " 
		SELECT *
		from tb_ortu
	";
	if (isset($_GET["search"]["value"])) {
		$query .= 'WHERE CONCAT(tb_ortu.nama_ayah,"",tb_ortu.username,"",tb_ortu.nama_ibu) LIKE "%'.$_GET["search"]["value"].'%" ';
	}
	if (isset($_GET["order"])) {
		$query .= 'ORDER BY '.$_GET['order']['0']['column'].' '.$_GET['order']['0']['dir'].' ';
	}else {
		$query .= 'ORDER BY tb_ortu.id ASC ';
	}
	if ($_GET["length"] != -1) {
		$query .= 'LIMIT ' . $_GET['start'] . ', ' . $_GET['length'];
	}

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = [];
	$filtered_rows = $statement->rowCount();
	$start = $_REQUEST['start'];
	$idx = 0;
	foreach ($result as $row) {
		$idx++;
		$sub_array = [];
		$sub_array[] = $idx;
		$sub_array[] = $row['nama_ayah'];
		$sub_array[] = $row['nama_ibu'];
		$sub_array[] = $row['username'];
		// $sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-info btn-xs update-guru">Ubah</button>';
		$sub_array[] = '<button type="button" name="update_password" id="'.$row["id"].'" class="btn btn-success btn-xs reset-password-ortu">Reset Password</button>';
		$data[] = $sub_array;
	}

	$output = [
		"draw" => intval($_GET["draw"]),
		"recordsTotal" => $filtered_rows,
		"recordsFiltered"  => get_total_all_records($connect,"tb_ortu"),
		"data" => $data
	];

	echo json_encode($output);
}

function getPengaturanAkunGuruAdminDatatable($connect) {
	// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$query = '';
	$output = [];
	$query .= " 
		SELECT *
		from tb_guru WHERE type != 'admin'
	";
	if (isset($_GET["search"]["value"])) {
		$query .= 'AND CONCAT(tb_guru.nama,"",tb_guru.username) LIKE "%'.$_GET["search"]["value"].'%" ';
	}
	if (isset($_GET["order"])) {
		$query .= 'ORDER BY '.$_GET['order']['0']['column'].' '.$_GET['order']['0']['dir'].' ';
	}else {
		$query .= 'ORDER BY tb_guru.nip ASC ';
	}
	if ($_GET["length"] != -1) {
		$query .= 'LIMIT ' . $_GET['start'] . ', ' . $_GET['length'];
	}

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = [];
	$filtered_rows = $statement->rowCount();
	$start = $_REQUEST['start'];
	$idx = 0;
	foreach ($result as $row) {
		$idx++;
		$sub_array = [];
		$sub_array[] = $idx;
		$sub_array[] = $row['nama'];
		$sub_array[] = $row['username'];
		$sub_array[] = $row['alamat'];
		// $sub_array[] = '<button type="button" name="update" id="'.$row["nip"].'" class="btn btn-info btn-xs update-guru">Ubah</button>';
		$sub_array[] = '<button type="button" name="update_password" id="'.$row["nip"].'" class="btn btn-warning btn-xs reset-password-guru">Reset Password</button>';
		$data[] = $sub_array;
	}

	$output = [
		"draw" => intval($_GET["draw"]),
		"recordsTotal" => $filtered_rows,
		"recordsFiltered"  => get_total_all_records($connect,"tb_guru"),
		"data" => $data
	];

	echo json_encode($output);
}

function getPengaturanAkunAdminDatatable($connect) {
	// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$nip = $_SESSION['nip'];
	$query = '';
	$output = [];
	$query .= " 
		SELECT *
		from tb_guru
		WHERE tb_guru.nip = {$nip}
	";
	if (isset($_POST["search"]["value"])) {
		$query .= 'AND CONCAT(tb_guru.nama,"",tb_guru.username) LIKE "%'.$_POST["search"]["value"].'%" ';
	}
	if (isset($_POST["order"])) {
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}else {
		$query .= 'ORDER BY tb_guru.nip ASC ';
	}
	if ($_POST["length"] != -1) {
		$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	}

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = [];
	$filtered_rows = $statement->rowCount();
	$start = $_REQUEST['start'];
	$idx = 0;
	foreach ($result as $row) {
		$idx++;
		$sub_array = [];
		$sub_array[] = $idx;
		$sub_array[] = $row['nama'];
		$sub_array[] = $row['username'];
		$sub_array[] = $row['alamat'];
		$sub_array[] = $row['tlpn'];
		$sub_array[] = '<button type="button" name="update" id="'.$row["nip"].'" class="btn btn-info btn-xs update-guru">Ubah</button>';
		$sub_array[] = '<button type="button" name="update_password" id="'.$row["nip"].'" class="btn btn-success btn-xs update-password">Update Password</button>';
		$data[] = $sub_array;
	}

	$output = [
		"draw" => intval($_POST["draw"]),
		"recordsTotal" => $filtered_rows,
		"recordsFiltered"  => get_total_guru_by_nip_records($connect,"tb_guru",$nip),
		"data" => $data
	];

	echo json_encode($output);
}

function getPengaturanAkunGuruDatatable($connect) {
	// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$nip = $_SESSION['nip'];
	$query = '';
	$output = [];
	$query .= " 
		SELECT *
		from tb_guru
		WHERE tb_guru.nip = {$nip}
	";
	if (isset($_POST["search"]["value"])) {
		$query .= 'AND CONCAT(tb_guru.nama,"",tb_guru.username) LIKE "%'.$_POST["search"]["value"].'%" ';
	}
	if (isset($_POST["order"])) {
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}else {
		$query .= 'ORDER BY tb_guru.nip ASC ';
	}
	if ($_POST["length"] != -1) {
		$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	}

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = [];
	$filtered_rows = $statement->rowCount();
	$start = $_REQUEST['start'];
	$idx = 0;
	foreach ($result as $row) {
		$idx++;
		$sub_array = [];
		$sub_array[] = $idx;
		$sub_array[] = $row['nama'];
		$sub_array[] = $row['username'];
		$sub_array[] = $row['alamat'];
		$sub_array[] = $row['tlpn'];
		$sub_array[] = '<button type="button" name="update" id="'.$row["nip"].'" class="btn btn-info btn-xs update-guru">Ubah</button>';
		$sub_array[] = '<button type="button" name="update_password" id="'.$row["nip"].'" class="btn btn-success btn-xs update-password">Update Password</button>';
		$data[] = $sub_array;
	}

	$output = [
		"draw" => intval($_POST["draw"]),
		"recordsTotal" => $filtered_rows,
		"recordsFiltered"  => get_total_guru_by_nip_records($connect,"tb_guru",$nip),
		"data" => $data
	];

	echo json_encode($output);
}

function get_total_guru_by_nip_records($connect,$table,$nip){
	$statement = $connect->prepare("SELECT * FROM $table WHERE nip = $nip");
	$statement->execute();
	return $statement->rowCount();
}


function getKegiatanDatatable($connect) {
	// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$query = '';
	$output = [];
	$nip = $_SESSION["nip"];
	$query .= " 
		SELECT tb_kegiatan.*,tb_guru.nama as nama_guru, DATE_FORMAT(tb_kegiatan.tgl,'%d %M %Y') as tgl_kegiatan, tb_kelas.kelas
		from tb_kegiatan
		LEFT JOIN tb_guru on tb_guru.nip = tb_kegiatan.nip
		LEFT JOIN tb_kelas ON tb_kelas.id = tb_kegiatan.id_kelas
		WHERE tb_kegiatan.nip = $nip
	";
	if (isset($_POST["search"]["value"])) {
		$query .= 'AND CONCAT(tb_kegiatan.nama,"",tb_kegiatan.deskripsi,"",tb_kegiatan.tgl) LIKE "%'.$_POST["search"]["value"].'%" ';
	}
	if (isset($_POST["order"])) {
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}else {
		$query .= 'ORDER BY tb_kegiatan.id ASC ';
	}
	if ($_POST["length"] != -1) {
		$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	}

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = [];
	$filtered_rows = $statement->rowCount();
	$start = $_REQUEST['start'];
	$idx = 0;
	foreach ($result as $row) {
		$idx++;
		$sub_array = [];
		$sub_array[] = $idx;
		$sub_array[] = '<img src="../uploads/kegiatan/'.$row["foto"].'" class="img img-responsive" style="width:100px;height:auto" />';
		$sub_array[] = $row['nama'];
		$sub_array[] = $row['deskripsi'];
		$sub_array[] = $row['kelas'];
		$sub_array[] = $row['tgl_kegiatan'];
		$sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update-kegiatan">Ubah</button>';
		$sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-xs delete-kegiatan">Hapus</button>';
		$data[] = $sub_array;
	}

	$output = [
		"draw" => intval($_POST["draw"]),
		"recordsTotal" => $filtered_rows,
		"recordsFiltered"  => get_total_all_kegiatan_records($connect,"tb_kegiatan",$nip),
		"data" => $data
	];

	echo json_encode($output);
}

function getPengaturanAkunDatatable($connect) {
	// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$id_ortu = $_SESSION['id'];
	$query = '';
	$output = [];
	$query .= " 
		SELECT *, (SELECT tb_pekerjaan.pekerjaan FROM tb_pekerjaan WHERE tb_pekerjaan.id = tb_ortu.pekerjaan_ayah) as nama_pekerjaan_ayah, (SELECT tb_pekerjaan.pekerjaan FROM tb_pekerjaan WHERE tb_pekerjaan.id = tb_ortu.pekerjaan_ibu) as nama_pekerjaan_ibu 
		from tb_ortu
		WHERE tb_ortu.id = {$id_ortu}
	";
	if (isset($_POST["search"]["value"])) {
		$query .= 'AND CONCAT(tb_ortu.nama_ayah,"",tb_ortu.nama_ibu,"",tb_ortu.username) LIKE "%'.$_POST["search"]["value"].'%" ';
	}
	if (isset($_POST["order"])) {
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}else {
		$query .= 'ORDER BY tb_ortu.id ASC ';
	}
	if ($_POST["length"] != -1) {
		$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	}

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = [];
	$filtered_rows = $statement->rowCount();
	$start = $_REQUEST['start'];
	$idx = 0;
	foreach ($result as $row) {
		$idx++;
		$sub_array = [];
		$sub_array[] = $idx;
		$sub_array[] = $row['nama_ayah'];
		$sub_array[] = $row['nama_ibu'];
		$sub_array[] = $row['username'];
		$sub_array[] = $row['email'];
		$sub_array[] = $row['nama_pekerjaan_ayah'];
		$sub_array[] = $row['nama_pekerjaan_ibu'];
		$sub_array[] = $row['tlpn'];
		$sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-info btn-xs update-user">Ubah</button>';
		$sub_array[] = '<button type="button" name="update_password" id="'.$row["id"].'" class="btn btn-success btn-xs update-password">Update Password</button>';
		$data[] = $sub_array;
	}

	$output = [
		"draw" => intval($_POST["draw"]),
		"recordsTotal" => $filtered_rows,
		"recordsFiltered"  => get_total_ortu_by_id_records($connect,"tb_ortu",$id_ortu),
		"data" => $data
	];

	echo json_encode($output);
}

function get_total_ortu_by_id_records($connect,$table,$id_ortu){
	$statement = $connect->prepare("SELECT * FROM $table WHERE id = $id_ortu");
	$statement->execute();
	return $statement->rowCount();
}

/**
 * Data siswa baru
 * @param  [type] $connect [description]
 * @return [type]          [description]
 */
function getDataSiswaDatatable($connect) {
	$query = '';
	$output = [];
	$query .= " 
		SELECT tb_siswa.*, DATE_FORMAT(tb_siswa.tgl_lahir,'%d %M %Y') as tanggal_lahir ,tb_pendaftaran.id as id_pendaftaran,tb_pendaftaran.jumlah_bayar,tb_pendaftaran.cara_bayar,tb_pendaftaran.status as status_pembayaran, (SELECT tb_kelas.kelas FROM tb_kelas WHERE tb_kelas.id=tb_detail_siswa.id_kelas) as kelas, tb_ortu.nama_ayah, tb_ortu.nama_ibu
		from tb_siswa
		LEFT JOIN tb_pendaftaran on tb_pendaftaran.id_siswa = tb_siswa.id
		LEFT JOIN tb_ortu ON tb_ortu.id = tb_siswa.id_ortu
		LEFT JOIN tb_detail_siswa ON tb_siswa.id = tb_detail_siswa.id_siswa
		WHERE tb_siswa.nis IS NULL
	";
	if (isset($_POST["search"]["value"])) {
		$query .= 'AND concat(tb_siswa.nama,"",tb_siswa.alamat) LIKE "%'.$_POST["search"]["value"].'%" ';
	}
	if (isset($_POST["order"])) {
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}else {
		$query .= 'ORDER BY tb_siswa.id ASC ';
	}
	if ($_POST["length"] != -1) {
		$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	}

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = [];
	$filtered_rows = $statement->rowCount();
	$start = $_REQUEST['start'];
	$idx = 0;
	$totalKuotaSiswa = getCountKuotaSiswaBaru($connect,'A');

	foreach ($result as $row) {
		$idx++;
		$status = '';
		$jk = '';
		$update = '';
		$button = '';
		if ($row['jenis_kelamin'] == '1') {
			$jk = 'Laki-laki';
		}else {
			$jk = 'Perempuan';
		}
		if ($row['status_pembayaran'] == 'unpaid') {
			$status .= '<span class="label label-danger">Non Active</span>';
			if ($totalKuotaSiswa <= 30) {
				$button = '
					<div class="btn-group-vertical">
						<div class="col-sm-12">
							<button type="button" name="update-siswa" id="'.$row["id"].'" class="btn btn-warning btn-xs update-siswa">Ubah</button>
						</div>
						<div class="col-sm-12" >
							<button type="button" name="konfirmasi-pembayaran" id="'.$row["id_pendaftaran"].'" class="btn btn-info btn-xs konfirmasi-siswa" data-status="'.$row["id"].'">Konfirmasi Pembayaran</button>
						</div>
						<div class="col-sm-12">
							<button type="button" name="tolak-pembayaran" id="'.$row["id_pendaftaran"].'" class="btn btn-danger btn-xs tolak-siswa" data-namasiswa="'.$row['nama'].'" data-idsiswa="'.$row["id"].'">Tolak</button>
						</div>
					</div>
				';
			}
		}elseif ($row['status_pembayaran'] == 'waiting') {
			$status .= '<span class="label label-info">Menunggu Konfirmasi</span>';
			if ($totalKuotaSiswa <= 30) {
				
				$button = '
					<div class="btn-group-vertical">
						<div class="col-sm-12" >
							<button type="button" name="update-siswa" id="'.$row["id"].'" class="btn btn-warning btn-xs update-siswa">Ubah</button>
						</div>
						<div class="col-sm-12" >
							<button type="button" name="view-data-konfirmasi" id="'.$row["id_pendaftaran"].'" class="btn btn-primary btn-xs view-data-konfirmasi">Lihat Bukti Pembayaran</button>
						</div>
						<div class="col-sm-12" >
							<button type="button" name="konfirmasi-pembayaran" id="'.$row["id_pendaftaran"].'" class="btn btn-info btn-xs konfirmasi-siswa" data-status="'.$row["id"].'">Konfirmasi Pembayaran</button>
						</div>
						<div class="col-sm-12">
							<button type="button" name="tolak-pembayaran" id="'.$row["id_pendaftaran"].'" class="btn btn-danger btn-xs tolak-siswa" data-namasiswa="'.$row['nama'].'" data-idsiswa="'.$row["id"].'">Tolak</button>
						</div>
					</div>
				';
			}
		}elseif ($row['status_pembayaran'] == 'paid') {
			$status .= '<span class="label label-success">Active</span>';
			if ($totalKuotaSiswa <= 30) {
				$button = '
					<div class="btn-group-vertical">
						<div class="col-sm-12" >
							<button type="button" name="update-siswa" id="'.$row["id"].'" class="btn btn-warning btn-xs update-siswa">Ubah</button>
						</div>
						<div class="col-sm-12" >
							<button type="button" name="view-data-konfirmasi" id="'.$row["id_pendaftaran"].'" class="btn btn-primary btn-xs view-data-konfirmasi">Lihat Bukti Pembayaran</button>
						</div>
					</div>
				';
			}
		}else {
			$button .= '<button type="button" class="btn btn-warning btn-xs">Siswa ditolak</button>';
			$status .= '<span class="label label-danger">Non Active</span>';
		}
		$sub_array = [];
		$sub_array[] = $idx;
		$sub_array[] = $row['nama'];
		$sub_array[] = $row['nama_ayah'];
		$sub_array[] = $row['nama_ibu'];
		$sub_array[] = $jk;
		$sub_array[] = $row['tanggal_lahir'];
		$sub_array[] = $row['alamat'];
		$sub_array[] = $status;
		$sub_array[] = $button;
		$data[] = $sub_array;
	}

	$output = [
		"draw" => intval($_POST["draw"]),
		"recordsTotal" => $filtered_rows,
		"recordsFiltered"  => get_total_all_null_siswa_records($connect,"tb_siswa"),
		"data" => $data
	];

	echo json_encode($output);
}

function getSiswaBaruDatatable($connect) {
	$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$query = '';
	$id_ortu = $_SESSION['id'];
	$output = [];
	$query .= " 
		SELECT tb_siswa.*,DATE_FORMAT(tb_siswa.tgl_lahir,'%d %M %Y') as tanggal_lahir, tb_pendaftaran.jumlah_bayar,tb_pendaftaran.cara_bayar,tb_pendaftaran.id_tahun_ajaran ,tb_pendaftaran.status as status_pembayaran, tb_pendaftaran.id as id_pendaftaran, tb_pendaftaran.keterangan
		from tb_siswa
		LEFT JOIN tb_pendaftaran on tb_pendaftaran.id_siswa = tb_siswa.id
		LEFT JOIN tb_detail_siswa ON tb_detail_siswa.id_siswa = tb_siswa.id
		WHERE tb_siswa.id_ortu IN(".$id_ortu.")
	";
	if (isset($_POST["search"]["value"])) {
		$query .= 'AND tb_siswa.nama LIKE "%'.$_POST["search"]["value"].'%" ';
	}
	if (isset($_POST["order"])) {
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}else {
		$query .= 'ORDER BY tb_siswa.id ASC ';
	}
	if ($_POST["length"] != -1) {
		$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	}
	// echo $query;

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = [];
	$filtered_rows = $statement->rowCount();
	$start = $_REQUEST['start'];
	$idx = 0;
	foreach ($result as $row) {
		$idx++;
		$status = '';
		$update = '';
		$jk = '';

		$cara_bayar = '';
		if ($row['cara_bayar'] == 'transfer') {
			$cara_bayar .= '<button type="button" name="konfirmasi" id="'.$row["id_pendaftaran"].'" data-nama="'.$row["nama"].'" class="btn btn-warning btn-xs konfirmasi-siswa">Konfirmasi</button>';
		}

		if ($row['status_pembayaran'] == 'unpaid') {
			$update = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update-siswa">Ubah</button>';
			$status = '<span class="label label-danger">Belum Bayar</span>';
		}elseif ($row['status_pembayaran'] == 'waiting') {
			$update = '';
			$status = '<span class="label label-info">Menunggu Konfirmasi</span>';
		}elseif ($row['status_pembayaran'] == 'paid') {
			$update = '';
			$status = '<span class="label label-success">Lunas</span><br><span class="label label-info">Diterima</span>';
		}elseif ($row['status_pembayaran'] == 'abort') {
			$update = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update-siswa">Ubah</button>';
			$status = '<span class="label label-danger">Siswa ditolak</span>';
		}
		if ($row['jenis_kelamin'] == '1') {
			$jk = 'Laki-laki';
		}else {
			$jk = 'Perempuan';
		}
		$sub_array = [];
		$sub_array[] = $idx;
		$sub_array[] = $row['nis'];
		$sub_array[] = $row['nama'];
		$sub_array[] = $jk;
		$sub_array[] = $row['tanggal_lahir'];
		$sub_array[] = $row['alamat'];
		$sub_array[] = $row['jumlah_bayar'];
		$sub_array[] = $row['cara_bayar'];
		$sub_array[] = $status;
		$sub_array[] = $update;
		$sub_array[] = $cara_bayar;
		$sub_array[] = $row['keterangan'];
		$data[] = $sub_array;
	}

	$output = [
		"draw" => intval($_POST["draw"]),
		"recordsTotal" => $filtered_rows,
		"recordsFiltered"  => get_total_all_siswa_records($connect,"tb_siswa",$id_ortu),
		"data" => $data
	];

	echo json_encode($output);
}

function getFAQDatatable($connect) {
	$query = '';
	$output = [];
	$query .= " 
		SELECT tb_faq.*
		from tb_faq 
	";
	if (isset($_POST["search"]["value"])) {
		$query .= 'WHERE tb_faq.judul LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR tb_faq.kontent LIKE "%'.$_POST["search"]["value"].'%" ';
	}
	if (isset($_POST["order"])) {
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}else {
		$query .= 'ORDER BY tb_faq.id ASC ';
	}
	if ($_POST["length"] != -1) {
		$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	}

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = [];
	$filtered_rows = $statement->rowCount();
	$start = $_REQUEST['start'];
	$idx = 0;
	foreach ($result as $row) {
		$idx++;
		$status = '';
		$jk = '';
		if ($row['status'] == 'active') {
			$status = '<span class="label label-success">Active</span>';
		}else {
			$status = '<span class="label label-danger">Non Active</span>';
		}
		$sub_array = [];
		$sub_array[] = $idx;
		$sub_array[] = $row['judul'];
		$sub_array[] = $row['kontent'];
		$sub_array[] = $status;
		$sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update-faq">Ubah</button>';
		$sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-xs delete-faq" data-status="'.$row["status"].'">Hapus</button>';
		$data[] = $sub_array;
	}

	$output = [
		"draw" => intval($_POST["draw"]),
		"recordsTotal" => $filtered_rows,
		"recordsFiltered"  => get_total_all_records($connect,"tb_faq"),
		"data" => $data
	];

	echo json_encode($output);
}

function getDiskonDatatable($connect) {
	$query = '';
	$output = [];
	$query .= " 
		SELECT tb_diskon.*, (SELECT CONCAT(tb_tahun_ajaran.tahun,' - ',tb_tahun_ajaran.semester) FROM tb_tahun_ajaran WHERE tb_tahun_ajaran.id = tb_diskon.tahun_ajaran) as tahun_ajaran_detail 
		from tb_diskon 
	";
	$select = "(SELECT CONCAT(tb_tahun_ajaran.tahun,' - ',tb_tahun_ajaran.semester) FROM tb_tahun_ajaran WHERE tb_diskon.tahun_ajaran = tb_tahun_ajaran.id)";
	if (isset($_POST["search"]["value"])) {
		$query .= 'WHERE tb_diskon.diskon LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR '.$select.' LIKE "%'.$_POST["search"]["value"].'%" ';
	}
	if (isset($_POST["order"])) {
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}else {
		$query .= 'ORDER BY tb_diskon.id ASC ';
	}
	if ($_POST["length"] != -1) {
		$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	}

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = [];
	$filtered_rows = $statement->rowCount();
	$start = $_REQUEST['start'];
	$idx = 0;
	foreach ($result as $row) {
		$idx++;
		$sub_array = [];
		$sub_array[] = $idx;
		$sub_array[] = $row['tahun_ajaran_detail'];
		$sub_array[] = $row['diskon'];
		$sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update-diskon">Ubah</button>';
		$data[] = $sub_array;
	}

	$output = [
		"draw" => intval($_POST["draw"]),
		"recordsTotal" => $filtered_rows,
		"recordsFiltered"  => get_total_all_records($connect,"tb_diskon"),
		"data" => $data
	];

	echo json_encode($output);
}

function getBiayaDaftarDatatable($connect) {
	$query = '';
	$output = [];
	$query .= " SELECT *, (SELECT CONCAT(tb_tahun_ajaran.tahun,' - ',tb_tahun_ajaran.semester) as tahun_ajaran FROM tb_tahun_ajaran WHERE tb_tahun_ajaran.id = tb_biaya_pendaftaran.id_tahun_ajaran) as tahun_ajaran from tb_biaya_pendaftaran ";
	if (isset($_POST["search"]["value"])) {
		$query .= 'WHERE tb_biaya_pendaftaran.biaya LIKE "%'.$_POST["search"]["value"].'%" ';
	}
	if (isset($_POST["order"])) {
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}else {
		$query .= 'ORDER BY tb_biaya_pendaftaran.id ASC ';
	}
	if ($_POST["length"] != -1) {
		$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	}

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = [];
	$filtered_rows = $statement->rowCount();
	$start = $_REQUEST['start'];
	$idx = 0;
	foreach ($result as $row) {
		$idx++;
		$status = '';
		$jk = '';
		$sub_array = [];
		$sub_array[] = $idx;
		$sub_array[] = $row['tahun_ajaran'];
		$sub_array[] = $row['biaya'];
		$sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update-biaya-daftar">Ubah</button>';
		$data[] = $sub_array;
	}

	$output = [
		"draw" => intval($_POST["draw"]),
		"recordsTotal" => $filtered_rows,
		"recordsFiltered"  => get_total_all_records($connect,"tb_biaya_pendaftaran"),
		"data" => $data
	];

	echo json_encode($output);
}

function getTahunAjaranDatatable($connect) {
	$query = '';
	$output = [];
	$query .= " SELECT * from tb_tahun_ajaran ";
	if (isset($_POST["search"]["value"])) {
		$query .= 'WHERE tb_tahun_ajaran.tahun LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR tb_tahun_ajaran.semester LIKE "%'.$_POST["search"]["value"].'%" ';
	}
	if (isset($_POST["order"])) {
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}else {
		$query .= 'ORDER BY tb_tahun_ajaran.id ASC ';
	}
	if ($_POST["length"] != -1) {
		$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	}

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = [];
	$filtered_rows = $statement->rowCount();
	$start = $_REQUEST['start'];
	$idx = 0;
	foreach ($result as $row) {
		$idx++;
		$status = '';
		$jk = '';
		$sub_array = [];
		$sub_array[] = $idx;
		$sub_array[] = $row['tahun'];
		$sub_array[] = $row['semester'];
		$sub_array[] = $row['tgl_mulai'];
		$sub_array[] = $row['tgl_selesai'];
		$sub_array[] = $row['biaya_daftar'];
		$sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update-tahunajaran">Ubah</button>';
		$data[] = $sub_array;
	}

	$output = [
		"draw" => intval($_POST["draw"]),
		"recordsTotal" => $filtered_rows,
		"recordsFiltered"  => get_total_all_records($connect,"tb_tahun_ajaran"),
		"data" => $data
	];

	echo json_encode($output);
}

/**
 * Get guru data for datatable
 * @param  object $connect 
 * @return array
 */
function getGuruDatatable($connect) {
	$query = '';
	$output = [];
	$query .= " SELECT * from tb_guru ";
	if (isset($_POST["search"]["value"])) {
		$query .= 'WHERE tb_guru.nama LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR tb_guru.username LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR tb_guru.alamat LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR tb_guru.nip LIKE "%'.$_POST["search"]["value"].'%" ';
	}
	if (isset($_POST["order"])) {
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}else {
		$query .= 'ORDER BY tb_guru.nip DESC ';
	}
	if ($_POST["length"] != -1) {
		$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	}

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = [];
	$filtered_rows = $statement->rowCount();
	$start = $_REQUEST['start'];
	$idx = 0;
	foreach ($result as $row) {
		$idx++;
		$status = '';
		$jk = '';
		if ($row['status'] == 'active') {
			$status = '<span class="label label-success">Active</span>';
		}else {
			$status = '<span class="label label-danger">Non Active</span>';
		}
		if ($row['jenis_kelamin'] == 1) {
			$jk = '<span>Laki-laki</span>';
		}else {
			$jk = '<span>Perempuan</span>';
		}
		$sub_array = [];
		$sub_array[] = $row['nip'];
		$sub_array[] = $row['nama'];
		$sub_array[] = $row['username'];
		$sub_array[] = $row['tgl_lahir'];
		$sub_array[] = $jk;
		$sub_array[] = $row['tlpn'];
		$sub_array[] = $row['type'];
		$sub_array[] = $status;
		// $sub_array[] = '<button type="button" name="make-admin" id="'.$row["nip"].'" class="btn btn-info btn-xs make-admin" data-type="'.$row["type"].'">Jadikan Admin</button>';
		$sub_array[] = '<button type="button" name="view" id="'.$row["nip"].'" class="btn btn-info btn-xs view-guru">Lihat</button>';
		$sub_array[] = '<button type="button" name="update" id="'.$row["nip"].'" class="btn btn-warning btn-xs update-guru">Ubah</button>';
		$sub_array[] = '<button type="button" name="delete" id="'.$row["nip"].'" class="btn btn-danger btn-xs delete-guru" data-status="'.$row["status"].'">Hapus</button>';
		$data[] = $sub_array;
	}

	$output = [
		"draw" => intval($_POST["draw"]),
		"recordsTotal" => $filtered_rows,
		"recordsFiltered"  => get_total_all_records($connect,"tb_guru"),
		"data" => $data
	];

	echo json_encode($output);
}

function getKelasDatatable($connect) {
	$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$query = '';
	$output = [];
	$query .= " SELECT tb_kelas.* from tb_kelas ";
	if (isset($_POST["search"]["value"])) {
		$query .= 'WHERE tb_kelas.kelas LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR tb_kelas.maximal_siswa LIKE "%'.$_POST["search"]["value"].'%" ';
	}
	if (isset($_POST["order"])) {
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}else {
		$query .= 'ORDER BY tb_kelas.kelas ASC ';
	}
	if ($_POST["length"] != -1) {
		$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	}

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = [];
	$filtered_rows = $statement->rowCount();
	$start = $_REQUEST['start'];
	$idx = 0;
	foreach ($result as $row) {
		// select photo

		$idx++;
		$sub_array = [];
		$sub_array[] = $idx;
		$sub_array[] = $row['kelas'];
		$sub_array[] = $row['maximal_siswa'];
		$sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update-kelas">Ubah</button>';
		$sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-xs delete-kelas" data-status="'.$row["id"].'">Hapus</button>';
		$data[] = $sub_array;
	}

	$output = [
		"draw" => intval($_POST["draw"]),
		"recordsTotal" => $filtered_rows,
		"recordsFiltered"  => get_total_all_records($connect,"tb_kelas"),
		"data" => $data
	];

	echo json_encode($output);
}

function getPekerjaanDatatable($connect) {
	$query = '';
	$output = [];
	$query .= " SELECT tb_pekerjaan.* from tb_pekerjaan ";
	if (isset($_POST["search"]["value"])) {
		$query .= 'WHERE tb_pekerjaan.pekerjaan LIKE "%'.$_POST["search"]["value"].'%" ';
	}
	if (isset($_POST["order"])) {
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}else {
		$query .= 'ORDER BY tb_pekerjaan.pekerjaan ASC ';
	}
	if ($_POST["length"] != -1) {
		$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	}

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = [];
	$filtered_rows = $statement->rowCount();
	$start = $_REQUEST['start'];
	$idx = 0;
	foreach ($result as $row) {
		// select photo

		$idx++;
		$sub_array = [];
		$sub_array[] = $idx ;
		$sub_array[] = $row['pekerjaan'];
		$sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update-pekerjaan">Ubah</button>';
		$sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-xs delete-pekerjaan" data-status="'.$row["id"].'">Hapus</button>';
		$data[] = $sub_array;
	}

	$output = [
		"draw" => intval($_POST["draw"]),
		"recordsTotal" => $filtered_rows,
		"recordsFiltered"  => get_total_all_records($connect,"tb_pekerjaan"),
		"data" => $data
	];

	echo json_encode($output);
}

function getGaleriDatatable($connect) {
	$query = '';
	$output = [];
	$query .= " SELECT tb_galeri.* from tb_galeri ";
	if (isset($_POST["search"]["value"])) {
		$query .= 'WHERE tb_galeri.judul LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR tb_galeri.deskripsi LIKE "%'.$_POST["search"]["value"].'%" ';
	}
	if (isset($_POST["order"])) {
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}else {
		$query .= 'ORDER BY tb_galeri.nip DESC ';
	}
	if ($_POST["length"] != -1) {
		$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	}

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = [];
	$filtered_rows = $statement->rowCount();
	$start = $_REQUEST['start'];
	$idx = 0;
	foreach ($result as $row) {
		// select photo

		$idx++;
		$sub_array = [];
		$sub_array[] = $row['judul'];
		$sub_array[] = $row['deskripsi'];
		$sub_array[] = '<button type="button" name="view" id="'.$row["id"].'" class="btn btn-info btn-xs view-galeri">Lihat</button>';
		$sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update-galeri">Ubah</button>';
		$sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-xs delete-galeri" data-status="'.$row["status"].'">Hapus</button>';
		$data[] = $sub_array;
	}

	$output = [
		"draw" => intval($_POST["draw"]),
		"recordsTotal" => $filtered_rows,
		"recordsFiltered"  => get_total_all_records($connect,"tb_galeri"),
		"data" => $data
	];

	echo json_encode($output);
}

function get_total_all_siswa_records($connect,$table,$id_ortu){
	$statement = $connect->prepare("SELECT * FROM $table WHERE id_ortu = $id_ortu");
	$statement->execute();
	return $statement->rowCount();
}
function get_total_all_notNull_siswa_records($connect,$table){
	$statement = $connect->prepare("SELECT * FROM $table WHERE nis IS NOT NULL");
	$statement->execute();
	return $statement->rowCount();
}
function get_total_all_null_siswa_records($connect,$table){
	$statement = $connect->prepare("SELECT * FROM $table WHERE nis IS NULL");
	$statement->execute();
	return $statement->rowCount();
}

function get_total_all_records($connect,$table){
	$statement = $connect->prepare("SELECT * FROM $table");
	$statement->execute();
	return $statement->rowCount();
}

function get_total_all_kegiatan_records($connect,$table,$nip){
	$statement = $connect->prepare("SELECT * FROM $table WHERE nip = {$nip}");
	$statement->execute();
	return $statement->rowCount();
}