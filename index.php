<?php

  /*********************************
   * START PAGE AND MAIN CONTAINER *
   *********************************/

  include('classes/class.page.php');

  $config = parse_ini_file('config.ini', true);

  session_name($config['SESSION']['session_name']);
  session_start();

  try
  {
    $dbsocket = new PDO('mysql:host=localhost; dbname=' . $config['DATABASE']['dbname'] . '; charset=utf8', $config['DATABASE']['dblogin'], $config['DATABASE']['dbpassword']);
    $dbsocket->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
  catch(Exception $e)
  {
    die('Erreur : '.$e->getMessage());
    echo 'Database connexion failed';
  }

  // Include functions and classes files
  include('functions/functions.index.php');

  ?>
