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
    create_start_page($subject_id);

    $query = 'SELECT id FROM page WHERE subject_id = ' . $subject_id . ' AND keyword is null';
    $result = $GLOBALS['dbsocket']->query($query);
    $page = $result->fetch();

    header('Location: index.php?page=subject&subjectid=' . $subject_id . '&modifpage=' . $page['id']);

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
            <label> Choix de visibilité : </label>
              <select name="visibility_author">
                <option value="0" '; if($subject->getVisibilityAuthor() == 0) echo 'selected'; echo '> Pas de choix </option>
                <option value="1" '; if($subject->getVisibilityAuthor() == 1) echo 'selected'; echo'> Anonymes </option>
                <option value="2" '; if($subject->getVisibilityAuthor() == 2) echo 'selected'; echo'> Utilisateurs </option>';
                if(moderator_level($_SESSION['user']->getId())) echo '<option value="3"> Modérateurs </option>';
                if(admin_level($_SESSION['user']->getId())) echo '<option value="4"> Administrateur </option>';
        echo '</select><br/>
            <input type="submit" name="modify_subject"/>
          </form>';
  }


  function save_subject_modification($subject, $title, $description, $visibility_author)
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
    $query = 'SELECT ' . $value . '
              FROM subject
              WHERE ' . $col . ' = \'' . $colvalue . '\';';

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
