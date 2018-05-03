<?php session_start();

	$titre = 'Ventes de billets';
	include('entete.php');
	echo ("
	<form method=\"post\" action=\"GererVentes-acte1.php\">
		<label for=\"nvutil\">Êtes vous un nouvel utilisateur ?</label>
		<input type=\"checkbox\" id=\"yes\" name=\"nvutil\"></input>
		<label for=\"num\">Si non entrez votre numéro :</label>
		<input type=\"number\" id=\"nUtil\" name=\"nUtil\"></input>
		<input type=\"submit\" value=\"Valider\"></input>
		<input type=\"reset\" value=\"Annuler\"></input>
	</form>");
	include('pied.php');
?>
