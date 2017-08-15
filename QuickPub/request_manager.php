<?php
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$post = array();
	if (isset($_POST['info']))
	{
		foreach ($_POST['info'] as $key => $value)
		{
			$post['info'][clean_string($key)] = clean_string($value);
		}
	}

	if (isset($_POST['user']))
	{
		foreach ($_POST['user'] as $key => $value)
		{
			$post['user'][clean_string($key)] = clean_string($value);
		}
	}

	foreach ($_POST as $key => $value)
	{
		if (is_string($_POST[$key]))
		{
			$post[clean_string($key)] = clean_string($value);
		}
	}
	if (isset($_FILES))
	{
		$files = $_FILES;
	}
}
else
{
	$post = false;
}

function clean_string($string)
{
	$string = trim($string);
	$string = stripslashes($string);
	$string = htmlspecialchars($string);
	return $string;
}
?>