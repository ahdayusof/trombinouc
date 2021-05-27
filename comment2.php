<?php
	
	session_start();
	
	include ('basedeprojet.php');
		
	$id = $_SESSION['id'];
	$num_pub = $_GET['num_pub'];
	$commentaire = str_replace("'","\'",$_POST['comment']);
	
	$sql = "INSERT INTO COMMENTAIRES (util_id,num_pub,commentaire) VALUES ('{$id}', '{$num_pub}', '{$commentaire}')";

	$req = $bd->prepare($sql);
	$req->execute () or die(print_r($req->errorInfo()));
	$req->closeCursor();

	if(empty($_GET['util_id'])){
		
		header ("Location: {$_GET['script']}.php");
		exit();
	}
	else {
		
		header ("Location: {$_GET['script']}.php?util_id={$_GET['util_id']}");
		exit();
	}
		
?>	