<?php

  search_wiki_form();

  if(isset($_POST['search_wiki']))
  {
    search_wiki(sanitize($_POST['title']), sanitize($_POST['description']), sanitize($_POST['keyword']));
  }

  if(logged() AND !banned($_SESSION['user']->getId()) AND !frozen($_SESSION['user']->getId()) AND !unregistered($_SESSION['user']->getId()) AND !reactivating($_SESSION['user']->getId()))
  {
    create_subject_form();
    if(isset($_POST['create_wiki']))
    {
      if(filled($_POST['title'], $_POST['description'], $_POST['visibility_author']))
      {
        create_new_subject(sanitize($_POST['title']), sanitize($_POST['description']), sanitize($_POST['visibility_author']), $_SESSION['user']->getId());
      }
      else
      {
        echo '<div class="error_msg"> Les champs de création de sujet doivent être remplis ! </div>';
      }
    }
  }
?>
