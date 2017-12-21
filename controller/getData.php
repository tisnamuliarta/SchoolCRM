<?php 
include '../connection.php';
/**
 * Check the post variable
 */

if (isset($_POST['table']))
	getGuruDatatable($connect);

if (isset($_POST['galeri']))
	getGaleriDatatable($connect);

if (isset($_POST['tahunajaran']))
	getTahunAjaranDatatable($connect);

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

if (isset($_POST['kelas']))
	getKelasDatatable($connect);


////////////////////////////
// Get data for datatable //
////////////////////////////
function getKegiatanDatatable($connect) {
	// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$query = '';
	$output = [];
	$query .= " 
		SELECT tb_kegiatan.*,tb_guru.nama as nama_guru, DATE_FORMAT(tb_kegiatan.tgl,'%d %M %Y') as tgl_kegiatan
		from tb_kegiatan
		LEFT JOIN tb_guru on tb_guru.nip = tb_kegiatan.nip
	";
	if (isset($_POST["search"]["value"])) {
		$query .= 'WHERE tb_kegiatan.nama LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR tb_kegiatan.deskripsi LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR tb_kegiatan.tgl LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'AND tb_kegiatan.nip = "'.$_SESSION["nip"].'"';
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
		$sub_array[] = $row['nama'];
		$sub_array[] = $row['deskripsi'];
		$sub_array[] = $row['tgl_kegiatan'];
		$sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update-kegiatan">Update</button>';
		$sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-xs delete-kegiatan">Delete</button>';
		$data[] = $sub_array;
	}

	$output = [
		"draw" => intval($_POST["draw"]),
		"recordsTotal" => $filtered_rows,
		"recordsFiltered"  => get_total_all_records($connect,"tb_kegiatan"),
		"data" => $data
	];

	echo json_encode($output);
}

function getDataSiswaDatatable($connect) {
	$query = '';
	$output = [];
	$query .= " 
		SELECT tb_siswa.*, DATE_FORMAT(tb_siswa.tgl_lahir,'%d %M %Y') as tanggal_lahir ,tb_pendaftaran.id as id_pendaftaran,tb_pendaftaran.jumlah_bayar,tb_pendaftaran.cara_bayar,tb_pendaftaran.status as status_pembayaran
		from tb_siswa
		LEFT JOIN tb_pendaftaran on tb_pendaftaran.id_siswa = tb_siswa.id
	";
	if (isset($_POST["search"]["value"])) {
		$query .= 'WHERE tb_siswa.nis LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR tb_siswa.nama LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR tb_siswa.alamat LIKE "%'.$_POST["search"]["value"].'%" ';
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
		$sub_array[] = $row['tanggal_lahir'];
		$sub_array[] = $row['alamat'];
		$sub_array[] = $status;
		$sub_array[] = '
			<div class="col-sm-12" style="margin-top:5px;">
				<button type="button" name="view-data-konfirmasi" id="'.$row["id_pendaftaran"].'" class="btn btn-primary btn-xs view-data-konfirmasi">Lihat Bukti Pembayaran</button>
			</div>
			<div class="col-sm-12" style="margin-top:5px;">
				<button type="button" name="konfirmasi-pembayaran" id="'.$row["id_pendaftaran"].'" class="btn btn-info btn-xs konfirmasi-siswa" data-status="'.$row["id"].'">Konfirmasi Pembayaran</button>
			</div>
		';
		$data[] = $sub_array;
	}

	$output = [
		"draw" => intval($_POST["draw"]),
		"recordsTotal" => $filtered_rows,
		"recordsFiltered"  => get_total_all_records($connect,"tb_siswa"),
		"data" => $data
	];

	echo json_encode($output);
}

function getSiswaBaruDatatable($connect) {
	$query = '';
	$id_ortu = $_SESSION['id'];
	$output = [];
	$query .= " 
		SELECT tb_siswa.*,DATE_FORMAT(tb_siswa.tgl_lahir,'%d %M %Y') as tanggal_lahir, tb_pendaftaran.jumlah_bayar,tb_pendaftaran.cara_bayar,tb_pendaftaran.status as status_pembayaran
		from tb_siswa
		LEFT JOIN tb_pendaftaran on tb_pendaftaran.id_siswa = tb_siswa.id
	";
	if (isset($_POST["search"]["value"])) {
		$query .= 'WHERE tb_siswa.nis LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR tb_siswa.nama LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR tb_siswa.alamat LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'AND tb_siswa.id_ortu = "'.$id_ortu.'" ';
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
		$update = '';
		$jk = '';
		if ($row['status_pembayaran'] == 'unpaid') {
			$update = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update-siswa">Update</button>';
			$status = '<span class="label label-danger">Belum Bayar</span>';
		}elseif ($row['status_pembayaran'] == 'waiting') {
			$update = '';
			$status = '<span class="label label-info">Menunggu Konfirmasi</span>';
		}elseif ($row['status_pembayaran'] == 'paid') {
			$update = '';
			$status = '<span class="label label-success">Lunas</span>';
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
		$data[] = $sub_array;
	}

	$output = [
		"draw" => intval($_POST["draw"]),
		"recordsTotal" => $filtered_rows,
		"recordsFiltered"  => get_total_all_records($connect,"tb_siswa"),
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
		$sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update-faq">Update</button>';
		$sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-xs delete-faq" data-status="'.$row["status"].'">Delete</button>';
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
		$sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update-diskon">Update</button>';
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
		$sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update-tahunajaran">Update</button>';
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
		$sub_array[] = '<button type="button" name="view" id="'.$row["nip"].'" class="btn btn-info btn-xs view-guru">View</button>';
		$sub_array[] = '<button type="button" name="update" id="'.$row["nip"].'" class="btn btn-warning btn-xs update-guru">Update</button>';
		$sub_array[] = '<button type="button" name="delete" id="'.$row["nip"].'" class="btn btn-danger btn-xs delete-guru" data-status="'.$row["status"].'">Delete</button>';
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
		$sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update-kelas">Update</button>';
		$sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-xs delete-kelas" data-status="'.$row["id"].'">Delete</button>';
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
		$sub_array[] = '<button type="button" name="view" id="'.$row["id"].'" class="btn btn-info btn-xs view-galeri">View</button>';
		$sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update-galeri">Update</button>';
		$sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-xs delete-galeri" data-status="'.$row["status"].'">Delete</button>';
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



function get_total_all_records($connect,$table){
	$statement = $connect->prepare("SELECT * FROM $table");
	$statement->execute();
	return $statement->rowCount();
}