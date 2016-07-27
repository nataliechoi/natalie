<?php

require_once '../index.php';

unset($_SESSION['user']);

exit(json_encode(array(
	'status'	 => 1,
	'message'	 => 'Success', 
	'data'		 => NULL
)));
