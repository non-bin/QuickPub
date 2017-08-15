<?php
function dump($var, $print = true)
{
	$out = var_export($var, true);
	$out = preg_replace('%\n%', '<br>', $out);
	$out = preg_replace('%\s\s%', ':&nbsp;&nbsp;&nbsp;', $out);
	$out = stripslashes($out);
	$out = $out . '<br>';

	if ($print)
	{
		echo $out;
		return $out;
	}
	else
	{
		return $out;
	}
}
?>