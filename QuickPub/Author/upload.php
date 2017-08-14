<!DOCTYPE html>
<html>
<body>
	<form action="upload.php" method="post" enctype="multipart/form-data">
		<input type="text" name="name"><br>
		<input type="file" name="upload"><br>
		<input type="submit">
	</form>
<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_POST["name"]) . "." . pathinfo($_FILES["upload"]["name"],PATHINFO_EXTENSION);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
	$check = getimagesize($_FILES["upload"]["tmp_name"]);
	if($check !== false) {
		echo "File is an image - " . $check["mime"] . ".";
		$uploadOk = 1;
	} else {
		echo "File is not an image.";
		$uploadOk = 0;
	}
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
	echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
	if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
		echo "The file ". basename( $_FILES["upload"]["name"]). " has been uploaded as " . basename($_POST["name"]) . "." . pathinfo($target_file,PATHINFO_EXTENSION);
	} else {
		echo "Sorry, there was an error uploading your file.<br>Files: ";
		var_dump($_FILES);
		echo "<br>Post: ";
		var_dump($_POST);
	}
}
?>

</body>
</html>