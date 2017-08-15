<!DOCTYPE html>
<html>
<head>
	<title>Add User</title>
</head>
<body>
	<?php
	require '../../request_manager.php';
	if (isset($post['submit']))
	{
		$data_missing = array();

		if (empty($post['prefix']))
		{
			$data_missing[] = 'Prefix';
		}
		else
		{
			$prefix = trim($post['prefix']);
		}

		if (empty($post['first_name']))
		{
			$data_missing[] = 'First Name';
		}
		else
		{
			$first_name = trim($post['first_name']);
		}

		if (!empty($post['middle_name']))
		{
			$middle_name = trim($post['middle_name']);
		}

		if (empty($post['last_name']))
		{
			$data_missing[] = 'Last Name';
		}
		else
		{
			$last_name = trim($post['last_name']);
		}

		if (empty($post['primary_email']))
		{
			$data_missing[] = 'Primary Email';
		}
		else
		{
			$primary_email = trim($post['primary_email']);
		}

		if (!empty($post['secondary_email']))
		{
			$secondary_email = trim($post['secondary_email']);
		}

		if (empty($post['password']))
		{
			$data_missing[] = 'Password';
		}
		else
		{
			$password = trim($post['password']);
		}

		if (empty($data_missing))
		{
			define('mysqli_dublicate_error_no', '1062');

			require '../../mysql.php';
			require '../../login_manager.php';
			require '../../config_manager.php';
			require_once '../../log.php';

			$hash = createHash($password);

			$query = "INSERT INTO login_info (primary_email, password, date_added, token) VALUES (?, ?, ?, ?)";

			$date = date("d/m/y H:i.s");

			$stmt = mysqli_prepare($dbc, $query);

			$token = create_token();

			mysqli_stmt_bind_param($stmt, "ssss", $primary_email, $hash, $date, $token);

			mysqli_stmt_execute($stmt);

			login_info_token($hash);

			$affected_rows = mysqli_stmt_affected_rows($stmt);

			mysqli_stmt_close($stmt);

			if ($affected_rows == 1)
			{

				$login_info = login_info($post['primary_email'], $post['password']);

				$query = "INSERT INTO user_info (first_name, middle_name, last_name, primary_email, secondary_email, prefix, date_added, roles, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";

				$stmt = mysqli_prepare($dbc, $query);

				mysqli_stmt_bind_param($stmt, "sssssssss", $first_name, $middle_name, $last_name, $primary_email, $secondary_email, $prefix, $date, $mainConfig['roles']['default'], $login_info['user_id']);

				mysqli_stmt_execute($stmt);

				$affected_rows = mysqli_stmt_affected_rows($stmt);

				if ($affected_rows == 1)
				{
					echo 'User sucessfully added. Please <a href="../login">Login</a>';

					mysqli_stmt_close($stmt);

					die();
				}
				else
				{
					if (user_exists($post['primary_email']))
					{
						echo "That email is already in use";
					}
					else
					{
						echo 'An error ocured while exicuting database query two';
						addLogEntry("Error while exicuting database query to user_info", "error", "0004");
						die();
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
					echo 'An error ocured while exicuting database query one';
					addLogEntry("Error while exicuting database query to login_info", "error", "0004~0");
					die();
				}
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

		<p>Scondary Email:
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