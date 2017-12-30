<?php 
include '../../connection.php';

if (isset($_GET['isSearch'])) {
	// Motorik
	if (($_GET['isSearch'] == 'yes') && ($_GET['chartType'] == 'motorik')) {
		$const = $_GET['chartType'];
		$id_kelas 			= $_GET['idKelas'];
		$id_tahun_ajaran 	= $_GET['idTahunAjaran'];
		$start_date 		= $_GET['startDate'];
		$end_date			= $_GET['endDate'];
		$query = '
			SELECT 
			SUM(motorik="A") as motorik_a, 
			SUM(motorik="B") as motorik_b, 
			SUM(motorik="C") as motorik_c,
			SUM(motorik="D") as motorik_d 
			FROM tb_perkembangan 
			LEFT JOIN tb_siswa ON tb_perkembangan.nis = tb_siswa.nis
			LEFT JOIN tb_detail_siswa ON tb_detail_siswa.id_siswa = tb_siswa.id
			LEFT JOIN tb_tahun_ajaran ON tb_tahun_ajaran.id = tb_detail_siswa.id_tahun_ajaran
			LEFT JOIN tb_kelas ON tb_kelas.id = tb_detail_siswa.id_kelas
			WHERE tb_siswa.nis IS NOT NULL AND tb_detail_siswa.id_kelas = :id_kelas AND tb_detail_siswa.id_tahun_ajaran = :id_tahun_ajaran AND tgl BETWEEN :start_date AND :end_date ';

		$statement = $connect->prepare($query);
		$statement->execute(array(
			':id_kelas'			=> $id_kelas,
			':id_tahun_ajaran'	=> $id_tahun_ajaran,
			':start_date'		=> $start_date,
			':end_date'			=> $end_date
		));

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
	// daya ingat
	if (($_GET['isSearch'] == 'yes') && ($_GET['chartType'] == 'pembiasaan')) {
		$const = $_GET['chartType'];
		$id_kelas 			= $_GET['idKelas'];
		$id_tahun_ajaran 	= $_GET['idTahunAjaran'];
		$start_date 		= $_GET['startDate'];
		$end_date			= $_GET['endDate'];
		$query = '
			SELECT 
			SUM(pembiasaan="A") as pembiasaan_a, 
			SUM(pembiasaan="B") as pembiasaan_b, 
			SUM(pembiasaan="C") as pembiasaan_c,
			SUM(pembiasaan="D") as pembiasaan_d 
			FROM tb_perkembangan 
			LEFT JOIN tb_siswa ON tb_perkembangan.nis = tb_siswa.nis
			LEFT JOIN tb_detail_siswa ON tb_detail_siswa.id_siswa = tb_siswa.id
			LEFT JOIN tb_tahun_ajaran ON tb_tahun_ajaran.id = tb_detail_siswa.id_tahun_ajaran
			LEFT JOIN tb_kelas ON tb_kelas.id = tb_detail_siswa.id_kelas
			WHERE tb_siswa.nis IS NOT NULL AND tb_detail_siswa.id_kelas = :id_kelas AND tb_detail_siswa.id_tahun_ajaran = :id_tahun_ajaran AND tgl BETWEEN :start_date AND :end_date ';

		$statement = $connect->prepare($query);
		$statement->execute(array(
			':id_kelas'			=> $id_kelas,
			':id_tahun_ajaran'	=> $id_tahun_ajaran,
			':start_date'		=> $start_date,
			':end_date'			=> $end_date
		));

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
	// keaktifan
	if (($_GET['isSearch'] == 'yes') && ($_GET['chartType'] == 'bahasa')) {
		$const = $_GET['chartType'];
		$id_kelas 			= $_GET['idKelas'];
		$id_tahun_ajaran 	= $_GET['idTahunAjaran'];
		$start_date 		= $_GET['startDate'];
		$end_date			= $_GET['endDate'];
		$query = '
			SELECT 
			SUM(bahasa="A") as bahasa_a, 
			SUM(bahasa="B") as bahasa_b, 
			SUM(bahasa="C") as bahasa_c,
			SUM(bahasa="D") as bahasa_d 
			FROM tb_perkembangan 
			LEFT JOIN tb_siswa ON tb_perkembangan.nis = tb_siswa.nis
			LEFT JOIN tb_detail_siswa ON tb_detail_siswa.id_siswa = tb_siswa.id
			LEFT JOIN tb_tahun_ajaran ON tb_tahun_ajaran.id = tb_detail_siswa.id_tahun_ajaran
			LEFT JOIN tb_kelas ON tb_kelas.id = tb_detail_siswa.id_kelas
			WHERE tb_siswa.nis IS NOT NULL AND tb_detail_siswa.id_kelas = :id_kelas AND tb_detail_siswa.id_tahun_ajaran = :id_tahun_ajaran AND tgl BETWEEN :start_date AND :end_date ';

		$statement = $connect->prepare($query);
		$statement->execute(array(
			':id_kelas'			=> $id_kelas,
			':id_tahun_ajaran'	=> $id_tahun_ajaran,
			':start_date'		=> $start_date,
			':end_date'			=> $end_date
		));

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
	// Sosialisai
	if (($_GET['isSearch'] == 'yes') && ($_GET['chartType'] == 'daya_fikir')) {
		$const = $_GET['chartType'];
		$id_kelas 			= $_GET['idKelas'];
		$id_tahun_ajaran 	= $_GET['idTahunAjaran'];
		$start_date 		= $_GET['startDate'];
		$end_date			= $_GET['endDate'];
		$query = '
			SELECT 
			SUM(daya_fikir="A") as daya_fikir_a, 
			SUM(daya_fikir="B") as daya_fikir_b, 
			SUM(daya_fikir="C") as daya_fikir_c,
			SUM(daya_fikir="D") as daya_fikir_d 
			FROM tb_perkembangan 
			LEFT JOIN tb_siswa ON tb_perkembangan.nis = tb_siswa.nis
			LEFT JOIN tb_detail_siswa ON tb_detail_siswa.id_siswa = tb_siswa.id
			LEFT JOIN tb_tahun_ajaran ON tb_tahun_ajaran.id = tb_detail_siswa.id_tahun_ajaran
			LEFT JOIN tb_kelas ON tb_kelas.id = tb_detail_siswa.id_kelas
			WHERE tb_siswa.nis IS NOT NULL AND tb_detail_siswa.id_kelas = :id_kelas AND tb_detail_siswa.id_tahun_ajaran = :id_tahun_ajaran AND tgl BETWEEN :start_date AND :end_date ';

		$statement = $connect->prepare($query);
		$statement->execute(array(
			':id_kelas'			=> $id_kelas,
			':id_tahun_ajaran'	=> $id_tahun_ajaran,
			':start_date'		=> $start_date,
			':end_date'			=> $end_date
		));

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
