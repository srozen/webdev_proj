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
   * @param $mail - User mail to create unique code
   * @param $login - User login to create unique code
   *
   * @return Hashed code
  */
  function generate_code($mail,$login)
  {
    return hash('sha1', mt_rand(10000,99999).time().$mail.$login, false);
  }


  function create_new_user($login, $password, $mail)
  {

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

  function remove_status($user_id, $status_id)
  {
    $query = 'DELETE from user_status
              WHERE user_id = \'' . $user_id . '\'
              AND status_id = \'' . $user_id . '\';';
    $GLOBALS['dbsocket']->exec($query);
  }
