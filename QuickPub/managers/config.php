<?php
require_once 'log.php';

$mainConfigFilePath = realpath("../../config/main.json"); // get the path to the config file
$mainConfigFile = fopen($mainConfigFilePath, "r") or die(addLogEntry("Unable to open file main.json", "error", "0002~0")); // open the config file
$mainConfig = fread($mainConfigFile,filesize($mainConfigFilePath)) or die(addLogEntry("Unable to open read main.json", "error", "0002~1")); // read the contest of the file
$mainConfig = json_decode($mainConfig, true) or die(addLogEntry("Unable to decode main.json", "error", "0003~0")); // decode the json to an associative array

function getConfig($path)
{
	$configFilePath = realpath("../../config/") . '/' . $path; // get the path to the config file
	$configFile = fopen($configFilePath, "r") or die(addLogEntry("Unable to open custom config file " . $path, "error", "0002~0")); // open the config file
	$config = fread($configFile,filesize($configFilePath)) or die(addLogEntry("Unable to read custom config file " . $path, "error", "0002~1")); // read the contest of the file
	$config = json_decode($config, true) or die(addLogEntry("Unable to decode custom config file " . $path, "error", "0003~0")); // decode the json to an associative array
	return $config;
}

function getRoleConfig($role)
{
	global $mainConfig;

	$configFilePath = realpath("../../config/roles/") . '/' . $mainConfig['roles'][$role]['configPath']; // get the path to the config file
	$configFile = fopen($configFilePath, "r") or die(addLogEntry("Unable to open custom config file " . $path, "error", "0002~0")); // open the config file
	$config = fread($configFile,filesize($configFilePath)) or die(addLogEntry("Unable to read custom config file " . $path, "error", "0002~1")); // read the contest of the file
	$config = json_decode($config, true) or die(addLogEntry("Unable to decode custom config file " . $path, "error", "0003~0")); // decode the json to an associative array
	return $config;
}
?>
