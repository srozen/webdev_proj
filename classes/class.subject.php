<?php

  class Subject
  {
    private $id;
		private $author_id;
		private $title;
		private $description;
		private $creation;
		private $last_modification;
		private $moderator;
		private $visibility_author;
		private $visibility_modo;
		private $visibility_admin;

    public function __construct($id)
    {
      $this->id = $id;

      $query = 'SELECT author_id, title, description, creation, last_modification, moderator, visibility_author, visibility_modo, visibility_admin
                FROM subject
                WHERE id = \'' . $id . '\'';

      $result = $GLOBALS['dbsocket']->query($query);

      $subject = $result->fetch(PDO::FETCH_ASSOC);

  		$this->author_id = $subject['author_id'];
  		$this->title = $subject['title'];
  		$this->description = $subject['description'];
  		$this->creation = $subject['creation'];
  		$this->last_modification = $subject['last_modification'];
  		$this->moderator = $subject['moderator'];
  		$this->visibility_author = $subject['visibility_author'];
  		$this->visibility_modo = $subject['visibility_modo'];
  		$this->visibility_admin = $subject['visibility_admin'];
    }

    public function reload()
    {
      $id = $this->getId();

      $query = 'SELECT author_id, title, description, creation, last_modification, moderator, visibility_author, visibility_modo, visibility_admin
                FROM subject
                WHERE id = \'' . $id . '\'';

      $result = $GLOBALS['dbsocket']->query($query);

      $subject = $result->fetch(PDO::FETCH_ASSOC);

      $this->setAuthorId($subject['author_id']);
  		$this->setTitle($subject['title']);
  		$this->setDescription($subject['description']);
  		$this->setLastModification($subject['last_modification']);
  		$this->setModerator($subject['moderator']);
  		$this->setVisibilityAuthor($subject['visibility_author']);
  		$this->setVisibilityModo($subject['visibility_modo']);
  		$this->setVisibilityAdmin($subject['visibility_admin']);
    }

    public function update($field, $value)
    {
      $dbfield;
      switch($field)
      {
        case 'title' :
          $dbfield = 'title';
          $this->setTitle($value);
          break;
        case 'description' :
          $dbfield = 'description';
          $this->setDescription($value);
          break;
        case 'last_modification' :
          $dbfield = 'last_modification';
          $this->setLastModification($value);
          break;
        case 'moderator' :
          $dbfield = 'moderator';
          $this->setRegister($value);
          break;
        case 'visibility_author' :
          $dbfield = 'visibility_author';
          $this->setVisibilityAuthor($value);
          break;
        case 'visibility_modo' :
          $dbfield = 'visibility_modo';
          $this->setVisibilityModo($value);
          break;
        case 'visibility_admin' :
          $dbfield = 'visibility_admin';
          $this->setVisibilityAdmin($value);
          break;
        default:
          $db_field = null;
          break;
      }

      if($dbfield != null)
      {
        $query = 'UPDATE subject
                  SET ' . $dbfield . ' =\'' . $value . '\', last_modification = NOW()
                  WHERE id=\'' . $this->getId() . '\';';
        $GLOBALS['dbsocket']->exec($query);
        return true;
      }
      else
      {
        return false;
      }
    }

    function getAuthorName()
    {
      return get_user_value('login', 'id', $this->author_id);
    }

    /****************************
    **** GETTERS AND SETTERS ****
    *****************************/

    public function setAuthorId($id)
    {
      $this->author_id = $id;
    }
    public function getAuthorId()
    {
      return $this->author_id;
    }

    public function getId()
    {
      return $this->id;
    }

    public function setTitle($title)
    {
      $this->title=$title;
    }

    public function getTitle()
    {
      return $this->title;
    }

    public function setDescription($description)
    {
      $this->description=$description;
    }

    public function getDescription()
    {
      return $this->description;
    }


    public function getCreation()
    {
      return $this->creation;
    }

    public function setLastModification($lastmodif)
    {
      $this->last_modification=$lastmodif;
    }

    public function getLastModification()
    {
      return $this->last_modification;
    }

    public function setModerator($moderatorid)
    {
      $this->moderator=$moderatorid;
    }

    public function getModerator()
    {
      return $this->moderator;
    }

    public function setVisibilityAuthor($level)
    {
      $this->visibility_author=$level;
    }

    public function getVisibilityAuthor()
    {
      return $this->visibility_author;
    }

    public function setVisibilityModo($level)
    {
      $this->visibility_modo=$level;
    }

    public function getVisibilityModo()
    {
      return $this->visibility_modo;
    }

    public function setVisibilityAdmin($level)
    {
      $this->visibility_admin=$level;
    }

    public function getVisibilityAdmin()
    {
      return $this->visibility_admin;
    }

  }
