<?php

  search_wiki();

  form_test();

  if(isset($_POST['submit']))
  {
    parser($_POST['text']);
  }

?>
