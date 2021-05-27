<?php

session_start();

	if(isset($_SESSION['id'])){
		header("location: accueil.php");
		exit();
	}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Trombinouc</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/trombinouc_icon.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body class="w3-light-grey">
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
				<form class="login100-form validate-form flex-sb flex-w" method="POST" action="accueil.php">
					<span class="login100-form-title p-b-32">
						S'identifiez-vous
					</span>
					
					<span class="txt2 p-b-20">
					<?php

						if (isset($_GET['erreur']) && $_GET['erreur']=='1'){
							echo "<p><strong>Login ou mot de passe incorrect. Veuillez recommencer.</strong></p>";
						}
						
						if (isset($_GET['erreur']) && $_GET['erreur']=='OK'){
							echo "<p><strong>Succès de l'inscription! Bienvenue à Trombinouc :D </strong></p>";
						}
						
						
					?>
					</span>
					
					
					
					<span class="txt1 p-b-11">
						Adresse e-mail
					</span>
					<div class="wrap-input100 validate-input m-b-36" data-validate = "Adresse e-mail est nécessaire">
						<input class="input100" type="email" name="ad_email" >
						<span class="focus-input100"></span>
					</div>
					
					<span class="txt1 p-b-11">
						Mot de passe
					</span>
					<div class="wrap-input100 validate-input m-b-12" data-validate = "Mot de passe est nécessaire">
						<span class="btn-show-pass">
							<i class="fa fa-eye"></i>
						</span>
						<input class="input100" type="password" for="mot_de_passe" id="mot_de_passe" name="mot_de_passe" >
						<span class="focus-input100"></span>
					</div>
					
					<div class="flex-sb-m w-full p-b-48">
						

						<div>
							<a href="resetpassword.php" class="txt3">
								Mot de passe oublié?
							</a>
							<a href="sinscrire.php" class="txt3">
								Pas encore membre?
							</a>
							<br>
							<a class="txt3">
								<?php
									
									if(!isset($_COOKIE['lastvisite'])){
										setcookie('lastvisite', date("H:i:s d-m-Y"), time() + (365*24*3600), "/");
										echo "Ceci est votre première visite. Bienvenue!";
									}
									else{
										echo "Votre dernière visite est ";
										echo "<b>{$_COOKIE['lastvisite']}</b>";
									}
									
								
								?>
								</a>
						</div>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Se connecter
						</button>
					</div>
					

				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>