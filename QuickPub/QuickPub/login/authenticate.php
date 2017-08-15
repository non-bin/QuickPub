<!DOCTYPE html>
<html>
<head>
	<title>Authenticate</title>
	<?php
	if (isset($_POST['submit']))
	{
		$data_missing = array();

		if (empty($_POST['password']))
		{
			$data_missing[] = 'Password';
		}
		else
		{
			$password = trim($_POST['password']);
		}

		if (empty($_POST['email']))
		{
			$data_missing[] = 'email';
		}
		else
		{
			$email = trim($_POST['email']);
		}

		if (empty($data_missing))
		{
			require_once '../../mysql_connect.php';
			require_once '../../password_manager.php';

			$query = "SELECT * FROM login_info where primary_email = '" . $email . "';";

			$result = mysqli_query($dbc, $query);

			$output = mysqli_fetch_assoc($result);

			if ($extraOutput = mysqli_fetch_assoc($result))
			{
				echo "MySQL retrned extra values:<br>";
				echo $output . "<br>";
				echo $extraOutput . "<br>";
				while ($extraOutput = mysqli_fetch_assoc($result))
				{
					echo $extraOutput . "<br>";
				}
			}

			if (!mysqli_error($dbc) == "")
			{
				die("Error while qxecuting MySQL query:<br>" . var_dump(mysqli_error($dbc)));
			}

			if (NULL == $output)
			{
				die("The email or password was incorect");
			}

			if (verifyPassword($password, $output['password']))
			{
				echo '<meta http-equiv="refresh" content="1;url=../author/submit"><script type="text/javascript">window.location.href = "../author/submit"</script>';
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
</head>
</html>