<?php
	$titre = 'Liste des épreuves associées au dossier 2 pour une discipline donnée, et nombre de billets pour chacune';
	include('entete.php');
	
		$requete = ("
		SELECT discipline from JO_INF245.LesDisciplines order by 1
	");
	// analyse de la requete et association au curseur
	$curseur = oci_parse ($lien, $requete) ;
	// affectation de la variable
	oci_bind_by_name ($curseur,':d', $d);
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
          <form action=\"EpreuvesDiscipline_action.php\" method=\"POST\">
          <label for=\"inp_discipline\">Veuillez choisir une discipline :</label>
                    <select name=\"inp_discipline\">"		);
			// on affiche un résultat et on passe au suivant s'il existe
			do {
				$discipline = oci_result($curseur,1) ;
				echo "<option value=\"$discipline\">".$discipline."</option>";
			} while (oci_fetch ($curseur));
		}
	}
         echo(" </select>
          <br /><br />
          <input type=\"submit\" value=\"Valider\" />
          <input type=\"reset\" value=\"Annuler\" />
          </form>
          ");
   
// travail à réaliser
echo (" <p class=\"work\">
      Améliorez l'interface utilisateur en proposant, à la place du champ de saisie libre, un choix dans une liste contenant toutes les disciplines (sous forme de boite de sélection ou de boutons radio).
      Cette fois-ci, la liste sera extraite de la base de données. </p>
");
          	// on libère le curseur
	oci_free_statement($curseur);
	include('pied.php');                      
?>
