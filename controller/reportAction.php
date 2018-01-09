<?php  
include '../connection.php';
include 'function.php';
include 'data/reportaction.php';

$isSame = false;
$output = [];


if (isset($_GET['btn_action'])) {
	if ($_GET['btn_action'] == 'load_nis_by_semester') {
		echo listNisBySemester($connect,$_GET['tahun']);
	}

	if ($_GET['btn_action'] == 'fill_blank_input') {
		$pembiasaan = getNilaiMotorik($connect,$_GET['nis'],$_GET['tahun'],'pembiasaan');
		$bahasa = getNilaiMotorik($connect,$_GET['nis'],$_GET['tahun'],'bahasa');
		$daya_fikir = getNilaiMotorik($connect,$_GET['nis'],$_GET['tahun'],'daya_fikir');
		$motorik = getNilaiMotorik($connect,$_GET['nis'],$_GET['tahun'],'motorik');
		echo json_encode(['pembiasaan' => $pembiasaan,'bahasa' => $bahasa,'daya_fikir' => $daya_fikir, 'motorik' => $motorik ]);
	}

	if ($_GET['btn_action'] == 'getHasilBelajar') {
		$query = '';
		$id_ortu = $_GET['id_ortu'];
		$tahunAjaran = $_GET['tahun_ajaran'];
		$nis = $_GET['nis'];
		$data = array();

		$query = "SELECT tb_siswa.nama, tb_raport.*, 
			(SELECT tb_kelas.kelas FROM tb_kelas WHERE tb_kelas.id=tb_detail_siswa.id_kelas) as kelas,
			(SELECT tb_tahun_ajaran.tahun FROM tb_tahun_ajaran WHERE tb_tahun_ajaran.id = tb_detail_siswa.id_tahun_ajaran) as tahun_ajaran,
			(SELECT tb_tahun_ajaran.semester FROM tb_tahun_ajaran WHERE tb_tahun_ajaran.id = tb_detail_siswa.id_tahun_ajaran) as semester
		from tb_raport
		LEFT JOIN tb_siswa ON tb_siswa.nis = tb_raport.nis
		LEFT JOIN tb_detail_siswa ON tb_siswa.id = tb_detail_siswa.id_siswa
		WHERE tb_siswa.nis IS NOT NULL AND tb_siswa.id_ortu = {$id_ortu} AND tb_detail_siswa.id_tahun_ajaran = {$tahunAjaran} AND tb_siswa.nis = {$nis}";

		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		$single = $statement->fetch(PDO::FETCH_ASSOC);
		foreach ($result as $row) {
			$data[] = array('kompetensi' => '<strong>I. PEMBIASAAN</strong><br>Anak mampu melakukan ibadah, terbiasa mengikuti aturan dan dapat hidup bersih dan mulai belajar membedakan benar dan salah, terbiasa berprilaku terpuji','nilai' => $row['pembiasaan']);
			$data[] = array('kompetensi' => '<strong>II. BAHASA</strong><br>Anak Mampu mendengarkan, berkomunikasi secara lisan, memiliki kesederhanaan kata dan mengenal simbul-simbul yang melambangkan - Nya untuk mempersiapkan membaca dan menulis','nilai' => $row['bahasa']);
			$data[] = array('kompetensi' => '<strong>III. DAYA FIKIR / DAYA CIPTA</strong><br>Anak mampu memahami konsep sederhana memecahkan masalah sederhana dalam kehidupan sehari-hari.','nilai' => $row['daya_fikir']);
			$data[] = array('kompetensi' => '<strong>IV. FISIK / MOTORIK</strong><br>Anak mampu melakukan aktivitas fisik secara terkoordinasi dalam rangka kelenturan, dan persiapan untuk menulis, kesembangan dan melatih keberanian.','nilai' => $row['motorik']);
			$data[] = array('kompetensi' => '<strong>TOTAL NILAI</strong>','nilai' => $row['total_nilai']);
			$data[] = array('kompetensi' => '<strong>KETERANGAN</strong> <br>'.$row['keterangan'],'nilai' => '');
		}

		echo json_encode($data);
	}
	// Buku penghubung
	if ($_GET['btn_action'] == 'getBukuPenghubung') {
		$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$query = '';
		$id_ortu = $_GET['id_ortu'];
		$tahun_ajaran = $_GET['tahun_ajaran'];
		$nis = $_GET['nis'];
		$week = $_GET['week'];
		$data = array();

		$query = "SELECT tb_kegiatan.*
		from tb_kegiatan
		LEFT JOIN tb_kelas ON tb_kegiatan.id_kelas = tb_kelas.id
		LEFT JOIN tb_detail_siswa ON tb_kelas.id = tb_detail_siswa.id_kelas
		LEFT JOIN tb_siswa ON tb_siswa.id = tb_detail_siswa.id_siswa
		LEFT JOIN tb_tahun_ajaran ON tb_tahun_ajaran.id = tb_detail_siswa.id_tahun_ajaran
		WHERE tb_siswa.nis IS NOT NULL AND tb_siswa.id_ortu = {$id_ortu} AND tb_tahun_ajaran.tahun = '{$tahun_ajaran}' AND tb_siswa.nis = '{$nis}' AND WEEK(tb_kegiatan.tgl) IN ({$week}) ";
		// echo $query;
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		$single = $statement->fetch(PDO::FETCH_ASSOC);
		foreach ($result as $row) {
			$data[] = array('nama' => $row['nama'],'deskripsi' => $row['deskripsi']);
		}

		echo json_encode($data);
	}
}

if (isset($_POST['btn_action'])) {
	/**
	 * ==========================================
	 * Save data
	 * ==========================================
	 */
	if ($_POST['btn_action'] == 'Add') {
		$semester = $_POST['semester'];
		$tahun_ajaran = $_POST['post_tahun_ajaran'];
		$id_tahun_ajaran = $_POST['tahun'];
		$nis = $_POST['nis'];
		// check duplicate
		$checkDuplicate = $connect->prepare("SELECT * FROM tb_raport WHERE nis = '{$nis}' AND tahun = {$id_tahun_ajaran}");
		$checkDuplicate->execute();
		$countCheckDuplicate = $checkDuplicate->rowCount();

		// Select kelas
		$selectKelas = $connect->prepare("SELECT tb_kelas.id FROM tb_kelas 
			LEFT JOIN tb_detail_siswa ON tb_detail_siswa.id_kelas = tb_kelas.id
			LEFT JOIN tb_siswa ON tb_siswa.id = tb_detail_siswa.id_siswa
			WHERE tb_siswa.nis = '{$nis}' ");
		$selectKelas->execute();
		$resultSelectKelas = $selectKelas->fetch(PDO::FETCH_ASSOC);


		if ($countCheckDuplicate > 0) {
			echo "Ups! terjadi kesalahan. Nilai raport hanya dapat diberikan sekali dalam 1 semester!";
		}else {
			$query = "
				INSERT INTO tb_raport (tahun,nip,nis,pembiasaan,bahasa,motorik,daya_fikir,keterangan,naik_kelas,tgl,id_kelas) 
				VALUES (:tahun,:nip,:nis,:pembiasaan,:bahasa,:motorik,:daya_fikir,:keterangan,:naik_kelas,:tgl,:id_kelas)
			";

			$naik_kelas = '';
			if ($semester == 'semester 1') {
				$naik_kelas = 1;
			}else {
				$naik_kelas = $_POST['naik_kelas'];
			}
			// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$statement = $connect->prepare($query);
			$statement->execute(
				array(
					':tahun' 			=> $id_tahun_ajaran,
					':nip' 				=> $_SESSION['nip'],
					':nis' 				=> $_POST['nis'],
					':pembiasaan' 		=> $_POST['pembiasaan'],
					':bahasa' 			=> $_POST['bahasa'],
					':motorik' 			=> $_POST['motorik'],
					':daya_fikir' 		=> $_POST['daya_fikir'],
					':keterangan' 		=> $_POST['keterangan'],
					':naik_kelas' 		=> $naik_kelas,
					':tgl'				=> $_POST['tgl'],
					':id_kelas'			=> $resultSelectKelas['id']
				)
			);

			updateRaportTotal($connect,$_POST['nis'],$_POST['tahun'],$semester,$naik_kelas,$id_tahun_ajaran,$tahun_ajaran);

			$result = $statement->fetchAll();
			if (isset($result)) {
				echo 'Nilai Raport berhasil ditambahkan!!';
			}
			
		}

	}
	/**
	 * ====================================
	 * Display single data
	 * ====================================
	 */
	if ($_POST['btn_action'] == 'fetch_single') {
		// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$query = " SELECT tb_raport.*, tb_siswa.nama, tb_siswa.jenis_kelamin, DATE_FORMAT(tb_siswa.tgl_lahir,'%d %M %Y') as tanggal_lahir , DATE_FORMAT(tb_raport.tgl,'%d %M %Y') as tanggal_raport ,
			(SELECT tb_kelas.kelas FROM tb_kelas WHERE tb_kelas.id=tb_raport.id_kelas) as kelas,
			(SELECT CONCAT(tb_tahun_ajaran.tahun) FROM tb_tahun_ajaran WHERE tb_tahun_ajaran.id = tb_raport.tahun ORDER BY tb_tahun_ajaran.tahun DESC) as tahun_ajaran,
			(SELECT tb_tahun_ajaran.semester FROM tb_tahun_ajaran WHERE tb_tahun_ajaran.id = tb_raport.tahun) as semester
			from tb_raport 
		    LEFT JOIN tb_siswa on tb_siswa.nis = tb_raport.nis
			LEFT JOIN tb_detail_siswa ON tb_siswa.id = tb_detail_siswa.id_siswa
			WHERE tb_siswa.nis IS NOT NULL AND tb_raport.id = :id ";
		$statement = $connect->prepare($query);
		$statement->execute([
			':id' => $_POST['id']
		]);
		$result = $statement->fetchAll();
		// $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
		foreach ($result as $row) {
			$output['id'] = $row['id'];
			$output['nip'] = $row['nip'];
			$output['tahun'] = $row['tahun'];
			$output['nis'] = $row['nis'];
			$output['nama'] = $row['nama'];
			$output['motorik'] = $row['motorik'];
			$output['pembiasaan'] = $row['pembiasaan'];
			$output['bahasa'] = $row['bahasa'];
			$output['daya_fikir'] = $row['daya_fikir'];
			$output['keterangan'] = $row['keterangan'];
			$output['naik_kelas'] = $row['naik_kelas'];
			$output['tahun_ajaran'] = $row['tahun_ajaran'];
			$output['semester'] = $row['semester'];
			$output['tgl'] = $row['tgl'];
		}
		echo json_encode($output);
	}

	/**
	 * =================================================
	 * Update data
	 * ==================================================
	 * */
	if ($_POST['btn_action'] == 'Edit') {
		// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$semester = $_POST['semester'];
		$tahun_ajaran = $_POST['post_tahun_ajaran'];
		$id_tahun_ajaran = $_POST['tahun'];
		$nis = $_POST['nis'];

		$query = "
			UPDATE tb_raport
			set
			keterangan = :keterangan,
			naik_kelas = :naik_kelas,
			tgl = :tgl
			WHERE id = :id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':keterangan' 		=> $_POST['keterangan'],
				':naik_kelas' 		=> $_POST['naik_kelas'],
				':tgl' 			=> $_POST['tgl'],
				':id'			=> $_POST['id_raport']
			)
		);
		// updateRaportTotal($connect,$_POST['no_induk'],$_POST['tahun']);
		updateRaportTotal($connect,$_POST['nis'],$_POST['tahun'],$semester,$_POST['naik_kelas'],$id_tahun_ajaran,$tahun_ajaran);

		$result = $statement->fetchAll();
		if (isset($result)) {
			echo "Raport siswa telah diapdate!";
		}
	}

	/**
	 * ================================
	 * Change tb_raport status
	 * ===============================
	 */
	if ($_POST['btn_action'] == 'delete') {
		$query ="
			DELETE FROM tb_raport 
			WHERE id = :id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':id' 	=> $_POST['id']
			)
		);
		$count = $statement->fetchAll();
		if (isset($count)) {
			echo 'Data perkembangan telah dihapus ';
		}
	}

}

?>