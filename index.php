<?php
/***********************
 * MAIN CONTAINER PAGE *
 ***********************/

  session_start();
  include_once('functions.index.php');

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="css/main.css"/>
    <title>Accueil</title>
  </head>

  <body>

    <header>
      <h3>Menu : </h3><nav><?php echo create_menu(); ?> </nav>
    </header>

    <section>
      <h1>Corps de page</h1>
    </section>

    <footer>
      <span>Copyright Samuel Monroe 2014 - 2015 <a href="mailto:spat.monroe@gmail.com">Contact</a></span>
    </footer>

  </body>

</html>
