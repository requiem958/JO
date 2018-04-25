<?php
$titre = 'Affichage des épreuves sans billets vendus';
include('entete.php');

$requete = 'with EpVide as (
	select nEpreuve from LesEpreuves minus select nEpreuve from LesBillets
	)select distinct nomE from lesEpreuves natural join EpVide';

// analyse de la requete et association au curseur
	$curseur = oci_parse ($lien, $requete) ;
	// execution de la requete
	$ok = @oci_execute ($curseur) ;
	// on teste $ok pour voir si oci_execute s'est bien passé
	if (!$ok) {
		// oci_execute a échoué, on affiche l'erreur
		$error_message = oci_error($curseur);
		echo "<p class=\"erreur\">{$error_message['message']}</p>";
	}
	else {
		// oci_execute a réussi, on fetch sur le premier résultat
		$res = oci_fetch ($curseur);
		if (!$res) {
			// il n'y a aucun résultat
			echo "<p class=\"erreur\"><b>Aucune epreuve sans resa dans la base de données</b></p>" ;
		}
		else {
			echo "<table><tr><th>Epreuve</th></tr>";
			// on affiche un résultat et on passe au suivant s'il existe
			do {

				$nomEpreuve = oci_result($curseur, 1) ;
				echo "<tr><td>$nomEpreuve</td></tr>";

			} while (oci_fetch ($curseur));

			echo "</table>";
		}
	}
	// on libère le curseur
	oci_free_statement($curseur);
          
include('pied.php');
?>
