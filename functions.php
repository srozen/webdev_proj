<?php

	include 'page.obj.php';

	/* Return a PDO connexion to the server */
	function db_connexion()
	{
		try
		{
			$conn = new PDO('mysql:host=localhost; dbname=1415he201041; charset=utf8', 'MONROE', 'Samuel');
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conn;
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage());
			echo 'Database connexion failed';
		}
	}



	/*********************
	 * SESSIONS HANDLING *
	 *********************/

	function logged()
	{
		if (isset($_SESSION['logged'])) return $_SESSION['logged'];
		else return false;
	}


	/***************************
	 * VALUES & FORMS CHECKING *
	 ***************************/



	/* Check if $var is valid (not empty and set) */
	function is_filled($var)
	{
		return(isset($var) AND !empty($var));
	}

	/* Check is $email is conform to "xxx@yyy.zz" standard */
	function valid_email($email)
	{

	}

	/* Check if $string length suits the minimal $length */
	function correct_length($string, $length)
	{
		if (strlen($string) == $length) return true;
		else return false;
	}

	/* Check if two strings are the same, if flag is true the comparison is case unsensitive */
	function same_strings($str1, $str2, $flag = false)
	{
		// If flag, decapitalize strings
		if($flag)
		{
			$str1 = strtolower($str1);
			$str2 = strtolower($str2);
		}
		if (str_cmp($str1, $str2) == 0) return true;
		else return false;
	}

	/*******************
	 * MENU DEFINITION *
	 *******************/

	function create_menu()
	{
		echo '<a href="index.php?page=index">Accueil</a>';
		echo '<a href="index.php?page=normal">Normale</a>';
		echo '<a href="index.php?page=contact">Contact</a>';
		if(logged())
		{
			echo '<a href="#">Profil</a>';
			echo '<a href="index.php?page=logout">Déconnexion</a>';
		}
		else
		{
			echo '<a href="index.php?page=register">Inscription</a>';
			echo '<a href="index.php?page=login">Connexion</a>';
		}
	}


	/*******************
	 * PAGE DEFINITION *
	 *******************/

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
			case 'register' :
				return $values = array('Inscription', 'register.php', 'Page d\'inscription');
			case 'login' :
				return $values = array('Connexion', 'login.php', 'Page de connexion');
			case 'lostpwd' :
				return $values = array('Mot de passe perdu', 'lostpwd.php', 'Récupération du mot de passe');
			case 'logout' :
				return $values = array('Déconnexion', 'logout.php', 'Page de déconnexion');
			default :
				return $values = array('', '', '');
		}
	}
?>
