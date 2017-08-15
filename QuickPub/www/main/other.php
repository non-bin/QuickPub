<?php
var_export(debug_backtrace());

if (isset($post['pageNo']))
{
	$pageNo = $post['pageNo'];
}
else
{
	$pageNo = 0;
}

if ($pageNo < count($config[$selRole][$selAction]['pages']) - 1)
{
	if (isset($query['page']))
	{
		$action = "?page=" . $query['page'] + 1;
	}
	else
	{
		$action = "?page=1";
	}
}
else
{
	$action = "../../submit.php";
}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../../css/main.css">
	<script type="text/javascript" src="../../javaScript/author_submit.php"></script>
</head>
<body onload="checkWordCount()">
	<a href="../../download/download.php">Download</a>
	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
		<input type="hidden" name="token" value="<?php echo $token; ?>">
		<?php
		echo '<h1>' . $config[$selRole][$selAction]['pages'][$pageNo]['name'] . "</h1>";
		for ($j=0; $j < count($config[$selRole][$selAction]['pages'][$pageNo]['elements']); $j++)
		{
			if ($config[$selRole][$selAction]['pages'][$pageNo]['elements'][$j]['type'] == "radio")
			{
				echo '<h3>' . $config[$selRole][$selAction]['pages'][$pageNo]['elements'][$j]['title'] . '</h3>';
				for ($k=0; $k < count($config[$selRole][$selAction]['pages'][$pageNo]['elements'][$j]['options']); $k++)
				{
					echo '<input type="radio" name="' . $config[$selRole][$selAction]['pages'][$pageNo]['elements'][$j]['name'];
					echo '" value="' . $config[$selRole][$selAction]['pages'][$pageNo]['elements'][$j]['options'][$k]['value'];
					echo '"> ' . $config[$selRole][$selAction]['pages'][$pageNo]['elements'][$j]['options'][$k]['name'] . "<br>";
				}
			}
			elseif ($config[$selRole][$selAction]['pages'][$pageNo]['elements'][$j]['type'] == "plainHTML")
			{
				echo $config[$selRole][$selAction]['pages'][$pageNo]['elements'][$j]['value'];
			}
			elseif (count($config[$selRole][$selAction]['pages']) > 1 && $config[$selRole][$selAction]['pages'][$pageNo]['elements'][$j]['type'] == "submit")
			{
				if (isset($config[$selRole][$selAction]['pages'][$pageNo]['elements'][$j]['name']))
				{
					echo '<input type="submit" name="' . $config[$selRole][$selAction]['pages'][$pageNo]['elements'][$j]['name'] . '"' . $config[$selRole][$selAction]['pages'][$pageNo]['elements'][$j]['name'] . '>';
				}
				else
				{
					echo '<input type="submit" name="' . $config[$selRole][$selAction]['pages'][$pageNo]['elements'][$j]['name'] . '">';
				}
			}
			else
			{
				echo '<h3>' . $config[$selRole][$selAction]['pages'][$pageNo]['elements'][$j]['title'] . '</h3>';
				$keys = array_keys($config[$selRole][$selAction]['pages'][$pageNo]['elements'][$j]);
				echo '<input ';
				for ($k=0; $k < count($config[$selRole][$selAction]['pages'][$pageNo]['elements'][$j]); $k++)
				{
					echo $keys[$k];
					echo '="' . $config[$selRole][$selAction]['pages'][$pageNo]['elements'][$j][$keys[$k]] . '" ';
				}
				echo "> <br>";
			}
		}
		?>
	</form>
</body>
</html>