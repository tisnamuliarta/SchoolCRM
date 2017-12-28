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
		$querySelect = "SELECT * FROM tb_pekerjaan";
		$stateSelect = $connect->prepare($querySelect);
		$stateSelect->execute();
		$resultSelect = $stateSelect->fetchAll();
		foreach ($resultSelect as $row) {
			if ($row['pekerjaan'] == $_POST['pekerjaan'] ) {
				$isSame = true;
			}
		}

		if ($isSame) {
			echo "Pekerjaan tidak boleh sama!";
		}else {
			$query = "
				INSERT INTO tb_pekerjaan (pekerjaan) 
				VALUES (:pekerjaan)
			";
			// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$statement = $connect->prepare($query);
			$statement->execute(
				array(
					':pekerjaan'	=> $_POST['pekerjaan']
				)
			);
			$result = $statement->fetchAll();
			if (isset($result)) {
				echo 'Pekerjaan berhasil ditambahkan';
			}
		}
	}
	/**
	 * ====================================
	 * Display single data
	 * ====================================
	 */
	if ($_POST['btn_action'] == 'fetch_single') {
		$query = " SELECT * FROM tb_pekerjaan WHERE id = :id ";
		$statement = $connect->prepare($query);
		$statement->execute([
			':id' => $_POST['id']
		]);
		$result = $statement->fetchAll();
		// $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
		foreach ($result as $row) {
			$output['id'] = $row['id'];
			$output['pekerjaan'] = $row['pekerjaan'];
		}
		echo json_encode($output);
	}

	/**
	 * =================================================
	 * Update data
	 * ==================================================
	 * */
	if ($_POST['btn_action'] == 'Edit') {
		$isSame = false;
		$querySelect = "SELECT * FROM tb_pekerjaan";
		$stateSelect = $connect->prepare($querySelect);
		$stateSelect->execute();
		$resultSelect = $stateSelect->fetchAll();
		foreach ($resultSelect as $row) {
			if ($row['pekerjaan'] == $_REQUEST['pekerjaan'] ) {
				$isSame = true;
			}
		}

		if ($isSame) {
			echo "Pekerjaan tidak boleh sama!";
		}else {
			$query = "
				UPDATE tb_pekerjaan
				set pekerjaan = :pekerjaan
				WHERE id = :id
			";
			$statement = $connect->prepare($query);
			$statement->execute(
				array(
					':pekerjaan' 		=> $_POST['pekerjaan'],
					':id'			=> $_POST['pekerjaan_id']
				)
			);
			$result = $statement->fetchAll();
			if (isset($result)) {
				echo "Pekerjaan telah diupdate!";
			}
		}
	}

	/**
	 * ================================
	 * Change tb_pekerjaan status
	 * ===============================
	 */
	if ($_POST['btn_action'] == 'delete') {

		// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$query =" DELETE FROM tb_pekerjaan WHERE id = :id ";
		$statement = $connect->prepare($query);
		$statement->execute(array(
			':id' 	=> $_POST['id']
		));
		if ($delete) {
			echo 'Pekerjaan telah dihapus! ';
		}
	}
}

?>