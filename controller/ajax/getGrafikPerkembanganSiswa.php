<?php 
include '../../connection.php';

if (isset($_GET['isSearch'])) {
	// Motorik
	if (($_GET['isSearch'] == 'yes') && ($_GET['chartType'] == 'motorik')) {
		$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$nis 			= $_GET['nis'];
		$id_tahun_ajaran 	= $_GET['idTahunAjaran'];
		$month = $_GET['month'];
		$day = '2010-'.$month.'-12';
		$firstDate =  date('Y-m-01', strtotime($day));
		$lastDate =  date('Y-m-t', strtotime($day));
		$query = "
			SELECT 
			SUM(motorik='A') as motorik_a, 
			SUM(motorik='B') as motorik_b, 
			SUM(motorik='C') as motorik_c,
			SUM(motorik='D') as motorik_d
			FROM tb_perkembangan 
			LEFT JOIN tb_siswa ON tb_siswa.nis = tb_perkembangan.nis
			LEFT JOIN tb_detail_siswa ON tb_siswa.id = tb_detail_siswa.id_siswa
			LEFT JOIN tb_tahun_ajaran ON tb_tahun_ajaran.id = tb_detail_siswa.id_tahun_ajaran
			WHERE tb_perkembangan.id_tahun_ajaran = '{$id_tahun_ajaran}' AND tb_perkembangan.nis = '{$nis}' AND MONTH(tb_perkembangan.tgl) = '{$month}' AND tb_perkembangan.tgl BETWEEN DATE_ADD(DATE_ADD(LAST_DAY(tb_perkembangan.tgl), INTERVAL 1 DAY), INTERVAL - 1 MONTH) AND LAST_DAY(tb_perkembangan.tgl)
			";
		$statement = $connect->prepare($query);
		$statement->execute();
		// echo $query;
		$data = array();
		$result = $statement->fetchAll();
		$idx = 0;
		foreach ($result as $row) {
			$data[] = array('id' => 'A','nilai' => $row['motorik_a']);
			$data[] = array('id' => 'B','nilai' => $row['motorik_b']);
			$data[] = array('id' => 'C','nilai' => $row['motorik_c']);
			$data[] = array('id' => 'D','nilai' => $row['motorik_d']);
		}
		echo json_encode($data);
	}

	// pembiasaan
	if (($_GET['isSearch'] == 'yes') && ($_GET['chartType'] == 'pembiasaan')) {
		$nis 			= $_GET['nis'];
		$id_tahun_ajaran 	= $_GET['idTahunAjaran'];
		$month = $_GET['month'];
		$query = "
			SELECT 
			SUM(pembiasaan='A') as pembiasaan_a, 
			SUM(pembiasaan='B') as pembiasaan_b, 
			SUM(pembiasaan='C') as pembiasaan_c,
			SUM(pembiasaan='D') as pembiasaan_d 
			FROM tb_perkembangan 
			LEFT JOIN tb_siswa ON tb_siswa.nis = tb_perkembangan.nis
			LEFT JOIN tb_detail_siswa ON tb_siswa.id = tb_detail_siswa.id_siswa
			LEFT JOIN tb_tahun_ajaran ON tb_tahun_ajaran.id = tb_detail_siswa.id_tahun_ajaran
			WHERE tb_perkembangan.id_tahun_ajaran = '{$id_tahun_ajaran}' AND tb_perkembangan.nis = '{$nis}' AND MONTH(tb_perkembangan.tgl) = '{$month}' AND tb_perkembangan.tgl BETWEEN DATE_ADD(DATE_ADD(LAST_DAY(tb_perkembangan.tgl), INTERVAL 1 DAY), INTERVAL - 1 MONTH) AND LAST_DAY(tb_perkembangan.tgl) ";

		$statement = $connect->prepare($query);
		$statement->execute();

		$data = array();
		$result = $statement->fetchAll();
		$idx = 0;
		foreach ($result as $row) {
			$data[] = array('id' => 'A','nilai' => $row['pembiasaan_a']);
			$data[] = array('id' => 'B','nilai' => $row['pembiasaan_b']);
			$data[] = array('id' => 'C','nilai' => $row['pembiasaan_c']);
			$data[] = array('id' => 'D','nilai' => $row['pembiasaan_d']);
		}
		echo json_encode($data);
	}
	// bahasa
	if (($_GET['isSearch'] == 'yes') && ($_GET['chartType'] == 'bahasa')) {
		$nis 			= $_GET['nis'];
		$id_tahun_ajaran 	= $_GET['idTahunAjaran'];
		$month = $_GET['month'];
		$query = "
			SELECT 
			SUM(bahasa='A') as bahasa_a, 
			SUM(bahasa='B') as bahasa_b, 
			SUM(bahasa='C') as bahasa_c,
			SUM(bahasa='D') as bahasa_d 
			FROM tb_perkembangan 
			LEFT JOIN tb_siswa ON tb_siswa.nis = tb_perkembangan.nis
			LEFT JOIN tb_detail_siswa ON tb_siswa.id = tb_detail_siswa.id_siswa
			LEFT JOIN tb_tahun_ajaran ON tb_tahun_ajaran.id = tb_detail_siswa.id_tahun_ajaran
			WHERE tb_perkembangan.id_tahun_ajaran = '{$id_tahun_ajaran}' AND tb_perkembangan.nis = '{$nis}' AND MONTH(tb_perkembangan.tgl) = '{$month}' AND tb_perkembangan.tgl BETWEEN DATE_ADD(DATE_ADD(LAST_DAY(tb_perkembangan.tgl), INTERVAL 1 DAY), INTERVAL - 1 MONTH) AND LAST_DAY(tb_perkembangan.tgl) ";

		$statement = $connect->prepare($query);
		$statement->execute();

		$data = array();
		$result = $statement->fetchAll();
		$idx = 0;
		foreach ($result as $row) {
			$data[] = array('id' => 'A','nilai' => $row['bahasa_a']);
			$data[] = array('id' => 'B','nilai' => $row['bahasa_b']);
			$data[] = array('id' => 'C','nilai' => $row['bahasa_c']);
			$data[] = array('id' => 'D','nilai' => $row['bahasa_d']);
		}
		echo json_encode($data);
	}
	// daya_fikir
	if (($_GET['isSearch'] == 'yes') && ($_GET['chartType'] == 'daya_fikir')) {
		$nis 			= $_GET['nis'];
		$id_tahun_ajaran 	= $_GET['idTahunAjaran'];
		$month = $_GET['month'];
		$query = "
			SELECT 
			SUM(daya_fikir='A') as daya_fikir_a, 
			SUM(daya_fikir='B') as daya_fikir_b, 
			SUM(daya_fikir='C') as daya_fikir_c,
			SUM(daya_fikir='D') as daya_fikir_d 
			FROM tb_perkembangan 
			LEFT JOIN tb_siswa ON tb_siswa.nis = tb_perkembangan.nis
			LEFT JOIN tb_detail_siswa ON tb_siswa.id = tb_detail_siswa.id_siswa
			LEFT JOIN tb_tahun_ajaran ON tb_tahun_ajaran.id = tb_detail_siswa.id_tahun_ajaran
			WHERE tb_perkembangan.id_tahun_ajaran = '{$id_tahun_ajaran}' AND tb_perkembangan.nis = '{$nis}' AND MONTH(tb_perkembangan.tgl) = '{$month}' AND tb_perkembangan.tgl BETWEEN DATE_ADD(DATE_ADD(LAST_DAY(tb_perkembangan.tgl), INTERVAL 1 DAY), INTERVAL - 1 MONTH) AND LAST_DAY(tb_perkembangan.tgl) ";

		$statement = $connect->prepare($query);
		$statement->execute();

		$data = array();
		$result = $statement->fetchAll();
		$idx = 0;
		foreach ($result as $row) {
			$data[] = array('id' => 'A','nilai' => $row['daya_fikir_a']);
			$data[] = array('id' => 'B','nilai' => $row['daya_fikir_b']);
			$data[] = array('id' => 'C','nilai' => $row['daya_fikir_c']);
			$data[] = array('id' => 'D','nilai' => $row['daya_fikir_d']);
		}
		echo json_encode($data);
	}
}
