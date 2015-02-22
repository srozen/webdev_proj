<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Mailing subscribe</title>
	</head>

	<body>
		<form name="subscribe" method="post" action="mail.php">
			Enter your mail to subscribe :
			<input type="text" name="mail"/>
			<input type="submit">
		</form>
	</body>

	<?php 
		if(!empty($_POST['mail'])) {
			$subject = 'ALERT';
			$message = 'You illegally downloaded movies from website T411.';
			$headers = 'From: cvaprot@saba.com' . "\r\n" .
			    'Reply-To: cvaprot@saba.com' . "\r\n" .
				    'X-Mailer: PHP/' . phpversion();
			mail($_POST['mail'], $subject, $message, $headers);
		}
	?>
</html>
