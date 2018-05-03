<?php session_start();
	
	$titre = 'Ventes de billets';
	include('entete.php');
	
	if(isset($_POST['validVente'])){
		$requete = 'insert into LesDossiers_base values( :nDossier, :nUtil, sysdate() )';
		$curseur = oci_parse($lien,$requete);
		oci_bind_by_name($curseur, 'nDossier', $_SESSION['nDossier']);
		oci_bind_by_name($curseur, 'nUtil', $_SESSION['nUtil']);
		$ok = @oci_execute ($curseur) ;

		// on teste $ok pour voir si oci_execute s'est bien passé
		if (!$ok) {
			// oci_execute a échoué, on affiche l'erreur
			$error_message = oci_error($curseur);
			echo "<p class=\"erreur\">{$error_message['message']}</p>";

		}
		else {
			oci_free_statement($curseur);
			$curseur = oci_parse($lien,'select max(nBillet)+1 from Lesbillets');
			$ok = @oci_execute ($curseur) ;

			// on teste $ok pour voir si oci_execute s'est bien passé
			if (!$ok) {
				// oci_execute a échoué, on affiche l'erreur
				$error_message = oci_error($curseur);
				echo "<p class=\"erreur\">{$error_message['message']}</p>";

			}
			else {
				if (!oci_fetch($curseur))
					$nBillet = 0;
				else
					$nBillet = oci_result($curseur);

				oci_free_statement($curseur);

				var_dump($_POST['epreuve']);
			}
		}
	}
	else
		echo "<p>Vous n'avez rien à faire ici.</p>";

	oci_free_statement($curseur);
	include('pied.php');
?>
