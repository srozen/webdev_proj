<?php
function login($login, $password, $config, $dbsocket, $code = '0')
{
  if(filled($login) AND filled($password))
  {
    $query = 'SELECT id, login, mail, class, subclass
              FROM user
              WHERE login = \'' . $login . '\'
              AND password = \'' . encrypt($config['PASSWORD']['crypto'], $password) . '\'';

    $result = $dbsocket->query($query);

    $user = $result->fetch();

    // If request returned a result //
    if(/!empty($user))
    {
      // Check if user is activating //
      if($user['subclass'] == 'activating')
      {
        if($code != 0)
        {
          if(/* Code fit in db */)
          {
            // Activation //
            // Changement de status user
            // Chargement de la session

            // Set date d'activation
            // Redirection vers profil ou index
          }
          else
          {
            return 'Vous n\'avez pas fourni un code d\'activation valide, vérifiez votre adresse mail ! ';
          }
        }
        else
        {
          return 'Vous devez vous activer pour vous connecter, vérifiez votre adresse email pour activer ce compte ! ';
        }
      }
      else
      {
        // Connexion
        // Chargement de la session
        // Redirection
      }
    }
    else
    {
      return 'Mauvaise combinaison login / mot de passe !';
    }
  }
  else
  {
    return 'Les champs ne sont pas remplis ! ';
  }

}
?>
