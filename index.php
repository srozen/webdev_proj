<?php
/***********************
 * MAIN CONTAINER PAGE *
 ***********************/

  session_start();

  try
  {
    $dbsocket = new PDO('mysql:host=localhost; dbname=1415he201041; charset=utf8', 'MONROE', 'Samuel');
    $dbsocket->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
  catch(Exception $e)
  {
    die('Erreur : '.$e->getMessage());
    echo 'Database connexion failed';
  }



  $config = parse_ini_file('config.ini', true);

  // Include functions and classes files
  include('functions.index.php');
  include('functions.input.php');
  include('functions.register.php');
  include('functions.database.php');

  include('class.page.php');

  include('constants.text.php');

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
      <h1><?php echo $config['GLOBAL']['title'];?></title></h1>
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
