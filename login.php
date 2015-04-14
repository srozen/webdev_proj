<?php

?>

	<form name="login" method="post" action="index.php?page=login">
		Pseudo : <br/>
		<input type="text" name="log_pseudo"/><br/>
		Mot de passe : <br/>
		<input type="password" name="log_passwd"/><br/>
		<input type="submit" name="log_submit"/><br/>
	</form>

	<a href="index.php?page=lostpwd">Mot de passe oublié?</a><br/><br/>

<?php
	if(isset($_POST['log_submit']))
	{
		
	}
