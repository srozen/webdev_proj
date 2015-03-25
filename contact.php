<?php

?>

<h1>Formulaire de contact</h1> 
<form name="contact" method="post" action="index.php?page=contact">
	Mail : <br/> 
	<input type="text" name="cmail"/><br/>
	Sujet : <br/>
	<input type="text" name="csubject"/><br/>
	Message : <br/>
	<textarea name="cmessage"></textarea><br/>
	<input type="submit" name="csubmit"/>
</form>

<?php
	if(isset($_POST['csubmit'])){
		if(not_empty($_POST['cmail'])AND not_empty($_POST['csubject']) 
		AND not_empty($_POST['cmessage']))
		{
			$headers = 'From: Samuel Monroe <admin@kek.com> ' . "\r\n" . 
			'Reply-To: admin@kek.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
				mail($_POST['cmail'], $_POST['csubject'], $_POST['cmessage'], $headers);
		}

		echo '<p style="color : #FF0000">Le mail a été envoyé.</p>';
	}
?>
