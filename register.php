<?php

  $register_log = array(
    "message" => "",
    "valid" => "",
    "loginmessage" => "",
    "loginclass" => "",
    "login" => "",
    "mailmessage" => "",
    "mailclass" => "",
    "mail" => "",
    "passwordmessage" => "",
    "passwordclass" => ""
  );

  if(isset($_POST['reg_submit']))
  {
    $register_log = check_register($_POST['login'], $_POST['mail'], $_POST['checkmail'], $_POST['password'], $_POST['checkpassword'], $config, $dbsocket);
    if($register_log['valid'])
    {
      echo '<span> Les données user suivantes vont être encodées en base de donnée : </span></br><pre>';
      print_r(create_new_user($_POST['login'], $_POST['password'], $_POST['mail'], $config, $dbsocket));
      echo '</pre>';
      // Generate activation code
        $code = generate_activation_code($_POST['mail'], $_POST['login']);
      // Create new user

      // Add activation link into db

      // Send email
        send_registration_mail($_POST['mail'], $code, $_POST['login']);
    }
  }
?>

<?php echo $register_log['message']; ?>
<form name="regiser" action="index.php?page=register" method="post">
  <label>Login : </label><br/>
    <input type="text" value ="<?php echo $register_log['login']; ?>" class="<?php echo $register_log['loginclass']; ?>" name="login" />
    <?php
      echo '<small>' . $LOGIN_REQUIREMENTS . '</small><br/>';
      echo $register_log['loginmessage'];
    ?>

  <label>Mot de passe : </label><br/>
    <input type="password" class="<?php echo $register_log['passwordclass']; ?>" name="password" placeholder="" />
    <?php
      echo '<small>' . $PASSWORD_REQUIREMENTS . '</small><br/>';
      echo $register_log['passwordmessage'];
    ?>

  <label>Vérification mot de passe : </label><br/>
    <input autocomplete="off" type="password" class="<?php echo $register_log['passwordclass']; ?>" name="checkpassword" placeholder="" /><br/>

  <label>Adresse mail : </label><br/>
    <input type="text" value="<?php echo $register_log['mail']; ?>" class="<?php echo $register_log['mailclass']; ?>" name="mail" placeholder="" /><br/>
    <?php
      echo $register_log['mailmessage'];
    ?>

  <label>Vérification du mail : </label><br/>
    <input autocomplete="off" type="text" class="<?php echo $register_log['mailclass']; ?>" name="checkmail" placeholder="" /><br/>

    <input type="submit" name="reg_submit" value="Inscription"/>
</form>
