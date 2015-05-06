<?php

  function administration_panel()
  {
    $panel = '<ul> Panneau d\'administration';
    $panel .= '<li><a href=index.php?page=administration&manage=config> Gestion de la configuration </a></li>';
    $panel .= '<li><a href=index.php?page=administration&manage=message> Gestion des messages de contact </a></li>';
    $panel .= '</ul>';

    return $panel;
  }

  function display_manage()
  {
    if(isset($_GET['manage']))
    {
      switch($_GET['manage'])
      {
        case 'config' :
          if(isset($_POST['config_submit']))
          {
            record_config($_POST['config_password']);
          }
          display_config();
          break;
        case 'message' :
          select_messages();
          break;
        default :
          echo '<div> Veuillez sélectionner une option d\'administration.</div>';
          break;
      }
    }
  }

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
        $row = '<label>' . $param .' : </label><input type="text" name="'. ($header.'-'.$param) . '" value="' . $value;
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
    echo '<input type="password" name="config_password" required/><br/>';
    echo '<input type="submit" value="Valider" name="config_submit"/></form>';
  }

  function record_config($password)
  {
    if(indoor_auth($password))
		{
      $ini = parse_ini_file("config.ini", true);
      $newini = '';
  		foreach($ini as $header => $section) {
  			$newini .= '['.$header.']'."\n";
  			foreach($section as $param => $value) {
  				$name = $header.'-'.$param;
  				$newini .= $param.' = '.$_POST[$name]."\n";
  			}
  		}
  		$fileIni = fopen("config.ini", "w");
  		fputs($fileIni, $newini);
  		fclose($fileIni);
      echo '<div class="success_msg"> La configuration a été modifiée </div>';
    }
    else
    {
      echo '<div class="error_msg"> Le mot de passe est incorrect </div>';
    }
  }

  function select_messages()
  {
    echo '<h2>Gestion des messages de contact</h2>';
    echo '<form name="mail" action="index.php?page=administration&manage=mail" method="post">
          <select name="mail_sort">
            <option value="">Type de classement</option>
            <option value="datedesc"> Les plus récents</option>
            <option value="dateasc"> Les plus anciens</option>
            <option value="noanswer">Messages non répondus</option>
            <option value="answer">Messages répondus</option>
            <option value="anonymous">Messages anonymes</option>
            <option value="user">Messages utilisateurs</option>
          </select>
          <input type="submit" value="Rechercher" name="mail_submit"/>
        </form>';
  }

  function build_message_query($sort)
  {
    $clause = '';

    switch($sort)
    {
      case 'datedesc':
        $clause = 'ORDER BY date DESC';
        break;
      case 'dateasc':
        $cause = 'ORDER BY date ASC';
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
        $clause = '';
        break;
    }

    $query = 'SELECT id , user_id as Utilisateur, subject as Sujet, message as Message, mail as \'Adresse Mail\', date as \'Envoyé le\', answer as Répondu
               FROM contact_message ' . $clause . ';';

    return $query;
  }

  function create_table()
  {

  }
?>
