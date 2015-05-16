<?php

  function create_start_page($subject_id, $start = false)
  {
      $query = 'INSERT INTO page(subject_id, creation, start)
                VALUES(:subject_id, NOW(), :start);';

      $result = $GLOBALS['dbsocket']->prepare($query);

      $result->execute(array(
        'subject_id' => $subject_id,
        'start' => $start
      ));
  }

  function create_page_form($subject, $keyword = '')
  {
    echo '<a href="index.php?page=subject&subjectid=' . $subject->getId() . '&action=displaypage"> Retour au sujet </a><br/>
          <form name="create_page" action="index.php?page=subject&subjectid=' . $subject->getId() .'&action=createpage" method="post">
            <h3> Création d\'une page : </h3>
            <label> Mot-clé : </label><br/>
              <input type="text" name="keyword" value="' . $keyword . '" /><br/>
            <label> Contenu : </label><br/>
              <textarea rows="6" cols="50" name="content"></textarea><br/>
            <input type="submit" name="create_page"/>
          </form>';
  }

  function display_page($subject, $page)
  {
    echo '<a href="index.php?page=subject&subjectid=' . $subject->getId() . '">Quitter page</a><br/>';
    if(logged() AND $subject->getAuthorId() == $_SESSION['user']->getId())
    {
      echo '<a href="index.php?page=subject&subjectid=' . $subject->getId() . '&action=modifpage&pageid=' . $page->getId() . '"> Modifier la page </a><br/>';
    }
    echo '<span><b> Mot clé : </b></span><br/>' . $page->getKeyword() . '<br/>';
    echo '<span><b> Modifié le : </b></span><br/>' . $page->getLastModification() . '<br/>';
    echo '<span><b> Contenu : </b></span><br/>' . parser($page->getContent(), $subject) . '<br/><br/>';
  }

  function modify_page_form($subject, $page)
  {

    echo '<a href="index.php?page=subject&subjectid=' . $subject->getId() . '&action=displaypage&pageid=' . $page->getId() . '"> Retour à la page </a><br/>
          <form name="create_page" action="index.php?page=subject&subjectid=' . $subject->getId() .'&action=displaypage&pageid=' . $page->getId() . '" method="post">
            <h3> Modification de la page : </h3>
            <label> Mot-clé : </label><br/>
              <input type="text" name="keyword" value="' . $page->getKeyword() . '" /><br/>
            <label> Contenu : </label><br/>
              <textarea rows="6" cols="50" name="content">' . $page->getContent() .'</textarea><br/>
            <input type="submit" name="modify_page"/>
          </form>';
  }

  function save_new_page($subject, $keyword, $content)
  {
    if(filled($keyword) AND filled($content))
    {
      if(!keyword_exists($subject, $keyword))
      {
        $query = 'INSERT INTO page(subject_id, keyword, content, creation, start)
                  VALUES(:subject_id, :keyword, :content, NOW(), false);';
        $result = $GLOBALS['dbsocket']->prepare($query);

        $result->execute(array(
          'subject_id' => $subject->getId(),
          'keyword' => $keyword,
          'content' => $content
        ));
      }
      else
      {
        echo '<div class="error_msg"> Le mot clé existe déjà !! </div>';
      }
    }
    else
    {
      echo '<div class="error_msg"> Tout les champs ne sont pas remplis !! </div>';
    }
  }

  function save_page_modification($page, $keyword, $content)
  {
    if(filled($keyword) AND $keyword != $page->getKeyword())
    {
      if($page->getStart() == false)
      {
        $page->update('keyword', $keyword);
      }
    }
    if(filled($content) AND $content != $page->getContent())
    {
      $page->update('content', $content);
    }
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

  function keyword_exists($subject, $keyword)
  {
    $query = 'SELECT count(*)
              FROM page
              WHERE keyword = \'' . $keyword . '\' AND subject_id = ' . $subject->getId() . ' ;';

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
