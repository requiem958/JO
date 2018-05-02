<?php session_start();

	$titre = 'Ventes de billets';
	include('entete.php');

	if(isset($_POST['nvutil'])){
		$requete = 'select max(nUtil)+1 from LesDossiers';
		$curseur = oci_parse($lien,$requete);
		$ok = @oci_execute ($curseur) ;

		// on teste $ok pour voir si oci_execute s'est bien passé
		if (!$ok) {
			// oci_execute a échoué, on affiche l'erreur
			$error_message = oci_error($curseur);
			echo "<p class=\"erreur\">{$error_message['message']}</p>";

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
	else if (isset($_POST['nutil'])){
		$_SESSION['nUtil'] = $_POST['nUtil'];
	}
	else{
		echo ("
	<form method=\"post\" action=\"GererVentes-acte1.php\">
		<label for=\"nvutil\">Êtes vous un nouvel utilisateur ?</label>
		<input type=\"checkbox\" id=\"yes\" name=\"nvutil\"></input>
		<label for=\"num\">Si non entrez votre numéro :</label>
		<input type=\"number\" id=\"nUtil\" name=\"nUtil\"></input>
		<input type=\"submit\" value=\"Valider\"></input>
		<input type=\"reset\" value=\"Annuler\"></input>
	</form>");
	}
	include('pied.php');
?>
