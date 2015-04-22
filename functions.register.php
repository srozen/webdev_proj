<?php
/******************************************************
 * SET OF FUNCTIONS USED TO MANAGE REGISTER PROCEDURE *
 ******************************************************/

 function valid_register_login($login, $config)
 {
   if(filled($login))
   {
     if(valid_login($login, $config))
     {
       echo 'Login valide';
     }
     else
     {
       echo 'Login pas valide';
     }
   }
   else
   {
     echo 'Login non rempli';
   }
 }

 function valid_register_mail($mail, $checkmail, $config)
 {
    if(filled($mail) AND filled($checkmail))
    {
     if(same_inputs($mail, $checkmail))
     {
       if(valid_mail($mail, $config))
       {
         echo 'Mail valide';
       }
       else
       {
         echo 'Le mail n\'est pas valide';
       }
     }
     else
     {
       echo 'Les mails ne sont pas les mêmes';
     }
   }
   else
   {
     echo 'Mails non remplis';
   }
 }

 function valid_register_password($password, $checkpassword, $config)
 {
   if(filled($password) AND filled($checkpassword))
   {
     if(same_inputs($password, $checkpassword))
     {
       if(valid_password($password))
       {
         echo 'Password valide';
       }
       else
       {
         echo 'Password non valdie';
       }
     }
     else
     {
       echo 'Password ne sont pas identiques';
     }
   }
   else
   {
     echo 'Passwords non remplis';
   }
 }
?>
