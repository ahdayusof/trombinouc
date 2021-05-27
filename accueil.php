<?php

session_start();

include ('basedeprojet.php');

	 
	if(!empty($_POST)){

		$sql = "SELECT * FROM UTILISATEURS INNER JOIN ADRESSES ON adresses.util_id=utilisateurs.id WHERE ad_email=:ad_email AND mot_de_passe =:mot_de_passe";
		$req = $bd->prepare($sql);
		$marqueurs = array('ad_email'=>$_POST['ad_email'], 'mot_de_passe'=>$_POST['mot_de_passe']);
		$req->execute ($marqueurs) or die(print_r($req->errorInfo()));	
		$login = $req->fetchall (); 
		$req->closeCursor();
		
		
		
			if(count($login)=='0'){
				header ('Location: index.php?erreur=1');
				exit();
			}
			
			else if($login['0']['ad_email']==$_POST['ad_email'] && $login['0']['mot_de_passe']==$_POST['mot_de_passe'] && count($login)==1){
				
				$_SESSION['id']=$login['0']['id'];
				$_SESSION['nom']=$login['0']['nom'];
				$_SESSION['prenom']=$login['0']['prenom'];
				$_SESSION['ad_email']=$login['0']['ad_email'];
				$_SESSION['genre']=$login['0']['genre'];
				$_SESSION['rue']=$login['0']['rue'];
				$_SESSION['ville']=$login['0']['ville'];
				$_SESSION['code_postal']=$login['0']['code_postal'];
				$_SESSION['pays']=$login['0']['pays'];
				$_SESSION['profession']=$login['0']['profession'];
				$_SESSION['numero_mobile']=$login['0']['numero_mobile'];
				$_SESSION['date_de_naiss']=$login['0']['date_de_naiss'];
				$_SESSION['date_cree']=$login['0']['date_cree'];
				
				$cookie_name = 'lastvisite';
				$cookie_value = date("H:i:s d-m-Y");
				setcookie($cookie_name, $cookie_value, time() + (365*24*3600), "/");
				
										
			}
		
			
	}
	
	if(empty($_SESSION['id'])){
		
		header ('Location: index.php?erreur=1');
		exit();
		
	}
	
	

?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Trombinouc</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/trombinouc_icon.png"/>
	<link rel="stylesheet" href="styles/w3.css">
	<link rel="stylesheet" href="styles/navbar.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">

</head>

<body class="w3-light-grey">

	<header id="header" class="w3-center w3-padding-32">
	<a href="accueil.php"><h1><img alt="trombinouc" src="images/trombinouc_icon.png" width="10%" height="10%"><a href="accueil.php"><b>rombinouc</b></h1></a>
	</header>

	<div id="navbar" class="w3-center w3-padding-small">
	  <a href="accueil.php"><img alt="accueil" src="images/accueil_icon.png" width="6%" height="6%"></a> 
	  <a href="amis.php"><img alt="amis" src="images/amis_icon.png" width="6%" height="6%"></a> 
	  <a href="profil.php"><img alt="profil" src="images/profil_icon.png" width="6%" height="6%"></a>
	  <a onclick="sedeconnecter()"><img alt="sedeconnecter" src="images/sedeconnecter_icon.png" width="6%" height="6%"></a>
	</div>
	

	<div class="w3-content content" style="max-width:1400px">

		<!-- Grid -->
		<div class="w3-row">
			
			<!-- Blog entries -->
			<div class="w3-col l8 s12">
			
				<!-- Blog entry -->
				<div class="w3-card-4 w3-margin w3-white w3-border" style="border-radius:10px">
					
					<!-- Nouvelle publication -->
					<div class="w3-container">
						<section>
							
							<form method="POST" action="publi2.php?script=accueil">
								<div class="w3-container w3-margin">
								<h3><img alt="profil" src="images/profil_icon.png" width="7%" height="7%">&nbsp <?php echo "{$_SESSION['nom']} {$_SESSION['prenom']}";?></h3>
								<textarea style="overflow:auto; resize:none; max-width:100%; border-radius: 5px; border: 1px solid #ccc; box-shadow: 1px 1px 1px #999;" for="publication" name="publication" id= "publication" rows="5" cols="120" placeholder="Que voulez-vous dire?" ></textarea>
								<button class="w3-right w3-margin-bottom" style="border-radius: 10px" type="submit" >Publier</button> 
								</div>
							</form>
						</section>
					
					</div>
				
				</div>
	
					
					<?php

						$sql = "SELECT id, num, nom, prenom, publication, date_publie FROM PUBLICATIONS INNER JOIN UTILISATEURS ON utilisateurs.id = publications.util_id WHERE id={$_SESSION['id']}
								UNION 
								SELECT id, num, nom, prenom, publication, date_publie FROM PUBLICATIONS INNER JOIN UTILISATEURS ON utilisateurs.id = publications.util_id 
										INNER JOIN person{$_SESSION['id']} ON utilisateurs.id = person{$_SESSION['id']}.ami_id WHERE type=2
								ORDER BY date_publie";
						$req = $bd->prepare($sql);
						$req->execute () or die(print_r($req->errorInfo()));
						$lesPub = $req->fetchall (); 
						$req->closeCursor();
										
						
						
						for ($row=count($lesPub)-1; $row>=0; $row--) {
							
							$sql = "SELECT id, num, nom, prenom, commentaire, date_comment  FROM COMMENTAIRES INNER JOIN UTILISATEURS ON utilisateurs.id = commentaires.util_id WHERE num_pub={$lesPub[$row]['num']} ORDER BY date_comment";
							$req = $bd->prepare($sql);
							$req->execute ();
							$lesCom = $req->fetchall (); 
							$req->closeCursor();
							
							$sql = "SELECT id, nom, prenom FROM AIMES INNER JOIN UTILISATEURS ON utilisateurs.id = aimes.par_qui WHERE num_pub = {$lesPub[$row]['num']} ";
							$req = $bd->prepare($sql);
							$req->execute () or die(print_r($req->errorInfo()));
							$Aimes = $req->fetchall (); 
							$req->closeCursor();
													
									
							echo "<div class=\"w3-card-4 w3-margin w3-white\" style=\"border-radius:10px\">";
							echo "<div class=\"w3-container\">";
							echo "<h4><a href=\"profil1.php?util_id={$lesPub[$row]['id']}\"><img alt=\"profil\" src=\"images/profil_icon.png\" width=\"7%\" height=\"7%\">&nbsp ";
							echo "{$lesPub[$row]['nom']} {$lesPub[$row]['prenom']}";
							echo "</a>";
							echo "</h4>";
							echo "<p><span style=\"color: grey\"> a dit \" </span><span class=\"w3-xlarge\"><b>";
							echo $lesPub[$row]['publication'];
							echo "</b></span><span style=\"color: grey\"> \" le ";
							echo $lesPub[$row]['date_publie'];
							
							if($_SESSION['id']==$lesPub[$row]['id']){
								echo "<a href=\"delpub.php?util_id={$lesPub[$row]['id']}&num_pub={$lesPub[$row]['num']}&script=accueil\">&nbsp&nbsp[&nbspsupprimer&nbsp&nbsp<img alt=\"profil\" src=\"images/delete_icon.png\" width=\"2%\" height=\"2%\">&nbsp]</a>";
							}
							
							echo "</p></span>";
							echo "<hr>";
							echo "<p><span class=\"w3-left\"><b>Commentaires&nbsp&nbsp</b><span class=\"w3-tag\">";
							echo count($lesCom);
							echo "</span></span>";
							echo "<a href=\"aime.php?num_pub={$lesPub[$row]['num']}&script=accueil\"><span class=\"w3-left\"><b>&nbsp&nbspAime&nbsp&nbsp</b><span class=\"w3-badge\">";
							echo count($Aimes);
							echo "</span></span></a>";
							
							if(count($Aimes)>0){
								echo "&nbsp aimé par ";
								for($row2=0; $row2<count($Aimes)-1; $row2++){
																		
									echo "<a href=\"profil1?util_id={$Aimes[$row2]['id']}\">{$Aimes[$row2]['nom']} {$Aimes[$row2]['prenom']}</a>, ";
								}
								
								echo "<a href=\"profil1?util_id={$Aimes[$row2]['id']}\">{$Aimes[$row2]['nom']} {$Aimes[$row2]['prenom']}</a>";
								
							}
							
							echo "</p>";							
							echo "</div>";
							echo "<div class=\"w3-container\">";
							
							for ($row1=0; $row1<count($lesCom); $row1++) {
								
								
								echo "<p><b>";
								echo $lesCom[$row1]['nom'];
								echo " {$lesCom[$row1]['prenom']}";
								echo "</b><span style=\"color: grey\"> a commenté \" </span><b>";
								echo $lesCom[$row1]['commentaire'];
								echo "</b><span style=\"color: grey\"> \" le ";
								echo $lesCom[$row1]['date_comment'];

								if($_SESSION['id']==$lesCom[$row1]['id']){
									echo "<a href=\"delcom.php?util_id={$lesCom[$row1]['id']}&num={$lesCom[$row1]['num']}&script=accueil\">&nbsp&nbsp[&nbspsupprimer&nbsp&nbsp<img alt=\"profil\" src=\"images/delete_icon.png\" width=\"2%\" height=\"2%\">&nbsp]</a>";
								}
								
								echo "</span></p>";
								
								
							}
							
							echo "</div>";
							echo "<div class=\"w3-container\">";
							echo "<p><form method=\"POST\" action=\"comment2.php?num_pub={$lesPub[$row]['num']}&script=accueil\">";
							echo "<textarea style=\"overflow:auto; resize:none; max-width:80%; border-radius: 5px; border: 1px solid #ccc; box-shadow: 1px 1px 1px #999;\" for=\"comment\" name=\"comment\" id= \"comment\" rows=\"1\" cols=\"120\" placeholder=\"Votre commentaire...\" ></textarea>";
							echo "<button class=\"w3-right w3-margin-bottom\" style=\"border-radius: 10px\" type=\"submit\" >Commenter</button>";
							echo "</form>";
							echo "</p></div>";
							
							echo "</div>";
						}
						
						

						?>  
					
				</div>
				
				<!-- Introduction menu -->
				<div class="w3-col l4">
				
					<!-- About Card -->
					<div class="w3-card w3-margin w3-margin-top" style="border-radius:10px">
						<h3><img class="w3-padding-small" src="images/profil_icon.png" style="width:16%">
						<b>Votre profil</b></h3>
						<div class="w3-container w3-white">
						
							<p>Bonjour <b><?php echo "{$_SESSION['nom']} {$_SESSION['prenom']}";?></b>
							<br> 
							
							<?php 
								
								if(isset($_COOKIE)){
									echo "Votre dernière visite est ";
									echo "<b>{$_COOKIE['lastvisite']}</b>";
								}
								else{
									echo "Ceci est votre première visite. Bienvenue!";
								}
								
							?>
							
							
							</p>
							  
						</div>
					</div>
					  
					<!-- Posts -->
					<div class="w3-card w3-margin w3-margin-top" style="border-radius:10px">
						<h3><img class="w3-padding-small" src="images/gift_icon.png" style="width:20%">
						<b>Anniversaires</b></h3>
						<div class="w3-container w3-white">
							
						
							<ul class="w3-ul w3-hoverable w3-white">
								  
							<?php
							
							$date_auj = date("m-d");
														
							$sql = "SELECT id, nom, prenom, date_de_naiss FROM PERSON{$_SESSION['id']} INNER JOIN UTILISATEURS ON utilisateurs.id = person{$_SESSION['id']}.ami_id WHERE type=2";
							$req = $bd->prepare($sql);
							$req->execute ();
							$lesAnn = $req->fetchall (); 
							$req->closeCursor();
							
							$va = substr($_SESSION['date_de_naiss'], 5);
							
							if($va == $date_auj){
								
								
								echo "<div class=\"w3-container w3-white w3-center w3-margin\">";
								echo "<h3>Aujourd'hui est votre anniversaire!!</h3>";
								echo "<img alt=\"anniversaire\" src=\"images/anniversaire.gif\" width=\"30%\" height=\"30%\">";								
								echo "</div>";
								
								$var = true;
								
							}
							
							for ($row=0; $row<count($lesAnn); $row++) {
								
								$ddn = $lesAnn[$row]['date_de_naiss'] ;
								
								$ddn = substr($lesAnn[$row]['date_de_naiss'], 5);
																
								if($ddn == $date_auj){
									
																										
									echo "<a href=\"profil1.php?util_id={$lesAnn[$row]['id']}\">";
									echo "<li class=\"w3-margin\">";
									echo "<img alt=\"profil\" src=\"images/profil_icon.png\" width=\"7%\" height=\"7%\">";
									echo $lesAnn[$row]['nom'];
									echo " ";
									echo $lesAnn[$row]['prenom'];
									echo "<br>";
									echo "</li></a>";
									
									$var = true;
									
								}
								
							}
							
							if (!isset($var)){
								
								echo "<div class=\"w3-container w3-white\">";
								echo "<p><span style=\"color: grey\">Personne ne fête son anniversaire aujourd'hui</span></p>";
								echo "</div>";
							}
									
							
							?>
												
							</ul>
						</div>
					</div>
							 
				<!-- END Introduction Menu -->
				</div>
				
			</div>
				
		</div>
		
	</div>

<script>
window.onscroll = function() {myFunction()};

var navbar = document.getElementById("navbar");
var sticky = navbar.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}

function sedeconnecter() {
	 if ( confirm( "Etes-vous sûr de vous déconnecter?" ) ) {		
		location.replace("sedeconnecter.php")
		
	} else {
		
		location.replace("accueil.php")

	}
}


</script>

</body>
</html>