<?php
  if(logged())
  {
    header("Location: index.php");
    die();
  }

  if(isset($_POST['submit']))
  {
    if(filled($_POST['mail']))
    {
      ask_password_recovery($_POST['mail']);
    }
    else
    {
      echo '<div class="success_msg"> Une adresse mail doit être indiquée ! </div>';
    }
  }
?>

<form name="lostpassword" action="index.php?page=lostpassword" method="post">
  <label>Entrez votre adresse mail : </label><br/>
  <input type="text" name="mail"/><br/>
  <input type="submit" name="submit"/>
</form>
