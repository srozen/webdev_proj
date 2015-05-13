<?php

  function search_wiki_form()
  {
    echo '<form name="search_wiki" action="index.php?page=wiki" method="post">
            <label> Titre du sujet : </label>
              <input type="text" name="title"/><br/>
            <label> Description du sujet : </label>
              <input type="text" name="description"/><br/>
            <label> Mot-clé : </label>
              <input type="text" name="keyword"/><br/>
            <input type="submit" name="search_wiki"/>
          </form>';
  }

  function search_wiki($title, $description, $keywords)
  {
    $page_query = search_page_query($keywords);
    $subject_query = search_subject_query($title, $description);
    $subject_result = $GLOBALS['dbsocket']->query($query);
    $page_result = $GLOBALS['dbsocket']->query($query);

  }

  function search_subject_query($title, $description)
  {
    $titleclause = '';
    $descriptionclause = '';

    $tc = false;
    $dc = false;
    $clause = '';

    if($title != null)
    {
      $titleclause .= 'title like \'%' . $title . '%\' ';
      $tc = true;
    }
    if($description != null)
    {
      if($tc == true)
      {
        $descriptionclause .= ' AND ';
      }
      $descriptionclause .= 'description like \'%' . $description . '%\' ';
      $dc = true;
    }

    if($tc == true or $dc == true)
    {
      $clause = 'WHERE ' . $titleclause . $descriptionclause;
    }

    $query = 'SELECT id
              FROM subject '. $clause . ';';

    return $query;
  }

  function search_page_query($keywords)
  {
    if($keywords != null)
    {
      $clause = 'WHERE keywords like \'%' . $keywords . '%\' ';
    }
    else
    {
      $clause = '';
    }

    $query = 'SELECT id
              FROM page ' . $clause . ';';

    return $query;
  }
?>
