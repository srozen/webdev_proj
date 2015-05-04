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
        echo 'le user existe';
      }
      else
      {
        echo 'Mauvaise combinaison login mdp';
      }
    }
    else
    {
      echo 'Les champs ne sont pas remplis !!! ';
    }
  }

  function activation($userid)
  {

  }

  function grant_access($userid)
  {
    update_lastlogin($userid);
  }

  function update_lastlogin($userid)
  {
    $lastlogin = get_user_value('currentlogin', 'id', $userid);
    set_user_value('lastlogin', $lastlogin, $userid);
    set_user_value('currentlogin', 'NOW()', $userid);
  }
