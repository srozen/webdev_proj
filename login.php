<?php
	if(isset($_POST['login_submit']))
	{
		login($_POST['login'], $_POST['password'], $_POST['activation']);
	}
?>

<form name="login" method="post" action="index.php?page=login&activation=<?php echo $_GET['activation'];?>">
	Pseudo : <br/>
	<input type="text" name="login"/><br/>
	Mot de passe : <br/>
	<input type="password" name="password"/><br/>
	<input type="hidden" name="activation" value="<?php echo $_GET['activation']; ?>"/>
	<input type="submit" name="login_submit"/><br/>
</form>

<a href="#">Mot de passe oublié?</a><br/><br/>
