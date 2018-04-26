<?php
    $titre = 'Demenagement Sportif';
	include('entete.php');
?>
<form action = "DemenagerSportif-action.php" method="post">
	<label for="nomS">Nom: </label>
	<input type="text" name="nomS"></input><br/>
	<label for="prenomS">Prenom:</label>
	<input type="text" name="prenomS"></input><br/>
	<input type="submit" value="Valider"></input>
	<input type="reset" value="Annuler"></input>
</form>
<?php
	include('pied.php');
?>