<?php

	$titre = 'Liste des épreuves associées au dossier 2 pour une discipline donnée, et nombre de billets pour chacune';
	include('entete.php');
	//creation du formulaire et de c'est différente valeur coder en brut 
    echo ("
          <form action=\"EpreuvesDiscipline_action.php\" method=\"POST\">
          <label for=\"inp_discipline\">Veuillez choisir une discipline :</label>
          <select name=\"inp_discipline\">
			 <option value=\"Bobsleigh\">Bobsleigh</option>
			 <option value=\"Combine nordique\">Combine nordique</option>
			 <option value=\"Curling\">Curling</option>
			 <option value=\"Hockey sur glace\">Hockey sur glace</option>
			 <option value=\"Luge\">Luge</option>
			 <option value=\"Patinage artistique\">Patinage artistique</option>
			 <option value=\"Patinage de vitesse\">Patinage de vitesse</option>
			 <option value=\"Saut a ski\">Saut a ski</option>
			 <option value=\"Skeleton\">Skeleton</option>
			 <option value=\"Ski alpin\">Ski alpin</option>
			 <option value=\"Ski de fond\">Ski de fond</option>
			 <option value=\"Snowboard\">Snowboard</option>
			 <option value=\"Sports de glace\">Sports de glace</option> 
			</select>
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
