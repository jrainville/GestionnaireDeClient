<?php
	include_once('_scripts/config.php');
	include_once('_includes/verifConnexion.php');
	
	if(!isset($_GET['client_id'])){
		header('location:index.php');
		exit();
	}
	
	setlocale(LC_MONETARY, 'fr_CA');
		
	$client_id=$_GET['client_id'];
	
	if(isset($_POST['confirmationResiliation'])){
		$dateResiliation=$_POST['dateResiliation'];
		
		if($dateResiliation!=''){
			$SQL="UPDATE contrats
				SET typeContrat='RÉSILIÉ', dateResiliation='$dateResiliation'
				WHERE client_id='$client_id'";
			mysqli_query($link, $SQL);
			
		}else $erreur='Vous avez oublié d\'entrer la date de résiliation, veuillez recommencer';
	}
	
	if(isset($_POST['confirmationSuspension'])){
		$dateSuspension=$_POST['dateSuspension'];
		
		if($dateSuspension!=''){
			$SQL="UPDATE contrats
				SET typeContrat='SUSPENDU', dateSuspension='$dateSuspension'
				WHERE client_id='$client_id'";
			mysqli_query($link, $SQL);
		}else $erreur='Vous avez oublié d\'entrer la date de suspension, veuillez recommencer';
	}
	
	//DÉSUPSPENSION
	if(isset($_POST['confirmationDesuspension'])){
		$dateDebut=$_POST['dateReprise'];
		$dateFin=$_POST['dateFin'];
		
		if($dateDebut==''){
			$erreur='Vous avez oublié d\'entrer la date de resprise, veuillez réessayer.';
		}
		if($dateFin==''){
			$erreur='Vous avez oublié d\'entrer la date de fin, veuillez réessayer.';
		}
		
		if(!isset($erreur)){
			$SQL="SELECT SUM(montant) as somme, COUNT(montant) as nbPaiements, contrats.contrat_id, modePaiement_id
				FROM paiements
				JOIN contrats
				ON contrats.contrat_id=paiements.contrat_id
				WHERE client_id='$client_id'
				AND conc=0"; 
			$reqSomme=mysqli_query($link, $SQL)or die(mysqli_error($link));
			$enrSomme=mysqli_fetch_assoc($reqSomme);
			
			$nbPaiements=$enrSomme['nbPaiements'];
			$total=$enrSomme['somme'];
			$contrat_id=$enrSomme['contrat_id'];
			$modePaiement_id=$enrSomme['modePaiement_id'];
			
			if($nbPaiements!=0){
				$montantPaiement=$total/$nbPaiements;
				
				$dateDiff=abs(strtotime($dateFin)-strtotime($dateDebut));
				
				$dateDiff=$dateDiff/(60*60*24);
				
				$joursEntre=floor($dateDiff/$nbPaiements);
				
				//Avant d'update on supprimme les anciens paiements
				$SQL="DELETE FROM paiements
					WHERE contrat_id='$contrat_id' AND conc = 0";
				mysqli_query($link, $SQL);
				
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
			}
			$SQL="UPDATE contrats
				SET typeContrat='NORMAL'
				WHERE client_id='$client_id'";
			mysqli_query($link, $SQL);
		}
	}
	
	
	if(isset($_POST['changementsPaiements'])){
		$tConc=array();
		$tModes=array();
		foreach($_POST as $cle => $valeur){
			if($valeur=='on'){
				$tConc[]=substr($cle,6);
			}else if(is_numeric($valeur)){
				$tModes[$cle]=$valeur;
			}
		}
		
		for($i=0;$i<count($tConc);$i++){
			$paiement_id=$tConc[$i];
			$SQL="UPDATE paiements
				SET conc='1'
				WHERE paiement_id='$paiement_id'";
			mysqli_query($link,$SQL);
		}
		
		foreach($tModes as $paiement_id => $mode_id){
			$SQL="UPDATE paiements
				SET modePaiement_id='$mode_id'
				WHERE paiement_id='$paiement_id'";
				
			mysqli_query($link,$SQL);
		}
	}
	
	
	$SQL="SELECT *
		FROM clients
		JOIN contrats
		ON contrats.client_id=clients.client_id
		WHERE clients.client_id='$client_id'";
	
	$req=mysqli_query($link,$SQL);
	
	if(mysqli_num_rows($req)==0){
		header('location:creerContrat.php?client_id='.$client_id);
		exit();
	}
	
	$enr=mysqli_fetch_assoc($req);
	
	$contrat_id=$enr['contrat_id'];
	
	if(isset($_POST['confirmationSuppression'])){
		$SQL="DELETE FROM contrats
			WHERE client_id='$client_id'";
		mysqli_query($link, $SQL);
		
		$SQL="DELETE FROM paiements
			WHERE contrat_id='$contrat_id'";
		mysqli_query($link, $SQL);
		
		$SQL="DELETE FROM clients
			WHERE client_id='$client_id'";
		mysqli_query($link, $SQL);
	}
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Swann - Facture de <?php echo $enr['nomClient'] ?></title>
<?php
	include_once('_includes/linksEtScripts.inc.php');
?>
<link rel="stylesheet" type="text/css" href="_css/print.css" media="print" />
</head>

<body>

<div class="container">
	<?php
        include_once('_includes/header.inc.php');
    ?>
    
    <div class="content">
   	 	<?php
		$affichage='';
		
		if(isset($erreur)){
			$affichage.='<p>'.$erreur.'</p>';
		}
		
    	//Suppression
        if(isset($_POST['suppression'])){
            $affichage='<form class="formConfirmation" action="#" method="post">
				<div class="field submit">
					<input type="submit" class="btn" value="CONFIRMER LA SUPPRESSION">
				</div>
				<input type="hidden" name="confirmationSuppression">
			</form>';
        }
		
		//Résiliation
        if(isset($_POST['resiliation'])){
            $affichage='<form class="formConfirmation" action="#" method="post">
				<div class="field date">
					<label for="dateResiliation">Date de résiliation</label>
					<input type="date" name="dateResiliation" id="dateResiliation" placeholder="AAAA-MM-JJ">
				</div>
				<input type="submit" class="btn confirmation" value="CONFIRMER LA RÉSILIATION">
				<input type="hidden" name="confirmationResiliation">
			</form>';
        }
		
		//Suspension
        if(isset($_POST['suspension'])){
            $affichage='<form class="formConfirmation" action="#" method="post">
				<div class="field date">
					<label for="dateSuspension">Date de suspension</label>
					<input type="date" name="dateSuspension" id="dateSuspension" placeholder="AAAA-MM-JJ">
				</div>
				<input type="submit" class="btn confirmation" value="CONFIRMER LA SUSPENSION">
				<input type="hidden" name="confirmationSuspension">
			</form>';
        }
		
		//Dé-Suspension
        if(isset($_POST['desuspension'])){
            $affichage='<form class="formConfirmation" action="#" method="post">
				<div class="field date">
					<label for="dateReprise">Date de reprise</label>
					<input type="date" name="dateReprise" id="dateReprise" placeholder="AAAA-MM-JJ">
				</div>
				<div class="field date">
					<label for="dateFin">Date de fin</label>
					<input type="date" name="dateFin" id="dateFin" placeholder="AAAA-MM-JJ">
				</div>
				<input type="submit" class="btn confirmation" value="CONFIRMER LA DÉ-SUSPENSION">
				<input type="hidden" name="confirmationDesuspension">
			</form>';
        }
		
		echo $affichage;
        ?>
    	<h1><img src="SmallLogoBW.png" width="248" height="75" alt="Logo"></h1>
        
        <ul class="floatLeft">
        	<li><b>9232-5893 Québec Inc  (450)657-7926</b></li>
            <li>355 Montée des Pionniers, suite 101</li>
            <li>Terrebonne QUEBEC</li>
            <li>J6V 1N5</li>
       </ul>
       <ul class="floatRight">
            <li><b># Contrat : <?php if ($enr['numeroContrat']) {
				echo $enr['numeroContrat'];
			}else {
				echo 'Aucun';
			}?></b></li>
            <li><b>Durée:     <?php echo $enr['duree'] ?> mois</b></li>
            <li><b># License :   303681</b></li>
        </ul>
        
		<div class="infosMembre">
			<h3>Information du Membre</h3>
			
			<ul class="floatLeft">
				<li><b>Client : </b><?php echo $enr['nomClient'] ?></li>
				<li><b>Adresse : </b><?php echo $enr['adresse'] ?></li>
				<li><b>Ville : </b><?php echo $enr['ville'] ?></li>
				<li><b>Tel : </b><?php echo $enr['telephone'] ?></li>
			</ul>
			
			 <ul class="floatRight">
				<li><b>Né(e) le : </b><?php echo $enr['dateNaissance'] ?></li>
				<li><b>Adresse courriel : </b><?php if ($enr['tag']) { 
					echo $enr['tag'];
				} else {
					echo 'Aucune';
				}?></li>
				<li><b>Code Postal : </b><?php echo $enr['codePostal'] ?></li>
				<li><b>Sexe : </b><?php echo $enr['sexe'] ?></li>
			</ul>
			
			<div class="blocsInfos">
				<div class="detailAbonnement">
					<h3>Détail d'abonnement</h3>
					<ul>
						<li><b>Date Début : </b><?php echo $enr['dateDebut'] ?></li>
						<li><b>Date Fin : </b><?php echo $enr['dateFin'] ?></li>
						<li><b>Durée : </b><?php echo $enr['duree'] ?></li>
						<li><b>Type de contrat : </b><?php
							echo $enr['typeContrat'] ;
							
							if($enr['typeContrat']=='RÉSILIÉ'){
								echo ' en date du '.$enr['dateResiliation'];
							}else if($enr['typeContrat']=='SUSPENDU'){
								echo ' en date du '.$enr['dateSuspension'];
							}
							
							?></li>
						<li><b>Frais d'administration : </b><?php echo '$'.number_format ($enr['fraisAdministration'],2) ?></li>
						<li><b>Coût : </b><?php echo '$'.number_format ($enr['cout'],2) ?></li>
						<li><b>#TVQ 1217330341 : </b><?php echo '$'.number_format ($enr['TPS'],2) ?></li>
						<li><b>#TPS 826555310 : </b><?php echo '$'.number_format ($enr['TVQ'],2) ?></li>
						<li><b>#Total : </b><?php echo '$'.number_format ($enr['total'],2) ?></li>
						<?php if (isset($enr['numeroCarteCredit']) && $enr['numeroCarteCredit'] != '') { ?>
							<li class="cache"><b>#Carte de crédit : </b><?php echo $enr['numeroCarteCredit'] ?></li>
							<li class="cache"><b>Date d'expiration : </b><?php echo $enr['expirationCarteCredit'] ?></li>
							<li class="cache"><b>Numéro de sécurité : </b><?php echo $enr['numSecuriteCarteCredit'] ?></li>
						<?php } ?>
					</ul>
				</div>
				
				<?php
				
				$SQL="SELECT *
					FROM infos";
				$req=mysqli_query($link, $SQL);
				
				$enrInfos=mysqli_fetch_assoc($req);
				
				$description=$enrInfos['descriptionServices'];
				$reglements=$enrInfos['reglements'];
				
				?>
				
				<div class="description<?php if (isset($enr['numeroCarteCredit']) && $enr['numeroCarteCredit'] != '') { ?> avecCarteCredit<?php } ?>">
					<h3>Description des services</h3>
					
					<?php echo '<p>'.$description.'</p>' ?>
				</div>
				
				<div class="methodePaiement">
					<h3>Méthode de paiement</h3>
					<p>Les frais d'administration de: <?php echo '$'.number_format ($enr['fraisAdministration'],2) ?> sont dûs immédiatement.</p>
					<p>Je, soussigné(e), m'engage à payer à 'Centre de Santé 9232-5893 Québec inc' ci-haut indiqué, la somme de :</p>
					<p class="marginLeft"><b>Total : </b><?php echo '$'.number_format ($enr['total'],2) ?></p>
					<p>Ce montant est divisible en montants égaux (minimum de deux) et séparés également dans le temps.</p>
					<form action="#" method="post">
						<table>
							<tbody>
								<tr>
									<th>Date</th>
									<th>Mode</th>
									<th>Montant</th>
									<th>Conc.</th>
								</tr>
								
								<?php
									$contrat_id=$enr['contrat_id'];
									$SQL="SELECT *
										FROM paiements
										WHERE contrat_id='$contrat_id'";
									$reqPaiements=mysqli_query($link, $SQL);
									
									$SQL="SELECT modePaiement_id, modePaiement
										FROM modesPaiements";
										
									$reqModes=mysqli_query($link, $SQL);
									
									if(mysqli_num_rows($reqModes)>0){
										$modes=array();
										while($enrModes=mysqli_fetch_assoc($reqModes)){
											$modes[$enrModes['modePaiement_id']]=$enrModes['modePaiement'];
										}
									}
									
									if(mysqli_num_rows($reqPaiements)==0){
										echo '<p>Il n\'y a pas de paiements reliés à ce contrat</p>';
									}else{
										$affichage='';
										while($enrPaiements=mysqli_fetch_assoc($reqPaiements)){
											
											$affichage.='<tr>';
											
											$affichage.='<td>'.$enrPaiements['datePaiement'].'</td>
												<td>';
												
											   if($enrPaiements['modePaiement_id']==NULL){
													if(isset($modes) && count($modes)>0){
														$affichage.='<select name="'.$enrPaiements['paiement_id'].'"><option></option>';
														foreach($modes as $mode_id => $mode){
															$affichage.='<option value="'.$mode_id.'">'.$mode.'</option>';
														}
														$affichage.='</select>';
													}
												}else{
													$index=$enrPaiements['modePaiement_id'];
													
													$affichage.=$modes[$index];
												}
												
												$affichage.='</td>
												<td>$'.number_format( $enrPaiements['montant'], 2).'</td>
												<td>';
												
												if($enrPaiements['conc']==true){
													$affichage.='Oui';
												}else{
													$affichage.='<input type="checkbox" name="check-'.$enrPaiements['paiement_id'].'">';
												}
												
												$affichage.='</td>';
												$affichage.='</tr>';
										}
										
										echo $affichage;
									}
								?>
								
							</tbody>
						</table>
						<input type="hidden" name="changementsPaiements">
						<div class="conteneurBoutonPaiement"><input class="btn modifierPaiement" type="submit" value="Modifier le paiement"></div>
					</form>
					
				</div>
				
				<div class="reglements">
					<h3>Règlements généraux</h3>
					
					<?php echo '<p>'.$reglements.'</p>' ?>
				</div>
				
				<div class="actionsClient">
					<form action="modifierClient.php?client_id=<?php echo $client_id ?>" method="post">
						<input class="btn" type="submit" value="Modifier ce client/contrat">
					</form>
					<form action="#" method="post">
						<input class="btn" type="submit" value="Supprimer ce client">
						<input type="hidden" name="suppression">
					</form>
					<form action="#" method="post">
						<input class="btn" type="submit" value="Résilier le contrat de ce client">
						<input type="hidden" name="resiliation">
					</form>
					<?php
						if($enr['typeContrat']=='SUSPENDU'){
							$affichage='<form action="#" method="post">
								<input class="btn" type="submit" value="Dé-Suspendre le contrat de ce client">
								<input type="hidden" name="desuspension">
								</form>';
						}else{
							$affichage='<form action="#" method="post">
								<input class="btn" type="submit" value="Suspendre le contrat de ce client">
								<input type="hidden" name="suspension">
								</form>';
						}
						echo $affichage;
					?>
				</div>
			</div>
		</div>
        
    </div><!-- CONTENT -->
	
	<?php
		include('_includes/footer.inc.php');
	?>

</div>

</body>
</html>