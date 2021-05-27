<?php

	session_start();

	include ('basedeprojet.php');
	
	if(empty($_SESSION['id'])){
		
		header ('Location: index.php?erreur=1');
		exit();
		
	}
	
	$sql = "SELECT * FROM UTILISATEURS INNER JOIN ADRESSES ON adresses.util_id = utilisateurs.id WHERE id={$_GET['util_id']}";
	$req = $bd->prepare($sql);
	$req->execute ();
	$leProfil = $req->fetchall (); 
	$req->closeCursor();
	
	if($_SESSION['id']==$leProfil['0']['id']){
		header ('Location: profil.php');
		exit();
	}
	
	
	if($leProfil['0']['genre']=='Femme'){
		
		$genre="Elle";
	}
	else{
		$genre="Il";
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

	<header id="header" class="w3-container w3-center w3-padding-32">
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

			<div class="w3-col l8 s12">
				<!-- Blog entry -->
				<div class="w3-card-4 w3-margin w3-white" style="border-radius:10px">
				
					<div class="w3-container w3-padding-large w3-margin" >
					
						<h3 class="w3-center"><img class="w3-padding-small" src="images/profil_icon.png" style="width:16%">
						<br><b><?php echo "{$leProfil['0']['nom']} {$leProfil['0']['prenom']}";?></b></h3>
						
						<?php	
								
								$sql = "SELECT type FROM PERSON{$_SESSION['id']} WHERE ami_id={$leProfil['0']['id']}";
								$req = $bd->prepare($sql);
								$req->execute ();
								$leRel = $req->fetchall (); 
								$req->closeCursor();
								
								
								if($leRel['0']['type']==2){
									
									echo "<div class=\"w3-center\">";
									echo "<button class=\"w3-center\" style=\"border-radius:4px\" width=\"100%\"><a href=\"bloquer.php?util_id={$leProfil['0']['id']}&script=profil1\">Bloquer</a></button>";
									
									echo " ";
									
									echo "<button class=\"w3-center\" style=\"border-radius:4px\" width=\"100%\"><a href=\"sedesabonner.php?util_id={$leProfil['0']['id']}&script=profil1\">Se desabonner</a></button>";
									echo "</div>";

									
								}
								else if($leRel['0']['type']==1 ){
									
									echo "<div class=\"w3-center\">";
									echo "<button class=\"w3-center\" style=\"border-radius:4px\" width=\"100%\"><a href=\"bloquer.php?util_id={$leProfil['0']['id']}&script=profil1\">Bloquer</a></button>";
									
									echo " ";
									echo "<button class=\"w3-center\" style=\"border-radius:4px\" width=\"100%\"><a href=\"ajouter.php?util_id={$leProfil['0']['id']}&script=profil1\">Ajouter +</a></button>";
									echo "</div>";
									
								}
								else if($leRel['0']['type']==0 ){
									
									echo "<div class=\"w3-center\">";
									echo "<button class=\"w3-center\" style=\"border-radius:4px\" width=\"100%\"><a href=\"debloquer.php?util_id={$leProfil['0']['id']}&script=profil1\">Debloquer</a></button>";
									echo "</div>";
									
								}
								
						?>
						 
						<div class="w3-container w3-white">
						
						<h3><b>Intro<b></h3>
						<h4><img src="images/genre_icon.png" alt="genre" width="3%" height="3%"> <?php echo $leProfil['0']['genre'];?></h4>
						<h4><img src="images/accueil_icon.png" alt="rue" width="3%" height="3%"> <?php echo $leProfil['0']['rue'];?> <?php echo $leProfil['0']['ville'];?> <?php echo $leProfil['0']['code_postal'];?> <?php echo $leProfil['0']['pays'];?></h4>
						<h4><img src="images/profession_icon.png" alt="profession" width="3%" height="3%"> <?php echo $leProfil['0']['profession'];?></h4>						
						<h4><img src="images/contact_icon.png" alt="numero_mobile" width="3%" height="3%"> <?php echo $leProfil['0']['numero_mobile'];?></h4>
						<h4><img src="images/birthday_icon.png" alt="date_de_naiss" width="3%" height="3%"> <span style="color: grey"> Né(e) le </span><?php echo $leProfil['0']['date_de_naiss'];?></h4>
						
						
						
						<hr>
						
						</div>
						
						<div class="w3-container w3-white w3-margin">
						<h3><b>Photos<b></h3>
						
						<?php
													
							if($leRel['0']['type']==2 ){
								
								if($leProfil['0']['id']==1){
									echo "<img src=\"images/image3.jpg\" alt=\"elect1\" width=\"30%\" height=\"30%\">";
									echo "<img src=\"images/image4.jpg\" alt=\"elect2\" width=\"30%\" height=\"30%\">";
									}
								else{
									echo "<span style=\"color: grey\">{$genre} n'a pas de photos</span>";
								}
								
							}
							else if ($leRel['0']['type']==1 || $leRel['0']['type']==0){
								
								echo "<span style=\"color: grey\">Vous n'êtes pas autorisé(e) à voir les photos</span>";
								
								
								
							}
							else if ($leRel['0']['type']==3){
								
								echo "<span style=\"color: grey\">Vous avez été bloqué(e) par cet utilisateur</span>";
								
							}
							
						?>			
							  
						</div>
				
					</div>
					
				</div>
				
						
				<?php
				
				if($leRel['0']['type']==2){

						$sql = "SELECT id, num, nom, prenom, publication, date_publie FROM PUBLICATIONS INNER JOIN UTILISATEURS ON utilisateurs.id = publications.util_id WHERE id={$leProfil['0']['id']} ORDER BY date_publie";
							
							$req = $bd->prepare($sql);
							$req->execute () or die(print_r($req->errorInfo()));
							$lesPub = $req->fetchall (); 
							$req->closeCursor();
							
						$sql = "SELECT id, nom, prenom, message, aime, date_envoie FROM MESSAGES INNER JOIN UTILISATEURS ON utilisateurs.id = messages.util_id WHERE util_id={$leProfil['0']['id']}";
						
							$req = $bd->prepare($sql);
							$req->execute () or die(print_r($req->errorInfo()));
							$lesMes = $req->fetchall (); 
							$req->closeCursor();
							
							
																
						for ($row=count($lesPub)-1; $row>=0; $row--) {
							
							$sql = "SELECT id, nom, num, prenom, commentaire, date_comment  FROM COMMENTAIRES INNER JOIN UTILISATEURS ON utilisateurs.id = commentaires.util_id WHERE num_pub={$lesPub[$row]['num']} ORDER BY date_comment";
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
							echo "<h4><a href=\"profil.php?util_id={$lesPub[$row]['id']}\"><img alt=\"profil\" src=\"images/profil_icon.png\" width=\"7%\" height=\"7%\">&nbsp ";
							echo "{$lesPub[$row]['nom']} {$lesPub[$row]['prenom']}";
							echo "</a></h4>";
							echo "<p><span style=\"color: grey\"> a dit \" </span><span class=\"w3-xlarge\"><b>";
							echo $lesPub[$row]['publication'];
							echo "</b></span><span style=\"color: grey\"> \" le ";
							echo $lesPub[$row]['date_publie']; 
							echo "</p></span><hr>";
							echo "<p><span class=\"w3-left\"><b>Commentaires&nbsp&nbsp</b><span class=\"w3-tag\">";
							echo count($lesCom);
							echo "</span></span>";
							echo "<a href=\"aime.php?num_pub={$lesPub[$row]['num']}&util_id={$leProfil['0']['id']}&script=profil1\"><span class=\"w3-left\"><b>&nbsp&nbspAime&nbsp&nbsp</b><span class=\"w3-badge\">";
							echo count($Aimes);
							echo "</span></span></a>";
							
							if(count($Aimes)>0){
								
								echo "<span style=\"color: grey\">&nbsp aimé par ";
								for($row2=0; $row2<count($Aimes)-1; $row2++){
																		
									echo "<a href=\"profil1?util_id={$Aimes[$row2]['id']}\">{$Aimes[$row2]['nom']} {$Aimes[$row2]['prenom']}</a>, ";
								}
								
								echo "<a href=\"profil1?util_id={$Aimes[$row2]['id']}\">{$Aimes[$row2]['nom']} {$Aimes[$row2]['prenom']}</a></span>";
								
							}
							
							echo "</p>";
						   	echo "</div>";
							echo "<div class=\"w3-container\">";
							
							for ($row1=0; $row1<count($lesCom); $row1++) {
								
								
								echo "<p><a href=\"profil1.php?util_id={$lesCom[$row1]['id']}\"><b>";
								echo $lesCom[$row1]['nom'];
								echo " {$lesCom[$row1]['prenom']}";
								echo "</b></a><span style=\"color: grey\"> a commenté \" </span><b>";
								echo $lesCom[$row1]['commentaire'];
								echo "</b><span style=\"color: grey\"> \" le ";
								echo $lesCom[$row1]['date_comment'];

								if($_SESSION['id']==$lesCom[$row1]['id']){
									echo "<a href=\"delcom.php?util_id={$leProfil['0']['id']}&num={$lesCom[$row1]['num']}&script=profil1\">&nbsp&nbsp[&nbspsupprimer&nbsp&nbsp<img alt=\"profil\" src=\"images/delete_icon.png\" width=\"2%\" height=\"2%\">&nbsp]</a>";
								}
								
								echo "</span></p>";
																
							}
							
							echo "</div>";
							echo "<div class=\"w3-container\">";
							echo "<p><form method=\"POST\" action=\"comment2.php?num_pub={$lesPub[$row]['num']}&script=profil1&util_id={$leProfil['0']['id']}\">";
							echo "<textarea style=\"overflow:auto; resize:none; max-width:80%; border-radius: 5px; border: 1px solid #ccc; box-shadow: 1px 1px 1px #999;\" for=\"comment\" name=\"comment\" id= \"comment\" rows=\"1\" cols=\"120\" placeholder=\"Votre commentaire...\" ></textarea>";
							echo "<button class=\"w3-right w3-margin-bottom\" style=\"border-radius: 10px\" type=\"submit\" >Commenter</button>";
							echo "</form>";
							echo "</p></div>";
							
							echo "</div>";
						}
						
				}		

				?>
				
			</div>
			
			<div class="w3-col l4">
				<div class="w3-card w3-margin w3-margin-top" style="border-radius:10px">
					<h3><img class="w3-padding-large" src="images/amis_icon.png" width="25%">
						<b>Amis</b></h3>
						<div class="w3-container w3-white">
							
						
							<ul class="w3-ul w3-hoverable w3-white">
								  
							<?php
							
							if($leRel['0']['type']==2 ){
								$sql = "SELECT id, nom, prenom, type FROM PERSON{$leProfil['0']['id']} INNER JOIN UTILISATEURS ON utilisateurs.id = person{$leProfil['0']['id']}.ami_id WHERE type=2";
								$req = $bd->prepare($sql);
								$req->execute ();
								$lesAmis = $req->fetchall ();
								$req->closeCursor();
															
								
								if(count($lesAmis)!=0){
								
									echo "<h4 class=\"w3-margin\"><b>";
									echo count($lesAmis);
									echo "</b> ami(s)</h4>";
									
									for ($row=0; $row<count($lesAmis); $row++){
										
										if($lesAmis[$row]['id'] != $leProfil['0']['id']){
										
											echo "<a href=\"profil1.php?util_id={$lesAmis[$row]['id']}\">";
											echo "<li class=\"w3-margin\" style=\"border-radius:20px\">";
											echo "<img alt=\"profil\" src=\"images/profil_icon.png\" width=\"7%\" height=\"7%\">&nbsp ";
											echo " {$lesAmis[$row]['nom']}";
											echo " ";
											echo $lesAmis[$row]['prenom'];
											echo "<br>";
											echo "</li></a>";
											
										}
									}
									
								}
								else {
									
									echo "<h4>{$genre} n'a pas d'amis</h4>";
								}
							}
							
							?>
												
							</ul>
						</div>
				</div>
				
				<?php
				if($leRel['0']['type']==2 ){
				
					echo "<div class=\"w3-card-4 w3-margin w3-white w3-border\" style=\"border-radius:10px\">";
					echo "<section>";
					echo "<form method=\"POST\" action=\"publi4.php?util_id={$leProfil['0']['id']}\">";
					echo "<div class=\"w3-container w3-margin\">";
					echo "<h5><img alt=\"profil\" src=\"images/profil_icon.png\" width=\"7%\" height=\"7%\">&nbsp";
					echo "{$_SESSION['nom']} {$_SESSION['prenom']}</h5>";
					echo "<textarea style=\"overflow:auto; resize:none; max-width:100%; border-radius: 5px; border: 1px solid #ccc; box-shadow: 1px 1px 1px #999;\" for=\"message\" name=\"message\" id= \"message\" rows=\"4\" cols=\"120\" placeholder=\"Envoyer un message privé\" ></textarea>";
					echo "<button class=\"w3-right w3-margin-bottom\" style=\" border-radius: 10px\" type=\"submit\" >Envoyer</button>";
					echo "</div></form>";
					echo "</section>";
					echo "</div>";
				
				}
				?>
				
				
				<div class="w3-card w3-margin w3-margin-top" style="border-radius:10px">
					<h3><img class="w3-padding-large" src="images/message_icon.png" width="25%">
						<b>Messages</b></h3>
						<div class="w3-container w3-white">
						
						<?php
							
							
							if($leRel['0']['type']==2 ){
							
								$sql = "SELECT mes_id, id, nom, prenom, message, aime, date_envoie FROM MESSAGES INNER JOIN UTILISATEURS ON utilisateurs.id = messages.util_id WHERE ami_id={$leProfil['0']['id']} AND util_id={$_SESSION['id']} ORDER BY date_envoie";
								
									$req = $bd->prepare($sql);
									$req->execute () or die(print_r($req->errorInfo()));
									$lesMes = $req->fetchall (); 
									$req->closeCursor();
								
								if(count($lesMes)>0 && $_SESSION['id']==$lesMes['0']['id']){
									
									for($row=0; $row<count($lesMes); $row++){
									
										$sql = "SELECT id, nom, num, prenom, id_mes, reponse, date_rep FROM REPONSES INNER JOIN UTILISATEURS ON utilisateurs.id = reponses.util_id WHERE id_mes={$lesMes[$row]['mes_id']} ORDER BY date_rep";
									
											$req = $bd->prepare($sql);
											$req->execute () or die(print_r($req->errorInfo()));
											$lesRep = $req->fetchall (); 
											$req->closeCursor();
										
												
										
										echo "<div class=\"w3-container\">";
										echo "<h4><a href=\"profil.php?util_id={$lesMes[$row]['id']}\"><img alt=\"profil\" src=\"images/profil_icon.png\" width=\"7%\" height=\"7%\">&nbsp ";
										echo "{$lesMes[$row]['nom']} {$lesMes[$row]['prenom']}";
										echo "</a></h4>";
										echo "<p><span style=\"color: grey\"> a dit \" </span><span class=\"w3-xlarge\"><b>";
										echo $lesMes[$row]['message'];
										echo "</b></span><span style=\"color: grey\"> \" le ";
										echo $lesMes[$row]['date_envoie'];									
										echo "<a href=\"delmes.php?util_id={$leProfil['0']['id']}&mes_id={$lesMes[$row]['mes_id']}&script=profil1\">&nbsp&nbsp[&nbspsupprimer&nbsp&nbsp<img alt=\"profil\" src=\"images/delete_icon.png\" width=\"2%\" height=\"2%\">&nbsp]</a>";
								
										echo "</p></span>";
										
											
										echo "<hr><p><span class=\"w3-left\"><b>Reponses&nbsp&nbsp</b><span class=\"w3-tag\">";
										echo count($lesRep);
										echo "</span></span></p>";
										echo "</div>";
										echo "<div class=\"w3-container\">";	
										
											for ($row1=0; $row1<count($lesRep); $row1++) {
												
												
												echo "<p><a href=\"profil1.php?util_id={$lesRep[$row1]['id']}\"><b>";
												echo $lesRep[$row1]['nom'];
												echo " {$lesRep[$row1]['prenom']}";
												echo "</b></a><span style=\"color: grey\"> a repondu \" </span><b>";
												echo $lesRep[$row1]['reponse'];
												echo "</b><span style=\"color: grey\"> \" le ";
												echo $lesRep[$row1]['date_rep']; 
												
												if($_SESSION['id']==$lesRep[$row1]['id']){
										
													echo "<a href=\"delrep.php?util_id={$leProfil['0']['id']}&num={$lesRep[$row1]['num']}&script=profil1\">&nbsp&nbsp[&nbspsupprimer&nbsp&nbsp<img alt=\"profil\" src=\"images/delete_icon.png\" width=\"2%\" height=\"2%\">&nbsp]</a>";
												}
												
												echo "</span></p>";
												
												
											}
											
										echo "</div>";	
										echo "<div class=\"w3-container\">";
										echo "<p><form method=\"POST\" action=\"repondre2.php?mes_id={$lesMes[$row]['mes_id']}&util_id={$leProfil['0']['id']}&script=profil1\">";
										echo "<textarea style=\"overflow:auto; resize:none; max-width:70%; border-radius: 5px; border: 1px solid #ccc; box-shadow: 1px 1px 1px #999;\" for=\"reponse\" name=\"reponse\" id= \"reponse\" rows=\"2\" cols=\"120\" placeholder=\"Votre reponse...\" ></textarea>";
										echo "<button class=\"w3-right w3-margin-bottom\" style=\"border-radius: 10px\" type=\"submit\" >Repondre</button>";
										echo "</form>";
										echo "</p>";
										echo "</div>";
										
										echo "<hr style=\"border: 1px solid grey\">";
										
									}
								
										
								}
															
														
							}

						?>
							
						</div>
							
					</div>
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
		
		location.replace("profil.php")

	}
}
</script>

</body>
</html>