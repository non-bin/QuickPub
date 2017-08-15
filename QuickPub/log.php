<?php
require_once __DIR__ . '\other.php';

function addLogEntry($description = 'Unknown Error', $logName = 'error', $errorNo = '0000')
{
	$return_errors = 'none';
	$display_errors = 'simple';

	$logGenral = fopen(dirname($_SERVER['SCRIPT_FILENAME'], 3) . '\logs\genral.log', 'a');
	$logError = fopen(dirname($_SERVER['SCRIPT_FILENAME'], 3) . '\logs\error.log', 'a');
	if ($logName == 'genral')
	{
		$logString = date("d/m/y H:i.s - ") . $description . "\n";
		fwrite($logGenral, $logString);
	}
	elseif ($logName == 'error')
	{
		$debugInfo = debug_backtrace();

		if ($errorNo == "0004")
		{
			global $dbc;
			global $stmt;

			$description = mysqli_error($dbc);

			$errorNo = $errorNo . "~" . mysqli_errno($dbc);
			$logString = "//----------------------------------------------\n\n" . date("d/m/y H:i.s - ") . $errorNo . "\n\n" . $description . "\nError called in file: " . preg_replace("/\\\\/", "/", $debugInfo['0']['file']) . " on line: " . $debugInfo['0']['line'] . "\nUsfull Information:\n" . var_export($debugInfo, true) . var_export($_SERVER, true) . "\n\n\n";
		}
		else
		{
			$logString = "//----------------------------------------------\n\n" . date("d/m/y H:i.s - ") . $errorNo . "\n\n" . $description . "\nError called in file: " . preg_replace("/\\\\/", "/", $debugInfo['0']['file']) . " on line: " . $debugInfo['0']['line'] . "\nUsfull Information:\n" . var_export($debugInfo, true) . var_export($_SERVER, true) . "\n\n\n";
		}

		fwrite($logError, $logString);

		/*Alert on error
		echo '<script>alert("error - $errorNo\n$description\n' . preg_replace('%\n%', '\n', var_export(debug_backtrace(), true)) . '");</script>';
		*/

		/* Redirect on error
		echo '<script>window.location.href = 'http://' + window.location.hostname + '/V.3/www/error.php';</script>';
		*/

		if ($return_errors == 'all')
		{
			$logString = htmlspecialchars($logString);
			return preg_replace('%\n%', "<br>", $logString);
		}
		if ($return_errors == 'simple')
		{
			$logString = '<b>Warning: </b>' . $description . ' in <b>' . $debugInfo['0']['file'] . '</b> on line <b>' . $debugInfo['0']['line'] . '<br>';
			return $logString;
		}

		if ($display_errors == 'all')
		{
			$logString = htmlspecialchars($logString);
			echo preg_replace('%\n%', "<br>", $logString);
		}
		if ($display_errors == 'simple')
		{
			$logString = '<b>Warning: </b>' . $description . ' in <b>' . $debugInfo['0']['file'] . '</b> on line <b>' . $debugInfo['0']['line'] . '<br>';
			echo $logString;
		}
	}
	else
	{
		addLogEntry('Error with addLogEntry()', 'error', '0001~0');
	}
}

?>