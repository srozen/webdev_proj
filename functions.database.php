<?php

/********************************************
 * FUNCTIONS USED TO INTERACT WITH DATABASE *
 ********************************************/


/* Returns boolean, check if $field is already in database */
// USE : user_exists('id', 1, $dbsocket); "Is the id 1 in user table?" //
function user_exists($field, $value, $dbsocket)
{
  $query = 'SELECT count(*)
            FROM user
            WHERE ' . $field . ' = \'' . $value . '\';';

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

/* Return a user value from a known $col $colvalue */
// USE : get_user_value('login', 'id', '1', $dbsocket); "Get me the login value for id 1" //
function get_user_value($value, $col, $colvalue, $dbsocket)
{
  $query = 'SELECT ' . $value . '
            FROM user
            WHERE ' . $col . ' = \'' . $colvalue . '\';';

  $result = $dbsocket->query($query);
  $uservalue = $result->fetch();

  return $uservalue[$value];
}

/* Update a targeted user from a $userid with designated $field with a $value */
// USE : set_user_value('login', 'johnsmith', '24', $dbsocket); "Set user 24 login with 'johnsmith'" //
function set_user_value($field, $value, $userid, $dbsocket)
{
  $query = 'UPDATE user
            SET ' . $field . ' =\'' . $value . '\'
            WHERE user_id =\'' . $userid . '\';';

  $result = $dbsocket->exec($query);
  return $result;
}

/* Return an activation code from a $userid */
// USER : get_activation_code(1, $dbsocket); "Get me the activation code for user 1" //
function get_activation_code($userid, $dbsocket)
{
  $query = 'SELECT code
            FROM activation
            WHERE user_id = \'' . $userid . '\';';
  $result = dbsocket->query($query);
  $activation = $result->fetch();

  return $activation['code'];
}
