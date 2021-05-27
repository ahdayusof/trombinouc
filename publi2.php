<?php

	session_start();

	include ('basedeprojet.php');
	
	$publication = str_replace("'","\'",$_POST['publication']);
		
	$sql = "INSERT INTO PUBLICATIONS (util_id,publication) VALUES ('{$_SESSION['id']}', '{$publication}')";

	
	$req = $bd->prepare($sql);
	$req->execute () or die(print_r($req->errorInfo()));	
	$lesEnreg = $req->fetchall (); 
	$req->closeCursor();


	header ("Location: {$_GET['script']}.php");
	exit();
		
?>	