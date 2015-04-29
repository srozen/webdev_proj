<?php
/*******************************************
 * SET OF FUNCTIONS USED TO VALIDATE INPUT *
 *******************************************/

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
function valid_login($login, $config)
{
  return preg_match('/^[A-Za-z]{1}[A-Za-z0-9]{'. $config['LOGIN']['minlength'] . ',' . $config['LOGIN']['maxlength'] .'}$/', $login);
}

/* Check if password follows requirements */
function valid_password($password, $config)
{
  return preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{'. $config['PASSWORD']['minlength'] . ',' . $config['PASSWORD']['maxlength'] . '50}$/', $password);
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

function encrypt($password, $encryption)
{
  return hash($encryption, $password, false);
}

function sanitize($string)
{
  return htmlspecialchars(trim($string));
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
