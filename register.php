<form name="regiser" action="index.php?page=register" method="post">
  <label>Login : </label>
    <input type="text" name="login" placeholder="" required/><br/>

  <label>Mot de passe : </label>
    <input type="password" name="password" placeholder="" required/><br/>

  <label>Vérification mot de passe : </label>
    <input autocomplete="off" type="password" name="password_check" placeholder="" required/><br/>

  <label>Email : </label>
    <input type="email" name="email" placeholder="" required/><br/>

  <label>Vérification email : </label>
    <input autocomplete="off" type="email" name="email_check" placeholder="" required/><br/>

    <input type="submit" name="reg_submit" value="Inscription"/>
</form>
