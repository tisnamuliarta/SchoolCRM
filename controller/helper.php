<?php 
include '../connection.php';
include 'function.php';

/**
 * =======================
 * Check is same
 * =====================
 */

if (isset($_POST['guruUsername'])) 
	checkUsername($connect,"tb_guru",$_POST['guruUsername']);

if (isset($_POST['tlpn']))
	checkTlpn($connect,"tb_guru",$_POST['tlpn']);

if (isset($_POST['nip']))
	checkNIP($connect,$_POST['nip']);

if (isset($_POST['email']))
	checkEmail($connect,"tb_ortu",$_POST['email']);

if (isset($_POST['id_ortu']))
	countSiswaTerdaftarByOrtu($connect,$_POST['id_ortu']);

if (isset($_POST['idTahunAjaran']))
	getDiscountByIdTahunAjaran($connect,$_POST['idTahunAjaran']);

/**
 * ===================
 * Helper function
 * ===================
 */

function getDiscountByIdTahunAjaran($connect,$idTahunAjaran) {
	$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$query = "SELECT tb_diskon.diskon FROM tb_diskon WHERE tb_diskon.tahun_ajaran = :tahun_ajaran";
	$statement = $connect->prepare($query);
	$statement->execute(array(
		':tahun_ajaran' => $idTahunAjaran
	));
	$result = $statement->fetch(PDO::FETCH_ASSOC);
	echo $result['diskon']; 
}

function countSiswaTerdaftarByOrtu($connect,$id_ortu) {
	$query = "SELECT count(*) as count_siswa FROM tb_siswa WHERE nis IS NOT NULL AND tb_siswa.id_ortu= :id_ortu";
	$statement = $connect->prepare($query);
	$statement->execute(array(
		':id_ortu' => $id_ortu
	));
	$count = $statement->fetchColumn();
	echo $count;
}




/**
 * =============================
 * Details data
 * =============================
 */
if (isset($_POST['btn_action'])) {
	if ($_POST['btn_action'] == 'user_details') {
		getUserDetail($connect,$_POST['user_id']);
	}
	if ($_POST['btn_action'] == 'galeriDetails') {
		getGaleriDetails($connect,$_POST['galeri_id']);
	}
	if ($_POST['btn_action'] == 'guruDetails') {
		getGuruDetail($connect,$_POST['guru_nip']);
	}
    if ($_POST['btn_action'] == 'nilaiPerkembanganSiswa') {
        getDetailNilaiSiswa($connect,$_POST['nis'],$_POST['kegiatan']);
    }
	if ($_POST['btn_action'] == 'data_konfirmasi_pendaftaran') {
		getKonfirmasiPembayaranDetails($connect,$_POST['pendaftaran_id']);
	}
	if ($_POST['btn_action'] == 'data_kk') {
		getDataKK($connect,$_POST['pendaftaran_id']);
	}
    if ($_POST['btn_action'] == 'data_kegiatan') {
//        getDataKegiatan($connect,$_POST['id_kelas']);
        $id_kelas =  $_POST['id_kelas'];
        $query = "SELECT *  FROM tb_kegiatan
		WHERE tb_kegiatan.id_kelas = :id_kelas
		ORDER BY tb_kegiatan.nama DESC ";
        $dbs = $connect->prepare($query);
        $dbs->execute(array(
            ':id_kelas' => $id_kelas
        ));
        $result = $dbs->fetchAll();
        $output = '';
        foreach ($result as $row) {
            $output .= '<option value="'.$row['id'].'" >'.$row['nama'].'</option>' ;
        }
        echo $output;
    }
}
