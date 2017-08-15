<?php
$mainConfigFilePath = $_SERVER["DOCUMENT_ROOT"] . "/V.2/quickpub/config/main.json";
$mainConfigFile = fopen($mainConfigFilePath, "r") or die('<script type="text/javascript">alert("Unable to open file main.json please contact your administrator");</script>');
$mainConfig = fread($mainConfigFile,filesize($mainConfigFilePath)) or die('<script type="text/javascript">alert("unable to read main.json please contact your administrator");</script>');
$mainConfig = json_decode($mainConfig, true) or die('<script type="text/javascript">alert("Unable to decode main.json please contact your administrator");</script>');

$configFilePath = $_SERVER["DOCUMENT_ROOT"] . "/V.2/quickpub/config/author_submit.json";
$configFile = fopen($configFilePath, "r") or die('<script type="text/javascript">alert("Unable to open file author_submit.json please contact your administrator");</script>');
$config = fread($configFile,filesize($configFilePath)) or die('<script type="text/javascript">alert("unable to read author_submit.json please contact your administrator");</script>');
$config = json_decode($config, true) or die('<script type="text/javascript">alert("Unable to decode author_submit.json please contact your administrator");</script>');

if (isset($config['title']))
{
	$title = $config['title'];
}
else
{
	$title = $mainConfig['title'];
}

parse_str($_SERVER['QUERY_STRING'], $query);
if (isset($query['page']))
{
	$pageNo = $query['page'];
}
else
{
	$pageNo = 0;
}

if ($pageNo < count($config['pages']) - 1)
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
		<input type="hidden" name="hash" value="<?php echo $hash; ?>">
		<?php
		echo '<h1>' . $config['pages'][$pageNo]['name'] . "</h1>";
		for ($j=0; $j < count($config['pages'][$pageNo]['elements']); $j++)
		{
			if ($config['pages'][$pageNo]['elements'][$j]['type'] == "radio")
			{
				echo '<h3>' . $config['pages'][$pageNo]['elements'][$j]['title'] . '</h3>';
				for ($k=0; $k < count($config['pages'][$pageNo]['elements'][$j]['options']); $k++)
				{
					echo '<input type="radio" name="' . $config['pages'][$pageNo]['elements'][$j]['name'];
					echo '" value="' . $config['pages'][$pageNo]['elements'][$j]['options'][$k]['value'];
					echo '"> ' . $config['pages'][$pageNo]['elements'][$j]['options'][$k]['name'] . "<br>";
				}
			}
			elseif ($config['pages'][$pageNo]['elements'][$j]['type'] == "plainHTML")
			{
				echo $config['pages'][$pageNo]['elements'][$j]['value'];
			}
			elseif (count($config['pages']) > 1 && $config['pages'][$pageNo]['elements'][$j]['type'] == "submit")
			{
				if (isset($config['pages'][$pageNo]['elements'][$j]['name']))
				{
					echo '<input type="submit" name="' . $config['pages'][$pageNo]['elements'][$j]['name'] . '"' . $config['pages'][$pageNo]['elements'][$j]['name'] . '>';
				}
				else
				{
					echo '<input type="submit" name="' . $config['pages'][$pageNo]['elements'][$j]['name'] . '">';
				}
			}
			else
			{
				echo '<h3>' . $config['pages'][$pageNo]['elements'][$j]['title'] . '</h3>';
				$keys = array_keys($config['pages'][$pageNo]['elements'][$j]);
				echo '<input ';
				for ($k=0; $k < count($config['pages'][$pageNo]['elements'][$j]); $k++)
				{
					echo $keys[$k];
					echo '="' . $config['pages'][$pageNo]['elements'][$j][$keys[$k]] . '" ';
				}
				echo "> <br>";
			}
		}
		?>
	</form>
</body>
</html>