<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Image upload</title>
	</head>

	<body>
		<form action="image_upload.php" method="post" enctype="multipart/form-data">
			Select image to upload:
			<input type="file" name="image" id="image"/>
			<input type="submit" value="Upload Image" name="submit"/>
		</form>
	</body>
</html>

<?php
	//Destination directory - Same as script for now
	$target_dir = "";
	//Specifies path of the file to be uploaded
	$target_file = $target_dir . basename($_FILES["image"]["name"]);
	//NOT USED YET
	$uploadOk = 1;
	
	/*
	 * Check is image is not fake 
	 */
	$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["image"]["tmp_name"]);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
	}

	/*
	 * Check if $upload is set to allow upload
	 */
	if($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
	} else {
		if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
			echo "The file " . basename($_FILES["image"]["name"]) . " has been uploaded.";
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}
?>
