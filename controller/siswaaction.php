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
		$newName = '';
		$fileName = explode(".", $_FILES['kk']['name']);
		$allowedExt = array("jpg","jpeg","png");
		if (in_array($fileName[1], $allowedExt)) {
			$newName = md5(rand()).'.'.$fileName[1];
			$sourcePath = $_FILES['kk']['tmp_name'];
			$destination = '../uploads/kk/'.$newName;
			move_uploaded_file($sourcePath,$destination);
		}

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

		$queryPendaftaran = "INSERT INTO tb_pendaftaran (id_siswa,id_tahun_ajaran,id_ortu,jumlah_bayar,cara_bayar,kk)
			VALUES (:id_siswa,:id_tahun_ajaran,:id_ortu,:jumlah_bayar,:cara_bayar,:kk)";
		$statementPendaftaran = $connect->prepare($queryPendaftaran);
		$statementPendaftaran->execute(array(
			':id_siswa'			=> $idSiswa,
			':id_tahun_ajaran'	=> $_POST['tahun_ajaran'],
			':id_ortu'			=> $_SESSION['id'],
			':jumlah_bayar'		=> $_POST['biayaPendaftaran'],
			':cara_bayar'		=> $_POST['metodePembayaran'],
			':kk'				=> $newName
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
		$query = " SELECT tb_siswa.*,DATE_FORMAT(tb_siswa.tgl_lahir,'%d %M %Y') as tanggal_lahir, tb_pendaftaran.jumlah_bayar,tb_pendaftaran.cara_bayar,tb_pendaftaran.id_tahun_ajaran,tb_pendaftaran.status as status_pembayaran, tb_pendaftaran.id as id_pendaftaran
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
			$output['id_pendaftaran'] = $row['id_pendaftaran'];
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
	/**
	 * =================================
	 * fetch konfirmasi pendaftaran data
	 * =================================
	 */
	if ($_POST['btn_action'] == 'fetch_konfirmasi_siswa') {
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
		}
		echo json_encode($output);
	}





	/**
	 * =================================================
	 * Update data
	 * ==================================================
	 * */
	if ($_POST['btn_action'] == 'Edit') {
		$galeriStatement = $connect->prepare("SELECT * from tb_pendaftaran where id = :id_pendaftaran");
		$galeriStatement->execute(array(
			':id_pendaftaran' => $_POST['id_pendaftaran_siswa']
		));
		$resultFoto = $galeriStatement->fetchAll();
		foreach ($galeriStatement as $row) {
			$file = "../uploads/kk/".$row["kk"];
			if (file_exists($file)) {
				unlink($file);
				$delete = true;	
			}
		}

		$newName = '';
		$fileName = explode(".", $_FILES['kk']['name']);
		$allowedExt = array("jpg","jpeg","png");
		if (in_array($fileName[1], $allowedExt)) {
			$newName = md5(rand()).'.'.$fileName[1];
			$sourcePath = $_FILES['kk']['tmp_name'];
			$destination = '../uploads/kk/'.$newName;
			move_uploaded_file($sourcePath,$destination);
		}

		$queryPendaftaran = "
			UPDATE tb_pendaftaran
			set kk = :kk
			WHERE id = :id
		";
		$statementPendaftaran = $connect->prepare($queryPendaftaran);
		$statementPendaftaran->execute(
			array(
				':kk' 		=> $newName,
				':id'			=> $_POST['id_pendaftaran_siswa']
			)
		);

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
	 * Konfirmasi Pembayaran, Page Guru
	 * ======================
	 */
	if ($_POST['btn_action'] == 'konfirmasi_pembayaran') {
		// query update pendaftaran
		$query_pendaftaran = " UPDATE tb_pendaftaran 
			set status = :status,
			keterangan = :keterangan
			WHERE id = :id_pendaftaran ";
		$statement = $connect->prepare($query_pendaftaran);
		$statement->execute(array(
				':status' 	=> 'paid',
				':keterangan' => null,
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
		$select_siswa = "SELECT tb_ortu.nama as nama_ortu, tb_siswa.nama as nama_siswa, tb_ortu.tlpn FROM tb_siswa LEFT JOIN tb_ortu ON tb_ortu.id = tb_siswa.id_ortu 
		WHERE tb_siswa.id=:id_siswa";
		$statement_siswa = $connect->prepare($select_siswa);
		$statement_siswa->execute(array(
			':id_siswa' 	=> $_POST['id_siswa']
		));
		$result_siswa = $statement_siswa->fetch(PDO::FETCH_ASSOC);
		$tlpn_ortu = $result_siswa['tlpn'];
		$nama_ortu = $result_siswa['nama_ortu'];
		$nama_siswa = $result_siswa['nama_siswa'];
		// end select pendaftaran

		$query_detail_siswa = "INSERT INTO tb_detail_siswa (id_siswa,id_kelas,id_tahun_ajaran)
		VALUES (:id_siswa,:id_kelas,:id_tahun_ajaran)";
		$statement_detail_siswa = $connect->prepare($query_detail_siswa);
		$statement_detail_siswa->execute(array(
			':id_siswa'			=> $_POST['id_siswa'],
			':id_kelas'			=> $idkelas,
			':id_tahun_ajaran'	=> $idTahunAjaran
		));

		$message = $client->message()->send([
		    'to' => $tlpn_ortu,
		    'from' => 'TK SINAR PRIMA',
		    'text' => 'Yth. '.$nama_ortu.' Terima Kasih telah menyelesaikan pembayaran untuk '.$nama_siswa.'. Pengambilan seragam dapat dilakukan mulai besok. Terima Kasih '
		]);
		$result = $statement->fetchAll();
		if (isset($result)) {
			echo 'Data berhasil dikonfirmasi ';
		}
	}
}

if (isset($_POST['btn_action_tolak'])) {
	if ($_POST['btn_action_tolak'] == 'tolak_siswa') {
		// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		// update pendaftaran
		$query = " UPDATE tb_pendaftaran
			set keterangan = :keterangan, status = :status
			WHERE id = :id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':keterangan' 		=> $_POST['keterangan'],
				':status' 			=> 'abort',
				':id'				=> $_POST['id_tolak_pendaftaran']
			)
		);
		// update siswa
		$query_siswa = " UPDATE tb_siswa
			status = :status
			WHERE id = :id
		";
		$statement_siswa = $connect->prepare($query_siswa);
		$statement_siswa->execute(
			array(
				':status' 			=> 'non-active',
				':id'				=> $_POST['id_tolak_siswa']
			)
		);

		$result = $statement->fetch();
		if (isset($result)) {
			echo "Siswa ditolak!";
		}
	}
}

if (isset($_POST['btn_action_konfirmasi'])) {
	/**
	 * =======================
	 * Konfirmasi pendaftaran
	 * ======================
	 */
	if ($_POST['btn_action_konfirmasi'] == 'konfirmasi_pendaftaran') {
		// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if (isset($_FILES['fotoBukti']['name'])) {
			$fileName = explode(".", $_FILES['fotoBukti']['name']);
			$allowedExt = array("jpg","jpeg","png");
			if (in_array($fileName[1], $allowedExt)) {
				$newName = md5(rand()).'.'.$fileName[1];
				$sourcePath = $_FILES['fotoBukti']['tmp_name'];
				$destination = '../uploads/'.$newName;
				move_uploaded_file($sourcePath,$destination);
				// Update tb_pembayaran
				$query = " UPDATE tb_pendaftaran 
				SET status = :status,
				foto = :fotoBukti
				WHERE tb_pendaftaran.id = :id_konfirmasi_pendaftaran";

				$statement = $connect->prepare($query);
				$statement->execute(array(
					':status' 	=> 'waiting',
					':fotoBukti'			=> $newName,
					':id_konfirmasi_pendaftaran' => $_POST['id_konfirmasi_pendaftaran']
				));
				$result = $statement->fetchAll();
				if (isset($result)) {
					echo 'Konfirmasi telah terkirim dan sedang diproses oleh administrator!';			
				}
			}
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