<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>
	<a href="add_user.php">Sign Up</a>
	<h3>Login</h3>
	<form action="authenticate.php" method="post" enctype="multipart/form-data">
	
		<p>Email</p>
		<input type="text" name="email">

		<p>Password</p>
		<input type="password" name="password">

		<br><br>
		<input type="submit" name="submit" value"Login">
	</form>
</body>
</html>