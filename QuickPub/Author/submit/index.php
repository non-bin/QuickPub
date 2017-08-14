<?php
$mainConfigFilePath = $_SERVER["DOCUMENT_ROOT"] . "/wms/config/main.json";
$mainConfigFile = fopen($mainConfigFilePath, "r") or die("Unable to open file main.json"); // open config file
$mainConfig = fread($mainConfigFile,filesize($configFilePath)) or die("unable to read main.json"); // read config file
$mainConfig = json_decode($mainConfig, true) or die('json decoding failed');					// decode config file

$configFilePath = $_SERVER["DOCUMENT_ROOT"] . "/wms/config/author_submit.json";
$configFile = fopen($configFilePath, "r") or die("Unable to open file config.json"); // open config file
$config = fread($configFile,filesize($configFilePath)) or die("unable to read config.json"); // read config file
$config = json_decode($config, true) or die('json decoding failed');					// decode config file
?>


<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
</head>
<body>
	<form action="upload.php" method="post" enctype="multipart/form-data">
		<?php
		for ($i=0; $i < count($config['pages']); $i++)
		{
			echo $config['pages'][$i]['name'] . "<br><br>";
			for ($j=0; $j < count($config['pages'][$i]['elements']); $j++)
			{
				echo '<h3>' . $config['pages'][$i]['elements'][$j]['title'] . '</h3>'; // element title
				if ($config['pages'][$i]['elements'][$j]['type'] == "radio")
				{
					for ($k=0; $k < count($config['pages'][$i]['elements'][$j]['options']); $k++)
					{
						echo '<input type="radio" name="' . $config['pages'][$i]['elements'][$j]['name']; // element name
						echo '" value="' . $config['pages'][$i]['elements'][$j]['options'][$k]['value']; // option value
						echo '"> ' . $config['pages'][$i]['elements'][$j]['options'][$k]['name'] . "<br>"; // option name
					}
				}
				else
				{
					$keys = array_keys($config['pages'][$i]['elements'][$j]); // create array for indexing an elements arrtibutributes
					echo '<input ';															//begin input
					for ($k=0; $k < count($config['pages'][$i]['elements'][$j]); $k++)
					{
						echo $keys[$k]; 														// attribute name
						echo '="' . $config['pages'][$i]['elements'][$j][$keys[$k]] . '" '; // attribute value
					}
					echo "> <br>";
					echo '<label for="' . $config['pages'][$i]['elements'][$j]['type'] . '">'; // add lable
					if (isset($config['pages'][$i]['elements'][$j]['value'])) {
						echo $config['pages'][$i]['elements'][$j]['value'];
					}
					echo "lable</lable><br>";
				}
			}
		}
		?>
	</form>
</body>
</html>