<?php

?>

<h1>Formulaire d'enregistrement</h1>

<form name="subscribe" method="post" action="index.php?page=subscription">
	Pseudo : <br/>
	<input type="text" name="sub_pseudo"/><br/>
	Mot de passe : <br/>
	<input type="password" name="sub_passwd1"/><br/>
	Vérification du mot de passe : <br/>
	<input type="password" name="sub_passwd2"/><br/>
	Adresse e-mail : <br/>
	<input type="text" name="sub_mail1"/><br/>
	Vérification e-mail :<br/>
	<input type="text" name="sub_mail2"/><br/><br/>
	<input type="submit" name="sub_submit"/>
</form>
