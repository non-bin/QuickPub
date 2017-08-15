<?php
// set database constants
define('db_user', 'requests');
define('db_password', 'Daqawa12');
define('db_host', 'localhost');
define('db_name', 'quickpub');

if ($dbc = mysqli_connect(db_host, db_user, db_password, db_name)) // if connect to the database is sucessfull
{
	if (!mysqli_select_db($dbc, db_name)) // if database dosn't exist
	{
		die(addLogEntry('No database with that name', 'error', '0004~0')); // throw an error
	}
}
else
{
	die(addLogEntry('Failed to connect to MySQL server', 'error', '0004~0')); // throw an error
}

function escape_data($query)
{
	if (function_exists('mysqli_real_escape_string'))
	{
		global $dbc;
		$query = strip_tags($query); // strip out all html and php tags
		//preg_replace('%([^A-Za-z0-9\s])%', '', $String); // strip all charictors exept these
		$query = mysqli_real_escape_string($query, $dbc); // make it safe for a MySQL query
	}
	else
	{
		$query = strip_tags($query); // strip out all html and php tags
		//preg_replace('%([^A-Za-z0-9\s])%', '', $String); // strip all charictors exept these
		$query = mysqli_escape_string($query); // make it safe for a MySQL query
	}
	return $query;
}
/* I dont know what this is
{
	$query = "SELECT * FROM login_info WHERE primary_email = ?;";

	$stmt = mysqli_prepare($dbc, $query);

	mysqli_stmt_bind_param($stmt, "s", $email);

	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

	return mysqli_fetch_assoc($result);
}
*/
?>