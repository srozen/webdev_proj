<?php
/*****************************************************
 * SET OF FUNCTIONS USED TO MANAGE USER PROFILE PAGE *
 *****************************************************/

  function update_user_mail($user, $mail, $mailcheck, $config, $dbsocket)
  {
    $vmail = check_mails($mail, $mailcheck, $config, $dbsocket);
    if($vmail == true)
    {
      $user->update('mail', $mail, $dbsocket);
      echo '<span class="success_msg"> Le mail a été changé !! </span><br/>';
    }
    else
    {
      echo $vmail;
    }
  }

  function update_user_login($user, $login, $password, $config, $dbsocket)
  {
    $vlogin = check_login($login, $config, $dbsocket);
    if($vlogin == true)
    {
      $user->update('login', $login, $dbsocket);
      echo '<span class="success_msg"> Le login a été changé !! </span><br/>';
    }
    else
    {
      echo $vlogin;
    }
  }

  function update_user_password()
  {

  }

  function update_user_avatar()
  {

  }

  function profile_auth($password, $config, $dbsocket)
  {
    return filled($password) AND indoor_auth($password, $config, $dbsocket);
  }
 ?>
