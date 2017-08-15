<?php
require_once 'mysql_connect.php';

function user_info($hash)
{
	$query = 'SELECT * FROM users WHERE hash = "' . $hash . '"';

	$responce = mysqli_query($dbc, $query);

	var_dump($responce);

	$responce = mysqli_fetch_array($responce);

	return $responce;
}
?>