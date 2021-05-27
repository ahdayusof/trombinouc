<?php

	session_start();

	include ('basedeprojet.php');
	
	$message = str_replace("'","\'",$_POST['message']);
		
	$sql = "INSERT INTO MESSAGES (util_id,ami_id,message) VALUES ({$_SESSION['id']}, {$_GET['util_id']}, '{$message}')";

	
	$req = $bd->prepare($sql);
	$req->execute () or die(print_r($req->errorInfo()));
	$req->closeCursor();


	header ("Location: profil1.php?util_id={$_GET['util_id']}");
	exit();
		
?>	