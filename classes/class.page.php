<?php

	class Page
	{
		private $tabtitle;
		private $file;
		private $title;

		public function __construct($tabtitle, $file, $title)
		{
			$this->tabtitle = $tabtitle;
			$this->file = $file;
			$this->title= $title;
		}

		public function setTabTitle($val)
		{
			$this->tabtitle = $val;
		}

		public function getTabTitle()
		{
			return $this->tabtitle;
		}

		public function setFile($val)
		{
			$this->url = $val;
		}

		public function getFile()
		{
			return $this->url;
		}

		public function setTitle($var)
		{
			$this->title = $var;
		}

		public function getTitle()
		{
			return $this->title;
		}
	}
?>
