<?php
	session_start();
	
	$_SESSION['user'] = null;
	
	if (isset($_COOKIE['gestionnaireUser'])) {
		unset($_COOKIE['gestionnaireUser']);
		setcookie('gestionnaireUser', null, -1);
	}
	
	header('location:login.php');
?>