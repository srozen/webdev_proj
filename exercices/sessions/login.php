<?php
	session_start();
	$_SESSION['login'] = 'kek';
	header("Location: index.php");
	die();
?>
