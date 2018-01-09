<?php  
include '../connection.php';
include 'function.php';

$isSame = false;
$output = [];

if (isset($_POST['btn_action'])) {
	if ($_POST['btn_action'] == 'load_nama_siswa') {
		echo listSiswaByNIS($connect,$_POST['nis']);
	}


	/**
	 * ==========================================
	 * Save data
	 * ==========================================
	 */
	if ($_POST['btn_action'] == 'Add') {
		$nis = $_POST['nis'];
		// select perkembangan
		$query_select = "SELECT * FROM tb_perkembangan WHERE nip=:nip AND nis=:nis AND tgl=:tgl";
		$sc = $connect->prepare($query_select);
		$sc->execute(array(
			':nip'		=> $_SESSION['nip'],
			':nis'		=> $nis,
			':tgl'		=> $_POST['tgl']
		));
		$count = $sc->rowCount();
		if ($count > 0) {
			echo "Ups terjadi kesalahan!! Penilaian hanya boleh sekali dalam sehari!";
		}else {
			// select siswa
			$detail_siswa = $connect->prepare("SELECT tb_detail_siswa.* FROM tb_detail_siswa LEFT JOIN tb_siswa ON tb_siswa.id = tb_detail_siswa.id_siswa WHERE tb_siswa.nis = '{$nis}' ");
			$detail_siswa->execute();
			$result_detail_siswa = $detail_siswa->fetch(PDO::FETCH_ASSOC);
			$id_kelas = $result_detail_siswa['id_kelas'];
			$id_tahun_ajaran = $result_detail_siswa['id_tahun_ajaran'];

			$query = "
				INSERT INTO tb_perkembangan (nip,nis,pembiasaan,bahasa,daya_fikir,motorik,tgl,id_kelas,id_tahun_ajaran) 
				VALUES (:nip,:nis,:pembiasaan,:bahasa,:daya_fikir,:motorik,:tgl,:id_kelas,:id_tahun_ajaran)
			";
			// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$statement = $connect->prepare($query);
			$statement->execute(
				array(
					':nip' 			=> $_SESSION['nip'],
					':nis' 			=> $_POST['nis'],
					':pembiasaan' 		=> $_POST['pembiasaan'],
					':bahasa' 		=> $_POST['bahasa'],
					':daya_fikir' 		=> $_POST['daya_fikir'],
					':motorik' 	=> $_POST['motorik'],
					':tgl'			=> $_POST['tgl'],
					':id_kelas'			=> $id_kelas,
					':id_tahun_ajaran'			=> $id_tahun_ajaran,
				)
			);
			$result = $statement->fetchAll();
			if (isset($result)) {
				echo 'Nilai Perkembangan berhasil ditambahkan!!';
			}
		}
	}
	/**
	 * ====================================
	 * Display single data
	 * ====================================
	 */
	if ($_POST['btn_action'] == 'fetch_single') {
		$query = " SELECT tb_perkembangan.*, tb_siswa.nama, tb_siswa.jenis_kelamin, DATE_FORMAT(tb_siswa.tgl_lahir,'%d %M %Y') as tanggal_lahir ,
			(SELECT tb_kelas.kelas FROM tb_kelas WHERE tb_kelas.id=tb_perkembangan.id_kelas) as kelas,
			(SELECT tb_tahun_ajaran.tahun FROM tb_tahun_ajaran WHERE tb_tahun_ajaran.id = tb_perkembangan.id_tahun_ajaran) as tahun_ajaran,
			(SELECT tb_tahun_ajaran.semester FROM tb_tahun_ajaran WHERE tb_tahun_ajaran.id = tb_perkembangan.id_tahun_ajaran) as semester
			from tb_perkembangan 
		    LEFT JOIN tb_siswa on tb_siswa.nis = tb_perkembangan.nis
			LEFT JOIN tb_pendaftaran on tb_pendaftaran.id_siswa = tb_siswa.id
			LEFT JOIN tb_detail_siswa ON tb_siswa.id = tb_detail_siswa.id_siswa
			WHERE tb_siswa.nis IS NOT NULL AND tb_perkembangan.id = :id ";
		$statement = $connect->prepare($query);
		$statement->execute([
			':id' => $_POST['id']
		]);
		$result = $statement->fetchAll();
		// $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
		foreach ($result as $row) {
			$output['id'] = $row['id'];
			$output['nip'] = $row['nip'];
			$output['nis'] = $row['nis'];
			$output['nama'] = $row['nama'];
			$output['daya_fikir'] = $row['daya_fikir'];
			$output['bahasa'] = $row['bahasa'];
			$output['motorik'] = $row['motorik'];
			$output['pembiasaan'] = $row['pembiasaan'];
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
		$query = "
			UPDATE tb_perkembangan
			set nis = :nis,
			daya_fikir = :daya_fikir,
			bahasa = :bahasa,
			pembiasaan = :pembiasaan,
			motorik = :motorik,
			tgl = :tgl
			WHERE id = :id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':nis' 			=> $_POST['nis'],
				':daya_fikir' 		=> $_POST['daya_fikir'],
				':bahasa' 		=> $_POST['bahasa'],
				':pembiasaan' 		=> $_POST['pembiasaan'],
				':motorik' 	=> $_POST['motorik'],
				':tgl' 			=> $_POST['tgl'],
				':id'			=> $_POST['id_perkembangan']
			)
		);
		$result = $statement->fetch();
		if (isset($result)) {
			echo "Perkembangan siswa telah diapdate!";
		}
	}

	/**
	 * ================================
	 * Change tb_perkembangan status
	 * ===============================
	 */
	if ($_POST['btn_action'] == 'delete') {
		$query ="
			DELETE FROM tb_perkembangan 
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