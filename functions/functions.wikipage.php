<?php

  function create_start_page($subject_id)
  {
      $query = 'INSERT INTO page(subject_id, creation)
                VALUES(:subject_id, NOW());';

      $result = $GLOBALS['dbsocket']->prepare($query);

      $result->execute(array(
        'subject_id' => $subject_id
      ));
  }

  function display_page($subject, $page)
  {
    if(logged() AND $subject->getAuthorId() == $_SESSION['user']->getId())
    {
      echo '<a href="index.php?page=subject&subjectid=' . $subject->getId() . '&action=modifpage&pageid=' . $page->getId() . '"> Modifier la page </a><br/>';
    }
    echo '<span><b> Mot clé : </b></span><br/>' . $page->getKeyword() . '<br/>';
    echo '<span><b> Modifié le : </b></span><br/>' . $page->getLastModification() . '<br/>';
    echo '<span><b> Contenu : </b></span><br/>' . $page->getContent() . '<br/><br/>';
  }

  function modify_page_form($subject, $page)
  {
    echo '<a href="index.php?page=subject&subjectid=' . $subject->getId() . '&action=displaypage&pageid=' . $page->getId() . '"> Retour à la page </a><br/>
          <form name="create_page" action="index.php?page=subject&subjectid=' . $subject->getId() .'&action=displaypage&pageid=' . $page->getId() . '" method="post">
            <h3> Modification de la page : </h3>
            <label> Mot-clé : </label><br/>
              <input type="text" name="title" value="' . $page->getKeyword() .'" /><br/>
            <label> Contenu : </label><br/>
              <textarea rows="6" cols="50" name="description">' . $page->getContent() .'</textarea><br/>
            <input type="submit" name="modify_page"/>
          </form>';
  }

  function load_page($pageid)
  {
    if(filled($pageid))
    {
      if(page_exists('id', $pageid))
      {
        return new Wikipage($pageid);
      }
      else
      {
        return null;
      }
    }
    else
    {
      return null;
    }
  }

  function page_related($subject, $page)
  {
    if($page != null)
    {
      return ($subject->getId() == $page->getSubjectId());
    }
    else
    {
      return false;
    }
  }

  function get_page_value($value, $col, $colvalue)
  {
    $query = 'SELECT ' . $value . '
              FROM page
              WHERE ' . $col . ' = \'' . $colvalue . '\';';

    $result = $GLOBALS['dbsocket']->query($query);
    $page = $result->fetch();

    return $page[$value];
  }

  function page_exists($field, $value)
  {
    $query = 'SELECT count(*)
              FROM page
              WHERE ' . $field . ' = \'' . $value . '\';';

    $result = $GLOBALS['dbsocket']->query($query);

    if($result->fetchColumn() > 0)
    {
      return true;
    }
    else
    {
      return false;
    }
  }
