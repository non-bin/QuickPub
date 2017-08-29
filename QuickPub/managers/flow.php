<?php
function addFlow($name, $owner_id, $role) // create a flow
{
	global $dbc;

	$query = "INSERT INTO flows (name, owner_id, created_by_role) VALUES (?, ?, ?);"; // create the flow
	$stmt  = mysqli_prepare($dbc, $query);
	mysqli_stmt_bind_param($stmt, "sis", $name, $owner_id, $role);
	mysqli_stmt_execute($stmt);
	$affected_rows = mysqli_stmt_affected_rows($stmt);

	if ($affected_rows == 1) // if it was created successfully
	{
		$lastId = mysqli_insert_id($dbc); // save the flow id
		$query  = "SELECT * FROM flows where flow_id = ?;";
		$stmt   = mysqli_prepare($dbc, $query);
		mysqli_stmt_bind_param($stmt, "s", $lastId);
		mysqli_stmt_execute($stmt); // save the flow info
		$result = mysqli_stmt_get_result($stmt);
		$result = mysqli_fetch_assoc($result);

		return $result; // then return it
	}
	else // if not
	{
		addLogEntry('affected rows was 0 on flow creation', 'error', '0005~0'); // throw an error
		return false; // return false
	}
}

function addFlowEntry($flow_id, $content, $owner_id, $created_by_role) // add an entry to a flow
{
	global $dbc;

	if (isset($content['file'])) // if a file was submitted
	{
		$content['type'] = 'file'; // set the content type to file
	}
	else // if not
	{
		$content['type'] = 'text'; // set the content type to text
	}

	$contentJSON = json_encode($content); // encode the entry content to json

	$query = "INSERT INTO flow_entrys (flow_id, content, owner_id, created_by_role) VALUES (?, ?, ?, ?);"; // add the entry
	$stmt  = mysqli_prepare($dbc, $query);
	mysqli_stmt_bind_param($stmt, "isis", $flow_id, $contentJSON, $owner_id, $created_by_role);
	mysqli_stmt_execute($stmt);
	$affected_rows = mysqli_stmt_affected_rows($stmt);

	dump($affected_rows);
	echo "-------------------------<br>";

	if ($affected_rows == 1) // if it worked
	{
		$lastId = mysqli_insert_id($dbc); // save the flow entry id
		$query  = "SELECT * FROM flow_entrys where entry_id = ?;";
		$stmt   = mysqli_prepare($dbc, $query);
		mysqli_stmt_bind_param($stmt, "i", $lastId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$entry  = mysqli_fetch_assoc($result); // save the entry info

		$flow = viewFlow($flow_id); // save the full flow info

		if (isset($content['file'])) // if there's a file
		{
			$dir = realpath('../../flows/') . '\\' . sprintf("%04d", $flow['flow_id']); // add preceding 0s to the flow id, then add it to the flows path

			if (!file_exists($dir)) // if the folder doesn't exist
			{
				mkdir($dir); // make it
			}

			$target_file = $dir . '/' . $lastId . '.' . pathinfo($content['file']["name"])['extension']; // add the flow entry id to the flow path

			if (move_uploaded_file($content['file']["tmp_name"], $target_file)) // if moving the file to the flow entry folder worked
			{
				return $entry; // return the flow entry info
			}
			else // if not
			{
				addLogEntry('error with moving file for flow entry creation', 'error', '0005~1'); // throw an error
				return false; // return false
			}
		}
		else // if there is no file
		{
			return $entry; // return the flow entry info
		}
	}
	else // if the entry creation failed
	{
		addLogEntry('affected rows was 0 on flow entry creation', 'error', '0005~0'); // throw an error
		return false; // return false
	}
}

function viewFlow($id) // view the info for a flow
{
	global $dbc;

	$query = "SELECT * FROM flows where flow_id = ?;";
	$stmt  = mysqli_prepare($dbc, $query);
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);
	$out = mysqli_stmt_get_result($stmt); // get the flow info
	$out = mysqli_fetch_assoc($out);

	return $out; // return it
}

function viewFlowEntrys($id) // view the info for a flow entry
{
	global $dbc;

	$count = 0;

	$query = "SELECT * FROM flow_entrys where flow_id = ?;";
	$stmt  = mysqli_prepare($dbc, $query);
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt); // get the flow entry info
	$result = mysqli_fetch_assoc($result);

	while ($row = $result) // don't know what this is
	{
		$count       = $count + 1;
		$out[$count] = $row;
	}

	return $out; // return it
}

function viewFlowBy($owner) // view a flow by an array of identifiers
{
	global $dbc;

	$query = "SELECT * FROM flow_entrys WHERE `flow_id` = 17 AND entry_id = 32;";
	$stmt  = mysqli_prepare($dbc, $query);
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt); // get the flow entry info
	$result = mysqli_fetch_assoc($result);
}
?>
