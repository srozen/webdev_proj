<?php
  if(!logged())
  {
    header("Location: index.php?page=login");
		die();
  }

  $dbsocket = db_connexion();

  /*** MAIL CHANGING ***/
  if(isset($_POST['mail_submit']))
  {
    if(is_filled($_POST['mail_newmail']) AND is_filled($_POST['mail_pwd']))
    {
      if(indoor_auth($_POST['mail_pwd']))
      {
        if($query = $_SESSION['user']->update_db('mail', $_POST['mail_newmail']))
        {
          $dbsocket->exec($query);
        }
      }
    }
  }

  /*** PASSWORD CHANGING ***/
  if(isset($_POST['pwd_submit']))
  {
    if(is_filled($_POST['old_pwd']) AND is_filled($_POST['new_pwd']) AND is_filled($_POST['new_pwd_verif']))
    {
      if(indoor_auth($_POST['old_pwd']))
      {
        if($query = $_SESSION['user']->update_db('password', $_POST['new_pwd']))
        {
          $dbsocket->exec($query);
        }
      }
    }
  }

  /*** LOGIN CHANGING ***/
  if(isset($_POST['username_submit']))
  {
    if(is_filled($_POST['new_username']) AND is_filled($_POST['username_pwd']))
    {
      if(indoor_auth($_POST['username_pwd']))
      {
        if($query = $_SESSION['user']->update_db('login', $_POST['new_username']))
        {
          $dbsocket->exec($query);
        }
      }
    }
  }

  /***********************/

  echo '<pre>';
  print_r($_SESSION['user']);

  echo 'Login : ' . $_SESSION['user']->getLogin();
  echo '</pre>';
?>


<?php

?>

  <h2>Edition du profil</h2>

<pre>
  <h3>Vos configurations</h3>
  <form name="config_change" action="index.php?page=profile" method="post">
    <label>Avatar : </label><input type="file" name="config_avatar"/>
    <label>Confirmez en entrant votre mot de passe : </label><input type="password" name="config_password"/>
    <input type="submit" value="Enregistrer" name="config_submit"/>
  </form>
</pre>

<pre>
  <h3>Changer votre e-mail</h3>
  <form name="mail_change" action="index.php?page=profile" method="post">
    <label>Adresse e-mail : </label><input type="text" value="<?php echo $_SESSION['user']->getMail(); ?>" name="mail_newmail"/>
    <label>Mot de passe actuel : </label><input type="password" name="mail_pwd"/>
    <input type="submit" value="Enregistrer" name="mail_submit"/>
  </form>
</pre>

<pre>
  <h3>Changer votre mot de passe </h3>
  <form name="pwd_change" action="index.php?page=profile" method="post">
    <label>Ancien mot de passe : </label><input type="password" name="old_pwd"/>
    <label>Nouveau mot de passe : </label><input type="password" name="new_pwd"/>
    <label>Répéter mot de passe : </label><input type="password" name="new_pwd_verif"/>
    <input type="submit" value="Enregistrer" name="pwd_submit"/>
  </form>
</pre>

<pre>
  <h3>Changer votre nom d'utilisateur</h3>
  <form name="username_change" action="index.php?page=profile" method="post">
    <label>Login souhaité : </label><input type="text" value="<?php echo $_SESSION['user']->getLogin(); ?>" name="new_username"/>
    <label>Confirmez en entrant votre mot de passe : </label><input type="password" name="username_pwd"/>
    <input type="submit" value="Enregistrer" name="username_submit"/>
  </form>
</pre>

<?php
  $dbsocket = null;
?>
