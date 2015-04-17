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



	/********************************
	 * SESSIONS HANDLING & SECURITY *
	 ********************************/

	function logged()
	{
		if (isset($_SESSION['logged'])) return $_SESSION['logged'];
		else return false;
	}

	function is_admin()
	{
		return true;
	}


  function indoor_auth($password)
  {
    $dbsocket = db_connexion();
    $query = 'SELECT count(*)
              FROM user
              WHERE user_login = \'' . $_SESSION['user']->getLogin() . '\' AND binary user_pwd = \'' . $password . '\';';
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

		$dbsocket = db_connexion();

		$result = $dbsocket->query($query);

		create_table($result, 'Messages : ');
	}

	function display_users()
	{

	}

	function search_users()
	{

	}

	function display_config()
	{

	}


	function create_table($reqresult, $title)
	{
		$data = $reqresult->fetchAll(PDO::FETCH_ASSOC);
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
