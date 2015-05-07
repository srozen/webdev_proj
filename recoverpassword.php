<?php
if(logged())
{
  header("Location: index.php");
  die();
}

if(filled($_GET['activation']))
{
  $code = $_GET['activation'];
  $query = 'SELECT id FROM user WHERE id = (SELECT user_id FROM activation WHERE code = \'' . $code . '\' AND recovery = false);';
  $result = $GLOBALS['dbsocket']->query($query);
  $userid = $result->fetch();

  if(empty($userid))
  {
    echo '<div class="error_msg"> Vous n\'êtes pas en demande de mot de passe, veuillez vous connecter normalement.</div>';
    die();
  }

  $user = new User($userid['id']);
  $question = get_user_value('question', 'id', $user->getId());

  if(isset($_POST['submit']))
  {
    process_password_recovery($_POST['answer'], $_POST['password'], $_POST['checkpassword'], $user);
  }

  echo '<form name=recoverpassword action="index.php?page=recoverpassword&activation=' . $_GET['activation'] . '" method="post">
          <label> Votre question est : </label><br/>
          <p> ' . $question . '</p>
          <label> Réponse : </label><br/>
            <input type="text" name="answer"/><br/>
          <label> Nouveau mot de passe : </label></br>
            <input type="password" name="password"/><br/>
          <label> Vérification du mot de pass : </label><br/>
            <input type="password" name="checkpassword"/><br/>
          <input type="submit" name="submit">
        </form>';
}
else
{
  header("Location: index.php");
  die();
}

?>
