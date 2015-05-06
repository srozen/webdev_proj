<?php

  function administration_panel()
  {
    $panel = '<ul> Panneau d\'administration';
    $panel .= '<li><a href=index.php?page=administration&manage=config> Gestion de la configuration </a></li>';
    $panel .= '<li><a href=index.php?page=administration&manage=contact> Gestion des messages de contact </a></li>';
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
        case 'contact' :
          select_contact_messages();
          if(isset($_GET['action']) AND $_GET['action'] == 'answer')
          {
            reply_contact_message($_GET['messageid']);
          }
          if(isset($_POST['contact_submit']))
          {
            display_contact_messages($_POST['mail_sort']);
          }
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

  function select_contact_messages()
  {
    echo '<h2>Gestion des messages de contact</h2>';
    echo '<form name="mail" action="index.php?page=administration&manage=contact" method="post">
          <select name="mail_sort">
            <option value="">Type de classement</option>
            <option value="datedesc"> Les plus récents</option>
            <option value="dateasc"> Les plus anciens</option>
            <option value="noanswer">Messages non répondus</option>
            <option value="answer">Messages répondus</option>
            <option value="anonymous">Messages anonymes</option>
            <option value="user">Messages utilisateurs</option>
          </select>
          <input type="submit" value="Rechercher" name="contact_submit"/>
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

  function display_contact_messages($sort)
  {
    $query = build_message_query($sort);
    $result = $GLOBALS['dbsocket']->query($query);

    $elements = $result->fetchAll(PDO::FETCH_ASSOC);
    $i = 0;
    echo '<form name="select_message" action="index.php?page=administration&manage=contact" method="post"><table><tr>';

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
        echo '<td>' . $element['id'] . '</td>';
        if($element['Utilisateur'] != null)
        {
          echo '<td><a href="#">'. get_user_value('login', 'id', $element['Utilisateur']) .'</a></td>';
        }
        else
        {
          echo '<td> --- </td>';
        }
        echo '<td>' . $element['Sujet']. '</td>';
        echo '<td>' . $element['Message'] . '</td>';
        echo '<td>' . $element['Adresse Mail']. '</td>';
        echo '<td>' . $element['Envoyé le'] . '</td>';
        if($element['Répondu'] == 0)
        {
          echo '<td> Non </td>';
        }
        else
        {
          echo '<td> Oui </td>';
        }
        echo '<td><a href="index.php?page=administration&manage=contact&action=answer&messageid='. $element['id'] . '"/>Répondre</a></td>';
        echo '</tr>';
        $i++;
      }
      echo '</tbody></table><input type="submit" value="Répondre" name="select_message"></form>';
    }
  }

  function reply_contact_message($messageid)
  {

    if(filled($messageid))
    {
      $query = 'SELECT mail, message, subject
                FROM contact_message
                WHERE id = ' . $messageid . ';';
      $result = $GLOBALS['dbsocket']->query($query);

      $contact = $result->fetch(PDO::FETCH_ASSOC);

      if(isset($_POST['answer_submit']))
      {
        if(filled($_POST['answer']))
        {
          sendreply_contact_message($contact['mail'], $contact['subject'], $contact['message'], $_POST['answer'], $messageid);
          record_message($GLOBALS['config']['GLOBAL']['noreply'], $_POST['subject'], $_POST['answer'], $messageid);
        }
        else
        {
          echo '<div class="error_msg"> Vous \'avez pas répondu au message ! </div>';
        }
      }

      $recall = '<h4>Rappel du message : </h4>
                  <label>Mail : </label><br/> ' . $contact['mail'] . '<br/>
                  <label>Sujet : </label><br/>' . $contact['subject'] . '<br/>
                  <label>Message : </label><br/>' . $contact['message'] . '<br/>';

      $form = '<form name="answer" action="index.php?page=administration&manage=contact&action=answer&messageid='. $messageid . '" method="post">
                  <h4> Réponse : </h4>
                  <input type="text" hidden name="subject" value="Re : ' . $contact['subject'] . ' "/>
                  <textarea rows="6" cols="50" name="answer"></textarea><br/>
                  <input type="submit" name="answer_submit"/>
              </form>';

      echo $recall;
      echo $form;
    }
    else
    {
      echo '<div class="error_msg"> Aucun message trouvé !</div>';
    }
  }
?>
