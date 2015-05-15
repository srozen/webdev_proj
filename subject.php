<?php

  $subject = load_subject($_GET['subjectid']);
  if(isset($_GET['pageid']))
  {
    $page = load_page($_GET['pageid']);
  }
  else
  {
    $page = null;
  }

  $owner = (logged() AND $subject->getAuthorId() == $_SESSION['user']->getId());
  $page_related = page_related($subject, $page);

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
    $subject->reload();
    display_subject($subject);
    display_subject_pages($subject, $owner);
  }

  if(isset($_GET['action']) AND $_GET['action'] == 'displaypage' AND $page_related)
  {
    display_page($subject, $page);
  }
  if(isset($_GET['action']) AND $_GET['action'] == 'modifpage' AND $page_related AND $owner)
  {
    modify_page_form($subject, $page);
  }

?>
