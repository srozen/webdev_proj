<?php

/**************************************
 * FUNCTIONS USED TO GET INFO FROM DB *
 ************************************** /

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

  $result = $dbsocket->qiery($query);
  $uservalue = $result->fetch();

  return $uservalue[$value];
}
