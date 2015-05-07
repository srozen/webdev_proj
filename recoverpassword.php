<?php
if(logged())
{
  header("Location: index.php");
  die();
}

if(filled($_GET['activation']))
{
  $code = $_GET['activation'];
  $query = 'SELECT id
            FROM user
            WHERE id = (SELECT user_id FROM activation WHERE code = ' . $code . ' AND recovery = false):';
  $result = $GLOBALS['dbsocket']->query($query);
  $userid = $result->fetch();

  $user = new User($uservalue['id']);

  $question = get_user_value('question', 'id', $user->getId());

  echo '<form name=recoverpassword action="index.php?page=recoverpassword" method="post">
          <label> Votre question est : </label><br/>
          <p> ' . $question . '</p>
          <label> Réponse : </label><br/>
          <input type="text" name="answer"/>
          <input type="submit" name="submit">
        </form>';
}
else
{
  header("Location: index.php");
  die();
}

?>
