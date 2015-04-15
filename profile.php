<?php
  if(!logged())
  {
    header("Location: index.php?page=login");
		die();
  }

  echo '<pre>';
  print_r($_SESSION['user']);

  echo 'Login : ' . $_SESSION['user']->getLogin();
  echo '</pre>';
?>
