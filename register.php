<?php
	if(logged())
	{
		header("Location: index.php");
		die();
	}
?>

<form name="register" method="post" action="index.php?page=register">
	Pseudo : <br/>
	<input type="text" name="reg_login"/><br/>

	Mot de passe : <br/>
	<input type="password" name="reg_pwd"/><br/>

	Vérification du mot de passe : <br/>
	<input type="password" name="reg_pwd_check"/><br/>

	Adresse e-mail : <br/>
	<input type="text" name="reg_mail"/><br/>

	Vérification e-mail :<br/>
	<input type="text" name="reg_mail_check"/><br/><br/>

	<input type="submit" name="reg_submit"/>
</form>

<?php

	if(isset($_POST['reg_submit']))
	{
		if(is_filled($_POST['reg_login']) AND is_filled($_POST['reg_pwd']) AND is_filled($_POST['reg_pwd_check']) AND is_filled($_POST['reg_mail']) AND is_filled($_POST['reg_mail_check']))
		{
			$dbsocket = db_connexion();
			$query = 'INSERT INTO user (user_login, user_pwd, user_mail, user_subscription)
								VALUES (\'' . $_POST['reg_login'] . '\', \'' . $_POST['reg_pwd'] . '\', \'' . $_POST['reg_mail'] .'\', NOW())';
			$dbsocket->exec($query);
			$dbsocket = null;
			echo "<h3 class=\"success_msg\">Inscription réussie ! </h3>";

			$to = $_POST['reg_mail'];

			$subject = 'Insription au Wiki';

			$headers = "From: " . strip_tags('no-reply@wiki.pmm.be') . "\r\n";
			$headers .= "Reply-To: ". strip_tags('no-reply@wiki.pmm.be') . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=utf-8\r\n";

			$message = '<html><body>';
			$message .= '<h2>Vous avez été inscrit !</h2>';
			$message .= '<h3>Rappel de votre message : <h3>';
			$message .= '<ul>';
			$message .= '<li><b>Pseudo  :</b>'   . $_POST['reg_login']   . '</li>';
			$message .= '<li><b>Email  :</b>'   . $_POST['reg_mail'] . '</li>';
			$message .= '</ul></body></html>';

			mail($to, $subject, $message, $headers);
		}
		else
		{
			echo "<h3 class=\"error_msg\">Les champs n'ont pas été tous complétés ! </h3>";
		}
	}

?>
