<?php

  if(!logged())
  {
    header("Location: index.php");
    die();
  }

  if(isset($_GET['action']) AND $_GET['action'] == 'modify')
  {
    echo '<a href="index.php?page=profile">Retour au profil</a><br/>';
    if(isset($_POST['submit_profile']))
    {
      process_profile_form(sanitize($_POST['login']), sanitize($_POST['password']), sanitize($_POST['checkpassword']), sanitize($_POST['mail']), sanitize($_POST['checkmail']), sanitize($_POST['userpassword']), $_SESSION['user']);
    }
    display_profile_form($_SESSION['user'], 'index.php?page=profile&action=modify');
  }
  else
  {
    echo '<a href="index.php?page=profile&action=modify">Modifier le profil</a><br/>';
    display_profile($_SESSION['user']);
  }
?>
