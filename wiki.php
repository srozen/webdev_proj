<?php

  search_wiki_form();

  form_test();

  if(isset($_POST['search_wiki']))
  {
    search_wiki($_POST['title'], $_POST['description'], $_POST['keyword']);
  }

  if(isset($_POST['submit']))
  {
    parser($_POST['text']);
  }

?>
