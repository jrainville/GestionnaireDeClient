<?php
	$affichage='<header>
	
		<nav>
			<ul>
				<li><a href="index.php" class="';
				if(isset($index)) $affichage.=$index;
				$affichage.='">Liste de contrats</a></li>
				
				<li><a href="listeClients.php" class="';
				if(isset($listeClients)) $affichage.=$listeClients;
				$affichage.='">Liste de client(e)s</a></li>
				
				<li><a href="creerClient.php" class="';
				if(isset($creerClient)) $affichage.=$creerClient;
				$affichage.='">Ajouter un(e) client(e)</a></li>
				
				<li><a href="creerContrat.php" class="';
				if(isset($creerContrat)) $affichage.=$creerContrat;
				$affichage.='">Créer un contrat</a></li>
				
				<li><a href="ajouterModePaiement.php" class="';
				if(isset($ajouterModePaiement)) $affichage.=$ajouterModePaiement;
				$affichage.='">Ajouter un mode de paiement</a></li>
				
				<li><a href="changerInfos.php" class="';
				if(isset($changerInfos)) $affichage.=$changerInfos;
				$affichage.='">Changer la descr. et les regl.</a></li>
			</ul>
		</nav>
		
	</header>';
	
	echo $affichage;
?>