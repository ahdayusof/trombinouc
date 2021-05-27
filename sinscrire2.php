<?php

	include ('basedeprojet.php');
	
	$sql = "SELECT * FROM UTILISATEURS WHERE ad_email=:ad_email";
	$req = $bd->prepare($sql);
	$marqueurs = array('ad_email'=>$_POST['ad_email']);
	$req->execute ($marqueurs) or die(print_r($req->errorInfo()));	
	$login = $req->fetchall (); 
	$req->closeCursor();
	
	if(count($login)!=0){
		
		header ('Location:sinscrire.php?erreur=1');
		exit();
	}
		
	$sql = "INSERT INTO UTILISATEURS (nom,prenom,ad_email,mot_de_passe,genre,profession,numero_mobile,date_de_naiss) 
			VALUES ('{$_POST['nom']}', '{$_POST['prenom']}', '{$_POST['ad_email']}', '{$_POST['mot_de_passe']}', '{$_POST['genre']}', '{$_POST['profession']}', '{$_POST['numero_mobile']}', '{$_POST['date_de_naiss']}')";


		$req = $bd->prepare($sql);
		$req->execute() or die(print_r($req->errorInfo()));
		$req->closeCursor();
		
	$sql = "SELECT * FROM UTILISATEURS WHERE ad_email=:ad_email";
		
		$req = $bd->prepare($sql);
		$marqueurs = array('ad_email'=>$_POST['ad_email']);
		$req->execute ($marqueurs) or die(print_r($req->errorInfo()));	
		$lesEnreg = $req->fetchall (); 
		$req->closeCursor();
		
			
	$sql = "INSERT INTO ADRESSES (util_id, rue,ville,code_postal,pays) 
			VALUES ('{$lesEnreg['0']['id']}', '{$_POST['rue']}', '{$_POST['ville']}', '{$_POST['code_postal']}', '{$_POST['pays']}')";

		$req = $bd->prepare($sql);
		$req->execute() or die(print_r($req->errorInfo()));
		$req->closeCursor();
	
	$sql = "CREATE TABLE `person{$lesEnreg['0']['id']}` ( `ami_id` INT NOT NULL , `type` INT DEFAULT '1' , INDEX (`ami_id`)) ENGINE = INNODB;;";
	
		$req = $bd->prepare($sql);
		$req->execute() or die(print_r($req->errorInfo()));
		$req->closeCursor();
		
	$sql = "ALTER TABLE `person{$lesEnreg['0']['id']}` ADD FOREIGN KEY (`ami_id`) REFERENCES `utilisateurs`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;";
		
		$req = $bd->prepare($sql);
		$req->execute() or die(print_r($req->errorInfo()));
		$req->closeCursor();
		
	$sql = "SELECT id FROM UTILISATEURS WHERE id!={$lesEnreg['0']['id']}";
	
		$req = $bd->prepare($sql);
		$marqueurs = array('ad_email'=>$_POST['ad_email']);
		$req->execute ($marqueurs) or die(print_r($req->errorInfo()));	
		$lesUti = $req->fetchall (); 
		$req->closeCursor();
	
		
	for($row=0; $row<count($lesUti); $row++){
		
		$sql = "INSERT INTO `person{$lesEnreg['0']['id']}` (ami_id) VALUES ({$lesUti[$row]['id']})";
		
			$req = $bd->prepare($sql);
			$req->execute() or die(print_r($req->errorInfo()));
			$req->closeCursor();
		
	}
	
	for($row=0; $row<count($lesUti); $row++){
		
		$sql = "INSERT INTO person{$lesUti[$row]['id']} (ami_id) VALUES ({$lesEnreg['0']['id']})";
		
			$req = $bd->prepare($sql);
			$req->execute() or die(print_r($req->errorInfo()));
			$req->closeCursor();
		
	}
	
	
	header ('Location: index.php?erreur=OK');
	exit();
	
		
?>	