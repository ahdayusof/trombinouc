<?php

session_start();

include ('pays.php');


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
				<form class="login100-form validate-form flex-sb flex-w" method="POST" action="modifier2.php">
					<span class="login100-form-title p-b-32">
						Modifiez votre profil
					</span>
					
					<span class="txt2 p-b-20">
					<?php

						if (isset($_GET['erreur']) && $_GET['erreur']=='1'){
							echo "<strong>Votre mot de passe est incorrect. Veuillez recommencer.</strong>";
						}
						
										
					?>
					</span>
					<hr>
					
					<span class="txt1 p-b-11">
						Nom
					</span>
					<div class="wrap-input100 validate-input m-b-36" data-validate = "Nom est nécessaire">
						<input class="input100" type="text" name="nom" maxlength="50" value="<?php echo $_SESSION['nom']; ?>" placeholder="<?php echo $_SESSION['nom']; ?>">
						<span class="focus-input100"></span>
					</div>
					
					<span class="txt1 p-b-11">
						Prenom
					</span>
					<div class="wrap-input100 validate-input m-b-36" data-validate = "Prènom est nécessaire">
						<input class="input100" type="text" name="prenom" maxlength="50" value="<?php echo $_SESSION['prenom']; ?>" placeholder="<?php echo $_SESSION['prenom']; ?>">
						<span class="focus-input100"></span>
					</div>
					
					<span class="txt1 p-b-11">
						Adresse e-mail
					</span>
					<div class="wrap-input100 validate-input m-b-36" data-validate = "Adresse e-mail est nécessaire">
						<input class="input100" type="email" name="ad_email" maxlength="100" value="<?php echo $_SESSION['ad_email']; ?>" placeholder="<?php echo $_SESSION['ad_email']; ?>">
						<span class="focus-input100"></span>
					</div>
					
					<span class="txt1 p-b-11">
						Mot de passe
					</span>
					<div class="wrap-input100 validate-input m-b-36" data-validate = "Mot de passe est nécessaire">
						<span class="btn-show-pass">
							<i class="fa fa-eye"></i>
						</span>
						<input class="input100" type="password" name="mot_de_passe" maxlength="25">
						<span class="focus-input100"></span>
					</div>
					
					<span class="txt1 p-b-11">
						Nouveau mot de passe
					</span>
					<div class="wrap-input100 m-b-36">
						<span class="btn-show-pass">
							<i class="fa fa-eye"></i>
						</span>
						<input class="input100" type="password" name="nmot_de_passe" maxlength="25">
						<span class="focus-input100"></span>
					</div>
					
							
					
					<span class="txt1 p-b-11">
						Genre
					</span>
					<div class="wrap-input100 validate-input m-b-36" data-validate = "Genre est nécessaire">
						<select class="input100" name="genre" id="genre" value="<?php echo $_SESSION['genre']; ?>">
							
							<option value="<?php echo $_SESSION['genre']; ?>"><?php echo $_SESSION['genre']; ?></option>
							
							<?php
							
							if($_SESSION['genre']='Femme'){
								
								echo "<option value=\"Homme\">Homme</option>";
							}
							else{
								echo "<option value=\"Femme\">Femme</option>";
							}
							
							?>
							
						</select> 
						
					</div>
					
					<span class="txt1 p-b-11">
						Rue
					</span>
					<div class="wrap-input100 validate-input m-b-36" data-validate ="Rue est nécessaire">
						<input class="input100" type="text" name="rue" maxlength="30" value="<?php echo $_SESSION['rue']; ?>" placeholder="<?php echo $_SESSION['rue']; ?>">
						<span class="focus-input100"></span>
					</div>
					
					<span class="txt1 p-b-11">
						Ville
					</span>
					<div class="wrap-input100 validate-input m-b-36" data-validate = "Ville est nécessaire">
						<input class="input100" type="text" name="ville" maxlength="30" value="<?php echo $_SESSION['ville']; ?>" placeholder="<?php echo $_SESSION['ville']; ?>">
						<span class="focus-input100"></span>
					</div>
					
					<span class="txt1 p-b-11">
						Code postal
					</span>
					<div class="wrap-input100 validate-input m-b-36" data-validate = "Code postal est nécessaire">
						<input class="input100" type="text" name="code_postal" maxlength="10" value="<?php echo $_SESSION['code_postal']; ?>" placeholder="<?php echo $_SESSION['code_postal']; ?>">
						<span class="focus-input100"></span>
					</div>
					
					<span class="txt1 p-b-11">
						Pays
					</span>
					<div class="wrap-input100 validate-input m-b-36" data-validate = "Pays est nécessaire">
						<select class="input100" name="pays" id="pays" value="<?php echo $_SESSION['pays']; ?>">
							
							<option value="<?php echo $_SESSION['pays']; ?>"><?php echo $_SESSION['pays']; ?></option>
							
							<?php
								
								foreach ($pays as $cle => $val) {
									
									echo "<option value=\"{$cle}\">{$val}</option>";
									
								}
								
							
							?>
							
						</select> 
					</div>
					
					<span class="txt1 p-b-11">
						Profession
					</span>
					<div class="wrap-input100 validate-input m-b-36" data-validate = "Profession est nécessaire">
						<input class="input100" type="text" name="profession" maxlength="100" value="<?php echo $_SESSION['profession']; ?>" placeholder="<?php echo $_SESSION['profession']; ?>">
						<span class="focus-input100"></span>
					</div>
					
					<span class="txt1 p-b-11">
						Numéro de portable
					</span>
					<div class="wrap-input100 validate-input m-b-36" data-validate = "Numéro de portable est nécessaire">
						<input class="input100" type="number" name="numero_mobile" maxlength="10" value="<?php echo $_SESSION['numero_mobile']; ?>" placeholder="<?php echo $_SESSION['numero_mobile']; ?>">
						<span class="focus-input100"></span>
					</div>
					
					<span class="txt1 p-b-11">
						Date de naissance
					</span>
					<div class="wrap-input100 validate-input m-b-12" data-validate = "Date de naissance est nécessaire">
						<input class="input100" type="date" name="date_de_naiss" value="<?php echo $_SESSION['date_de_naiss']; ?>" placeholder="<?php echo $_SESSION['date_de_naiss']; ?>">
						<span class="focus-input100"></span>
					</div>
					<div class="flex-sb-m w-full p-b-48">
						

						<div>
							<a href="resetpassword.php" class="txt3">
								Mot de passe <b>oublié?</b>
							</a>
							<a href="profil.php" class="txt3">
								<b>Annuler </b>la modification
							</a>
						</div>
					</div>
					
					<br>
					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn">
							Modifier
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
	<script src="js/password.js"></script>
	


</body>
</html>