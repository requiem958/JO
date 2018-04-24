<?php
	$titre = 'Infos dossier (1 curseur)';
	include('entete.php');

	$requete1 = 'select nDossier,nBillet, nomE, dateEpreuve from lesBillets natural join lesepreuves order by Ndossier, nBillet';
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
			$last_num = oci_result($curseur1,1);
			do {
				$num = oci_result($curseur1,1);
				$date = oci_result($curseur1,2);
				$nBillet = oci_result($curseur2, 1) ;
				$nEpreuve = oci_result($curseur2, 2) ;
				$nomE = oci_result($curseur2, 3) ;
				$dateE = oci_result($curseur2, 4) ;
				if ($num != $last_num)
				{
					echo "</table></p>\n<p>Dossier n°".$num." émis à la date du : ".$date."\n";
					echo "<table><tr><th>N°Billet</th><th>N°Epreuve</th><th>Nom Epreuve</th><th>dateEpreuve</th></tr>";
					$last_num = $num;
				}
				echo "<tr><td>$nBillet</td><td>$nEpreuve</td><td>$nomE</td><td>$dateE</td></tr>\n";
			}while(oci_fetch($curseur1));
		}
	}
	include('pied.php');
?>

