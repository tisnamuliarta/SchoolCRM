<?php 

include '../connection.php';

$query = "SELECT * FROM tb_ortu where tlpn = :tlpn";
$statement = $connect->prepare($query);
$statement->execute([
	':tlpn' => $_POST['tlpn']
]);
$count = $statement->rowCount();
if ($count > 0) {
	$result = $statement->fetchAll();
	foreach ($result as $row) {
		if ($row['tlpn'] == $_POST['tlpn']) {
			echo "Nomer telepon sudah digunakan!";
		}
	}
}
