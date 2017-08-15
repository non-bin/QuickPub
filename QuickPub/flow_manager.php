<?php
function addFlow($name, $owner_id, $role)
{
	global $dbc;

	$query = "INSERT INTO flows (name, owner_id, created_by_role) VALUES (?, ?, ?);";
	$stmt = mysqli_prepare($dbc, $query);
	mysqli_stmt_bind_param($stmt, "sis", $name, $owner_id, $role);
	mysqli_stmt_execute($stmt);
	$affected_rows = mysqli_stmt_affected_rows($stmt);

	if ($affected_rows == 1)
	{
		$lastId = mysqli_insert_id($dbc);
		$query = "SELECT * FROM flows where flow_id = ?;";
		$stmt = mysqli_prepare($dbc, $query);
		mysqli_stmt_bind_param($stmt, "s", $lastId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$result = mysqli_fetch_assoc($result);

		return $result;
	}
	else
	{
		addLogEntry('affected rows was 0 on flow creation', 'error', '0005~0');
		return false;
	}
}

function addFlowEntry($flow_id, $content, $owner_id, $created_by_role)
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

	$query = "INSERT INTO flow_entrys (flow_id, content, owner_id, created_by_role) VALUES (?, ?, ?, ?);";
	$stmt = mysqli_prepare($dbc, $query);
	mysqli_stmt_bind_param($stmt, "isis", $flow_id, $contentJSON, $owner_id, $created_by_role);
	mysqli_stmt_execute($stmt);
	$affected_rows = mysqli_stmt_affected_rows($stmt);

	if ($affected_rows == 1)
	{
		$lastId = mysqli_insert_id($dbc);
		$query = "SELECT * FROM flow_entrys where entry_id = ?;";
		$stmt = mysqli_prepare($dbc, $query);
		mysqli_stmt_bind_param($stmt, "i", $lastId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$entry = mysqli_fetch_assoc($result);

		$flow = viewFlow($flow_id);

		if (isset($content['file']))
		{
			$dir = __dir__ . '/flows/' . sprintf("%04d", $flow['flow_id']);

			if (!file_exists($dir))
			{
				mkdir($dir);
			}

			$target_file = $dir . '/' . $lastId;
			if (move_uploaded_file($content['file']["tmp_name"], $target_file))
			{
				return $entry;
			}
			else
			{
				addLogEntry('error with moving file for flow entry creation', 'error', '0005~1');
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
		addLogEntry('affected rows was 0 on flow entry creation', 'error', '0005~0');
		return false;
	}
}

function viewFlow($id)
{
	global $dbc;

	$query = "SELECT * FROM flows where flow_id = ?;";
	$stmt = mysqli_prepare($dbc, $query);
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);
	$out = mysqli_stmt_get_result($stmt);
	$out = mysqli_fetch_assoc($out);

	return $out;
}

function viewFlowEntrys($id)
{
	global $dbc;

	$count = 0;

	$query = "SELECT * FROM flow_entrys where flow_id = ?;";
	$stmt = mysqli_prepare($dbc, $query);
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	while($row = mysqli_fetch_assoc($result))
	{
		$count = $count + 1;
		$out[$count] = $row;
	}

	return $out;
}
?>