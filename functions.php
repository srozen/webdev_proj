<?php

	include 'page.obj.php';

	/* Check if $var is valid (not empty and set) */
	function not_empty($var)
	{
		return(isset($var) AND !empty($var));
	}

	/* Return a PDO connexion to the server */
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

	/* Return a page definition with a title, filename and text */
	function define_page($page)
	{
		$pvalues = page_value($page);
		return new Page($pvalues[0], $pvalues[1], $pvalues[2]);
	}


	/* Set the Page object values depending on the GET[page] element*/
	function page_value($page)
	{
		switch($page){
			case 'index' :
				return $values = array('Index', 'welcome.php', 'Page index');
			case 'normal' :
				return $values = array('Normale', 'normal.php', 'Page normale');
			case 'contact' :
				return $values = array('Contact', 'contact.php', 'Page de contact');
			case 'subscribe' :
				return $values = array('Inscription', 'subscription.php', 'Page d\'inscription');
			case 'login' :
				return $values = array('Connexion', 'login.php', 'Page de connexion');
			case 'lostpwd' :
				return $values = array('Mot de passe perdu', 'lostpwd.php', 'Récupération du mot de passe');
			default :
				return $values = array('', '', '');
		}
	}
?>
