<?php

  function send_contact_message($mail, $subject, $message)
  {
    if(filled($mail) AND filled($subject) AND filled($message))
    {
      record_message($mail, $subject, $message);
      confirm_contact_message($mail, $subject, $message);
      echo '<div class="success_msg"> Le message a bien été envoyé ! </div>';
    }
    else
    {
      echo '<div class="error_msg"> Les champs doivent être remplis ! </div>';
    }
  }

  function send_status_notification($mail, $status_id, $change)
  {
    $to = $mail;

    $subject = 'Changement de statut';

    $headers = message_headers();

    switch($change)
    {
      case 'remove' :
        $action = 'retiré de';
        break;
      case 'add' :
        $action = 'ajouté à';
        break;
    }
    $message = '<html><body>';
    $message .= '<h2>Votre statut a été modifié par un administrateur.</h2>';
    $message .= '<p> Le statut ' . get_status_label($status_id, true) . ' a été ' . $action . ' votre profil.</p>';
    $message .= '</body></html>';

    mail($to, $subject, $message, $headers);
  }

  function confirm_contact_message($mail, $subj, $text)
  {
    $to = $mail;

    $subject = 'Message envoyé : ' . $subj;

    $headers = message_headers();

    $message = '<html><body>';
    $message .= '<h2>Votre message a bien été envoyé et sera traité dans les plus brefs délais</h2>';
    $message .= '<h3>Rappel de votre message : </h3>';
    $message .= '<ul>';
    $message .= '<li><b>Email  :</b>'   . $mail    . '</li>';
    $message .= '<li><b>Sujet  :</b>'   . $subj . '</li>';
    $message .= '<li><b>Message  :</b>' . $text . '</li>';
    $message .= '</ul></body></html>';

    mail($to, $subject, $message, $headers);
  }

  function sendreply_contact_message($mail, $subj, $text, $answer, $id)
  {
    $to = $mail;

    $subject = 'Re : ' . $subj;

    $headers = message_headers();

    $message = '<html><body>';
    $message .= '<pre>' . $answer . '</pre>';
    $message .= '<h3>Rappel de votre message : <h3>';
    $message .= '<pre>' . $text . '</pre>';
    $message .= 'Pour toute autre demande, veuillez ouvrir un nouveau ticket via la page contact du site.';
    $message .= '</body></html>';

    mail($to, $subject, $message, $headers);

    $query = 'UPDATE contact_message
              SET answer = true
              WHERE id = \'' . $id . '\';';
    $result = $GLOBALS['dbsocket']->exec($query);
  }

  function send_passwordrecovery_message($mail, $recovery_code)
  {
   $url = 'http://'. $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'] . '?page=passwordrecovery&activation=';

   $to = $mail;

   $subject = $GLOBALS['config']['GLOBAL']['title'] . ' - Restauration du mot de passe';

   $headers = "From: " . strip_tags('no-reply@wiki.pmm.be') . "\r\n";
   $headers .= "Reply-To: ". strip_tags('no-reply@wiki.pmm.be') . "\r\n";
   $headers .= "MIME-Version: 1.0\r\n";
   $headers .= "Content-Type: text/html; charset=utf-8\r\n";

   $message = '<html><body>';
   $message .= '<h2>Vous avez demandé une restauration du mot de passe.</h2>';
   $message .= '<h2>Si vous n\'avez pas fait cette requête, veuillez sécuriser vos données afin d\'éviter un vol de votre compte.</h2>';
   $message .= '<h3> Veuillez valider cette restauration via le lien suivant : </h3>';
   $message .= '<a href="'. $url . $recovery_code . '">Activation</a><br/>';
   $message .= '<h3> Ou en copiant ce lien dans votre navigateur : </h3>';
   $message .= '<span>'. $url . $recovery_code;
   $message .= '</body></html>';

   mail($to, $subject, $message, $headers);
  }

  function record_message($mail, $subject, $message, $parentid = null)
  {
    if(logged())
    {
      $userid = $_SESSION['user']->getId();
    }
    else
    {
      $userid = null;
    }

    $query = 'INSERT INTO contact_message (subject, mail, message, date, user_id, parentid)
              VALUES (:subject, :mail, :message, NOW(), :user_id, :parentid);';
    $response = $GLOBALS['dbsocket']->prepare($query);
    $response->execute(array(
      'subject' => $subject,
      'mail' => $mail,
      'message' => $message,
      'user_id' => $userid,
      'parentid' => $parentid
    ));
  }

  function message_headers()
  {
    $headers = "From: " . strip_tags('no-reply@wiki.pmm.be') . "\r\n";
    $headers .= "Reply-To: ". strip_tags('no-reply@wiki.pmm.be') . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";

    return $headers;
  }
