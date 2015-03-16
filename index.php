<?php
	$css;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>PMM - Project</title>
<?php
	if(isset($_GET['style']) AND !empty($_GET['style'])) {		
	switch($_GET['style']){
	case 'green' : $css = 'green.css'; break;
	case 'red' : $css = 'red.css'; break;
	case 'blue' : $css = 'blue.css'; break;
	}
	}
?>
		<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>"/>
	</head>

	<body>
		<nav>
			<a href="index.php?style=green">Green Theme</a>
			<a href="index.php?style=red">Red Theme</a>
			<a href="index.php?style=blue">Blue Theme</a>
		</nav>

		<header>
			<h1>Header</h2>
		</header>

		<nav>
			<a href="#">Accueil</a>
			<a href="#">Normale</a>
			<a href="#">Contact</a>
			<a href="#">Inscription</a>
			<a href="#">Connexion</a>
		</nav>

		<section>
			<h1>Body</h1>
		</section>

		<footer>
			Copyright Samuel Monroe - 2014/2015
			</footer>
		</body>
</html>
