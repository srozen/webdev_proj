<?php
/******************************************************
 * SET OF FUNCTIONS USED TO MANAGE REGISTER PROCEDURE *
 ******************************************************/

 function check_register($login, $mail, $checkmail, $password, $checkpassword, $config, $dbsocket)
 {
   $insert_db = true;
   $check_result = array(
     "message" => "",
     "valid" => "",
     "loginmessage" => "",
     "loginclass" => "",
     "login" => "",
     "mailmessage" => "",
     "mailclass" => "",
     "mail" => "",
     "passwordmessage" => "",
     "passwordclass" => ""
   );

   $vlogin = check_login($login, $config, $dbsocket);
   $vmail = check_mails($mail, $checkmail, $config, $dbsocket);
   $vpassword = check_passwords($password, $checkpassword, $config);

   if(gettype($vlogin) != 'boolean')
   {
     $check_result['loginmessage'] = $vlogin;
     $check_result['loginclass'] = 'badinput';
     $insert_db = false;
   }
   else
   {
     $check_result['login'] = $login;
     $check_result['loginclass'] = 'correctinput';
   }

   if(gettype($vmail) != 'boolean')
   {
     $check_result['mailmessage'] = $vmail;
     $check_result['mailclass'] = 'badinput';
     $insert_db = false;
   }
   else
   {
     $check_result['mail'] = $mail;
     $check_result['mailclass'] = 'correctinput';
   }

   if(gettype($vpassword) != 'boolean')
   {
     $check_result['passwordmessage'] = $vpassword;
     $check_result['passwordclass'] = 'badinput';
     $insert_db = false;
   }

   if($insert_db == true)
   {
     $check_result['message'] = '<span class="success_msg"> Inscription réussie, veuillez valider celle-ci via le lien envoyé à votre mail. </span><br/>';
     $check_result['valid'] = true;
   }
   else
   {
     $check_result['message'] = '<span class="error_msg"> Une erreur est surevenue lors de votre inscription ! </span><br/>';
     $check_result['valid'] = false;
   }

   return $check_result;
 }

 /* Ensure that $login is not empty, valid and not used in database by another user */
 function check_login($login, $config, $dbsocket)
 {
   if(filled($login))
   {
     if(valid_login($login, $config))
     {
       if(!user_exists('login', $login, $dbsocket))
       {
         return true;
       }
       else
       {
         return "<span class=\"error_msg\"> Le login existe déjà ! </span><br/>";
       }
     }
     else
     {
       return "<span class=\"error_msg\"> Le login est incorrect ! </span><br/>";
     }
   }
   else
   {
     return "<span class=\"error_msg\"> Le login doit être rempli ! </span><br/>";
   }
 }

 /* Ensure that $mail is not empty, valid and not used in database by another user */
 function check_mails($mail, $checkmail, $config, $dbsocket)
 {
   if(filled($mail) AND filled($checkmail))
   {
     if(same_inputs($mail, $checkmail))
     {
       if(valid_mail($mail))
       {
         if(!user_exists('mail', $mail, $dbsocket))
         {
           return true;
         }
         else
         {
           return "<span class=\"error_msg\">Le mail est déjà utilisé ! </span><br/>";
         }
       }
       else
       {
         return "<span class=\"error_msg\">Le mail est invalide ! </span><br/>";
       }
     }
     else
     {
       return "<span class=\"error_msg\">Les mails ne sont pas identiques ! </span><br/>";
     }
   }
   else
   {
     return "<span class=\"error_msg\"> Les mails doivent être remplis ! </span><br/>";
   }
 }

 /* Ensure that $password is not empty and valid */
 function check_passwords($password, $checkpassword, $config)
 {
   if(filled($password) AND filled($checkpassword))
   {
     if(same_inputs($password, $checkpassword))
     {
       if(valid_password($password, $config))
       {
         return true;
       }
       else
       {
         return "<span class=\"error_msg\">Le mot de passe est invalide ! </span><br/>";
       }
     }
     else
     {
       return "<span class=\"error_msg\">Les mots de passe ne sont pas identiques ! </span><br/>";
     }
   }
   else
   {
     return "<span class=\"error_msg\"> Les mots de passe doivent être remplis ! </span><br/>";
   }
 }

 /* Returns random string from $mail and $login of the user */
 function generate_activation_code($mail,$login)
 {
   return hash('sha1', mt_rand(10000,99999).time().$mail.$login, false);
 }

 function add_activation_code($userid, $code, $dbsocket)
 {
   $query = 'INSERT INTO activation (user_id, code)
             VALUES(:userid, :code)';
   $result = $dbsocket->prepare($query);
   $result->execute(array(
     'userid' => $userid,
     'acode' => $code
   ));
 }

 function create_new_user($login, $password, $mail, $config, $dbsocket)
 {
   $hashed = encrypt($password, $config['PASSWORD']['crypto']);

   $query = 'INSERT INTO user (login, password, mail, class, subclass, registration, statuschange)
             VALUES (:login, :password, :mail, :class, :subclass, :registration, :statuschange);';
   $result = $dbsocket->prepare($query);

   $result->execute(array(
     'login' => $login,
     'password' => $hashed,
     'mail' => $mail,
     'class' => 'user',
     'subclass' => 'activating',
     'registration' => 'NOW()',
     'statuschange' => 'NOW()',
   ));
 }

 /* Send a mail with an $activation_code to the $mail */
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

?>
