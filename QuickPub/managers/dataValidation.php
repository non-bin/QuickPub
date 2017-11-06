<?php

// some pretty good data validation stuff here:
// https://codex.wordpress.org/Data_Validation

function validate($variable, $type) // fallback is returned if the value that would be returned is empty
{
	if ($type == 'placeholder')
	{
		$return = true
	}

	return $return;
}

function clean($variable, $type, $fallback) // fallback is returned if the value that would be returned is empty
{
	$return = $variable

	return $return;
}

?>
