<?php

  /***************************
   * LOST PASSWORD PROCEDURE *
   ***************************/

  if(logged())
 	{
 	  header("Location: index.php");
 	  die();
 	}

  if(isset($_POST['lostpwd_submit']))
  {
    if(user_exists('mail', $_POST['mail'], $dbsocket))
    {
      echo 'Vous êtes bien enregistré sur le site ! ';
    }
    else
    {
      echo 'Cette adresse mail n\'existe pas. ';
    }
  }

?>

  <form name="retrieve_mail" action="index.php?page=lostpwd" method="post">
    <label>Entrez votre mail : <label><br/>
      <input type="text" name="mail"/><br/>
      <input type="submit" name="lostpwd_submit"/>
  </form>
