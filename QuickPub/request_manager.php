<?php
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$post = array();
	foreach ($_POST as $key => $value)
	{
		$post[clean_string($key)] = clean_string($value);
	}
	var_export($post, true);
}
else
{
}

function clean_string($string)
{
	$string = trim($string);
	$string = stripslashes($string);
	$string = htmlspecialchars($string);
	return $string;
}
?>