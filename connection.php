<?php 

$connect = new PDO('mysql:host=127.0.0.1;dbname=db_crm','root','');
session_start();
	
// try {
// 	$connect = new PDO('mysql:host=127.0.0.1;dbname=db_crm','root','',[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
// 	session_start();
// } catch (PDOException $e) {
// 	echo $e->getMessage();
// }

?>