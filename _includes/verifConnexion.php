<?php

	if(!$_SESSION['user']) {
		//On vérifie s'il le user est en cookie
		if (isset($_COOKIE['gestionnaireUser']) && $_COOKIE['gestionnaireUser'] != '') {
			$_SESSION['user'] = $_COOKIE['gestionnaireUser'];
		} else {
			header('location:login.php');
			exit();
		}
	}
	
?>