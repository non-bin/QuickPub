<?php
// set database constants
define('db_user', 'requests');
define('db_password', 'password');
define('db_host', 'localhost');
define('db_name', 'quickpub');

if ($dbc = mysqli_connect(db_host, db_user, db_password, db_name)) // if connect to the database is successful
{
	if (!mysqli_select_db($dbc, db_name)) // if database doesn't exist
	{
		die(addLogEntry('No database with that name', 'error', '0004~0')); // throw an error
	}
}
else
{
	die(addLogEntry('Failed to connect to MySQL server', 'error', '0004~0')); // throw an error
}
?>
