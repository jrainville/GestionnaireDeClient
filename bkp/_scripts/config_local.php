<?php
setlocale (LC_TIME, 'fr_FR.utf8','fra');

session_start();

if(stristr($_SERVER['HTTP_HOST'],'localhost'))
{
	$db_host='localhost';
	$db_database='swann_bd';
	$db_username='root';
	$db_password='';
}


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