<?php

  function create_new_subject($title, $subject, $visibility_author, $userid)
  {
    $query = 'INSERT INTO subject(author_id, title, description, creation, visibility_author)
              VALUES(:author_id, :title, :description, NOW(), :visibility_author);';

    $result = $GLOBALS['dbsocket']->prepare($query);

    $result->execute(array(
      'author_id' => $userid,
      'title' => $title,
      'subject' => $subject,
      'description' => $description,
      'visibility_author' => $visibility_author
    ));

  }
?>
