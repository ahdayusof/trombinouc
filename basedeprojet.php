<?php 
	
	
	try {
		$bd = new PDO ( "mysql:host=localhost;dbname=trombinouc",
		 "root", "" ); 
		$bd->exec('SET NAMES utf8');
	}


	catch (PDOException $e) {
		die ("Erreur: Connexion impossible");
	}


?>
