<?php
  if(isset($_POST['reg_submit']))
  {
    valid_register_login($_POST['login'], $config);
    valid_register_mail($_POST['mail'], $_POST['mail_check'], $config);
    valid_register_password($_POST['password'], $_POST['password_check'], $config);
  }
?>

<form name="regiser" action="index.php?page=register" method="post">
  <label>Login : </label>
    <input type="text" name="login" required/>
    <?php echo '<small>' . $LOGINLENGTH . '</small><br/>';?>

  <label>Mot de passe : </label>
    <input type="password" name="password" placeholder="" required/>
    <?php echo '<small>' . $PASSWORDLENGTH . '</small><br/>';?>

  <label>Vérification mot de passe : </label>
    <input autocomplete="off" type="password" name="password_check" placeholder="" required/><br/>

  <label>Adresse mail : </label>
    <input type="email" name="mail" placeholder="" required/><br/>

  <label>Vérification du mail : </label>
    <input autocomplete="off" type="email" name="mail_check" placeholder="" required/><br/>

    <input type="submit" name="reg_submit" value="Inscription"/>
</form>
