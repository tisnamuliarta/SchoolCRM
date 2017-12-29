<?php  
include '../connection.php';
include 'function.php';
include 'data/reportaction.php';

$isSame = false;
$output = [];


if (isset($_GET['btn_action'])) {
	if ($_GET['btn_action'] == 'load_nis_by_semester') {
		echo listNisBySemester($connect,$_GET['tahun']);
	}

	if ($_GET['btn_action'] == 'fill_blank_input') {
		$motorik = getNilaiMotorik($connect,$_GET['nis'],$_GET['tahun'],'motorik');
		$sosialisasi = getNilaiMotorik($connect,$_GET['nis'],$_GET['tahun'],'sosial');
		$keaktifan = getNilaiMotorik($connect,$_GET['nis'],$_GET['tahun'],'aktif');
		$daya_ingat = getNilaiMotorik($connect,$_GET['nis'],$_GET['tahun'],'daya_ingat');
		echo json_encode(['motorik' => $motorik,'sosialisasi' => $sosialisasi,'keaktifan' => $keaktifan, 'daya_ingat' => $daya_ingat ]);
	}
}

if (isset($_POST['btn_action'])) {
	/**
	 * ==========================================
	 * Save data
	 * ==========================================
	 */
	if ($_POST['btn_action'] == 'Add') {
		$query = "
			INSERT INTO tb_raport (tahun,nip,nis,keaktifan,sosialisai,motorik,daya_ingat,kesenian,mendengarkan,membaca,menulis,tgl) 
			VALUES (:tahun,:nip,:nis,:keaktifan,:sosialisai,:motorik,:daya_ingat,:kesenian,:mendengarkan,:membaca,:menulis,:tgl)
		";
		// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':tahun' 			=> $_POST['tahun'],
				':nip' 				=> $_SESSION['nip'],
				':nis' 				=> $_POST['nis'],
				':keaktifan' 		=> $_POST['aktif'],
				':sosialisai' 		=> $_POST['sosial'],
				':motorik' 			=> $_POST['motorik'],
				':daya_ingat' 		=> $_POST['daya_ingat'],
				':kesenian' 		=> $_POST['kesenian'],
				':mendengarkan' 	=> $_POST['mendengarkan'],
				':membaca' 			=> $_POST['membaca'],
				':menulis' 		=> $_POST['menulis'],
				':tgl'				=> $_POST['tgl'],
			)
		);

		updateRaportTotal($connect,$_POST['nis'],$_POST['tahun']);

		$result = $statement->fetchAll();
		if (isset($result)) {
			echo 'Nilai Raport berhasil ditambahkan!!';
		}
	}
	/**
	 * ====================================
	 * Display single data
	 * ====================================
	 */
	if ($_POST['btn_action'] == 'fetch_single') {
		// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$query = " SELECT tb_raport.*, tb_siswa.nama, tb_siswa.jenis_kelamin, DATE_FORMAT(tb_siswa.tgl_lahir,'%d %M %Y') as tanggal_lahir , DATE_FORMAT(tb_raport.tgl,'%d %M %Y') as tanggal_raport ,
			(SELECT tb_kelas.kelas FROM tb_kelas WHERE tb_kelas.id=tb_detail_siswa.id_kelas) as kelas,
			(SELECT CONCAT(tb_tahun_ajaran.tahun,' - ',tb_tahun_ajaran.semester) FROM tb_tahun_ajaran WHERE tb_tahun_ajaran.id = tb_detail_siswa.id_tahun_ajaran ORDER BY tb_tahun_ajaran.tahun DESC) as tahun_ajaran,
			(SELECT tb_tahun_ajaran.semester FROM tb_tahun_ajaran WHERE tb_tahun_ajaran.id = tb_detail_siswa.id_tahun_ajaran) as semester
			from tb_raport 
		    LEFT JOIN tb_siswa on tb_siswa.nis = tb_raport.nis
			LEFT JOIN tb_detail_siswa ON tb_siswa.id = tb_detail_siswa.id_siswa
			WHERE tb_siswa.nis IS NOT NULL AND tb_raport.id = :id ";
		$statement = $connect->prepare($query);
		$statement->execute([
			':id' => $_POST['id']
		]);
		$result = $statement->fetchAll();
		// $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
		foreach ($result as $row) {
			$output['id'] = $row['id'];
			$output['nip'] = $row['nip'];
			$output['tahun'] = $row['tahun'];
			$output['nis'] = $row['nis'];
			$output['nama'] = $row['nama'];
			$output['motorik'] = $row['motorik'];
			$output['sosial'] = $row['sosialisai'];
			$output['daya_ingat'] = $row['daya_ingat'];
			$output['aktif'] = $row['keaktifan'];
			$output['membaca'] = $row['membaca'];
			$output['kesenian'] = $row['kesenian'];
			$output['mendengarkan'] = $row['mendengarkan'];
			$output['menulis'] = $row['menulis'];
			$output['tahun_ajaran'] = $row['tahun_ajaran'];
			$output['tgl'] = $row['tgl'];
		}
		echo json_encode($output);
	}

	/**
	 * =================================================
	 * Update data
	 * ==================================================
	 * */
	if ($_POST['btn_action'] == 'Edit') {
		// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$query = "
			UPDATE tb_raport
			set
			motorik = :motorik,
			sosialisai = :sosial,
			keaktifan = :aktif,
			daya_ingat = :daya_ingat,
			kesenian = :kesenian,
			mendengarkan = :mendengarkan,
			membaca = :membaca,
			menulis = :menulis,
			tgl = :tgl
			WHERE id = :id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':motorik' 		=> $_POST['motorik'],
				':sosial' 		=> $_POST['sosial'],
				':aktif' 		=> $_POST['aktif'],
				':daya_ingat' 	=> $_POST['daya_ingat'],
				':kesenian' 	=> $_POST['kesenian'],
				':mendengarkan' => $_POST['mendengarkan'],
				':membaca' 		=> $_POST['membaca'],
				':menulis' 		=> $_POST['menulis'],
				':tgl' 			=> $_POST['tgl'],
				':id'			=> $_POST['id_raport']
			)
		);
		updateRaportTotal($connect,$_POST['no_induk'],$_POST['tahun']);

		$result = $statement->fetchAll();
		if (isset($result)) {
			echo "Raport siswa telah diapdate!";
		}
	}

	/**
	 * ================================
	 * Change tb_raport status
	 * ===============================
	 */
	if ($_POST['btn_action'] == 'delete') {
		$query ="
			DELETE FROM tb_raport 
			WHERE id = :id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':id' 	=> $_POST['id']
			)
		);
		$count = $statement->fetchAll();
		if (isset($count)) {
			echo 'Data perkembangan telah dihapus ';
		}
	}

}

?>