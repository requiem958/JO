<?php
	$nome=$_POST['NomE'];
	$datep=$_POST['Datep'];
	$categorie=$_POST['categorie'];
	$prix=$_POST['Prix'];
	$forme=$_POST['forme'];
	$disc=$_POST['Disc'];
	$discipline=$_POST['inp_discipline'];
	$nbs=$_POST['nbs'];
	if ( $discipline=="0" and $disc==""  || $nome=="" || $datep=="" || $prix=="" || $nbs =="" ){ // cas ou il nous manque un arguments
		$titre = "Erreur un champ est vide";
		include('entete.php');
		include('pied.php');
	} 
	else {
		if ($discipline =="0"){  // cas ou on crée une nouvelle disciplines
			$count=1;  //conteur permetant de savoir si nous sommes passez par cette boucle
			$discipline=$disc;//on assigne à discipline la valeur saisie par l'utilisateur
			$titre = "L'épreuve  $nome ,$categorie ,$forme($nbs) ,$discipline ,$datep , $prix à été crée ";
			include('entete.php');
			$requete1 = "INSERT INTO LesDisciplines values (:d )"; //requetes pour insérer une nouvelle discipline
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
				echo (" tout vas bien ") ;
				// terminaison de la transaction : validation
				oci_commit ($lien) ;
			}
		}
		if ($count!=1){  // puisque nous somme pas passez plus haut on execute ici le titre
		$titre = "L'épreuve  $nome ,$categorie ,$forme($nbs) ,$discipline ,$datep , $prix à été crée ";
		include('entete.php');
		}
		 $requete = ("
		SELECT max(Nepreuve)+1 from Lesepreuves
		"); // on récupére le nepreuve au quels on est et on ajoute 1 pour celui qu'on va crée 
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
		oci_fetch ($curseur);
		$nepreuve= oci_result($curseur,1);
		$requete2 = "INSERT INTO LesEpreuves values (:nepreuve, :nome, :forme, :discipline, :categorie, :nbs, to_date(:datep, 'DD-MM-YYYY'),:prix)";
		// analyse de la requete et association au curseur
		$curseur = oci_parse ($lien, $requete2) ;
		// affectation des variables
		oci_bind_by_name ($curseur,':nepreuve', $nepreuve);
		oci_bind_by_name ($curseur,':nome', $nome);
		oci_bind_by_name ($curseur,':forme', $forme);
		oci_bind_by_name ($curseur,':discipline', $discipline);
		oci_bind_by_name ($curseur,':categorie', $categorie);
		oci_bind_by_name ($curseur,':nbs', $nbs);
		oci_bind_by_name ($curseur,':datep', $datep);
		oci_bind_by_name ($curseur,':prix', $prix);
		// execution de la requete
		$ok = @oci_execute ($curseur,OCI_NO_AUTO_COMMIT) ;
			if (!$ok) {
				echo LeMessage ("majRejetee") ;
				// terminaison de la transaction : annulation
				oci_rollback ($lien) ;
			}	else {
				echo (" confirmation de la creation ") ;
				// terminaison de la transaction : validation
				oci_commit ($lien) ;
			}

	// on libère le curseur
	oci_free_statement($curseur);
	include('pied.php');
	}

?>
