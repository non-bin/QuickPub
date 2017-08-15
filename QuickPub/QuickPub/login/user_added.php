<!DOCTYPE html>
<html>
<head>
	<title>Add User</title>
</head>
<body>
	<?php
	if (isset($_POST['submit']))
	{
		$data_missing = array();

		if (empty($_POST['prefix']))
		{
			$data_missing[] = 'Prefix';
		}
		else
		{
			$prefix = trim($_POST['prefix']);
		}

		if (empty($_POST['first_name']))
		{
			$data_missing[] = 'First Name';
		}
		else
		{
			$first_name = trim($_POST['first_name']);
		}

		if (!empty($_POST['middle_name']))
		{
			$middle_name = trim($_POST['middle_name']);
		}

		if (empty($_POST['last_name']))
		{
			$data_missing[] = 'Last Name';
		}
		else
		{
			$last_name = trim($_POST['last_name']);
		}

		if (empty($_POST['primary_email']))
		{
			$data_missing[] = 'Primary Email';
		}
		else
		{
			$primary_email = trim($_POST['primary_email']);
		}

		if (!empty($_POST['secondary_email']))
		{
			$secondary_email = trim($_POST['secondary_email']);
		}

		if (empty($_POST['password']))
		{
			$data_missing[] = 'Password';
		}
		else
		{
			$password = trim($_POST['password']);
		}

		if (empty($data_missing))
		{
			require_once '../../mysql_connect.php';
			require_once '../../password_manager.php';

			$hash = createHash($password);

			$query = "INSERT INTO login_info (first_name, middle_name, last_name, primary_email, secondary_email, prefix, password) VALUES (?, ?, ?, ?, ?, ?, ?)";

			$stmt = mysqli_prepare($dbc, $query);

			mysqli_stmt_bind_param($stmt, "sssssss", $first_name, $middle_name, $last_name, $primary_email, $secondary_email, $prefix, $hash);

			mysqli_stmt_execute($stmt);

			$affected_rows = mysqli_stmt_affected_rows($stmt);

			if ($affected_rows == 1)
			{
				echo "User sucessfully added";

				mysqli_stmt_close($stmt);

				mysqli_close($dbc);
			}
			else
			{
				echo 'An error ocured while exicuting database query:<br>';

				var_dump(var_dump($dbc));

				mysqli_stmt_close($stmt);

				mysqli_close($dbc);
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

	<a href="../login">Login</a>
	<form action="user_added.php" method="post">
		<b>Create Account</b>

		<p>First Name:<input type="text" name="first_name">
		</p>

		<p>Middle Name:<input type="text" name="middle_name">
		</p>

		<p>Last Name:<input type="text" name="last_name">
		</p>

		<p>Primary Email:<input type="text" name="primary_email">
		</p>

		<p>Scondary Email:<input type="text" name="secondary_email">
		</p>

		<p>Prefix:
			<input type="radio" name="prefix" value="Dr.">Dr
			<input type="radio" name="prefix" value="Mr.">Mr
			<input type="radio" name="prefix" value="Mrs.">Mrs
			<input type="radio" name="prefix" value="Ms.">Ms
		</p>

		<p>Password:
			<input type="password" name="password">
		</p>

		<input type="submit" name="submit" value="join">
	</form>
</body>
</html>