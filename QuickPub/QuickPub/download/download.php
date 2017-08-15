<html>
<head>
	<title>Download File From MySQL</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
	<?php
	include '../../mysql_connect.php';

	$query = "SELECT id, name FROM files";
	$result = mysqli_query($dbc, $query) or die('Error, query failed');
	if(mysqli_num_rows($result) == 0)
	{
		echo "Database is empty <br>";
	}
	else
	{
		while(list($id, $name) = mysqli_fetch_array($result))
		{
			?>
			<a href="download.php?id=<?php echo $id; ?>"><?php echo $name; ?></a> <br>
			<?php
		}
	}
	?>

	<?php
	if(isset($_GET['id']))
	{
		require_once '../../mysql_connect.php';

		$id = $_GET['id'];
		$query = "SELECT name, type, size, content FROM files WHERE id = '" . $id . "'";

		$result = mysqli_query($dbc, $query) or die('Error, query failed');
		list($name, $type, $size, $content) = mysqli_fetch_array($result);

		$type = explode("/", $type)[1];

		$name = $name . "." . $type;

		header("Content-length: $size");
		header("Content-type: $type");
		header("Content-Disposition: attachment; filename=$name");
		echo $content;

		exit;
	}
	?>
</body>
</html>