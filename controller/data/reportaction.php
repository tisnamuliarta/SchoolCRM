<?php  
/**
 * Get Nilai Motoril
 * @param  Database Object 	$connect 
 * @param  string 			$nis     
 * @param  string 			$tahun  
 * @return String         
 */
function getNilaiMotorik($connect, $nis, $tahun,$perkembangan) {
	$query = "
		SELECT 
		SUM({$perkembangan}='A') as {$perkembangan}_a, 
		SUM({$perkembangan}='B') as {$perkembangan}_b, 
		SUM({$perkembangan}='C') as {$perkembangan}_c 
		FROM tb_perkembangan 
		LEFT JOIN tb_siswa ON tb_perkembangan.nis = tb_siswa.nis
		LEFT JOIN tb_detail_siswa ON tb_detail_siswa.id_siswa = tb_siswa.id
		LEFT JOIN tb_tahun_ajaran ON tb_tahun_ajaran.id = tb_detail_siswa.id_tahun_ajaran
		LEFT JOIN tb_kelas ON tb_kelas.id = tb_detail_siswa.id_kelas
		WHERE tb_siswa.nis IS NOT NULL AND tb_siswa.nis = :nis  AND tb_detail_siswa.id_tahun_ajaran = :id_tahun_ajaran AND tgl BETWEEN tb_tahun_ajaran.tgl_mulai AND tb_tahun_ajaran.tgl_selesai ";

	$statement = $connect->prepare($query);
	$statement->execute(array(
		':nis'				=> $nis,
		':id_tahun_ajaran'	=> $tahun
	));

	$result = $statement->fetch(PDO::FETCH_ASSOC);
	$final = [];
	$final["{$perkembangan}_a"] = $result["{$perkembangan}_a"];
	$final["{$perkembangan}_b"] = $result["{$perkembangan}_b"];
	$final["{$perkembangan}_c"] = $result["{$perkembangan}_c"];

	$count = $final["{$perkembangan}_a"] + $final["{$perkembangan}_b"] + $final["{$perkembangan}_c"];
	$all = (3 * $final["{$perkembangan}_a"]) + (2 * $final["{$perkembangan}_b"]) + (1 * $final["{$perkembangan}_c"]);
	$average = (double)$all / (double)$count;

	if (($average >= 1) && ($average <= 1.6)) {
		return 'C';
	}elseif (($average >= 1.7) && ($average <= 2.3)) {
		return 'B';
	}elseif (($average >= 2.4) && ($average <= 3)) {
		return 'A';
	}

}

function updateRaportTotal($connect,$nis,$tahun) {
	// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$querySelect = "SELECT tb_raport.* FROM tb_raport
		LEFT JOIN tb_siswa ON tb_siswa.nis = tb_raport.nis
		LEFT JOIN tb_detail_siswa ON tb_siswa.id = tb_detail_siswa.id_siswa 
		WHERE tb_raport.nis = :nis AND tb_detail_siswa.id_tahun_ajaran = :tahun";

	$sts = $connect->prepare($querySelect);
	$sts->execute(array(
		':nis'		=> $nis,
		':tahun'	=> $tahun
	));
	$rs = $sts->fetch(PDO::FETCH_ASSOC);
	$total = '';

	$count = 8;
	$all = returnValue($rs['sosialisai']) + returnValue($rs['daya_ingat']) + returnValue($rs['motorik']) + returnValue($rs['keaktifan']) + returnValue($rs['kesenian']) + returnValue($rs['mendengarkan']) + returnValue($rs['membaca']) + returnValue($rs['menulis']);
	$average = round(((double)$all / (double)$count),2 );
	// echo $average;

	if (($average >= 1.00) && ($average <= 1.69)) {
		$total = 'C';
	}elseif (($average >= 1.70) && ($average <= 2.39)) {
		$total = 'B';
	}elseif (($average >= 2.40) && ($average <= 3.00)) {
		$total = 'A';
	}

	// Update
	$queryUpdate = "UPDATE tb_raport
	SET total_nilai = :total
	WHERE nis = :nis AND tahun = :tahun";
	$statementUpdate = $connect->prepare($queryUpdate);
	$statementUpdate->execute(array(
		':total'	=> $total,
		':nis'		=> $nis,
		':tahun'	=> $tahun
	));
}

function returnValue($field) {
	if ($field == 'A')
		return 3;
	elseif ($field == 'B')
		return 2;
	elseif ($field == 'C')
		return 1;
}