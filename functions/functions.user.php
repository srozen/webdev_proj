<?php
  /**************************
   * USER RELATED FUNCTIONS *
   **************************/

  /**
   * @param $field - Specify which column to search in
   * @param $value - Specify value to look for
   *
   * @return Boolean telling if the value has been found
  */

  function user_exists($field, $value)
  {
    $query = 'SELECT count(*)
              FROM user
              WHERE ' . $field . ' = \'' . $value . '\';';

    $result = $GLOBALS['dbsocket']->query($query);

    if($result->fetchColumn() > 0)
    {
      return true;
    }
    else
    {
      return false;
    }
  }

  function is_user_status($status, $userid)
  {
    $query = 'SELECT count(*)
              FROM user_status
              WHERE user_id = \'' . $userid . '\' AND
              status_id = (SELECT id
              FROM status
              WHERE label = \'' . $status . '\');';

    $result = $GLOBALS['dbsocket']->query($query);

    if($result->fetchColumn() > 0)
    {
      return true;
    }
    else
    {
      return false;
    }
  }

  function is_user_statusid($statusid, $userid)
  {
    $query = 'SELECT count(*)
              FROM user_status
              WHERE user_id = \'' . $userid . '\' AND
              status_id = ' . $statusid . ';';

    $result = $GLOBALS['dbsocket']->query($query);

    if($result->fetchColumn() > 0)
    {
      return true;
    }
    else
    {
      return false;
    }
  }

  function get_user_status($userid)
  {
    $query = 'SELECT label from status where id in (select status_id from user_status where user_id = ' . $userid . ');';
    $result = $GLOBALS['dbsocket']->query($query);
    $array_status = $result->fetchAll(PDO::FETCH_ASSOC);
    return $array_status;
  }

  /**
   * Returns a value by looking for a know value in a known column
   * @param $value - String, column name, of the wanted value
   * @param $col - String, column name, of the known value
   * @param $colvalue - String, column value
   *
   * @return Wanted value
  */
  function get_user_value($value, $col, $colvalue)
  {
    $query = 'SELECT ' . $value . '
              FROM user
              WHERE ' . $col . ' = \'' . $colvalue . '\';';

    $result = $GLOBALS['dbsocket']->query($query);
    $uservalue = $result->fetch();

    return $uservalue[$value];
  }

  function set_user_value($field, $value, $userid)
  {
    if($value == 'NOW()')
    {
      $set = 'SET ' . $field . ' = NOW() ';
    }
    else
    {
      $set = 'SET ' . $field . ' = \'' . $value . '\'';
    }

    $query = 'UPDATE user ' . $set . ' WHERE id =\'' . $userid . '\';';

    $result = $GLOBALS['dbsocket']->exec($query);

    return $result;
  }

  /**
   * @param $mail - User mail to create unique code
   * @param $login - User login to create unique code
   *
   * @return Hashed code
  */
  function generate_code($login, $mail)
  {
    return hash('sha1', mt_rand(10000,99999).time().$mail.$login, false);
  }


  function create_new_user($login, $password, $mail)
  {
    $hashed = encrypt($password);

    $query = 'INSERT into user(login, password, mail, register)
              VALUES (:login, :password, :mail, NOW());';

    $result = $GLOBALS['dbsocket']->prepare($query);

    $result->execute(array(
      'login' => $login,
      'password' => $hashed,
      'mail' => $mail
    ));

  }

  function get_activation_code($userid)
  {
    $query = 'SELECT code
              FROM activation
              WHERE user_id = \'' . $userid . '\'
              AND recovery = false;';
    $result = $GLOBALS['dbsocket']->query($query);
    $activation = $result->fetch();

    return $activation['code'];
  }

  function get_reactivation_code($userid)
  {
    $query = 'SELECT code
              FROM activation
              WHERE user_id = \'' . $userid . '\'
              AND recovery = true;';
    $result = $GLOBALS['dbsocket']->query($query);
    $activation = $result->fetch();

    return $activation['code'];
  }

  function add_activation_code($userid, $code, $recovery = 0)
  {
    $query = 'INSERT INTO activation (user_id, code, recovery)
              VALUES(:user_id, :code, :recovery)';
    $result = $GLOBALS['dbsocket']->prepare($query);
    $result->execute(array(
      'user_id' => $userid,
      'code' => $code,
      'recovery' => $recovery
    ));
  }

  function remove_activation_code($userid)
  {
    $query = 'DELETE from activation
              WHERE user_id = \'' . $userid . '\'
              AND recovery = false;';
    $GLOBALS['dbsocket']->exec($query);
  }

  function remove_reactivation_code($userid)
  {
    $query = 'DELETE from activation
              WHERE user_id = \'' . $userid . '\'
              AND recovery = true;';
    $GLOBALS['dbsocket']->exec($query);
  }

  function add_user_status($userid, $statusid, $send_notification = false)
  {
    $query = 'INSERT into user_status(user_id, status_id, date)
              VALUES (:userid, :statusid, NOW());';

    $result = $GLOBALS['dbsocket']->prepare($query);

    $result->execute(array(
      'userid' => $userid,
      'statusid' => $statusid
    ));

    if($send_notification)
    {
      $mail = get_user_value('mail', 'id', $userid);
      send_status_notification($mail, $statusid, 'add');
    }
  }

  function remove_user_status($userid, $statusid, $send_notification = false)
  {
    $query = 'DELETE from user_status
              WHERE user_id = \'' . $userid . '\'
              AND status_id = \'' . $statusid . '\';';
    $GLOBALS['dbsocket']->exec($query);

    if($send_notification)
    {
      $mail = get_user_value('mail', 'id', $userid);
      send_status_notification($mail, $statusid, 'remove');
    }
  }
