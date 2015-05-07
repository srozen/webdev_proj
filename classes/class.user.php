<?php

  class User
  {
    private $id;
    private $login;
    private $mail;
    private $register;
    private $lastlogin;
    private $currentlogin;
    private $activation;
    private $avatar;
    private $question;
    private $secret;

    public function __construct($id)
    {
      $this->id = $id;

      $query = 'SELECT login, mail, register, lastlogin, currentlogin, activation, avatar, question, secret
                FROM user
                WHERE id = \'' . $id . '\'';

      $result = $GLOBALS['dbsocket']->query($query);

      $user = $result->fetch(PDO::FETCH_ASSOC);

      $this->login = $user['login'];
      $this->mail = $user['mail'];
      $this->register = $user['register'];
      $this->lastlogin = $user['lastlogin'];
      $this->currentlogin = $user['currentlogin'];
      $this->activation = $user['activation'];
      $this->avatar = $user['avatar'];
      $this->question = $user['question'];
      $this->secret = $user['secret'];
    }

    public function reload()
    {
      $userid = $this->getId();

      $query = 'SELECT login, mail, register, lastlogin, currentlogin, activation, avatar, question, secret
                FROM user
                WHERE id = \'' . $userid . '\'';

      $result = $GLOBALS['dbsocket']->query($query);

      $user = $result->fetch(PDO::FETCH_ASSOC);

      $this->setLogin($user['login']);
      $this->setMail($user['mail']);
      $this->setRegister($user['register']);
      $this->setLastLogin($user['lastlogin']);
      $this->setCurrentLogin($user['currentlogin']);
      $this->setActivation($user['activation']);
      $this->setAvatar($user['avatar']);
      $this->setQuestion($user['question']);
      $this->setSecret($user['secret']);
    }

    public function update($field, $value)
    {
      $dbfield;
      switch($field)
      {
        case 'login' :
          $dbfield = 'login';
          $this->setLogin($value);
          break;
        case 'password' :
          $dbfield = 'password';
          break;
        case 'mail' :
          $dbfield = 'mail';
          $this->setMail($value);
          break;
        case 'register' :
          $dbfield = 'register';
          $this->setRegister($value);
          break;
        case 'lastlogin' :
          $dbfield = 'lastlogin';
          $this->setLastLogin($value);
          break;
        case 'currentlogin' :
          $dbfield = 'currentlogin';
          $this->setCurrentLogin($value);
          break;
        case 'activation' :
          $dbfield = 'activatiob';
          $this->setActivation($value);
          break;
        case 'avatar' :
          $dbfield = 'avatar';
          $this->setAvatar($value);
          break;
        case 'question' :
          $dbfield = 'question';
          $this->setQuestion($value);
          break;
        case 'answer' :
          $dbfield = 'answer';
          break;
        case 'secret' :
          $dbfield = 'secret';
          $this->setSecret($value);
          break;
        default:
          $db_field = null;
          break;
      }

      if($dbfield != null)
      {
        $query = 'UPDATE user
                  SET ' . $dbfield . ' =\'' . $value . '\'
                  WHERE id=\'' . $this->getId() . '\';';
        $GLOBALS['dbsocket']->exec($query);
        return true;
      }
      else
      {
        return false;
      }
    }

    /****************************
    **** GETTERS AND SETTERS ****
    *****************************/

    public function getId()
    {
      return $this->id;
    }

    public function setLogin($var)
    {
      $this->login = $var;
    }

    public function getLogin()
    {
      return $this->login;
    }

    public function setMail($var)
    {
      $this->mail = $var;
    }

    public function getMail()
    {
      return $this->mail;
    }

    public function setRegister($var)
    {
      $this->register=$var;
    }

    public function getRegister()
    {
      return $this->register;
    }

    public function setLastlogin($var)
    {
      $this->lastlogin=$var;
    }

    public function getLastLogin()
    {
      return $this->lastlogin;
    }

    public function setCurrentLogin($var)
    {
      $this->currentlogin=$var;
    }

    public function getCurrentLogin()
    {
      return $this->currentlogin;
    }

    public function setActivation($var)
    {
      $this->activation=$var;
    }

    public function getActivation()
    {
      return $this->activation;
    }

    public function setAvatar($var)
    {
      $this->avatar=$var;
    }

    public function getAvatar()
    {
      return $this->avatar;
    }

    public function setQuestion($var)
    {
      $this->question=$var;
    }

    public function getQuestion()
    {
      return $this->question;
    }

    public function setSecret($var)
    {
      $this->secret=$var;
    }

    public function getSecret()
    {
      return $this->secret;
    }

    /*
     * Setters and getters

    public function set()
    {
      $this->=;
    }

    public function get()
    {
      return $this->;
    }

    */
  }
