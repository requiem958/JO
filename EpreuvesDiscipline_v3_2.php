<?php
session_start;
	// récupération des variables
	$nDossier = $_POST['nDossier'];
	$titre = "Discpline liée au dossier $nDossier";
	include('entete.php');

	// construction de la requete
	$requete = ("
		SELECT  distinct discipline FROM JO_INF245.LesBillets natural join JO_INF245.LesEpreuves join lesdossiers using(ndossier) WHERE nDossier = :n
	");
	// analyse de la requete et association au curseur
	$curseur = oci_parse ($lien, $requete) ;
	// affectation de la variable
	oci_bind_by_name ($curseur,':n', $nDossier);
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
			echo "<p class=\"erreur\"><b> Discipline inconnue </b></p>" ;
		}
		else {
			// on affiche la liste
		echo ("
          <form action=\"EpreuvesDiscipline_v3_3.php\" method=\"POST\">
          <label for=\"inp_discipline\">Veuillez choisir une discipline :</label>
                    <select name=\"inp_discipline\">"		);
			// on affiche un résultat et on passe au suivant s'il existe
			do {
				$discipline = oci_result($curseur,1) ;
				echo "<option value=\"$discipline\">".$discipline."</option>\n";
			} while (oci_fetch ($curseur));
		}
         echo(" </select>
          <br /><br />
          <input type=\"submit\" value=\"Valider\" />
          <input type=\"reset\" value=\"Annuler\" />
          </form>
          ");
	   }
	// on libère le curseur
	oci_free_statement($curseur);

	include('pied.php');

?>

