<?php session_start();
	include("entete.php");
	$_SESSION['nomBat'] = $_POST['nomBat'];
	
	if (!isset($_POST['numLog'])){
		
		$requete = 'with X as (
		select nomBat, nlogement, count( nSportif) as occupe,capacite from lesLogements natural join leslocataires group by NomBat,nlogement,capacite having count( nSportif) != capacite
		union
		select nomBat, nlogement, 0 as occupe, capacite from (select nomBat,nlogement,capacite from lesLogements minus select nomBat,nlogement,capacite from lesLocataires natural join lesLogements)
	)
	select distinct nLogement from X natural join leslogements where occupe < capacite and lower(nomBat) = lower(:name) order by 1';

		$curseur = oci_parse ($lien, $requete) ;
		
		oci_bind_by_name($curseur,':name',$_SESSION['nomBat']);
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
				echo "<p class=\"erreur\">C'est bête t'as tout fait bugué</p><br/>";
			}
			else{
				echo "<form action=\"InscrireSportif-final.php\" method=\"post\">";
				echo "<select name = \"numLog\">";
				do{
					$numLog = oci_result($curseur,1);
					echo "<option value=\"$numLog\">$numLog</option>";
				}while(oci_fetch($curseur));
				echo "</select>";
				echo "<input type=\"submit\" value=\"Valider\"></input><input type=\"reset\" value=\"Annuler\"></input>";
				echo "</form>";
			}
		} //end of else
		
		oci_free_statement($curseur);
	
	}
	else{
		$requeteInsertionSportif	='INSERT INTO LesSportifs values (:num,:nom,:prenom,:pays,:cat,:date)';
		$requeteInsertionEquipe		='INSERT INTO LesEquipes values (:numS,:numE)';
		$requeteInsertionLocataire	='INSERT INTO LesLocataires values (:numS,:nLog,nBat)';
		
		$requeteNvNum = 'select max(nSportif) from lesSportifs';
		
		$curseur1 = oci_parse($lien,$requeteNvNum);
		@oci_execute($curseur1);
		
		
	}
	include("pied.php");
?>

