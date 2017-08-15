<?php
require_once __DIR__ . '\log.php';
require_once __DIR__ . '\mysql.php';

function user_exists($email)
{
	global $dbc;

	$query = "SELECT primary_email FROM login_info WHERE primary_email = ?;";

	$stmt = mysqli_prepare($dbc, $query);

	if (!$stmt)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function verifyUser($email, $password)
{
	if (login_info($email, $password) == false)
	{
		return false;
	}
	else
	{

	}
}

function login_info($email, $password)
{
	global $dbc;

	$query = "SELECT * FROM login_info WHERE primary_email = ?;";

	$stmt = mysqli_prepare($dbc, $query);

	mysqli_stmt_bind_param($stmt, "s", $email);

	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

	$return = mysqli_fetch_assoc($result);


	if (verifyPassword($password, $return['password']))
	{
		return $return;
	}
	else
	{
		return false;
	}
}

function login_info_token($token)
{
	global $dbc;

	$query = "SELECT * FROM login_info WHERE token = ?;";

	$stmt = mysqli_prepare($dbc, $query);

	mysqli_stmt_bind_param($stmt, "s", $token);

	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

	$return = mysqli_fetch_assoc($result);

	return $return;
}

function user_info($id)
{
	global $dbc;

	$query = "SELECT * FROM user_info WHERE user_id = ?;";

	$stmt = mysqli_prepare($dbc, $query);

	mysqli_stmt_bind_param($stmt, "s", $id);

	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

	$return = mysqli_fetch_assoc($result);

	$return['roles_arr'] = explode(", ", $return['roles']);

	return $return;
}

function create_token($user_id = -1)
{
	$token = RandString(30);

	if ($user_id == -1)
	{
		return $token;
	}
	else
	{
		global $dbc;

		$query = "UPDATE login_info SET token = ? WHERE user_id = ?;";

		$stmt = mysqli_prepare($dbc, $query);

		mysqli_stmt_bind_param($stmt, "si", $token, $user_id);

		mysqli_stmt_execute($stmt);

		if (!mysqli_errno($dbc) == 0)
		{
			addLogEntry('', 'error', '0004');
		}

		return $token;
	}
}

function RandString($length)
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString = $randomString . $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

function createhash($given_password)
{
	return password_hash($given_password, PASSWORD_DEFAULT, ['cost' => 12]);
}

function verifyPassword($given_password, $hash)
{
	return password_verify($given_password, $hash);
}
?>