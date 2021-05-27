<?php
	
	session_start();
	
	include ('basedeprojet.php');
	
	$sql = "SELECT * FROM UTILISATEURS WHERE ad_email=:ad_email AND mot_de_passe=:mot_de_passe";
	$req = $bd->prepare($sql);
	$marqueurs = array('ad_email'=>$_SESSION['ad_email'], 'mot_de_passe'=>$_POST['mot_de_passe']);
	$req->execute ($marqueurs) or die(print_r($req->errorInfo()));	
	$login = $req->fetchall (); 
	$req->closeCursor();
	
	
	if(count($login)==0){
		header ('Location:modifier.php?erreur=1');
		exit();
	}
	
	
	$nom = $_POST['nom'];
	$prenom = $_POST['prenom'];
	$ad_email = $_POST['ad_email'];
	
	if(!empty($_POST['nmot_de_passe'])){
		$mot_de_passe = $_POST['nmot_de_passe'];
	}
	else{
		$mot_de_passe = $_POST['mot_de_passe'];
	}
	
	
	$genre = $_POST['genre'];	
	$rue = $_POST['rue'];
	$ville = $_POST['ville'];
	$code_postal = $_POST['code_postal'];
	$pays = $_POST['pays'];
	$profession = $_POST['profession'];
	$numero_mobile = $_POST['numero_mobile'];
	$date_de_naiss = $_POST['date_de_naiss'];
	
	$sql = "UPDATE UTILISATEURS SET nom='{$nom}', prenom='{$prenom}', ad_email='{$ad_email}', mot_de_passe='{$mot_de_passe}', genre='{$genre}', 
			profession = '{$profession}', numero_mobile='{$numero_mobile}', date_de_naiss='{$date_de_naiss}' WHERE id={$_SESSION['id']}";
	
	$req = $bd->prepare($sql);
	$req->execute() or die(print_r($req->errorInfo()));	
	$req->closeCursor();
	
	$sql = "UPDATE ADRESSES SET rue='{$rue}', ville='{$ville}', code_postal='{$code_postal}', pays='{$pays}' WHERE util_id={$_SESSION['id']}";
	
	$req = $bd->prepare($sql);
	$req->execute() or die(print_r($req->errorInfo()));
	$req->closeCursor();
	
	$sql = "SELECT * FROM UTILISATEURS INNER JOIN ADRESSES ON adresses.util_id=utilisateurs.id WHERE id=:id";
		$req = $bd->prepare($sql);
		$marqueurs = array('id'=>$_SESSION['id']);
		$req->execute ($marqueurs) or die(print_r($req->errorInfo()));	
		$lesEnreg = $req->fetchall (); 
		$req->closeCursor();
		
			
	$_SESSION['nom']=$lesEnreg['0']['nom'];
	$_SESSION['prenom']=$lesEnreg['0']['prenom'];
	$_SESSION['ad_email']=$lesEnreg['0']['ad_email'];
	$_SESSION['genre']=$lesEnreg['0']['genre'];
	$_SESSION['rue']=$lesEnreg['0']['rue'];
	$_SESSION['ville']=$lesEnreg['0']['ville'];
	$_SESSION['code_postal']=$lesEnreg['0']['code_postal'];
	$_SESSION['pays']=$lesEnreg['0']['pays'];
	$_SESSION['profession']=$lesEnreg['0']['profession'];
	$_SESSION['numero_mobile']=$lesEnreg['0']['numero_mobile'];
	$_SESSION['date_de_naiss']=$lesEnreg['0']['date_de_naiss'];


	header ('Location:profil.php?erreur=OK');
	exit();
		
?>