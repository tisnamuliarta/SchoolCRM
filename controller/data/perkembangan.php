<?php 

require_once '../../connection.php';

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
				<button type="button" name="update-siswa" id="'.$row["id"].'" class="btn btn-warning btn-xs update-siswa">Update</button>
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

function get_total_all_notNull_siswa_records($connect,$table){
	$statement = $connect->prepare("SELECT * FROM $table WHERE nis IS NOT NULL");
	$statement->execute();
	return $statement->rowCount();
}