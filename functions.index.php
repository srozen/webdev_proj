<?php
/***********************************************
 * SET OF FUNCTIONS USED TO LAY OUT INDEX PAGE *
 ***********************************************/

 /* Creates the menu for the <nav> bar in index */
 function create_menu()
 {
  $nav =  '<a href="index.php?page=index"> Accueil </a>';
  $nav .= '<a href="index.php?page=contact"> Contact </a>';

  $nav .= '<a href="index.php?page=register"> Inscription </a>';
  $nav .= '<a href="index.php?page=login"> Connexion </a>';

  echo $nav;
 }

 /* Return a page definition with a title, filename and text */
 function create_page($page)
 {
   $pvalues = page_values($page);
   return new Page($pvalues[0], $pvalues[1], $pvalues[2]);
 }


 /* Set the Page object values depending on the GET[page] element*/
 function page_values($page)
 {
   switch($page)
   {
     case 'index' :
       return $values = array('Accueil', 'welcome.php', 'Page d\'accueil');
       break;
     case 'contact' :
       return $values = array('Contact', 'contact.php', 'Page de contact');
       break;
     case 'register' :
       return $values = array('Inscription', 'register.php', 'Page d\'inscription');
       break;
     case 'login' :
       return $values = array('Connexion', 'login.php', 'Page de connexion');
       break;
     default :
       return $values = array('Accueil', 'welcome.php', 'Page d\'accueil');
       break;
   }
 }
?>
