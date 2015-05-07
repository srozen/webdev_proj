<?php

  if(!logged())
  {
    header("Location: index.php");
    die();
  }

  if(isset($_GET['action']) AND $_GET['action'] == 'modify')
  {
    if(frozen($_SESSION['user']->getId()))
    {
      header("Location: index.php?page=profile");
      die();
    }
    echo '<a href="index.php?page=profile">Retour au profil</a><br/>';
    if(isset($_POST['submit_profile']))
    {
      process_profile_form(sanitize($_POST['login']), sanitize($_POST['password']), sanitize($_POST['checkpassword']), sanitize($_POST['mail']), sanitize($_POST['checkmail']), sanitize($_POST['userpassword']), $_SESSION['user'], $_POST['question'], $_POST['answer']);
    }
    display_profile_form($_SESSION['user'], 'index.php?page=profile&action=modify');
  }
  else
  {
    if(frozen($_SESSION['user']->getId()))
    {
      echo '<div class="error_msg"> Vous êtes actuellement gelé, vous ne pouvez modifier votre profil. </div>';
    }
    else
    {
      echo '<a href="index.php?page=profile&action=modify">Modifier le profil</a><br/>';
    }
    display_profile($_SESSION['user']);
  }
?>
