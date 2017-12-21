<?php  
include '../connection.php';
include 'function.php';

$isSame = false;
$output = [];

if (isset($_POST['btn_action'])) {
	/**
	 * ==========================================
	 * Save data
	 * ==========================================
	 */
	if ($_POST['btn_action'] == 'Add') {
		$query = "
			INSERT INTO tb_galeri (nip,judul,deskripsi) 
			VALUES (:nip,:judul,:deskripsi)
		";
		// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':nip' 		=> $_SESSION['nip'],
				':judul' 	=> $_POST['judul'],
				':deskripsi'	=> $_POST['deskripsi']
			)
		);
		$idGaleri = $connect->lastInsertId();
		uploadImage($connect,$idGaleri);
		$result = $statement->fetchAll();
		if (isset($result)) {
			echo 'Galeri berhasil ditambahkan';
		}
	}
	/**
	 * ====================================
	 * Display single data
	 * ====================================
	 */
	if ($_POST['btn_action'] == 'fetch_single') {
		$query = " SELECT * FROM tb_galeri WHERE id = :id ";
		$statement = $connect->prepare($query);
		$statement->execute([
			':id' => $_POST['id']
		]);
		$result = $statement->fetchAll();
		// $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
		foreach ($result as $row) {
			$output['id'] = $row['id'];
			$output['judul'] = $row['judul'];
			$output['deskripsi'] = $row['deskripsi'];
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
		$galeriDetail = "SELECT * from tb_galeri_detail where id_galeri = :id_galeri";
		$galeriStatement = $connect->prepare($galeriDetail);
		$galeriStatement->execute(array(
			':id_galeri' => $_POST['galeri_id']
		));
		foreach ($galeriStatement as $row) {
			$file = "../uploads/".$row["foto"];
			if (file_exists($file)) {
				unlink($file);
				$delete = true;	
			}
		}

		$galeriDelete = "DELETE FROM tb_galeri_detail where id_galeri = :id_galeri";
		$deleteGaleriStatement = $connect->prepare($galeriDelete);
		$deleteGaleriStatement->execute(array(
			':id_galeri' => $_POST['galeri_id']
		));

		$query = "
			UPDATE tb_galeri
			set judul = :judul,
			deskripsi = :deskripsi
			WHERE id = :id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':judul' 		=> $_POST['judul'],
				':deskripsi' 	=> $_POST['deskripsi'],
				':id'			=> $_POST['galeri_id']
			)
		);
		uploadImage($connect,$_POST['galeri_id']);
		$result = $statement->fetch();
		if (isset($result)) {
			echo "User updated!";
		}
	}

	/**
	 * ================================
	 * Change tb_galeri status
	 * ===============================
	 */
	if ($_POST['btn_action'] == 'delete') {
		$delete = false;

		$galeriDetail = "SELECT * from tb_galeri_detail where id_galeri = :id_galeri";
		$galeriStatement = $connect->prepare($galeriDetail);
		$galeriStatement->execute(array(
			':id_galeri' => $_POST['id']
		));
		foreach ($galeriStatement as $row) {
			$file = "../uploads/".$row["foto"];
			if (file_exists($file)) {
				unlink($file);
				$delete = true;	
			}
		}

		// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$query =" DELETE FROM tb_galeri WHERE id = :id ";
		$statement = $connect->prepare($query);
		$statement->execute(array(
			':id' 	=> $_POST['id']
		));
		if ($delete) {
			echo 'Galeri telah dihapus! ';
		}
	}
}

if (isset($_POST['btn_action_kelas'])) {
	/**
	 * ==========================================
	 * Save data
	 * ==========================================
	 */
	if ($_POST['btn_action_kelas'] == 'Add') {
		$query = "
			INSERT INTO tb_kelas (kelas,maximal_siswa) 
			VALUES (:kelas,:maximal_siswa)
		";
		// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':kelas' 			=> $_POST['kelas'],
				':maximal_siswa'	=> $_POST['maximal_siswa']
			)
		);
		$result = $statement->fetchAll();
		if (isset($result)) {
			echo 'Kelas berhasil ditambahkan';
		}
	}
	/**
	 * ====================================
	 * Display single data
	 * ====================================
	 */
	if ($_POST['btn_action_kelas'] == 'fetch_single') {
		$query = " SELECT * FROM tb_kelas WHERE id = :id ";
		$statement = $connect->prepare($query);
		$statement->execute([
			':id' => $_POST['id']
		]);
		$result = $statement->fetchAll();
		// $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
		foreach ($result as $row) {
			$output['id'] = $row['id'];
			$output['kelas'] = $row['kelas'];
			$output['maximal_siswa'] = $row['maximal_siswa'];
		}
		echo json_encode($output);
	}

	/**
	 * =================================================
	 * Update data
	 * ==================================================
	 * */
	if ($_POST['btn_action_kelas'] == 'Edit') {
		// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$query = "
			UPDATE tb_kelas
			set kelas = :kelas,
			maximal_siswa = :maximal_siswa
			WHERE id = :id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':kelas' 			=> $_POST['kelas'],
				':maximal_siswa' 	=> $_POST['maximal_siswa'],
				':id'				=> $_POST['id_kelas']
			)
		);
		$result = $statement->fetch();
		if (isset($result)) {
			echo "Data kelas telah diupdate!";
		}
	}

	/**
	 * ================================
	 * Change tb_galeri status
	 * ===============================
	 */
	if ($_POST['btn_action_kelas'] == 'delete') {
		// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$query =" DELETE FROM tb_kelas WHERE id = :id ";
		$statement = $connect->prepare($query);
		$statement->execute(array(
			':id' 	=> $_POST['id']
		));
		$result = $statement->fetchAll();
		if (isset($result)) {
			echo 'Kelas telah dihapus! ';
		}
	}
}

?>