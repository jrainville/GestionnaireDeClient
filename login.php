<?php
	include_once('_scripts/config.php');
	include_once('_scripts/functions.php');
	
	if (isset($_SESSION['user'])) {
		header('location:index.php');
		exit();
	}
	
	if (isset($_POST['connexion'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$rememberMe = $_POST['rememberMe'];
		
		$erreurs = [];
		
		if($username == '') {
			$erreurs['username'] = 'Le nom d\'utilisateur est nécessaire';
		}
		
		if($password == '') {
			$erreurs['password'] = 'Le mot de passe est nécessaire';
		}
		
		if (count($erreurs) == 0) {
			$password = hashPW($password);
			
			$SQL = "SELECT user_id
				FROM users
				WHERE username='$username' AND password='$password'";
				
			$req = mysqli_query($link,$SQL);
			
			if (mysqli_num_rows($req) == 0) {
				$erreurs['password'] = 'Mauvais nom d\'utilisateur et/ou mot de passe';
			}else{
				$enr = mysqli_fetch_assoc($req);
				$_SESSION['user'] = $enr['user_id'];
				if ($rememberMe) {
					setcookie('gestionnaireUser', $enr['user_id'], time() + (86400 * 30)); // 86400 = 1 day
				}
				
				header('location:index.php');
				exit();
			}
		}
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Connexion</title>
<?php
	include_once('_includes/linksEtScripts.inc.php');
?>

</head>

<body>

<div class="container">
    
    <div class="content">
    	<h1>Connexion</h1>
        
		<p>Vous devez vous connecter afin d'accéder au site.</p>
		
		<form class="connexionForm" action="" method="post">
			<div class="field text">
				<label for="username">Nom d'usager</label>
				<input type="text" id="username"  name="username" <?php 
				if(isset($username)) { 
					echo 'value="'.$username.'"'; 
				} 
				?>>
				<?php 
					if(isset($erreurs['username'])){
						echo '<p class="erreur">'.$erreurs['username'].'</p>';
					}
				?>
			</div>
			<div class="field text">
				<label for="password">Mot de passe</label>
				<input type="password" id="password"  name="password">
				<?php 
					if(isset($erreurs['password'])){
						echo '<p class="erreur">'.$erreurs['password'].'</p>';
					}
				?>
			</div>
			<div class="field checkbox">
				<label for="rememberMe">Se souvenir de moi</label>
				<input type="checkbox" id="rememberMe" name="rememberMe" <?php 
				if(isset($rememberMe)) { 
					echo 'selected'; 
				} 
				?>>
			</div>
			<p class="motPasseOublie"><a href="motDePasseOublie.php">Mot de passe oublié?</a></p>
			<div class="field submit">
				<input type="submit" class="btn" value="Envoyer">
			</div>
			<input type="hidden" name="connexion">
		</form>
    </div><!--Content-->

</div>

</body>
</html>