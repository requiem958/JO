<?php

	$titre = 'Liste des épreuves associées au dossier 2 pour une discipline donnée, et nombre de billets pour chacune';
	include('entete.php');

    echo ("
          <form action=\"EpreuvesDiscipline_v1_action.php\" method=\"POST\">
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
			Améliorez l'interface utilisateur en proposant, à la place du champ de saisie libre, un choix dans une liste contenant toutes les disciplines (sous forme de boite de sélection ou de boutons radio).<br />Cette liste sera codée \"en dur\".
		</p>
	");

	include('pied.php');

?>
