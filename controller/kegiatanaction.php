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
		$newName = '';
		$fileName = explode(".", $_FILES['foto']['name']);
		$allowedExt = array("jpg","jpeg","png");
		if (in_array($fileName[1], $allowedExt)) {
			$newName = md5(rand()).'.'.$fileName[1];
			$sourcePath = $_FILES['foto']['tmp_name'];
			$destination = '../uploads/kegiatan/'.$newName;
			move_uploaded_file($sourcePath,$destination);
		}

		$query = "
			INSERT INTO tb_kegiatan (id_kelas,nip,deskripsi,nama,tgl,foto) 
			VALUES (:id_kelas,:nip,:deskripsi,:nama,:tgl,:foto)
		";
		// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':nip' 			=> $_SESSION['nip'],
				':deskripsi' 	=> $_POST['deskripsi'],
				':nama' 		=> $_POST['nama'],
				':id_kelas' 	=> $_POST['id_kelas'],
				':tgl'			=> $_POST['tgl'],
				':foto'			=> $newName,
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

		$query = " SELECT tb_kegiatan.*,tb_guru.nama as nama_guru, DATE_FORMAT(tb_kegiatan.tgl,'%d %M %Y') as tgl_kegiatan, tb_kelas.kelas
		from tb_kegiatan
		LEFT JOIN tb_guru on tb_guru.nip = tb_kegiatan.nip
		LEFT JOIN tb_kelas ON tb_kelas.id = tb_kegiatan.id_kelas 
		WHERE tb_kegiatan.id = :id ";
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
			$output['id_kelas'] = $row['id_kelas'];
		}
		echo json_encode($output);
	}

	/**
	 * =================================================
	 * Update data
	 * ==================================================
	 * */
	if ($_POST['btn_action'] == 'Edit') {
		// delete foto
		$galeriStatement = $connect->prepare("SELECT * from tb_kegiatan where id = :id_kegiatan");
		$galeriStatement->execute(array(
			':id_kegiatan' => $_POST['id_kegiatan']
		));
		$resultFoto = $galeriStatement->fetchAll();
		foreach ($resultFoto as $row) {
			$file = "../uploads/kegiatan/".$row["foto"];
			if (file_exists($file)) {
				unlink($file);
				$delete = true;	
			}
		}

		// upload foto
		$newName = '';
		$fileName = explode(".", $_FILES['foto']['name']);
		$allowedExt = array("jpg","jpeg","png");
		if (in_array($fileName[1], $allowedExt)) {
			$newName = md5(rand()).'.'.$fileName[1];
			$sourcePath = $_FILES['foto']['tmp_name'];
			$destination = '../uploads/kegiatan/'.$newName;
			move_uploaded_file($sourcePath,$destination);
		}

		$query = "
			UPDATE tb_kegiatan
			set nama = :nama,
			deskripsi = :deskripsi,
			tgl = :tgl,
			foto = :foto
			WHERE id = :id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':nama' 		=> $_POST['nama'],
				':deskripsi' 	=> $_POST['deskripsi'],
				':tgl' 			=> $_POST['tgl'],
				':foto' 		=> $newName,
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
	 * Change tb_kegiatan status
	 * ===============================
	 */
	if ($_POST['btn_action'] == 'delete') {
		$galeriStatement = $connect->prepare("SELECT * from tb_kegiatan where id = :id_kegiatan");
		$galeriStatement->execute(array(
			':id_kegiatan' => $_POST['id']
		));
		$resultFoto = $galeriStatement->fetchAll();
		foreach ($resultFoto as $row) {
			$file = "../uploads/kegiatan/".$row["foto"];
			if (file_exists($file)) {
				unlink($file);
				$delete = true;	
			}
		}

		$query ="
			DELETE FROM tb_kegiatan 
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