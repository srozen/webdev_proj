<?php

	class Page
	{
		private $metatitle;
		private $url;
		private $title;

		public function __construct($metatitle, $url, $title)
		{
			$this->metatitle = $metatitle;
			$this->url = $url;
			$this->title= $title;
		}

		public function setMetaTitle($val)
		{
			$this->metatitle = $val;
		}

		public function getMetaTitle()
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
