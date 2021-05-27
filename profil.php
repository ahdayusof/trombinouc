<?php

session_start();

include ('basedeprojet.php');

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
						<br><b><?php echo "{$_SESSION['nom']} {$_SESSION['prenom']}";?></b></h3>
						
						<div class="w3-center">
						<?php

						if (isset($_GET['erreur']) && $_GET['erreur']=='OK'){
							echo "<span style=\"color: grey\">Votre profil est mis à jour</span>";
						}
						
						
						?>
						</div>
						
						<div class="w3-container w3-white">
						
						<h3><b>Intro<b></h3>
						<h4><img src="images/genre_icon.png" alt="genre" width="3%" height="3%"> <?php echo $_SESSION['genre'];?></h4>
						<h4><img src="images/accueil_icon.png" alt="rue" width="3%" height="3%"> <?php echo $_SESSION['rue'];?> <?php echo $_SESSION['ville'];?> <?php echo $_SESSION['code_postal'];?> <?php echo $_SESSION['pays'];?></h4>
						<h4><img src="images/profession_icon.png" alt="profession" width="3%" height="3%"> <?php echo $_SESSION['profession'];?></h4>						
						<h4><img src="images/contact_icon.png" alt="numero_mobile" width="3%" height="3%"> <?php echo $_SESSION['numero_mobile'];?></h4>
						<h4><img src="images/birthday_icon.png" alt="date_de_naiss" width="3%" height="3%"> <span style="color: grey"> Né(e) le </span><?php echo $_SESSION['date_de_naiss'];?></h4>
						
						
						<div class="w3-center">
						<button class="w3-center" style="border-radius:4px" width="100%"><a href="modifier.php">Modifier les infos</a></button>
						</div>
						<hr>
						
						</div>
						
						<div class="w3-container w3-white w3-margin">
						<h3><b>Photos<b></h3>
						
							<?php 
							
								if($_SESSION['id']==1){
									
									echo "<img src=\"images/image3.jpg\" alt=\"elect1\" width=\"30%\" height=\"30%\">";
									echo "<img src=\"images/image4.jpg\" alt=\"elect2\" width=\"30%\" height=\"30%\">";
								}
								else
									echo "<span style=\"color: grey\">Vous n'avez pas de photos à montrer</span>";
								
							?>
							  
						</div>
				
					</div>
					
				</div>
				
				<div class="w3-card-4 w3-margin w3-white w3-border" style="border-radius:10px">
					
					<!-- Nouvelle publication -->
					<div class="w3-container">
						<section>
							
							<form method="POST" action="publi2.php?script=profil">
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

						$sql = "SELECT id, num, nom, prenom, publication, date_publie FROM PUBLICATIONS INNER JOIN UTILISATEURS ON utilisateurs.id = publications.util_id WHERE id={$_SESSION['id']} ORDER BY date_publie";
						
						$req = $bd->prepare($sql);
						$req->execute () or die(print_r($req->errorInfo()));
						$lesPub = $req->fetchall (); 
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
							echo "<h4><a href=\"profil1.php?util_id={$lesPub[$row]['id']}\"><img alt=\"profil\" src=\"images/profil_icon.png\" width=\"7%\" height=\"7%\">&nbsp ";
							echo "{$lesPub[$row]['nom']} {$lesPub[$row]['prenom']}";
							echo "</a></h4>";
							echo "<p><span style=\"color: grey\"> a dit \" </span><span class=\"w3-xlarge\"><b>";
							echo $lesPub[$row]['publication'];
							echo "</b></span><span style=\"color: grey\"> \" le ";
							echo $lesPub[$row]['date_publie'];
							
							if($_SESSION['id']==$lesPub[$row]['id']){
								echo "<a href=\"delpub.php?util_id={$lesPub[$row]['id']}&num_pub={$lesPub[$row]['num']}&script=profil\">&nbsp&nbsp[&nbspsupprimer&nbsp&nbsp<img alt=\"profil\" src=\"images/delete_icon.png\" width=\"2%\" height=\"2%\">&nbsp]</a>";
							}
							
							echo "</p></span><hr>";
							echo "<p><span class=\"w3-left\"><b>Commentaires&nbsp&nbsp</b><span class=\"w3-tag\">";
							echo count($lesCom);
							echo "</span></span>";
							echo "<a href=\"aime.php?num_pub={$lesPub[$row]['num']}&script=profil\"><span class=\"w3-left\"><b>&nbsp&nbspAime&nbsp&nbsp</b><span class=\"w3-badge\">";
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
								
								
								echo "<p><a href=\"profil1.php?util_id={$lesCom[$row1]['id']}\"><b>";
								echo $lesCom[$row1]['nom'];
								echo " {$lesCom[$row1]['prenom']}";
								echo "</b></a><span style=\"color: grey\"> a commenté \" </span><b>";
								echo $lesCom[$row1]['commentaire'];
								echo "</b><span style=\"color: grey\"> \" le ";
								echo $lesCom[$row1]['date_comment'];

								if($_SESSION['id']==$lesCom[$row1]['id']){
									echo "<a href=\"delcom.php?util_id={$lesCom[$row1]['id']}&num={$lesCom[$row1]['num']}&script=profil\">&nbsp&nbsp[&nbspsupprimer&nbsp&nbsp<img alt=\"profil\" src=\"images/delete_icon.png\" width=\"2%\" height=\"2%\">&nbsp]</a>";
								}
								
								echo "</span></p>";
								
								
							}
							
							echo "</div>";
							echo "<div class=\"w3-container\">";
							echo "<p><form method=\"POST\" action=\"comment2.php?num_pub={$lesPub[$row]['num']}&script=profil1&util_id={$_SESSION['id']}\">";
							echo "<textarea style=\"overflow:auto; resize:none; max-width:80%; border-radius: 5px; border: 1px solid #ccc; box-shadow: 1px 1px 1px #999;\" for=\"comment\" name=\"comment\" id= \"comment\" rows=\"1\" cols=\"120\" placeholder=\"Votre commentaire...\" ></textarea>";
							echo "<button class=\"w3-right w3-margin-bottom\" style=\"border-radius: 10px\" type=\"submit\" >Commenter</button>";
							echo "</form></p></div>";
							
							
							echo "</div>";
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
							
							$sql = "SELECT id, nom, prenom, type FROM PERSON{$_SESSION['id']} INNER JOIN UTILISATEURS ON utilisateurs.id = person{$_SESSION['id']}.ami_id WHERE type=2";
							$req = $bd->prepare($sql);
							$req->execute ();
							$lesAmis = $req->fetchall ();
							$req->closeCursor();
							
							
							if(count($lesAmis)!=0){
							
								echo "<h4 class=\"w3-margin\"><b>";
								echo count($lesAmis);
								echo "</b> ami(s)</h4>";
								
								for ($row=0; $row<count($lesAmis); $row++){
									
									
									
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
							else {
								
								echo "<h4>Vous n'avez pas d'amis</h4>";
							}
							
							
							?>
												
							</ul>
						</div>
				</div>
				
				<div class="w3-card w3-margin w3-margin-top" style="border-radius:10px">
					<h3><img class="w3-padding-large" src="images/message_icon.png" width="25%">
						<b>Messages</b></h3>
						<div class="w3-container w3-white">
						
						<?php
							
							$sql = "SELECT mes_id, id, nom, prenom, message, aime, date_envoie FROM MESSAGES INNER JOIN UTILISATEURS ON utilisateurs.id = messages.util_id WHERE ami_id={$_SESSION['id']} ORDER BY date_envoie";
							
								$req = $bd->prepare($sql);
								$req->execute () or die(print_r($req->errorInfo()));
								$lesMes = $req->fetchall (); 
								$req->closeCursor();
								
							if(count($lesMes)==0){
								
								echo "<h4>Vous n'avez pas de messages</h4>";
							}
							
							for ($row=count($lesMes)-1; $row>=0; $row--) {
								
								$sql = "SELECT id, nom, num, prenom, reponse, date_rep FROM REPONSES INNER JOIN UTILISATEURS ON utilisateurs.id = reponses.util_id WHERE id_mes={$lesMes[$row]['mes_id']} ORDER BY date_rep";
							
									$req = $bd->prepare($sql);
									$req->execute () or die(print_r($req->errorInfo()));
									$lesRep = $req->fetchall (); 
									$req->closeCursor();
								
										
								
								echo "<div class=\"w3-container\">";
								echo "<h4><a href=\"profil1.php?util_id={$lesMes[$row]['id']}\"><img alt=\"profil\" src=\"images/profil_icon.png\" width=\"7%\" height=\"7%\">&nbsp ";
								echo "{$lesMes[$row]['nom']} {$lesMes[$row]['prenom']}";
								echo "</a></h4>";
								echo "<p><span style=\"color: grey\"> a dit \" </span><span class=\"w3-xlarge\"><b>";
								echo $lesMes[$row]['message'];
								echo "</b></span><span style=\"color: grey\"> \" le ";
								echo $lesMes[$row]['date_envoie']; 
								echo "</p></span><hr>";
								echo "<p><span class=\"w3-left\"><b>Reponses&nbsp&nbsp</b><span class=\"w3-tag\">";
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
										
										echo "<a href=\"delrep.php?util_id={$lesRep[$row1]['id']}&num={$lesRep[$row1]['num']}&script=profil\">&nbsp&nbsp[&nbspsupprimer&nbsp&nbsp<img alt=\"profil\" src=\"images/delete_icon.png\" width=\"2%\" height=\"2%\">&nbsp]</a>";
									}
									
									echo "</span></p>";
									
								}
								
								echo "</div>";
								echo "<div class=\"w3-container\">";
								echo "<p><form method=\"POST\" action=\"repondre2.php?mes_id={$lesMes[$row]['mes_id']}&script=profil1&util_id={$_SESSION['id']}\">";
								echo "<textarea style=\"overflow:auto; resize:none; max-width:70%; border-radius: 5px; border: 1px solid #ccc; box-shadow: 1px 1px 1px #999;\" for=\"reponse\" name=\"reponse\" id= \"reponse\" rows=\"2\" cols=\"120\" placeholder=\"Votre reponse...\" ></textarea>";
								echo "<button class=\"w3-right w3-margin-bottom\" style=\"border-radius: 10px;\" type=\"submit\" >Repondre</button>";
								echo "</form>";
								echo "</p></div>";
								echo "<hr style=\"border: 1px solid grey\">";
								
								
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
