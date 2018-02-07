<?php 
include '../../connection.php';

if (isset($_GET['isSearch'])) {
	// Motorik
	if (($_GET['isSearch'] == 'yes') && ($_GET['chartType'] == 'motorik')) {
		$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$nis 			= $_GET['nis'];
		$id_tahun_ajaran 	= $_GET['idTahunAjaran'];
		$month = $_GET['month'];
		$id_kegiatan = $_GET['kegiatan'];
		$day = '2010-'.$month.'-12';
		$firstDate =  date('Y-m-01', strtotime($day));
		$lastDate =  date('Y-m-t', strtotime($day));
		$query = "
			SELECT
			COUNT(tb_perkembangan.motorik) as count_m,
			WEEK(tb_perkembangan.tgl) as minggu, 
			SUM(motorik='A') as motorik_a, 
			SUM(motorik='B') as motorik_b, 
			SUM(motorik='C') as motorik_c,
			SUM(motorik='D') as motorik_d
			FROM tb_perkembangan 
			LEFT JOIN tb_siswa ON tb_siswa.nis = tb_perkembangan.nis
			LEFT JOIN tb_detail_siswa ON tb_siswa.id = tb_detail_siswa.id_siswa
			LEFT JOIN tb_tahun_ajaran ON tb_tahun_ajaran.id = tb_detail_siswa.id_tahun_ajaran
			WHERE tb_perkambangan.id_kegiatan = '{$id_kegiatan}' AND tb_perkembangan.id_tahun_ajaran = '{$id_tahun_ajaran}' AND tb_perkembangan.nis = '{$nis}' AND MONTH(tb_perkembangan.tgl) = '{$month}' AND tb_perkembangan.tgl BETWEEN DATE_ADD(DATE_ADD(LAST_DAY(tb_perkembangan.tgl), INTERVAL 1 DAY), INTERVAL - 1 MONTH) AND LAST_DAY(tb_perkembangan.tgl)
			GROUP BY WEEK(tgl)
			ORDER BY WEEK(tgl)
			";
		$statement = $connect->prepare($query);
		$statement->execute();
		$data = array();
		$returnData = array();
		$result = $statement->fetchAll();
		$idx = 0;
		foreach ($result as $row) {
			$A = (4 * $row["motorik_a"]);
			$B = (3 * $row["motorik_b"]);
			$C = (2 * $row["motorik_c"]);
			$D = (1 * $row["motorik_d"]);
			$all = (integer)$A + (integer)$B + (integer)$C + (integer)$D;
			$average = (double)$all / (double)$row['count_m'];
			if (($average >= 1) && ($average <= 1.75)) {
				$data['huruf'] =  'D';
				$data['angka'] = 1;
			}elseif (($average >= 1.76) && ($average <= 2.51)) {
				$data['huruf'] =  'C';
				$data['angka'] = 2;
			}elseif (($average >= 2.52) && ($average <= 3.27)) {
				$data['huruf'] =  'B';
				$data['angka'] = 3;
			}elseif (($average >= 3.28) && ($average <= 4.03)) {
				$data['huruf'] =  'A';
				$data['angka'] = 4;
			}
			$returnData[] = array('minggu' => $row['minggu'], 'huruf' => $data['huruf'],'nilai' => $data['angka']);
		}
		echo json_encode($returnData);
	}
	// pembiasaan
	if (($_GET['isSearch'] == 'yes') && ($_GET['chartType'] == 'pembiasaan')) {
		$nis 			= $_GET['nis'];
		$id_tahun_ajaran 	= $_GET['idTahunAjaran'];
		$month = $_GET['month'];
		$query = "
			SELECT 
			COUNT(tb_perkembangan.pembiasaan) as count_m,
			WEEK(tb_perkembangan.tgl) as minggu,
			SUM(pembiasaan='A') as pembiasaan_a, 
			SUM(pembiasaan='B') as pembiasaan_b, 
			SUM(pembiasaan='C') as pembiasaan_c,
			SUM(pembiasaan='D') as pembiasaan_d 
			FROM tb_perkembangan 
			LEFT JOIN tb_siswa ON tb_siswa.nis = tb_perkembangan.nis
			LEFT JOIN tb_detail_siswa ON tb_siswa.id = tb_detail_siswa.id_siswa
			LEFT JOIN tb_tahun_ajaran ON tb_tahun_ajaran.id = tb_detail_siswa.id_tahun_ajaran
			WHERE tb_perkembangan.id_tahun_ajaran = '{$id_tahun_ajaran}' AND tb_perkembangan.nis = '{$nis}' AND MONTH(tb_perkembangan.tgl) = '{$month}' AND tb_perkembangan.tgl BETWEEN DATE_ADD(DATE_ADD(LAST_DAY(tb_perkembangan.tgl), INTERVAL 1 DAY), INTERVAL - 1 MONTH) AND LAST_DAY(tb_perkembangan.tgl)
			GROUP BY WEEK(tgl)
			ORDER BY WEEK(tgl) ";

		$statement = $connect->prepare($query);
		$statement->execute();
		$data = array();
		$returnData = array();
		$result = $statement->fetchAll();
		$idx = 0;
		foreach ($result as $row) {
			$A = (4 * $row["pembiasaan_a"]);
			$B = (3 * $row["pembiasaan_b"]);
			$C = (2 * $row["pembiasaan_c"]);
			$D = (1 * $row["pembiasaan_d"]);
			$all = (integer)$A + (integer)$B + (integer)$C + (integer)$D;
			$average = (double)$all / (double)$row['count_m'];
			if (($average >= 1) && ($average <= 1.75)) {
				$data['huruf'] =  'D';
				$data['angka'] = 1;
			}elseif (($average >= 1.76) && ($average <= 2.51)) {
				$data['huruf'] =  'C';
				$data['angka'] = 2;
			}elseif (($average >= 2.52) && ($average <= 3.27)) {
				$data['huruf'] =  'B';
				$data['angka'] = 3;
			}elseif (($average >= 3.28) && ($average <= 4.03)) {
				$data['huruf'] =  'A';
				$data['angka'] = 4;
			}
			$returnData[] = array('minggu' => $row['minggu'], 'huruf' => $data['huruf'],'nilai' => $data['angka']);
		}
		echo json_encode($returnData);
	}
	// bahasa
	if (($_GET['isSearch'] == 'yes') && ($_GET['chartType'] == 'bahasa')) {
		$nis 			= $_GET['nis'];
		$id_tahun_ajaran 	= $_GET['idTahunAjaran'];
		$month = $_GET['month'];
		$query = "
			SELECT
			COUNT(tb_perkembangan.bahasa) as count_m,
			WEEK(tb_perkembangan.tgl) as minggu, 
			SUM(bahasa='A') as bahasa_a, 
			SUM(bahasa='B') as bahasa_b, 
			SUM(bahasa='C') as bahasa_c,
			SUM(bahasa='D') as bahasa_d 
			FROM tb_perkembangan 
			LEFT JOIN tb_siswa ON tb_siswa.nis = tb_perkembangan.nis
			LEFT JOIN tb_detail_siswa ON tb_siswa.id = tb_detail_siswa.id_siswa
			LEFT JOIN tb_tahun_ajaran ON tb_tahun_ajaran.id = tb_detail_siswa.id_tahun_ajaran
			WHERE tb_perkembangan.id_tahun_ajaran = '{$id_tahun_ajaran}' AND tb_perkembangan.nis = '{$nis}' AND MONTH(tb_perkembangan.tgl) = '{$month}' AND tb_perkembangan.tgl BETWEEN DATE_ADD(DATE_ADD(LAST_DAY(tb_perkembangan.tgl), INTERVAL 1 DAY), INTERVAL - 1 MONTH) AND LAST_DAY(tb_perkembangan.tgl)
			GROUP BY WEEK(tgl)
			ORDER BY WEEK(tgl) ";

		$statement = $connect->prepare($query);
		$statement->execute();
		$data = array();
		$returnData = array();
		$result = $statement->fetchAll();
		$idx = 0;
		foreach ($result as $row) {
			$A = (4 * $row["bahasa_a"]);
			$B = (3 * $row["bahasa_b"]);
			$C = (2 * $row["bahasa_c"]);
			$D = (1 * $row["bahasa_d"]);
			$all = (integer)$A + (integer)$B + (integer)$C + (integer)$D;
			$average = (double)$all / (double)$row['count_m'];
			if (($average >= 1) && ($average <= 1.75)) {
				$data['huruf'] =  'D';
				$data['angka'] = 1;
			}elseif (($average >= 1.76) && ($average <= 2.51)) {
				$data['huruf'] =  'C';
				$data['angka'] = 2;
			}elseif (($average >= 2.52) && ($average <= 3.27)) {
				$data['huruf'] =  'B';
				$data['angka'] = 3;
			}elseif (($average >= 3.28) && ($average <= 4.03)) {
				$data['huruf'] =  'A';
				$data['angka'] = 4;
			}
			$returnData[] = array('minggu' => $row['minggu'], 'huruf' => $data['huruf'],'nilai' => $data['angka']);
		}
		echo json_encode($returnData);
	}
	// daya_fikir
	if (($_GET['isSearch'] == 'yes') && ($_GET['chartType'] == 'daya_fikir')) {
		$nis 			= $_GET['nis'];
		$id_tahun_ajaran 	= $_GET['idTahunAjaran'];
		$month = $_GET['month'];
		$query = "
			SELECT 
			COUNT(tb_perkembangan.daya_fikir) as count_m,
			WEEK(tb_perkembangan.tgl) as minggu,
			SUM(daya_fikir='A') as daya_fikir_a, 
			SUM(daya_fikir='B') as daya_fikir_b, 
			SUM(daya_fikir='C') as daya_fikir_c,
			SUM(daya_fikir='D') as daya_fikir_d 
			FROM tb_perkembangan 
			LEFT JOIN tb_siswa ON tb_siswa.nis = tb_perkembangan.nis
			LEFT JOIN tb_detail_siswa ON tb_siswa.id = tb_detail_siswa.id_siswa
			LEFT JOIN tb_tahun_ajaran ON tb_tahun_ajaran.id = tb_detail_siswa.id_tahun_ajaran
			WHERE tb_perkembangan.id_tahun_ajaran = '{$id_tahun_ajaran}' AND tb_perkembangan.nis = '{$nis}' AND MONTH(tb_perkembangan.tgl) = '{$month}' AND tb_perkembangan.tgl BETWEEN DATE_ADD(DATE_ADD(LAST_DAY(tb_perkembangan.tgl), INTERVAL 1 DAY), INTERVAL - 1 MONTH) AND LAST_DAY(tb_perkembangan.tgl)
			GROUP BY WEEK(tgl)
			ORDER BY WEEK(tgl) ";

		$statement = $connect->prepare($query);
		$statement->execute();
		$data = array();
		$returnData = array();
		$result = $statement->fetchAll();
		$idx = 0;
		foreach ($result as $row) {
			$A = (4 * $row["daya_fikir_a"]);
			$B = (3 * $row["daya_fikir_b"]);
			$C = (2 * $row["daya_fikir_c"]);
			$D = (1 * $row["daya_fikir_d"]);
			$all = (integer)$A + (integer)$B + (integer)$C + (integer)$D;
			$average = (double)$all / (double)$row['count_m'];
			if (($average >= 1) && ($average <= 1.75)) {
				$data['huruf'] =  'D';
				$data['angka'] = 1;
			}elseif (($average >= 1.76) && ($average <= 2.51)) {
				$data['huruf'] =  'C';
				$data['angka'] = 2;
			}elseif (($average >= 2.52) && ($average <= 3.27)) {
				$data['huruf'] =  'B';
				$data['angka'] = 3;
			}elseif (($average >= 3.28) && ($average <= 4.03)) {
				$data['huruf'] =  'A';
				$data['angka'] = 4;
			}
			$returnData[] = array('minggu' => $row['minggu'], 'huruf' => $data['huruf'],'nilai' => $data['angka']);
		}
		echo json_encode($returnData);
	}
}

function displayData($connect,$type) {
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $nis 			    = $_GET['nis'];
    $id_tahun_ajaran 	= $_GET['idTahunAjaran'];
    $month              = $_GET['month'];
    $id_kegiatan        = $_GET['kegiatan'];
    $day = '2010-'.$month.'-12';
    $firstDate =  date('Y-m-01', strtotime($day));
    $lastDate =  date('Y-m-t', strtotime($day));
    $query = "
			SELECT
			COUNT(tb_perkembangan.{$type}) as count_m,
			WEEK(tb_perkembangan.tgl) as minggu, 
			SUM({$type}='A') as {$type}_a, 
			SUM({$type}='B') as {$type}_b, 
			SUM({$type}='C') as {$type}_c,
			SUM({$type}='D') as {$type}_d
			FROM tb_perkembangan 
			LEFT JOIN tb_siswa ON tb_siswa.nis = tb_perkembangan.nis
			LEFT JOIN tb_detail_siswa ON tb_siswa.id = tb_detail_siswa.id_siswa
			LEFT JOIN tb_tahun_ajaran ON tb_tahun_ajaran.id = tb_detail_siswa.id_tahun_ajaran
			WHERE tb_perkambangan.id_kegiatan = '{$id_kegiatan}' AND tb_perkembangan.id_tahun_ajaran = '{$id_tahun_ajaran}' AND tb_perkembangan.nis = '{$nis}' AND MONTH(tb_perkembangan.tgl) = '{$month}' AND tb_perkembangan.tgl BETWEEN DATE_ADD(DATE_ADD(LAST_DAY(tb_perkembangan.tgl), INTERVAL 1 DAY), INTERVAL - 1 MONTH) AND LAST_DAY(tb_perkembangan.tgl)
			GROUP BY WEEK(tgl)
			ORDER BY WEEK(tgl)
			";
    $statement = $connect->prepare($query);
    $statement->execute();
    $data = array();
    $returnData = array();
    $result = $statement->fetchAll();
    $idx = 0;
    foreach ($result as $row) {
        $A = (4 * $row["{$type}_a"]);
        $B = (3 * $row["{$type}_b"]);
        $C = (2 * $row["{$type}_c"]);
        $D = (1 * $row["{$type}_d"]);
        $all = (integer)$A + (integer)$B + (integer)$C + (integer)$D;
        $average = (double)$all / (double)$row['count_m'];
        if (($average >= 1) && ($average <= 1.75)) {
            $data['huruf'] =  'D';
            $data['angka'] = 1;
        }elseif (($average >= 1.76) && ($average <= 2.51)) {
            $data['huruf'] =  'C';
            $data['angka'] = 2;
        }elseif (($average >= 2.52) && ($average <= 3.27)) {
            $data['huruf'] =  'B';
            $data['angka'] = 3;
        }elseif (($average >= 3.28) && ($average <= 4.03)) {
            $data['huruf'] =  'A';
            $data['angka'] = 4;
        }
        $returnData[] = array('minggu' => $row['minggu'], 'huruf' => $data['huruf'],'nilai' => $data['angka']);
    }
    echo json_encode($returnData);
}
