<?php
	
	include_once('_scripts/config.php');
	include_once('_includes/verifConnexion.php');
	
	if(!isset($_GET['client_id'])){
		header('location:index.php');
		exit();
	}
	
	$client_id=$_GET['client_id'];
	
	//Sélection des infos
	$SQL="SELECT *
		FROM clients
		WHERE clients.client_id='$client_id'";
	
	$req=mysqli_query($link,$SQL) or die(mysqli_error($link));;
	$enr=mysqli_fetch_assoc($req);
	
	$nomClient=$enr['nomClient'];
	$adresse=$enr['adresse'];
	$ville=$enr['ville'];
	$telephone=$enr['telephone'];
	$dateNaissance=$enr['dateNaissance'];
	$tag=$enr['tag'];
	$codePostal=$enr['codePostal'];
	$sexe=$enr['sexe'];
	
	if(isset($_POST['creerClient'])){
		$nomClient=$_POST['nomClient'];
		$adresse=$_POST['adresse'];
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
			$SQL="UPDATE clients
				SET nomClient='$nomClient',adresse='$adresse',ville='$ville',telephone='$telephone',dateNaissance='$dateNaissance',tag='$tag',codePostal='$codePostal',sexe='$sexe'
				WHERE client_id='$client_id'";
				
			mysqli_query($link,$SQL) or die(mysqli_error($link));;
			
		}

	}
	
	$SQL="SELECT *
		FROM contrats
		WHERE client_id='$client_id'";
	$req=mysqli_query($link,$SQL) or die(mysqli_error($link));;
	$enr=mysqli_fetch_assoc($req);
	
	$contrat_id=$enr['contrat_id'];
	$numeroContrat=$enr['numeroContrat'];
	$duree=$enr['duree'];
	$dateDebut=$enr['dateDebut'];
	$dateFin=$enr['dateFin'];
	$typeContrat=$enr['typeContrat'];
	$fraisAdministration=$enr['fraisAdministration'];
	$cout=$enr['cout'];
	$numeroCarteCredit=$enr['numeroCarteCredit'];
	$expirationCarteCredit=$enr['expirationCarteCredit'];
	$numSecuriteCarteCredit=$enr['numSecuriteCarteCredit'];
	$TPS=$enr['TPS'];
	$TVQ=$enr['TVQ'];
	$total=$enr['total'];
	
	$SQL="SELECT COUNT(*) as nbPaiements
		FROM paiements
		WHERE contrat_id='$contrat_id'";
	$req=mysqli_query($link,$SQL) or die(mysqli_error($link));;
	$enr=mysqli_fetch_assoc($req);
	
	$nbPaiements=$enr['nbPaiements'];
	
	$SQL="SELECT modePaiement_id
		FROM paiements
		WHERE contrat_id='$contrat_id'";
	$req=mysqli_query($link,$SQL) or die(mysqli_error($link));;
	$enr=mysqli_fetch_assoc($req);
	
	$modePaiement_id=$enr['modePaiement_id'];
		
	if(isset($_POST['creerContrat'])){
		$numeroContrat=$_POST['numeroContrat'];
		$duree=$_POST['duree'];
		$dateDebut=$_POST['dateDebut'];
		$dateFin=$_POST['dateFin'];
		$typeContrat=$_POST['typeContrat'];
		$fraisAdministration=$_POST['fraisAdministration'];
		$cout=$_POST['cout'];
		$nbPaiements=$_POST['nbPaiements'];
		$numeroCarteCredit=$_POST['numeroCarteCredit'];
		$expirationCarteCredit=$_POST['expirationCarteCredit'];
		$numSecuriteCarteCredit=$_POST['numSecuriteCarteCredit'];
		$modePaiement_id=$_POST['modePaiement_id'];
		
		$erreurs=array();
		
		
		if(!is_numeric($fraisAdministration)){
			$erreurs['fraisAdministration']='Les frais d\'administration doivent être numériques';
		}
		if(!is_numeric($cout)){
			$erreurs['cout']='Le coût doit être numérique';
		}
		if(!is_numeric($duree)){
			$erreurs['duree']='La durée doit être numérique';
		}
		if(!is_numeric($nbPaiements)){
			$erreurs['nbPaiements']='Le nombre de paiements doit être numérique';
		}
		
		if(!strtotime($dateDebut)){
			$erreurs['dateDebut']='La date entrée n\'est pas valide (Format valide = aaaa-mm-jj)';
		}
		if(!strtotime($dateFin)){
			$erreurs['dateFin']='La date entrée n\'est pas valide (Format valide = aaaa-mm-jj)';
		}
		
		if($client_id==''){
			$erreurs['client_id']='Vous avez oublié de choisir un client';
		}
		if($numeroContrat==''){
			$erreurs['numeroContrat']='Vous avez oublié d\'écrire le numéro de contrat';
		}
		if($duree==''){
			$erreurs['duree']='Vous avez oublié d\'écrire la durée';
		}
		if($dateDebut==''){
			$erreurs['dateDebut']='Vous avez oublié d\'écrire la date de début';
		}
		if($dateFin==''){
			$erreurs['dateFin']='Vous avez oublié d\'écrire la date de fin';
		}
		if($fraisAdministration==''){
			$erreurs['fraisAdministration']='Vous avez oublié d\'écrire les frais d\'administration';
		}
		if($cout==''){
			$erreurs['cout']='Vous avez oublié d\'écrire le coût';
		}
		if($nbPaiements==''){
			$erreurs['nbPaiements']='Vous avez oublié d\'écrire le nombre de paiements';
		}
		if($typeContrat==''){
			$erreurs['typeContrat']='Vous avez oublié d\'écrire le type de contrat';
		}
		if($modePaiement_id==''){
			$erreurs['modePaiement_id']='Vous avez oublié de choisir le mode de paiement';
		}
		
		$sousTotal=$cout;
			
		$TPS=$_POST['TPS'];
		
		$TVQ=$_POST['TVQ'];
	
		$total=$_POST['total'];
		
		if(count($erreurs)==0){
				
			$SQL="SELECT contrat_id FROM contrats WHERE client_id='$client_id'";
			$req=mysqli_query($link,$SQL) or die(mysqli_error($link));;
			
			if(mysqli_num_rows($req)==0){
				$SQL="INSERT INTO contrats (client_id, numeroContrat, duree, dateDebut, dateFin, fraisAdministration, cout, TPS, TVQ, total, numeroCarteCredit, expirationCarteCredit, numSecuriteCarteCredit, typeContrat)
					VALUES ('$client_id', '$numeroContrat','$duree','$dateDebut','$dateFin','$fraisAdministration','$cout','$TPS','$TVQ', '$total', '$numeroCarteCredit', '$expirationCarteCredit', '$numSecuriteCarteCredit', '$typeContrat')";
				
				mysqli_query($link,$SQL) or die(mysqli_error($link));;
				
				$contrat_id=mysqli_insert_id($link);
			}else{
				$enr=mysqli_fetch_assoc($req);
				
				$contrat_id=$enr['contrat_id'];
				
				//Avant d'update on supprimme les anciens paiements
				$SQL="DELETE FROM paiements
					WHERE contrat_id='$contrat_id'";
					
				mysqli_query($link,$SQL) or die(mysqli_error($link));;
				
				$SQL="UPDATE contrats
					SET client_id='$client_id', numeroContrat='$numeroContrat', duree='$duree', dateDebut='$dateDebut', dateFin='$dateFin', fraisAdministration='$fraisAdministration', cout='$cout', TPS='$TPS', TVQ='$TVQ', total='$total', numeroCarteCredit='$numeroCarteCredit', expirationCarteCredit='$expirationCarteCredit', numSecuriteCarteCredit='$numSecuriteCarteCredit', typeContrat='$typeContrat'
					WHERE client_id='$client_id'";
					
				mysqli_query($link,$SQL) or die(mysqli_error($link));;
				
			}
			$montantPaiement=$total/$nbPaiements;
			
			$dateDiff=abs(strtotime($dateFin)-strtotime($dateDebut));
			
			$dateDiff=$dateDiff/(60*60*24);
			
			$joursEntre=floor($dateDiff/$nbPaiements);
			
			$dateSuivante;
			for($i=0;$i<$nbPaiements;$i++){
				if($i==0){
					$date=$dateDebut;
					$SQL="INSERT INTO paiements (montant, datePaiement, contrat_id, modePaiement_id)
					VALUES ('$montantPaiement','$dateDebut', '$contrat_id', '$modePaiement_id')";
					
					mysqli_query($link,$SQL) or die(mysqli_error($link));;
				}else{
					
					$dateSuivante = date('Y-m-d', strtotime($date.' +'.$joursEntre.' days'));
					
					$SQL="INSERT INTO paiements (montant, datePaiement, contrat_id, modePaiement_id)
						VALUES ('$montantPaiement','$dateSuivante', '$contrat_id', '$modePaiement_id')";
						
					mysqli_query($link,$SQL) or die(mysqli_error($link));;
					
					$date=$dateSuivante;
				}
			}
		}

	}
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Modifier un(e) client(e)</title>
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
		<div class="modifClient">
			<h2>Modifier un(e) client(e)</h2>
			
			<form action="#" method="post" class="creerClient">
				<?php
					$affichage='<div class="field text">
					<label for="nomClient">Client</label>
					<input type="text" name="nomClient" id="nomClient"';
					
					if(isset($nomClient)){
						$affichage.='value="'.$nomClient.'"';
					}
					
					$affichage.='>';
					
					if(isset($erreurs['nomClient'])){
						$affichage.='<p class="erreur">'.$erreurs['nomClient'].'</p>';
					}
					
					$affichage .= '</div>';
					
					$affichage.='<div class="field text">
					<label for="adresse">Adresse</label>
					<input type="text" name="adresse" id="adresse"';
					
					if(isset($adresse)){
						$affichage.='value="'.$adresse.'"';
					}
					
					$affichage.='>';
					
					if(isset($erreurs['adresse'])){
						$affichage.='<p class="erreur">'.$erreurs['adresse'].'</p>';
					}
					
					$affichage .= '</div>';
					
					$affichage.='<div class="field text">
					<label for="ville">Ville</label>
					<input type="text" name="ville" id="ville"';
					
					if(isset($ville)){
						$affichage.='value="'.$ville.'"';
					}
					
					$affichage.='>';
					
					if(isset($erreurs['ville'])){
						$affichage.='<p class="erreur">'.$erreurs['ville'].'</p>';
					}
					
					$affichage .= '</div>';
					
					$affichage.='<div class="field text">
					<label for="telephone">Téléphone</label>
					<input type="tel" name="telephone" id="telephone"';
					
					if(isset($telephone)){
						$affichage.='value="'.$telephone.'"';
					}
					
					$affichage.='>';
					
					if(isset($erreurs['telephone'])){
						$affichage.='<p class="erreur">'.$erreurs['telephone'].'</p>';
					}
					
					$affichage .= '</div>';
					
					$affichage.='<div class="field date">
					<label for="dateNaissance">Né(e) le</label>
					<input type="date" placeholder="AAAA-MM-JJ" name="dateNaissance" id="dateNaissance"';
					
					if(isset($dateNaissance)){
						$affichage.='value="'.$dateNaissance.'"';
					}
					
					$affichage.='>';
					
					if(isset($erreurs['dateNaissance'])){
						$affichage.='<p class="erreur">'.$erreurs['dateNaissance'].'</p>';
					}
					
					$affichage .= '</div>';
					
					$affichage.='<div class="field text">
					<label for="tag">Courriel</label>
					<input type="text" name="tag" id="tag"';
					
					if(isset($tag)){
						$affichage.='value="'.$tag.'"';
					}
					
					$affichage.='>';
					
					if(isset($erreurs['tag'])){
						$affichage.='<p class="erreur">'.$erreurs['tag'].'</p>';
					}
					
					$affichage .= '</div>';
					
					$affichage.='<div class="field text">
					<label for="codePostal">Code Postal</label>
					<input type="text" name="codePostal" id="codePostal"';
					
					if(isset($codePostal)){
						$affichage.='value="'.$codePostal.'"';
					}
					
					$affichage.='>';
					
					if(isset($erreurs['codePostal'])){
						$affichage.='<p class="erreur">'.$erreurs['codePostal'].'</p>';
					}
					
					$affichage .= '</div>';
					
					$affichage.='<div class="field select">
					<label>Sexe</label>
					<select name="sexe">';
					
					$affichage.='<option value="Femme" '.(($sexe=='Femme')?'selected':'').'>Femme</option>';
					$affichage.='<option value="Homme" '.(($sexe=='Homme')?'selected':'').'>Homme</option>';
					  
					 $affichage.='</select>';
					
					if(isset($erreurs['sexe'])){
						$affichage.='<p class="erreur">'.$erreurs['sexe'].'</p>';
					}
					
					$affichage .= '</div>';
					
					$affichage.='<input type="hidden" name="creerClient">';
					
					$affichage.='<div class="field submit">
					<input type="submit" class="btn" value="Modifier client" >
					</div>';
					
					echo $affichage;
				?>
			</form>
		</div>
        
		<div class="modifClient" id="modifContrat">
		
			<h2>Modifier le contrat</h2>
			
			<form action="#modifContrat" method="post" class="modifContrat">
				<?php
									
					$affichage='<fieldset>
					<div class="field text">
					<label for="numeroContrat">Numéro du contrat</label>
					<input type="text" name="numeroContrat" id="numeroContrat"';
					
					if(isset($numeroContrat)){
						$affichage.='value="'.$numeroContrat.'"';
					}
					
					$affichage.='>';
					
					if(isset($erreurs['numeroContrat'])){
						$affichage.='<p class="erreur">'.$erreurs['numeroContrat'].'</p>';
					}
					
					$affichage .= '</div>';
					
					$affichage.='<div class="field text">
					<label for="duree">Durée (en mois)</label>
					<input type="text" name="duree" id="duree"';
					
					if(isset($duree)){
						$affichage.='value="'.$duree.'"';
					}
					
					$affichage.='>';
					
					if(isset($erreurs['duree'])){
						$affichage.='<p class="erreur">'.$erreurs['duree'].'</p>';
					}
					
					$affichage .= '</div>';
					
					$affichage.='<div class="field date">
					<label for="dateDebut">Date de début</label>
					<input type="date" placeholder="AAAA-MM-JJ" name="dateDebut" id="dateDebut"';
					
					if(isset($dateDebut)){
						$affichage.='value="'.$dateDebut.'"';
					}
					
					$affichage.='>';
					
					if(isset($erreurs['dateDebut'])){
						$affichage.='<p class="erreur">'.$erreurs['dateDebut'].'</p>';
					}
					
					$affichage .= '</div>';
					
					$affichage.='<div class="field date">
					<label for="dateFin">Date de fin</label>
					<input type="date" placeholder="AAAA-MM-JJ" name="dateFin" id="dateFin"';
					
					if(isset($dateFin)){
						$affichage.='value="'.$dateFin.'"';
					}
					
					$affichage.='>';
					
					if(isset($erreurs['dateFin'])){
						$affichage.='<p class="erreur">'.$erreurs['dateFin'].'</p>';
					}
					
					$affichage .= '</div>';
					
					 $affichage.='<div class="field text">
					<label for="typeContrat">Type de contrat</label>
					<input type="text" name="typeContrat" id="typeContrat"';
					
					if(isset($typeContrat)){
						$affichage.='value="'.$typeContrat.'"';
					}
					
					$affichage.='>';
					
					if(isset($erreurs['typeContrat'])){
						$affichage.='<p class="erreur">'.$erreurs['typeContrat'].'</p>';
					}
					
					$affichage .= '</div>
					</fieldset>';
					
					$affichage.='<fieldset>
					 <div class="field text">
					<label for="fraisAdministration">Frais d\'administration</label>
					<input type="text" name="fraisAdministration" id="fraisAdministration"';
					
					if(isset($fraisAdministration) && is_numeric($fraisAdministration)){
						$affichage.='value="'.number_format ( $fraisAdministration , 2, '.', '').'"';
					}
					
					$affichage.='>';
					
					if(isset($erreurs['fraisAdministration'])){
						$affichage.='<p class="erreur">'.$erreurs['fraisAdministration'].'</p>';
					}
					
					$affichage .= '</div>';
					
					$affichage.='<div class="field text">
					<label for="cout">Coût</label>
					<input type="text" name="cout" id="cout"';
					
					if(isset($cout) && is_numeric($cout)){
						$affichage.='value="'.number_format ( $cout , 2, '.', '').'"';
					}
					
					$affichage.='>';
					
					if(isset($erreurs['cout'])){
						$affichage.='<p class="erreur">'.$erreurs['cout'].'</p>';
					}
					
					$affichage .= '</div>';
					
					$affichage.='<div class="field text readonly">
					<label for="TPS">TPS</label>
					<input type="text" readonly name="TPS" id="TPS"';
					
					if(isset($TPS) && is_numeric($TPS)){
						$affichage.='value="'.number_format ( $TPS , 2, '.', '').'"';
					}
					
					$affichage.='>';
					
					if(isset($erreurs['TPS'])){
						$affichage.='<p class="erreur">'.$erreurs['TPS'].'</p>';
					}
					
					$affichage .= '</div>';
					
					$affichage.='<div class="field text readonly">
					<label for="TVQ">TVQ</label>
					<input type="text" readonly name="TVQ" id="TVQ"';
					
					if(isset($TVQ) && is_numeric($TVQ)){
						$affichage.='value="'.number_format ( $TVQ , 2, '.', '').'"';
					}
					
					$affichage.='>';
					
					if(isset($erreurs['TVQ'])){
						$affichage.='<p class="erreur">'.$erreurs['TVQ'].'</p>';
					}
					
					$affichage .= '</div>';
					
					$affichage.='<div class="field text readonly">
					<label for="total">Total</label>
					<input type="text" readonly name="total" id="total"';
					
					if(isset($total) && is_numeric($total)){
						$affichage.='value="'.number_format ( $total , 2, '.', '').'"';
					}
					
					$affichage.='>';
					
					if(isset($erreurs['total'])){
						$affichage.='<p class="erreur">'.$erreurs['total'].'</p>';
					}
					
					$affichage .= '</div>';
					
					$affichage.='<div class="field text">
					<label for="nbPaiements">En combien de paiements</label>
					<input type="text" name="nbPaiements" id="nbPaiements"';
					
					if(isset($nbPaiements)){
						$affichage.='value="'.$nbPaiements.'"';
					}
					
					$affichage.='>';
					
					if(isset($erreurs['nbPaiements'])){
						$affichage.='<p class="erreur">'.$erreurs['nbPaiements'].'</p>';
					}
					
					$SQL="SELECT modePaiement_id, modePaiement
						FROM modesPaiements";
						
					$reqModes=mysqli_query($link,$SQL) or die(mysqli_error($link));;
					
					$modes=array();
					while($enrModes=mysqli_fetch_assoc($reqModes)){
						$modes[$enrModes['modePaiement_id']]=$enrModes['modePaiement'];
					}
					
					$affichage .= '</div>';
					
					$affichage.='<div class="field select">
					<label>Mode de paiement</label>
						<select name="modePaiement_id"><option></option>';
					foreach($modes as $mode_id => $mode){
						$affichage.='<option value="'.$mode_id.'" '.(($modePaiement_id==$mode_id)?'selected':'').'>'.$mode.'</option>';
					}
					$affichage.='</select>';
					
					if(isset($erreurs['modePaiement_id'])){
						$affichage.='<p class="erreur">'.$erreurs['modePaiement_id'].'</p>';
					}
					
					$affichage .= '</div>';
					
					$affichage.='<div class="field text">
					<label for="numeroCarteCredit">Numéro de carte de crédit</label>
					<input type="text" name="numeroCarteCredit" id="numeroCarteCredit"';
					
					if(isset($numeroCarteCredit)){
						$affichage.='value="'.$numeroCarteCredit.'"';
					}
					
					$affichage.='>';
					
					if(isset($erreurs['numeroCarteCredit'])){
						$affichage.='<p class="erreur">'.$erreurs['numeroCarteCredit'].'</p>';
					}
					
					$affichage .= '</div>';
					
					$affichage.='<div class="field text">
					<label for="expirationCarteCredit">Date d\'expiration de la carte de crédit</label>
					<input type="text" placeholder="MM/AA" name="expirationCarteCredit" id="expirationCarteCredit"';
					
					if(isset($expirationCarteCredit)){
						$affichage.='value="'.$expirationCarteCredit.'"';
					}
					
					$affichage.='>';
					
					if(isset($erreurs['expirationCarteCredit'])){
						$affichage.='<p class="erreur">'.$erreurs['expirationCarteCredit'].'</p>';
					}
					
					  if(isset($erreurs['numeroCarteCredit'])){
						$affichage.='<p class="erreur">'.$erreurs['numeroCarteCredit'].'</p>';
					}
					
					$affichage .= '</div>';
					
					$affichage.='<div class="field text">
					<label for="numSecuriteCarteCredit">Numéro de sécurité de la carte de crédit</label>
					<input type="text" name="numSecuriteCarteCredit" id="numSecuriteCarteCredit"';
					
					if(isset($numSecuriteCarteCredit)){
						$affichage.='value="'.$numSecuriteCarteCredit.'"';
					}
					
					$affichage.='>';
					
					if(isset($erreurs['numSecuriteCarteCredit'])){
						$affichage.='<p class="erreur">'.$erreurs['numSecuriteCarteCredit'].'</p>';
					}
					
					$affichage .= '</div>
					</fieldset>';
					
					$affichage.='<input type="hidden" name="creerContrat">';
					
					$affichage.='<div class="field submit">
					<input type="submit" class="btn" value="Modifier contrat" >
					</div>';
					
					echo $affichage;
				?>
			</form>
			
		</div>
	
	<?php
		include('_includes/footer.inc.php');
	?>
        
    </div>
</div>

</body>
</html>