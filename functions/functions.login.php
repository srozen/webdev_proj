<?php

  function login($login, $password, $code)
  {
    if(filled($login) AND filled($password))
    {
      $query = 'SELECT id
                FROM user
                WHERE login = \'' . $login . '\'
                AND password = \'' . encrypt($password) . '\'';

      $result = $GLOBALS['dbsocket']->query($query);

      $user = $result->fetch(PDO::FETCH_ASSOC);

      if(!empty($user))
      {
        if(activating($user['id']))
        {
          activation($user['id'], $code);
        }
        else if(reactivating($user['id']))
        {
          reactivation($user['id'], $code);
        }
        else if(lostpassword($user['id']))
        {
          $message = 'Demande de changement de mot de passe annulée !';
          $url = '?message='.$message;
          remove_user_status($user['id'], 6);
          remove_activation_code($user['id']);
          grant_access($user['id'], $url);
        }
        else if(banned($user['id']))
        {
          echo '<div class="error_msg"> Vous êtes banni ! </div>';
          die();
        }
        else
        {
          grant_access($user['id']);
        }
      }
      else
      {
        echo '<div class="error_msg"> Mauvaise combinaison login/mot de passe.</div>';
      }
    }
    else
    {
      echo '<div class="error_msg"> Vous devez remplir tout les champs pour vous connecter.</div>';
    }
  }

  function activation($userid, $code)
  {
    if(filled($code))
    {
      if(get_activation_code($userid) == $code)
      {
        set_user_value('lastlogin', 'NOW()', $userid);
        set_user_value('currentlogin', 'NOW()', $userid);
        set_user_value('activation', 'NOW()', $userid);

        remove_user_status($userid, 4);
        remove_activation_code($userid);
        grant_access($userid);
      }
      else
      {
        echo '<div class="error_msg"> Le code d\'activation fourni n\'est pas valide.</div>';
      }
    }
    else
    {
      echo '<div class="error_msg"> Vous devez vous connecter via le mail d\'activation!</div>';
    }
  }

  function reactivation($userid, $code)
  {
    if(filled($code))
    {
      if(get_reactivation_code($userid) == $code)
      {
        remove_user_status($userid, 5);
        remove_reactivation_code($userid);
        grant_access($userid);
      }
      else
      {
        echo '<div class="error_msg"> Le code de réactivation fourni n\'est pas valide.</div>';
      }
    }
    else
    {
      grant_access($userid);
    }
  }

  function grant_access($userid, $message = null)
  {
    update_lastlogin($userid);
    $_SESSION['logged'] = true;
    $_SESSION['user'] = new User($userid);
    header('Location: index.php' . $message);
  }

  function update_lastlogin($userid)
  {
    $lastlogin = get_user_value('currentlogin', 'id', $userid);
    set_user_value('lastlogin', $lastlogin, $userid);
    set_user_value('currentlogin', 'NOW()', $userid);
  }
