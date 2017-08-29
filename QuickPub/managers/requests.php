<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") // if the page was requested with POST
{
	$post = array(); // create the post variable

	if (isset($_POST['info'])) // if there is an info section in the post request
	{
		foreach ($_POST['info'] as $key => $value) // clean all of the data and add it to the post variable
		{
			$post['info'][clean_string($key)] = clean_string($value);
		}
	}

	if (isset($_POST['user'])) // if there is a user section in the post request
	{
		foreach ($_POST['user'] as $key => $value) // clean all of the data and add it to the post variable
		{
			$post['user'][clean_string($key)] = clean_string($value);
		}
	}

	foreach ($_POST as $key => $value) // for everything not in a subcategory
	{
		if (is_string($_POST[$key])) // clean all of the data and add it to the post variable
		{
			$post[clean_string($key)] = clean_string($value);
		}
	}

	if (isset($_FILES)) // if there are files
	{
		$files = $_FILES; // add them to the files variable
	}
	else // if not
	{
		$files = false; // set it to false
	}
}
else // if not
{
	$post = false; // set post to false
}

function clean_string($string)
{
	/* for the moment I have disabled these, later I will put in more security measures
	preg_replace('%([^A-Za-z0-9\s])%', '', $String); // strip all characters except these
	$string = trim($string);
	$string = stripslashes($string);
	$string = htmlspecialchars($string);
	 */
	return $string;
}
?>
