<?php

  if(!logged())
  {
    header("Location: index.php");
    die();
  }

?>

<h3> Données du profil </h3>
<pre>
  <h4> Avatar : </h4>
  <h4> Login : </h4>
  <h4> Mail : </h4>
</pre>

<h3> Modification du profil </h3>

Modifier votre : <a href="index.php?page=profile&modification=avatar"> Avatar </a>
                 <a href="index.php?page=profile&modification=login"> Login </a>
                 <a href="index.php?page=profile&modification=mail"> Mail </a>
                 <a href="index.php?page=profile&modification=password"> Mot de passe </a>

<?php

  if(isset($_GET['modification']))
  {
    //
  }
