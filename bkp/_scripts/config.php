<?php
$db_host='localhost';
$db_database='centr295_gestionnaireContrats';
//centr295_gestionnaireContrats
$db_username='centr295_gestion';
//centr295_gestion 
$db_password='?p&TOpJX~q{y';
//?p&TOpJX~q{y

session_start();


$link = mysqli_connect($db_host, $db_username, $db_password);
if(!$link) 
{
	die('Impossible de se connecter au serveur: ' . mysqli_error($link));
}

//Select database
$db = mysqli_select_db($link,$db_database);

if(!$db) 
{
	die("Erreur dans la base de données. Veuillez réessayer plus tard.");
}

mysqli_set_charset($link,'utf8');
mysqli_query($link,'SET NAMES "utf8"');

?>