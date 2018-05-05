<?php
    $titre = 'ajouter une epreuve';
	include('entete.php');
	$requete = ("
		SELECT discipline from LesDisciplines   
	");//on selectione toute les discplines pour pouvoir faire le formulaire 
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
	else {
		// oci_execute a réussi, on fetch sur le premier résultat
		$res = oci_fetch ($curseur);
		if (!$res) {
			// il n'y a aucun résultat du coup on demande directement à l'utilisateur d'entrez une nouvelle discpline
			echo(" 
          <form action=\"creationEpreuves.php\" method=\"POST\">
          <p>Entrez le nom de l'épreuve :<input type=\"text\" name=\"NomE\" /></p>
          <label for=\"inp_categorie\">Veuillez choisir une categorie :</label>
          <select name=\"categorie\">
			 <option value=\"mixte\">Mixte</option>
			 <option value=\"feminin\">Feminin</option>
			 <option value=\"masculin\">Masculin</option>
			</select>
	<p><label for=\"inp_forme\">Veuillez choisir une forme :</label>
          <select name=\"forme\">
			 <option value=\"Individuelle\">Individuel</option>
			 <option value=\"par equipe\">Equipe</option>
			 <option value=\"par couple\">Couple</option>
			</select></p>
		<p>            Entrez une discipline puisqu'aucune existe :<input type=\"text\" name=\"inp_discipline\" /></p>
		<p>            Entrez la date :<input type=\"date\" name=\"Datep\" /></p>
		<p>            Entrez le prix :<input type=\"number\" name=\"Prix\" min=\"0\" /></p>
		<p>            Entrez le nombre par équipe :<input type=\"number\" name=\"nbs\" min=\"1\" /></p>
			<br /><br />
			<input type=\"submit\" value=\"Valider\" />
			<input type=\"reset\" value=\"Annuler\" />
		</form>
	");
		}
		//cas ou il y'a des résultat on demande à l'utilisateur de tout saisir 
		else {
	echo("
          <form action=\"creationEpreuves.php\" method=\"POST\">
          <p>Entrez le nom de l'épreuve :<input type=\"text\" name=\"NomE\" /></p>
          <label for=\"inp_categorie\">Veuillez choisir une categorie :</label>
          <select name=\"categorie\">
			 <option value=\"mixte\">Mixte</option>
			 <option value=\"feminin\">Feminin</option>
			 <option value=\"masculin\">Masculin</option>
			</select>
	<p><label for=\"inp_forme\">Veuillez choisir une forme :</label>
          <select name=\"forme\">
			 <option value=\"individuelle\">Individuel</option>
			 <option value=\"par equipe\">Equipe</option>
			 <option value=\"par couple\">Couple</option>
			</select></p>
			
			<p><label for=\"inp_discipline\"> choisir une discipline :</label>
                    <select name=\"inp_discipline\">	
                    <option value=\"0\">nouvelle discipline</option>"	);
			// on affiche un résultat et on passe au suivant s'il existe
		do {
				$discipline = oci_result($curseur,1) ;
				echo "<option value=\"$discipline\">".$discipline."</option>";
			} while (oci_fetch ($curseur));
		
		echo ("			</select></p> 
		   <p>   Entrez la nouvelle discipline :<input type=\"text\" name=\"Disc\" /></p>
		<p>            Entrez la date (DD-MM-YYYY) :<input type=\"text\" name=\"Datep\" /></p>
		<p>            Entrez le prix :<input type=\"number\" name=\"Prix\" min=\"0\" /></p>
		<p>            Entrez le nombre par équipe :<input type=\"number\" name=\"nbs\" min=\"1\" /></p>
			<br /><br />
			<input type=\"submit\" value=\"Valider\" />
			<input type=\"reset\" value=\"Annuler\" />
		</form>
	");}
}
	oci_free_statement($curseur);
	include('pied.php');
?>

