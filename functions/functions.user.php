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

  function add_activation_code($userid, $code)
  {
    $query = 'INSERT INTO activation (user_id, code)
              VALUES(:userid, :code)';
    $result = $GLOBALS['dbsocket']->prepare($query);
    $result->execute(array(
      'userid' => $userid,
      'code' => $code
    ));
  }

  function add_status($user_id, $status_id)
  {
    $query = 'INSERT into user_status(user_id, status_id, date)
              VALUES (:userid, :statusid, NOW());';

    $result = $GLOBALS['dbsocket']->prepare($query);

    $result->execute(array(
      'userid' => $user_id,
      'status_id' => $status_id
    ));
  }

  function remove_activation_code($userid)
  {
    $query = 'DELETE from activation
              WHERE user_id = \'' . $userid . '\'
              AND recovery = false;';
    $GLOBALS['dbsocket']->exec($query);
  }

  function remove_status($user_id, $status_id)
  {
    $query = 'DELETE from user_status
              WHERE user_id = \'' . $user_id . '\'
              AND status_id = \'' . $user_id . '\';';
    $GLOBALS['dbsocket']->exec($query);
  }
