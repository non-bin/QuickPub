<?php

// some pretty good data validation stuff here:
// https://codex.wordpress.org/Data_Validation

function validate($variable, $type, $fallback = false) // fallback is returned if the value that would be returned is empty
{
	if ($type == 'default') // default string cleaner
	{
		$return = $variable;
	}
	elseif ($type == 'sqlStr') // escape a string for use in a sql query NOTE: DO NOT PASS A FULL SQL QUERY!
	{
		$return = esc_sql($variable);
	}
	elseif ($type == 'htmlStr') // escape a string for use in html
	{
		$return = htmlspecialchars($variable);
	}
	elseif ($type == 'json') // there's nothing for json validation but I've put in the groundwork for it anyway
	{
		$return = $variable;
	}
	elseif ($type == 'sqlAssoc') // there's nothing for sql assoc validation but I've put in the groundwork for it anyway
	{
		$return = $variable;
	}
	elseif ($type == 'email') // returns a sanitized email, or false if no email was found
	{
		$return = sanitize_email($variable);

		if (is_email($return))
		{
			$return = $variable;
		}
		else
		{
			return false;
		}
	}
	elseif ($type == 'password') // dose nothing :)
	{
		$return = $variable;
	}
	elseif ($type == 'request') // used for GET or POST variables there's nothing here but I've put in the groundwork for it anyway
	{
		if (isset($_POST['info'])) // if there is an info section in the post request
		{
			foreach ($_POST['info'] as $key => $value) // clean all of the data and add it to the post variable
			{
				$post['info'][$key] = $value;
			}
		}

		if (isset($_POST['user'])) // if there is a user section in the post request
		{
			foreach ($_POST['user'] as $key => $value) // clean all of the data and add it to the post variable
			{
				$post['user'][$key] = $value;
			}
		}

		foreach ($_POST as $key => $value) // for everything not in a subcategory
		{
			if (is_string($_POST[$key])) // clean all of the data and add it to the post variable
			{
				$post[$key] = $value;
			}
		}
	}
	elseif ($type == 'placeholder') // placeholder
	{
		$return = $variable;
	}

	if ($return == '')
	{
		return $fallback;
	}

	return $return;
}

?>
