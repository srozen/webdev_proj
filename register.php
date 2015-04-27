<?php

  if(logged())
  {
    header("Location: index.php");
    die();
  }

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
      echo '<span class="success_msg"> Un mail d\'activation va vous êtres envoyé à  : '. $_POST['mail'] . '</span></br>';
      create_new_user($_POST['login'], $_POST['password'], $_POST['mail'], $config, $dbsocket);

      $code = generate_activation_code($_POST['mail'], $_POST['login']);
      $userid = get_user_value('id', 'login', $_POST['login'], $dbsocket);
      add_activation_code($userid, $code, $dbsocket);

      send_registration_mail($_POST['mail'], $code, $_POST['login']);
    }
  }
?>

<?php echo $register_log['message']; ?>
<form name="regiser" action="index.php?page=register" method="post">
  <label>Login : </label><br/>
    <input type="text" size="<?php echo $config['LOGIN']['size']; ?>" maxlength="<?php echo $config['LOGIN']['maxlength']; ?>" value =" <?php echo $register_log['login']; ?>" class="<?php echo $register_log['loginclass']; ?>" name="login" />
    <?php
      echo '<small>' . ($config['LOGIN']['minlength']+1) . ' à ' . $config['LOGIN']['maxlength'] . ' caractères chiffres ou lettres.</small><br/>';
      echo $register_log['loginmessage'];
    ?>

  <label>Mot de passe : </label><br/>
    <input type="password" size="<?php echo $config['PASSWORD']['size']; ?>" maxlength="<?php echo $config['PASSWORD']['maxlength']; ?>" class="<?php echo $register_log['passwordclass']; ?>" name="password" placeholder="" />
    <?php
      echo '<small>' . ($config['PASSWORD']['minlength']+1) . ' à ' . $config['PASSWORD']['maxlength'] . ' , minimum une majuscule, minuscule, chiffre.</small><br/>';
      echo $register_log['passwordmessage'];
    ?>

  <label>Vérification mot de passe : </label><br/>
    <input autocomplete="off"  size="<?php echo $config['PASSWORD']['size']; ?>" maxlength="<?php echo $config['PASSWORD']['maxlength']; ?>" type="password" class="<?php echo $register_log['passwordclass']; ?>" name="checkpassword" placeholder="" /><br/>

  <label>Adresse mail : </label><br/>
    <input type="text" size="<?php echo $config['EMAIL']['size']; ?>" maxlength="<?php echo $config['EMAIL']['maxlength']; ?>" value="<?php echo $register_log['mail']; ?>" class="<?php echo $register_log['mailclass']; ?>" name="mail" placeholder="" /><br/>
    <?php
      echo $register_log['mailmessage'];
    ?>

  <label>Vérification du mail : </label><br/>
    <input autocomplete="off" size="<?php echo $config['EMAIL']['size']; ?>" maxlength="<?php echo $config['EMAIL']['maxlength']; ?>" type="text" class="<?php echo $register_log['mailclass']; ?>" name="checkmail" placeholder="" /><br/>

    <input type="submit" name="reg_submit" value="Inscription"/>
</form>
