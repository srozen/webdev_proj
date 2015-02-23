<?php
	$ini_array = parse_ini_file("config.ini", true);
	print_r($ini_array);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Ini form</title>
	</head>

	<body>
		<h1>Set your displays choices : </h1><br/><br/>
		<form action="form_ini.php" method="get" name="iniform">
<?php
	$ini_array = parse_ini_file("config.ini", true);
	foreach($ini_array as $file => $section) {
		echo '<h3>[' . $file . ']</h3>';
		echo '<br/>';
		foreach($section as $key => $value) {
			echo $key;
			echo '<input type="text" value="' . $value . '" name="' . $key . '"/><br/>';
			if (isset($_GET['submit'])) ini_set($key,(int)$value);
		}
	}
?>
			<input type="submit" name="submit"/>
		</form>
	</body>
</html>
