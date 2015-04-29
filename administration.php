<?php

  if(!logged())
  {
    header("Location: index.php");
    die();
  }

  if(!is_admin($_SESSION['user']))
  {
    header("Location: index.php");
    die();
  }


  echo '<ul> Panneau d\'administration';
  echo '<li><a href=index.php?page=administration&manage=user> Gestion des membres </a></li>';
  echo '<li><a href=index.php?page=administration&manage=mail> Gestion des messages </a></li>';
  echo '<li><a href=index.php?page=administration&manage=config> Gestion de la configuration </a></li>';
  echo '</ul>';

?>
