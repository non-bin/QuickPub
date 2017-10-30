<?php

require '../../managers/log.php';
require '../../managers/wordpressCodeX.php';
require '../../managers/dataValidation.php';
require_once '../../managers/requests.php';

if ($post & isset($post['submit'])) // if post was used and a form was submitted (someone has logged in)
{
	$data_missing = array(); // make an array for the missing data
	$data_unsafe  = array(); // make an array for the unsafe data

	if (empty($post['password'])) // if the password is missing
	{
		$data_missing[] = 'password'; // add password to the array
	}
	else
	{
		if (!$post['password'] == validate($post['password'], 'password')) // check if the password safe (mysql.php)
		{
			$data_unsafe[] = 'password'; // add password to the list
		}
	}

	if (empty($post['email'])) // if the email is missing
	{
		$data_missing[] = 'email'; // add email to the list
	}
	else
	{
		if (!$post['email'] == validate($post['email'], 'email')) // check if the email safe (mysql.php)
		{
			$data_unsafe[] = 'email'; // add email to the list
		}
	}

	if (empty($data_missing) & empty($data_unsafe)) // if all data was submitted and is safe
	{
		require_once '../../managers/mysql.php'; // connect to the MySQL database
		require_once '../../managers/login.php';

		$loginInfo = login_info($post['email'], $post['password'])['user_id'];

		if (verifyUser($post['email'], $post['password'])) // verify the credentials
		{
			$token = create_token($loginInfo); // give the user a token

			die('
				<html>
				<body>
					<form action="../main/index.php" method="post">
						<input type="hidden" name="info[token]" value="' . $token . '">
						<div id="manual" style="display: none;">
							if your browser dose not support automatic redirects, click <input type="submit" value="here">
						</div>
				</form>
				<script type="text/javascript">document.forms[0].submit();</script>
				<script>setTimeout(function() { document.getElementById("manual").style = "" }, 3000);</script>
			</body>
			</html>
			');
		}
		else // if the credentials are incorrect
		{
			echo "The email or password was incorrect"; // tell the user
		}
	}
	else // if any data was unsubstituted or unsafe
	{
		if (!empty($data_missing))
		{
			echo "The following data was not submitted: ";

			foreach ($data_missing as $missing)
			{
				echo $missing . " ";
			}
			echo "<br>";
		}

		if (!empty($data_unsafe))
		{
			echo "The following fields contain illegal characters: ";

			foreach ($data_unsafe as $unsafe)
			{
				echo $unsafe . " ";
			}
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
