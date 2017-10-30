<?php

require_once 'log.php';
require_once 'mysql.php';

function user_exists($email) // check if a user exists ('if (!login_info() == false)' can be used instead)
{
	global $dbc;

	$query = "SELECT primary_email FROM login_info WHERE primary_email = ?;";
	$stmt  = mysqli_prepare($dbc, $query);
	mysqli_stmt_bind_param($stmt, "s", $email);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$result = mysqli_fetch_assoc($result);

	if ($result['primary_email'] == $email) // if the request did not fail
	{
		return true;
	}
	else
	{
		return false;
	}
}

function verifyUser($email, $password) // verify if a users credentials
{
	if (login_info($email, $password) == false)
	{
		return false;
	}
	else
	{
		return true;
	}
}

function login_info($email, $password) // get the login info for a user (a password is required. in the future this might make things difficult)
{
	global $dbc;

	$query = "SELECT * FROM login_info WHERE primary_email = ?;";
	$stmt  = mysqli_prepare($dbc, $query);
	mysqli_stmt_bind_param($stmt, "s", $email);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$return = mysqli_fetch_assoc($result);

	validate($return, 'sqlAssoc');

	if ($extraOutput = mysqli_fetch_assoc($result)) // if extra values were received
	{
		echo addLogEntry('Extra values were received', 'error', '0004~1'); // throw an error
	}

	if (mysqli_error($dbc) != "") // if there is an error
	{
		die(addLogEntry("Error while executing MySQL query", "error", "0004")); // throw an error
	}

	if (verifyPassword($password, $return['password'])) // if the password and email match
	{
		return $return; // return the info
	}
	else // if not
	{
		return false; // don't
	}
}

function login_info_token($token) // same as login_info except using a token instead of an email and password
{
	global $dbc;

	$query = "SELECT * FROM login_info WHERE token = ?;";
	$stmt  = mysqli_prepare($dbc, $query);
	mysqli_stmt_bind_param($stmt, "s", $token);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$return = mysqli_fetch_assoc($result);

	return $return;
}

function user_info($id) // get the user info for a user from the user id (this is gotten from login_info() or login_info_token())
{
	global $dbc;

	$query = "SELECT * FROM user_info WHERE user_id = ?;";
	$stmt  = mysqli_prepare($dbc, $query);
	mysqli_stmt_bind_param($stmt, "s", $id);
	mysqli_stmt_execute($stmt);
	$result              = mysqli_stmt_get_result($stmt);
	$return              = mysqli_fetch_assoc($result);
	$return['roles_arr'] = explode(", ", $return['roles']);

	return $return;
}

function create_token($userId = -1) // create a user token
{
	$token = RandString(30); // generate the token with length 30

	if ($userId == -1) // if no user id is given
	{
		return $token; // return the token
	}
	else // if a user id is given
	{
		global $dbc;

		$query = "UPDATE login_info SET token = ? WHERE user_id = ?;";
		$stmt  = mysqli_prepare($dbc, $query);
		mysqli_stmt_bind_param($stmt, "si", $token, $userId);
		mysqli_stmt_execute($stmt); // apply it to the user

		if (!mysqli_errno($dbc) == 0) // if there's an error
		{
			addLogEntry('Error while applying token to user', 'error', '0004'); // throw an error (no description is needed)
		}

		return $token; // then return the token
	}
}

function RandString($length) // create a random string from the charset
{
	$charset      = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randomString = '';
	for ($i = 0; $i < $length; $i++)
	{
		$randomString = $randomString . $charset[rand(0, strlen($charset) - 1)];
	}
	return $randomString;
}

function createhash($givenPassword) // create a password hash
{
	return password_hash($givenPassword, PASSWORD_DEFAULT, ['cost' => 12]);
}

function verifyPassword($givenPassword, $hash) // check a password against a hash
{
	return password_verify($givenPassword, $hash);
}
?>
