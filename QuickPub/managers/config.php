<?php

$config = compileConfig(); // compile the config files

dump($config); // then dump the contents

return $config; // and return it

function compileConfig() // compile the config files
{
	if (!$config = readConfigFile('../config/main.json')) // read the contents of the main config file. if it fails
	{
		fail('main.json'); // tell the user
		return false;      // and ret0
	}

	foreach ($config['roles'] as $code => $value) // loop through each role specified in main.json
	{
		if (!$config['roles'][$code] = readConfigFile('../config/roles/' . $config['roles'][$code]['configPath'])) // if reading it fails
		{
			fail($config['roles'][$code]['configPath']); // tell the user
			return false;                                // and ret0
		}
	}

	foreach ($config['actions'] as $code => $value) // loop through each action specified in main.json
	{
		if (!$config['actions'][$code] = readConfigFile('../config/actions/' . $config['actions'][$code]['configPath'])) // if reading it fails
		{
			fail($config['actions'][$code]['configPath']); // tell the user
			return false;                                  // and ret0
		}
	}

	return $config; // if all gos well, return the config
}

function readConfigFile($relativePath) // read and decode the contents of a config file
{
	if (!$configFilePath = realpath($relativePath)) // get the path to the file, and if it doesn't exist
	{
		addLogEntry($relativePath . " is missing or moved", "error", "0007~0"); // tell the user but don't print the location
		return false;                                                           // then ret0
	}

	if (!$configFile = fopen($configFilePath, "r")) // open the config file, if that fails
	{
		addLogEntry("unable to open " . $relativePath, "error", "0007~1"); // tell the user but don't print the location
		return false;                                                      // then ret0
	}

	if (!$configRaw = fread($configFile, filesize($configFilePath))) // read the contest of the file, if that fails
	{
		addLogEntry("unable to read " . $relativePath, "error", "0007~1"); // tell the user but don't print the location
		return false;                                                      // then ret0
	}

	if (!$config = jsonDecode($configRaw)) // decode the file into and array, if that fails
	{
		addLogEntry("unable to decode " . $relativePath . '. try putting the contents of it into <a href="https://jsonlint.com/">https://jsonlint.com/</a>.', "error", "0007~1"); // tell the user but don't print the location
		return false;                                                                                                                                                             // then ret0
	}

	return $config; // if all gos well, return the config as an array
}

function fail($place) // print a failure message
{
	echo '<br><b>failed config updating at ' . $place . '. There should be more errors before this, and way more info in the error log so try and fix the config and try again. Good luck :)</b>';
	return false;
}

function jsonDecode($input) // decode a JSON string to an assoc array
{
	if ($return = json_decode($input, true)) // if decoding succeeds
	{
		return $return; // return the array
	}
	else          // if not
	{
		addLogEntry('An error occurred while decoding a config file', 'error', '0003'); // throw an error
		return false;                                                                   // and ret0
	}
}

?>
