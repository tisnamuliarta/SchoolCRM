<?php 
// process login
$message = "";
if (isset($_POST['login'])) {
	echo $connect;
}


function generatePassword($key)
{
	return password_hash($key, PASSWORD_DEFAULT);
}

function createGuru($connect)
{
	$sql = "
	INSERT INTO tb_guru (nip,nama,username,password,alamat,tgl_lahir,jenis_kelamin,tlpn,status)
	VALUES('1782928282','Wayan Adi','admin','".password_hash('admin',PASSWORD_DEFAULT)."','DPS','2017-01-10','1','0282882','active')
	";
	return $connect->prepare($sql)->execute();
}

function createOrtu($connect)
{
	$sql = "
		INSERT INTO tb_ortu (nama,username,password,tgl_lahir,alamat,jenis_kelamin,tlpn,status)
		VALUES('Adi','adi','".password_hash('admin',PASSWORD_DEFAULT)."','1985-01-01','DPS','1','92822','active')
	";
	return $connect->prepare($sql)->execute();
}

function createUser($connect)
{
	$query = "
	INSERT INTO tb_user (username, password, status, nip, ortu_id,login_status) 
	VALUES('admin','".password_hash('admin',PASSWORD_DEFAULT)."','admin','1234',null,'active')";
	return $connect->prepare($query)->execute();
}