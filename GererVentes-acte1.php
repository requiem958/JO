<?php session_start();

	include('entete.php');

	
	//On récupére les variables sur le numéro d'user

	if(isset($_POST['nvUtil']) && $_POST['nvUtil']=="on"){
		$curseur = oci_parse($lien,'select max(nUtil)+1 from LesDossiers');
		$ok = @oci_execute ($curseur) ;

		// on teste $ok pour voir si oci_execute s'est bien passé
		if (!$ok) {
			// oci_execute a échoué, on affiche l'erreur
			$error_message = oci_error($curseur);
			echo "<p class=\"erreur\">{$error_message['message']}</p>";
			echo "bwa";
			return;

		}
		else {
			if (!oci_fetch($curseur)){
				$_SESSION['nUtil'] = 0;
			}
			else{
				$_SESSION['nUtil'] = oci_result($curseur,1);
			}
		}
	}
	else if (isset($_POST['nUtil'])){
		$_SESSION['nUtil'] = $_POST['nUtil'];
	}
	else{
		echo "<p>Erreur d'arrivée ici</p>";
		oci_free_statement($curseur);
		include('pied.php');
		return;
	}

	//On récupère les numéros de dossier
	oci_free_statement($curseur);
	
	$curseur = oci_parse($lien,'select max(nDossier)+1 from LesDossiers');
	$ok = @oci_execute ($curseur);

	// on teste $ok pour voir si oci_execute s'est bien passé
	if (!$ok) {
		// oci_execute a échoué, on affiche l'erreur
		$error_message = oci_error($curseur);
		echo "<p class=\"erreur\">{$error_message['message']}</p>";
		oci_free_statement($curseur);
		include('pied.php');
		return;
	}
	else {
		if (!oci_fetch($curseur))
			$_SESSION['nDossier'] = 0;
		else
			$_SESSION['nDossier'] = oci_result($curseur,1);
	}
	//On affiche les epreuves pour la selection
	
	if (!isset($_SESSION['nDossier'])){
		echo "<p> Vous n'avez aucun numéro de dossier vous ne devez pas être là.</p>";
	}
	else {
		echo "<p>Vous êtes l'utilisateur numéro ".$_SESSION['nUtil']." pour le dossier ".$_SESSION['nDossier']."</p><br/>";
		
		//Generation des epreuves à choisir
		
		oci_free_statement($curseur);
		$curseur = oci_parse($lien,'select nEpreuve,nomE,dateEpreuve from LesEpreuves order by dateEpreuve,nomE');
		$ok = @oci_execute ($curseur) ;

		// on teste $ok pour voir si oci_execute s'est bien passé
		if (!$ok) {
			// oci_execute a échoué, on affiche l'erreur
			$error_message = oci_error($curseur);
			echo "<p class=\"erreur\">{$error_message['message']}</p>";

		}
		else {
			if (!oci_fetch($curseur)){
				
				$error_message = oci_error($curseur);
				echo "<p>Pas d'épreuves dans la base, c'est embétant</p>";
				echo "<p class=\"erreur\">{$error_message['message']}</p>";
			}
			else{
				echo "<form action=\"GererVentes-acte1.php\" method=\"post\">";
				do{
					$nEpreuve = oci_result($curseur, 1);
					$nomEpreuve = oci_result($curseur, 2);
					$dateEpreuve = oci_result($curseur, 3);
					echo "
					<input type=\"checkbox\" name=\"nom_$nEpreuve\"></input>
					<label for=\"nom_$nEpreuve\">$nomEpreuve : $dateEpreuve</label>
					<label for=\"nbBillet_$nEpreuve\">Nombre de billets : </label>
					<input type=\"number\" name=\"nbBillet_$nEpreuve\"></input>
					<input type=\"hidden\" name=\"nEpreuve_$nEpreuve\" value=\"$nEpreuve\"></input><br/>\n";
				}while(oci_fetch($curseur));

				echo "<input type=\"submit\" name=\"validVente\" value=\"Valider\"></input>\n<input type=\"reset\" value=\"Annuler\"></input>\n</form>";
			}
		}
	}
	oci_free_statement($curseur);
	include('pied.php');
?>