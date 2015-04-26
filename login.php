<?php

	if(logged())
	{
	  header("Location: index.php");
	  die();
	}

	if(isset($_POST['login_submit']))
	{
		login($_POST['login'], $_POST['password'], $_GET['activation'], $config, $dbsocket);
	}
?>


	<form name="login" method="post" action="index.php?page=login">
		Pseudo : <br/>
		<input type="text" name="login"/><br/>
		Mot de passe : <br/>
		<input type="password" name="password"/><br/>
		<input type="submit" name="login_submit"/><br/>
	</form>

	<a href="index.php?page=lostpwd">Mot de passe oublié?</a><br/><br/>
