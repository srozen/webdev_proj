<?php

  function create_wiki_form()
  {
    echo '<form name="search_wiki" action="index.php?page=wiki&action=create" method="post">
            <label> Titre du sujet : </label><br/>
              <input type="text" name="title"/><br/>
            <label> Description du sujet : </label><br/>
              <textarea rows="6" cols="50" name="description"></textarea><br/>
            <label> Choix de visibilité : </label>
              <select name="visibility_author">
                <option value="0"> Pas de choix </option>
                <option value="1"> Anonymes </option>
                <option value="2"> Utilisateurs </option>';
                if(moderator_level($_SESSION['user']->getId())) echo '<option value="3"> Modérateurs </option>';
                if(admin_level($_SESSION['user']->getId())) echo '<option value="4"> Administrateur </option>';
        echo '</select><br/>
            <input type="submit" name="search_wiki"/>
          </form>';
  }

  function search_wiki_form()
  {
    echo '<form name="search_wiki" action="index.php?page=wiki&action=search" method="post">
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
    // Get the queries depending on the parameters
    $page_query = search_page_query($keywords);
    $subject_query = search_subject_query($title, $description);

    // Execute queries
    $subject_result = $GLOBALS['dbsocket']->query($subject_query);
    $page_result = $GLOBALS['dbsocket']->query($page_query);

    //Get data
    $subjects = $subject_result->fetchAll(PDO::FETCH_ASSOC);
    $pages = $page_result->fetchAll(PDO::FETCH_ASSOC);

    $i = 0;
    echo '<table><caption>Sujets trouvés : </caption><tr>';

    if(count($subjects))
    {
      $col_names = array_keys($subjects[0]);

      foreach($col_names as $name)
      {
        echo '<th>'. $name .'</th>';
      }
      echo '</tr></thead><tbody>';
      foreach($subjects as $subject)
      {
        echo '<tr>';
        echo '</tr>';
        $i++;
      }
    }
    echo '</tbody></table>';

    echo '<table><caption>Pages trouvées : </caption><tr>';

    $i = 0;
    if(count($pages))
    {
      $col_names = array_keys($pages[0]);

      foreach($col_names as $name)
      {
        echo '<th>'. $name .'</th>';
      }
      echo '</tr></thead><tbody>';
      foreach($pages as $page)
      {
        echo '<tr>';
        echo '</tr>';
        $i++;
      }
    }
    echo '</tbody></table>';
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
