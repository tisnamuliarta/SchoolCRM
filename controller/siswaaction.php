<?php  
include '../connection.php';
include 'function.php';
include '../nexmo.php';

$output = [];
if (isset($_POST['btn_action'])) {
	/**
	 * ==========================================
	 * Save data
	 * ==========================================
	 */
	if ($_POST['btn_action'] == 'Add') {
		// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$query = "INSERT INTO tb_siswa (nama,id_ortu,tgl_lahir,alamat,jenis_kelamin) 
			VALUES (:nama,:id_ortu,:tgl_lahir,:alamat,:jenis_kelamin) ";
		$statement = $connect->prepare($query);
		$statement->execute(array(
			':nama' 		=> $_POST['nama'],
			':id_ortu' 		=> $_SESSION['id'],
			':tgl_lahir'	=> $_POST['tgl_lahir'],
			':alamat'		=> $_POST['alamat'],
			':jenis_kelamin'=> $_POST['jenis_kelamin']
		));
		$idSiswa = $connect->lastInsertId();

		$queryPendaftaran = "INSERT INTO tb_pendaftaran (id_siswa,id_tahun_ajaran,id_ortu,jumlah_bayar,cara_bayar)
			VALUES (:id_siswa,:id_tahun_ajaran,:id_ortu,:jumlah_bayar,:cara_bayar)";
		$statementPendaftaran = $connect->prepare($queryPendaftaran);
		$statementPendaftaran->execute(array(
			':id_siswa'			=> $idSiswa,
			':id_tahun_ajaran'	=> $_POST['tahun_ajaran'],
			':id_ortu'			=> $_SESSION['id'],
			':jumlah_bayar'		=> $_POST['biayaPendaftaran'],
			':cara_bayar'		=> $_POST['metodePembayaran']
		));

		$result = $statement->fetchAll();
		if (isset($result)) {
			echo 'Siswa berhasil didaftarkan, mohon segera melunasi biaya pendaftaran.!';
		}
	}
	/**
	 * ====================================
	 * Display single data
	 * ====================================
	 */
	if ($_POST['btn_action'] == 'fetch_single') {
		$query = " SELECT tb_siswa.*,DATE_FORMAT(tb_siswa.tgl_lahir,'%d %M %Y') as tanggal_lahir, tb_pendaftaran.jumlah_bayar,tb_pendaftaran.cara_bayar,tb_pendaftaran.id_tahun_ajaran,tb_pendaftaran.status as status_pembayaran
			from tb_siswa
			LEFT JOIN tb_pendaftaran on tb_pendaftaran.id_siswa = tb_siswa.id WHERE 
			tb_siswa.id = :id ";
		$statement = $connect->prepare($query);
		$statement->execute([
			':id' => $_POST['id']
		]);

		$result = $statement->fetchAll();
		// $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
		foreach ($result as $row) {
			$output['id'] = $row['id'];
			$output['nama'] = $row['nama'];
			$output['nis'] = $row['nis'];
			$output['id_tahun_ajaran'] = $row['id_tahun_ajaran'];
			$output['jumlah_bayar'] = $row['jumlah_bayar'];
			$output['tgl_lahir'] = $row['tgl_lahir'];
			$output['alamat'] = $row['alamat'];
			$output['jenis_kelamin'] = $row['jenis_kelamin'];
			$output['cara_bayar'] = $row['cara_bayar'];
			$output['status'] = $row['status'];
		}
		echo json_encode($output);
	}

	if ($_POST['btn_action'] == 'konfirmasi_siswa') {
		$query = " SELECT * FROM tb_siswa WHERE id = :id ";
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
			UPDATE tb_siswa
			set nama = :nama,
			tgl_lahir = :tgl_lahir,
			alamat = :alamat,
			jenis_kelamin = :jenis_kelamin
			WHERE id = :id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':nama' 		=> $_POST['nama'],
				':tgl_lahir' 	=> $_POST['tgl_lahir'],
				':alamat' 		=> $_POST['alamat'],
				':jenis_kelamin'=> $_POST['jenis_kelamin'],
				':id'			=> $_POST['id_siswa']
			)
		);
		$result = $statement->fetch();
		if (isset($result)) {
			echo "Data siswa telah diupdate!";
		}
	}

	/**
	 * ================================
	 * Change tb_siswa status
	 * ===============================
	 */
	if ($_POST['btn_action'] == 'delete') {
		if ($_POST['status'] == 'active') {
			$status = 'non-active';
		}else {
			$status = 'non-active';
		}
		$query ="
			UPDATE tb_siswa 
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
	/**
	 * =====================
	 * Konfirmasi Pembayaran
	 * ======================
	 */
	if ($_POST['btn_action'] == 'konfirmasi_pembayaran') {
		// query update pendaftaran
		$query_pendaftaran = " UPDATE tb_pendaftaran 
			set status = :status
			WHERE id = :id_pendaftaran ";
		$statement = $connect->prepare($query_pendaftaran);
		$statement->execute(array(
				':status' 	=> 'paid',
				':id_pendaftaran' 	=> $_POST['id_pendaftaran']
		));
		// End query update pendaftaran

		$nis = str_pad(generateNis($connect),4,"0",STR_PAD_LEFT);
		// query update siswa
		$query_siswa = "UPDATE tb_siswa 
		SET status = :status,
		nis = :nis
		WHERE id = :id_siswa ";
		$statement_siswa = $connect->prepare($query_siswa);
		$statement_siswa->execute(array(
			':status' 	=> 'active',
			':nis'		=> $nis,
			':id_siswa'	=> $_POST['id_siswa']
		));
		// end query update siswa

		// Query select kelas
		$select_kelas = "SELECT * FROM tb_kelas WHERE kelas='A'";
		$statement_kelas = $connect->prepare($select_kelas);
		$statement_kelas->execute();
		$result_kelas = $statement_kelas->fetch(PDO::FETCH_ASSOC);
		$idkelas = $result_kelas['id'];
		// echo $idkelas;
		// End query select siswa 

		// select pendaftran
		$select_pendaftaran = "SELECT * FROM tb_pendaftaran WHERE id=:id_pendaftaran";
		$statement_pendaftaran = $connect->prepare($select_pendaftaran);
		$statement_pendaftaran->execute(array(
			':id_pendaftaran' 	=> $_POST['id_pendaftaran']
		));
		$result_pendaftaran = $statement_pendaftaran->fetch(PDO::FETCH_ASSOC);
		$idTahunAjaran = $result_pendaftaran['id_tahun_ajaran'];
		// end select pendaftaran

		// select pendaftran
		$select_siswa = "SELECT tb_ortu.tlpn FROM tb_siswa LEFT JOIN tb_ortu ON tb_ortu.id = tb_siswa.id_ortu 
		WHERE tb_siswa.id=:id_siswa";
		$statement_siswa = $connect->prepare($select_siswa);
		$statement_siswa->execute(array(
			':id_siswa' 	=> $_POST['id_siswa']
		));
		$result_siswa = $statement_siswa->fetch(PDO::FETCH_ASSOC);
		$tlpn_ortu = $result_siswa['tlpn'];
		// end select pendaftaran

		$query_detail_siswa = "INSERT INTO tb_detail_siswa (id_siswa,id_kelas,id_tahun_ajaran)
		VALUES (:id_siswa,:id_kelas,:id_tahun_ajaran)";
		$statement_detail_siswa = $connect->prepare($query_detail_siswa);
		$statement_detail_siswa->execute(array(
			':id_siswa'			=> $_POST['id_siswa'],
			':id_kelas'			=> $idkelas,
			':id_tahun_ajaran'	=> $idTahunAjaran
		));

		// $message = $client->message()->send([
		//     'to' => $tlpn_ortu,
		//     'from' => 'Acme Inc',
		//     'text' => 'A text message sent using the Nexmo SMS API'
		// ]);
		$result = $statement->fetchAll();
		if (isset($result)) {
			echo 'Data berhasil dikonfirmasi ';
		}
	}

}

if (isset($_POST['btn_action_konfirm'])) {
	/**
	 * =======================
	 * Konfirmasi pendaftaran
	 * ======================
	 */
	if ($_POST['btn_action_konfirm'] == 'Konfirm') {
		if (isset($_FILES['foto']['name'])) {
			$fileName = explode(".", $_FILES['foto']['name']);
			$allowedExt = array("jpg","jpeg","png");
			if (in_array($fileName[1], $allowedExt)) {
				// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$newName = md5(rand()).'.'.$fileName[1];
				$sourcePath = $_FILES['foto']['tmp_name'];
				$destination = '../uploads/'.$newName;
				move_uploaded_file($sourcePath,$destination);
				// Update tb_pembayaran
				$query = " UPDATE tb_pendaftaran 
				SET status = :status,
				foto = :foto
				WHERE tb_pendaftaran.id = :id_pendaftaran";

				$statement = $connect->prepare($query);
				$statement->execute(array(
					':status' 	=> 'waiting',
					':foto'			=> $newName,
					':id_pendaftaran' => $_POST['id_pendaftaran']
				));

				echo 'Konfirmasi telah terkirim dan sedang diproses oleh administrator!';
			}
		}
	}
}

?>