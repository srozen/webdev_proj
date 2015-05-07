<?php

  function logged()
  {
    if (isset($_SESSION['logged'])) return $_SESSION['logged'];
    else return false;
  }

  function admin($userid)
  {
    return (is_user_status('admin', $userid));
  }

  function subadmin($userid)
  {
    return (is_user_status('subadmin', $userid));
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
