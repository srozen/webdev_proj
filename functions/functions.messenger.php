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

    $headers = "From: " . strip_tags('no-reply@wiki.pmm.be') . "\r\n";
    $headers .= "Reply-To: ". strip_tags('no-reply@wiki.pmm.be') . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";

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
