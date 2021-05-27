<?php

	session_start();

	include ('basedeprojet.php');
	
	if(empty($_SESSION['id'])){
		
		header ('Location: index.php?erreur=1');
		exit();
		
	}
	
	$sql = "SELECT * FROM UTILISATEURS INNER JOIN ADRESSE ON adresse.util_id = utilisateurs.id WHERE id!={$_SESSION['id']}";
	$req = $bd->prepare($sql);
	$req->execute ();
	$lesAmis = $req->fetchall (); 
	$req->closeCursor();

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

			<div class="w3-col" style="border-radius:10px">
				<!-- Blog entry -->
				<div class="w3-card-4 w3-margin w3-white" style="border-radius:10px">
				
					<div class="w3-container w3-padding-large w3-margin" >
					
						<h3><b>Les membres<b></h3>
						
						<?php	
								
								$sql = "SELECT id, nom, prenom, type FROM PERSON{$_SESSION['id']} INNER JOIN UTILISATEURS ON utilisateurs.id = person{$_SESSION['id']}.ami_id ORDER BY nom";
								$req = $bd->prepare($sql);
								$req->execute ();
								$lesAmis = $req->fetchall (); 
								$req->closeCursor();
								
															
								for ($row=0; $row<count($lesAmis); $row++){
									
									
									
										echo "<a href=\"profil1.php?util_id={$lesAmis[$row]['id']}\">";
										echo "<li class=\"w3-margin\" style=\"border-radius:20px\">";
										echo "<img alt=\"profil\" src=\"images/profil_icon.png\" width=\"7%\" height=\"7%\">";
										echo " {$lesAmis[$row]['nom']}";
										echo " ";
										echo $lesAmis[$row]['prenom'];
										
										
										
										if($lesAmis[$row]['type']==2){
										
											echo "<div class=\"w3-right\">";
											echo "<button class=\"w3-center\" style=\"border-radius:4px\" width=\"100%\"><a href=\"bloquer.php?util_id={$lesAmis[$row]['id']}&script=amis\">Bloquer</a></button>";
											echo " ";
									
											echo "<button class=\"w3-center\" style=\"border-radius:4px\" width=\"100%\"><a href=\"sedesabonner.php?util_id={$lesAmis[$row]['id']}&script=amis\">Se desabonner</a></button>";
											echo "</div>";
										
										}
										else if($lesAmis[$row]['type']==1 ){
											
											echo "<div class=\"w3-right\">";
											echo "<button class=\"w3-center\" style=\"border-radius:4px\" width=\"100%\"><a href=\"bloquer.php?util_id={$lesAmis[$row]['id']}&script=amis\">Bloquer</a></button>";
											
											echo " ";
											echo "<button class=\"w3-center\" style=\"border-radius:4px\" width=\"100%\"><a href=\"ajouter.php?util_id={$lesAmis[$row]['id']}&script=amis\">Ajouter +</a></button>";
											echo "</div>";
										
										}
										else if($lesAmis[$row]['type']==0 ){
											
											echo "<div class=\"w3-right\">";
											echo "<button class=\"w3-center\" style=\"border-radius:4px\" width=\"100%\"><a href=\"debloquer.php?util_id={$lesAmis[$row]['id']}&script=amis\">Debloquer</a></button>";
											echo "</div>";
										
										}
										
										
										echo "<br>";
										echo "</li></a>";
									
																		
								}
								
								
						?>
						

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
		
		location.replace("amis.php")

	}
}
</script>

</body>
</html>