<?php 
include '../../connection.php';

function getDataForChart($connect,$const) {
	$id_kelas 			= $_POST['id_kelas'];
	$id_tahun_ajaran 	= $_POST['id_tahun_ajaran'];
	$start_date 		= $_POST['start_date'];
	$end_date			= $_POST['end_date'];
	$query = '
		SELECT 
		COUNT(tb_perkembangan.id),
		SUM($const="A") as "'.$const.'"_a, 
		SUM($const="B") as "'.$const.'"_b, 
		SUM($const="C") as "'.$const.'"_c 
		FROM tb_perkembangan 
		LEFT JOIN tb_siswa ON tb_perkembangan.nis = tb_siswa.nis
		LEFT JOIN tb_detail_siswa ON tb_detail_siswa.id_siswa = tb_siswa.id
		LEFT JOIN tb_tahun_ajaran ON tb_tahun_ajaran.id = tb_detail_siswa.id_tahun_ajaran
		LEFT JOIN tb_kelas ON tb_kelas.id = tb_detail_siswa.id_kelas
		WHERE tb_siswa.nis IS NOT NULL AND tb_detail_siswa.id_kelas = :id_kelas AND tb_detail_siswa.id_tahun_ajaran = :id_tahun_ajaran AND tgl BETWEEN :start_date AND :end_date ';

	$statement = $this->db->query($query);
	$statement->execute(array(
		':id_kelas'			=> $id_kelas,
		':id_tahun_ajaran'	=> $id_tahun_ajaran,
		':start_date'		=> $start_date,
		':end_date'			=> $end_date
	));

	$data = array();
	$result = $statement->fetchAll();
	foreach ($result as $row) {
		$data[] = $row;
	}
	echo json_encode($data);
}
