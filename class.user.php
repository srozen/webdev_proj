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

    public function setId()
    {
      $this->id=$id;
    }

    public function getId()
    {
      return $this->id;
    }

    public function setLogin()
    {
      $this->login=$login;
    }

    public function getLogin()
    {
      return $this->login;
    }

    public function setMail()
    {
      $this->mail=$mail;
    }

    public function getMail()
    {
      return $this->mail;
    }

    public function setLastLogin()
    {
      $this->lastlogin=$lastlogin;
    }

    public function getLastLogin()
    {
      return $this->lastlogin;
    }

    public function setLevel()
    {
      $this->level=$level;
    }

    public function getLevel()
    {
      return $this->level;
    }

  }
