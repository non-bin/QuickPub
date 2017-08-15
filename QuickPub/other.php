<?php
function dump($var, $name = '')
{
	$out = var_export($var, true);
	$out = preg_replace('%\n%', '<br>', $out);
	$out = preg_replace('%\s%', '&nbsp;&nbsp;', $out);
	while (preg_match('%\\\\\\\\%', $out))
	{
		$out = preg_replace('%\\\\\\\\%', '/', $out);
	}

	if ($name != '')
	{
		echo '<b>' . $name . ':</b><br>' . $out . '<br>';
	}
	else
	{
		echo $out . '<br>';
	}
}
?>