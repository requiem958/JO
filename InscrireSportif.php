<?php
    $titre = 'Inscription Sportif';
	include('entete.php');
?>
<form action = "InscrireSportif-action1.php" method="post">
	<label for="nomS">Nom: </label>
	<input type="text" name="nomS"></input><br/>
	<label for="prenomS">Prenom:</label>
	<input type="text" name="prenomS"></input><br/>
	<label for="pays">Pays:</label>
	<input type="pays" name="pays"></input><br/>
	<label for="categorie">Sexe :</label>
	<select name="categorie">
		<option value="masculin">Masculin</option>
		<option value="feminin">Féminin</option>
	</select><br/>
	<label for="dateNais">Date de naissance : </label>
	<input type="text" name="dateNais"></input><br/>
	<label for="numE">numéro d'équipe : </label>
	<input type="number" name="numE"></input>
	<input type="submit" value="Valider"></input>
	<input type="reset" value="Annuler"></input>
</form>
<?php
	include('pied.php');
?>
