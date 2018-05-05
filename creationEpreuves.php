
<?php
	$nome=$_POST['NomE'];
	$date=$_POST['Date'];
	$categorie=$_POST['categorie'];
	$prix=$_POST['Prix'];
	$forme=$_POST['forme'];
	$disc=$_POST['Disc'];
	$discipline=$_POST['inp_discipline'];
	$nbs=$_POST['nbs'];
	if ($discipline =="" ||$nome=="" || $date=="" || $prix=="" || $nbs =="" ){
		$titre = "Erreur un champ est vide";
		include('entete.php');
		include('pied.php');
	}
	else {
		if ($discipline =="0"){
			$discipline=$disc;
			$requete1 = "INSERT INTO LesDisciplines values ':d'";
			// analyse de la requete et association au curseur
			$curseur = oci_parse ($lien, $requete1) ;
			// affectation de la variable
			oci_bind_by_name ($curseur,':d', $discipline);
			// execution de la requete
			$ok = @oci_execute ($curseur) ;
			if (!$ok) {
				echo LeMessage ("majRejetee") ;
				// terminaison de la transaction : annulation
				oci_rollback ($lien) ;
			}	else {
				echo LeMessage ("maj OK") ;
				// terminaison de la transaction : validation
				oci_commit ($lien) ;
			}
		}

		$titre = "L'épreuve  $nome ,$categorie ,$forme($nbs) ,$discipline ,$date , $prix à été crée ";
		include('entete.php');
		 $requete = ("
		SELECT max(Nepreuve) from Lesepreuves
		");
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
		$nepreuve = $requete+1;
	
		$requete2 = "INSERT INTO LesEpreuves values (:nepreuve, ':nome', ':forme', ':discipline', ':categorie', :nbs, to_date(':date', 'DD-MM-YYYY'), )";
		// analyse de la requete et association au curseur
		$curseur = oci_parse ($lien, $requete2) ;
		// affectation de la variable
		oci_bind_by_name ($curseur,':nepreuve', $nepreuve);
		oci_bind_by_name ($curseur,':nome', $nome);
		oci_bind_by_name ($curseur,':forme', $forme);
		oci_bind_by_name ($curseur,':discipline', $discipline);
		oci_bind_by_name ($curseur,':categorie', $categorie);
		oci_bind_by_name ($curseur,':nbs', $nbs);
		oci_bind_by_name ($curseur,':date', $date);
		// execution de la requete
		$ok = @oci_execute ($curseur) ;
			if (!$ok) {
				echo LeMessage ("majRejetee") ;
				// terminaison de la transaction : annulation
				oci_rollback ($lien) ;
			}	else {
				echo LeMessage ("maj OK") ;
				// terminaison de la transaction : validation
				oci_commit ($lien) ;
			}
	}
	// on libère le curseur
	oci_free_statement($curseur);
	include('pied.php');
}

?>
