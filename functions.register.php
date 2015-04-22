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
?>
