<?php
	include_once('_scripts/config.php');
	include_once('_includes/verifConnexion.php');
	
	if(isset($_GET['supprimer'])){
		$modePaiement_id=$_GET['supprimer'];
		
		$SQL="DELETE FROM modesPaiements 
			WHERE modePaiement_id = '$modePaiement_id'";
		mysqli_query($link, $SQL) or die(mysqli_error($link));
		
		header('location:ajouterModePaiement.php');
		exit();
	}
	
	if(isset($_POST['ajouterMode'])){
		$nouveauMode=$_POST['nouveauMode'];
		
		if($nouveauMode==''){
			$erreurMode='N\'oubliez pas d\'écrire le mode de paiement';
		}
		
		if(!isset($erreurMode)){
			$SQL="INSERT INTO modesPaiements (modePaiement)
				VALUES ('$nouveauMode')";
			mysqli_query($link, $SQL) or die(mysqli_error($link));
			
			$resultatAjout='L\'ajout du mode de paiement : '.$nouveauMode.' ; s\'est fait avec succès';
		}
	}
	
	$SQL = "SELECT modePaiement_id, modePaiement FROM modesPaiements";
	
	$req=mysqli_query($link,$SQL);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Ajouter un mode de paiement</title>
<?php
	include_once('_includes/linksEtScripts.inc.php');
?>
</head>

<body>

<div class="container">
	<?php
        $ajouterModePaiement='active';
        include_once('_includes/header.inc.php');
    ?>
    
    <div class="content">
    	<h1>Ajouter un mode de paiement</h1>
        
        <form method="post" action="#">
            <?php
				if(isset($resultatAjout)) echo '<p>'.$resultatAjout.'</p>';
				if(isset($erreurMode)) echo '<p class="erreur">'.$erreurMode.'</p>';
			?>
			<div class="field text">
				<label for="nouveauMode">Nouveau mode de paiement:</label>
				<input type="text" id="nouveauMode"  name="nouveauMode">
			</div>
			<input type="submit" class="btn submitNewPaiement" value="Ajouter">
            <input type="hidden" name="ajouterMode">
        </form>
		
		<?php if(mysqli_num_rows($req)!=0){ ?>
			<div class="listePaiementsContainer">
				<h4>Liste des modes de paiements déjà présents</h4>
				<ul class="listeModesPaiement">
				<?php while($enr=mysqli_fetch_assoc($req)){ ?>
					<li><?php echo $enr['modePaiement']; ?><a class="supprimer" href="?supprimer=<?php echo $enr['modePaiement_id'] ?>">Supprimer</a></li>
				<?php } ?>
				</ul>
			</div>
			<?php } ?>
        
    </div>
	
	<?php
		include('_includes/footer.inc.php');
	?>

</div>

</body>
</html>