<?php

	include 'page.obj.php';
	
	function not_empty($var)
	{
		return(isset($var) AND !empty($var));
	}

	function db_connexion()
	{
		try
		{
			return new PDO('mysql:host=localhost;
							dbname=1415he201041;
							charset=utf8', 'MONROE', 'Samuel');
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage());
			echo 'Database connexion failed';
		}
	}	
	
	function define_page($page)
	{
		$pvalues = page_value($page);
		return new Page($pvalues[0], $pvalues[1], $pvalues[2]);
	}

	function page_value($page)
	{
		switch($page){
			case 'index' :
				return $values = array('Index', 'index.php', 'Page index');
			case 'normal' :
				return $values = array('Normale', 'normal.php', 'Page normale');
			case 'contact' :
				return $values = array('Contact', 'contact.php', 'Page de contact');
			case 'subscribe' :
				return $values = array('Inscription', 'subscription.php', 'Page d\'inscription');
			case 'login' :
				return $values = array('Connexion', 'login.php', 'Page de connexion');
			default :
				return $values = array('', '', '');
		}
	}
?>
