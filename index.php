<?php
	include 'functions.php';
	$page_type;
	if(isset($_GET['page'])) $page_type = $_GET['page'];
	else $page_type='index';

	$page = define_page($page_type);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title><?php echo $page->getMetaTitle(); ?></title>
		<link rel="stylesheet" type="text/css" href="css/base.css"/>
	</head>

	<body>

		<header>
			<h1>Header</h2>

			<nav>
				<a href="index.php?page=index">Accueil</a>
				<a href="index.php?page=normal">Normale</a>
				<a href="index.php?page=contact">Contact</a>
				<a href="index.php?page=subscribe">Inscription</a>
				<a href="index.php?page=login">Connexion</a>
			</nav>

		</header>

		<section>
			<h1>Body</h1>
			<?php include $page->getUrl(); ?>
		</section>

		<footer>
		Copyright Samuel Monroe - 2014 / 2015 <a href="mailto:spat.monroe@gmail.com">Contact</a>
			</footer>
		</body>
</html>
