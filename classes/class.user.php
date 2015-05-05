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
    private $answer;
    private $secret;

    public function __construct($id)
    {
      $this->id = $id;

      $query = 'SELECT login, mail, register, lastlogin, currentlogin, activation, avatar, question, answer, secret
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
      $this->answer = $user['answer'];
      $this->secret = $user['secret'];
    }

    public function update($field, $value, $dbsocket)
    {
      $db_field;
      switch($field)
      {
        case 'login' :
          $db_field = 'login';
          $this->setLogin($value);
          break;

        default:
          $db_field = null;
          break;
      }

      if($db_field != null)
      {
        $query = 'UPDATE user
                  SET ' . $db_field . ' =\'' . $value . '\'
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
  }
