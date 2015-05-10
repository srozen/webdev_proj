<?php

  form_test();

  if(isset($_POST['submit']))
  {
    parser($_POST['text']);
  }

?>
