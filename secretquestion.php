<?php

  if(!logged() OR $_SESSION['user']->getSecret() == true)
  {
    header("Location: index.php");
    die();
  }

  if(isset($_POST['submit']))
  {
    if(process_question_answer($_POST['question'], $_POST['answer'], $_SESSION['user']))
    {
      header("Location: index.php");
    }
  }
?>

<h4 class="error_msg"> Vous devez remplir cette question et réponse secrète pour accèder au site ! </h4>
<form name="secretquestion" action="index.php?page=secretquestion" method="post">
  <label> Question : </label><br/>
    <input type="text" name="question"/><br/>
  <label> Réponse : </label><br/>
    <input type="text" name="answer"/><br/>
  <input type="submit" name="submit"/><br/>
</form>
