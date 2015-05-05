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

?>
