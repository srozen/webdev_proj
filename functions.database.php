<?php

/**************************************
 * FUNCTIONS USED TO GET INFO FROM DB *
 ************************************** /

/* Returns boolean, check if login is in database */
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
