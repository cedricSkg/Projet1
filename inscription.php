<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Login V13</title>
	<meta charset="UTF-8">

	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/main2.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body style="background-color: #999999; margin:0; " onload="myFunction()">
<div id="loader">
    <div class="gradient-background">
    
      <div class="disc spin">
        <div class="disc-reflection-left">
        </div>
        <div class="disc-reflection-right">
        </div>
        <div class="disc-groove">
        </div>
        <div class="label "> 
          <div class="disc-font disc-title">
            Song's World
          </div>
          <div class="disc-font disc-group">
            Laoding...
          </div>
        </div>
      </div>
      <div class="tone-arm oscillating">
      </div>
  </div>
  </div>
  <div  id="myDiv" class="animate-bottom" style="display:none">
	<div class="limiter ">
		<div class="container-login100">
			
			<div class="login100-more" style="background-image: url('images/bg-01.png');"></div>
			<a href="accueil.php" class="icone">
				<i class="fa fa-home"></i>
			</a>
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="POST" action="">
                    
					<span class="login100-form-title">
						Inscription
					</span>

					<div class="wrap-input100 validate-input" data-validate="Nom requis">
						<span class="label-input100">Nom</span>
						<input class="input100" type="text" id="nom" name="nom" placeholder="Nom...">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Mail valide requis: ex@abc.xyz">
						<span class="label-input100">Email</span>
						<input class="input100" type="email" id="mail" name="mail" placeholder="Adresse email...">
						<span class="focus-input100"></span>
					</div>
                    <div class="wrap-input100 validate-input" data-validate = "Mail valide requis: ex@abc.xyz">
						<span class="label-input100">Repeter l'email</span>
						<input class="input100" type="email" id="mail2" name="mail2" placeholder="Retaper Adresse email...">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Nom d'utilisateur requis">
						<span class="label-input100">Nom d'utilisateur</span>
						<input class="input100" type="text" id="pseudo" name="pseudo" placeholder="Nom d'utilisateur...">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Mot de passe requis">
						<span class="label-input100">Mot de passe</span>
						<input class="input100" type="password" id="mdp" name="mdp" placeholder="*************">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Mot de passe repris requis">
						<span class="label-input100">Repeat Password</span>
						<input class="input100" type="password" id="mdp2" name="mdp2" placeholder="*************">
						<span class="focus-input100"></span>
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
                            <button class="login100-form-btn" name="forminscription" type="submit">
								Inscription
							</button>
						</div>

						<a href="connexion.php" class="dis-block txt3 hov1">
							Connexion
							<i class="fa fa-long-arrow-right"></i>
						</a>
					</div>
				</form>
				
			</div>
		</div>
	</div>
	<?php
	//payetc@3il.fr
        $bdd = new PDO('mysql:host=127.0.0.1;dbname=songs_world', 'root', '');
			if(isset($_POST['forminscription'])) {
			$pseudo = htmlspecialchars($_POST['pseudo']);
			$nom = htmlspecialchars($_POST['nom']);
			$mail = htmlspecialchars($_POST['mail']);
			$mail2 = htmlspecialchars($_POST['mail2']);
			$mdp = sha1($_POST['mdp']);
			$mdp2 = sha1($_POST['mdp2']);
			if(!empty($_POST['nom']) AND !empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])) {
				$pseudolength = strlen($pseudo);
				if($pseudolength <= 255) {
					if($mail == $mail2) {
						if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
						$reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail = ?");
						$reqmail->execute(array($mail));
						$mailexist = $reqmail->rowCount();
						if($mailexist == 0) {
							if($mdp == $mdp2) {
								$longueurKey = 15;
								$key = "";
								for($i=1;$i<$longueurKey;$i++) {
									$key .= mt_rand(0,9);
								}
								$insertmbr = $bdd->prepare("INSERT INTO membres(nom, pseudo, mail, motdepasse, confirmkey) VALUES(?, ?, ?, ?, ?)");
			
								$insertmbr->execute(array($nom, $pseudo, $mail, $mdp, $key));
								$erreur = "Votre compte a bien été créé !";
							} else {
								$erreur = "Vos mots de passes ne correspondent pas !";
							}
						} else {
							$erreur = "Adresse mail déjà utilisée !";
						}
						} else {
						$erreur = "Votre adresse mail n'est pas valide !";
						}
					} else {
						$erreur = "Vos adresses mail ne correspondent pas !";
					}
				} else {
					$erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
				}
			} else {
				$erreur = "Tous les champs doivent être complétés !";
			}
			}
	?>
    <div class="reponse" style="z-index:1;">
        <?php
        	if(isset($erreur)) {
				if ($erreur!="Votre compte a bien été créé !") {
					echo '<font color="red">'.$erreur."</font>";
				}else {
					echo '<font color="green">'.$erreur."</font>";
				}
        	 }
        ?>
    </div>
</div>
	<script>
  var myVar;
  
  function myFunction() {
    myVar = setTimeout(showPage, 3000);
  }
  
  function showPage() {
    document.getElementById("loader").style.display = "none";
    document.getElementById("myDiv").style.display = "block";
  }
  </script>
</body>
</html>