<?php
echo '<form action="./" method="post"><input type="hidden" name="info[token]" value="' . $loginInfo['token'] . '">';

if ($selRole == 'main')
{
	echo "<h1>Main</h1>";
	foreach ($userInfo['roles_arr'] as $key => $value)
	{
		echo "<button type='submit' name='info[nextRole]' value='" . $value . "'>" . $config[$value]['main']['title'] . "</button>";
	}
	echo '</form>';
}
else
{
	echo '<h1>' . $config[$selRole]['main']['title'] . '</h1><input type="hidden" name="info[nextRole]" value="' . $selRole . '">';
	foreach ($config[$selRole]['main']['actions'] as $key => $value)
	{
		echo "<button type='submit' name='info[nextAct]' value='" . $key . "'>" . $config[$selRole]['main']['actions'][$key]['title'] . '</button>';
	}
}
?>