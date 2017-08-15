<?php

define('db_user', 'requests');
define('db_password', 'Daqawa12#$39655');
define('db_host', 'localhost');
define('db_name', 'users');

if ($dbc = mysqli_connect(db_host, db_user, db_password, db_name))
{
	if (!mysqli_select_db (db_name))
	{
		trigger_error('Failed to connect to database');
		exit();
	}
}
else
{
	trigger_error('Failed to connect to database');
	exit();
}

function escape_data($data)
{
	if (function_exists('mysql_real_escape_string'))
	{
		global $dbc;
		$data = mysql_real_escape_string(trim($data), $dbc);
		$data = strip_tags($data);
	}
	else
	{
		$data = mysql_escape_string($trim($data));
		$data = strip_tags($data);
	}
	return $data;
}
?>