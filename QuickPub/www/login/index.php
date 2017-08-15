<?php

require '../../log.php';
require '../../request_manager.php';

if (isset($post['submit'])) // if a form was submited (someone has loged in)
{
	$data_missing = array(); // make an array for the missing data
	$data_safe = array(); // make an array for the unsafe data

	if (empty($post['password'])) // if the password is missing
	{
		$data_missing[] = 'password'; // add password to the array
	}
	else
	{
		if ($post['password'] == clean_string($post['password'])) // check if the password safe (mysql.php)
		{
			$data_safe[] = 'password'; // add password to the list
		}
	}

	if (empty($post['email'])) // if the email is missing
	{
		$data_missing[] = 'email'; // add email to the list
	}
	else
	{
		if ($post['email'] == clean_string($post['email'])) // check if the email safe (mysql.php)
		{
			$data_safe[] = 'email'; // add email to the list
		}
	}

	if (empty($data_missing) & empty($data_safe))
	{
		require '../../mysql.php';
		require '../../login_manager.php';

		$query = "SELECT * FROM login_info where primary_email = ?;";

		$stmt = mysqli_prepare($dbc, $query);

		mysqli_stmt_bind_param($stmt, "s", $email);

		mysqli_stmt_execute($stmt);

		$result = mysqli_stmt_get_result($stmt);

		$output = mysqli_fetch_assoc($result);

		if ($extraOutput = mysqli_fetch_assoc($result))
		{
			echo "<b>Warning:</b> MySQL retrned extra values<br>";
		}

		if (!mysqli_error($dbc) == "")
		{
			die(addLogEntry("Error while excuting MySQL query", "error", "0004"));
		}

		if ($output == null)
		{
			die("The email or password was incorect");
		}

		if (verifyPassword($password, $output['password']))
		{
			$token = create_token(login_info($email, $password)['user_id']);

			die('
				<html>
				<body>
					<form action="../main/index.php" method="post">
						<input type="hidden" name="info[token]" value="' . $token . '">
						<div id="manual" style="display: none;">
							if your browser dose not suport automatic redirects, click <input type="submit" value="here">
						</div>
				</form>
				<script type="text/javascript">document.forms[0].submit();</script>
				<script>setTimeout(function() { document.getElementById("manual").style = "" }, 3000);</script>
			</body>
			</html>
			');
		}
		else
		{
			echo "The email or password was incorect";
		}
	}
	else
	{
		echo "The folowing data was not submited: ";

		foreach ($data_missing as $missing)
		{
			echo $missing . " ";
		}
	}

}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>
	<br>
	<a href="../signup">Sign Up</a>
	<h3>Login</h3>
	<form action="./" method="post">

		<p>Email</p>
		<input type="text" name="email">

		<p>Password</p>
		<input type="password" name="password">

		<br><br>
		<input type="submit" name="submit" value="Login">
	</form>
</body>
</html>