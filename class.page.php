<?php

	class Page
	{
		private $tabtitle;
		private $url;
		private $title;

		public function __construct($tabtitle, $url, $title)
		{
			$this->tabtitle = $tabtitle;
			$this->url = $url;
			$this->title= $title;
		}

		public function setTabTitle($val)
		{
			$this->metatitle = $val;
		}

		public function getTabTitle()
		{
			return $this->metatitle;
		}

		public function setUrl($val)
		{
			$this->url = $val;
		}

		public function getUrl()
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
