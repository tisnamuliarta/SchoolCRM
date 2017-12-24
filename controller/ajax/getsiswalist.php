<?php 
include '../../connection.php';

$row = array();
$return_arr = array();
$row_arr = array();

if ((isset($_GET['term']) && strlen($_GET['term']) > 0) || (isset($_GET['id']) && is_numeric($_GET['id']))) 
{
	if (isset($_GET['term'])) {
		$getVar = $_GET['term'];
		$whereClause = " nama LIKE '%". $getVar ."%' ";
	}elseif ($_GET['id']) {
		$whereClause = " id = $getVar ";
	}

	$limit = intval($_GET['page_limit']);
	$sql = "SELECT id,nis,nama FROM tb_siswa WHERE :whereClause ORDER BY nama LIMIT :limitDisplay";
	$statement = $connect->prepare($sql);
	$statement->execute(array(
		':whereClause'	=> $whereClause,
		':limitDisplay'	=> $limit
	));
	$count = $statement->rowCount();
	if ($count > 0) {
		$result = $statement->fetchAll();
		foreach ($result as $resultArray) {
			$row_arr['id'] = $resultArray['id'];
			$row_arr['nis'] = $resultArray['nis'];
			$row_arr['nama'] = $resultArray['nama'];
			array_push($return_arr, $row_arr);
		}
	}
}else {
	$row_arr['id'] = 0;
	$row_arr['nis'] = null;
	$row_arr['nama'] = utf8_encode('Cari siswa...');
	array_push($return_arr, $row_arr);
}

$ret = array();
if (isset($_GET['id'])) {
	$ret = $row_arr;
}else {
	$ret['results'] = $return_arr;
}
echo json_encode($ret);