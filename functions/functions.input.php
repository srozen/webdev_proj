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
    return hash('sha512', $password, false);
  }

  /* Remove white spaces and sanitize input */
  function sanitize($string)
  {
    return htmlspecialchars(trim($string));
  }

?>
