<?php
/*****************************************************
 * PREDICATES TO MANAGE ACCESS RIGHTS ON THE WEBSITE *
 *****************************************************/

function logged()
{
  if (isset($_SESSION['logged'])) return $_SESSION['logged'];
  else return false;
}

function is_admin($user)
{
  return ($user->getClass() == 'admin');
}

function indoor_auth($password, $config, $dbsocket)
{
  $query = 'SELECT count(*)
            FROM user
            WHERE login = \'' . $_SESSION['user']->getLogin() . '\' AND password = \'' . encrypt($password, $config['PASSWORD']['password_crypto']) . '\';';
  $result = $dbsocket->query($query);

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
