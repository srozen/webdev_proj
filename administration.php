<?php
  if(!logged())
  {
    header("Location: index.php");
    die();
  }
  else if(!admin($_SESSION['user']->getId()))
  {
    header("Location: index.php");
    die();
  }

  echo administration_panel();
  display_manage();
?>
