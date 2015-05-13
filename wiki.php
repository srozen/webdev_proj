<?php

  search_wiki_form();

  if(logged() AND !banned($_SESSION['user']->getId()) AND !frozen($_SESSION['user']->getId()) AND !unregistered($_SESSION['user']->getId()) AND !reactivating($_SESSION['user']->getId()))
  {
    create_wiki_form();
  }

  if(isset($_POST['search_wiki']))
  {
    search_wiki($_POST['title'], $_POST['description'], $_POST['keyword']);
  }

?>
