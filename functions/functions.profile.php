<?php

  function display_profile($user)
  {
    $profile = '<h4> Données du profil </h4>
                  <label> Login : </label><br/> ' . $user->getLogin() . '
                  <label> Mail : </label><br/> ' . $user->getMail() . '
                  <label> Id : </label><br/> ' . $user->getId() . '
                  <label> Dernière connexion : </label><br/> ' . $user->getLastLogin() . '
                  <label> Avatar : </label><br/>' . display_avatar($user);
    echo $profile;
  }

  function display_profile_form($user, $target)
  {
    $form = '<h4> Modification du profil </h4>
                <form name="profil" method="post" action="'. $target . '" enctype="multipart/form-data">
                  <label> Login : </label><br/>
                    <input type="text" name="login" value="' . $user->getLogin() . '"/><br/>
                  <label> Mot de passe </label><br/>
                    <input type="password" name="password"/><br/>
                  <label> Vérification du mot de passe </label><br/>
                    <input type="password" name="checkpassword"/><br/>
                  <label> Mail : </label><br/>
                    <input type="text" name="mail" value="' . $user->getMail() . '"/><br/>
                  <label> Vérification Mail : </label><br/>
                    <input type="text" name="checkmail"/><br/>
                  <label> Avatar : </label><br/>
                    <input type="file" name="avatar" id="avatar"><br/>
                  <label> Pour appliquer les changements, entrez votre mot de passe : </label><br/>
                  <input type="password" name="userpassword"/><br/>
                  <input type="submit" name="submit_profile"/><br/>
                </form>';
    echo $form;
  }

  function process_profile_form($login, $password, $checkpassword, $mail, $checkmail, $userpassword, $user)
  {
    if(indoor_auth($userpassword))
    {
      // Login
      if($login != $user->getLogin())
      {
        if(check_login($login))
        {
          $user->update('login', $login);
        }
      }

      if(filled($password) AND filled($checkpassword))
      {
        if(check_passwords($password, $checkpassword))
        {
          $user->update('password', encrypt($password));
        }
      }

      if($mail != $user->getMail())
      {
        if(check_mails($mail, $checkmail))
        {
          $user->update('mail', $mail);
        }
      }

      if($_FILES["avatar"]["error"] != 0)
      {
        echo 'lelele';
      }
      else
      {
        update_user_avatar($user);
      }
    }
    else
    {
      echo '<div class="error_msg"> Le mot de passe de confirmation est erroné. </div>';
    }
  }

  function display_avatar($user)
  {
    if($user->getAvatar() == true)
    {
        $extensions = array('jpg', 'png', 'gif');

        foreach($extensions as $ext)
        {
          $file = $GLOBALS['config']['GLOBAL']['avatar'] . $user->getId() . '.' . $ext;
          if(file_exists($file))
          {
            echo '<img class="avatar" src="' . $file . '" alt="Avatar de ' . $user->getId() . '"/>';
          }
        }
    }
    else
    {
      echo '<img class="avatar" src="'. $GLOBALS['config']['GLOBAL']['avatar'] . $GLOBALS['config']['GLOBAL']['defaultavatar'] . '" alt="Avatar par défaut"/>';
    }
  }




  function update_user_avatar($user)
  {
    if($user->getAvatar() == false)
    {
      $user->update('avatar', true);
    }
    //Filename related to the user id
    $temp = explode(".",$_FILES["avatar"]["name"]);
    $newfilename = $GLOBALS['config']['GLOBAL']['avatar'] . $user->getId() . '.' .end($temp);

    //Specifies path of the file to be uploaded
    $target_file = $GLOBALS['config']['GLOBAL']['avatar'] . basename($_FILES['avatar']['name']);
    //NOT USED YET
    $uploadOk = 1;

    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

      $check = getimagesize($_FILES["avatar"]["tmp_name"]);
      if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      }
      else
      {
        echo '<span class="error_msg">Le fichier n\'est pas une image !</span>';
        $uploadOk = 0;
      }

    /*
     * Check if $upload is set to allow upload
     */
    if($uploadOk == 0) {
      echo '<span class="error_msg">Votre image n\'a pas été uploadée !</span><br/>';
    }
    else
    {
      $extensions = array('jpg', 'png', 'gif');

      foreach($extensions as $ext)
      {
        $f = $GLOBALS['config']['GLOBAL']['avatar'] . $user->getId() . '.' . $ext;
        if(file_exists($f))
        {
          unlink($f);
        }
      }

      if(move_uploaded_file($_FILES["avatar"]["tmp_name"], $newfilename)) {
        echo '<span class="success_msg">Le fichier ' . basename($_FILES["avatar"]["name"]) . ' a été uploadé.</span>';
        smart_resize_image($newfilename, null, $GLOBALS['config']['AVATAR']['width'], $GLOBALS['config']['AVATAR']['height'], true, $newfilename, false, false, 100);
      }
      else
      {
        echo '<span class="error_msg">Une erreur est survenue durant l\'upload !</span><br/>';
      }
    }
  }

  function profile_auth($password, $config, $dbsocket)
  {
    return filled($password) AND indoor_auth($password, $config, $dbsocket);
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
	  //$cropWidth = ($width_old - $width * $x) / 2;
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
	  imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $final_width, $final_height, $width_old - 2 * $cropWidth, $height_old - 2 * $cropHeight);


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
