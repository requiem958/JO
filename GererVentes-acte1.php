<?php session_start();
	$requete = 'select max(nDossier)+1 from LesDossiers_base';
	$curseur = oci_parse($lien,$requete);
	$ok = @oci_execute ($curseur) ;

	// on teste $ok pour voir si oci_execute s'est bien passé
	if (!$ok) {
		// oci_execute a échoué, on affiche l'erreur
		$error_message = oci_error($curseur);
		echo "<p class=\"erreur\">{$error_message['message']}</p>";

	}
	else {
		if (!oci_fetch($curseur))
			$_SESSION['nDossier'] = 0;
		else
			$_SESSION['nDossier'] = oci_result($curseur,1);
	}
	
	if (isset($_SESSION['nDossier'])){
		echo "<p>Vous êtes l'utilisateur numéro ".$_SESSION['nUtil']." pour le dossier ".$_SESSION['nDossier']."</p><br>";
		
		//Generation des epreuves à choisir
		
		$requete = 'select nEpreuve,nomEpreuve,dateEpreuve from LesEpreuves';
		
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
					echo ("
					<input type=\"checkbox\" name=\"nom_$nEpreuve\"></input>
					<label for=\"nom_$nEpreuve\">$nomEpreuve : $dateEpreuve</label>
					<label for=\"nbBillet_$nEpreuve\">Nombre de billets : </label>
					<input type=\"number\" name=\"nbBillet_$nEpreuve\"></input>
					<input type=\"hidden\" name=\"nEpreuve_$nEpreuve\" value=\"$nEpreuve\"></input>"
					);
				}while(oci_fetch($curseur));
?>
	<input type="submit" name="validVente" value="Valider"></input>
	<input type="reset" value="Annuler"></input>
	</form>
<?
			}
		}
	}
	*/
