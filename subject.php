<?php

  $subject = load_subject($_GET['subjectid']);

  $owner = (logged() AND $subject->getAuthorId() == $_SESSION['user']->getId());

  if(isset($_POST['modify_subject']))
  {
    save_subject_modification($subject, $_POST['title'], $_POST['description'], $_POST['visibility_author']);
  }

  if(isset($_GET['action']) AND $_GET['action'] == 'modifsubject' AND logged() AND $owner)
  {
    modify_subject_form($subject);
  }
  else
  {
    if(logged() AND $subject->getAuthorId() == $_SESSION['user']->getId())
    {
      echo '<a href="index.php?page=subject&subjectid=' . $subject->getId() . '&action=modifsubject"> Modifier le sujet </a><br/>';
    }
    echo '<span><b> Titre : </b></span>' . $subject->getTitle() . '<br/>';
    echo '<span><b> Auteur : </b></span>' . $subject->getAuthorName() .'<br/>';
    echo '<span><b> Description : </b></span>' . $subject->getDescription() . '<br/>';
    echo '<span><b> Modifié le : </b></span>' . $subject->getLastModification() . '<br/><br/>';

    echo '<h4> Pages du sujet : </h4>';
    display_subject_pages($subject, $owner);
  }

?>
