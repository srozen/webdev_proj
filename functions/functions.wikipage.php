<?php

  function create_start_page($subject_id)
  {
      $query = 'INSERT INTO page(subject_id, creation)
                VALUES(:subject_id, NOW());';

      $result = $GLOBALS['dbsocket']->prepare($query);

      $result->execute(array(
        'subject_id' => $subject_id
      ));
  }

  function get_page_value($value, $col, $colvalue)
  {
    $query = 'SELECT ' . $value . '
              FROM page
              WHERE ' . $col . ' = \'' . $colvalue . '\';';

    $result = $GLOBALS['dbsocket']->query($query);
    $page = $result->fetch();

    return $page[$value];
  }
