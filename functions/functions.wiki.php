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

  function search_wiki($title, $description, $keyword)
  {
    if()
  }

  function search_wiki_query()
  {
    $titleclause = '';
    $descriptionclause = '';
    $keywordclause = '';

    $tc = false;
    $dc = false;
    $kc = false;
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
      $descriptionclause .= 'mail like \'%' . $description . '%\' ';
      $dc = true;
    }
    if($status != 'all')
    {
      if($tc == true OR $dc == true)
      {
        $keywordclause .= ' AND ';
      }
      $kc = true;
      $keywordclause .= 'keyword like \'%' . $keyword .'%\' ';
    }

    if($tc == true or $dc == true or $kc == true)
    {
      $clause = 'WHERE ' . $titleclause . $descriptionclause . $keywordclause;
    }

    $query = 'SELECT id, login as Login, mail as Mail, register as Inscription, lastlogin as \'Dernière connexion\'
              FROM user '. $clause . ';';

    return $query;
  }
?>
