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
		SUM({$perkembangan}='C') as {$perkembangan}_c,
		SUM({$perkembangan}='D') as {$perkembangan}_d 
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
	$final["{$perkembangan}_d"] = $result["{$perkembangan}_d"];

	$count = $final["{$perkembangan}_a"] + $final["{$perkembangan}_b"] + $final["{$perkembangan}_c"] + $final["{$perkembangan}_d"];
	$all = (4 * $final["{$perkembangan}_a"]) + (3 * $final["{$perkembangan}_b"]) + (2 * $final["{$perkembangan}_c"]) + (1 * $final["{$perkembangan}_a"]);

	$average = (double)$all / (double)$count;

	// echo "Average ".$average;

	if (($average >= 1) && ($average <= 1.75)) {
		return 'D';
	}elseif (($average >= 1.76) && ($average <= 2.51)) {
		return 'C';
	}elseif (($average >= 2.52) && ($average <= 3.27)) {
		return 'B';
	}elseif (($average >= 3.28) && ($average <= 4.03)) {
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

	$count = 4;
	$all = returnValue($rs['pembiasaan']) + returnValue($rs['bahasa']) + returnValue($rs['motorik']) + returnValue($rs['daya_fikir']) ;
	$average = round(((double)$all / (double)$count),2 );
	// echo $average;

	if (($average >= 1.00) && ($average <= 1.75)) {
		$total = 'D';
	}elseif (($average >= 1.76) && ($average <= 2.51)) {
		$total = 'C';
	}elseif (($average >= 2.52) && ($average <= 3.27)) {
		$total = 'B';
	}elseif (($average >= 3.28) && ($average <= 4.03)) {
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
		return 4;
	elseif ($field == 'B')
		return 3;
	elseif ($field == 'C')
		return 2;
	elseif ($field == 'D')
		return 1;
}