<?php

	$titre = 'Liste des épreuves associées à un dossier donné pour une discipline donnée, et nombre de billets pour chacune';
	include('entete.php');
    echo ("
          <form action=\"EpreuvesDiscipline_v3_action.php\" method=\"POST\">
          <label for=\"inp_discipline\">Veuillez saisir une discipline :</label>
          <input type=\"text\" name=\"discipline\" />
          <br /><br />
          <input type=\"submit\" value=\"Valider\" />
          <input type=\"reset\" value=\"Annuler\" />
          </form>
          ");
	// travail à réaliser
	echo ("
		<p class=\"work\">
			Ajoutez une étape à cet enchaînement de scripts, de façon à obtenir le fonctionnement suivant :
			<ul>
				<li><b>Etape 1 :</b> un formulaire nous demande de choisir un numéro de dossier dans une liste extraite de la base de données</li>
				<li><b>Etape 2 :</b> pour le numéro de dossier choisi, un formulaire nous demande de sélectionner une discipline dans une liste qui ne contiendra que les disciplines concernées par le numéro de dossier demandé</li>
				<li><b>Etape 3 :</b> affichage de la liste des billets correspondant à la discipline et au numéro de dossier sélectionnés, et pour chacun nombre de places. </li>
			</ul>
		</p>
	");

	include('pied.php');

?>
