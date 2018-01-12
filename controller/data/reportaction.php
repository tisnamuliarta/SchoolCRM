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
		WHERE tb_siswa.nis IS NOT NULL AND tb_siswa.nis = '{$nis}'  AND tb_perkembangan.id_tahun_ajaran = '{$tahun}' AND tgl BETWEEN tb_tahun_ajaran.tgl_mulai AND tb_tahun_ajaran.tgl_selesai ";

	$statement = $connect->prepare($query);
	$statement->execute();

	$result = $statement->fetch(PDO::FETCH_ASSOC);
	$final = [];
	$final["{$perkembangan}_a"] = $result["{$perkembangan}_a"];
	$final["{$perkembangan}_b"] = $result["{$perkembangan}_b"];
	$final["{$perkembangan}_c"] = $result["{$perkembangan}_c"];
	$final["{$perkembangan}_d"] = $result["{$perkembangan}_d"];

	$count = $final["{$perkembangan}_a"] + $final["{$perkembangan}_b"] + $final["{$perkembangan}_c"] + $final["{$perkembangan}_d"];
	$A = (4 * $final["{$perkembangan}_a"]);
	$B = (3 * $final["{$perkembangan}_b"]);
	$C = (2 * $final["{$perkembangan}_c"]);
	$D = (1 * $final["{$perkembangan}_d"]);
	$all = (integer)$A + (integer)$B + (integer)$C + (integer)$D;
	$average = (double)$all / (double)$count;

	if (($average >= 1) && ($average <= 1.75)) {
		return 'D';
	}elseif (($average >= 1.76) && ($average <= 2.51)) {
		return 'C';
	}elseif (($average >= 2.52) && ($average <= 3.27)) {
		return 'B';
	}elseif (($average >= 3.28) && ($average <= 4.03)) {
		return 'A';
	}

	// echo " Tahun ".$query;

	// echo " all ".$all." count ".$count." average ".$average;
	// echo " A ". $final["{$perkembangan}_a"] ." B ". $final["{$perkembangan}_b"] ." C ". $final["{$perkembangan}_c"] ." D ". $final["{$perkembangan}_d"];
}

function updateRaportTotal($connect,$nis,$tahun,$semester,$naik_kelas,$id_tahun_ajaran,$tahun_ajaran) {
	// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// query select raport
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

	// query select tahun ajaran
	// Update kenaikan kelas atau naik semester
	$update_tahun_ajaran = '';
	$ta = $connect->prepare("SELECT * FROM tb_tahun_ajaran WHERE id = {$id_tahun_ajaran}");
	$ta->execute();
	$resultta = $ta->fetch(PDO::FETCH_ASSOC);
	if (($naik_kelas == 1) && ($semester == 'semester 1')) {
		$selectNewTa = $connect->prepare("SELECT * FROM tb_tahun_ajaran WHERE tahun = '{$tahun_ajaran}' AND semester = 'semester 2' ");
		$selectNewTa->execute();
		$resultNewTa = $selectNewTa->fetch(PDO::FETCH_ASSOC);
		$update_tahun_ajaran = $resultNewTa['id'];

		// select id siswa
		$getIDSiswa = $connect->prepare("SELECT * FROM tb_siswa WHERE nis = '{$nis}' ");
		$getIDSiswa->execute();
		$resultGetIdSiswa = $getIDSiswa->fetch(PDO::FETCH_ASSOC);
		$idSiswa = $resultGetIdSiswa['id'];

		$updateDetailSiswa = $connect->prepare("UPDATE tb_detail_siswa 
			SET id_tahun_ajaran = {$update_tahun_ajaran}
			WHERE id_siswa = {$idSiswa} ");
		$updateDetailSiswa->execute();

	}else if (($naik_kelas == 1) && ($semester == 'semester 2')) {
		$selectNewTa = $connect->prepare("SELECT * FROM tb_tahun_ajaran WHERE LEFT(tahun,4) = RIGHT('{$tahun_ajaran}',4) AND semester = 'semester 1' ");
		$selectNewTa->execute();
		$resultNewTa = $selectNewTa->fetch(PDO::FETCH_ASSOC);
		$update_tahun_ajaran = $resultNewTa['id'];

		// select id siswa
		$getIDSiswa = $connect->prepare("SELECT * FROM tb_siswa WHERE nis = '{$nis}' ");
		$getIDSiswa->execute();
		$resultGetIdSiswa = $getIDSiswa->fetch(PDO::FETCH_ASSOC);
		$idSiswa = $resultGetIdSiswa['id'];

		$selectKelas = $connect->prepare("SELECT * FROM tb_kelas WHERE kelas = 'B'");
		$selectKelas->execute();
		$resultKelas = $selectKelas->fetch(PDO::FETCH_ASSOC);
		$idKelas = $resultKelas['id'];

		$updateDetailSiswa = $connect->prepare("UPDATE tb_detail_siswa 
			SET id_tahun_ajaran = {$update_tahun_ajaran},
			id_kelas = {$idKelas}
			WHERE id_siswa = {$idSiswa} ");
		$updateDetailSiswa->execute();
	}
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