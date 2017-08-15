<?php

define('db_user', 'requests');
define('db_password', 'Daqawa12#$39655');
define('db_host', 'localhost');
define('db_name', 'users');

if ($dbc = mysqli_connect(db_host, db_user, db_password, db_name))
{
	if (!mysqli_select_db($dbc, db_name))
	{
		die('Failed to connect to database');
	}
}
else
{
	die('Failed to connect to database');
}

function escape_data($query)
{
	if (function_exists('mysqli_real_escape_string'))
	{
		global $dbc;
		$query = trim($query);
		$query = mysqli_real_escape_string($query, $dbc);
		$query = strip_tags($query);

		//preg_replace('%([^A-Za-z0-9\s])%', ' $0', $String);
	}
	else
	{
		$query = trim($query);
		$query = mysqli_escape_string($query);
		$query = strip_tags($query);

		//preg_replace('%([^A-Za-z0-9\s])%', ' $0', $String);
	}
	return $query;
}
/*
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