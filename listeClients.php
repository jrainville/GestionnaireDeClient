<?php
	
	setlocale (LC_TIME, 'fr_FR');

	include_once('_scripts/config.php');
	include_once('_includes/verifConnexion.php');
	
	$SQL = "SELECT nomClient, clients.client_id, dateDebut, dateFin, datePaiement, typeContrat, tag, dateNaissance
		FROM clients
		JOIN contrats
		ON clients.client_id=contrats.client_id
		JOIN paiements
		ON paiements.contrat_id=contrats.contrat_id
		WHERE conc=0
		ORDER BY datePaiement ASC";
			
	$req = mysqli_query($link,$SQL);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Liste de client(e)s</title>
<?php
	include_once('_includes/linksEtScripts.inc.php');
?>

<script>
	
	$(document).ready(function() {
	   $('#listeClients').DataTable({
			"order": [[ 1, "asc" ]],
			"lengthMenu": [[25, 50, -1], [25, 50, "Tous"]],
			"language": {
				"sProcessing":     "Traitement en cours...",
				"sSearch":         "Rechercher&nbsp;:",
				"sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
				"sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
				"sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
				"sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
				"sInfoPostFix":    "",
				"sLoadingRecords": "Chargement en cours...",
				"sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
				"sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
				"oPaginate": {
					"sFirst":      "Premier",
					"sPrevious":   "Pr&eacute;c&eacute;dent",
					"sNext":       "Suivant",
					"sLast":       "Dernier"
				},
				"oAria": {
					"sSortAscending":  ": activer pour trier la colonne par ordre croissant",
					"sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
				}
		   }
		});
		   
		$('#toutSelectionner').click(function () {
			$('.envoiEmail').prop('checked', true);
		});
		   
		$('#toutDeselectionner').click(function () {
			$('.envoiEmail').prop('checked', false);
		});
		
		$('#copierAdresses').click(function () {
			var listeAdresses = '';
			$('.envoiEmail:checked').each(function () {
				listeAdresses += $(this).val() + ' ';
			});
			window.prompt("Copier les adresses: Ctrl+C, Enter", listeAdresses);
		});
	} );

</script
</head>

<body>

<div class="container">
	<?php
        $listeClients='active';
        include_once('_includes/header.inc.php');
    ?>
    
    <div class="content">
    	<h1>Liste de clients</h1>
        
		<button class="btn" id="toutSelectionner">Tout sélectionner</button>
		<button class="btn" id="toutDeselectionner">Tout Désélectionner</button>
		<button class="btn" id="copierAdresses">Copier les adresses courriel</button>
		
        <?php
		
			$tEtats=array(
				'normal'=>'Normal',
				'bientot'=>'Bientôt expi.',
				'expire'=>'Expiré',
				'resilie'=>'Résilié',
				'suspendu'=>'Suspendu',
			);
			
			$affichage='';
			
			$delaiJours=30;
			
			if(mysqli_num_rows($req)!=0){
				$affichage.='<table class="listeClients" id="listeClients">
					<thead>
						<tr>
							<th>Envoyer<br>courriel</th>
							<th>Client(e)</th>
							<th>Courriel</th>
							<th>Date de naissance</th>
							<th>Mois de naissance</th>
							<th>État</th>
						</tr>
					</thead>
					<tbody>';
				
				$tPaiements=array();
				
				while($enr=mysqli_fetch_assoc($req)){
					if(!in_array($enr['client_id'], $tPaiements)){
						$tPaiements[]=$enr['client_id'];
						$client_id=$enr['client_id'];
						$class='normal';						
						
						if($enr['typeContrat']=='RÉSILIÉ'){
							$class='resilie';
						}else if($enr['typeContrat']=='SUSPENDU'){
							$class='suspendu';
						}else{						
							//Fin contrat
							$datejour = date('d/m/Y');
							
							//la date du fin est stocké dans une base de données
								//on extracte la date du fin depuis la bdd et on la met dans une variable $datefin
							$datefin= date('Y-m-d', strtotime($enr['dateFin'].' -'.$delaiJours.' days')); ;  
							
							//explode pour mettre la date du fin en format numerique: 12/05/2006  -> 12052006
							$dfin = explode("-", $datefin); 
							
							//explode pour mettre la date du jour en format numerique: 31/05/2009  -> 31052009
							$djour = explode("/", $datejour); 
							
							// concaténation pour inverser l'ordre: 12052006 -> 20060512
							$finab = $dfin[0].$dfin[1].$dfin[2]; 
							// concaténation pour inverser l'ordre: 31052009 -> 20090531
							$auj = $djour[2].$djour[1].$djour[0];
							
							// Ensuite il suffit de comparer les deux valeurs
							
							if ($auj>$finab){
							//------Abonnement expiré;-------
								$class='bientot';
							}
							
							
							//Fin contrat
							$datejour = date('d/m/Y');
							//la date du fin est stocké dans une base de données
								//on extracte la date du fin depuis la bdd et on la met dans une variable $datefin
							$datefin= $enr['dateFin'];  
							
							//explode pour mettre la date du fin en format numerique: 12/05/2006  -> 12052006
							$dfin = explode("-", $datefin); 
							
							//explode pour mettre la date du jour en format numerique: 31/05/2009  -> 31052009
							$djour = explode("/", $datejour); 
							
							// concaténation pour inverser l'ordre: 12052006 -> 20060512
							$finab = $dfin[0].$dfin[1].$dfin[2]; 
								// concaténation pour inverser l'ordre: 31052009 -> 20090531
							$auj = $djour[2].$djour[1].$djour[0]; 
							
							// Ensuite il suffit de comparer les deux valeurs
							
							if ($auj>$finab){
							//------Abonnement expiré;-------
								$class='expire';
							}
						}
						
						$etat=$tEtats[$class];
						
						$affichage.='<tr>
							<td><input type="checkbox" class="envoiEmail" value="'.$enr['tag'].'"></td>
							<td>
								<a href="facture.php?client_id='.$client_id.'">'.$enr['nomClient'].'</a>
							</td>
							<td><a href="mailto:'.$enr['tag'].'">'.$enr['tag'].'</a></td>
							<td>'.$enr['dateNaissance'].'</td>
							<td>'.ucwords(utf8_encode(strftime ("%m - %B",strtotime($enr['dateNaissance'])))).'</td>
							<td class="'.$class.' etat">'.$etat.'</td>
							</tr>';
					}//IF
				}//WHILE
				
				$SQL="SELECT nomClient, clients.client_id, dateDebut, dateFin, tag, dateNaissance
					FROM clients
					JOIN contrats
					ON clients.client_id=contrats.client_id
					ORDER BY nomClient";
				
				$reqClients=mysqli_query($link, $SQL);
				
				while($enrClients=mysqli_fetch_assoc($reqClients)){
					if(!in_array($enrClients['client_id'], $tPaiements)){
						$tPaiements[]=$enrClients['client_id'];
						$client_id=$enrClients['client_id'];
						$class='normal';						
						
						if($enr['typeContrat']=='RÉSILIÉ'){
							$class='resilie';
						}else if($enr['typeContrat']=='SUSPENDU'){
							$class='suspendu';
						}else{			
							//Fin contrat
							$datejour = date('d/m/Y');
							
							//la date du fin est stocké dans une base de données
								//on extracte la date du fin depuis la bdd et on la met dans une variable $datefin
							$datefin= date('Y-m-d', strtotime($enrClients['dateFin'].' -'.$delaiJours.' days')); ;  
							
							//explode pour mettre la date du fin en format numerique: 12/05/2006  -> 12052006
							$dfin = explode("-", $datefin); 
							
							//explode pour mettre la date du jour en format numerique: 31/05/2009  -> 31052009
							$djour = explode("/", $datejour); 
							
							// concaténation pour inverser l'ordre: 12052006 -> 20060512
							$finab = $dfin[0].$dfin[1].$dfin[2]; 
							// concaténation pour inverser l'ordre: 31052009 -> 20090531
							$auj = $djour[2].$djour[1].$djour[0];
							
							// Ensuite il suffit de comparer les deux valeurs
							
							if ($auj>$finab){
							//------Abonnement expiré;-------
								$class='bientot';
							}
							
							
							//Fin contrat
							$datejour = date('d/m/Y');
							//la date du fin est stocké dans une base de données
								//on extracte la date du fin depuis la bdd et on la met dans une variable $datefin
							$datefin= $enrClients['dateFin'];  
							
							//explode pour mettre la date du fin en format numerique: 12/05/2006  -> 12052006
							$dfin = explode("-", $datefin); 
							
							//explode pour mettre la date du jour en format numerique: 31/05/2009  -> 31052009
							$djour = explode("/", $datejour); 
							
							// concaténation pour inverser l'ordre: 12052006 -> 20060512
							$finab = $dfin[0].$dfin[1].$dfin[2]; 
								// concaténation pour inverser l'ordre: 31052009 -> 20090531
							$auj = $djour[2].$djour[1].$djour[0]; 
							
							// Ensuite il suffit de comparer les deux valeurs
							
							if ($auj>$finab){
							//------Abonnement expiré;-------
								$class='expire';
							}
						}
						
						$etat=$tEtats[$class];
						
						$affichage.='<tr>
							<td><input type="checkbox" class="envoiEmail" value="'.$enrClients['tag'].'"></td>
							<td>
								<a href="facture.php?client_id='.$enrClients['client_id'].'">'.$enrClients['nomClient'].'</a>
							</td>
							<td><a href="mailto:'.$enrClients['tag'].'">'.$enrClients['tag'].'</a></td>
							<td>'.$enrClients['dateNaissance'].'</td>
							<td>'.ucwords(utf8_encode(strftime ("%m - %B",strtotime($enrClients['dateNaissance'])))).'</td>
							<td class="'.$class.'">'.$etat.'</td>
							</tr>';
					}
				}
	
				$SQL2 = "SELECT nomClient, clients.client_id, tag, dateNaissance
						FROM clients
						LEFT JOIN contrats
						ON clients.client_id=contrats.client_id
						WHERE contrat_id IS NULL";
						
				$req2 = mysqli_query($link, $SQL2);
				
				while($enr2 = mysqli_fetch_assoc($req2)){
					$affichage.='<tr>
						<td><input type="checkbox" class="envoiEmail" value="'.$enr2['tag'].'"></td>
						<td>
							<a href="facture.php?client_id='.$enr2['client_id'].'">'.$enr2['nomClient'].'</a>
						</td>
						<td><a href="mailto:'.$enr2['tag'].'">'.$enr2['tag'].'</a></td>
						<td>'.$enr2['dateNaissance'].'</td>
						<td>'.ucwords(utf8_encode(strftime ("%m - %B",strtotime($enr2['dateNaissance'])))).'</td>
						<td class="sansContrat">Sans contrat</td>
						</tr>';
				}
				
				$affichage.='</tbody>
					</table>';
				echo $affichage;
			}else{
				echo '<p>Il n\'y a pas de clients</p>';
			}
			
			
		?>
        
    </div><!--Content-->
	
	<?php
		include('_includes/footer.inc.php');
	?>

</div>

</body>
</html>