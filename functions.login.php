<?php
function login($login, $password, $activationcode = '0')
{
  $query = 'SELECT id, login, mail, status
            FROM user
            WHERE user_login = \'' . $_POST['log_login'] . '\'
            AND  user_pwd = \'' . hash('sha512', $_POST['log_passwd'], false) . '\'';

  $result = $dbsocket->query($query);

  $user = $result->fetch();

  if(!empty($user))
  {
    if(is_activating($user['user_status']))
    {
      if(strcmp(get_user_activation_code($login), $activationcode) == 0)
      {
        // Activation //
        // Changement de status user
        $query = 'UPDATE user SET user_status = \'20\' WHERE user_login = \'' . $login . '\';';
        // Chargement de la session

        // Set date d'activation
        // Redirection vers profil ou index
      }
      else
      {
        // Le code n'est pas valide
        // Message d'erreur
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
    echo 'Mauvaise combinaison';
  }
}
?>
