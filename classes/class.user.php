<?php

  class User
  {
    private $id;
    private $login;
    private $mail;
    private $class;
    private $subclass;
    private $lastlogin;

    public function __construct($id, $login, $mail, $class, $subclass, $lastlogin)
		{
			$this->id = $id;
			$this->login = $login;
			$this->mail = $mail;
      $this->class = $class;
      $this->subclass = $subclass;
      $this->lastlogin = $lastlogin;
		}

    public function update_db($field, $value)
    {
      $db_field;
      switch($field)
      {
        case 'login' :
          $db_field = 'login';
          $_SESSION['user']->setLogin($value);
          break;

        case 'password' :
          $db_field = 'password';
          break;

        case 'mail' :
          $db_field = 'mail';
          $_SESSION['user']->setMail($value);
          break;

        case 'class' :
          $db_field = 'class';
          $_SESSION['class']->setClass($value);
          break;

        case 'subclasss' :
          $db_field = 'subclass';
          $_SESSION['subclass']->setSubClass($value);
          break;

        case 'lastlogin' :
          $db_field = 'lastlogin';
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
                  WHERE id=\'' . $_SESSION['user']->getId() . '\';';
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

    public function setClass($class)
    {
      $this->class=$class;
    }

    public function getClass()
    {
      return $this->class;
    }

    public function setSubClass($subclass)
    {
      $this->subclass=$subclass;
    }

    public function getSubClass()
    {
      return $this->subclass;
    }

    public function setLastLogin($lastlogin)
    {
      $this->lastlogin=$lastlogin;
    }

    public function getLastLogin()
    {
      return $this->lastlogin;
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
