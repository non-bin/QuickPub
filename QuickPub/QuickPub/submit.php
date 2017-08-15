<?php
if(isset($_POST['submit']) && $_FILES['file']['size'] > 0)
{
	$token = $_POST['token'];
	$fileName = $_POST['title'];
	$tmpName = $_FILES['file']['tmp_name'];
	$fileSize = $_FILES['file']['size'];
	$fileType = $_FILES['file']['type'];

	move_uploaded_file($tmp_name, destination);

	if(!get_magic_quotes_gpc())
	{
		$fileName = addslashes($fileName);
	}

	include '../mysql_connect.php';

	$query = "INSERT INTO files (name, size, type, content ) ".
	"VALUES ('$fileName', '$fileSize', '$fileType', '$content')";

	mysqli_query($dbc, $query) or die('Error, query failed');

	echo "$fileName uploaded<br>";
}
?>