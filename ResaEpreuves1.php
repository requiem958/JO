<?php
	$titre = 'Infos dossier (2 curseur)';
	include('entete.php');

	$requete1 = 'select nDossier, dateEmission from LesDossiers order by ndossier';
	$curseur1 = oci_parse ($lien, $requete1) ;
	$ok = @oci_execute ($curseur1) ;
	if (!$ok) {
		$error_message = oci_error($curseur);
		echo "<p class=\"erreur\">{$error_message['message']}</p>";
	}
	else {
		if (!oci_fetch($curseur1)) {
			echo "<p><b>Il n'y a aucun dossier !</b></p>" ;
		}
		else{
			do {
				$num = oci_result($curseur1,1);
				$date = oci_result($curseur1,2);
				echo "<p>Dossier n°".$num." émis à la date du : ".$date."\n";
				$requete2 = 'select nBillet, nEpreuve, nomE, dateEpreuve from lesBillets natural join Lesepreuves where nDossier = :n order by nBillet, nEpreuve, dateEpreuve';
				// analyse de la requete et association au curseur
				$curseur2 = oci_parse ($lien, $requete2) ;

				// affectation de la variable
				oci_bind_by_name ($curseur2,':n', $num);

				// execution de la requete
				$ok = @oci_execute ($curseur2);

				// on teste $ok pour voir si oci_execute s'est bien passé
				if (!$ok) {

					// oci_execute a échoué, on affiche l'erreur
					$error_message = oci_error($curseur2);
					echo "<p class=\"erreur\">{$error_message['message']}</p>";

				}
				else{
					if (!oci_fetch($curseur2)){
						echo "<p><b>Il n'y a aucune resa pour ce dossier !</b></p>" ;
					}
					else{
						echo "<table><tr><th>N°Billet</th><th>N°Epreuve</th><th>Nom Epreuve</th><th>dateEpreuve</th></tr>";
						// on affiche un résultat et on passe au suivant s'il existe
						do {

							$nBillet = oci_result($curseur2, 1) ;
							$nEpreuve = oci_result($curseur2, 2) ;
							$nomE = oci_result($curseur2, 3) ;
							$date = oci_result($curseur2, 4) ;
							echo "<tr><td>$nBillet</td><td>$nEpreuve</td><td>$nomE</td><td>$date</td></tr>";

						} while (oci_fetch ($curseur2));

						echo "</table>";
					}
				}
				echo "</p>\n";
			}while(oci_fetch($curseur1));
		}
	}while(oci_fetch($curseur1));
	include('pied.php');
?>

