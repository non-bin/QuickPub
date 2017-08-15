<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST')
{
	die('
		<html>
		<body>
			<form action="http://' . $_SERVER['HTTP_HOST'] . '" method="post">
				<div id="manual" style="display: none;">
					if your browser dose not suport automatic redirects, click <input type="submit" value="here">
				</div>
		</form>
		<script type="text/javascript">document.forms[0].submit();</script>
		<script>setTimeout(function() { document.getElementById("manual").style = "" }, 3000);</script>
	</body>
	</html>
	');
}

require '../../log.php';
require '../../request_manager.php';
require '../../login_manager.php';
require '../../config_manager.php';
require_once '../../other.php';

$token = $post['token'];

if (isset($post['nextRole']))
{
	$selRole = $post['nextRole'];
}
else
{
	$selRole = "main";
}

if (isset($post['nextAct']))
{
	$selAction = $post['nextAct'];
}
else
{
	$selAction = "main";
}

$loginInfo = login_info_token($token);
$userInfo = user_info($loginInfo['user_id']);

foreach ($userInfo['roles_arr'] as $role)
{
	$config[$role]['main'] = getRoleConfig($role);

	foreach ($config[$role]['main']['actions'] as $action)
	{
		$config[$role][$action['name']] = getConfig("roles/" . $config[$role]['main']['name'] . "/" . $action['name'] . ".json");
	}
}

if (isset($config[$selRole][$selAction]['title']))
{
	$title = $config[$selRole][$selAction]['title'];
}
else
{
	$title = $mainConfig['main']['title'];
}

echo $selRole . '<br>';
echo $selAction . '<br>';

if ($selRole == "main")
{
	require 'main.php';
}
elseif ($selAction == "main")
{
	require 'main.php';
}
else
{
	require 'other.php';
}
?>