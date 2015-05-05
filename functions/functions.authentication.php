<?php

  function logged()
  {
    if (isset($_SESSION['logged'])) return $_SESSION['logged'];
    else return false;
  }

?>
