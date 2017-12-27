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
			SUM(motorik="C") as motorik_c 
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
		}
		echo json_encode($data);
	}
	// daya ingat
	if (($_GET['isSearch'] == 'yes') && ($_GET['chartType'] == 'daya_ingat')) {
		$const = $_GET['chartType'];
		$id_kelas 			= $_GET['idKelas'];
		$id_tahun_ajaran 	= $_GET['idTahunAjaran'];
		$start_date 		= $_GET['startDate'];
		$end_date			= $_GET['endDate'];
		$query = '
			SELECT 
			SUM(daya_ingat="A") as daya_ingat_a, 
			SUM(daya_ingat="B") as daya_ingat_b, 
			SUM(daya_ingat="C") as daya_ingat_c 
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
			$data[] = array('id' => 'A','nilai' => $row['daya_ingat_a']);
			$data[] = array('id' => 'B','nilai' => $row['daya_ingat_b']);
			$data[] = array('id' => 'C','nilai' => $row['daya_ingat_c']);
		}
		echo json_encode($data);
	}
	// keaktifan
	if (($_GET['isSearch'] == 'yes') && ($_GET['chartType'] == 'aktif')) {
		$const = $_GET['chartType'];
		$id_kelas 			= $_GET['idKelas'];
		$id_tahun_ajaran 	= $_GET['idTahunAjaran'];
		$start_date 		= $_GET['startDate'];
		$end_date			= $_GET['endDate'];
		$query = '
			SELECT 
			SUM(aktif="A") as aktif_a, 
			SUM(aktif="B") as aktif_b, 
			SUM(aktif="C") as aktif_c 
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
			$data[] = array('id' => 'A','nilai' => $row['aktif_a']);
			$data[] = array('id' => 'B','nilai' => $row['aktif_b']);
			$data[] = array('id' => 'C','nilai' => $row['aktif_c']);
		}
		echo json_encode($data);
	}
	// Sosialisai
	if (($_GET['isSearch'] == 'yes') && ($_GET['chartType'] == 'sosial')) {
		$const = $_GET['chartType'];
		$id_kelas 			= $_GET['idKelas'];
		$id_tahun_ajaran 	= $_GET['idTahunAjaran'];
		$start_date 		= $_GET['startDate'];
		$end_date			= $_GET['endDate'];
		$query = '
			SELECT 
			SUM(sosial="A") as sosial_a, 
			SUM(sosial="B") as sosial_b, 
			SUM(sosial="C") as sosial_c 
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
			$data[] = array('id' => 'A','nilai' => $row['sosial_a']);
			$data[] = array('id' => 'B','nilai' => $row['sosial_b']);
			$data[] = array('id' => 'C','nilai' => $row['sosial_c']);
		}
		echo json_encode($data);
	}
}
