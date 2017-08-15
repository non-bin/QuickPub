<?php
require '../../form_manager.php';

$extraHTML = "";

if (isset($post['info']['nextPage']))
{
	$pageNo = intval($post['info']['nextPage']);
}
else
{
	$pageNo = 0;
}

if ($pageNo < count($config[$selRole][$selAction]['pages']) - 1)
{
	$action = "./index.php";
	$nextPage = $pageNo + 1;
	$extraHTML = '<input type="hidden" name="info[nextPage]" value="' . $nextPage . '">';
}
else
{
	if ($pageNo < count($config[$selRole][$selAction]['pages']))
	{
		$action = "./index.php";
		$extraHTML = '<input type="hidden" name="info[nextPage]" value="-1">';
	}
	else
	{
		$action = "../submit/index.php";
	}
}

echo '<!DOCTYPE html><html><head><link rel="stylesheet" type="text/css" href="../../css/main.css"><script type="text/javascript" src="../../javaScript/author_submit.php"></script></head><body onload="checkWordCount()"><form action="' . $action . '" method="post" enctype="multipart/form-data"><input type="hidden" name="info[token]" value="' . $token . '">' . $extraHTML . '<h1>' . $config[$selRole][$selAction]['title'] . '</h1><h2>' . $config[$selRole][$selAction]['pages'][$pageNo]['name'] . "</h2>";

for ($j=0; $j < count($config[$selRole][$selAction]['pages'][$pageNo]['elements']); $j++) // repeet for each element
{

	$element = $config[$selRole][$selAction]['pages'][$pageNo]['elements'][$j];

	if ($element['type'] == "radio") // code for radio button
	{
		echo '<h4>' . $element['title'] . '</h4>';
		for ($k=0; $k < count($element['options']); $k++)
		{
			echo '<input type="radio" name="user[' . $element['name'] . ']';
			echo '" value="' . $element['options'][$k]['value'];
			echo '"> ' . $element['options'][$k]['name'] . "<br>";
		}
	}


	elseif ($element['type'] == "plainHTML") // code for plain HTML
	{
		echo $element['value'];
	}


	elseif ($element['type'] == "hidden") // code for hidden element
	{
		$keys = array_keys($element);
		echo '<input ';
		foreach ($element as $key => $value)
		{
			if ($key == 'name')
			{
				echo 'name="user[' . $value . ']" ';
			}
			else
			{
				echo $key . '="' . $value . '" ';
			}
		}
		echo ">";
	}

	elseif ($element['type'] == "file") // code for file
	{
		echo '<h4>' . $element['title'] . '</h4>';
		echo '<input ';
		foreach ($element as $key => $value)
		{
			echo $key . '="' . $value . '" ';
		}
		echo "> <br>";
	}


	else // code for everything else
	{
		echo '<h4>' . $element['title'] . '</h4>';
		echo '<input ';
		foreach ($element as $key => $value)
		{
			if ($key == 'name')
			{
				echo 'name="user[' . $value . ']" ';
			}
			else
			{
				echo $key . '="' . $value . '" ';
			}
		}
		echo "> <br>";
	}
}
echo '<input type="hidden" name="info[nextRole]" value="' . $selRole . '"><input type="hidden" name="info[nextAct]" value="' . $selAction . '"></form></body></html>'
?>