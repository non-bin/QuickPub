<?php
require_once 'log.php';
$mainConfigFilePath = __DIR__ . "/config/main.json";
$mainConfigFile = @fopen($mainConfigFilePath, "r") or die(addLogEntry("Unable to open file main.json", "error", "0002~0"));
$mainConfig = @fread($mainConfigFile,filesize($mainConfigFilePath)) or die(addLogEntry("Unable to open read main.json", "error", "0002~1"));
$mainConfig = @json_decode($mainConfig, true) or die(addLogEntry("Unable to decode main.json", "error", "0003~0"));

function getConfig($path)
{
	$configFilePath = __DIR__ . "/config/" . $path;
	$configFile = @fopen($configFilePath, "r") or die(addLogEntry("Unable to open custom config file " . $path, "error", "0002~0"));
	$config = @fread($configFile,filesize($configFilePath)) or die(addLogEntry("Unable to read custom config file " . $path, "error", "0002~1"));
	$config = @json_decode($config, true) or die(addLogEntry("Unable to decode custom config file " . $path, "error", "0003~0"));
	return $config;
}

function getRoleConfig($role)
{
	global $mainConfig;

	$path = $mainConfig['roles'][$role]['configPath'];
	$configFilePath = __DIR__ . "/config/roles/" . $path;
	$configFile = @fopen($configFilePath, "r") or die(addLogEntry("Unable to open custom config file " . $path, "error", "0002~0"));
	$config = @fread($configFile,filesize($configFilePath)) or die(addLogEntry("Unable to read custom config file " . $path, "error", "0002~1"));
	$config = @json_decode($config, true) or die(addLogEntry("Unable to decode custom config file " . $path, "error", "0003~0"));
	return $config;
}
?>