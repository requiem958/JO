<?php
   // fin de la page
   if(isset($lien) && $lien) { // on ferme la connexion Oracle éventuellement ouverte
      Deconnexion ($lien);
   }
   include ("navigation.php");
    ?>

</body>
</html>