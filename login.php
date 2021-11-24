<?php

require_once 'database.php';
if($_POST){
    $pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT * FROM User where idQ = ?";
	$q = $pdo->prepare($sql);
	$q->execute(array($idQ));
	$data = $q->fetch(PDO::FETCH_ASSOC);
	$title = $data['qtitle'];
	$content = $data['qcontent'];

	Database::disconnect();
}

?>