<?php
session_start();
		// récupération des variables 
	$nDossier =  $_SESSION['nDossier'] ;
	$discipline = $_POST['inp_discipline'];
	$titre = "Liste des épreuves associées au dossier $nDossier pour la discipline $discipline, et nombre de billets pour chacune";
	include('entete.php');

	// construction de la requete permetant de sortir les billets corespondent à la discpline et au dossier fournie 
	$requete = ("
SELECT nepreuve, nome, to_char(dateepreuve, 'Day, DD-MM-YYYY'), count(*) 
	FROM JO_INF245.LesBillets B natural join JO_INF245.Lesepreuves B join Lesdossiers using (ndossier) 	
	WHERE nDossier = :n and lower(discipline) = lower(:d)  
	group by nepreuve, nome, dateepreuve 
	");
	// analyse de la requete et association au curseur
	$curseur = oci_parse ($lien, $requete) ;

	// affectation de la variable
	oci_bind_by_name ($curseur, ":d", $discipline);
	oci_bind_by_name ($curseur, ":n", $nDossier);
	// execution de la requete
	$ok = @oci_execute ($curseur) ;

	// on teste $ok pour voir si oci_execute s'est bien passé
	if (!$ok) {
echo( $discipline );
		// oci_execute a échoué, on affiche l'erreur
		$error_message = oci_error($curseur);
		echo "<p class=\"erreur\">{$error_message['message']}</p>";

	}
	else {
		// oci_execute a réussi, on fetch sur le premier résultat
		$res = oci_fetch ($curseur);

		if (!$res) {

			// il n'y a aucun résultat
			echo "<p class=\"erreur\"><b>Aucune place associée à cette discipline ou discipline inconnue</b></p>" ;

		}
		else {

			// on affiche la table qui va servir a la mise en page du resultat
			echo "<table><tr><th>Numéro</th><th>Nom</th><th>Date</th><th>Nb billets</th></tr>" ;

			// on affiche un résultat et on passe au suivant s'il existe
			do {

				$noEpreuve = oci_result($curseur, 1) ;
				$nom= oci_result($curseur, 2) ;
				$dateEp = oci_result($curseur, 3) ;
                $nb  = oci_result($curseur, 4) ;
				echo "<tr><td>$noEpreuve</td><td>$nom</td><td>$dateEp</td><td>$nb</td></tr>";

			} while (oci_fetch ($curseur));

			echo "</table>";
		}

	}

	// on libère le curseur
	oci_free_statement($curseur);

	include('pied.php');

?>

