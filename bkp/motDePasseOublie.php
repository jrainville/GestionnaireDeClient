<?php
	require_once('_scripts/config.php');
	include_once('_scripts/functions.php');
	
	$erreurs = [];
	
	// ÉTAPE 1: on reçoit le username ddu user pour lui envoyer par email son code
	if (isset($_POST['sendMail'])) {
		$username = $_POST['username'];
		
		if ($username == '') {
			$erreurs['username'] = 'Nom d\'usager vide';
		} else {
			$SQL = "SELECT email, user_id
				FROM users
				WHERE username = '$username'";
				
			$req = mysqli_query($link, $SQL);
			if (mysqli_num_rows($req) > 0) {
				$enr = mysqli_fetch_assoc($req);
				$code = generateRandomString(20);
				$user_id = $enr['user_id'];
				
				$SQL = "UPDATE users
					SET code = '$code'
					WHERE user_id = '$user_id'";
					
				mysqli_query($link, $SQL);
				
				$link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]?confirmationCode&user_id=$user_id&code=$code";
				
				$email = $enr['email'];
				$message = "<p>Voici comment changer votre mot de passe.</p>
					<p>Copiez le code de confirmation suivant dans la boîte de dialogue présente sur le site</p>
					<p>Code: $code</p>
					<p>Ou bien, cliquez sur ce lien: <a href=\"$link\">$link</a></p>
					<p>Veuillez ne pas répondre à ce message</p>";
					
				$subject = 'Récupération de mot de passe';
				
				$to = 'rainville.jonathan@gmail.com';
				
				$from = "NE PAS RÉPONDRE <rainville.jonathan@gmail.com>";
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
				$headers .= "From:". $from . "\r\n";
				mail($to, $subject, $message, $headers);
				
				$message_sent = true;
			} else {
				$erreurs['username'] = 'Mauvais nom d\'usager';
			}
		}
	}

	if (isset($_POST['confirmationCode']) || isset($_GET['confirmationCode'])) {
		if (isset($_POST['confirmationCode'])) {
			$user_id = $_POST['user_id'];
			$code = $_POST['code'];
		} else {
			$user_id = $_GET['user_id'];
			$code = $_GET['code'];
		}
		
		$codeEnvoye = true;
		
		$SQL = "SELECT code, username
				FROM users
				WHERE user_id = '$user_id'";
				
		$req = mysqli_query($link, $SQL);
		
		$enr = mysqli_fetch_assoc($req);
		
		$username = $enr['username'];
		$codeVoulu = $enr['code'];
		
		if ($code != $codeVoulu) {
			$erreurs['code'] = 'Mauvais code fourni.';
		} else {
			$codeConfirme = true;
		}
	}
	
	if (isset($_POST['changerMotDePasse'])) {
		$changementMdp = true;
		$user_id = $_POST['user_id'];
		$newPassword = $_POST['new_password'];
		$newPasswordAgain = $_POST['new_password_again'];
		
		$erreurs = [];
		
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
			$newPassword = hashPW($newPassword);
			
			$SQL = "UPDATE users
				SET password = '$newPassword'
				WHERE user_id = '$user_id'";
				
			$result = mysqli_query($link, $SQL);
			$changementMdp = false;
		}
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mot de passe oublié</title>
<?php
	include_once('_includes/linksEtScripts.inc.php');
?>

</head>

<body>

<div class="container">
    
    <div class="content">
    	<h1>Mot de passe oublié</h1>
		
		
		<?php 
			if(isset($result)) {
				echo '<p>';
				if ($result) {
					echo 'Changement de mot de passe réussi.</p>';
					echo '<p><a href="login.php">Appuyer ici pour retourner à la connexion</a>';
				}else {
					echo 'Le changement a échoué, veuillez réessayer plus tard.';
				}
				echo '</p>';
			}
		?>
		
		
		<?php 
		
		if ($message_sent || ($codeEnvoye && !$codeConfirme)) { ?>
			
			<?php if ($message_sent) { ?><p>Message envoyé à <?php echo $email ?>.</p><?php } ?>
			<form action="" method="post">
				<p class="renvoiCode">Pour renvoyer le code de confirmation, appuyez <input type="submit" value="ici">.</p>
				<input type="hidden" name="sendMail">
				<input type="hidden" name="username" value="<?php echo $username; ?>">
			</form>
			<form class="connexionForm" action="" method="post">
				<div class="field text">
					<label for="code">Code de confirmation</label>
					<input type="text" id="code"  name="code">
					<?php 
						if(isset($erreurs['code'])){
							echo '<p class="erreur">'.$erreurs['code'].'</p>';
						}
					?>
				</div>
				<div class="field submit">
					<input type="submit" class="btn" value="Envoyer">
				</div>
				<input type="hidden" name="confirmationCode">
				<input type="hidden" name="user_id" value="<?php echo $user_id ?>">
			</form>
			
		<?php } else if ($codeConfirme || $changementMdp) { ?>

			<form class="connexionForm" action="" method="post">
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
				<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
			</form>

		<?php } else if (!$result) { ?>
		
			<form class="connexionForm" action="" method="post">
				<div class="field text">
					<label for="username">Nom d'utilisateur</label>
					<input type="text" id="username"  name="username">
					<?php 
						if(isset($erreurs['username'])){
							echo '<p class="erreur">'.$erreurs['username'].'</p>';
						}
					?>
				</div>
				<div class="field submit">
					<input type="submit" class="btn" value="Envoyer">
				</div>
				<input type="hidden" name="sendMail">
			</form>
		
		<? } ?>
    </div><!--Content-->
</div>

</body>
</html>