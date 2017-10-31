<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') // if the page was not requested with post
{
	die('
		<html>
		<body>
			<form action="../index.php" method="post">
				<div id="manual" style="display: none;">
					if your browser dose not support automatic redirects, click <input type="submit" value="here">
				</div>
		</form>
		<script type="text/javascript">document.forms[0].submit();</script>
		<script>setTimeout(function() { document.getElementById("manual").style = "" }, 3000);</script>
	</body>
	</html>
	'); // send the user to www/index.php (default redirect page)
}

require '../../managers/log.php';
require '../../managers/wordpressCodeX.php';
require '../../managers/dataValidation.php';
require_once '../../managers/requests.php';
require_once '../../managers/login.php';
require_once '../../managers/config.php';

if (isset($post['info']['nextPage'])) // if a 'next page' value was sent with the post request
{
	$nextPage = intval($post['info']['nextPage']); // save the next page to a variable
}
else // if not
{
	$nextPage = null; // set it to null (not sure if this is right)
}

if ($nextPage == -1) // if next page is -1 (come back to this later-)
{
	require '../submit/index.php';
}
else // if not
{
	$token = $post['info']['token']; // save the token

	if (isset($post['info']['nextRole'])) // if a role page was requested
	{
		$selRole = $post['info']['nextRole']; // set the selected role to it
	}
	else // if not
	{
		$selRole = "main"; // set the selected role to the role selection page
	}

	if (isset($post['info']['nextAct'])) // if a next action was sent
	{
		$selAction = $post['info']['nextAct']; // set the selected action to it
	}
	else // if not
	{
		$selAction = "main"; // set the selected action to the main page
	}

	$loginInfo = login_info_token($token); // get the login info for the user from the token
	$userInfo  = user_info($loginInfo['user_id']); // get the user info from the user id from the login info

	foreach ($userInfo['roles_arr'] as $role) // for each of the roles the user has
	{
		$config[$role]['main'] = getRoleConfig($role); // get the config for it and save it to the config variable

		if ($config[$role]['main'] != false)
		{
			foreach ($config[$role]['main']['actions'] as $action) // for each of the actions the role can perform
			{
				$config[$role][$action['name']] = getConfig("roles/" . $config[$role]['main']['name'] . "/" . $action['name'] . ".json"); // get the config for it and save it to the config variable
			}
		}
		else
		{
			// an invalid role was requested
		}
	}

	if (isset($config[$selRole][$selAction]['title'])) // if the requested page and action have a title
	{
		$title = $config[$selRole][$selAction]['title']; // save it
	}
	else // if not
	{
		$title = $mainConfig['main']['title']; // use the default one
	}

	if ($selRole == "main" || $selAction == "main") // if a main page was requested (either the root or main page for a specified role)
	{
		echo '<form action="./" method="post"><input type="hidden" name="info[token]" value="' . $loginInfo['token'] . '">'; // begin a form with a hidden input containing the token

		if ($selRole == 'main') // if the root page was requested
		{
			echo "<h1>" . $mainConfig['main']['title'] . "</h1>"; // put in the title

			foreach ($userInfo['roles_arr'] as $key => $value) // for each of the users roles
			{
				if ($config[$value]['main'] != false)
				{
					echo "<button type='submit' name='info[nextRole]' value='" . $value . "'>" . $config[$value]['main']['title'] . "</button>"; // add a button to select it
				}
				else
				{
					// the user has an invalid role
				}
			}
			echo '</form>'; // close the form
		}
		else // if a role was specified (the main page for the specified role was requested)
		{
			echo '<h1>' . $config[$selRole]['main']['title'] . '</h1><input type="hidden" name="info[nextRole]" value="' . $selRole . '">'; // print the title and add a hidden input containing the selected role

			foreach ($config[$selRole]['main']['actions'] as $key => $value) // for each of the actions the selected role can perform
			{
				echo "<button type='submit' name='info[nextAct]' value='" . $key . "'>" . $config[$selRole]['main']['actions'][$key]['title'] . '</button>'; // add a button to select the next action
			}
		}
	}
	else // if a role and action was specified, load the common page
	{
		$extraHTML = ""; // create a variable for functions to put form elements into

		if (isset($post['info']['nextPage'])) // if a page was requested
		{
			$pageNo = intval($post['info']['nextPage']); // save the page number
		}
		else // if not
		{
			$pageNo = 0; // set the page number to 0
		}

		if ($pageNo < count($config[$selRole][$selAction]['pages']) - 1) // if the user is before the second last page of an action
		{
			$action    = "./index.php"; // set the action to this page
			$nextPage  = $pageNo + 1; // set the next page to be requested
			$extraHTML = '<input type="hidden" name="info[nextPage]" value="' . $nextPage . '">'; // add the next page value to the form
		}
		else // if the user is on the last page
		{
			if ($pageNo < count($config[$selRole][$selAction]['pages'])) // if the user is on the second last page
			{
				$action    = "./index.php"; // set the action to this page
				$extraHTML = '<input type="hidden" name="info[nextPage]" value="-1">'; // add the next page value (-1 (last page)) to the form
			}
			else // if the user is on the last page
			{
				$action = "../submit/index.php"; // set the action to the submit page
			}
		}

		echo '<!DOCTYPE html><html><head></head><body onload="checkWordCount()"><form action="' . $action . '" method="post" enctype="multipart/form-data"><input type="hidden" name="info[token]" value="' . $token . '">' . $extraHTML . '<h1>' . $config[$selRole][$selAction]['title'] . '</h1><h2>' . $config[$selRole][$selAction]['pages'][$pageNo]['name'] . "</h2>"; // create the form and set the action, add the token, insert the extra html, insert the action title, then insert page name

		for ($j = 0; $j < count($config[$selRole][$selAction]['pages'][$pageNo]['elements']); $j++) // repeat for each element in the page
		{
			$currentElement = $config[$selRole][$selAction]['pages'][$pageNo]['elements'][$j]; // save the configuration for the current element

			if ($currentElement['type'] == "radio") // if the current element is a radio button
			{
				echo '<h4>' . $currentElement['title'] . '</h4>'; // insert the title
				for ($k = 0; $k < count($currentElement['options']); $k++) // repeat for each option
				{
					echo '<input type="radio" name="user[' . $currentElement['name'] . ']'; // create an option and set the name
					echo '" value="' . $currentElement['options'][$k]['value']; // set the value
					echo '"> ' . $currentElement['options'][$k]['name'] . "<br>"; // set the display name
				}
			}
			elseif ($currentElement['type'] == "plainHTML") // if the current element is just plain HTML
			{
				echo $currentElement['value']; // print it
			}
			elseif ($currentElement['type'] == "hidden") // if the current element is a hidden element
			{
				echo '<input '; // start the input
				foreach ($currentElement as $key => $value) // for each attribute
				{
					if ($key == 'name') // if it is the name
					{
						echo 'name="user[' . $value . ']" '; // set the name attribute, but nest it under 'user'
					}
					else // if not
					{
						echo $key . '="' . $value . '" '; // add the attribute
					}
				}
				echo ">"; // close the input
			}
			elseif ($currentElement['type'] == "file") // if the current element is a file input
			{
				echo '<h4>' . $currentElement['title'] . '</h4>'; // print the title
				echo '<input '; // start the input
				foreach ($currentElement as $key => $value) // for each of the attributes
				{
					echo $key . '="' . $value . '" '; // add it
				}
				echo "> <br>"; // close the input
			}
			else // everything else
			{
				echo '<h4>' . $currentElement['title'] . '</h4>'; // print the title
				echo '<input '; // start the input
				foreach ($currentElement as $key => $value) // for each of the attributes
				{
					if ($key == 'name') // if it's the name
					{
						echo 'name="user[' . $value . ']" '; // set the name attribute, but nest it under 'user'
					}
					else // if not
					{
						echo $key . '="' . $value . '" '; // add is
					}
				}
				echo "> <br>"; // close input
			}
		}
		echo '<input type="hidden" name="info[nextRole]" value="' . $selRole . '"><input type="hidden" name="info[nextAct]" value="' . $selAction . '"></form></body></html>'; // add the selected role and action
	}
}
?>
