<?php
/**************************************************
 * SET OF FUNCTIONS TO MANAGE ADMINISTRATION PAGE *
 **************************************************/

function select_messages()
{
  echo '<h2>Gestion des messages de contact</h2>';
  echo '<form name="mail" action=\'index.php?page=administration&manage=mail\' method="post">
        <select name="mail_sort">
          <option value="date">Classement par date</option>
          <option value="noanswer">Messages non répondus</option>
          <option value="answer">Messages répondus</option>
          <option value="anonymous">Messages anonymes</option>
          <option value="user">Messages utilisateurs</option>
        </select>
        <input type="submit" value="Rechercher" name="mail_submit"/>
      </form>';
}

function display_messages($sorting, $dbsocket)
{
  $clause = '';

  switch($sorting)
  {
    case 'date':
      $clause = 'ORDER BY date DESC';
      break;
    case 'noanswer':
      $clause = 'WHERE answer = false';
      break;
    case 'answer':
      $clause = 'WHERE answer = true';
      break;
    case 'anonymous':
      $clause = 'WHERE user_id is null';
       break;
    case 'user':
      $clause = 'WHERE user_id is not null';
      break;
    default:
      break;
  }

  $query = 'SELECT id , user_id as Utilisateur, subject as Sujet, message as Message, mail as \'Adresse Mail\', date as \'Envoyé le\', answer as Répondu
             FROM contact_message ' . $clause . ';';

  $result = $dbsocket->query($query);

  $elements = $result->fetchAll(PDO::FETCH_ASSOC);
  $i = 0;
  echo '<form name="select_message" action="index.php?page=administration&manage=mail" method="post"><table><tr>';

  if(count($elements))
  {
    $col_names = array_keys($elements[0]);

    foreach($col_names as $name)
    {
      echo '<th>'. $name .'</th>';
    }
    echo '</tr></thead><tbody>';
    foreach($elements as $element)
    {
      echo '<tr>';
      foreach($element as $attribute)
      {
        echo '<td>'. htmlspecialchars($attribute) .'</td>';
      }
      echo '<td><input type="radio" name="answer_id" value="'. $element['id'] . '"/>Répondre</td>';
      echo '</tr>';
      $i++;
    }
    echo '</tbody></table><input type="submit" value="Répondre" name="select_message"></form>';
  }
}

function answer_message_form($id, $dbsocket)
{
  $query = 'SELECT id, subject, message, mail, date
             FROM contact_message
             WHERE id = ' . $id .';';

  $result = $dbsocket->query($query);
  $contact = $result->fetch(PDO::FETCH_ASSOC);

  echo '<form name="answer_message" action="index.php?page=administration&manage=mail" method="post">';
  echo '<h4> Id Message : </h4><label>' . $contact['id'] .'</label><input type="hidden" name="id" value="'. $contact['id'] .'"/>';
  echo '<h4> Mail : </h4><label>' . $contact['mail'] .'</label><input type="hidden" name="mail" value="'. $contact['mail'] .'"/>';
  echo '<h4> Sujet : </h4><label>' . $contact['subject'] .'</label><input type="hidden" name="subject" value="'. $contact['subject'] .'"/>';
  echo '<h4> Message : </h4><label>' . $contact['message'] .'</label><input type="hidden" name="message" value="'. $contact['message'] .'"/>';
  echo '<h4> Votre réponse : </h4><textarea rows="6" cols="50" name="answer"/></textarea><br/>';
  echo '<input type="submit" name="answer_message"/>';
  echo '</form>';
}


function select_users()
{
  echo '<h3>Bienvenue dans la gestion des utilisateurs</h3>
        <form name="user" action="index.php?page=administration&manage=user" method="post">
          <label>Entrez un pseudo à rechercher : </label>
            <input type="text" name="login"/>
          <label>Entrez un email à rechercher : </label>
            <input type="text" name ="mail"/>
          <label>Sélectionnez un statut : </label>
            <select name="status">
              <option value="all">Statut</option>
              <option value="normal">Actif</option>
              <option value="activation">En attente d\'activation</option>
            </select>
            <input type="submit" value="Rechercher" name="select_users"/>
        </form>';
}

function display_users($login, $mail, $status, $dbsocket)
{
  $loginclause = '';
  $mailclause = '';
  $statusclause = '';
  $lc = false;
  $mc = false;
  $sc = false;
  $clause = '';

  if($login != null)
  {
    $loginclause .= 'login = \'' . $login . '\' ';
    $lc = true;
  }
  if($mail != null)
  {
    if($lc == true)
    {
      $mailclause .= ' AND ';
    }
    $mailclause .= 'mail = \'' . $mail . '\' ';
    $mc = true;
  }
  if($status != 'all')
  {
    if($lc == true OR $mc == true)
    {
      $statusclause .= ' AND ';
    }
    $sc = true;
    $statusclause .= 'subclass = \'' . $status . '\' ';
  }

  if($lc == true or $mc == true or $sc == true)
  {
    $clause = 'WHERE ' . $loginclause . $mailclause . $statusclause;
  }

  $query = 'SELECT id , login, mail, class, subclass
            FROM user '. $clause . ';';


  $result = $dbsocket->query($query);

  $elements = $result->fetchAll(PDO::FETCH_ASSOC);

  $i = 0;
  echo '<form name="select_user" action="index.php?page=administration&manage=user" method="post"><table><tr>';

  if(count($elements))
  {
    $col_names = array_keys($elements[0]);

    foreach($col_names as $name)
    {
      echo '<th>'. $name .'</th>';
    }
    echo '</tr></thead><tbody>';
    foreach($elements as $element)
    {
      echo '<tr>';
      foreach($element as $attribute)
      {
        echo '<td>'. htmlspecialchars($attribute) .'</td>';
      }
      echo '<td><input type="radio" name="user_id" value="'. $element['id'] . '"/>Gérer</td>';
      echo '</tr>';
      $i++;
    }
    echo '</tbody></table><input type="submit" value="Gestion du user" name="select_message"></form>';
  }
}

/* Function display config.ini parameters and create a form to change its values */
function display_config()
{
  $ini= parse_ini_file("config.ini", true);

  echo '<h2>Modification de la configuration</h2>';
  echo '<form name ="update_config" method="post" action="index.php?page=administration&manage=config">';
  foreach($ini as $header => $section)
  {
    echo '<h3>' . $header . '</h3>';
    foreach($section as $param => $value)
    {
      $row = '<label>' . $param .' : </label><input type="text" name="'. $param . '" value="' . $value;
      $rowend;
      if($header == "DATABASE")
      {
        $rowend = '" readonly/><br>';
      }
      else
      {
        $rowend = '" required/><br>';
      }
      echo $row.$rowend;
    }
  }

  echo '<p> Validez les changements : </p>';
  echo '<label>Mot de passe : </label>';
  echo '<input type="password" name="password_config" required/><br/>';
  echo '<input type="submit" value="Valider" name="config_submit"/></form>';

}

/* Function receive POST values from display_config() and use it to update config.ini file. */
function update_config($password, $config, $dbsocket)
{
  if(profile_auth($password, $config, $dbsocket))
  {
    $file = fopen("config.ini", "w");
    $ini_array = parse_ini_file("config.ini", true);

    $ini_array['DATABASE']['localhost'] = $_POST['localhost'];
    $ini_array['DATABASE']['remotehost'] = $_POST['remotehost'];
    $ini_array['DATABASE']['dbname'] = $_POST['dbname'];
    $ini_array['DATABASE']['dblogin'] = $_POST['dblogin'];
    $ini_array['DATABASE']['dbpassword'] = $_POST['dbpassword'];
    $ini_array['GLOBAL']['title'] = $_POST['title'];
    $ini_array['GLOBAL']['copyright'] = $_POST['copyright'];
    $ini_array['GLOBAL']['banner'] = $_POST['banner'];
    $ini_array['GLOBAL']['avatar'] = $_POST['avatar'];
    $ini_array['GLOBAL']['defaultavatar'] = $_POST['defaultavatar'];
    $ini_array['ADMIN']['admin_name'] = $_POST['admin_name'];
    $ini_array['ADMIN']['admin_mail'] = $_POST['admin_mail'];
    $ini_array['SESSION']['session_name'] = $_POST['session_name'];
    $ini_array['PASSWORD']['password_crypto'] = $_POST['password_crypto'];
    $ini_array['PASSWORD']['password_minlength'] = $_POST['password_minlength'];
    $ini_array['PASSWORD']['password_maxlength'] = $_POST['password_maxlength'];
    $ini_array['PASSWORD']['password_size'] = $_POST['password_size'];
    $ini_array['LOGIN']['login_minlength'] = $_POST['login_minlength'];
    $ini_array['LOGIN']['login_maxlength'] = $_POST['login_maxlength'];
    $ini_array['LOGIN']['login_size'] = $_POST['login_size'];
    $ini_array['MAIL']['mail_maxlength'] = $_POST['mail_maxlength'];
    $ini_array['MAIL']['mail_size'] = $_POST['mail_size'];


    $config_file = '';
    foreach($ini_array as $header => $section)
    {
      $config_file .= '['.$header.']'."\n";
      foreach($section as $param => $value)
      {
        $config_file .= "$param = $value"."\n";
      }
    }

    fputs($file, $config_file);
    fclose($file);
    echo '<span class="success_msg"> La configuration a été modifiée ! </span>';
  }
  else
  {
    echo '<span class="error_msg"> Mauvais mot de passe ! </span>';
  }
}


function create_table($reqresult)
{
  $elements = $reqresult->fetchAll(PDO::FETCH_ASSOC);
  $i = 0;
  echo '<table><tr>';

  if(count($elements))
  {
    $col_names = array_keys($elements[0]);

    foreach($col_names as $name)
    {
      echo '<th>'. $name .'</th>';
    }
    echo '</tr></thead><tbody>';
    foreach($elements as $element)
    {
      echo '<tr>';
      foreach($element as $attribute)
      {
        echo '<td>'. htmlspecialchars($attribute) .'</td>';
      }
      echo '<td><a href="' . $element['id'] . '"> Gèrer </a></td>';
      echo '</tr>';
      $i++;
    }
    echo '</tbody></table>';
  }
}
?>
