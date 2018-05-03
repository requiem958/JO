<?php session_start();
	
	$titre = 'Ventes de billets';
	include('entete.php');
	$nBillet = 0;
	if(isset($_POST['validVente'])){
		//echo $_SESSION['nDossier']." et ". $_SESSION['nUtil'];
		$requete = 'INSERT INTO LesDossiers_base values (:nUtil,:nDossier,sysdate)';
		$curseur = oci_parse($lien,$requete);
		oci_bind_by_name($curseur, ':nDossier', $_SESSION['nDossier']);
		oci_bind_by_name($curseur, ':nUtil', $_SESSION['nUtil']);
		$ok = @oci_execute ($curseur) ;

		// on teste $ok pour voir si oci_execute s'est bien passé
		if (!$ok) {
			echo "<p>Erreur insertion dossier</p>";
			// oci_execute a échoué, on affiche l'erreur
			$error_message = oci_error($curseur);
			echo "<p class=\"erreur\">{$error_message['message']}</p>";
			oci_rollback($lien);

		}
		
		else {
			$curseur = oci_parse($lien,'select max(nBillet)+1 from Lesbillets');
			$ok = @oci_execute ($curseur,OCI_NO_AUTO_COMMIT) ;

			// on teste $ok pour voir si oci_execute s'est bien passé
			if (!$ok) {
				echo "<p>Erreur selection billet</p>";
				// oci_execute a échoué, on affiche l'erreur
				$error_message = oci_error($curseur);
				echo "<p class=\"erreur\">{$error_message['message']}</p>";
				oci_rollback($lien);
			}
			
			else {
				//var_dump($_POST);
				//echo "<br/><br/>";
				if (!oci_fetch($curseur))
					$nBillet = 0;
				else
					$nBillet = oci_result($curseur,1);
				//Iteration sur toutes les epreuves demandées

				$curseur = oci_parse($lien,'INSERT INTO LesBillets values(:nBillet,:nDossier,:nEpreuve)');
				
				foreach($_POST['epreuve'] as $key => $epreuve ){
					
					if ($epreuve['name'] == "on"){
						$nbBillet = $epreuve['nbBillet'];
						
						//Ajout de autant de billets que demandés
						for ($i=0; $i < $nbBillet; $i++){
							echo "$nBillet;";
							oci_bind_by_name($curseur, ':nBillet', $nBillet);
							$nBillet = $nBillet + 1;
							
							oci_bind_by_name($curseur, ':nDossier', $_SESSION['nDossier']);
							oci_bind_by_name($curseur, ':nEpreuve', $key);

							$ok = @oci_execute ($curseur,OCI_NO_AUTO_COMMIT) ;
							if (!$ok) {
								echo "<p>Erreur insertion billet : $key : $nBillet : ".$_SESSION['nDossier'].".</p><br/>";
								// oci_execute a échoué, on affiche l'erreur
								$error_message = oci_error($curseur);
								echo "<p class=\"erreur\">{$error_message['message']}</p>";

								oci_rollback($lien);

								oci_free_statement($curseur);
								
								include('pied.php');
								return;

							}
							
						}
					}
				}
			}
				//oci_commit($lien);
		}
	}
	else{
		echo "<p>Vous n'avez rien à faire ici.</p>";
		include('pied.php');
		return;
	}

	oci_free_statement($curseur);

	include('pied.php');
?>
