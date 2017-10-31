<?php
require_once 'mysql.php';
require_once 'log.php';

function saveForm($name, $ownerID, $ownerRole) // saves a form to be reopened later
{
	global $dbc;

	$query = "INSERT INTO unsubmited_forms (name, owner_id, created_by_role) VALUES (?, ?, ?);";
	$stmt  = mysqli_prepare($dbc, $query);
	mysqli_stmt_bind_param($stmt, "sis", $name, $ownerID, $ownerRole);
	mysqli_stmt_execute($stmt);
	$affectedRows = mysqli_stmt_affected_rows($stmt);

	if ($affectedRows == 1) // if it worked
	{
		$lastId = mysqli_insert_id($dbc);
		$query  = "SELECT * FROM unsubmited_forms where form_id = ?;";
		$stmt   = mysqli_prepare($dbc, $query);
		mysqli_stmt_bind_param($stmt, "s", $lastId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$result = mysqli_fetch_assoc($result);

		return $result; // return the saved form
	}
	else // if not
	{
		addLogEntry('Unable to save form', 'error', '0006~0'); // throw an error
		return false; // return false
	}
}

function saveFormEntry($formID, $content)
{
	global $dbc;

	if (isset($content['file']))
	{
		$content['type'] = 'file';
	}
	else
	{
		$content['type'] = 'text';
	}

	$contentJSON = json_encode($content);

	$query = "INSERT INTO form_entrys (form_id, content) VALUES (?, ?);";
	$stmt  = mysqli_prepare($dbc, $query);
	mysqli_stmt_bind_param($stmt, "is", $formID, $contentJSON);
	mysqli_stmt_execute($stmt);
	$affectedRows = mysqli_stmt_affected_rows($stmt);

	if ($affectedRows == 1)
	{
		$lastId = mysqli_insert_id($dbc);
		$query  = "SELECT * FROM form_entrys where entry_id = ?;";
		$stmt   = mysqli_prepare($dbc, $query);
		mysqli_stmt_bind_param($stmt, "i", $lastId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$entry  = mysqli_fetch_assoc($result);

		$flow = viewForm($formID);

		if (isset($content['file']))
		{
			$dir = __dir__ . '/forms/' . sprintf("%04d", $form['formID']);

			if (!file_exists($dir))
			{
				mkdir($dir);
			}

			$targetFile = $dir . '/' . $lastId;
			if (move_uploaded_file($content['file']["tmp_name"], $targetFile))
			{
				return $entry;
			}
			else
			{
				addLogEntry('error with moving file for form entry creation', 'error', '0006~1');
				return false;
			}
		}
		else
		{
			return $entry;
		}
	}
	else
	{
		addLogEntry('affected rows was 0 on form entry creation', 'error', '0006~0');
		return false;
	}
}

function viewFormEntrys($id)
{
	global $dbc;

	$count = 0;

	$query = "SELECT * FROM form_entrys where form_id = ?;";
	$stmt  = mysqli_prepare($dbc, $query);
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	while ($row = mysqli_fetch_assoc($result))
	{
		$count       = $count + 1;
		$out[$count] = $row;
	}

	return $out;
}

function viewForm($id)
{
	global $dbc;

	$query = "SELECT * FROM unsubmited_forms where form_id = ?;";
	$stmt  = mysqli_prepare($dbc, $query);
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);
	$out = mysqli_stmt_get_result($stmt);
	$out = mysqli_fetch_assoc($out);

	return $out;
}

function removeForm($id)
{
	# code...
}
?>
