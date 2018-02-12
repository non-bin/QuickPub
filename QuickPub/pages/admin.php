<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // if a request was made with post
	switch ($command) {
		case 'compileConfig':
			$conf->compile(); // doesn't work yet
			break;

		default:
			# code...
			break;
	}
}

?>
