<?php
/************************************************************************
 * THIS SET OF FUNCTIONS PROVIDES AN API FOR INTERNAL MESSAGES MANAGING *
 ************************************************************************/


function send_contact_message($mail, $subject, $message, $dbsocket)
{
  if(filled($mail) AND filled($subject) AND filled($message))
  {
    save_contact_message($mail, $subject, $message, $dbsocket);
    confirm_contact_message($mail, $subject, $message);
    echo '<span class="success_msg"> Le message a bien été envoyé ! </span>';
  }
  else
  {
    echo '<span class="error_msg"> Vous n\'avez pas rempli tout les champs ! </span>';
  }
}


function save_contact_message($mail, $subject, $message, $dbsocket, $parentid = null)
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
            VALUES (:subject, :mail, :message, NOW(), :user_id, ' . $parentid . ');';
  $response = $dbsocket->prepare($query);
  $response->execute(array(
    'subject' => $subject,
    'mail' => $mail,
    'message' => $message,
    'user_id' => $userid
  ));
}

function confirm_contact_message($mail, $subj, $text)
{
  $to = $mail;

  $subject = 'Message envoyé : ' . $subj;

  $headers = "From: " . strip_tags('no-reply@wiki.pmm.be') . "\r\n";
  $headers .= "Reply-To: ". strip_tags('no-reply@wiki.pmm.be') . "\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=utf-8\r\n";

  $message = '<html><body>';
  $message .= '<h2>Votre message a bien été envoyé et sera traité dans les plus brefs délais</h2>';
  $message .= '<h3>Rappel de votre message : <h3>';
  $message .= '<ul>';
  $message .= '<li><b>Email  :</b>'   . $mail    . '</li>';
  $message .= '<li><b>Sujet  :</b>'   . $subj . '</li>';
  $message .= '<li><b>Message  :</b>' . $text . '</li>';
  $message .= '</ul></body></html>';

  mail($to, $subject, $message, $headers);
}

function answer_contact_message($mail, $subj, $text, $answer, $id, $dbsocket)
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
  $result = $dbsocket->exec($query);
}
?>
