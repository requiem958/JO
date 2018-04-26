<?php session_start();

	include("entete.php");

	if (isset($_POST['nomS'])){

		$_SESSION['nomS'] = $_POST['nomS'];
		$_SESSION['prenomS'] = $_POST['prenomS'];
		
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
				echo "<form action=\"DemenagerSportif-action.php\" method=\"post\">";
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
	}
	else if(isset($_POST['nomBat'])){
		$_SESSION['nomBat']=$_POST['nomBat'];

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
				echo "<form action=\"DemenagerSportif-action.php\" method=\"post\">";
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
		
	}
	else if(isset($_POST['numLog'])){
		$_SESSION['nLog'] = $_POST['numLog'];
		$requeteInsertionLocataire	='INSERT INTO LesLocataires values (:numS,:nLog,:nBat)';
		$requeteSuppresionLocataire ='DELETE FROM LesLocataires where num=:num';
		
		$curseur = oci_parse($lien,'select nSportif from lesSportifs where lower(nom) = lower(:nom) and lower(prenom) = lower(:prenom)');
		oci_bind_by_name($curseur, ':nom', $_SESSION['nomS']);
		oci_bind_by_name($curseur, ':prenom', $_SESSION['prenomS']);
		@oci_execute($curseur);
		if(!oci_fetch($curseur)){
			echo "<p class=\"erreur\">Ce sportif n'existe aucunement.</p><br/>";
		}
		else{
			$num = oci_result($curseur, 1);

			$curseur = oci_parse($lien, $requeteSu);

			oci_bind_by_name($curseur, ':num', $num);

			$ok = @oci_execute ($curseur, OCI_NO_AUTO_COMMIT) ;
			// on teste $ok pour voir si oci_execute s'est bien passé
			if (!$ok) {
				echo("Requete Suppression");
				echo LeMessage ("majRejetee")."<br /><br />";
				$e = oci_error($curseur);
				echo LeMessageOracle ($e['code'], $e['message']) ;
				// terminaison de la transaction : annulation
				oci_rollback ($lien) ;
			}
			else {
			// analyse de la requete 2 et association au curseur
				$curseur = oci_parse ($lien, $requeteInsertionLocataire);
				oci_bind_by_name($curseur, ':numS', $num);
				oci_bind_by_name($curseur, ':nLog', $_SESSION['nLog']);
				oci_bind_by_name($curseur, ':nBat', $_SESSION['nomBat']);
				// execution de la requete
				$ok = @oci_execute ($curseur, OCI_NO_AUTO_COMMIT);

				// on teste $ok pour voir si oci_execute s'est bien passé
				if (!$ok) {
					echo("Requete Insertion");
					echo LeMessage ("majRejetee")."<br /><br />";
					echo LeMessageOracle ($e['code'], $e['message']) ;
					// terminaison de la transaction : annulation
					oci_rollback ($lien) ;

				}
				else {

					echo LeMessage ("majOk");
					// terminaison de la transaction : validation
					oci_commit ($lien) ;

				}

			}

		}
	}
	oci_free_statement($curseur);

	include("pied.php");
?>
