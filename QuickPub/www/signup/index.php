<!DOCTYPE html>
<html>
<head>
	<title>Add User</title>
</head>
<body>
	<?php
	require '../../managers/requests.php';
	if ($post) // if post was used
	{
		$data_missing = array(); // check if any data is missing

		if (empty($post['prefix']))
		{
			$data_missing[] = 'Prefix';
		}
		else
		{
			$prefix = $post['prefix'];
		}

		if (empty($post['first_name']))
		{
			$data_missing[] = 'First Name';
		}
		else
		{
			$first_name = $post['first_name'];
		}

		if (!empty($post['middle_name']))
		{
			$middle_name = $post['middle_name'];
		}

		if (empty($post['last_name']))
		{
			$data_missing[] = 'Last Name';
		}
		else
		{
			$last_name = $post['last_name'];
		}

		if (empty($post['primary_email']))
		{
			$data_missing[] = 'Primary Email';
		}
		else
		{
			$primary_email = $post['primary_email'];
		}

		if (!empty($post['secondary_email']))
		{
			$secondary_email = $post['secondary_email'];
		}

		if (empty($post['password']))
		{
			$data_missing[] = 'Password';
		}
		else
		{
			$password = $post['password'];
		}

		if (empty($data_missing)) // if nothing was missing
		{

			require_once '../../managers/mysql.php';
			require_once '../../managers/login.php';
			require_once '../../managers/config.php';
			require_once '../../managers/log.php';

			$hash  = createHash($password); // hash the given password
			$query = "INSERT INTO login_info (primary_email, password, date_added, token) VALUES (?, ?, ?, ?)";
			$date  = date("d/m/y H:i.s"); // get the date and time
			$stmt  = mysqli_prepare($dbc, $query);
			$token = create_token(); // create a token
			mysqli_stmt_bind_param($stmt, "ssss", $primary_email, $hash, $date, $token);
			mysqli_stmt_execute($stmt); // create the account
			login_info_token($token); // get the login info from the token
			$affected_rows = mysqli_stmt_affected_rows($stmt);
			mysqli_stmt_close($stmt);

			if ($affected_rows == 1 & user_exists($primary_email)) // if the account was successfully created
			{
				$login_info = login_info($post['primary_email'], $post['password']); // get the login info
				$query      = "INSERT INTO user_info (first_name, middle_name, last_name, primary_email, secondary_email, prefix, date_added, roles, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
				$stmt       = mysqli_prepare($dbc, $query);
				mysqli_stmt_bind_param($stmt, "sssssssss", $first_name, $middle_name, $last_name, $primary_email, $secondary_email, $prefix, $date, $mainConfig['roles']['default'], $login_info['user_id']);
				mysqli_stmt_execute($stmt); // create the user info
				$affected_rows = mysqli_stmt_affected_rows($stmt);

				if ($affected_rows == 1) // if the user info was added
				{
					echo 'User successfully added. Please <a href="../login">Login</a>'; // get the user to log in

					mysqli_stmt_close($stmt);

					die();
				}
				else // if not
				{
					if (user_exists($post['primary_email']))
					{
						echo "That email is already in use";
					}
					else
					{
						addLogEntry("Error while executing database query to user_info", "error", "0004~2");
					}
				}
			}
			else
			{
				if (user_exists($post['primary_email']))
				{
					echo "That email is already in use";
				}
				else
				{
					addLogEntry("Error while executing database query to login_info", "error", "0004~2");
				}
			}
		}
		else // if data wasn't submitted
		{
			echo "The flowing data was not submitted: ";

			foreach ($data_missing as $missing)
			{
				echo $missing . " ";
			}
		}
	}
	?>
	<br>
	<a href="../login">Login</a>
	<form action="index.php" method="post">
		<b>Create Account</b>

		<p>First Name:
			<input type="text" name="first_name" required>
		</p>

		<p>Middle Name:
			<input type="text" name="middle_name">
		</p>

		<p>Last Name:
			<input type="text" name="last_name" required>
		</p>

		<p>Primary Email:
			<input type="text" name="primary_email" required>
		</p>

		<p>Secondary Email:
			<input type="text" name="secondary_email">
		</p>

		<p>Prefix:<br>
			<input type="radio" name="prefix" value="Dr." required>Dr
			<input type="radio" name="prefix" value="Mr." required>Mr
			<input type="radio" name="prefix" value="Mrs." required>Mrs
			<input type="radio" name="prefix" value="Ms." required>Ms
		</p>

		<p>Password:
			<input type="password" name="password" required>
		</p>

		<input type="submit" name="submit" value="join">
	</form>
</body>
</html>
