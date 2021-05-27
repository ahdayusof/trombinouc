<?php

	session_start();

	include ('basedeprojet.php');
	

	$sql = "DELETE FROM MESSAGES WHERE mes_id={$_GET['mes_id']}";

	$req = $bd->prepare($sql);
	$req->execute () or die(print_r($req->errorInfo()));
	$req->closeCursor();


	header ("Location: {$_GET['script']}.php?util_id={$_GET['util_id']}");
	exit();

?>