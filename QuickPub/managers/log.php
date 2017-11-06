<?php

define('return_errors', 'none');    // error detail returned from function
define('display_errors', 'simple'); // error detail to be echoed to the page
define('log_errors', 'full');       // error detail to be logged to the error log file (logs/error.log)

function dump($var, $print = true, $label = true) // dump the contents of a variable
{
	if ($label)
	{
		$trace = debug_backtrace();
		$vLine = file($trace[0]['file']);
		$fLine = $vLine[$trace[0]['line'] - 1];
		preg_match_all("/\\$(\w+)/", $fLine, $match);
		$varName = $match[0][0];
	}

	$out = var_export($var, true); // export the variable
	$out = $out . '<br>';

	if ($label)
	{
		if ($print) // if the function is called to return it's value
		{
			echo '<pre>' . $varName . ' = ' . $out . '</pre>';   // echo it
			return '<pre>' . $varName . ' = ' . $out . '</pre>'; // then return it
		}
		else                                               // if not
		{
			return '<pre>' . $varName . ' = ' . $out . '</pre>'; // just return it
		}
	}
	else
	{
		if ($print) // if the function is called to return it's value
		{
			echo '<pre>' . $out . '</pre>';   // echo it
			return '<pre>' . $out . '</pre>'; // then return it
		}
		else                            // if not
		{
			return '<pre>' . $out . '</pre>'; // just return it
		}
	}
}

function addLogEntry($description = 'Unknown Error', $logName = 'error', $errorNo = '0000', $echoPath = true)
{
	/*
	detail of error reporting:
	none: don't output anything
	simple: simple error report in the format 'Quickpub Warning: <description> in <file> on line <line>'
	simplehtml: return only, html format simple error report in the format 'Quickpub Warning: <description> in <file> on line <line>'
	full: verbose output
	 */

	// $echoPath = $config['system']['echoPath'];

	$genralLogPath = realpath('../../') . '/logs/general.log'; // save the log files paths
	$errorLogPath  = realpath('../../') . '/logs/error.log';

	if (!file_exists(realpath('../../') . '/logs/'))
	{
		mkdir(realpath('../../') . '/logs/');
	}

	$genralLog = fopen($genralLogPath, 'a'); // open the log files
	$errorLog  = fopen($errorLogPath, 'a');

	if ($logName == 'general') // if the output log is 'general'
	{
		$logString = date("d/m/y H:i.s - ") . $description . "\n"; // log to the general log file (logs/general.log) in the format 'dd/mm/yy hh:mm.ss - <description>'
		fwrite($genralLog, $logString);
	}
	elseif ($logName == 'error') // if the output log is 'error'
	{
		$debugInfo = debug_backtrace(); // get the debug traceback

		if (strpos($errorNo, "0004") !== false) // if the error number is 0004 (MySQL error)
		{
			global $dbc;  // get access to the database connection
			global $stmt; // and sql statement

			$errorNo = $errorNo . '~' . $db->connect_errno; // use the contents of mysql_error() as the description

			//this can be used to use the description from the function call as well:
			// $description = $description . '. ' . mysqli_error($dbc); // add the contents of mysql_error() to the description

		}

		if (strpos($errorNo, "0003") !== false) // if the error number is 0003 (JSON error)
		{
			$errorNo = $errorNo . '~' . ; // use the contents of json_last_error() as the error number
		}

		$logString = "//----------------------------------------------\n\n" . date("d/m/y H:i.s - ") . $errorNo . "\n\n" . $description . "\nError called in file: " . preg_replace("/\\\\/", "/", $debugInfo['0']['file']) . " on line: " . $debugInfo['0']['line'] . "\nUseful Information:\n\ndebugInfo:\n" . stripslashes(var_export($debugInfo, true)) . "\n\n_SERVER:\n" . stripslashes(var_export($_SERVER, true)) . "\n\n\n"; // create the verbose output

		// these two lines can be added to:

		// Alert on error
		// echo '<script>alert("error - ' . $errorNo . '\n' . $description . '\n' . preg_replace('%\n%', '\n', var_export(debug_backtrace(), true)) . '");</script>';

		// Redirect on error
		// echo "<script>window.location.href = 'http://' + window.location.hostname + '/V.3/www/error.php?errno=" . $errorNo . "';</script>";

		if ($echoPath)
		{
			$errorLocation     = $debugInfo['0']['file'] . ' on line ' . $debugInfo['0']['line'];
			$errorLocationHtml = ' in <b>' . $debugInfo['0']['file'] . '</b> on line <b>' . $debugInfo['0']['line'] . '</b>';
		}
		else
		{
			$errorLocation     = '';
			$errorLocationHtml = '';
		}

		if (log_errors == 'full') // verbose output
		{
			fwrite($errorLog, $logString);    // wright the verbose report to the error file
		}
		elseif (log_errors == 'simple') // simple output
		{
			$logString = 'Quickpub Warning: (' . $errorNo . ') ' . $description . ' in ' . $errorLocation . '\n';
			fwrite($errorLog, $logString); // write the simple error report to file
		}

		if (return_errors == 'full') // verbose output
		{
			$logString = htmlspecialchars($logString);       // clean the verbose output variable for use in html
			return preg_replace('%\n%', "<br>", $logString); // return the clean string
		}
		elseif (return_errors == 'simple')             // simple output
		{
			$logString = 'Quickpub Warning: (' . $errorNo . ') ' . $description . ' in ' . $errorLocation;
			return $logString;                       // return the simple error report
		}
		elseif (return_errors == 'simplehtml') // simple output
		{
			$logString = '<b>Quickpub Warning: </b>(' . $errorNo . ') ' . $description . $errorLocationHtml . '<br>';
			return $logString; // return the simple error report
		}

		if (display_errors == 'full') // verbose output
		{
			$logString = htmlspecialchars($logString);     // clean the verbose output variable for use in html
			echo preg_replace('%\n%', "<br>", $logString); // echo the clean string
		}
		elseif (display_errors == 'simple')          // simple output
		{
			$logString = '<b>Quickpub Warning: </b>(' . $errorNo . ') ' . $description . $errorLocationHtml . '<br>';
			echo $logString; // echo the simple error report
		}
	}
	else
	{
		addLogEntry('Error while adding log entry', 'error', '0001~0');
	}
}

?>
