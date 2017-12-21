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
		$isSame = false;

		$query = " INSERT INTO tb_diskon (tahun_ajaran,diskon) VALUES (:tahun_ajaran,:diskon) ";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':tahun_ajaran' 		=> $_POST['tahun_ajaran'],
				':diskon' 		=> $_POST['diskon'],
			)
		);
		$count = $statement->rowCount();
		$result = $statement->fetchAll();
		if (isset($result)) {
			echo 'Diskon berhasil ditambahkan!';
		}
	}
	/**
	 * ====================================
	 * Display single data
	 * ====================================
	 */
	if ($_POST['btn_action'] == 'fetch_single') {
		$query = " SELECT tb_diskon.*, (SELECT CONCAT(tb_tahun_ajaran.tahun,' - ',tb_tahun_ajaran.semester) FROM tb_tahun_ajaran WHERE tb_tahun_ajaran.id = tb_diskon.tahun_ajaran) as tahun_ajaran_detail FROM tb_diskon WHERE id = :id ";
		$statement = $connect->prepare($query);
		$statement->execute([
			':id' => $_POST['id']
		]);
		$result = $statement->fetchAll();
		// $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
		foreach ($result as $row) {
			$output['id'] = $row['id'];
			$output['diskon'] = $row['diskon'];
			$output['tahun_ajaran'] = $row['tahun_ajaran'];
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
			UPDATE tb_diskon
			SET tahun_ajaran = :tahun_ajaran,
			diskon = :diskon
			WHERE id = :id
		";
		// $statement = $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':tahun_ajaran' 		=> $_POST['tahun_ajaran'],
				':diskon' 	=> $_POST['diskon'],
				':id'			=> $_POST['diskon_id']
			)
		);
		// print_r($statement->errorInfo());
		$result = $statement->fetch();
		if (isset($result)) {
			echo "Diskon berhasil diupdate!";
		}
	}

	/**
	 * ================================
	 * Change tb_diskon status
	 * ===============================
	 */
	if ($_POST['btn_action'] == 'delete') {
		if ($_POST['status'] == 'active') {
			$status = 'non-active';
		}else {
			$status = 'non-active';
		}
		$query ="
			UPDATE tb_diskon 
			set status = :status
			WHERE nip = :nip
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':status' 	=> $status,
				':nip' 	=> $_POST['user_nip']
			)
		);
		$count = $statement->rowCount();
		$result = $statement->fetchAll();
		if (isset($result)) {
			echo 'Status user berubah menjadi ' . $status;
		}
	}

	/**
	 * ================================
	 * Grand as admin
	 * ===============================
	 */
	if ($_POST['btn_action'] == 'asAdmin') {
		$type = 'guru';
		if ($_POST['type'] == 'guru') {
			$type = 'admin';
		}
		$query ="
			UPDATE tb_diskon 
			set type = :type
			WHERE nip = :nip
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':type' 	=> $type,
				':nip' 	=> $_POST['user_nip']
			)
		);
		$result = $statement->fetchAll();
		if (isset($result)) {
			echo 'Status user berubah menjadi ' . $type;
		}
	}

}

?>