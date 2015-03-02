<?php
	session_start();
	$logged = false;
	$user = false;
	$admin = false;
	if(!isset($_SESSION['login']));
	else if($_SESSION['login'] == 'admin') {$admin = TRUE; $user = TRUE; $logged = true;}
	else {$user = TRUE; $logged=true;}
	include 'functions.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Page index</title>
	</head>

	<body>
		<h1>Page d'accueil</h1>
	<?php menu_display($logged, $user, $admin); ?>
		<pre>	
	<?php
		echo '<h3>SESSION AVANT</h3>';
		print_r($_SESSION);
		echo '<p>Bienvenue</p>';
		echo '<h3>SESSION APRES</h3>';
		$_SESSION['Pages'][] = 'index.php';
		print_r($_SESSION);
		if(!$logged) session_destroy();
	?>
		</pre>
	</body>
</html>

