<?php
/***********************
 * MAIN CONTAINER PAGE *
 ***********************/


  include('classes/class.page.php');
  include('classes/class.user.php');

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
      <nav><span>Menu : </span><?php create_menu(); ?> </nav>
    </header>

    <section>
      <?php
        echo '<h2>' . $page->getTitle() . '</h2>';
        include($page->getUrl());
      ?>
    </section>

    <footer>
      <span><?php echo $config['GLOBAL']['copyright'] . ' ';?><a href="mailto:<?php echo $config['ADMIN']['admin_mail'];?>"><?php echo $config['ADMIN']['admin_name'];?></a> - Code sous licence MIT</span>
    </footer>

  </body>

</html>

<?php
  $dbsocket = null;
?>
