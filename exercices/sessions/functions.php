<?php

	function menu_display($logged, $user, $admin) {
		echo '<nav>';
		echo '<a href="index.php">Page d\'accueil</a>';
		echo '<a href="normal.php">Page normale</a>';
		if($user) echo '<a href="user.php">Page user</a>';
		else echo '<span>Non user</span>';	
		if($admin) echo '<a href="admin.php">Page admin</a>';
		else echo '<span>Non admin</span>';
		if($logged) echo '<a href="logout.php">Logout</a>';
		else echo '<a href="login.php">Login</a>';
		echo '</nav>';
	}
?>
