<?php

require '../../request_manager.php';

if (isset($post['submit']))
{
	$data_missing = array();

	if (empty($post['password']))
	{
		$data_missing[] = 'Password';
	}
	else
	{
		$password = trim($post['password']);
	}

	if (empty($post['email']))
	{
		$data_missing[] = 'email';
	}
	else
	{
		$email = trim($post['email']);
	}

	if (empty($data_missing))
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
			echo "MySQL retrned extra values";
		}

		if (!mysqli_error($dbc) == "")
		{
			die("Error while qxecuting MySQL query");
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
						<input type="hidden" name="token" value="' . $token . '">
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
		<input type="text" name="email" required>

		<p>Password</p>
		<input type="password" name="password" required>

		<br><br>
		<input type="submit" name="submit" value="Login">
	</form>
</body>
</html>