<?php
	include_once('_scripts/config.php');
	include_once('_includes/verifConnexion.php');
	
	if(isset($_POST['changerInfos'])){
		$decription=nl2br(addslashes($_POST['description']));
		$reglements=nl2br(addslashes($_POST['reglements']));
		
		$SQL="UPDATE infos
			SET descriptionServices='$decription', reglements='$reglements'";
		mysqli_query($link, $SQL) or die(mysqli_error($link));
	}
	
	$SQL="SELECT *
		FROM infos";
	$req=mysqli_query($link, $SQL) or die(mysqli_error($link));
	
	$enr=mysqli_fetch_assoc($req);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Changer les infos</title>
<?php
	include_once('_includes/linksEtScripts.inc.php');
?>
</head>

<body>

<div class="container">
	<?php
        $changerInfos='active';
        include_once('_includes/header.inc.php');
    ?>
    
    <div class="content">
    	<h1>Changer la description et les règlements</h1>
        
        <form method="post" action="#" class="changerInfos">
			<div class="textarea">
				<label for="description">Description des services:</label>
				<textarea id="description"  name="description"><?php echo strip_tags(stripslashes($enr['descriptionServices'])) ?></textarea>
			</div>
            
			<div class="textarea">
				<label for="reglements">Règlements généraux:</label>
				<textarea id="reglements"  name="reglements"><?php echo strip_tags(stripslashes($enr['reglements'])) ?></textarea>
			</div>
            
            <input type="hidden" name="changerInfos">
			<div class="field submit">
				<input type="submit" class="btn" value="Changer">
			</div>
        </form>
        
    </div>
	
	<?php
		include('_includes/footer.inc.php');
	?>

</div>

</body>
</html>