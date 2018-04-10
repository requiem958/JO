<?php

	$titre = 'Contenu des relations fournies';
	include('entete.php');

	// définition des relations
$lesRelations = array ("JO.LesBatiments", "JO.LesDisciplines", "JO.LesEpreuves", "JO.LesEquipes", "JO.LesInscriptions", "JO.LesLocataires", "JO.LesLogements", "JO.LesResultats", "JO.LesSportifs", "JO.LesBillets", "JO.LesDossiers_base", "JO.LesDossiers" );

// définition des attributs
$lesSchemas = array ("JO.LesBatiments"  => array("nomBat","numero", "rue", "ville"),
             "JO.LesDisciplines" => array ("discipline"),
		     "JO.LesEpreuves" => array("nEpreuve", "nomE", "forme", "discipline", "categorie", "nbs", "dateEpreuve"),
		     "JO.LesEquipes" => array("nEquipe", "nSportif"),
		     "JO.LesInscriptions" => array("nInscrit", "nEpreuve"),
		     "JO.LesLocataires" => array("nSportif", "nLogement", "nomBat"),
		     "JO.LesLogements" => array("nLogement", "capacite", "nomBat"),
		     "JO.LesResultats" => array("nEpreuve", "gold", "silver", "bronze"),
             "JO.LesSportifs" => array("nSportif", "nomS", "prenomS", "pays", "categorie", "dateNais"),
             "JO.LesBillets"  => array("nDossier", "nBillet","nEpreuve"),
             "JO.LesDossiers_base" => array("nDossier", "nUtil", "dateEmission"),
             "JO.LesDossiers" => array("nDossier", "nUtil", "dateEmission", "prix")
	);

	// pour chaque relation
	foreach ($lesRelations as $uneRelation) {
		// construction de la requête
		$requete = "select * from $uneRelation ORDER BY {$lesSchemas[$uneRelation][0]}";
		// analyse de la requete et association au curseur
		$curseur = oci_parse ($lien, $requete) ;
		// execution de la requete
		oci_execute ($curseur);
		if (!($row = oci_fetch_assoc ($curseur))) {
			// le resultat est vide
			echo "<p><b>La relation ".$uneRelation." est vide </b></p>" ;
		}
		else {
			// création de la table qui va servir a la mise en page du resultat
			echo "<p><table> <tr><th> ".$uneRelation." </th></tr><tr>" ;
			foreach ($lesSchemas[$uneRelation] as $unAttr)
				echo "<td><th> ".$unAttr." </th></td>";
			echo "</tr>";
			// Affichage du resultat (non vide)
			do {
				echo "<tr>";
				foreach ($lesSchemas[$uneRelation] as $unAttr) {
				  echo "<td> ".$row[strtoupper($unAttr)]." </td>";
				}
				echo "</tr>";
			} while ($row = oci_fetch_assoc ($curseur));
			echo "</table></p>";
		}
		oci_free_statement($curseur);
	}
	include('pied.php');
?>
