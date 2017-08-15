<?php
function dump($var, $ret = false)
{
	$out = var_export($var, true);
	$out = preg_replace('%\n%', '<br>', $out);
	$out = preg_replace('%\s\s%', ':&nbsp;&nbsp;&nbsp;', $out);
	$out = stripslashes($out);
	$out = $out . '<br>';

	if ($ret)
	{
		return $out;
	}
	else
	{
		echo $out;
	}
}
?>