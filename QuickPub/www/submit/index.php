<?php
require '../../flow_manager.php';

$loginInfo = login_info_token($post['info']['token']);
$userInfo = user_info($loginInfo['user_id']);

$flows[$post['user']['title']] = addFlow($post['user']['title'], $loginInfo['user_id'], $post['info']['nextRole']);
dump($post);


foreach ($post['user'] as $key => $value)
{
	echo $key . ': ' . dump($value, true);
	if ($key != 'title')
	{
		dump(addFlowEntry($flows[$post['user']['title']]['flow_id'], ['value' => $value], $loginInfo['user_id'], $post['info']['nextRole']));
	}
}

foreach ($files as $key => $value)
{
	dump(addFlowEntry($flows[$post['user']['title']]['flow_id'], ['file' => $value], $loginInfo['user_id'], $post['info']['nextRole']));
}
?>