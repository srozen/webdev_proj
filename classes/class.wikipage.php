<?php

  class Wikipage
  {
    private $id;
		private $subject_id;
		private $keyword;
		private $content;
		private $creation;
		private $last_modification;

    public function __construct($id)
    {
      $this->id = $id;

      $query = 'SELECT subject_id, keyword, content, creation, last_modification
                FROM page
                WHERE id = \'' . $id . '\'';

      $result = $GLOBALS['dbsocket']->query($query);

      $wikipage = $result->fetch(PDO::FETCH_ASSOC);

  		$this->subject_id = $wikipage['subject_id'];
  		$this->keyword = $wikipage['keyword'];
  		$this->content = $wikipage['content'];
  		$this->creation = $wikipage['creation'];
  		$this->last_modification = $wikipage['last_modification'];
    }
  }
