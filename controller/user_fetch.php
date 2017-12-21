<?php 

include '../connection.php';
include 'function.php';

$query = '';
$output = [];
$query .= "
	SELECT * from tb_ortu
";
if (isset($_POST["search"]["value"])) {
	$query .= 'WHERE tb_ortu.nama LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR tb_ortu.username LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR tb_ortu.alamat LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR tb_ortu.email LIKE "%'.$_POST["search"]["value"].'%" ';
}
if (isset($_POST["order"])) {
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}else {
	$query .= 'ORDER BY tb_ortu.id DESC ';
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
	$sub_array[] = $idx;
	$sub_array[] = $row['nama'];
	$sub_array[] = $row['username'];
	$sub_array[] = $row['tgl_lahir'];
	$sub_array[] = $jk;
	$sub_array[] = $row['tlpn'];
	// $sub_array[] = $row['alamat'];
	$sub_array[] = $status;
	$sub_array[] = '<button type="button" name="view" id="'.$row["id"].'" class="btn btn-info btn-xs view-user">View</button>';
	$sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update-user">Update</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-xs delete-user" data-status="'.$row["status"].'">Delete</button>';
	$data[] = $sub_array;
}

function get_total_all_records($connect)
{
	$statement = $connect->prepare('SELECT * FROM tb_ortu');
	$statement->execute();
	return $statement->rowCount();
}

$output = [
	"draw" => intval($_POST["draw"]),
	"recordsTotal" => $filtered_rows,
	"recordsFiltered"  => get_total_all_records($connect),
	"data" => $data
];

echo json_encode($output);