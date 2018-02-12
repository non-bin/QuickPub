<?php

class mainConfig
{
    public $value;

    public function __construct()
    {
		if (!$value = require ("../config/config.php"))
		{
			throwError("problem with config retrieval");
        }
    }
}

?>
