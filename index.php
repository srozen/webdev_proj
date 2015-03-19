<?php
	$page_type;
	if(isset($_GET['page'])) $page_type = $_GET['page'];
	else $page_type='index';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>PMM - Project</title>
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
			<?php
				switch($page_type) {
					case 'index':
						echo '<h2>Page index</h2>';
						break;
					case 'normal':
						echo '<h2>Page normale</h2>';
						break;
					case 'contact':
						include 'contact.php';
						break;
					case 'subscribe':
						echo '<h2>Page d\'inscription</h2>';
						break;
					case 'login':
						echo '<h2>Page de connexion</h2>';
						break;
					default:
						echo '<h2>Page sans choix</h2>';
				}
			?>

		</section>

		<footer>
			Copyright Samuel Monroe - 2014/2015
			</footer>
		</body>
</html>
