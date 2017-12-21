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
			INSERT INTO tb_guru (
			nip,nama,username,password,tgl_lahir,alamat,jenis_kelamin,tlpn,status,type) 
			VALUES (:nip,:nama,:username,:password,:tgl_lahir,:alamat,:jenis_kelamin,:tlpn,:status,:type)
		";
		$statement = $connect->prepare($query);
		$password = password_hash($_POST['password'],PASSWORD_DEFAULT);
		$statement->execute(
			array(
				':nip' 		=> $_POST['nip'],
				':nama' 		=> $_POST['nama'],
				':username' 	=> $_POST['username'],
				':password' 	=> $password,
				':tgl_lahir'	=> $_POST['tgl_lahir'],
				':alamat'		=> $_POST['alamat'],
				':jenis_kelamin'=> $_POST['jenis_kelamin'],
				':tlpn'			=> $_POST['tlpn'],
				':status'		=> $_POST['status'],
				':type'			=> 'guru'
			)
		);
		$count = $statement->rowCount();
		$result = $statement->fetchAll();
		if (isset($result)) {
			echo 'Data guru berhasil ditambahkan!';
		}
	}
	/**
	 * ====================================
	 * Display single data
	 * ====================================
	 */
	if ($_POST['btn_action'] == 'fetch_single') {
		$query = " SELECT * FROM tb_guru WHERE nip = :nip ";
		$statement = $connect->prepare($query);
		$statement->execute([
			':nip' => $_POST['nip']
		]);
		$result = $statement->fetchAll();
		// $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
		foreach ($result as $row) {
			$output['nip'] = $row['nip'];
			$output['nama'] = $row['nama'];
			$output['username'] = $row['username'];
			$output['tgl_lahir'] = $row['tgl_lahir'];
			$output['alamat'] = $row['alamat'];
			$output['jenis_kelamin'] = $row['jenis_kelamin'];
			$output['tlpn'] = $row['tlpn'];
			$output['status'] = $row['status'];
			$output['type'] = $row['type'];
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
			UPDATE tb_guru
			set nama = :nama,
			tgl_lahir = :tgl_lahir,
			alamat = :alamat,
			jenis_kelamin = :jenis_kelamin,
			tlpn = :tlpn,
			status = :status
			WHERE nip = :nip
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':nama' 		=> $_POST['nama'],
				':tgl_lahir' 	=> $_POST['tgl_lahir'],
				':alamat' 		=> $_POST['alamat'],
				':jenis_kelamin'=> $_POST['jenis_kelamin'],
				':tlpn' 		=> $_POST['tlpn'],
				':status' 		=> $_POST['status'],
				':nip'			=> $_POST['user_nip']
			)
		);
		$result = $statement->fetch();
		if (isset($result)) {
			echo "Data guru berhasil diupdate!";
		}
	}

	/**
	 * ================================
	 * Change tb_guru status
	 * ===============================
	 */
	if ($_POST['btn_action'] == 'delete') {
		if ($_POST['status'] == 'active') {
			$status = 'non-active';
		}else {
			$status = 'non-active';
		}
		$query ="
			UPDATE tb_guru 
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
			UPDATE tb_guru 
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