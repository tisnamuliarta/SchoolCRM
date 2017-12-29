<?php 
function selectData($connect,$table){
	$query = "SELECT * FROM $table";
	$statement =  $connect->prepare($query);
	return $statement->execute();
}

function getActivity($connect) {
	$query = "SELECT tb_kegiatan.*, DATE_FORMAT(tb_kegiatan.tgl,'%d %M %Y') as tanggal_kegiatan FROM tb_kegiatan";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	return $result;
}

function getListPekerjaan($connect) {
	// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$query = "SELECT * FROM tb_pekerjaan ORDER BY pekerjaan ASC";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach ($result as $row) {
		$output .= '<option value="'.$row['id'].'" >'.$row['pekerjaan'].'</option>' ;
	}
	return $output;
}

function getListKelas($connect) {
	// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$query = "SELECT * FROM tb_kelas ORDER BY kelas ASC";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach ($result as $row) {
		$output .= '<option value="'.$row['id'].'" >'.$row['kelas'].'</option>' ;
	}
	return $output;
}

function getAllTahunAjaran($connect) {
	$query = "SELECT tb_tahun_ajaran.id,tb_tahun_ajaran.tahun, CONCAT(tb_tahun_ajaran.tahun,' - ',tb_tahun_ajaran.semester) as tahun_ajaran 
		FROM tb_tahun_ajaran
		ORDER BY tb_tahun_ajaran.tahun DESC ";
	$dbs = $connect->prepare($query);
	$dbs->execute();
	$result = $dbs->fetchAll();
	$output = '';
	foreach ($result as $row) {
		$output .= '<option value="'.$row['id'].'" >'.$row['tahun_ajaran'].'</option>' ;
	}
	return $output;
}

/**
 * Display list tahun ajaran
 * @param  integer $connect
 * @return string
 */
function listTahunAjatan($connect,$tahun) {
	$query = "SELECT tb_tahun_ajaran.id,tb_tahun_ajaran.tahun, CONCAT(tb_tahun_ajaran.tahun,' - ',tb_tahun_ajaran.semester) as tahun_ajaran 
		FROM tb_tahun_ajaran
		WHERE $tahun IN (SELECT LEFT(tahun,4)) OR $tahun IN(SELECT RIGHT(tahun,4)) 
		ORDER BY tb_tahun_ajaran.tahun DESC ";
	$dbs = $connect->prepare($query);
	$dbs->execute();
	$result = $dbs->fetchAll();
	$output = '';
	foreach ($result as $row) {
		$output .= '<option value="'.$row['id'].'" >'.$row['tahun_ajaran'].'</option>' ;
	}
	return $output;
}

function countSiswaBaru($connect){
	$query = "SELECT * FROM tb_siswa WHERE nis IS NOT NULL";
	$statement =  $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

function getKuotaKelas($connect,$kelas) {
	$query = "SELECT tb_kelas.* FROM tb_kelas WHERE kelas = :kelas";
	$st = $connect->prepare($query);
	$st->execute(array(
		':kelas'	=> $kelas
	));
	$result = $st->fetch(PDO::FETCH_ASSOC);
	return $result['maximal_siswa'];
}

function getCountKuotaSiswaBaru($connect,$kelas) {
	$query = "SELECT COUNT(*) as count FROM tb_siswa 
		LEFT JOIN tb_detail_siswa ON tb_siswa.id=tb_detail_siswa.id_siswa 
		LEFT JOIN tb_kelas ON tb_kelas.id = tb_detail_siswa.id_kelas
		WHERE tb_siswa.nis IS NOT NULL AND tb_siswa.status = :status
		AND tb_kelas.kelas=:kelas ";
	$statement = $connect->prepare($query);
	$statement->execute(array(
		':status'	=> 'active',
		':kelas'	=> $kelas
	));
	$return =  $statement->fetch(PDO::FETCH_ASSOC);
	return $return['count'];
}

function countTotalKuotaSiswaBaru($connect){
	return getKuotaKelas($connect,'A') - countSiswaBaru($connect);
}

function generateNis($connect) {
	$query_count = "SELECT * FROM `tb_siswa` WHERE nis IS NOT NULL";
	$statement= $connect->prepare($query_count);
	$statement->execute();
	$count = $statement->rowCount();
	return ($count + 1);
}

function uploadImage($connect,$id) {
	foreach ($_FILES['foto']['name'] as $name => $value) {
		$fileName = explode(".", $_FILES['foto']['name'][$name]);
		$allowedExt = array("jpg","jpeg","png");
		if (in_array($fileName[1], $allowedExt)) {
			$newName = md5(rand()).'.'.$fileName[1];
			$sourcePath = $_FILES['foto']['tmp_name'][$name];
			$destination = '../uploads/'.$newName;
			move_uploaded_file($sourcePath,$destination);
			// insert into database
			$query = " INSERT INTO tb_galeri_detail (id_galeri,foto) VALUES (:id_galeri,:foto)";
			$statement = $connect->prepare($query);
			$statement->execute(
				array(
					':id_galeri' 	=> $id,
					':foto'			=> $newName
				)
			);	
		}
	}
}

function getNilaiPerkembanganSiswa($connect,$nis) {
	
}

function listNisBySemester($connect,$tahun) {
	$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$query = "SELECT tb_siswa.* 
		FROM tb_siswa
		LEFT JOIN tb_detail_siswa ON tb_siswa.id = tb_detail_siswa.id_siswa
		WHERE tb_siswa.nis IS NOT NULL AND tb_detail_siswa.id_tahun_ajaran = $tahun
		ORDER BY tb_siswa.nis ASC ";
	$dbs = $connect->prepare($query);
	$dbs->execute();
	$result = $dbs->fetchAll();
	$output = '';
	$idx = 0;
	foreach ($result as $row) {
		$idx++; 
		$output .= '<option value="'.$row['nis'].'" >'.$row['nis'].'</option>' ;
	}
	return $output;
}

function listSiswaNISnotNull($connect) {
	$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$query = "SELECT tb_siswa.* 
		FROM tb_siswa
		WHERE tb_siswa.nis IS NOT NULL 
		ORDER BY tb_siswa.nis ASC ";
	$dbs = $connect->prepare($query);
	$dbs->execute();
	$result = $dbs->fetchAll();
	$output = '';
	foreach ($result as $row) {
		$output .= '<option value="'.$row['nis'].'" >'.$row['nis'].'</option>' ;
	}
	return $output;
}

function listSiswaByNIS($connect,$nis) {
	$query = "SELECT tb_siswa.* 
		FROM tb_siswa
		WHERE tb_siswa.nis = :nis 
		ORDER BY tb_siswa.nis ASC ";
	$dbs = $connect->prepare($query);
	$dbs->execute(array(
		':nis'	=> $nis
	));
	$result = $dbs->fetch(PDO::FETCH_ASSOC);
	return $result['nama'];
}

function listAllTa($connect) {
	$query = "SELECT tb_tahun_ajaran.id,tb_tahun_ajaran.tahun, CONCAT(tb_tahun_ajaran.tahun,' - ',tb_tahun_ajaran.semester) as tahun_ajaran 
		FROM tb_tahun_ajaran
		ORDER BY tb_tahun_ajaran.tahun DESC ";
	$dbs = $connect->prepare($query);
	$dbs->execute();
	$result = $dbs->fetchAll();
	$output = '';
	foreach ($result as $row) {
		$output .= '<option value="'.$row['id'].'" >'.$row['tahun_ajaran'].'</option>' ;
	}
	return $output;
}

/**
 * List siswa by ortu id
 * @param  object $connect
 * @return string
 */
function listSiswaByOrtu($connect) {
	// $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$query = "SELECT tb_siswa.nama, tb_pendaftaran.id 
	FROM tb_pendaftaran 
	LEFT JOIN tb_siswa ON tb_siswa.id = tb_pendaftaran.id_siswa
	WHERE tb_pendaftaran.id_ortu = :id_ortu AND tb_pendaftaran.status = 'unpaid' ";

	$statement = $connect->prepare($query);
	$statement->execute(array(
		':id_ortu' 	=> $_SESSION['id']
	));
	$result = $statement->fetchAll();
	$output = '';
	foreach ($result as $row) {
		$output .= '<option value="'.$row['id'].'" > Nama : '.$row['nama']. '</option>' ;
	}
	return $output;
}

/**
 * Check nip guru
 * @param  object $connect 
 * @param  string $nip     
 * @return string
 */
function checkNIP($connect,$nip) {
	$query = "SELECT * FROM tb_guru WHERE nip = :nip";
	$statement = $connect->prepare($query);
	$statement->execute(
		array(
			':nip' => $nip
		)
	);
	$count = $statement->rowCount();
	if ($count > 0) {
		$result = $statement->fetchAll();
		foreach ($result as $row) {
			if ($row['nip'] == $nip) {
				echo "NIP tidak boleh sama!";
			}
		}
	}
}

/**
 * Check if username same
 * @param  database object $connect
 * @param  string $table   
 * @param  string $username 
 * @return string
 */
function checkUsername($connect,$table,$username) {
	$query = "SELECT * FROM $table where username = :username";
	$statement =  $connect->prepare($query);
	$statement->execute(
		array(
			':username' => $username
		)
	);
	$count = $statement->rowCount();
	if ($count > 0) {
		$result = $statement->fetchAll();
		foreach ($result as $row) {
			if ($row['username'] == $username) {
				echo "Username tidak boleh sama!";
			}
		}
	}
}

function checkEmail($connect,$table,$email) {
	$query = "SELECT * FROM $table where email = :email";
	$statement =  $connect->prepare($query);
	$statement->execute(
		array(
			':email' => $email
		)
	);
	$count = $statement->rowCount();
	if ($count > 0) {
		$result = $statement->fetchAll();
		foreach ($result as $row) {
			if ($row['email'] == $email) {
				echo "Email tidak boleh sama!";
			}
		}
	}
}

function checkTlpn($connect,$table,$tlpn) {
	$query = "SELECT * FROM $table WHERE tlpn = :tlpn";
	$statement = $connect->prepare($query);
	$statement->execute(
		array(
			':tlpn' => $tlpn
		)
	);
	$count = $statement->rowCount();
	if ($count > 0) {
		$result = $statement->fetchAll();
		foreach ($result as $row) {
			if ($row['tlpn'] == $tlpn) {
				echo "Nomer telepon tidak boleh sama";
			}
		}
	}
}

function getGaleriDetail($connect,$galeri_id) {
	$qp = "SELECT tb_galeri_detail.* FROM tb_galeri_detail LEFT JOIN tb_galeri on tb_galeri.id = tb_galeri_detail.id_galeri WHERE tb_galeri_detail.id_galeri= :id_galeri ";
	$dbsg = $connect->prepare($qp);
	$dbsg->execute(array(
		':id_galeri' => $row['id']
	));
	$galeriResult = $dbsg->fetchAll();
}

/**
 * ========================
 * Display details
 * ========================
 */

function getGaleriDetails($connect,$galeri_id) {
	$query = "SELECT * FROM tb_galeri WHERE id = $galeri_id";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();

	$qp = "SELECT tb_galeri_detail.* FROM tb_galeri_detail LEFT JOIN tb_galeri on tb_galeri.id = tb_galeri_detail.id_galeri WHERE tb_galeri_detail.id_galeri= :id_galeri ";
	$dbsg = $connect->prepare($qp);
	$dbsg->execute(array(
		':id_galeri' => $galeri_id
	));
	$galeriResult = $dbsg->fetchAll();

	$output = '
	<div class="table-responsive">
		<table class="table table-boredered  table-striped">
	';
	foreach($result as $row)
	{
		$status = '';
		$jenis_kelamin = '';
		$output .= '
		<tr>
			<td>Judul</td>
			<td>'.$row["judul"].'</td>
		</tr>
		<tr>
			<td>Deskripsi</td>
			<td>'.$row["deskripsi"].'</td>
		</tr>
		';
	}
	$output .= '
		</table>
	</div>
	';
	$output .='
		<div class="row">
	';
	foreach ($galeriResult as $row) {
		$output .= '
			<div class="col-sm-4">
			    <div class="image img">
			      <img class="img img-responsive" src="../uploads/'.$row['foto'].'" alt="First slide">
			    </div>
			  </div>
		';
	}

	$output .= '
		</div>
	';

	echo $output;
}

/**
 * Get Orang tua detail
 * @param  object $connect
 * @param  integer $user_id
 * @return string
 */
function getUserDetail($connect,$user_id) {
	$query = "SELECT tb_ortu.*, (SELECT tb_pekerjaan.pekerjaan FROM tb_pekerjaan WHERE tb_pekerjaan.id = tb_ortu.pekerjaan_ayah) as nama_pekerjaan_ayah, (SELECT tb_pekerjaan.pekerjaan FROM tb_pekerjaan WHERE tb_pekerjaan.id = tb_ortu.pekerjaan_ibu) as nama_pekerjaan_ibu 
		from tb_ortu WHERE tb_ortu.id = $user_id";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '
	<div class="table-responsive">
		<table class="table table-boredered  table-striped">
	';
	foreach($result as $row)
	{
		$status = '';
		$jenis_kelamin = '';
		if($row['status'] == 'active'){
			$status = '<span class="label label-success">Active</span>';
		}else{
			$status = '<span class="label label-danger">Non Active</span>';
		}
		$output .= '
		<tr>
			<td>Nama Ayah</td>
			<td>'.$row["nama_ayah"].'</td>
		</tr>
		<tr>
			<td>Nama Ibu</td>
			<td>'.$row["nama_ibu"].'</td>
		</tr>
		<tr>
			<td>Pekerjaan Ayah</td>
			<td>'.$row["nama_pekerjaan_ayah"].'</td>
		</tr>
		<tr>
			<td>Pekerjaan Ibu</td>
			<td>'.$row["nama_pekerjaan_ibu"].'</td>
		</tr>
		<tr>
			<td>Email</td>
			<td>'.$row["email"].'</td>
		</tr>
		<tr>
			<td>Username</td>
			<td>'.$row["username"].'</td>
		</tr>
		<tr>
			<td>Telepon</td>
			<td>'.$row["tlpn"].'</td>
		</tr>
		<tr>
			<td>Alamat</td>
			<td>'.$row["alamat"].'</td>
		</tr>
		<tr>
			<td>Status</td>
			<td>'.$status.'</td>
		</tr>
		';
	}
	$output .= '
		</table>
	</div>
	';
	echo $output;
}

/**
 * ========================
 * Display details
 * ========================
 */

function getGuruDetail($connect,$nip) {
	$query = "SELECT * FROM tb_guru WHERE nip = $nip";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '
	<div class="table-responsive">
		<table class="table table-boredered  table-striped">
	';
	foreach($result as $row)
	{
		$status = '';
		$jenis_kelamin = '';
		if($row['status'] == 'active'){
			$status = '<span class="label label-success">Active</span>';
		}else{
			$status = '<span class="label label-danger">Non Active</span>';
		}
		if ($row['jenis_kelamin'] == 1 ) {
			$jenis_kelamin = '<span>Laki-laki</span>';
		}else {
			$jenis_kelamin = '<span>Perempuan</span>';
		}
		$output .= '
		<tr>
			<td>NIP</td>
			<td>'.$row["nip"].'</td>
		</tr>
		<tr>
			<td>Nama</td>
			<td>'.$row["nama"].'</td>
		</tr>
		<tr>
			<td>Username</td>
			<td>'.$row["username"].'</td>
		</tr>
		<tr>
			<td>Tanggal Lahir</td>
			<td>'.$row["tgl_lahir"].'</td>
		</tr>
		<tr>
			<td>Telepon</td>
			<td>'.$row["tlpn"].'</td>
		</tr>
		<tr>
			<td>Jenis Kelamin</td>
			<td>'.$jenis_kelamin.'</td>
		</tr>
		<tr>
			<td>Alamat</td>
			<td>'.$row["alamat"].'</td>
		</tr>
		<tr>
			<td>Status</td>
			<td>'.$status.'</td>
		</tr>
		';
	}
	$output .= '
		</table>
	</div>
	';
	echo $output;
}
/**
 * Get konfirmasi pembayaran details
 * @param  object $connect      
 * @param  integer $id_pendaftaran
 * @return array
 */
function getKonfirmasiPembayaranDetails($connect,$id_pendaftaran) {
	$qp = "SELECT tb_pendaftaran.*, tb_ortu.nama FROM tb_pendaftaran LEFT JOIN tb_ortu on tb_ortu.id = tb_pendaftaran.id_ortu WHERE tb_pendaftaran.id= :id ";
	$dbsg = $connect->prepare($qp);
	$dbsg->execute(array(
		':id' => $id_pendaftaran
	));
	$galeriResult = $dbsg->fetchAll();

	$output = '
	<div class="table-responsive">
		<table class="table table-boredered  table-striped">
	';
	foreach($galeriResult as $row)
	{
		$status = '';
		$jenis_kelamin = '';
		$output .= '
		<tr>
			<td>Nama Orang Tua</td>
			<td>: '.$row["nama"].'</td>
		</tr>
		<tr>
			<td>Tanggal Daftar</td>
			<td>: '.$row["tgl_daftar"].'</td>
		</tr>
		<tr>
			<td>Jumlah Bayar</td>
			<td>: '.$row["jumlah_bayar"].'</td>
		</tr>
		<tr>
			<td>Metode Pembayaran</td>
			<td>: '.$row["cara_bayar"].'</td>
		</tr>
		';
	}
	$output .= '
		</table>
	</div>
	';
	$output .='
		<div class="row">
	';
	foreach ($galeriResult as $row) {
		$output .= '
			<div class="col-sm-12">
			    <div class="image img">
			      <img class="img img-responsive" src="../uploads/'.$row['foto'].'" alt="First slide">
			    </div>
			  </div>
		';
	}

	$output .= '
		</div>
	';

	echo $output;
}
