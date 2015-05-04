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
      $userid = get_user_value('id', 'mail', $_POST['mail'], $dbsocket);
      $user = create_user($userid, $dbsocket);

      if($user->getQuestionSet() == false)
      {
        echo 'Vous n\'avez pas rempli la question et réponse secrète, veuillez contacter un administrateur.';
      }
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
