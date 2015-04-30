<?php
/********************************************
 * FUNCTIONS USED TO MANAGE LOGIN PROCEDURE *
 ********************************************/

function login($login, $password, $code, $config, $dbsocket)
{
  if(filled($login) AND filled($password))
  {
    $query = 'SELECT id, subclass
              FROM user
              WHERE login = \'' . $login . '\'
              AND password = \'' . encrypt($password, $config['PASSWORD']['password_crypto']) . '\'';

    $result = $dbsocket->query($query);

    $user = $result->fetch(PDO::FETCH_ASSOC);

    // If request returned a result //
    if(!empty($user))
    {
      // Check if user is activating //
      if($user['subclass'] == 'activating')
      {
        if(filled($code))
        {
          if(get_activation_code($user['id'], $dbsocket) == $code)
          {
            set_user_value('lastlogin', 'NOW()', $use['id'], $dbsocket);
            set_user_value('currentlogin', 'NOW()', $user['id'], $dbsocket);
            set_user_value('subclass', 'normal', $user['id'], $dbsocket);
            set_user_value('statuschange', 'NOW()', $user['id'], $dbsocket);
            set_user_value('activation', 'NOW()', $user['id'], $dbsocket);

            // TODO : Remove activation row in db

            login_procedure($user['id'], $dbsocket);
          }
          else
          {
            echo 'Vous n\'avez pas fourni un code d\'activation valide, vérifiez votre adresse mail ! ';
          }
        }
        else
        {
          echo 'Vous devez vous activer pour vous connecter, vérifiez votre adresse email pour activer ce compte ! ';
        }
      }
      else if($user['subclass'] == 'normal')
      {
        login_procedure($user['id'], $dbsocket);
      }
      else
      {
        echo 'Vous n\'êtes pas authorisé à vous connecter ! ';
      }
    }
    else
    {
      echo 'Mauvaise combinaison login / mot de passe !';
    }
  }
  else
  {
    echo 'Les champs ne sont pas remplis ! ';
  }

}

function login_procedure($userid, $dbsocket)
{
  $lastlogin = get_user_value('currentlogin', 'id', $userid, $dbsocket);
  set_user_value('lastlogin', $lastlogin, $userid, $dbsocket);
  set_user_value('currentlogin', 'NOW()', $userid, $dbsocket);

  //Récupèrer l'entièreté des données utiles
  $query = 'SELECT id, login, mail, class, subclass, lastlogin, avatar
            FROM user
            WHERE id = \'' . $userid . '\'';

  $result = $dbsocket->query($query);

  $user = $result->fetch(PDO::FETCH_ASSOC);
  $_SESSION['logged'] = true;
  $_SESSION['user'] = new User($user['id'], $user['login'], $user['mail'], $user['class'], $user['subclass'], $user['lastlogin'], $user['avatar']);
  header("Location: index.php");
}

?>
