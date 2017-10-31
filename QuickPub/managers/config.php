<?php
require_once 'dataValidation.php';
require_once 'log.php';

$mainConfigFilePath = realpath("../../config/main.json");                                                                                            // get the path to the config file
$mainConfigFile     = fopen($mainConfigFilePath, "r") or die(addLogEntry("Unable to open file main.json", "error", "0002~0"));                       // open the config file
$mainConfigRaw      = fread($mainConfigFile, filesize($mainConfigFilePath)) or die(addLogEntry("Unable to open read main.json", "error", "0002~1")); // read the contest of the file
$mainConfigValid    = validate($mainConfigRaw, 'json');                                                                                              // validate the file contents
$mainConfig         = json_decode($mainConfigValid, true) or die(addLogEntry("Unable to decode main.json", "error", "0003~0"));                      // decode the json to an associative array

foreach ($mainConfig['roles'] as $key => $value)
{
	$roles[] = $key;
}

function getConfig($path)
{
	$configFilePath = realpath("../../config/") . '/' . $path;                                                                                            // get the path to the config file
	$configFile     = fopen($configFilePath, "r") or die(addLogEntry("Unable to open custom config file " . $path, "error", "0002~0"));                   // open the config file
	$configRaw      = fread($configFile, filesize($configFilePath)) or die(addLogEntry("Unable to read custom config file " . $path, "error", "0002~1")); // read the contest of the file
	$configValid    = validate($configRaw, 'json');                                                                                                       // validate the file contents
	$config         = json_decode($configValid, true) or die(addLogEntry("Unable to decode custom config file " . $path, "error", "0003~0"));             // decode the json to an associative array
	return $config;
}

function getRoleConfig($role)
{
	global $mainConfig;
	global $roles;

	if (in_array($role, $roles))
	{
		$configFilePath = realpath("../../config/roles/") . '/' . $mainConfig['roles'][$role]['configPath'];                                                  // get the path to the config file
		$configFile     = fopen($configFilePath, "r") or die(addLogEntry("Unable to open custom config file " . $path, "error", "0002~0"));                   // open the config file
		$configRaw      = fread($configFile, filesize($configFilePath)) or die(addLogEntry("Unable to read custom config file " . $path, "error", "0002~1")); // read the contest of the file
		$configValid    = validate($configRaw, 'json');                                                                                                       // validate the file contents
		$config         = json_decode($configValid, true) or die(addLogEntry("Unable to decode custom config file " . $path, "error", "0003~0"));             // decode the json to an associative array
		return $config;
	}
	else
	{
		addLogEntry('invalid role ' . $role . ' config requested', 'error', '0007~1');
		return false;
	}
}
?>
