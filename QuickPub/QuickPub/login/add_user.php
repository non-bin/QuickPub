<!DOCTYPE html>
<html>
<head>
	<title>Add User</title>
</head>
<body>
	<a href="../login">Login</a>
	<form action="user_added.php" method="post">
		<b>Create Account</b>

		<p>First Name:
			<input type="text" name="first_name">
		</p>

		<p>Middle Name:
			<input type="text" name="middle_name">
		</p>

		<p>Last Name:
			<input type="text" name="last_name">
		</p>

		<p>Primary Email:
			<input type="text" name="primary_email">
		</p>

		<p>Scondary Email:
			<input type="text" name="secondary_email">
		</p>

		<p>Prefix:<br>
			<input type="radio" name="prefix" value="Dr.">Dr
		</p>
		<input type="radio" name="prefix" value="Mr.">Mr
		<input type="radio" name="prefix" value="Mrs.">Mrs
		<input type="radio" name="prefix" value="Ms.">Ms


		<p>Password:
			<input type="password" name="password">
		</p>

		<input type="submit" name="submit" value="join">
	</form>

</body>
</html>