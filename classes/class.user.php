<?php

  class User
  {
    private $id;
    private $login;
    private $mail;
    private $class;
    private $subclass;
    private $lastlogin;
    private $avatar;

    public function __construct($id, $login, $mail, $class, $subclass, $lastlogin, $avatar)
		{
			$this->id = $id;
			$this->login = $login;
			$this->mail = $mail;
      $this->class = $class;
      $this->subclass = $subclass;
      $this->lastlogin = $lastlogin;
      $this->avatar = $avatar;
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

        case 'password' :
          $db_field = 'password';
          break;

        case 'mail' :
          $db_field = 'mail';
          $this->setMail($value);
          break;

        case 'class' :
          $db_field = 'class';
          $this->setClass($value);
          break;

        case 'subclasss' :
          $db_field = 'subclass';
          $this->setSubClass($value);
          break;

        case 'lastlogin' :
          $db_field = 'lastlogin';
          $this->setLastLogin($value);
          break;

        case 'avatar' :
          $db_field = 'avatar';
          $this->setAvatar($value);
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
        $dbsocket->exec($query);
        return true;
      }
      else
      {
        return false;
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

    public function setAvatar($value)
    {
      $this->avatar=$value;
    }

    public function getAvatar()
    {
      return $this->avatar;
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
