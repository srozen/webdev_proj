<?php
/***********************
 * MAIN CONTAINER PAGE *
 ***********************/


  include('classes/class.page.php');
  include('classes/class.user.php');

  $config = parse_ini_file('config.ini', true);

  session_name($config['SESSION']['name']);
  session_start();

  try
  {
    $dbsocket = new PDO('mysql:host=localhost; dbname=' . $config['DATABASE']['name'] . '; charset=utf8', $config['DATABASE']['login'], $config['DATABASE']['password']);
    $dbsocket->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
  catch(Exception $e)
  {
    die('Erreur : '.$e->getMessage());
    echo 'Database connexion failed';
  }


  // Include functions and classes files
  include('functions/functions.index.php');
  include('functions/functions.input.php');
  include('functions/functions.register.php');
  include('functions/functions.login.php');
  include('functions/functions.database.php');
  include('functions/functions.accessrights.php');
  include('functions/functions.messenger.php');
  include('functions/functions.profile.php');
  include('functions/functions.administration.php');


  // Creating the Page object
  if(isset($_GET['page']))  $page = create_page($_GET['page']);
  else $page = create_page('index');
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="css/main.css"/>
    <title><?php echo $config['GLOBAL']['title'] . ' - ' . $page->getTabTitle(); ?></title>
  </head>

  <body>

    <header>
      <img src="<?php echo $config['GLOBAL']['banner']; ?>" alt="Logo Ephec"/>
      <h1><?php echo $config['GLOBAL']['title'];?></h1>
      <h2><?php if(logged()) echo 'Bienvenue user'; else echo 'Bienvenue anonyme'; ?></h2>
      <h3>Description de la session</h3>
      <?php echo '<pre>'; echo print_r($_SESSION); echo ' </pre>';?>
      <nav><span>Menu : </span><?php create_menu(); ?> </nav>
    </header>

    <section>
      <h1>Corps de page</h1>
      <?php
        echo '<h2>' . $page->getTitle() . '</h2>';
        include($page->getUrl());
      ?>
    </section>

    <footer>
      <span><?php echo $config['GLOBAL']['copyright'] . ' ';?><a href="mailto:<?php echo $config['ADMIN']['mail'];?>"><?php echo $config['ADMIN']['name'];?></a> - Code sous licence MIT</span>
    </footer>

  </body>

</html>

<?php
  $dbsocket = null;
?>
