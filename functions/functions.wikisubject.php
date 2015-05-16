<?php

  function create_new_subject($title, $description, $visibility_author, $userid)
  {
    $query = 'INSERT INTO subject(author_id, title, description, creation, visibility_author)
              VALUES(:author_id, :title, :description, NOW(), :visibility_author);';

    $result = $GLOBALS['dbsocket']->prepare($query);

    $result->execute(array(
      'author_id' => $userid,
      'title' => $title,
      'description' => $description,
      'visibility_author' => $visibility_author
    ));

    $subject_id = get_subject_value('id', 'title', $title);
    create_start_page($subject_id, true);

    $query = 'SELECT id FROM page WHERE subject_id = ' . $subject_id . ' AND keyword is null';
    $result = $GLOBALS['dbsocket']->query($query);
    $page = $result->fetch();

    header('Location: index.php?page=subject&subjectid=' . $subject_id . '&pageid=' . $page['id'] . '&action=modifpage');

  }

  function display_subject($subject, $authorized)
  {
    if(logged() AND $authorized)
    {
      echo '<a href="index.php?page=subject&subjectid=' . $subject->getId() . '&action=modifsubject"> Modifier le sujet </a><br/>';
      echo '<a href="index.php?page=subject&subjectid=' . $subject->getId() . '&action=createpage"> Ajouter une page</a><br/>';
    }
    echo '<span><b> Titre : </b></span>' . $subject->getTitle() . '<br/>';
    echo '<span><b> Auteur : </b></span>' . $subject->getAuthorName() .'<br/>';
    echo '<span><b> Description : </b></span>' . $subject->getDescription() . '<br/>';
    echo '<span><b> Modifié le : </b></span>' . $subject->getLastModification() . '<br/><br/>';

    echo '<h4> Pages du sujet : </h4>';
  }

  function load_subject($subjectid)
  {
    if(filled($subjectid))
    {
      if(subject_exists('id', $subjectid))
      {
        return new Subject($subjectid);
      }
      else
      {
        header("Location: index.php?page=wiki");
    		die();
      }
    }
    else
    {
      header("Location: index.php?page=wiki");
      die();
    }
  }

  function modify_subject_form($subject)
  {
    echo '<a href="index.php?page=subject&subjectid=' . $subject->getId() . '"> Retour au sujet </a><br/>
          <form name="create_wiki" action="index.php?page=subject&subjectid=' . $subject->getId() .'" method="post">
            <h3> Modification du sujet : </h3>
            <label> Titre du sujet : </label><br/>
              <input type="text" name="title" value="' . $subject->getTitle() .'" /><br/>
            <label> Description du sujet : </label><br/>
              <textarea rows="6" cols="50" name="description">' . $subject->getDescription() .'</textarea><br/>
            <label> Choix de visibilité : </label><br>
            <label> Choix de visibilité utilisateur: </label><select name="visibility_author">
                <option value="0" '; if($subject->getVisibilityAuthor() == 0) echo 'selected'; echo'> Pas de choix </option>
                <option value="1" '; if($subject->getVisibilityAuthor() == 1) echo 'selected'; echo'> Anonymes </option>
                <option value="2" '; if($subject->getVisibilityAuthor() == 2) echo 'selected'; echo'> Utilisateurs </option>';
                if(moderator_level($_SESSION['user']->getId())) echo '<option value="3" '; if($subject->getVisibilityAuthor() == 3) echo 'selected'; echo'> Modérateurs </option>';
                if(admin_level($_SESSION['user']->getId())) echo '<option value="4" '; if($subject->getVisibilityAuthor() == 4) echo 'selected'; echo'> Administrateur </option>
              </select><br/>';

        if($subject->getModerator() == $_SESSION['user']->getId() OR admin_level($_SESSION['user']->getId()))
        {
          echo '<label> Choix de visibilité modérateur: </label><select name="visibility_modo">
                <option value="0" '; if($subject->getVisibilityModo() == 0) echo 'selected'; echo '> Pas de choix </option>
                <option value="1" '; if($subject->getVisibilityModo() == 1) echo 'selected'; echo'> Anonymes </option>
                <option value="2" '; if($subject->getVisibilityModo() == 2) echo 'selected'; echo'> Utilisateurs </option>
                <option value="3" '; if($subject->getVisibilityModo() == 3) echo 'selected'; echo'> Modérateurs </option>';
                if(admin_level($_SESSION['user']->getId())) echo '<option value="4" '; if($subject->getVisibilityModo() == 4) echo 'selected'; echo'> Administrateur </option>
              </select><br/>';
        }

        if(admin_level($_SESSION['user']->getId()))
        {
          echo '<label> Choix de visibilité administrateur: </label><select name="visibility_admin">
                <option value="0" '; if($subject->getVisibilityAdmin() == 0) echo 'selected'; echo '> Pas de choix </option>
                <option value="1" '; if($subject->getVisibilityAdmin() == 1) echo 'selected'; echo'> Anonymes </option>
                <option value="2" '; if($subject->getVisibilityAdmin() == 2) echo 'selected'; echo'> Utilisateurs </option>
                <option value="3" '; if($subject->getVisibilityAdmin() == 3) echo 'selected'; echo'> Modérateurs </option>
                <option value="4" '; if($subject->getVisibilityAdmin() == 4) echo 'selected'; echo'> Administrateur </option>
              </select><br/>';
        }

        echo '<input type="submit" name="modify_subject"/>
          </form>';
  }

  function display_subject_pages($subject, $owner)
  {
    $query = 'SELECT id, keyword as \'Mot-Clé\', creation as \'Date de création\', last_modification as \'Dernière modification\'
              FROM page
              WHERE subject_id = ' . $subject->getId() .';';
    $page_result = $GLOBALS['dbsocket']->query($query);
    $pages = $page_result->fetchAll(PDO::FETCH_ASSOC);

    echo '<table><tr>';

    $i = 0;
    if(count($pages))
    {
      $col_names = array_keys($pages[0]);

      echo '<th>'. $col_names[1] .'</th>';
      echo '<th>'. $col_names[2] .'</th>';
      echo '<th>'. $col_names[3] .'</th>';

      echo '</tr></thead><tbody>';
      foreach($pages as $page)
      {
        echo '<tr>';
          echo '<td><a href="index.php?page=subject&subjectid=' . $subject->getId() . '&pageid=' . $page['id'] . '&action=displaypage">'; if(isset($page['Mot-Clé'])) echo $page['Mot-Clé']; else echo 'Page d\'entrée'; echo '</a></td>';
          echo '<td>' . $page['Date de création'] . '</td>';
          echo '<td>'; if(isset($page['Dernière modification'])) echo $page['Dernière modification']; else echo '---'; echo '</td>';
        echo '</tr>';
        $i++;
      }
    }
    echo '</tbody></table>';
  }



  function save_subject_modification($subject, $title, $description, $visibility_author, $visibility_modo, $visibility_admin)
  {
    if(filled($title) AND $title != $subject->getTitle())
    {
      $subject->update('title', $title);
    }
    if(filled($description) AND $description != $subject->getDescription())
    {
      $subject->update('description', $description);
    }
    if(filled($visibility_author) AND $visibility_author != $subject->getVisibilityAuthor())
    {
      $subject->update('visibility_author', $visibility_author);
    }
    if(filled($visibility_modo) AND $visibility_modo != $subject->getVisibilityModo() AND (($subject->getModerator() == $_SESSION['user']->getId()) OR (admin_level($_SESSION['user']->getId()))))
    {
      $subject->update('visibility_modo', $visibility_modo);
    }
    if(filled($visibility_admin) AND $visibility_admin != $subject->getVisibilityAdmin() AND admin_level($_SESSION['user']->getId()))
    {
      $subject->update('visibility_admin', $visibility_admin);
    }

  }


  /**
   * Returns a value by looking for a know value in a known column
   * @param $value - String, column name, of the wanted value
   * @param $col - String, column name, of the known value
   * @param $colvalue - String, column value
   *
   * @return Wanted value
  */
  function get_subject_value($value, $col, $colvalue)
  {
    $colvalue = $GLOBALS['dbsocket']->quote($colvalue);
    $query = 'SELECT ' . $value . '
              FROM subject
              WHERE ' . $col . ' = ' . $colvalue . ';';


    $result = $GLOBALS['dbsocket']->query($query);
    $subject = $result->fetch();

    return $subject[$value];
  }

  function subject_exists($field, $value)
  {
    $query = 'SELECT count(*)
              FROM subject
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
?>
