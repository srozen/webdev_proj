<?php

  function add_recovery_code($userid, $code, $dbsocket)
  {
    $query = 'INSERT INTO activation (user_id, code, recovery)
              VALUES(:userid, :code, true)';
    $result = $dbsocket->prepare($query);
    $result->execute(array(
      'userid' => $userid,
      'code' => $code
    ));
  }

  function send_recovery_mail($mail, $code, $login)
  {
    $url = 'http://'. $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'] . '?page=lostpwd&recovery=';

    $to = $mail;

    $subject = 'Wiki - Restauration du mot de passe '. $login . ' ! ';

    $headers = "From: " . strip_tags('no-reply@wiki.pmm.be') . "\r\n";
    $headers .= "Reply-To: ". strip_tags('no-reply@wiki.pmm.be') . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";

    $message = '<html><body>';
    $message .= '<h2>Vous avez lancé la procédure de récupèration du mot de passe. </h2>';
    $message .= '<h3> Pour continuer, veuillez cliquer sur le lien suivant : </h3>';
    $message .= '<a href="'. $url . $code . '">Activation</a><br/>';
    $message .= '<h3> Ou copier ce lien dans votre navigateur : </h3>';
    $message .= '<div>'. $url . $code '</div>';
    $message .= '<div> Si le problème persiste, veuillez entrer en contact avec l\'administrateur via le lien suivant : </div>';
    $message .= '<a href="' . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'] . '?page=contact"Contact administrateur</a>';
    $message .= '</body></html>';

    mail($to, $subject, $message, $headers);
  }
