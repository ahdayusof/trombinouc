<?php
	
	session_start();
	
	include ('basedeprojet.php');
	
	/*
	0-bloquer
	1-pas d'amis
	2-ami
	
	*/
	
	$sql = "UPDATE PERSON{$_SESSION['id']} SET type=2 WHERE ami_id={$_GET['util_id']}";
		$req = $bd->prepare($sql);
		$req->execute (); 
		$req->closeCursor();
	
	$sql = "UPDATE PERSON{$_GET['util_id']} SET type=2 WHERE ami_id={$_SESSION['id']}";
		$req = $bd->prepare($sql);
		$req->execute (); 
		$req->closeCursor();
	
	header("location: {$_GET['script']}.php?util_id={$_GET['util_id']}");
	exit();
		
	
?>