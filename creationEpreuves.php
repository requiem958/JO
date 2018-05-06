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
<<<<<<< HEAD
	} 
	else {
		if ($discipline =="0"){  // cas ou on crée une nouvelle disciplines
			$count=1;  //conteur permetant de savoir si nous sommes passez par cette boucle
			$discipline=$disc;//on assigne à discipline la valeur saisie par l'utilisateur
			$titre = "L'épreuve  $nome ,$categorie ,$forme($nbs) ,$discipline ,$datep , $prix à été crée ";
			include('entete.php');
			$requete1 = "INSERT INTO LesDisciplines values (:d )"; //requetes pour insérer une nouvelle discipline
=======
	}
	else {
		if ($discipline =="0"){
			$discipline=$disc;
			$requete1 = "INSERT INTO LesDisciplines values ':d'";
>>>>>>> JO2
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
<<<<<<< HEAD
				echo (" tout vas bien ") ;
=======
				echo LeMessage ("maj OK") ;
>>>>>>> JO2
				// terminaison de la transaction : validation
				oci_commit ($lien) ;
			}
		}
<<<<<<< HEAD
		if ($count!=1){  // puisque nous somme pas passez plus haut on execute ici le titre
		$titre = "L'épreuve  $nome ,$categorie ,$forme($nbs) ,$discipline ,$datep , $prix à été crée ";
		include('entete.php');
		}
		 $requete = ("
		SELECT max(Nepreuve)+1 from Lesepreuves
		"); // on récupére le nepreuve au quels on est et on ajoute 1 pour celui qu'on va crée 
=======

		$titre = "L'épreuve  $nome ,$categorie ,$forme($nbs) ,$discipline ,$date , $prix à été crée ";
		include('entete.php');
		 $requete = ("
		SELECT max(Nepreuve) from Lesepreuves
		");
>>>>>>> JO2
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
<<<<<<< HEAD
		oci_fetch ($curseur);
		$nepreuve= oci_result($curseur,1);
		$requete2 = "INSERT INTO LesEpreuves values (:nepreuve, :nome, :forme, :discipline, :categorie, :nbs, to_date(:datep, 'DD-MM-YYYY'),:prix)";
		// analyse de la requete et association au curseur
		$curseur = oci_parse ($lien, $requete2) ;
		// affectation des variables
=======
		$nepreuve = $requete+1;
	
		$requete2 = "INSERT INTO LesEpreuves values (:nepreuve, ':nome', ':forme', ':discipline', ':categorie', :nbs, to_date(':date', 'DD-MM-YYYY'), )";
		// analyse de la requete et association au curseur
		$curseur = oci_parse ($lien, $requete2) ;
		// affectation de la variable
>>>>>>> JO2
		oci_bind_by_name ($curseur,':nepreuve', $nepreuve);
		oci_bind_by_name ($curseur,':nome', $nome);
		oci_bind_by_name ($curseur,':forme', $forme);
		oci_bind_by_name ($curseur,':discipline', $discipline);
		oci_bind_by_name ($curseur,':categorie', $categorie);
		oci_bind_by_name ($curseur,':nbs', $nbs);
<<<<<<< HEAD
		oci_bind_by_name ($curseur,':datep', $datep);
		oci_bind_by_name ($curseur,':prix', $prix);
		// execution de la requete
		$ok = @oci_execute ($curseur,OCI_NO_AUTO_COMMIT) ;
=======
		oci_bind_by_name ($curseur,':date', $date);
		// execution de la requete
		$ok = @oci_execute ($curseur) ;
>>>>>>> JO2
			if (!$ok) {
				echo LeMessage ("majRejetee") ;
				// terminaison de la transaction : annulation
				oci_rollback ($lien) ;
			}	else {
<<<<<<< HEAD
				echo (" confirmation de la creation ") ;
				// terminaison de la transaction : validation
				oci_commit ($lien) ;
			}

=======
				echo LeMessage ("maj OK") ;
				// terminaison de la transaction : validation
				oci_commit ($lien) ;
			}
	}
>>>>>>> JO2
	// on libère le curseur
	oci_free_statement($curseur);
	include('pied.php');
	}

?>
