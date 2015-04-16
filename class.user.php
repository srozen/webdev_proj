<?php

  class User
  {
    private $id;
    private $login;
    private $mail;
    private $lastlogin;
    private $level;

    public function __construct($id, $login, $mail, $lastlogin, $level)
		{
			$this->id = $id;
			$this->login = $login;
			$this->mail= $mail;
      $this->lastlogin = $lastlogin;
      $this->level = $level;
		}

    public function update_db($field, $value)
    {
      $db_field;
      switch($field)
      {
        case 'login' :
          $db_field = 'user_login';
          $_SESSION['user']->setLogin($value);
          break;

        case 'password' :
          $db_field = 'user_pwd';
          break;

        case 'mail' :
          $db_field = 'user_mail';
          $_SESSION['user']->setMail($value);
          break;

        case 'lastlogin' :
          $db_field = 'user_lastlogin';
          $_SESSION['user']->setLastLogin($value);
          break;

        default:
          $db_field = null;
          break;
      }

      if($db_field != null)
      {
        $query = 'UPDATE user
                  SET ' . $db_field . ' =\'' . $value . '\'
                  WHERE user_id=\'' . $_SESSION['user']->getId() . '\';';
        return $query;
      }
      else
      {
        $query = null;
        return $query;
      }

    }

    public function setId($id)
    {
      $this->id=$id;
    }

    public function getId()
    {
      return $this->id;
    }

    public function setLogin($login)
    {
      $this->login=$login;
    }

    public function getLogin()
    {
      return $this->login;
    }

    public function setMail($mail)
    {
      $this->mail=$mail;
    }

    public function getMail()
    {
      return $this->mail;
    }

    public function setLastLogin($lastlogin)
    {
      $this->lastlogin=$lastlogin;
    }

    public function getLastLogin()
    {
      return $this->lastlogin;
    }

    public function setLevel($level)
    {
      $this->level=$level;
    }

    public function getLevel()
    {
      return $this->level;
    }

  }
