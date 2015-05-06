<?php

  function get_status_label($status_id, $translated = false)
  {
    $query = 'SELECT label FROM status WHERE id = ' . $status_id . ';';
    $result = $GLOBALS['dbsocket']->query($query);
    $status = $result->fetch();

    if($translated)
    {
      return translate_status($status['label']);
    }
    else
    {
      return $status['label'];
    }
  }
