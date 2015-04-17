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
      case 'mail' : ?>
        <h3>Bienvenue dans la gestion des mails</h3>
        <form name="mailsort" action='index.php?page=administration&manage=mail' method="post">
          <select name="sorting">
            <option value="date">Classement par date</option>
            <option value="noanswer">Messages non répondus</option>
            <option value="answer">Messages répondus</option>
            <option value="anonymous">Messages anonymes</option>
            <option value="user">Messages utilisateurs</option>
          </select>
          <input type="submit" value="Trier" name="submit_mailsort"/>
        </form>
        <?php
        if(isset($_POST['submit_mailsort']))
        {
          display_messages($_POST['sorting']);
        }
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
