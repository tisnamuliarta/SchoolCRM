<?php 

include '../connection.php';

$query = "SELECT * FROM tb_ortu where username = :username";
$statement = $connect->prepare($query);
$statement->execute([
	':username' => $_POST['username']
]);
$count = $statement->rowCount();
if ($count > 0) {
	$result = $statement->fetchAll();
	foreach ($result as $row) {
		if ($row['username'] == $_POST['username']) {
			echo "Username tidak boleh sama!";
		}
	}
}
