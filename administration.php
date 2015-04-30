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

  if(isset($_GET['manage']))
  {
    switch($_GET['manage'])
    {
      case 'user' : ?>
        <h3>Bienvenue dans la gestion des utilisateurs</h3>
        <form name="user" action='index.php?page=administration&manage=user' method="post">
          <label>Entrez un pseudo à rechercher : </label>
          <input type="text" name="user_login"/>
          <label>Entrez un email à rechercher : </label>
          <input type="text" name ="user_mail"/>
          <label>Sélectionnez un statut : </label>
          <select name="user_status">
            <option value="all">Statut</option>
            <option value="activated">Actif</option>
            <option value="unactivated">En attente d'activation</option>
          </select>
          <input type="submit" value="Rechercher" name="user_submit"/>
        <?php
        if(isset($_POST['user_submit']))
        {
          display_users($_POST['user_login'], $_POST['user_mail'], $_POST['user_status']);
        }
        break;
      case 'mail' :
        select_messages();
        if(isset($_POST['mail_submit']))
        {
          display_messages($_POST['mail_sort'], $dbsocket);
        }
        break;
      case 'config' :
        if(isset($_POST['config_submit']))
        {
          update_config($_POST['password_config'], $config, $dbsocket);
        }
        display_config();
        break;
      default :
        echo 'Veuillez sélectionner une option d\'administration';
        break;
    }
  }

?>
