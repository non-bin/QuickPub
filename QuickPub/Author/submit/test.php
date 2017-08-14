<!DOCTYPE html>
<html>
<head>
</head>
<body>

</body>
</html>

<?php
$myfile = fopen("config.json", "r") or die("Unable to open file!");
$json = fread($myfile,filesize("config.json"));

$result = json_decode($json, true) or die('nope');
var_dump($json);
echo "<br><br>";
var_dump($result);
echo "<br><br>";
echo $result['pages'][0]['inputs'][3]['type'];
fclose($myfile);
?>