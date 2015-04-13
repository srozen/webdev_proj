<?php

?>

<form name="register" method="post" action="index.php?page=register">
	Pseudo : <br/>
	<input type="text" name="reg_login"/><br/>

	Mot de passe : <br/>
	<input type="password" name="reg_pwd1"/><br/>

	Vérification du mot de passe : <br/>
	<input type="password" name="reg_pwd2"/><br/>

	Adresse e-mail : <br/>
	<input type="text" name="reg_mail1"/><br/>

	Vérification e-mail :<br/>
	<input type="text" name="reg_mail2"/><br/><br/>

	<input type="submit" name="reg_submit"/>
</form>

<?php

	if(isset($_POST['reg_submit']))
	{

	}

	function check_register($login, $pwd1, $pwd2, $mail1, $mail2)
	{
		
	}
