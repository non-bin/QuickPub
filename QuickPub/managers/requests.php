<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") // if the page was requested with POST
{
	$post = []; // create the post variable

	if (isset($_POST['info'])) // if there is an info section in the post request
	{
		foreach ($_POST['info'] as $key => $value) // clean all of the data and add it to the post variable
		{
			$post['info'][validate($key, 'default')] = validate($value, 'default');
		}
	}

	if (isset($_POST['user'])) // if there is a user section in the post request
	{
		foreach ($_POST['user'] as $key => $value) // clean all of the data and add it to the post variable
		{
			$post['user'][validate($key, 'default')] = validate($value, 'default');
		}
	}

	foreach ($_POST as $key => $value) // for everything not in a subcategory
	{
		if (is_string($_POST[$key])) // clean all of the data and add it to the post variable
		{
			$post[validate($key, 'default')] = validate($value, 'default');
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

?>
