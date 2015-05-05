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
        if(is_user_status('activating', $user['id']))
        {
          activation($user['id'], $code);
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

  function grant_access($userid)
  {
    update_lastlogin($userid);
    $_SESSION['logged'] = true;
    $_SESSION['user'] = new User($userid);
    header("Location: index.php");
  }

  function update_lastlogin($userid)
  {
    $lastlogin = get_user_value('currentlogin', 'id', $userid);
    set_user_value('lastlogin', $lastlogin, $userid);
    set_user_value('currentlogin', 'NOW()', $userid);
  }
