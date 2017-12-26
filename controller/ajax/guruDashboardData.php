<?php 
include '../../connection.php';

if (isset($_GET['isSearch'])) {
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
			$idx++;
			$data[] = array('id' => '1','nilai' => $row['motorik_a']);
			$data[] = array('id' => '2','nilai' => $row['motorik_b']) ;
			$data[] = array('id' => '3','nilai' => $row['motorik_c']) ;
		}
		echo json_encode($data);
	}
}
