<h4>Bienvenue sur le Wiki ! </<h4></h4><br/>
<div>Vous pourrez bientôt vous inscrire sur le site.</div>
<div>D'autres fonctionnalités seront implémentées par la suite.</div>

<?php
  if(logged())
  {
    echo '<pre>';
    print_r($_SESSION['user']);
    echo '</pre>';
  }
?>
