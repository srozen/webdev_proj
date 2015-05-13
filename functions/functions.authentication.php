<?php

  function logged()
  {
    if (isset($_SESSION['logged'])) return $_SESSION['logged'];
    else return false;
  }

  /*********************
  * STATUS LEVEL CHECK *
  **********************/

  function admin_level($userid)
  {
    return( get_user_statuslevel($userid) <= 0);
  }

  function moderator_level($userid)
  {
    return( get_user_statuslevel($userid) <= 10);
  }

  function user_level($userid)
  {
    return( get_user_statuslevel($userid) <= 20);
  }

  /***********************************************
  * SIMPLE STATUS CHECK FUNCTIONS BASED ON LABEL *
  ************************************************/

  function admin($userid)
  {
    return (is_user_status('admin', $userid));
  }

  function moderator($userid)
  {
    return (is_user_status('moderator', $userid));
  }

  function normal($userid)
  {
    return (is_user_status('normal', $userid));
  }

  function activating($userid)
  {
    return (is_user_status('activating', $userid));
  }

  function reactivating($userid)
  {
    return (is_user_status('reactivating', $userid));
  }

  function lostpassword($userid)
  {
    return (is_user_status('lostpassword', $userid));
  }

  function frozen($userid)
  {
    return (is_user_status('frozen', $userid));
  }

  function unregistered($userid)
  {
    return (is_user_status('unregistered', $userid));
  }

  function banned($userid)
  {
    return (is_user_status('banned', $userid));
  }

  function indoor_auth($password)
  {
    $query = 'SELECT count(*)
              FROM user
              WHERE id = \'' . $_SESSION['user']->getId() . '\' AND password = \'' . encrypt($password) . '\';';
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

?>
