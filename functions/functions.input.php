<?php
  /******************************
   * INPUT VALIDATION FUNCTIONS *
   ******************************/

  /* Check if $var is not empty and set */

  function filled($var)
  {
    return (isset($var) AND !empty($var));
  }

  /* Check if mail is a real mail */
  function valid_mail($mail)
  {
    return filter_var($mail, FILTER_VALIDATE_EMAIL);
  }

  /* Check if login follows requirements */
  function valid_login($login)
  {
    return preg_match('/^[A-Za-z]{1}[A-Za-z0-9]{'. $GLOBALS['config']['LOGIN']['login_minlength'] . ',' . $GLOBALS['config']['LOGIN']['login_maxlength'] .'}$/', $login);
  }

  /* Check if password follows requirements */
  function valid_password($password)
  {
    return preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{'. $GLOBALS['config']['PASSWORD']['password_minlength'] . ',' . $GLOBALS['config']['PASSWORD']['password_maxlength'] . '50}$/', $password);
  }

  function valid_question($question)
  {
    return preg_match('/[A-Za-z ]{6,40}[?]*[?]/', $question);
  }

  function valid_answer($answer)
  {
    return preg_match('/[A-Za-z0-9]{6,40}/', $answer);
  }

  /* Check if two strings are the same, if flag is true the comparison is case unsensitive */
  function same_inputs($str1, $str2, $flag = false)
  {
    if($flag)
    {
      $str1 = strtolower($str1);
      $str2 = strtolower($str2);
    }
    if (strcmp($str1, $str2) == 0) return true;
    else return false;
  }

  /* Encrypt string */
  function encrypt($string)
  {
    return hash('sha512', $string, false);
  }

  /* Remove white spaces and sanitize input */
  function sanitize($string)
  {
    return htmlspecialchars(trim($string));
  }

  function check_login($login)
  {
    if(filled($login))
    {
      if(valid_login($login))
      {
        if(!user_exists('login', $login))
        {
          return true;
        }
        else
        {
          echo "<span class=\"error_msg\"> Le login existe déjà ! </span><br/>";
          return false;
        }
      }
      else
      {
        echo "<span class=\"error_msg\"> Le login est incorrect ! </span><br/>";
        return false;
      }
    }
    else
    {
      echo "<span class=\"error_msg\"> Le login doit être rempli ! </span><br/>";
      return false;
    }
  }

  function check_mails($mail, $checkmail)
  {
    if(filled($mail) AND filled($checkmail))
    {
      if(same_inputs($mail, $checkmail))
      {
        if(valid_mail($mail))
        {
          if(!user_exists('mail', $mail))
          {
            return true;
          }
          else
          {
            echo "<span class=\"error_msg\">Le mail est déjà utilisé ! </span><br/>";
            return false;
          }
        }
        else
        {
          echo "<span class=\"error_msg\">Le mail est invalide ! </span><br/>";
          return false;
        }
      }
      else
      {
        echo "<span class=\"error_msg\">Les mails ne sont pas identiques ! </span><br/>";
        return false;
      }
    }
    else
    {
      echo "<span class=\"error_msg\"> Les mails doivent être remplis ! </span><br/>";
      return false;
    }
  }

  function check_passwords($password, $checkpassword)
  {
    if(filled($password) AND filled($checkpassword))
    {
      if(same_inputs($password, $checkpassword))
      {
        if(valid_password($password))
        {
          return true;
        }
        else
        {
          echo "<span class=\"error_msg\">Le mot de passe est invalide ! </span><br/>";
          return false;
        }
      }
      else
      {
        echo "<span class=\"error_msg\">Les mots de passe ne sont pas identiques ! </span><br/>";
        return false;
      }
    }
    else
    {
      echo "<span class=\"error_msg\"> Les mots de passe doivent être remplis ! </span><br/>";
      return false;
    }
  }

  function check_mail($mail)
  {
    if(filled($mail))
    {
      if(valid_mail($mail))
      {
        if(!user_exists('mail', $mail))
        {
          return true;
        }
        else
        {
          echo "<span class=\"error_msg\">Le mail est déjà utilisé ! </span><br/>";
          return false;
        }
      }
      else
      {
        echo "<span class=\"error_msg\">Le mail est invalide ! </span><br/>";
        return false;
      }
    }
    else
    {
      echo "<span class=\"error_msg\"> Le mail doit être rempli ! </span><br/>";
      return false;
    }
  }

  function check_password($password)
  {
    if(filled($password))
    {
      if(valid_password($password))
      {
        return true;
      }
      else
      {
        echo "<span class=\"error_msg\"> Le mot de passe est invalide ! </span><br/>";
        return false;
      }
    }
    else
    {
      echo "<span class=\"error_msg\"> Le mot de passe doit être rempli ! </span><br/>";
      return false;
    }
  }

  function check_question($question)
  {
    if(filled($question))
    {
      if(valid_question($question))
      {
        return true;
      }
      else
      {
        echo '<div class="error_msg"> La question n\'est pas valide ! </div>';
        return false;
      }
    }
    else
    {
      echo '<div class="error_msg"> Vous devez remplir la question secrète ! </div>';
      return false;
    }
  }

  function check_answer($answer)
  {
    if(filled($answer))
    {
      if(valid_answer($answer))
      {
        return true;
      }
      else
      {
        echo '<div class="error_msg"> La réponse secrète n\'est pas valide ! </div>';
        return false;
      }
    }
    else
    {
      echo '<div class="error_msg"> Vous devez remplir la réponse secrète ! </div>';
      return false;
    }
  }

?>
