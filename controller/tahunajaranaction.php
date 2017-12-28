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
		$selectQuery = "SELECT * FROM tb_tahun_ajaran WHERE tahun = :tahunajar";
		$dbs = $connect->prepare($selectQuery);
		$dbs->execute(array(
			':tahunajar' => $_POST['tahun']
		)); 
		$countRow = $dbs->rowCount();
		if ($countRow > 0) {
			$result = $dbs->fetchAll();
			foreach ($result as $row) {
				if (($row['tahun'] == $_POST['tahun']) && ($row['semester'] == $_POST['semester'])) {
					$isSame = true;
				}
			}
		}

		if ($isSame) {
			echo 'Tahun ajaran tidak boleh sama!';
		}else {
			$query = " INSERT INTO tb_tahun_ajaran (tahun,semester,tgl_mulai,tgl_selesai) VALUES (:tahun,:semester) ";
			$statement = $connect->prepare($query);
			$statement->execute(
				array(
					':tahun' 			=> $_POST['tahun'],
					':semester' 		=> $_POST['semester'],
					':tgl_mulai' 		=> $_POST['tgl_mulai'],
					':tgl_selesai' 		=> $_POST['tgl_selesai'],
				)
			);
			$count = $statement->rowCount();
			$result = $statement->fetchAll();
			if (isset($result)) {
				echo 'Tahun ajaran berhasil ditambahkan!';
			}
		}
	}
	/**
	 * ====================================
	 * Display single data
	 * ====================================
	 */
	if ($_POST['btn_action'] == 'fetch_single') {
		$query = " SELECT * FROM tb_tahun_ajaran WHERE id = :id ";
		$statement = $connect->prepare($query);
		$statement->execute([
			':id' => $_POST['ta_id']
		]);
		$result = $statement->fetchAll();
		// $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
		foreach ($result as $row) {
			$output['id'] = $row['id'];
			$output['semester'] = $row['semester'];
			$output['tahun'] = $row['tahun'];
			$output['tgl_mulai'] = $row['tgl_mulai'];
			$output['tgl_selesai'] = $row['tgl_selesai'];
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
			UPDATE tb_tahun_ajaran
			SET tahun = :tahun,
			semester = :semester,
			tgl_mulai = :tgl_mulai,
			tgl_selesai = :tgl_selesai
			WHERE id = :ta_id
		";
		// $statement = $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':tahun' 		=> $_POST['tahun'],
				':semester' 	=> $_POST['semester'],
				':tgl_mulai' 	=> $_POST['tgl_mulai'],
				':tgl_selesai' 	=> $_POST['tgl_selesai'],
				':ta_id'		=> $_POST['ta_id']
			)
		);
		// print_r($statement->errorInfo());
		$result = $statement->fetch();
		if (isset($result)) {
			echo "Tahun ajaran berhasil diupdate!";
		}
	}

	/**
	 * ================================
	 * Change tb_tahun_ajaran status
	 * ===============================
	 */
	if ($_POST['btn_action'] == 'delete') {
		if ($_POST['status'] == 'active') {
			$status = 'non-active';
		}else {
			$status = 'non-active';
		}
		$query ="
			UPDATE tb_tahun_ajaran 
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
			UPDATE tb_tahun_ajaran 
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