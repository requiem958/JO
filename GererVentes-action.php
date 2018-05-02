<?php session_start();
	
	$titre = 'Ventes de billets';
	include('entete.php');
	
	if(isset($_POST['validVente'])){
		$requete = 'insert into LesEpreuves from ';
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
	else{
		$_SESSION['nUtil'] = $_POST['nUtil'];
	}
	include('pied.php');
?>
