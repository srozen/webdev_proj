<?php
  /*************************
   * REGISTERING FUNCTIONS *
   *************************/

  function registration($login, $password, $mail)
  {
    // create new user
    // generate code
    // add code
    // send mail
    // echo message
  }

  function send_registration_mail($mail, $activation_code, $login)
  {
   $url = 'http://'. $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'] . '?page=login&activation=';

   $to = $mail;

   $subject = 'Insription au Wiki - Bienvenue '. $login . ' ! ';

   $headers = "From: " . strip_tags('no-reply@wiki.pmm.be') . "\r\n";
   $headers .= "Reply-To: ". strip_tags('no-reply@wiki.pmm.be') . "\r\n";
   $headers .= "MIME-Version: 1.0\r\n";
   $headers .= "Content-Type: text/html; charset=utf-8\r\n";

   $message = '<html><body>';
   $message .= '<h2>Vous vous êtes inscrit au wiki !</h2>';
   $message .= '<h3> Veuillez valider votre inscription via le lien suivant : </h3>';
   $message .= '<a href="'. $url . $activation_code . '">Activation</a><br/>';
   $message .= '<h3> Ou en copiant ce lien dans votre navigateur : </h3>';
   $message .= '<span>'. $url . $activation_code;
   $message .= '</body></html>';

   mail($to, $subject, $message, $headers);
  }
