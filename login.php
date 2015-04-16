<?php
	if(logged())
	{
		header("Location: index.php");
		die();
	}
?>


	<form name="login" method="post" action="index.php?page=login">
		Pseudo : <br/>
		<input type="text" name="log_login"/><br/>
		Mot de passe : <br/>
		<input type="password" name="log_passwd"/><br/>
		<input type="submit" name="log_submit"/><br/>
	</form>

	<a href="index.php?page=lostpwd">Mot de passe oublié?</a><br/><br/>

<?php
	if(isset($_POST['log_submit']))
	{
		if(is_filled($_POST['log_login']) AND is_filled($_POST['log_passwd']))
		{
			$dbsocket = db_connexion();
			$query = 'SELECT count(*)
								FROM user
								WHERE user_login = \'' . $_POST['log_login'] . '\' AND binary user_pwd = \'' . $_POST['log_passwd'] . '\';';

			$result = $dbsocket->query($query);

			if($result->fetchColumn() > 0)
			{
				echo "<h3 class=\"success_msg\">Connexion réussie ! </h3>";
				$_SESSION['logged'] = true;
				$_SESSION['login'] = $_POST['log_login'];

				$query = 'SELECT user_id, user_login, user_mail, user_lastlogin
									FROM user
									WHERE user_login = \'' . $_POST['log_login'] . '\';';
				$result = $dbsocket->query($query);
				$user = $result->fetch(PDO::FETCH_ASSOC);
				$_SESSION['user'] = new User($user['user_id'], $user['user_login'], $user['user_mail'], 0, 0);

				header("Location: index.php");
			}
			else
			{
				echo "<h3 class=\"error_msg\">Mauvais login ou mot de passe ! </h3>";
			}
			$dbsocket = null;
		}
	}
