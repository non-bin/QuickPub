<?php
function addLogEntry($logString, $logName = "genral", $errorNo = "")
{
	$logGenral = fopen(dirname($_SERVER['SCRIPT_FILENAME'], 2) . "/logs/genral.log", "a");
	$logError = fopen(dirname($_SERVER['SCRIPT_FILENAME'], 2) . "/logs/error.log", "a");

	if ($logName == "genral")
	{
		$logString = date("d/m/y H:i.s - ") . $logString . "\n";
		fwrite($logGenral, $logString);
	}
	elseif ($logName == "error")
	{
		$logString = "//----------------------------------------------\n\n" . date("d/m/y H:i.s - ") . sprintf('%04d', $errorNo) . "\n\n" . $logString . "\n_SERVER:\n" . var_export($_SERVER, true) . "\n\n\n";
		fwrite($logError, $logString);
	}
	else
	{
		addLogEntry("Error with addLogEntry() function in log.php\n\nlogName = " . var_export($logName, true), "error", "1");
	}
}

addLogEntry("test log");

?>