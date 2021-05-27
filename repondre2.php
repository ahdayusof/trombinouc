<?php
	
	session_start();
	
	include ('basedeprojet.php');
	
	$id = $_SESSION['id'];
	$mes_id = $_GET['mes_id'];
	$reponse = str_replace("'","\'",$_POST['reponse']);
	
	$sql = "INSERT INTO REPONSES (util_id, id_mes ,reponse) VALUES ('{$id}', '{$mes_id}', '{$reponse}')";

	$req = $bd->prepare($sql);
	$req->execute () or die(print_r($req->errorInfo()));
	$req->closeCursor();


	header ("Location: {$_GET['script']}.php?util_id={$_GET['util_id']}");
	exit();
		
?>	