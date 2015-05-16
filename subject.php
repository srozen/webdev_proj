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

  $authorized = (logged() AND !frozen($_SESSION['user']->getId()) AND !reactivating($_SESSION['user']->getId()) AND (($subject->getAuthorId() == $_SESSION['user']->getId()) OR ($subject->getModerator() == $_SESSION['user']->getId()) OR (admin($_SESSION['user']->getId()))));
  $page_related = page_related($subject, $page);

  if(isset($_POST['modify_subject']))
  {
    if(isset($_POST['visibility_modo'])) $visibility_modo = $_POST['visibility_modo']; else $visibility_modo = null;
    if(isset($_POST['visibility_admin'])) $visibility_admin = $_POST['visibility_admin']; else $visibility_admin = null;
    save_subject_modification($subject, $_POST['title'], $_POST['description'], $_POST['visibility_author'], $visibility_modo, $visibility_admin);
  }
  if(isset($_POST['modify_page']))
  {
    save_page_modification($page, sanitize($_POST['keyword']), sanitize($_POST['content']));
  }

  if(isset($_GET['action']) AND $_GET['action'] == 'modifsubject' AND logged() AND $authorized)
  {
    modify_subject_form($subject);
  }
  else
  {
    $subject->reload();
    display_subject($subject, $authorized);
    display_subject_pages($subject, $authorized);
  }

  if(isset($_GET['action']))
  {
    if($_GET['action'] == 'displaypage' AND $page_related)
    {
      $page->reload();
      echo '<hr/><h1>Page : </h1>';
      display_page($subject, $page);
    }
    if($_GET['action'] == 'modifpage' AND $page_related AND $authorized)
    {
      modify_page_form($subject, $page);
    }
    if($_GET['action'] == 'createpage' AND $authorized)
    {
      if(isset($_POST['create_page']))
      {
        save_new_page($subject, $_POST['keyword'], $_POST['content']);
      }
      if(isset($_GET['keyword'])) create_page_form($subject, $_GET['keyword']);
      else create_page_form($subject);
    }
  }


?>
