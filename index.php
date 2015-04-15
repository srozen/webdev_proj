<?php
	include 'class.page.php';
	include 'class.user.php';
	session_start();
	include 'functions.php'; // Set of basic functions ##TOSPLIT##

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
			<img id="epheclogo" src="images/ephec.png" alt="logo ephec"/>
			<h1>Bienvenue <?php if(logged()) echo $_SESSION['login']; else echo 'anonyme';?>.</h1>

			<nav>
				<?php create_menu(); ?>
			</nav>

		</header>

		<section>
			<h1>Body</h1>
			<h2><?php echo $page->getTitle(); ?></h2>
			<?php include $page->getUrl(); ?>
		</section>

		<footer>
		Copyright Samuel Monroe - 2014 / 2015 <a href="mailto:spat.monroe@gmail.com">Contact</a>
			</footer>
		</body>
</html>
