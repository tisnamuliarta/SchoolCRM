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
			INSERT INTO tb_ortu (nama,email,username,password,tgl_lahir,alamat,jenis_kelamin,tlpn,status) 
			VALUES (:nama,:email,:username,:password,:tgl_lahir,:alamat,:jenis_kelamin,:tlpn,:status)
		";
		$statement = $connect->prepare($query);
		$password = password_hash($_POST['password'],PASSWORD_DEFAULT);
		$statement->execute(
			array(
				':nama' 		=> $_POST['nama'],
				':email' 		=> $_POST['email'],
				':username' 	=> $_POST['username'],
				':password' 	=> $password,
				':tgl_lahir'	=> $_POST['tgl_lahir'],
				':alamat'		=> $_POST['alamat'],
				':jenis_kelamin'=> $_POST['jenis_kelamin'],
				':tlpn'			=> $_POST['tlpn'],
				':status'		=> $_POST['status']
			)
		);
		$result = $statement->fetchAll();
		if (isset($result)) {
			echo 'User added';
		}
	}
	/**
	 * ====================================
	 * Display single data
	 * ====================================
	 */
	if ($_POST['btn_action'] == 'fetch_single') {
		$query = " SELECT * FROM tb_ortu WHERE id = :id ";
		$statement = $connect->prepare($query);
		$statement->execute([
			':id' => $_POST['id']
		]);
		$result = $statement->fetchAll();
		// $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
		foreach ($result as $row) {
			$output['id'] = $row['id'];
			$output['nama'] = $row['nama'];
			$output['email'] = $row['email'];
			$output['username'] = $row['username'];
			$output['tgl_lahir'] = $row['tgl_lahir'];
			$output['alamat'] = $row['alamat'];
			$output['jenis_kelamin'] = $row['jenis_kelamin'];
			$output['tlpn'] = $row['tlpn'];
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
			UPDATE tb_ortu
			set nama = :nama,
			email = :email,
			tgl_lahir = :tgl_lahir,
			alamat = :alamat,
			jenis_kelamin = :jenis_kelamin,
			tlpn = :tlpn,
			status = :status
			WHERE id = :id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':nama' 		=> $_POST['nama'],
				':email' 		=> $_POST['email'],
				':tgl_lahir' 	=> $_POST['tgl_lahir'],
				':alamat' 		=> $_POST['alamat'],
				':jenis_kelamin'=> $_POST['jenis_kelamin'],
				':tlpn' 		=> $_POST['tlpn'],
				':status' 		=> $_POST['status'],
				':id'			=> $_POST['user_id']
			)
		);
		$count = $statement->rowCount();
		$result = $statement->fetch();
		if (isset($result)) {
			echo "User updated!";
		}
	}

	/**
	 * ================================
	 * Change tb_ortu status
	 * ===============================
	 */
	if ($_POST['btn_action'] == 'delete') {
		if ($_POST['status'] == 'active') {
			$status = 'non-active';
		}else {
			$status = 'non-active';
		}
		$query ="
			UPDATE tb_ortu 
			set status = :status
			WHERE id = :user_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':status' 	=> $status,
				':user_id' 	=> $_POST['user_id']
			)
		);
		$count = $statement->rowCount();
		if ($count > 0) {
			echo 'Status user berubah menjadi ' . $status;
		}
	}

}

?>