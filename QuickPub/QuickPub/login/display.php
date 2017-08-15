<?php

require_once('../../mysql_connect.php');

$query = 'SELECT first_name, middle_name, last_name, primary_email, secondary_email, prefix, date_added, user_id FROM users';

$responce = @mysqli_query($dbc, $query);

if ($responce)
{
	echo '<table align="left" cellspace="5" cellpaddign="8">

	<tr>
	<td align="left"><b>First Name</b></td>
	<td align="left"><b>Middle Name</b></td>
	<td align="left"><b>Last Name</b></td>
	<td align="left"><b>Primary Email</b></td>
	<td align="left"><b>Secondary Email</b></td>
	<td align="left"><b>Prefix</b></td>
	<td align="left"><b>Date Added</b></td>
	<td align="left"><b>User ID</b></td>
	</tr>';

	while($row = mysqli_fetch_array($responce))
	{
		echo '<tr>
		<td align="left">' . $row['first_name'] . '</td>
		<td align="left">' . $row['middle_name'] . '</td>
		<td align="left">' . $row['last_name'] . '</td>
		<td align="left">' . $row['primary_email'] . '</td>
		<td align="left">' . $row['secondary_email'] . '</td>
		<td align="left">' . $row['prefix'] . '</td>
		<td align="left">' . $row['date_added'] . '</td>
		<td align="left">' . $row['user_id'] . '</td></tr>';
	}
	echo '</table>';
}
else
{
	echo 'Error while isueing database query:' . mysqli_error($dbc);
}

mysqli_close($dbc);

?>