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
		// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$selectQuery = "SELECT * FROM tb_faq WHERE judul = :judul";
		$dbs = $connect->prepare($selectQuery);
		$dbs->execute(array(
			':judul' => $_POST['judul']
		)); 
		$countRow = $dbs->rowCount();
		if ($countRow > 0) {
			$result = $dbs->fetchAll();
			foreach ($result as $row) {
				if (($row['judul'] == $_POST['judul']) && ($row['kontent'] == $_POST['kontent'])) {
					$isSame = true;
				}
			}
		}

		if ($isSame) {
			echo 'FAQ tidak boleh sama!';
		}else {
			$query = " INSERT INTO tb_faq (judul,kontent) VALUES (:judul,:kontent) ";
			$statement = $connect->prepare($query);
			$statement->execute(
				array(
					':judul' 		=> $_POST['judul'],
					':kontent' 		=> $_POST['kontent'],
				)
			);
			$count = $statement->rowCount();
			$result = $statement->fetchAll();
			if (isset($result)) {
				echo 'FAQ berhasil ditambahkan!';
			}
		}
	}
	/**
	 * ====================================
	 * Display single data
	 * ====================================
	 */
	if ($_POST['btn_action'] == 'fetch_single') {
		$query = " SELECT * FROM tb_faq WHERE id = :id ";
		$statement = $connect->prepare($query);
		$statement->execute([
			':id' => $_POST['faq_id']
		]);
		$result = $statement->fetchAll();
		// $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
		foreach ($result as $row) {
			$output['id'] = $row['id'];
			$output['kontent'] = $row['kontent'];
			$output['judul'] = $row['judul'];
			$output['status'] = $row['status'];
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
			UPDATE tb_faq
			SET judul = :judul,
			kontent = :kontent,
			status = :status
			WHERE id = :ta_id
		";
		// $statement = $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':judul' 		=> $_POST['judul'],
				':kontent' 	=> $_POST['kontent'],
				':status' 	=> $_POST['status'],
				':ta_id'			=> $_POST['faq_id']
			)
		);
		// print_r($statement->errorInfo());
		$result = $statement->fetch();
		if (isset($result)) {
			echo "FAQ berhasil diupdate!";
		}
	}

	/**
	 * ================================
	 * Change tb_faq status
	 * ===============================
	 */
	if ($_POST['btn_action'] == 'delete') {
		if ($_POST['status'] == 'active') {
			$status = 'non-active';
		}else {
			$status = 'non-active';
		}
		$query ="
			UPDATE tb_faq 
			set status = :status
			WHERE id = :id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':status' 	=> $status,
				':id' 	=> $_POST['id']
			)
		);
		$result = $statement->fetchAll();
		if (isset($result)) {
			echo 'Status berubah menjadi ' . $status;
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
			UPDATE tb_faq 
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