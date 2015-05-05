<?php

  /***********************
  * CONTACT FORM MODULE *
  ***********************/

  if(isset($_POST['contact_submit']))
  {
    send_contact_message(sanitize($_POST['mail']), sanitize($_POST['subject']), sanitize($_POST['message']));
  }
?>


<form name="contact" method="post" action="index.php?page=contact">
  <?php
    if(!logged())
    {
      echo 'Mail : <br/>';
      echo '<input type="text" name="mail"/><br/>';
    }
  ?>
  Sujet : <br/>
    <input type="text" name="subject"/><br/>
    Message : <br/>
    <textarea rows="6" cols="50" name="message"></textarea><br/>
  <input type="submit" name="contact_submit"/>
</form>
