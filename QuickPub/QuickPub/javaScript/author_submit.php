<?php
$mainConfigFilePath = $_SERVER["DOCUMENT_ROOT"] . "/quickpub/config/main.json";
$mainConfigFile = fopen($mainConfigFilePath, "r") or die('alert("JS was unable to open file main.json please contact your administrator");'); // open config file
$mainConfig = fread($mainConfigFile,filesize($mainConfigFilePath)) or die('alert("JS was unable to read main.json please contact your administrator");'); // read config file
$mainConfig = json_decode($mainConfig, true) or die('alert("JS was unable to decode main.json please contact your administrator");');					// decode config file

$configFilePath = $_SERVER["DOCUMENT_ROOT"] . "/quickpub/config/author_submit.json";
$configFile = fopen($configFilePath, "r") or die('alert("JS was unable to open file author_submit.json please contact your administrator");'); // open config file
$config = fread($configFile,filesize($configFilePath)) or die('alert("JS was unable to read author_submit.json please contact your administrator");'); // read config file
$config = json_decode($config, true) or die('alert("JS was unable to decode author_submit.json please contact your administrator");');					// decode config file

for ($i = 0; $i < 1; $i++) { // change when all pages are added
	for ($j = 0; $j < count($config['pages'][$i]['elements']); $j++) {
		if ($config['pages'][$i]['elements'][$j]['type'] == "text" && isset($config['pages'][$i]['elements'][$j]['maxWords']))
		{
			echo 'var ' . $config['pages'][$i]['elements'][$j]['name'] . ' = ' . $config['pages'][$i]['elements'][$j]['maxWords'] . '; function checkWordCount() { new' . $config['pages'][$i]['elements'][$j]['name'] . 'Value = ""; ' . $config['pages'][$i]['elements'][$j]['name'] . 'Value = document.getElementById("' . $config['pages'][$i]['elements'][$j]['name'] . '").value.split(" "); if (' . $config['pages'][$i]['elements'][$j]['name'] . 'Value.length > ' . $config['pages'][$i]['elements'][$j]['name'] . ') { for (var i = 0; i < ' . $config['pages'][$i]['elements'][$j]['name'] . '; i++) { new' . $config['pages'][$i]['elements'][$j]['name'] . 'Value = new' . $config['pages'][$i]['elements'][$j]['name'] . 'Value + ' . $config['pages'][$i]['elements'][$j]['name'] . 'Value[i] + " "; } document.getElementById("' . $config['pages'][$i]['elements'][$j]['name'] . '").value = new' . $config['pages'][$i]['elements'][$j]['name'] . 'Value; } setTimeout(checkWordCount, 10); }' . "\n";
		}
	}
}
?>