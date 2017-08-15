<?php
function createHash($given_password)
{
	return password_hash($given_password, PASSWORD_DEFAULT, ['cost' => 12]);
}

function verifyPassword($given_password, $hash)
{
	return password_verify($given_password, $hash);
}
?>