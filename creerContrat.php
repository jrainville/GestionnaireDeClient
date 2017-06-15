<?php
	include_once('_scripts/config.php');
	include_once('_includes/verifConnexion.php');
	
	if(isset($_GET['client_id'])){
		$client_id=$_GET['client_id'];
	}
	
	$SQL="SELECT client_id, nomClient
		FROM clients
		ORDER BY nomClient";
		
	$reqClients=mysqli_query($link,$SQL);
	
	if(isset($_POST['creerContrat'])){
		$client_id=$_POST['client_id'];
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
		if($modePaiement_id=='default'){
			$erreurs['modePaiement_id']='Vous avez oublié de choisir le mode de paiement';
		}
		
		$sousTotal=$cout;
			
		$TPS=$_POST['TPS'];
		
		$TVQ=$_POST['TVQ'];
	
		$total=$_POST['total'];
		
		if(count($erreurs)==0){
				
			$SQL="SELECT contrat_id FROM contrats WHERE client_id='$client_id'";
			$req=mysqli_query($link, $SQL);
			
			if(mysqli_num_rows($req)==0){
				$SQL="INSERT INTO contrats (client_id, numeroContrat, duree, dateDebut, dateFin, fraisAdministration, cout, TPS, TVQ, total, numeroCarteCredit, expirationCarteCredit, numSecuriteCarteCredit, typeContrat)
					VALUES ('$client_id', '$numeroContrat','$duree','$dateDebut','$dateFin','$fraisAdministration','$cout','$TPS','$TVQ', '$total', '$numeroCarteCredit', '$expirationCarteCredit', '$numSecuriteCarteCredit', '$typeContrat')";
				
				mysqli_query($link, $SQL);
				
				$contrat_id=mysqli_insert_id($link);
			}else{
				$enr=mysqli_fetch_assoc($req);
				
				$contrat_id=$enr['contrat_id'];
				
				//Avant d'update on supprimme les anciens paiements
				$SQL="DELETE FROM paiements
					WHERE contrat_id='$contrat_id'";
					
				mysqli_query($link, $SQL);
				
				$SQL="UPDATE contrats
					SET client_id='$client_id', numeroContrat='$numeroContrat', duree='$duree', dateDebut='$dateDebut', dateFin='$dateFin', fraisAdministration='$fraisAdministration', cout='$cout', TPS='$TPS', TVQ='$TVQ', total='$total', numeroCarteCredit='$numeroCarteCredit', expirationCarteCredit='$expirationCarteCredit', numSecuriteCarteCredit='$numSecuriteCarteCredit', typeContrat='$typeContrat'
					WHERE client_id='$client_id'";
					
				mysqli_query($link, $SQL);
				
			}
			$montantPaiement=$total/$nbPaiements;
			
			$dateDiff=abs(strtotime($dateFin)-strtotime($dateDebut));
			
			$dateDiff=$dateDiff/(60*60*24);
			
			$joursEntre=floor($dateDiff/$nbPaiements);
			
			$dateSuivante;
			for($i=0;$i<$nbPaiements;$i++){
				if($i==0){
					$date=$dateDebut;
				//}else if($i==$nbPaiements-1){
					$SQL="INSERT INTO paiements (montant, datePaiement, contrat_id, modePaiement_id)
					VALUES ('$montantPaiement','$dateDebut', '$contrat_id', '$modePaiement_id')";
					
					mysqli_query($link,$SQL);
				}else{
					
					$dateSuivante = date('Y-m-d', strtotime($date.' +'.$joursEntre.' days'));
					
					$SQL="INSERT INTO paiements (montant, datePaiement, contrat_id, modePaiement_id)
						VALUES ('$montantPaiement','$dateSuivante', '$contrat_id', '$modePaiement_id')";
						
					mysqli_query($link,$SQL);
					
					$date=$dateSuivante;
				}
			}
			
			header('location:facture.php?client_id='.$client_id);
			exit();
		}

	}
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Créer un contrat</title>
<?php
	include_once('_includes/linksEtScripts.inc.php');
?>
</head>

<body>

<div class="container">
	<?php
        $creerContrat='active';
        include_once('_includes/header.inc.php');
    ?>
    
    <div class="content">
    	<h1>Créer un contrat</h1>
        
        <form action="#" method="post" class="creerContrat">
			<fieldset>
            <?php
				$affichage='<div class="field select"><label>Client<span class="requiredField">*</span></label>
				<select name="client_id">';
				while($enrClients=mysqli_fetch_assoc($reqClients)){
                	$affichage.='<option value="'.$enrClients['client_id'].'"';
					if(isset($client_id) && $client_id==$enrClients['client_id']) $affichage.='selected';
					$affichage.='>'.$enrClients['nomClient'].'</option>';
				}
                $affichage.='</select>';
                                
                if(isset($erreurs['client_id'])){
                    $affichage.='<p class="erreur">'.$erreurs['client_id'].'</p>';
                }
                
                $affichage.='</div>';
				
                $affichage.='<div class="field text"><label for="numeroContrat">Numéro du contrat</label>
                <input type="text" name="numeroContrat" id="numeroContrat"';
                
                if(isset($numeroContrat)){
                    $affichage.='value="'.$numeroContrat.'"';
                }
                
                $affichage.='>';
                
                if(isset($erreurs['numeroContrat'])){
                    $affichage.='<p class="erreur">'.$erreurs['numeroContrat'].'</p>';
                }
                
                $affichage.='</div>';
                
                $affichage.='<div class="field text"><label for="duree">Durée (en mois)<span class="requiredField">*</span></label>
                <input type="text" name="duree" id="duree"';
                
                if(isset($duree)){
                    $affichage.='value="'.$duree.'"';
                }
                
                $affichage.='>';
                
                if(isset($erreurs['duree'])){
                    $affichage.='<p class="erreur">'.$erreurs['duree'].'</p>';
                }
                
                $affichage.='</div>';
                
                $affichage.='<div class="field date"><label for="dateDebut">Date de début<span class="requiredField">*</span></label>
                <input type="date" placeholder="AAAA-MM-JJ" name="dateDebut" id="dateDebut"';
                
                if(isset($dateDebut)){
                    $affichage.='value="'.$dateDebut.'"';
                }
                
                $affichage.='>';
                
                if(isset($erreurs['dateDebut'])){
                    $affichage.='<p class="erreur">'.$erreurs['dateDebut'].'</p>';
                }
                
                $affichage.='</div>';
                
                $affichage.='<div class="field date"><label for="dateFin">Date de fin<span class="requiredField">*</span></label>
                <input type="date" placeholder="AAAA-MM-JJ" name="dateFin" id="dateFin"';
                
                if(isset($dateFin)){
                    $affichage.='value="'.$dateFin.'"';
                }
                
                $affichage.='>';
                
                if(isset($erreurs['dateFin'])){
                    $affichage.='<p class="erreur">'.$erreurs['dateFin'].'</p>';
                }
                
                $affichage.='</div>';
				
				
				 $affichage.='<div class="field text"><label for="typeContrat">Type de contrat<span class="requiredField">*</span></label>
                <input type="text" name="typeContrat" id="typeContrat"';
                
                if(isset($typeContrat)){
                    $affichage.='value="'.$typeContrat.'"';
                }
                
                $affichage.='>';
                
                if(isset($erreurs['typeContrat'])){
                    $affichage.='<p class="erreur">'.$erreurs['typeContrat'].'</p>';
                }
                
                $affichage.='</div>
					</fieldset>';
                
				
                $affichage.='<fieldset>
				 <div class="field text"><label for="fraisAdministration">Frais d\'administration<span class="requiredField">*</span></label>
                <input type="text" name="fraisAdministration" id="fraisAdministration"';
                
                if(isset($fraisAdministration) && is_numeric($fraisAdministration)){
                    $affichage.='value="'.number_format ( $fraisAdministration , 2).'"';
                }
                
                $affichage.='>';
                
                if(isset($erreurs['fraisAdministration'])){
                    $affichage.='<p class="erreur">'.$erreurs['fraisAdministration'].'</p>';
                }
                
                $affichage.='</div>';
                
                $affichage.='<div class="field text"><label for="cout">Coût<span class="requiredField">*</span></label>
                <input type="text" name="cout" id="cout"';
                
                if(isset($cout) && is_numeric($cout)){
                    $affichage.='value="'.number_format ( $cout , 2).'"';
                }
                
                $affichage.='>';
                
                if(isset($erreurs['cout'])){
                    $affichage.='<p class="erreur">'.$erreurs['cout'].'</p>';
                }
                
                $affichage.='</div>';
                
                $affichage.='<div class="field text readonly"><label for="TPS">TPS<span class="requiredField">*</span></label>
                <input type="text" readonly name="TPS" id="TPS"';
                
                if(isset($TPS) && is_numeric($TPS)){
                    $affichage.='value="'.number_format ( $TPS , 2).'"';
                }
                
                $affichage.='>';
                
                if(isset($erreurs['TPS'])){
                    $affichage.='<p class="erreur">'.$erreurs['TPS'].'</p>';
                }
                
                $affichage.='</div>';
				
				$affichage.='<div class="field text readonly"><label for="TVQ">TVQ<span class="requiredField">*</span></label>
                <input type="text" readonly name="TVQ" id="TVQ"';
                
                if(isset($TVQ) && is_numeric($TVQ)){
                    $affichage.='value="'.number_format ( $TVQ , 2).'"';
                }
                
                $affichage.='>';
                
                if(isset($erreurs['TVQ'])){
                    $affichage.='<p class="erreur">'.$erreurs['TVQ'].'</p>';
                }
                
                $affichage.='</div>';
				
				$affichage.='<div class="field text readonly"><label for="total">Total<span class="requiredField">*</span></label>
                <input type="text" readonly name="total" id="total"';
                
                if(isset($total) && is_numeric($total)){
                    $affichage.='value="'.number_format ( $total , 2).'"';
                }
                
                $affichage.='>';
                
                if(isset($erreurs['total'])){
                    $affichage.='<p class="erreur">'.$erreurs['total'].'</p>';
                }
                
                $affichage.='</div>';
				
				$affichage.='<div class="field text"><label for="nbPaiements">En combien de paiements<span class="requiredField">*</span></label>
                <input type="text" name="nbPaiements" id="nbPaiements"';
                
                if(isset($nbPaiements)){
                    $affichage.='value="'.$nbPaiements.'"';
                }
                
                $affichage.='>';
                
                if(isset($erreurs['nbPaiements'])){
                    $affichage.='<p class="erreur">'.$erreurs['nbPaiements'].'</p>';
                }
                
                $affichage.='</div>';
				
				$SQL="SELECT modePaiement_id, modePaiement
					FROM modesPaiements";
					
				$reqModes=mysqli_query($link, $SQL);
				
				$modes=array();
				while($enrModes=mysqli_fetch_assoc($reqModes)){
					$modes[$enrModes['modePaiement_id']]=$enrModes['modePaiement'];
				}
				
				$affichage.='<div class="field select"><label>Mode de paiement<span class="requiredField">*</span></label>
					<select name="modePaiement_id"><option value="default">Choisir un mode de paiement</option>';
				foreach($modes as $mode_id => $mode){
					$affichage.='<option value="'.$mode_id.'"';
					if ($mode_id == $modePaiement_id) {
						$affichage .= ' selected';
					}
					$affichage .= '>'.$mode.'</option>';
				}
				$affichage.='</select>';
				
				if(isset($erreurs['modePaiement_id'])){
                    $affichage.='<p class="erreur">'.$erreurs['modePaiement_id'].'</p>';
                }
                
                $affichage.='</div>';
				
				$affichage.='<div class="field text"><label for="numeroCarteCredit">Numéro de carte de crédit</label>
                <input type="text" name="numeroCarteCredit" id="numeroCarteCredit"';
                
                if(isset($numeroCarteCredit)){
                    $affichage.='value="'.$numeroCarteCredit.'"';
                }
                
                $affichage.='>';
                
                if(isset($erreurs['numeroCarteCredit'])){
                    $affichage.='<p class="erreur">'.$erreurs['numeroCarteCredit'].'</p>';
                }
                
                $affichage.='</div>';
				
				$affichage.='<div class="field text"><label for="expirationCarteCredit">Date d\'expiration de la carte de crédit</label>
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
                
                $affichage.='</div>';
				
				$affichage.='<div class="field text"><label for="numSecuriteCarteCredit">Numéro de sécurité de la carte de crédit</label>
                <input type="text" name="numSecuriteCarteCredit" id="numSecuriteCarteCredit"';
                
                if(isset($numSecuriteCarteCredit)){
                    $affichage.='value="'.$numSecuriteCarteCredit.'"';
                }
                
                $affichage.='>';
                
                if(isset($erreurs['numSecuriteCarteCredit'])){
                    $affichage.='<p class="erreur">'.$erreurs['numSecuriteCarteCredit'].'</p>';
                }
                
                $affichage.='</div>
					</fieldset>';
				
                
                $affichage.='<input type="hidden" name="creerContrat">';
                
                $affichage.='<div class="field submit"><input class="btn" type="submit" value="Créer"></div>';
                
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