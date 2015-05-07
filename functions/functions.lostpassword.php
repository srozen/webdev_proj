<?php

  function ask_password_recovery($mail)
  {
    if(user_exists('mail', $mail))
    {
      $userid = get_user_value('id', 'mail', $mail);

      $user = new User($userid);

      if($user->getSecret() == false)
      {
        echo '<div class="error_msg"> Vous n\'aviez pas rempli votre question secrète, veuillez contacter un administrateur. </div>';
      }
      else
      {
        if(!banned($user->getId()))
        {
          if(lostpassword($user->getId()))
          {
            echo '<div class="success_msg"> Vous êtes déjà en procédure de changement de mot de passe ! </div>';
            echo '<div class="success_msg"> Un mail de changement de mot de passe va vous être renvoyé sur votre adresse mail. </div>';
          }
          else
          {
            echo '<div class="success_msg"> Un mail de changement de mot de passe va vous être envoyé sur votre adresse mail. </div>';
            $code = generate_code($user->getLogin(), $user->getMail());
            add_activation_code($user->getId(), $code);
            add_user_status($user->getId(), 6);
            send_passwordrecovery_message($user->getMail(), $code);
          }
        }
        else
        {
          echo '<div class="success_msg"> Vous êtes banni du Wiki ! </div>';
        }
      }
    }
    else
    {
      echo '<div class="success_msg"> Cette adresse mail n\'est reliée à aucun compte ! </div>';
    }
  }
