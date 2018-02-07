<?php 
include '../../connection.php';

if (isset($_GET['isSearch'])) {
	echo json_encode([displayData($connect,'motorik'),displayData($connect,'pembiasaan'),displayData($connect,'bahasa'),displayData($connect,'daya_fikir')]);
	// Motorik
	// if (($_GET['isSearch'] == 'yes') && ($_GET['chartType'] == 'motorik')) {
	// 	displayData($connect,'motorik');
	// }
	// // pembiasaan
	// if (($_GET['isSearch'] == 'yes') && ($_GET['chartType'] == 'pembiasaan')) {
	// 	displayData($connect,'pembiasaan');
	// }
	// // bahasa
	// if (($_GET['isSearch'] == 'yes') && ($_GET['chartType'] == 'bahasa')) {
	// 	displayData($connect,'bahasa');
	// }
	// // daya_fikir
	// if (($_GET['isSearch'] == 'yes') && ($_GET['chartType'] == 'daya_fikir')) {
	// 	displayData($connect,'daya_fikir');	
	// }
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
			WHERE tb_perkembangan.id_kegiatan = '{$id_kegiatan}' AND tb_perkembangan.id_tahun_ajaran = '{$id_tahun_ajaran}' AND tb_perkembangan.nis = '{$nis}' AND MONTH(tb_perkembangan.tgl) = '{$month}' AND tb_perkembangan.tgl BETWEEN DATE_ADD(DATE_ADD(LAST_DAY(tb_perkembangan.tgl), INTERVAL 1 DAY), INTERVAL - 1 MONTH) AND LAST_DAY(tb_perkembangan.tgl)
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
        $returnData = array('perkembangan' => "{$type}",'minggu' => $row['minggu'], 'huruf' => $data['huruf'],'nilai' => $data['angka']);
    }
    return $returnData;
}
