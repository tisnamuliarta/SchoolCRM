<?php  
include '../connection.php';
include 'function.php';

$isSame = false;
$output = [];

if (isset($_POST['btn_action_update_password'])) {
	if ($_POST['btn_action_update_password'] == 'update_password' ) {
		// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$id = $_POST['user_id_update'];
		$username = $_POST['usernameUpdatePassword'];
		$query_ortu = "SELECT * FROM tb_ortu WHERE id = {$id} AND username = '{$username}'";
	  	$statement_ortu =  $connect->prepare($query_ortu);
	  	$statement_ortu->execute();
	  	// echo $query_ortu;
	  	if ($statement_ortu->rowCount() > 0) {
	  		$query = "
				UPDATE tb_ortu
				set password = :password
				WHERE id = :id
			";
			$statement = $connect->prepare($query);
			$statement->execute(
				array(
					':password'     => password_hash($_POST['password'],PASSWORD_DEFAULT),
					':id'			=> $_POST['user_id_update']
				)
			);
			$result = $statement->fetchAll();
			if (isset($result)) {
				echo "Data telah diupdate!";
			}
	  	}else {
	  		$query_guru = "SELECT * FROM tb_ortu WHERE username = '{$username}'";
		  	$statement_guru =  $connect->prepare($query_guru);
		  	$statement_guru->execute();

		  	$result = $statement_guru->rowCount();
		  	if ($result > 0) {
			  	echo ("Ups username sudah terdaftar pada sistem, gunakan yang lain!");
		  	}else {
		  		$query = "
					UPDATE tb_ortu
					set password = :password,
					username = :username
					WHERE id = :id
				";
				$statement = $connect->prepare($query);
				$statement->execute(
					array(
						':username'			=> $_POST['usernameUpdatePassword'],
						':password'     => password_hash($_POST['password'],PASSWORD_DEFAULT),
						':id'			=> $_POST['user_id_update']
					)
				);
				$count = $statement->rowCount();
				$result = $statement->fetchAll();
				if (isset($result)) {
					echo "Data telah diupdate!";
				}
		  	}
	  	}
		
	}

	if ($_POST['btn_action_update_password'] == 'update_password_guru' ) {
		$username = $_POST['usernameUpdatePassword'];
		$nip = $_POST['user_id_update'];
		// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$query_guru = "SELECT * FROM tb_guru WHERE nip = {$nip} AND username = '{$username}'";
	  	$statement_guru =  $connect->prepare($query_guru);
	  	$statement_guru->execute();
	  	$noError = 0;
	  	// if there are any guru with same username
	  	if ($statement_guru->rowCount() > 0) {
	  		$query = "
				UPDATE tb_guru
				set password = :password
				WHERE nip = :nip
			";
			$statement = $connect->prepare($query);
			$statement->execute(
				array(
					':password'     => password_hash($_POST['password'],PASSWORD_DEFAULT),
					':nip'			=> $_POST['user_id_update']
				)
			);
			$result = $statement->fetch();
			if (isset($result)) {
				echo "Password telah diupdate!";
			}
	  	}else {
	  		$query_guru = "SELECT * FROM tb_guru WHERE username = '{$username}'";
		  	$statement_guru =  $connect->prepare($query_guru);
		  	$statement_guru->execute();

		  	$count = $statement_guru->rowCount();
		  	if ($count > 0) {
		  		echo ("Username tidak boleh sama!");
		  	}else {
		  		$query = "
					UPDATE tb_guru
					set password = :password,
					username = :username
					WHERE nip = :nip
				";
				$statement = $connect->prepare($query);
				$statement->execute(
					array(
						':username'			=> $_POST['usernameUpdatePassword'],
						':password'     => password_hash($_POST['password'],PASSWORD_DEFAULT),
						':nip'			=> $_POST['user_id_update']
					)
				);
				$result = $statement->fetch();
				if (isset($result)) {
					echo "Password telah diupdate!";
				}
		  	}
	  	}
	}
}

if (isset($_POST['btn_action'])) {
	/**
	 * ====================================
	 * Display single data
	 * ====================================
	 */
	if ($_POST['btn_action'] == 'fetch_single') {
		$query = " SELECT tb_ortu.*, (SELECT tb_pekerjaan.pekerjaan FROM tb_pekerjaan WHERE tb_pekerjaan.id = tb_ortu.pekerjaan_ayah) as nama_pekerjaan_ayah, (SELECT tb_pekerjaan.pekerjaan FROM tb_pekerjaan WHERE tb_pekerjaan.id = tb_ortu.pekerjaan_ibu) as nama_pekerjaan_ibu 
		from tb_ortu WHERE tb_ortu.id = :id ";
		$statement = $connect->prepare($query);
		$statement->execute([
			':id' => $_POST['id']
		]);
		$result = $statement->fetchAll();
		// $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
		foreach ($result as $row) {
			$output['id'] = $row['id'];
			$output['nama_ayah'] = $row['nama_ayah'];
			$output['nama_ibu'] = $row['nama_ibu'];
			$output['nama_pekerjaan_ayah'] = $row['nama_pekerjaan_ayah'];
			$output['nama_pekerjaan_ibu'] = $row['nama_pekerjaan_ibu'];
			$output['pekerjaan_ayah'] = $row['pekerjaan_ayah'];
			$output['pekerjaan_ibu'] = $row['pekerjaan_ibu'];
			$output['email'] = $row['email'];
			$output['username'] = $row['username'];
			$output['alamat'] = $row['alamat'];
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
			set nama_ayah = :nama_ayah,
			nama_ibu = :nama_ibu,
			pekerjaan_ayah = :pekerjaan_ayah,
			pekerjaan_ibu = :pekerjaan_ibu,
			email = :email,
			alamat = :alamat,
			tlpn = :tlpn,
			username = :username
			WHERE id = :id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':nama_ayah'        => $_POST['nama_ayah'],
	          	':nama_ibu'         => $_POST['nama_ibu'],
	          	':pekerjaan_ayah'   => ($_POST['pekerjaan_ayah']) ? $_POST['pekerjaan_ayah'] : null,
	          	':pekerjaan_ibu'    => ($_POST['pekerjaan_ibu']) ? $_POST['pekerjaan_ibu'] : null,
	          	':email'            => $_POST['email'],
	          	':alamat'           => $_POST['alamat'],
	          	':tlpn'             => $_POST['tlpn'],
				':id'				=> $_POST['user_id']
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


	if ($_POST['btn_action'] == 'reset_password_ortu') {
		$query ="
			UPDATE tb_ortu 
			set password = :password
			WHERE id = :id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':password' 	=> password_hash('password',PASSWORD_DEFAULT),
				':id' 	=> $_POST['id']
			)
		);
		$result = $statement->fetchAll();
		if (isset($result)) {
			echo 'Password telah direset!';
		}
	}

	if ($_POST['btn_action'] == 'reset_password_guru') {
		// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$query ="
			UPDATE tb_guru 
			set password = :password
			WHERE nip = :nip
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':password' 	=> password_hash('password',PASSWORD_DEFAULT),
				':nip' 	=> $_POST['id']
			)
		);
		$result = $statement->fetchAll();
		if (isset($result)) {
			echo 'Password telah direset!';
		}
	}

}

?>