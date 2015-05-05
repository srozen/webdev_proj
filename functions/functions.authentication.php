<?php

  function logged()
  {
    if (isset($_SESSION['logged'])) return $_SESSION['logged'];
    else return false;
  }

  function admin($userid)
  {
    return(is_user_status('admin', $userid));
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
