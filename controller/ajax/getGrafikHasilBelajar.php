<?php 
include '../../connection.php';

if (isset($_GET['isSearch'])) {
	// Motorik
	if (($_GET['isSearch'] == 'yes') && ($_GET['chartType'] == 'hasil')) {
		$nis 			= $_GET['nis'];
		$id_tahun_ajaran 	= $_GET['idTahunAjaran'];
		$query = '
			SELECT tb_raport.sosialisai, tb_raport.daya_ingat, tb_raport.motorik, tb_raport.keaktifan, tb_raport.kesenian, tb_raport.mendengarkan, tb_raport.membaca, tb_raport.menulis 
			FROM tb_raport 
			WHERE tb_raport.tahun = :tahun AND tb_raport.nis = :nis';

		$statement = $connect->prepare($query);
		$statement->execute(array(
			':nis'			=> $nis,
			':tahun'	=> $id_tahun_ajaran,
		));

		$data = array();
		$result = $statement->fetchAll();
		$idx = 0;
		foreach ($result as $row) {
			$data[] = array('id' => 'daya_ingat','nilai' => $row['daya_ingat']);
			$data[] = array('id' => 'B','nilai' => $row['motorik_b']);
			$data[] = array('id' => 'C','nilai' => $row['motorik_c']);
			$data[] = array('id' => 'A','nilai' => $row['motorik_a']);
			$data[] = array('id' => 'B','nilai' => $row['motorik_b']);
			$data[] = array('id' => 'C','nilai' => $row['motorik_c']);
			$data[] = array('id' => 'A','nilai' => $row['motorik_a']);
			$data[] = array('id' => 'B','nilai' => $row['motorik_b']);
		}
		echo json_encode($data);
	}
}
