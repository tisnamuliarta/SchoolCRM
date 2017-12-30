<?php 

require_once '../../connection.php';

$query = '';
$output = [];
$kelas = $_POST['kelas'];
$tahunAjaran = $_POST['tahunAjaran'];
$startDate = $_POST['tgl_perkembangan_mulai'];
$endDate = $_POST['tgl_perkembangan_akhir'];
$query .= " 
	SELECT tb_perkembangan.*, tb_siswa.nama, tb_siswa.jenis_kelamin, DATE_FORMAT(tb_siswa.tgl_lahir,'%d %M %Y') as tanggal_lahir , DATE_FORMAT(tb_perkembangan.tgl,'%d %M %Y') as tanggal_perkembangan ,
	(SELECT tb_kelas.kelas FROM tb_kelas WHERE tb_kelas.id=tb_detail_siswa.id_kelas) as kelas,
	(SELECT tb_tahun_ajaran.tahun FROM tb_tahun_ajaran WHERE tb_tahun_ajaran.id = tb_detail_siswa.id_tahun_ajaran) as tahun_ajaran,
	(SELECT tb_tahun_ajaran.semester FROM tb_tahun_ajaran WHERE tb_tahun_ajaran.id = tb_detail_siswa.id_tahun_ajaran) as semester
	from tb_perkembangan 
    LEFT JOIN tb_siswa on tb_siswa.nis = tb_perkembangan.nis
	LEFT JOIN tb_pendaftaran on tb_pendaftaran.id_siswa = tb_siswa.id
	LEFT JOIN tb_detail_siswa ON tb_siswa.id = tb_detail_siswa.id_siswa
	WHERE tb_siswa.nis IS NOT NULL
";

if ($_POST['isSearch'] == 'yes') {
	$query .= " AND tb_detail_siswa.id_kelas = $kelas AND tb_detail_siswa.id_tahun_ajaran = $tahunAjaran AND tb_perkembangan.tgl BETWEEN '$startDate' AND '$endDate' ";
}

if (isset($_POST["search"]["value"])) {
	$query .= 'AND concat(tb_siswa.nama,"",tb_siswa.nis,"",tb_siswa.alamat)  LIKE "%'.$_POST["search"]["value"].'%" ';
}
if (isset($_POST["order"])) {
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}else {
	$query .= 'ORDER BY tb_perkembangan.tgl ASC ';
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
	$jk = '';
	$update = '';
	$button = '<div class="btn-group-vertical">
				<button type="button" name="update-perkembangan" id="'.$row["id"].'" class="btn btn-info btn-sm update-perkembangan">Update</button>
				<button type="button" name="delete-perkembangan" id="'.$row["id"].'" class="btn btn-warning btn-sm delete-perkembangan">Delete</button>
			</div>';
	if ($row['jenis_kelamin'] == '1') {
		$jk = 'Laki-laki';
	}else {
		$jk = 'Perempuan';
	}
	$sub_array = [];
	$sub_array[] = $row['nis'];
	$sub_array[] = $row['nama'];
	$sub_array[] = $row['kelas'];
	$sub_array[] = $row['tanggal_perkembangan'];
	$sub_array[] = $row['pembiasaan'];
	$sub_array[] = $row['bahasa'];
	$sub_array[] = $row['daya_fikir'];
	$sub_array[] = $row['motorik'];
	$sub_array[] = $button;
	$data[] = $sub_array;
}

$output = [
	"draw" => intval($_POST["draw"]),
	"recordsTotal" => $filtered_rows,
	"recordsFiltered"  => get_total_all_notNull_siswa_records($connect,"tb_perkembangan"),
	"data" => $data
];

echo json_encode($output);

function get_total_all_notNull_siswa_records($connect,$table){	
	$statement = $connect->prepare("SELECT * FROM $table");
	$statement->execute();
	return $statement->rowCount();
}