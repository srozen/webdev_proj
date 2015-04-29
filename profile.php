<?php

  if(!logged())
  {
    header("Location: index.php");
    die();
  }

if(isset($_GET['modification']) AND $_GET['modification'] == 'true')
{
  if(isset($_GET['param']))
  {
    switch($_GET['param'])
    {
      case 'config' :
        echo 'Modifier config';
        break;
      case 'mail' :
        echo 'Modifier mail';
        break;
      case 'password' :
        echo 'Modifier password';
        break;
      case 'login' :
        echo 'Modifier login';
        break;
      default:
        break;
    }
  }
  ?>
  <h3> Modification du profil </h3>

  <pre>
    <form name="config_change"
          action="index.php?page=profile&modification=true&param=config"
          method="post"
          enctype="multipart/form-data">
      <label>Avatar : </label>
      <input type="file"
             name="avatar"
             id="avatar"/>
      <label>Confirmez en entrant votre mot de passe : </label>
      <input type="password"
             name="config_password"/>
      <input type="submit"
             value="Enregistrer"
             name="config_submit"/>
    </form>
  </pre>

  <pre>
    <h3>Changer votre e-mail</h3>
    <form name="mail_change"
          action="index.php?page=profile&modification=true&param=mail"
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
          action="index.php?page=profile&modification=true&param=password"
          method="post">
      <label>Ancien mot de passe : </label>
      <input type="password"
             name="old_pwd"/>
      <label>Nouveau mot de passe : </label>
      <input type="password"
             name="new_pwd"/>
      <label>Répéter mot de passe : </label>
      <input type="password"
             name="new_pwd_verif"/>
      <input type="submit"
             value="Enregistrer"
             name="pwd_submit"/>
    </form>
  </pre>

  <pre>
    <h3>Changer votre nom d'utilisateur</h3>
    <form name="username_change"
          action="index.php?page=profile&modification=true&param=login"
          method="post">
      <label>Login souhaité : </label>
      <input type="text"
             value="<?php echo $_SESSION['user']->getLogin(); ?>"
             name="new_username"/>
      <label>Confirmez en entrant votre mot de passe : </label>
      <input type="password"
             name="username_pwd"/>
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
