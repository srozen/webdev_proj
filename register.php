<?php

  if(isset($_POST['register']))
  {
    // Check the login
    // Check the passwords
    // Check the mails

    // If all is ok
      // create the user
      // Generate and link the code
      // Send activation mail

    // else echo error messages
  }

?>

<form name="register" action="index.php?page=register" method="post">
  <label>Login</label><br/>
    <input type="text" name="login"/><br/>
  <label>Mot de passe</label><br/>
    <input type="password" name="password"/><br/>
  <label>Vérification du mot de passe</label><br/>
    <input type="password" name="checkpassword"/><br/>
  <label>Mail</label><br/>
    <input type="text" name="mail"/><br/>
  <label>Vérification du mail</label><br/>
    <input type="text" name="checkmail"/><br/>
  <input type="submit" name="register" value="Inscription"/>
</form>
