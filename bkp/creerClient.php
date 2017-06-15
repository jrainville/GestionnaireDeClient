<?php
	include_once('_scripts/config.php');
	include_once('_includes/verifConnexion.php');
	
	if(isset($_POST['creerClient'])){
		$nomClient=$_POST['nomClient'];
		$adresse=addslashes($_POST['adresse']);
		$ville=$_POST['ville'];
		$telephone=$_POST['telephone'];
		$dateNaissance=$_POST['dateNaissance'];
		$tag=$_POST['tag'];
		$codePostal=$_POST['codePostal'];
		$sexe=$_POST['sexe'];

		$erreurs=array();
		
		if($nomClient==''){
			$erreurs['nomClient']='Vous avez oublié d\'écrire le nom du client';
		}
		if($adresse==''){
			$erreurs['adresse']='Vous avez oublié d\'écrire l\'adresse du client';
		}
		if($ville==''){
			$erreurs['ville']='Vous avez oublié d\'écrire la ville du client';
		}
		if($telephone==''){
			$erreurs['telephone']='Vous avez oublié d\'écrire le numéro de téléphone du client';
		}
		if($dateNaissance==''){
			$erreurs['dateNaissance']='Vous avez oublié d\'écrire la date de naissance du client';
		}
		if($tag==''){
			$erreurs['tag']='Vous avez oublié d\'écrire le courriel du client';
		}
		if($codePostal==''){
			$erreurs['codePostal']='Vous avez oublié d\'écrire le code postal du client';
		}
		if($sexe==''){
			$erreurs['sexe']='Vous avez oublié de choisir le sexe du client';
		}
		
		if(count($erreurs)==0){		
			$SQL="INSERT INTO clients (nomClient, adresse, ville, telephone, dateNaissance, tag, codePostal, sexe)
				VALUES ('$nomClient','$adresse','$ville','$telephone','$dateNaissance','$tag','$codePostal','$sexe')";
				
			mysqli_query($link, $SQL);
			
			$id=mysqli_insert_id ($link);
			
			header('location:creerContrat.php?client_id='.$id);
			exit();
		}

	}
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Ajouter un(e) client(e)</title>
<?php
	include_once('_includes/linksEtScripts.inc.php');
?>
</head>

<body>

<div class="container">
	<?php
		$creerClient='active';
        include_once('_includes/header.inc.php');
    ?>
    
    <div class="content">
        <h1>Créer un(e) client(e)</h1>
        
        <form action="#" method="post" class="creerClient">
            <?php
                $affichage='<div class="field text"><label for="nomClient">Client</label>
                <input type="text" name="nomClient" id="nomClient"';
                
                if(isset($nomClient)){
                    $affichage.='value="'.$nomClient.'"';
                }
                
                $affichage.='>';
                
                if(isset($erreurs['nomClient'])){
                    $affichage.='<p class="erreur">'.$erreurs['nomClient'].'</p>';
                }
                
                $affichage.='</div>';
                
                $affichage.='<div class="field text"><label for="adresse">Adresse</label>
                <input type="text" name="adresse" id="adresse"';
                
                if(isset($adresse)){
                    $affichage.='value="'.stripslashes($adresse).'"';
                }
                
                $affichage.='>';
                
                if(isset($erreurs['adresse'])){
                    $affichage.='<p class="erreur">'.$erreurs['adresse'].'</p>';
                }
                
                $affichage.='</div>';
                
                $affichage.='<div class="field text"><label for="ville">Ville</label>
                <input type="text" name="ville" id="ville"';
                
                if(isset($ville)){
                    $affichage.='value="'.$ville.'"';
                }
                
                $affichage.='>';
                
                if(isset($erreurs['ville'])){
                    $affichage.='<p class="erreur">'.$erreurs['ville'].'</p>';
                }
                
                $affichage.='</div>';
                
                $affichage.='<div class="field text"><label for="telephone">Téléphone</label>
                <input type="tel" name="telephone" id="telephone"';
                
                if(isset($telephone)){
                    $affichage.='value="'.$telephone.'"';
                }
                
                $affichage.='>';
                
                if(isset($erreurs['telephone'])){
                    $affichage.='<p class="erreur">'.$erreurs['telephone'].'</p>';
                }
                
                $affichage.='</div>';
                
                $affichage.='<div class="field date"><label for="dateNaissance">Né(e) le</label>
                <input type="date" placeholder="AAAA-MM-JJ" name="dateNaissance" id="dateNaissance"';
                
                if(isset($dateNaissance)){
                    $affichage.='value="'.$dateNaissance.'"';
                }
                
                $affichage.='>';
                
                if(isset($erreurs['dateNaissance'])){
                    $affichage.='<p class="erreur">'.$erreurs['dateNaissance'].'</p>';
                }
                
                $affichage.='</div>';
                
                $affichage.='<div class="field text"><label for="tag">Courriel</label>
                <input type="text" name="tag" id="tag"';
                
                if(isset($tag)){
                    $affichage.='value="'.$tag.'"';
                }
                
                $affichage.='>';
                
                if(isset($erreurs['tag'])){
                    $affichage.='<p class="erreur">'.$erreurs['tag'].'</p>';
                }
                
                $affichage.='</div>';
                
                $affichage.='<div class="field text"><label for="codePostal">Code Postal</label>
                <input type="text" name="codePostal" id="codePostal"';
                
                if(isset($codePostal)){
                    $affichage.='value="'.$codePostal.'"';
                }
                
                $affichage.='>';
                
                if(isset($erreurs['codePostal'])){
                    $affichage.='<p class="erreur">'.$erreurs['codePostal'].'</p>';
                }
                
                $affichage.='</div>';
                
                $affichage.='<div class="field select"><label>Sexe</label>
                <select name="sexe">
                  <option value="Femme" selected>Femme</option>
                  <option value="Homme">Homme</option>
                </select>';
                
                if(isset($erreurs['sexe'])){
                    $affichage.='<p class="erreur">'.$erreurs['sexe'].'</p>';
                }
                
                $affichage.='</div>';
                
                $affichage.='<input type="hidden" name="creerClient">';
                
                $affichage.='<div class="field submit"><input class="btn" type="submit" value="Créer" ></div>';
                
                echo $affichage;
            ?>
        </form>
    </div>
	
	<?php
		include('_includes/footer.inc.php');
	?>
</div>

</body>
</html>