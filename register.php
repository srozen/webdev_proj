<?php

  $login_recall = $mail_recall = '';

  if(isset($_POST['register']))
  {
    // Checking login and recalling it if valid
    $valid_form = check_login($_POST['login']);
    if($valid_form) $login_recall = $_POST['login'];
    // Checking mail and recalling it if valid
    $valid_form = check_mails($_POST['mail'], $_POST['checkmail']);
    if($valid_form) $mail_recall = $_POST['mail'];
    // Checking if passwords are valid
    $valid_form = check_passwords($_POST['password'], $_POST['checkpassword']);


    if($valid_form)
    {
      //registration($_POST['login'], $_POST['mail'], $_POST['password'])
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
    <input type="text" name="checkmail"/><?php echo $req; ?><br/>
  <input type="submit" name="register" value="Inscription"/><br/>
  <span class="error_msg"> * = Champs requis </span>
</form>
