<?php 

require_once '../../connection.php';

$query = '';
$output = [];
$kelas = $_GET['kelas'];
$tahunAjaran = $_GET['tahunAjaran'];
$query .= " 
	SELECT tb_raport.*, tb_siswa.nama, tb_siswa.jenis_kelamin, DATE_FORMAT(tb_siswa.tgl_lahir,'%d %M %Y') as tanggal_lahir , DATE_FORMAT(tb_raport.tgl,'%d %M %Y') as tanggal_raport ,
	(SELECT tb_kelas.kelas FROM tb_kelas WHERE tb_kelas.id=tb_detail_siswa.id_kelas) as kelas,
	(SELECT tb_tahun_ajaran.tahun FROM tb_tahun_ajaran WHERE tb_tahun_ajaran.id = tb_detail_siswa.id_tahun_ajaran) as tahun_ajaran,
	(SELECT tb_tahun_ajaran.semester FROM tb_tahun_ajaran WHERE tb_tahun_ajaran.id = tb_detail_siswa.id_tahun_ajaran) as semester
	from tb_raport 
    LEFT JOIN tb_siswa on tb_siswa.nis = tb_raport.nis
	LEFT JOIN tb_detail_siswa ON tb_siswa.id = tb_detail_siswa.id_siswa
	WHERE tb_siswa.nis IS NOT NULL
";

if ($_GET['isSearch'] == 'yes') {
	$query .= " AND tb_detail_siswa.id_kelas = $kelas AND tb_detail_siswa.id_tahun_ajaran = $tahunAjaran ";
}

if (isset($_GET["search"]["value"])) {
	$query .= 'AND concat(tb_siswa.nama,"",tb_siswa.nis)  LIKE "%'.$_GET["search"]["value"].'%" ';
}
if (isset($_GET["order"])) {
	$query .= 'ORDER BY '.$_GET['order']['0']['column'].' '.$_GET['order']['0']['dir'].' ';
}else {
	$query .= 'ORDER BY tb_raport.nis ASC ';
}
if ($_GET["length"] != -1) {
	$query .= 'LIMIT ' . $_GET['start'] . ', ' . $_GET['length'];
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
				<button type="button" name="update-raport" id="'.$row["id"].'" class="btn btn-info btn-sm update-raport">Update</button>
			</div>';
	$sub_array = [];
	$sub_array[] = $row['nis'];
	$sub_array[] = $row['nama'];
	$sub_array[] = $row['kelas'];
	// $sub_array[] = $row['tanggal_raport'];
	$sub_array[] = $row['sosialisai'];
	$sub_array[] = $row['motorik'];
	$sub_array[] = $row['daya_ingat'];
	$sub_array[] = $row['keaktifan'];
	$sub_array[] = $row['kesenian'];
	$sub_array[] = $row['mendengarkan'];
	$sub_array[] = $row['membaca'];
	$sub_array[] = $row['menulis'];
	$sub_array[] = $row['total_nilai'];
	$sub_array[] = $button;
	$data[] = $sub_array;
}

$output = [
	"draw" => intval($_GET["draw"]),
	"recordsTotal" => $filtered_rows,
	"recordsFiltered"  => get_total_all_notNull_siswa_records($connect,"tb_raport"),
	"data" => $data
];

echo json_encode($output);

function get_total_all_notNull_siswa_records($connect,$table){	
	$statement = $connect->prepare("SELECT * FROM $table");
	$statement->execute();
	return $statement->rowCount();
}