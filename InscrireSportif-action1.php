<?php session_start();
	include("entete.php");
	$_SESSION['nomS'] = $_POST['nomS'];
	$_SESSION['prenomS'] = $_POST['prenomS'];
	$_SESSION['pays'] = $_POST['pays'];
	$_SESSION['cat'] = $_POST['categorie'];
	$_SESSION['dateNais'] = $_POST['dateNais'];
	$_SESSION['numE']=$_POST['numE'];
	
	$requete = "with X as (
	select nomBat, nlogement, count( nSportif) as occupe,capacite from lesLogements natural join leslocataires group by NomBat,nlogement,capacite having count( nSportif) != capacite
	union
	select nomBat, nlogement, 0 as occupe, capacite from (select nomBat,nlogement,capacite from lesLogements minus select nomBat,nlogement,capacite from lesLocataires natural join lesLogements)
)
select distinct nomBat from X natural join leslogements where occupe < capacite";

	$curseur = oci_parse ($lien, $requete) ;
	
	$ok = @oci_execute ($curseur);

	// on teste $ok pour voir si oci_execute s'est bien passé
	if (!$ok) {

		// oci_execute a échoué, on affiche l'erreur
		$error_message = oci_error($curseur);
		echo "<p class=\"erreur\">{$error_message['message']}</p>";

	}
	else{
		$res = oci_fetch($curseur);
		if (!$res){
			echo "<p class=\"erreur\">C'est bête y'a plus de place</p><br/>";
		}
		else{
			echo "<form action=\"InscrireSportif-final.php\" method=\"post\">";
			echo "<select name = \"nomBat\">";
			do{
				$nomB = oci_result($curseur,1);
				echo "<option value=\"$nomB\">$nomB</option>";
			}while(oci_fetch($curseur));
			echo "</select>";
			echo "<input type=\"submit\" value=\"Valider\"></input><input type=\"reset\" value=\"Annuler\"></input>";
			echo "</form>";
		}
} //end of else
	oci_free_statement($curseur);
	include("pied.php");
?>
