<?php

	session_start();

	include ('basedeprojet.php');
	
	$sql = "SELECT * FROM AIMES ";

	$req = $bd->prepare($sql);
	$req->execute () or die(print_r($req->errorInfo()));	
	$lesEnreg = $req->fetchall (); 
	$req->closeCursor();
	
	
	for($row=0; $row<count($lesEnreg) ; $row++){
		
		if($lesEnreg[$row]['num_pub']==$_GET['num_pub'] && $lesEnreg[$row]['par_qui']==$_SESSION['id']){
			
				$sql = "DELETE FROM AIMES WHERE num_pub={$_GET['num_pub']} AND par_qui={$_SESSION['id']}";

				$req = $bd->prepare($sql);
				$req->execute () or die(print_r($req->errorInfo()));
				$req->closeCursor();
				
				if(!empty($_GET['util_id'])){
		
					header ("location: {$_GET['script']}.php?util_id={$_GET['util_id']}");
					exit();
				}
				else{
					
					header ("location: {$_GET['script']}.php");
					exit();
					
				}
				
				
		}
		

	}
	
	
	$sql = "INSERT INTO AIMES (num_pub,par_qui) VALUES ({$_GET['num_pub']}, {$_SESSION['id']})";

	$req = $bd->prepare($sql);
	$req->execute () or die(print_r($req->errorInfo()));
	$req->closeCursor();
		
	if(!empty($_GET['util_id'])){
		
		header ("location: {$_GET['script']}.php?util_id={$_GET['util_id']}");
		exit();
	}
	else{
		
		header ("location: {$_GET['script']}.php");
		exit();
		
	}
		
?>	