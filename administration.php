<?php
  if(!logged())
  {
    header("Location: index.php?page=login");
    die();
  }

  echo '<ul> Panneau d\'administration';
  echo '<li><a href=index.php?page=administration&manage=user> Gestion des membres </a></li>';
  echo '<li><a href=index.php?page=administration&manage=mail> Gestion des messages </a></li>';
  echo '<li><a href=index.php?page=administration&manage=config> Gestion de la configuration </a></li>';
  echo '</ul>';

  if(isset($_GET['manage']))
  {
    switch($_GET['manage'])
    {
      case 'user' :
        echo 'Bienvenue dans la gestion des users';
        break;
      case 'mail' :
        echo 'Bienvenue dans la gestion des mails';
        break;
      case 'config' :
        echo 'Bienvenue dans la gestion de la configuration';
        break;
      default :
        echo 'Veuillez sélectionner une option d\'administration';
        break;
    }
  }
?>
