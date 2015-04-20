<?php

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

	$dbsocket = db_connexion();


	/****************
	 * USER QUERIES *
   ****************/

	/* Returns the related id from a username */
	function get_user_id($login)
	{
		$query = 'SELECT user_id
							FROM user
							WHERE user_login = \'' . $login . '\'';
		$result = $dbsocket->query($query);
		$id = $result->fetch();
		return $id['user_id'];
	}

	/* Returns status label (string) for a specific username */
	function get_user_status($login)
	{
		$query = 'SELECT status_label FROM status WHERE status_level =
								(SELECT user_status FROM user WHERE user_login = \'' . $login . '\'';
		$result = $dbsocket->query($query);
		$status = $result->fetch();
		return $status['status_label'];

	}

	/* Returns activation code for a specific username */
	// TODO : Return latest activation code
	// TODO : Check activationcode appellation in db
	//
	function get_user_activation_code($login)
	{

		$query = 'SELECT activationcode FROM activation WHERE user_id = \'' . get_user_id($login) ? '\';';
		$result = $dbsocket->query($query);
		$activation = $result->fetch();
		return $activation['activationcode'];
	}

	/* Returns boolean, check if login is in database */
	function user_exists($login)
	{
		$query = 'SELECT count(*)
							FROM user
							WHERE user_login = \'' . $login . '\';';

		$result = $dbsocket->query($query);

		if($result->fetchColumn() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/********************************
	 * SESSIONS HANDLING & SECURITY *
	 ********************************/

	/*
	 * Check Session logged field
	 * Returns boolean
	 */
	function logged()
	{
		if (isset($_SESSION['logged'])) return $_SESSION['logged'];
		else return false;
	}

	function is_admin()
	{
		return true;
	}

	function is_activating($status)
	{
		$query = 'SELECT status_label FROM status WHERE status_level = ' . $status . ';';
		$result = $dbsocket->query($query);
		$status = $result->fetch();

		return($status['status_label'] == 'activating');
	}
	
	/*
	 * Ask for a password and authentify LOGGED(session) user
	 * Returns boolean
	 */
  function indoor_auth($password)
  {
    $query = 'SELECT count(*)
              FROM user
              WHERE user_login = \'' . $_SESSION['user']->getLogin() . '\' AND user_pwd = \'' . hash('sha512', $password, false) . '\';';
    $result = $dbsocket->query($query);

    if($result->fetchColumn() > 0)
    {
      return true;
    }
    else
    {
      return false;
    }
  }

	/******************
	 * ADMINISTRATION *
	 ******************/

	function display_messages($sorting)
	{
		$clause = '';

		switch($sorting)
		{
			case 'date':
				$clause = 'ORDER BY mes_date DESC';
				break;
			case 'noanswer':
				$clause = 'WHERE mes_answer = false';
				break;
			case 'answer':
				$clause = 'WHERE mes_answer = true';
				break;
			case 'anonymous':
				$clause = 'WHERE user_id is null';
			 	break;
			case 'user':
				$clause = 'WHERE user_id is not null';
				break;
			default:
				break;
		}

		$query = 'SELECT user_id as Utilisateur, mes_subject as Sujet, mes_text as Message, mes_mail as \'Adresse Mail\', mes_date as \'Envoyé le\'
		 					FROM contact_message ' . $clause . ';';

		$result = $dbsocket->query($query);

		create_table($result, 'Messages : ');
	}

	function display_users($login = false, $mail = false, $status)
	{
		$query = 'SELECT * FROM user';
		$result = $dbsocket->query($query);

		create_table($result, 'Utilisateurs : ');
	}


	function display_config()
	{

	}


	function create_table($reqresult, $title)
	{
		$elements = $reqresult->fetchAll(PDO::FETCH_ASSOC);
		$i = 0;
		if ($title != null)
		{
			echo '<table><caption>' . $title . '</caption><tr>';
		}
		else echo '<table><tr>';

		if(count($elements))
		{
			$col_names = array_keys($elements[0]);

			foreach($col_names as $name)
			{
				echo '<th>'. $name .'</th>';
			}
			echo '</tr></thead><tbody>';
			foreach($elements as $element)
			{
				echo '<tr>';
				foreach($element as $attribute)
				{
					echo '<td>'. htmlspecialchars($attribute) .'</td>';
				}
				echo '</tr>';
				$i++;
			}
			echo '</tbody></table>';
		}
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
	function valid_mail($email)
	{
		return filter_var($email, FILTER_VALIDATE_EMAIL);
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
		if (strcmp($str1, $str2) == 0) return true;
		else return false;
	}

	function check_register($login, $mail, $checkmail, $pwd, $checkpwd)
	{
		$insert_db = true;
		$badinput = "style=\"border: 1px solid red;\"";
		$correctinput = "style=\"border: 1px solid green;\"";
		$check_result = array(
			"message" => "",
			"valid" => "",
			"loginmessage" => "",
			"loginclass" => "",
			"login" => "",
			"mailmessage" => "",
			"mailclass" => "",
			"mail" => "",
			"passwordmessage" => "",
			"passwordclass" => ""
		);

		$vlogin = valid_register_login($login);
		$vmail = valid_register_mail($mail, $checkmail);
		$vpassword = valid_register_password($pwd, $checkpwd);

		if(gettype($vlogin) != 'boolean')
		{
			$check_result['loginmessage'] = $vlogin;
			$check_result['loginclass'] = $badinput;
			$insert_db = false;
		}
		else
		{
			$check_result['login'] = $login;
			$check_result['loginclass'] = $correctinput;
		}

		if(gettype($vmail) != 'boolean')
		{
			$check_result['mailmessage'] = $vmail;
			$check_result['mailclass'] = $badinput;
			$insert_db = false;
		}
		else
		{
			$check_result['mail'] = $mail;
			$check_result['loginclass'] = $correctinput;
		}

		if(gettype($vpassword) != 'boolean')
		{
			$check_result['passwordmessage'] = $vpassword;
			$check_result['passwordclass'] = $badinput;
			$insert_db = false;
		}

		if($insert_db == true)
		{
			$check_result['message'] = '<span class="success_msg"> Inscription réussie, veuillez valider celle-ci via le lien envoyé à votre mail. </span><br/>';
			$check_result['valid'] = true;
		}
		else
		{
			$check_result['message'] = '<span class="error_msg"> Une erreur est surevenue lors de votre inscription ! </span><br/>';
			$check_result['valid'] = false;
		}

		return $check_result;
	}

	function valid_register_login($login)
	{
		$badlogin = '<span class="error_msg"> L\'identifiant n\'est pas correct ! </span><br/>';
		$alreadyused = '<span class="error_msg"> Cet identifiant est déjà utilisé ! </span><br/>';
		$minlength = 4; // INI
		$maxlength = 31; //INI
		if (!preg_match('/^[A-Za-z]{1}[A-Za-z0-9]{'. $minlength . ',' . $maxlength .'}$/', $login))
		{
			return $badlogin;
		}
		else
		{
	    if(user_exists($login))
			{
				return $alreadyused;
	    }
	    else
	    {
	      return true;
	    }
		}
	}

	function valid_register_mail($mail, $checkmail)
	{
		$alreadyusedmail = '<span class="error_msg"> Le mail est déjà utilisé ! </span><br/>';
		$badmail = '<span class="error_msg"> Le mail n\'est pas un email valide ! </span><br/>';
		$notsamemail = '<span class="error_msg"> Les mails ne sont pas identiques ! </span><br/>';
		if(same_strings($mail, $checkmail))
		{
			if (valid_mail($mail))
			{
				$query = 'SELECT count(*) FROM user WHERE user_mail = \'' . $mail . '\';';
				$result = $dbsocket->query($query);

				if($result->fetchColumn() > 0)
				{
					return $alreadyusedmail;
				}
				else
				{
					return true;
				}
			}
			else
			{
				return $badmail;
			}
		}
		else
		{
			return $notsamemail;
		}
	}

	function valid_register_password($pwd, $checkpwd)
	{
		///// INI for the password min/max values !!
		$badpassword = '<span class="error_msg"> Le mot de passe n\'est pas conforme ! </span><br/>';
		$notsamepassword = '<span class="error_msg"> Les mots de passe ne sont pas identiques ! </span><br/>';

		if(same_strings($pwd, $checkpwd))
		{
			if(!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,50}$/', $pwd))
			{
				return $badpassword;
			}
			else
			{
				return true;
			}
		}
		else
		{
			return $notsamepassword;
		}
	}

	/* Returns random string from $mail and $login of the user */
	function generate_activation_code($mail,$login)
	{
		return hash('sha1', mt_rand(10000,99999).time().$mail.$login, false);
	}

	/* Send a mail with an $activation_code to the $mail */
	function send_registration_mail($activation_code, $mail)
	{
		$to = $mail;

		$subject = 'Insription au Wiki';

		$headers = "From: " . strip_tags('no-reply@wiki.pmm.be') . "\r\n";
		$headers .= "Reply-To: ". strip_tags('no-reply@wiki.pmm.be') . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=utf-8\r\n";

		$message = '<html><body>';
		$message .= '<h2>Vous vous êtes inscrit au wiki !</h2>';
		$message .= '<h3> Veuillez valider votre inscription via le lien suivant : </h3>';
		$message .= '<a href="http://193.190.65.94/HE201041/TRAV/5_site_core/index.php?page=login&activation=' . $activation_code . '">Activation</a><br/>';
		$message .= '<h3> Ou en copiant ce lien dans votre navigateur : </h3>';
		$message .= '<span>http://193.190.65.94/HE201041/TRAV/5_site_core/index.php?page=login&activation='. $activation_code;
		$message .= '</body></html>';

		mail($to, $subject, $message, $headers);
	}

	function add_activation_code($userid, $activationcode)
	{
		$query = 'INSERT INTO activation (user_id, activation_code)
							VALUES(:userid, :activationcode)';
		$result = $dbsocket->prepare($query);
		$result->execute(array(
			'userid' => $userid,
			'activationcode' => $activationcode
		));
	}

	function login($login, $password, $activationcode = '0')
	{
		$query = 'SELECT user_id, user_login, user_mail, user_status
							FROM user u
							WHERE user_login = \'' . $_POST['log_login'] . '\'
							AND binary user_pwd = \'' . hash('sha512', $_POST['log_passwd'], false) . '\'';

		$result = $dbsocket->query($query);

		$user = $result->fetch();

		if(!empty($user))
		{
			if(is_activating($user['user_status']))
			{
				if(strcmp(get_user_activation_code($login), $activationcode) == 0)
				{
					// Activation //
					// Changement de status user
					$query = 'UPDATE user SET user_status = \'20\' WHERE user_login = \'' . $login . '\';';
					// Chargement de la session

					// Set date d'activation
					// Redirection vers profil ou index
				}
				else
				{
					// Le code n'est pas valide
					// Message d'erreur
				}
			}
			else
			{
				// Connexion
				// Chargement de la session
				// Redirection
			}
		}
		else
		{
			echo 'Mauvaise combinaison';
		}
	}
	/*******************
	 * MENU DEFINITION *
	 *******************/

	function create_menu()
	{
		echo '<a href="index.php?page=index"> Accueil </a>';
		echo '<a href="index.php?page=normal"> Normale </a>';
		echo '<a href="index.php?page=contact"> Contact </a>';
		if(logged())
		{
			echo '<a href="index.php?page=profile"> Profil </a>';
			if(is_admin())
			{
				echo '<a href="index.php?page=administration"> Administration </a>';
			}
			echo '<a href="index.php?page=logout"> Déconnexion </a>';
		}
		else
		{
			echo '<a href="index.php?page=register"> Inscription </a>';
			echo '<a href="index.php?page=login"> Connexion </a>';
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
				break;
			case 'normal' :
				return $values = array('Normale', 'normal.php', 'Page normale');
				break;
			case 'contact' :
				return $values = array('Contact', 'contact.php', 'Page de contact');
				break;
			case 'register' :
				return $values = array('Inscription', 'register.php', 'Page d\'inscription');
				break;
			case 'login' :
				return $values = array('Connexion', 'login.php', 'Page de connexion');
				break;
			case 'lostpwd' :
				return $values = array('Mot de passe perdu', 'lostpwd.php', 'Récupération du mot de passe');
				break;
			case 'logout' :
				return $values = array('Déconnexion', 'logout.php', 'Page de déconnexion');
				break;
			case 'profile' :
				return $values = array('Profil', 'profile.php', 'Page de gestion du profil');
				break;
			case 'administration' :
				return $values = array('Administration', 'administration.php', 'Page d\'administration');
				break;
			default :
				return $values = array('', '', '');
				break;
		}
	}







	/*******************
	 * IMAGES HANDLING *
	 *******************/

	/* Returns *file_path*
		 From a *target_dir* and a *user_id* */
	function retrieve_image($target_dir, $id)
	{
		$extensions = array('jpg', 'png', 'gif');

		foreach($extensions as $ext)
		{
			$file = $target_dir . $id . '.' . $ext;
			if(file_exists($file)) return $file;
		}
	}





	#
	# All credits to Nimrod007
	# https://github.com/Nimrod007/PHP_image_resize
	#

	/**
	* easy image resize function
	* @param  $file - file name to resize
	* @param  $string - The image data, as a string
	* @param  $width - new image width
	* @param  $height - new image height
	* @param  $proportional - keep image proportional, default is no
	* @param  $output - name of the new file (include path if needed)
	* @param  $delete_original - if true the original image will be deleted
	* @param  $use_linux_commands - if set to true will use "rm" to delete the image, if false will use PHP unlink
	* @param  $quality - enter 1-100 (100 is best quality) default is 100
	* @return boolean|resource
	*/
	function smart_resize_image($file,
	                            $string             = null,
	                            $width              = 0,
	                            $height             = 0,
	                            $proportional       = false,
	                            $output             = 'file',
	                            $delete_original    = true,
	                            $use_linux_commands = false,
								  $quality = 100
			 ) {

	  if ( $height <= 0 && $width <= 0 ) return false;
	  if ( $file === null && $string === null ) return false;

	  # Setting defaults and meta
	  $info                         = $file !== null ? getimagesize($file) : getimagesizefromstring($string);
	  $image                        = '';
	  $final_width                  = 0;
	  $final_height                 = 0;
	  list($width_old, $height_old) = $info;
	$cropHeight = $cropWidth = 0;

	  # Calculating proportionality
	  if ($proportional) {
	    if      ($width  == 0)  $factor = $height/$height_old;
	    elseif  ($height == 0)  $factor = $width/$width_old;
	    else                    $factor = min( $width / $width_old, $height / $height_old );

	    $final_width  = round( $width_old * $factor );
	    $final_height = round( $height_old * $factor );
	  }
	  else {
	    $final_width = ( $width <= 0 ) ? $width_old : $width;
	    $final_height = ( $height <= 0 ) ? $height_old : $height;
	  $widthX = $width_old / $width;
	  $heightX = $height_old / $height;

	  $x = min($widthX, $heightX);
	  $cropWidth = ($width_old - $width * $x) / 2;
	  $cropHeight = ($height_old - $height * $x) / 2;
	  }

	  # Loading image to memory according to type
	  switch ( $info[2] ) {
	    case IMAGETYPE_JPEG:  $file !== null ? $image = imagecreatefromjpeg($file) : $image = imagecreatefromstring($string);  break;
	    case IMAGETYPE_GIF:   $file !== null ? $image = imagecreatefromgif($file)  : $image = imagecreatefromstring($string);  break;
	    case IMAGETYPE_PNG:   $file !== null ? $image = imagecreatefrompng($file)  : $image = imagecreatefromstring($string);  break;
	    default: return false;
	  }


	  # This is the resizing/resampling/transparency-preserving magic
	  $image_resized = imagecreatetruecolor( $final_width, $final_height );
	  if ( ($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG) ) {
	    $transparency = imagecolortransparent($image);
	    $palletsize = imagecolorstotal($image);

	    if ($transparency >= 0 && $transparency < $palletsize) {
	      $transparent_color  = imagecolorsforindex($image, $transparency);
	      $transparency       = imagecolorallocate($image_resized, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
	      imagefill($image_resized, 0, 0, $transparency);
	      imagecolortransparent($image_resized, $transparency);
	    }
	    elseif ($info[2] == IMAGETYPE_PNG) {
	      imagealphablending($image_resized, false);
	      $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
	      imagefill($image_resized, 0, 0, $color);
	      imagesavealpha($image_resized, true);
	    }
	  }
	  imagecopyresampled($image_resized, $image, 0, 0, $cropWidth, $cropHeight, $final_width, $final_height, $width_old - 2 * $cropWidth, $height_old - 2 * $cropHeight);


	  # Taking care of original, if needed
	  if ( $delete_original ) {
	    if ( $use_linux_commands ) exec('rm '.$file);
	    else @unlink($file);
	  }

	  # Preparing a method of providing result
	  switch ( strtolower($output) ) {
	    case 'browser':
	      $mime = image_type_to_mime_type($info[2]);
	      header("Content-type: $mime");
	      $output = NULL;
	    break;
	    case 'file':
	      $output = $file;
	    break;
	    case 'return':
	      return $image_resized;
	    break;
	    default:
	    break;
	  }

	  # Writing image according to type to the output destination and image quality
	  switch ( $info[2] ) {
	    case IMAGETYPE_GIF:   imagegif($image_resized, $output);    break;
	    case IMAGETYPE_JPEG:  imagejpeg($image_resized, $output, $quality);   break;
	    case IMAGETYPE_PNG:
	      $quality = 9 - (int)((0.9*$quality)/10.0);
	      imagepng($image_resized, $output, $quality);
	      break;
	    default: return false;
	  }

	  return true;
	}
?>
