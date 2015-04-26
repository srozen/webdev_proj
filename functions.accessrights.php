<?php

/*****************************************************
 * PREDICATES TO MANAGE ACCESS RIGHTS ON THE WEBSITE *
 *****************************************************/

function logged()
{
  if (isset($_SESSION['logged'])) return $_SESSION['logged'];
  else return false;
}

?>
