<form name="regiser" action="index.php?page=register" method="post">
  <label>Login : </label>
    <input type="text" name="login" placeholder="" required/><br/>

  <label>Mot de passe : </label>
    <input type="password" name="password" placeholder="" required/><br/>

  <label>Vérification mot de passe : </label>
    <input autocomplete="off" type="password" name="password_check" placeholder="" required/><br/>

  <label>Adresse mail : </label>
    <input type="email" name="mail" placeholder="" required/><br/>

  <label>Vérification du mail : </label>
    <input autocomplete="off" type="email" name="mail_check" placeholder="" required/><br/>

    <input type="submit" name="reg_submit" value="Inscription"/>
</form>
