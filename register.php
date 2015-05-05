<?php

  $login_recall = $mail_recall = '';

  if(isset($_POST['register']))
  {
    // Checking login and recalling it if valid
    $valid_login = check_login($_POST['login']);
    if($valid_login) $login_recall = $_POST['login'];
    // Checking mail and recalling it if valid
    $valid_mail = check_mails($_POST['mail'], $_POST['checkmail']);
    if($valid_mail) $mail_recall = $_POST['mail'];
    // Checking if passwords are valid
    $valid_password = check_passwords($_POST['password'], $_POST['checkpassword']);


    if($valid_login == true AND $valid_mail == true AND $valid_password == true)
    {
      registration(sanitize($_POST['login']), sanitize($_POST['password']), sanitize($_POST['mail']));
    }

  }

  $req = '<span class="error_msg">*</span>';
?>

<form name="register" action="index.php?page=register" method="post">
  <label>Login</label><br/>
    <input type="text" name="login" value="<?php echo $login_recall; ?>"/><?php echo $req; ?><br/>
  <label>Mot de passe</label><br/>
    <input type="password" name="password"/><?php echo $req; ?><br/>
  <label>Vérification du mot de passe</label><br/>
    <input type="password" name="checkpassword"/><?php echo $req; ?><br/>
  <label>Mail</label><br/>
    <input type="text" name="mail" value="<?php echo $mail_recall; ?>"/><?php echo $req; ?><br/>
  <label>Vérification du mail</label><br/>
    <input type="text" name="checkmail" value="<?php echo $mail_recall; ?>"/><?php echo $req; ?><br/>
  <input type="submit" name="register" value="Inscription"/><br/>
  <span class="error_msg"> * = Champs requis </span>
</form>
