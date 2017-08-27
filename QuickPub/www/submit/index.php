<?php
require '../../managers/flow.php';

dump($post);
dump($_FILES);

$loginInfo = login_info_token($post['info']['token']); // get the login
$userInfo = user_info($loginInfo['user_id']); // and user info for the user

$flows[$post['user']['title']] = addFlow($post['user']['title'], $loginInfo['user_id'], $post['info']['nextRole']); // add a flow with the given name

foreach ($post['user'] as $key => $value) // for all of the user submitted values
{
	echo $key . ': ' . dump($value, false, false); // echo value and key
	if ($key != 'title') // if it's not the title
	{
		$entry = addFlowEntry($flows[$post['user']['title']]['flow_id'], ['value' => $value], $loginInfo['user_id'], $post['info']['nextRole']); // add the value as a flow entry

		if ($entry != false) // if it worked
		{
			dump($entry); // dump it
		}
		else // if not
		{
			echo "failed. Continuing anyway<br>"; // tell the user
		}
	}
}

foreach ($files as $key => $value) // for each of the files
{
	$entry = addFlowEntry($flows[$post['user']['title']]['flow_id'], ['file' => $value], $loginInfo['user_id'], $post['info']['nextRole']); // add the file as a flow entry

	if ($entry != false) // if it worked
	{
		dump($entry); // dump it
	}
	else // if not
	{
		echo "failed. Continuing anyway<br>"; // tell the user
	}
}

echo "done";
?>
