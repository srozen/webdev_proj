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

  function user_exists()
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
