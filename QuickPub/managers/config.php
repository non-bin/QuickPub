<?php

$config = compileConfig();

dump($config);

return $config;

function compileConfig()
{
	if (!$config = readConfigFile('../config/main.json'))
	{
		fail('main.json');
		return false;
	}

	foreach ($config['roles'] as $code => $value)
	{
		if (!$config['roles'][$code] = readConfigFile('../config/roles/' . $config['roles'][$code]['configPath']))
		{
			fail($config['roles'][$code]['configPath']);
			return false;
		}
	}

	return $config;
}

function readConfigFile($relativePath)
{
	if (!$configFilePath = realpath($relativePath)) // get the path to main.json file, and if it doesn't exist
	{
		addLogEntry($relativePath . " is missing or moved", "error", "0007~0"); // tell the user but don't print the location
		return false;                                                    // then return
	}

	if (!$configFile = fopen($configFilePath, "r")) // open the config file, if that fails
	{
		addLogEntry("unable to open " . $relativePath, "error", "0007~1"); // tell the user but don't print the location
		return false;                                                      // then return
	}

	if (!$configRaw = fread($configFile, filesize($configFilePath))) // read the contest of the file
	{
		addLogEntry("unable to read " . $relativePath, "error", "0007~1"); // tell the user but don't print the location
		return false;                                                      // then return
	}

	if (!$config = jsonDecode($configRaw))
	{
		addLogEntry("unable to decode " . $relativePath, "error", "0007~1"); // tell the user but don't print the location
		return false;                                                        // then return
	}

	return $config;
}

function fail($place)
{
	echo '<br><b>failed config updating at ' . $place . '. There should be more errors before this, and way more info in the error log so try and fix the config and try again. Good luck :)</b>';
	return false;
}

function jsonDecode($input)
{
	if ($return = json_decode($input, true))
	{
		return $return;
	}
	else
	{
		addLogEntry('An error occurred while decoding a config file', 'error', '0003');
		return false;
	}
}

?>
