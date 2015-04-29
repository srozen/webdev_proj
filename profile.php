<?php

  if(!logged())
  {
    header("Location: index.php");
    die();
  }

if(isset($_GET['modification']) AND $_GET['modification'] == 'true')
{
  /*** MAIL CHANGING ***/
  if(isset($_POST['mail_submit']))
  {
    if(profile_auth($_POST['mail_password'], $config, $dbsocket))
    {
      update_user_mail($_SESSION['user'], $_POST['mail_newmail'], $_POST['mail_newmailcheck'], $config, $dbsocket);
    }
    else
    {
      echo '<span class="error_msg"> Mauvais mot de passe ! </span>';
    }
  }

  /*** PASSWORD CHANGING ***/
  if(isset($_POST['password_submit']))
  {
    if(profile_auth($_POST['old_password'], $config, $dbsocket))
    {
      echo 'Password ok pour changer le mot de passe !';
    }
    else
    {
      echo 'Mauvais mot de passe ! ';
    }
  }

  /*** LOGIN CHANGING ***/
  if(isset($_POST['username_submit']))
  {
    if(profile_auth($_POST['username_password'], $config, $dbsocket))
    {
      update_user_login($_SESSION['user'], $_POST['new_username'], $_POST['username_password'], $config, $dbsocket);
    }
    else
    {
      echo 'Mauvais mot de passe ! ';
    }
  }

  /*** CONFIG CHANGING ***/
  if(isset($_POST['userconfig_submit']))
  {
    if(profile_auth($_POST['mail_password'], $config, $dbsocket))
    {
      echo 'Password ok pour changer le mail';
    }
    else
    {
      echo 'Mauvais mot de passe ! ';
    }
  }

  if(isset($_POST))
  ?>
  <h3> Modification du profil </h3>

  <a href="index.php?page=profile"> Retour au profil </a>

  <pre>
    <h3> Modifier votre configuration </h3>
    <form name="userconfig_change"
          action="index.php?page=profile&modification=true"
          method="post"
          enctype="multipart/form-data">
      <label>Avatar : </label>
      <input type="file"
             name="avatar"
             id="avatar"/>
      <label>Confirmez en entrant votre mot de passe : </label>
      <input type="password"
             name="userconfig_password"/>
      <input type="submit"
             value="Enregistrer"
             name="userconfig_submit"/>
    </form>
  </pre>

  <pre>
    <h3>Changer votre adresse mail</h3>
    <form name="mail_change"
          action="index.php?page=profile&modification=true"
          method="post">
      <label>Adresse mail : </label>
      <input type="text"
             value="<?php echo $_SESSION['user']->getMail(); ?>"
             name="mail_newmail"/>
      <label>Vérification mail : </labeL>
      <input type="text"
             name="mail_newmailcheck"/>
      <label>Mot de passe actuel : </label>
      <input type="password"
             name="mail_password"/>
      <input type="submit"
             value="Enregistrer"
             name="mail_submit"/>
    </form>
  </pre>

  <pre>
    <h3>Changer votre mot de passe </h3>
    <form name="pwd_change"
          action="index.php?page=profile&modification=true"
          method="post">
      <label>Ancien mot de passe : </label>
      <input type="password"
             name="old_password"/>
      <label>Nouveau mot de passe : </label>
      <input type="password"
             name="new_password"/>
      <label>Répéter mot de passe : </label>
      <input type="password"
             name="new_passwordcheck"/>
      <input type="submit"
             value="Enregistrer"
             name="password_submit"/>
    </form>
  </pre>

  <pre>
    <h3>Changer votre nom d'utilisateur</h3>
    <form name="username_change"
          action="index.php?page=profile&modification=true"
          method="post">
      <label>Login souhaité : </label>
      <input type="text"
             value="<?php echo $_SESSION['user']->getLogin(); ?>"
             name="new_username"/>
      <label>Confirmez en entrant votre mot de passe : </label>
      <input type="password"
             name="username_password"/>
      <input type="submit"
             value="Enregistrer"
             name="username_submit"/>
    </form>
  </pre>
  <?php
}
else
{
  ?>
  <h3> Données du profil </h3>
  <pre>
    <h4> Avatar : </h4>
    <h4> Login : </h4>
    <h4> Mail : </h4>
  </pre>

  <a href="index.php?page=profile&modification=true"> Modifier Profil </a>
  <?php
}
