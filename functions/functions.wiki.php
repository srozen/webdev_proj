<?php

  function search_wiki()
  {
    echo '<form name="search_wiki" action="index.php?page=wiki" method="post">
            <label> Titre du sujet : </label>
              <input type="text" name="subject"/><br/>
            <label> Description du sujet : </label>
              <input type="text" name="description"/><br/>
            <label> Mot-clé : </label>
              <input type="text" name="keyword"/><br/>
            <input type="submit" name="search_wiki"/>
          </form>';
  }

?>
