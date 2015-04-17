<?php
  if(!logged())
  {
    header("Location: index.php?page=login");
		die();
  }

  $dbsocket = db_connexion();

  /*** MAIL CHANGING ***/
  if(isset($_POST['mail_submit']))
  {
    if(is_filled($_POST['mail_newmail']) AND is_filled($_POST['mail_pwd']))
    {
      if(indoor_auth($_POST['mail_pwd']))
      {
        if($query = $_SESSION['user']->update_db('mail', $_POST['mail_newmail']))
        {
          $dbsocket->exec($query);
        }
      }
    }
  }

  /*** PASSWORD CHANGING ***/
  if(isset($_POST['pwd_submit']))
  {
    if(is_filled($_POST['old_pwd']) AND is_filled($_POST['new_pwd']) AND is_filled($_POST['new_pwd_verif']))
    {
      if(indoor_auth($_POST['old_pwd']))
      {
        if($query = $_SESSION['user']->update_db('password', $_POST['new_pwd']))
        {
          $dbsocket->exec($query);
        }
      }
    }
  }

  /*** LOGIN CHANGING ***/
  if(isset($_POST['username_submit']))
  {
    if(is_filled($_POST['new_username']) AND is_filled($_POST['username_pwd']))
    {
      if(indoor_auth($_POST['username_pwd']))
      {
        if($query = $_SESSION['user']->update_db('login', $_POST['new_username']))
        {
          $dbsocket->exec($query);
        }
      }
    }
  }

  /***********************/

  echo '<pre>';
  echo '<p>Avatar : </p>';
  echo '<p><img src="' . retrieve_image("images/avatars/", $_SESSION['user']->getId()) . '" alt="avatar" /></p>';
  print_r($_SESSION['user']);

  echo 'Login : ' . $_SESSION['user']->getLogin();
  echo '</pre>';
?>


<?php

?>

  <h2>Edition du profil</h2>

<?php
  if(isset($_POST['config_submit']) AND is_filled($_POST['config_password']) AND indoor_auth($_POST['config_password']))
  {
  	//Destination directory - Same as script for now
  	$target_dir = "images/avatars/";
    //Filename related to the user id
    $temp = explode(".",$_FILES["avatar"]["name"]);
    $newfilename = $target_dir . $_SESSION['user']->getId() . '.' .end($temp);

  	//Specifies path of the file to be uploaded
  	$target_file = $target_dir . basename($_FILES['avatar']['name']);
  	//NOT USED YET
  	$uploadOk = 1;

    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

  		$check = getimagesize($_FILES["avatar"]["tmp_name"]);
  		if($check !== false) {
  			echo "File is an image - " . $check["mime"] . ".";
  			$uploadOk = 1;
  		} else {
  			echo "File is not an image.";
  			$uploadOk = 0;
  		}

  	/*
  	 * Check if $upload is set to allow upload
  	 */
  	if($uploadOk == 0) {
  		echo "Sorry, your file was not uploaded.";
  	} else {
  		if(move_uploaded_file($_FILES["avatar"]["tmp_name"], $newfilename)) {
  			echo "The file " . basename($_FILES["avatar"]["name"]) . " has been uploaded.";
  			smart_resize_image($newfilename, null, 200, 200, false, $newfilename, false, false, 100);
  		} else {
  			echo "Sorry, there was an error uploading your file.";
  		}
  	}
  }
?>

<pre>
  <h3>Vos configurations</h3>
  <form name="config_change" action="index.php?page=profile" method="post" enctype="multipart/form-data">
    <label>Avatar : </label><input type="file" name="avatar" id="avatar"/>
    <label>Confirmez en entrant votre mot de passe : </label><input type="password" name="config_password"/>
    <input type="submit" value="Enregistrer" name="config_submit"/>
  </form>
</pre>

<pre>
  <h3>Changer votre e-mail</h3>
  <form name="mail_change" action="index.php?page=profile" method="post">
    <label>Adresse e-mail : </label><input type="text" value="<?php echo $_SESSION['user']->getMail(); ?>" name="mail_newmail"/>
    <label>Mot de passe actuel : </label><input type="password" name="mail_pwd"/>
    <input type="submit" value="Enregistrer" name="mail_submit"/>
  </form>
</pre>

<pre>
  <h3>Changer votre mot de passe </h3>
  <form name="pwd_change" action="index.php?page=profile" method="post">
    <label>Ancien mot de passe : </label><input type="password" name="old_pwd"/>
    <label>Nouveau mot de passe : </label><input type="password" name="new_pwd"/>
    <label>Répéter mot de passe : </label><input type="password" name="new_pwd_verif"/>
    <input type="submit" value="Enregistrer" name="pwd_submit"/>
  </form>
</pre>

<pre>
  <h3>Changer votre nom d'utilisateur</h3>
  <form name="username_change" action="index.php?page=profile" method="post">
    <label>Login souhaité : </label><input type="text" value="<?php echo $_SESSION['user']->getLogin(); ?>" name="new_username"/>
    <label>Confirmez en entrant votre mot de passe : </label><input type="password" name="username_pwd"/>
    <input type="submit" value="Enregistrer" name="username_submit"/>
  </form>
</pre>

<?php
  $dbsocket = null;
?>
