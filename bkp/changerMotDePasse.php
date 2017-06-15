<?php
	include_once('_scripts/config.php');
	include_once('_scripts/functions.php');
	include_once('_includes/verifConnexion.php');
	
	if (isset($_POST['changerMotDePasse'])) {
		$oldPassword = $_POST['old_password'];
		$newPassword = $_POST['new_password'];
		$newPasswordAgain = $_POST['new_password_again'];
		
		$erreurs = [];
		
		if($oldPassword == '') {
			$erreurs['old_password'] = 'L\'ancien mot de passe est nécessaire';
		}
		
		if($newPassword == '') {
			$erreurs['new_password'] = 'Le nouveau mot de passe est nécessaire';
		}
		
		if($newPasswordAgain == '') {
			$erreurs['new_password_again'] = 'Vous devez répeter le nouveau mot de passe';
		}
		
		if($newPasswordAgain != $newPassword) {
			$erreurs['newPasswordAgain'] = 'Vous devez répeter le nouveau mot de passe de façon exacte';
		}
		
		if (count($erreurs) == 0) {
			$user_id = $_SESSION['user'];
			$oldPassword = hashPW($oldPassword);
			
			$SQL = "SELECT user_id
				FROM users
				WHERE user_id = '$user_id' AND password = '$oldPassword'";
			
			$req = mysqli_query($link, $SQL);
			
			if (mysqli_num_rows($req) == 0) {
				$erreurs['old_password'] = 'Vous avez entré le mauvais mot de passe';
			}else{
				$newPassword = hashPW($newPassword);
				
				$SQL = "UPDATE users
					SET password = '$newPassword'
					WHERE user_id = '$user_id'";
					
				$result = mysqli_query($link, $SQL);
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

	<?php
        include_once('_includes/header.inc.php');
    ?>
    
    <div class="content">
    	<h1>Changement de mot de passe</h1>
		
		<?php 
			if(isset($result)) {
				echo '<p>';
				if ($result) {
					echo 'Changement de mot de passe réussi.</p>';
					echo '<p><a href="index.php">Appuyer ici pour retourner à l\'accueil</a>';
				}else {
					echo 'Le changement a échoué, veuillez réessayer plus tard.';
				}
				echo '</p>';
			}
		?>
		
		<form class="connexionForm" action="" method="post">
			<div class="field text">
				<label for="old_password">Ancien mot de passe</label>
				<input type="password" id="old_password"  name="old_password">
				<?php 
					if(isset($erreurs['old_password'])){
						echo '<p class="erreur">'.$erreurs['old_password'].'</p>';
					}
				?>
			</div>
			<div class="field text">
				<label for="new_password">Nouveau mot de passe</label>
				<input type="password" id="new_password"  name="new_password">
				<?php 
					if(isset($erreurs['new_password'])){
						echo '<p class="erreur">'.$erreurs['new_password'].'</p>';
					}
				?>
			</div>
			<div class="field text">
				<label for="new_password_again">Répeter le nouveau mot de passe</label>
				<input type="password" id="new_password_again"  name="new_password_again">
				<?php 
					if(isset($erreurs['new_password_again'])){
						echo '<p class="erreur">'.$erreurs['new_password_again'].'</p>';
					}
				?>
			</div>
			<div class="field submit">
				<input type="submit" class="btn" value="Envoyer">
			</div>
			<input type="hidden" name="changerMotDePasse">
		</form>
		
		<form class="connexionForm changerEmail" action="" method="post">
			<div class="field text">
				<label for="email">Adresse courriel</label>
				<input type="text" id="email"  name="email" value="<?php echo $email; ?>">
				<?php 
					if(isset($erreurs['email'])){
						echo '<p class="erreur">'.$erreurs['email'].'</p>';
					}
				?>
			</div>
			
			<div class="field submit">
				<input type="submit" class="btn" value="Envoyer">
			</div>
			<input type="hidden" name="chnagerEmail">
		</form>
    </div><!--Content-->

	<?php
		include('_includes/footer.inc.php');
	?>
</div>

</body>
</html>