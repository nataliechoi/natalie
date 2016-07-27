<?php

require_once '../index.php';

$user = isset($_SESSION['user']) ? $_SESSION['user'] : NULL;

if ( !is_null($user) && !empty($user) ) {
	exit(json_encode(array(
		'status'	 => 1,
		'message'	 => 'User',
		'data'		 => $user
	)));
}

exit(json_encode(array(
	'status'	 => 0,
	'message'	 => 'Guest'
)));
