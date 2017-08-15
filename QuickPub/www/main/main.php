<?php
echo '<form action="./" method="post"><input type="hidden" name="token" value="' . $loginInfo['token'] . '">';

if ($selRole == 'main')
{
	foreach ($userInfo['roles_arr'] as $key => $value)
	{
		echo "<input type='submit' name='nextRole' value='" . $value . "'>";
	}
	echo '</form>';
}
else
{
	echo '<input type="hidden" name="nextRole" value="' . $selRole . '">';
	foreach ($config[$selRole]['main']['actions'] as $key => $value)
	{
		echo "<input type='submit' name='nextAct' value='" . $key . "'>";
	}
}
?>