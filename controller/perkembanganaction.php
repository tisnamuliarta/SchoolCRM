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
		$query = "
			INSERT INTO tb_perkembangan (nip,deskripsi,nama,tgl) 
			VALUES (:nip,:deskripsi,:nama,:tgl)
		";
		// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':nip' 			=> $_SESSION['nip'],
				':deskripsi' 	=> $_POST['deskripsi'],
				':nama' 		=> $_POST['nama'],
				':tgl'			=> $_POST['tgl'],
			)
		);
		$result = $statement->fetchAll();
		if (isset($result)) {
			echo 'Kegiatan added!!';
		}
	}
	/**
	 * ====================================
	 * Display single data
	 * ====================================
	 */
	if ($_POST['btn_action'] == 'fetch_single') {
		$query = " SELECT * FROM tb_perkembangan WHERE id = :id ";
		$statement = $connect->prepare($query);
		$statement->execute([
			':id' => $_POST['id']
		]);
		$result = $statement->fetchAll();
		// $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
		foreach ($result as $row) {
			$output['id'] = $row['id'];
			$output['nip'] = $row['nip'];
			$output['nama'] = $row['nama'];
			$output['deskripsi'] = $row['deskripsi'];
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
			set nama = :nama,
			deskripsi = :deskripsi,
			tgl = :tgl
			WHERE id = :id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':nama' 		=> $_POST['nama'],
				':deskripsi' 	=> $_POST['deskripsi'],
				':tgl' 			=> $_POST['tgl'],
				':id'			=> $_POST['id_kegiatan']
			)
		);
		$result = $statement->fetch();
		if (isset($result)) {
			echo "Kegiatan updated!";
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
			WHERE id = :user_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':user_id' 	=> $_POST['id']
			)
		);
		$count = $statement->fetchAll();
		if (isset($count)) {
			echo 'Kegiatan telah dihapus ';
		}
	}

}

?>