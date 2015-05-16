<?php

  class Wikipage
  {
    private $id;
		private $subject_id;
		private $keyword;
		private $content;
		private $creation;
		private $last_modification;
    private $start;

    public function __construct($id)
    {
      $this->id = $id;

      $query = 'SELECT subject_id, keyword, content, creation, last_modification, start
                FROM page
                WHERE id = \'' . $id . '\'';

      $result = $GLOBALS['dbsocket']->query($query);

      $wikipage = $result->fetch(PDO::FETCH_ASSOC);

  		$this->subject_id = $wikipage['subject_id'];
  		$this->keyword = $wikipage['keyword'];
  		$this->content = $wikipage['content'];
  		$this->creation = $wikipage['creation'];
  		$this->last_modification = $wikipage['last_modification'];
      $this->start = $wikipage['start'];
    }

    public function reload()
    {
      $id = $this->getId();

      $query = 'SELECT subject_id, keyword, content, creation, last_modification, start
                FROM page
                WHERE id = \'' . $id . '\'';

      $result = $GLOBALS['dbsocket']->query($query);

      $wikipage = $result->fetch(PDO::FETCH_ASSOC);

      $this->setSubjectId($wikipage['subject_id']);
      $this->setKeyword($wikipage['keyword']);
      $this->setContent($wikipage['content']);
      $this->setCreation($wikipage['creation']);
      $this->setLastModification($wikipage['last_modification']);
      $this->setStart($wikipage['start']);
    }

    public function update($field, $value)
    {
      $dbfield;
      switch($field)
      {
        case 'subject_id' :
          $dbfield = 'subject_id';
          $this->setSubjectId($value);
          break;

        case 'keyword' :
          $dbfield = 'keyword';
          $this->setKeyword($value);
          break;

        case 'content' :
          $dbfield = 'content';
          $this->setContent($value);
          break;

        case 'creation' :
          $dbfield = 'creation';
          $this->setCreation($value);
          break;

        default:
          $db_field = null;
          break;
      }

      if($dbfield != null)
      {
        $query = 'UPDATE page
                  SET ' . $dbfield . ' = :value, last_modification = NOW()
                  WHERE id=\'' . $this->getId() . '\';';
        $result = $GLOBALS['dbsocket']->prepare($query);
        $result->execute(array(
          'value' => $value
        ));
        return true;
      }
      else
      {
        return false;
      }
    }


    public function getId()
    {
      return $this->id;
    }

    public function setSubjectId($id)
    {
      $this->subject_id=$id;
    }

    public function getSubjectId()
    {
      return $this->subject_id;
    }

    public function setKeyword($keyword)
    {
      $this->keyword=$keyword;
    }

    public function getKeyword()
    {
      return $this->keyword;
    }

    public function setContent($content)
    {
      $this->content=$content;
    }

    public function getContent()
    {
      return $this->content;
    }

    public function setCreation($creation)
    {
      $this->creation=$creation;
    }

    public function getCreation()
    {
      return $this->creation;
    }

    public function setLastModification($last_modification)
    {
      $this->last_modification=$last_modification;
    }

    public function getLastModification()
    {
      return $this->last_modification;
    }

    public function setStart($start)
    {
      $this->start=$start;
    }

    public function getStart()
    {
      return $this->start;
    }
  }
